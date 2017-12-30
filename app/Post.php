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
}
