<?php

namespace Modules\Post\Entities;

use Illuminate\Database\Eloquent\Model;

use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\Models\Media;


class Post extends Model implements HasMedia
{
    use HasMediaTrait;

    protected $table = "posts";

    protected $fillable = [];

    public function getPostByUser()
    {
        return $this->hasOne(\Modules\Users\Entities\User::class,'id','created_by');
    }

    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('thumb')
            ->width(48)
            ->height(48);
    }
}
