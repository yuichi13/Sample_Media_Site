<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes;
    
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'title', 'content', 'user_id', 'pic'
    ];

    public function user()
    {
        return $this->belongsTo('App\User')->withDefault();
    }

    public function pic()
    {
        if(!$this->pic){
            return 'storage/uploads/pic/no-img.png';
        } else{
            return $this->pic;
        }
    }

}
