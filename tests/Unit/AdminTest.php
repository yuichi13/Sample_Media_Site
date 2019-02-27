<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;
use App\Post;
use App\Admin;
use Hash;
use Auth;
use Log;
use \Illuminate\Foundation\Testing\DatabaseTransactions;

class AdminTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * A basic test example.
     *
     * @return void
     */
    
    // 管理者用ログインページのルートチェック
    public function testGetAdminLogin()
    {
        $this->get('admin/login')
        ->assertStatus(200);
    }

    // 管理者用ログインページの正常チェック
    public function testPostAdminLogin()
    {
        // ダミー管理者データを生成
        $admin = factory(Admin::class)->create();

        // 正常データでログイン
        $this->post('admin/login', [
            'email' => $admin->email,
            'pass' => 'secret'
        ])->assertRedirect('admin/user-list'); // ユーザーリストにリダイレクトされているかをチェック

        // ログインされているかをチェック
        $this->get('admin/login')
        ->assertRedirect('admin/user-list');
    }

    // 管理者用ログインページの異常チェック
    public function testPostAdminLoginFailed()
    {
        // ダミー管理者データを生成
        $admin = factory(Admin::class)->create();

        // 異常データをポスト
        $this->post('admin/login', [
            'email' => $admin->email,
            'pass' => 'badpass'
        ]);

        // ログインされていないことをチェック
        $this->get('admin/login')
        ->assertStatus(200);
    }

    // 管理者用ページのログアウトチェック
    public function testGetLogout()
    {
        // ダミー管理者データを生成してログイン
        $admin = factory(Admin::class)->create();
        $this->actingAs($admin, 'admin');

        // ログアウト処理を実行
        $this->get('admin/logout')
        ->assertRedirect('admin/login'); // ログイン画面にリダイレクトすることをチェック

        // ログインされていないことをチェック
        $this->get('admin/login')
        ->assertStatus(200);
    }

    // 管理者用ページのユーザーリストのルートチェック
    public function testGetUserList()
    {
        // ダミー管理者データを生成してログイン
        $admin = factory(Admin::class)->create();
        $this->actingAs($admin, 'admin');

        $this->get('admin/user-list')
        ->assertStatus(200);
    }

    // 管理者用ページのアクセス禁止チェック
    public function testGetBan()
    {
        // ダミー管理者データを生成してログイン
        $admin = factory(Admin::class)->create();
        $this->actingAs($admin, 'admin');

        // ダミーユーザーデータを生成
        $user = factory(User::class)->create();
        
        // アクセス禁止処理を実行
        $this->get('admin/ban/' . $user->id);

        // ユーザーのロールがアクセス禁止になっていることをチェック
        $this->assertDatabaseHas('users', [
            'role' => 1
        ]);
    }

    // 管理者用ページのアクセス禁止解除チェック
    public function testUnlock()
    {
        // ダミー管理者データを生成してログイン
        $admin = factory(Admin::class)->create();
        $this->actingAs($admin, 'admin');

        // アクセス禁止されている状態のダミーユーザーデータを生成
        $user = factory(User::class)->create([
            'role' => 1
        ]);

        // アクセス禁止解除処理を実行
        $this->get('admin/unlock/' . $user->id);

        // アクセス禁止処理が解除されていることをチェック
        $this->assertDatabaseMissing('users', [
            'role' => 1
        ]);
    }

    // 管理者用ページの記事一覧ルートチェック
    public function testGetPostlist()
    {
        // ダミー管理者データを生成してログイン
        $admin = factory(Admin::class)->create();
        $this->actingAs($admin, 'admin');

        $this->get('admin/post-list')
        ->assertStatus(200);
    }

    // 管理者用記事詳細ページルートチェック
    public function testGetPostDetail()
    {
        // ダミー管理者データを生成してログイン
        $admin = factory(Admin::class)->create();
        $this->actingAs($admin, 'admin');

        // ダミー記事データを生成
        $post = factory(Post::class)->create();
        
        $this->get('admin/post-detail/' . $post->id)
        ->assertStatus(200);
    }

    // 管理者用記事詳細ページ削除チェック
    public function testGetPostDelete()
    {
        // ダミー管理者データを生成してログイン
        $admin = factory(Admin::class)->create();
        $this->actingAs($admin, 'admin');

        // ダミー記事データを生成
        $post = factory(Post::class)->create();
        
        // 記事データ削除処理を実行
        $this->get('admin/post-delete/' . $post->id);

        // 記事データが論理削除されていることをチェック
        $this->assertSoftDeleted('posts', [
            'title' => $post->title
        ]);
    }
}
