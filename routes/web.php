<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::group(['middleware' => 'auth'], function(){

    Route::group(['prefix' => 'user'], function(){

        Route::group(['middleware' => ['auth', 'can:user-only']], function(){


        Route::get('mypage', [
            'uses' => 'UserController@getMypage',
            'as' => 'user.mypage'
        ]);

        Route::get('post-edit/{post_id}', [
            'uses' => 'PostController@getPostEdit',
            'as' => 'user.post_edit'
        ]);
        Route::post('post-edit/{post_id}', 'PostController@postPostEdit');

        Route::get('post-delete/{post_id}', [
            'uses' => 'PostController@getPostDelete',
            'as' => 'user.post_delete'
        ]);

        Route::get('post-article', [
            'uses' => 'PostController@getPostArticle',
            'as' => 'user.post_article'
        ]);
        Route::post('post-article', 'PostController@postPostArticle');

        Route::get('prof-edit', [
            'uses' => 'UserController@getProfEdit',
            'as' => 'user.prof_edit'
        ]);
        Route::post('prof-edit', [
            'uses' => 'UserController@postProfEdit',
        ]);
        Route::get('pass-edit', [
            'uses' => 'UserController@getPassEdit',
            'as' => 'user.pass_edit'
        ]);
        Route::post('pass-edit', 'UserController@postPassEdit');

        

        Route::get('with-draw', [
            'uses' => 'UserController@getWithDraw',
            'as' => 'user.with_draw'
        ]);
        Route::post('with-draw', 'UserController@postWithDraw');

        Route::get('contact', [
            'uses' => 'UserController@getContact',
            'as' => 'user.contact'
        ]);
        Route::post('contact', 'UserController@postContact');

    });
    Route::get('logout', [
            'uses' =>'UserController@getLogout',
            'as' => 'user.logout'
    ]);
});

});

Route::group(['prefix' => 'admin'], function(){

    Route::group(['middleware' => 'guest:admin'], function(){

        Route::get('login', [
            'uses' => 'AdminController@getLogin',
            'as' => 'admin.login'
        ]);
        Route::post('login', 'AdminController@postLogin');
    });

    Route::group(['middleware' => 'auth:admin'], function(){
        
        Route::get('logout', [
            'uses' => 'AdminController@getLogout',
            'as' => 'admin.logout'
        ]);

        Route::get('mypage', [
            'uses' => 'AdminController@getMypage',
            'as' => 'admin.mypage'
        ]);

        Route::get('user-list', [
            'uses' => 'AdminController@getUserList',
            'as' => 'admin.user_list'
        ]);

        Route::get('ban/{user_id}', [
            'uses' => 'AdminController@getBan',
            'as' => 'admin.ban'
        ]);

        Route::get('unlock/{user_id}', [
            'uses' => 'AdminController@getUnlock',
            'as' => 'admin.unlock'
        ]);

        Route::get('post-list', [
            'uses' => 'AdminController@getPostList',
            'as' => 'admin.post_list'
        ]);

        Route::get('post-detail/{post_id}', [
            'uses' => 'AdminController@getPostDetail',
            'as' => 'admin.post_detail'
        ]);

        Route::get('post-delete/{post_id}', [
            'uses' => 'AdminController@getPostDelete',
            'as' => 'admin.post_delete'
        ]);

    });
});

Route::group(['prefix' => 'user'], function(){

    Route::group(['middleware' => 'guest'], function(){

        Route::get('signup', [
            'uses' => 'UserController@getSignup',
            'as' => 'user.signup'
            ]);
        Route::post('signup', 'UserController@postSignup');
        
        Route::get('login', [
            'uses' => 'UserController@getLogin',
            'as' => 'user.login'
            ]);
        Route::post('login', 'UserController@postLogin');
    
    });
});

Route::get('password/reset', [
    'uses' => 'Auth\ForgotPasswordController@showLinkRequestForm',
    'as' => 'password.request'
    ]);
Route::post('password/email', [
    'uses' => 'Auth\ForgotPasswordController@sendResetLinkEmail',
    'as' => 'password.email'
    ]);

Route::get('password/{token}', [ 
    'uses' => 'Auth\ResetPasswordController@showResetForm',
    'as' => 'password.reset'
    ]);
Route::post('password/reset', 'Auth\ResetPasswordController@reset');



Route::get('/', [
    'uses' => 'PostController@getIndex',
    'as' => 'home'
]);
Route::get('post-detail/{post_id}', 'PostController@getPostDetail');





