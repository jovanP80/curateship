<?php

namespace Modules\Post\Entities;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table = "posts";

    protected $fillable = [];

    public function getPostByUser()
    {
        return $this->hasOne(\Modules\Users\Entities\User::class,'id','created_by');
    }
}
