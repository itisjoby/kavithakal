<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model {

    //
    protected $fillable = ['title', 'post_id', 'status'];

}
