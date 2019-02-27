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

class UserTest extends TestCase
{
    use DatabaseTransactions;
    //use RefreshDatabase;
    /**
     * A basic test example.
     *
     * @return void
     */

    // 新規登録画面ルートチェック
    public function testGetSignup()
    {
        $this->get('user/signup')
        ->assertStatus(200);
    }

    // 新規登録画面正常チェック
    public function testPostSignup()
    {
        // ログインしていないことをチェック
        $this->assertFalse(Auth::check());

        // 正常ユーザーデータをポスト
        $this->post('user/signup', [
            'email' => 'example@gmail.com',
            'pass' => 'secret',
            'pass_confirmation' => 'secret'
        ]);

        // ログインされていることをチェック
        $this->assertTrue(Auth::check());

        // データベースが更新されていることをチェック
        $this->assertDatabaseHas('users', [
            'email' => 'example@gmail.com'
        ]);
    }

    // 異常サインイン（メールアドレスが重複）
    public function testPostSignupFailed()
    {
        // ダミーユーザーデータを生成
        factory(User::class)->create([
            'email' => 'example@gmail.com'
        ]);

        // ログインされていないことをチェック
        $this->assertFalse(Auth::check());

        // 異常ユーザーデータをポスト
        $this->post('user/signup', [
            'email' => 'example@gmail.com',
            'pass' => 'secret',
            'pass_confirmation' => 'secret'
        ]);

        // ログインされていないことをチェック
        $this->assertFalse(Auth::check());
    }

    // 退会画面ルートチェック
    public function testGetWithdraw()
    {
        // ダミーユーザーデータを生成してログイン
        $user = factory(User::class)->create();
        $this->actingAs($user);

        $this->get('user/with-draw')
        ->assertStatus(200);
    }

    // 退会処理チェック
    public function testPostWithdraw()
    {
        // ダミーユーザーデータを生成してログイン
        $user = factory(User::class)->create();
        $this->actingAs($user);

        // ダミー記事データを生成
        factory(Post::class)->create([
            'user_id' => $user->id
        ]);
        
        // ログインされていることをチェック
        $this->assertTrue(Auth::check());

        // 退会処理を実行
        $this->post('user/with-draw');

        // ユーザーデータが論理削除されていることをチェック
        $this->assertSoftDeleted('users', [
            'id' => $user->id
        ]);

        // ポストデータが論理削除されていることをチェック
        $this->assertSoftDeleted('posts', [
            'user_id' => $user->id
        ]);

        // ログインされていないことをチェック
        $this->assertFalse(Auth::check());
    }

    // ログインページのルートチェック
    public function testGetLogin()
    {
        $this->get('user/login')
        ->assertStatus(200);
    }

    // ログイン処理正常チェック
    public function testPostLogin()
    {
        // ダミーユーザーデータを生成
        $user = factory(User::class)->create();
        
        // 正常ログイン処理
        $this->post('/user/login', [
            'email' => $user->email,
            'pass' => 'secret'
        ])->assertRedirect('user\mypage'); // マイページへリダイレクトすることをチェック

        // ログインされていることをチェック
        $this->assertTrue(Auth::check());
    }

    // ログイン処理異常チェック
    public function testPostLoginFailed()
    {
        // 存在しないデータをポスト
        $this->post('user/login', [
            'email' => 'bademail@gmail.com',
            'pass' => 'badpass'
        ]);

        // ログインされていないことをチェック
        $this->assertFalse(Auth::check());
    }

    // ログアウト処理チェック
    public function testPostLogout()
    {
        // ダミーユーザーデータを生成してログイン
        $user = factory(User::class)->create();
        $this->actingAs($user);

        // ログインされていることをチェック
        $this->assertTrue(Auth::check());

        // ログアウト処理実行
        $this->get('user/logout');

        // ログインしていないことをチェック
        $this->assertFalse(Auth::check());
    }

    // マイページルートチェック
    public function testGetMypage()
    {
        // ダミーユーザーデータを生成してログイン
        $user = factory(User::class)->create();
        $this->actingAs($user);

        $this->get('user/mypage')
        ->assertStatus(200);
    }

    // プロフィール編集画面ルートチェック
    public function testGetProfedit()
    {
        // ダミーユーザーデータを生成してログイン
        $user = factory(User::class)->create();
        $this->actingAs($user);

        $this->get('user/mypage')
        ->assertStatus(200);
    }

    // プロフィール編集正常チェック
    public function testPostProfedit()
    {
        // ダミーユーザーデータを生成してログイン
        $user = factory(User::class)->create();
        $this->actingAs($user);

        // 正常データをポスト
        $this->post('user/prof-edit', [
            'name' => 'テストネーム',
            'email' => 'test@gmail.com',
            'profile' => 'テストプロフィール'
        ]);

        // データベースが更新されていることをチェック
        $this->assertDatabaseHas('users', [
            'name' => 'テストネーム',
            'email' => 'test@gmail.com',
            'profile' => 'テストプロフィール'
        ]);
    }

    // プロフィール編集異常チェック
    public function testPostProfeditFailed()
    {
        // ダミーユーザーデータを生成してログイン
        $user = factory(User::class)->create();
        $this->actingAs($user);

        // 異常データをポスト
        $this->post('user/prof-edit', [
            'name' => 'テストネーム'
        ]);

        // データベースが更新されていないことをチェック
        $this->assertDatabaseMissing('users', [
            'name' => 'テストネーム'
        ]);
    }

    // パスワード変更ルートチェック
    public function testGetPassedit()
    {
        // ダミーユーザーデータを生成してログイン
        $user = factory(User::class)->create();
        $this->actingAs($user);

        $this->get('user/pass-edit')
        ->assertStatus(200);
    }

    // パスワード変更正常チェック
    public function testPostPassedit()
    {
        // ダミーユーザーデータを生成してログイン
        $user = factory(User::class)->create();
        $this->actingAs($user);

        // 正常データをポスト
        $this->post('user/pass-edit', [
            'pass_old' => 'secret',
            'pass_new' => 'secretnew',
            'pass_new_confirmation' => 'secretnew'
        ]);
        
        // データベースが更新されていることをチェック
        $this->assertTrue(Hash::check('secretnew', $user->fresh()->password));
    }

    // パスワード変更異常チェック
    public function testPostPasseditFailed()
    {
        // ダミーユーザーデータを生成してログイン
        $user = factory(User::class)->create();
        $this->actingAs($user);

        // 異常データをポスト
        $this->post('user/pass-edit', [
            'pass_old' => 'secret',
            'pass_new' => 'secretnew',
            'pass_new_confirmation' => 'badpass'
        ]);

        // データベースが更新されていないことをチェック
        $this->assertTrue(Hash::check('secret', $user->fresh()->password));
    }

    // コンタクトルートチェック
    public function testGetContact()
    {
        // ダミーユーザーデータを生成してログイン
        $user = factory(User::class)->create();
        $this->actingAs($user);

        $this->get('user/contact')
        ->assertStatus(200);
    }
}
