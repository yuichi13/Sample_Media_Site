<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;
use App\Post;
use Hash;
use Auth;
use Log;
use \Illuminate\Foundation\Testing\DatabaseTransactions;

class PostTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * A basic test example.
     *
     * @return void
     */

    // 記事一覧ページルートチェック
    public function testGetIndex()
    {
        $this->get('/')
        ->assertStatus(200);
    }

    // 記事詳細ページルートチェック
    public function testGetPostDetail()
    {
        // ダミー記事データを生成
        $post = factory(Post::class)->create();
        $this->get('post-detail/' . $post->id)
        ->assertStatus(200);

        // 生成した記事データが表示されているかチェック
        $this->get('post-detail/' . $post->id)
        ->assertSee($post->title);
    }

    // 記事編集ページルートチェック
    public function testGetPostEdit()
    {
        // ダミーユーザーデータを生成してログイン
        $user = factory(User::class)->create();
        $this->actingAs($user);

        // ダミー記事データを生成
        $post = factory(Post::class)->create();
        
        $this->get('user/post-edit/' . $post->id)
        ->assertStatus(200);
    }

    // 新規記事投稿ページルートチェック
    public function testGetPostArticle()
    {
        // ダミーユーザーデータを生成してログイン
        $user = factory(User::class)->create();
        $this->actingAs($user);

        $this->get('user/post-article')
        ->assertStatus(200);
    }

    // 新規記事投稿ページ正常チェック
    public function testPostPostArticle()
    {
        // ダミーユーザーデータを生成してログイン
        $user = factory(User::class)->create();
        $this->actingAs($user);

        // 正常記事データをポスト
        $this->post('user/post-article', [
            'title' => 'サンプルタイトル',
            'content' => 'サンプルコンテント'
        ]);

        // データベースが更新されていることをチェック
        $this->assertDatabaseHas('posts', [
            'title' => 'サンプルタイトル'
        ]);
    }

    // 新規記事投稿ページ異常チェック
    public function testPostPostArticleFailed()
    {
        // ダミーユーザーデータを生成してログイン
        $user = factory(User::class)->create();
        $this->actingAs($user);

        // 異常データをポスト
        $this->post('post-article', [
            'title' => '',
            'content' => 'サンプルコンテント'
        ]);

        // データベースが更新されていないことをチェック
        $this->assertDatabaseMissing('posts', [
            'content' => 'サンプルコンテント'
        ]);
    }

    // 記事編集ページ正常チェック
    public function testPostPostEdit()
    {
        // ダミーユーザーデータを生成してログイン
        $user = factory(User::class)->create();
        $this->actingAs($user);

        // ダミー記事データを生成
        $post = factory(Post::class)->create();
        
        // 正常データをポスト
        $this->post('user/post-edit/' . $post->id, [
            'title' => 'サンプルタイトル',
            'content' => 'サンプルコンテント'
        ]);

        // データベースが更新されていることをチェック
        $this->assertDatabaseHas('posts', [
            'title' => 'サンプルタイトル'
        ]);
    }

    // 記事編集ページ異常チェック
    public function testPostPostEditFailed()
    {
        // ダミーユーザーデータを生成してログイン
        $user = factory(User::class)->create();
        $this->actingAs($user);

        // ダミー記事データを生成
        $post = factory(Post::class)->create();
        
        // 異常データをポスト
        $this->post('user/post/' . $post->id, [
            'title' => 'サンプルタイトル',
            'content' => ''
        ]);

        // データベースが更新されていないことをチェック
        $this->assertDatabaseMissing('posts', [
            'title' => 'サンプルタイトル'
        ]);
    }

    // 記事削除チェック
    public function testGetPostDelete()
    {
        // ダミーユーザーデータを生成してログイン
        $user = factory(User::class)->create();
        $this->actingAs($user);

        // ダミー記事データを生成
        $post = factory(Post::class)->create();
        
        // 記事削除処理を実行
        $this->get('user/post-delete/' . $post->id);

        // 記事が論理削除されていることをチェック
        $this->assertSoftDeleted('posts', [
            'id' => $post->id
        ]);
    }
}