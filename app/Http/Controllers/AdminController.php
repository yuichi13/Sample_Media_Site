<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;
use App\User;
use App\Post;
use Log;

class AdminController extends Controller
{
    // ログイン後のリダイレクト先
    public function redirectTo()
    {
        return redirect()->route('admin.mypage');
    }

    // ログイン画面のviewの指定
    public function getLogin()
    {
        $title = '管理者用';
        return view('admin.login')->with('title', $title);
    }

    // バリデーションを行う
    public function postLogin(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'pass' => 'required'
        ], [
            'email.required' => ':attributeは必須です',
            'email.email' => ':attributeの形式でご入力ください',
            'pass.required' => ':attributeは必須です'
        ], [
            'email' => 'メールアドレス',
            'pass' => 'パスワード'
        ]);
        Log::debug('バリデーションOKです。');

        // 変数に値を代入
        $data = [
            'email' => $request->input('email'),
            'pass' => $request->input('pass'),
            'remember' => $request->input('remember')
        ];
        Log::debug('$dataの中身：' . print_r($data, true));

        $remember = ($data['remember']) ? true : false;

        // メールアドレスとパスワードがDBにあるか判定
        if(Auth::guard('admin')->attempt(['email' => $data['email'], 'password' => $data['pass']], $remember)){
            // 管理者用マイページへリダイレクト
            return redirect()->route('admin.user_list');
        } else{
            Log::debug('パスワードが違います。');
            
            return redirect()->back()->with('errormsg', 'パスワードが違います');
        }
    }

    public function getLogout()
    {
        Auth::logout();
        return redirect()->route('admin.login');
    }

    public function getUserList()
    {
        $u_list = User::paginate(5);
        return view('admin.user_list')->with('u_list', $u_list);
    }

    public function getBan($user_id)
    {
        Log::debug('$user_id:' . $user_id);
        $user = User::find($user_id);
        $user->role = 1;
        $user->save();
        return redirect()->back()->with('message', 'アクセスを禁止しました');
    }

    public function getUnlock($user_id)
    {
        $user = User::find($user_id);
        $user->role = 0;
        $user->save();
        return redirect()->back()->with('message', 'アクセスを許可しました');
    }

    public function getPostList()
    {
        $posts = Post::paginate(5);
        return view('admin.post_list')->with('posts', $posts);
    }

    public function getPostDetail($post_id)
    {
        $post = Post::find($post_id);
        return view('admin.post_detail')->with('post', $post);
    }

    public function getPostDelete($post_id)
    {
        $post = Post::find($post_id);
        $post->delete();
        return redirect()->route('admin.post_list')->with('message', '記事を削除しました');
    }
}
