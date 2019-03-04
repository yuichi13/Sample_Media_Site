<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\User;
use Auth;
use Log;

class PostController extends Controller
{
    public function getIndex()
    {
        $posts = Post::paginate(5);
        return view('home')->with('posts', $posts);
    }

    public function getPostDetail($post_id)
    {
        $post = Post::find($post_id);
        return view('post_detail')->with('post', $post);
    }

    public function getPostEdit($post_id)
    {
        $post = Post::find($post_id);
        return view('user.post_article')->with('post', $post);
    }

    public function postPostEdit(Request $request, $post_id)
    {
        $this->validate($request, [
            'title' => 'required',
            'content' => 'required',
            'pic' => 'image'
        ], [
            'title.required' => ':attributeは必須です。',
            'content.required' => ':attributeは必須です。',
            'pic' => '画像形式ではありません。'
        ], [
            'title' => 'タイトル',
            'content' => '本文'
        ]);

        // ファイル情報を一時的に格納
        if(($request->file('pic')) !== NULL){
            if($request->file('pic') !== Post::find($post_id)->pic){
                $pic_name = uniqid('PIC_') . "." . $request->file('pic')->guessExtension();
        $request->file('pic')->move(storage_path('/app/public/uploads/pic/'), $pic_name);
        $pic = '/storage/uploads/pic/' . $pic_name;
        
            } else{
                $pic = Post::find($post_id)->pic;
                
            }
        
        } elseif(Post::find($post_id)->pic){
            $pic = Post::find($post_id)->pic;
            
        } else{
            $pic = '';
        }

        $post = Post::find($post_id);
        $post->fill([
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'pic' => $pic
        ]);
        $post->save();
        return redirect()->route('user.mypage');
    }

    public function getPostDelete($post_id)
    {
        $post = Post::find($post_id);
        $post->delete();
        // マイページへリダイレクト
        return redirect()->route('user.mypage');
    }

    public function getPostArticle()
    {
        return view('user.post_article');
    }

    public function postPostArticle(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|max:100',
            'content' => 'required|max:500',
            'pic' => 'image'
        ], [
            'title.required' => ':attributeは必須です',
            'title.max' => ':attributeは:max文字以内でご入力ください',
            'content.required' => ':attributeは必須です',
            'content.max' => ':attributeは:max文字以内でご入力ください',
            'pic' => '画像形式ではありません'
        ], [
            'title' => 'タイトル',
            'content' => '本文'
        ]);

        // ファイル情報を一時的に格納
        if($request->file('pic')){
        $pic_name = uniqid('PIC_') . "." . $request->file('pic')->guessExtension();
        $request->file('pic')->move(storage_path('app/public/uploads/pic/'), $pic_name);
        $pic = '/storage/uploads/pic/' . $pic_name;
        } else{
            $pic = '';
        }
        
        // DBインサート
        $post = new Post([
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'user_id' => Auth::id(),
            'pic' => $pic
        ]);
        // 保存
        $post->save();
        // リダイレクト
        return redirect()->route('user.mypage');

    }

}
