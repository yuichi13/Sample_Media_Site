<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Notifications\JaPasswordReset;


class User extends Authenticatable
{
    use Notifiable;
    use softDeletes;

    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email', 'password', 'remember_token', 'name', 'profile'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function post()
    {
        return $this->hasMany('App\Post');
    }

    public function userName()
    {
        if(empty($this->name)){
            return '名無しさん';
        } else{
            return $this->name;
        }
    }

    public function avatar()
    {
        if(empty($this->avatar)){
            return asset('/uploads/avatar/avatar.png');
        } else{
            return $this->avatar;
        }
    }

    // ユーザーの一覧を取得（プルダウン用）
    public static function getUserList() 
    {
        return User::latest()->pluck('name', 'id');
    }

    // パスワードリセットの送信者とタイトルを日本語にオーバーライドする
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new JaPasswordReset($token));
    }

}
