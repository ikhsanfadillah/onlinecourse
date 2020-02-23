<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

class LandingPage extends Model implements hasMedia
{

    use HasMediaTrait;

    public static $rules = [
        'trailer_desc' => 'required',
        'trailer_photo' => 'image',
        'trailer_video' => 'mimetypes:video/x-flv,video/mp4,video/quicktime,video/x-msvideo,video/x-ms-wmv',
    ];

    public function mentor() {
        return $this->belongsTo(Mentor::class);
    }


    public function registerMediaCollections()
    {
        $this->addMediaCollection('preview-photo');
        $this->addMediaCollection('preview-video');
    }
}
