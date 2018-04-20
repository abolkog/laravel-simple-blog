<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    // Table name
    // protected $table = 'ma_posts';

    // Primary key
    //public $primaryKey = 'AY_ISM_COLUMN';

    // Timestamp disable
    // public $timestamps = false;

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function comments() {
        return $this->hasMany('App\Comment');
    }

    public function tags() {
        return $this->belongsToMany('App\Tag');
    }
}
