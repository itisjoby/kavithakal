<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Posts extends Model {

    //
    protected $fillable = ['title', 'content', 'mini_content', 'created_by', 'readed_count', 'status'];

}
