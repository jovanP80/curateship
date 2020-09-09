<?php

namespace Modules\Post\Entities;

use Illuminate\Database\Eloquent\Model;

use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\Models\Media;
use Spatie\Image\Image;

class Post extends Model implements HasMedia
{
    use HasMediaTrait;

    protected $table = "posts";

    protected $fillable = [];

    public $width;

    public function getPostByUser()
    {
        return $this->hasOne(\Modules\Users\Entities\User::class,'id','created_by');
    }

    public function setWidth($width)
    {
        $this->width = $width;
    }

    public function getWidth()
    {
        return $this->width;
    }


    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('thumb')
            ->width(50)
            ->height(50);

        foreach ($media->manipulations as $key => $manipulation) {
            if($key == 'small' || $key == 'medium' || $key == 'large') {
                $this->addMediaConversion($key)->width($manipulation['width'])->height($manipulation['height']);    
            }
        }

        /**
         * Commented out for calculated sizing option
         */
        /*$this->addMediaConversion('medium')
            ->width((Image::load($media->getPath())->getWidth())/2)
            ->height((Image::load($media->getPath())->getHeight())/2);*/
    }
}
