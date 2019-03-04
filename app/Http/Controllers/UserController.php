<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Post;
use Auth;
use Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendToAdmin;
use App\Mail\Notification;

class UserController extends Controller
{
    // 新規登録画面を返す
    public function getSignup()
    {
        return view('auth.signup');
    }

    // 新規登録画面がポスト送信された時の処理
    public function postSignup(Request $request)
    {
        // バリデーション
        $this->validate($request, [
            'email' => 'required|email|unique:users',
            'pass' => 'required|min:4|confirmed',
            'pass_confirmation' => 'required'
        ], [
            'email.required' => ':attributeは必須です。',
            'email.email' => 'Emailの形式でご入力ください。',
            'email.unique' => 'このメールアドレスは既に使われています。',
            'pass.required' => ':attributeは必須です。',
            'pass.min' => ':attributeは:min文字以上でご入力ください。',
            'pass.confirmed' => ':attributeが再入力と合っていません',
            'pass_confirmation.required' => ':attributeは必須です。'
        ], [
            'email' => 'メールアドレス',
            'pass' => 'パスワード',
            'pass_confirmation' => 'パスワード（再入力）'
        ]);
        // DBインサート
        $user = new User([
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('pass'))
        ]);
        // 保存
        $user->save();
        Auth::guard('user')->login($user);
        // リダイレクト
        return redirect()->route('user.mypage');
    }

    // 退会処理画面を返す
    public function getWithDraw()
    {
        return view('user.with_draw');
    }

    // 退会画面処理
    public function postWithDraw()
    {
        // トランザクション処理
        // 退会時にユーザー情報と記事情報を同時に削除、どちらかが失敗した場合はロールバックする
        \DB::transaction(function(){

        $user = User::find(Auth::id());
        $posts = \App\Post::where('user_id', Auth::id());
        
        $user->delete();
        $posts->delete();
        Auth::logout();
        });

        // 新規登録画面にリダイレクト
        return redirect()->route('user.signup');
    }
    
    // ユーザーログイン画面を返す
    public function getLogin()
    {
        return view('auth.login');
    }

    // ログイン画面でポスト送信された場合の処理
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
        
        // ログイン保持にチェックがあればtrueを格納
        if($request->input('remember')){
            $remember = true;
        } else{
            $remember = false;
        }

        // 入力されたメールアドレスとパスワードがDBのデータと一致していればログイン
        // ログイン保持にチェックがあればログイン保持処理が行われる
        if(Auth::attempt(['email' => $request->input('email'), 'password' => $request->input('pass')], $remember)){
            return redirect('user\mypage');
        } else{
            // 一致しなければ前の画面へリダイレクト
            return redirect()->back();
        }
    }

    // ユーザーログアウト処理
    public function getLogout()
    {
        Auth::logout();
        // ユーザーログイン画面へリダイレクト
        return redirect()->route('user.login');
    }

    // ユーザーマイページ画面を返す
    public function getMypage()
    {
        $user_id = Auth::id();
        $posts = Post::where('user_id', $user_id)->paginate(5);
        $user = User::find($user_id);
        
        return view('user.mypage')->with('dbUserData', $user)->with('dbPostData', $posts);
    }

    // プロフィール編集画面を返す
    public function getProfEdit()
    {
        $user_id = Auth::id();
        $dbUserData = User::find($user_id);

        return view('user.prof_edit')->with('dbUserData', $dbUserData);
    }

    // プロフィール編集画面がポスト送信された時の処理
    public function postProfEdit(Request $request)
    {
        $this->validate($request, [
            'name' => 'max:10',
            'email' => 'required|email',
            'profile' => 'max:100',
            'avatar' => 'image'
        ], [
            'name.max' => ':attributeは:max文字以内でご入力ください',
            'email.required' => ':attributeは必須です',
            'profile.max' => ':attributeは:max文字以内でご入力ください',
            'avatar.image' => '画像形式ではありません'
        ], [
            'name' => 'ユーザーネーム',
            'email' => 'メールアドレス',
            'profile' => 'プロフィール'
        ]);

        if($request->file('avatar') !== NULL){
            if($request->file('avatar') !== User::find(Auth::id())->avatar){

                $avatarname = uniqid('AVATAR_') . '.' . $request->file('avatar')->guessExtension();
                $request->file('avatar')->move(storage_path('app/public/uploads/avatar/'), $avatarname);
                $avatar = '/storage/uploads/avatar/' . $avatarname;

            } else{
                $avatar = User::find(Auth::id())->avatar;
            }
        } elseif(User::find(Auth::id())->avatar){
            $avatar = User::find(Auth::id())->avatar;
        } else{
            $avatar = '';
        }

        // DBインサート
        $user = User::find(Auth::id());
        $user->avatar = $avatar;
        $user->save();
        $user->fill($request->all())->save();
        
        // リダイレクト
        return redirect()->route('user.mypage');
    }

    public function getPassEdit()
    {
        $user = User::find(Auth::id());
        return view('user.pass_edit')->with('dbUserData', $user);
    }

    public function postPassEdit(Request $request)
    {
        $this->validate($request, [
            'pass_old' => 'required',
            'pass_new' => 'required|confirmed',
            'pass_new_confirmation' => 'required'
        ], [
            'pass_old.required' => ':attributeは必須です',
            'pass_new.required' => ':attributeは必須です',
            'pass_new_confirmation.required' => ':attributeは必須です',
            'pass_new.confirmed' => ':attributeがパスワード（再入力）と違います。'
        ], [
            'pass_old' => '古いパスワード',
            'pass_new' => '新しいパスワード',
            'pass_new_confirmation' => '新しいパスワード（再入力）'
        ]);
        $user = User::find(Auth::id());
        // 古いパスワードがDBにあるかチェック
        if(Hash::check($request->input('pass_old'), $user->password)){
            
            $user->password = Hash::make($request->input('pass_new'));
            $user->save();
           
            // リダイレクト
            return redirect()->route('user.mypage')->with('message', 'パスワードを変更しました');

        } else{
            return redirect()->back()->with('errormsg', 'パスワードが違います ');
        }
    }

    public function getContact()
    {
        return view('user.contact');
    }

    public function postContact(Request $request)
    {
        $this->validate($request, [
            'subject' => 'required',
            'content' => 'required'
        ], [
            'subject.required' => ':attributeは必須です',
            'content.required' => ':attributeは必須です'
        ], [
            'subject' => '件名',
            'content' => '本文'
        ]);

        // データを変数に格納
        $data = [
            'subject' => $request->input('subject'),
            'email' => User::find(Auth::id())->email,
            'content' => $request->input('content')
        ];

        $u_name = User::find(Auth::id())->name;


        Mail::to('example100@gmail.com')->send(new SendToAdmin($data['subject'], $data['content']));

        Mail::to($data['email'])->send(new Notification($u_name, $data));
        
        
        return redirect()->route('user.mypage')->with('message', 'メールを送信しました');
    }
}
