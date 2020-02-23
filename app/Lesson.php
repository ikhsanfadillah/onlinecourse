<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lesson extends Model implements hasMedia
{
    use HasMediaTrait;
    use SoftDeletes;
    const LESSON_MEDIA_TYPE_VIDEO = 'lesson-video';
    const LESSON_MEDIA_THUMBNAIL = 'thumbnail-photo';

    public static $createRules = [
        'title' => 'required|max:255',
        'slug' => 'required|alpha_dash|unique:lessons,slug',
        'desc' => 'required',
        'thumbnail_photo' => 'required|image',
        'lesson_video_url' => 'required',
//        'lesson_video' => 'required|mimetypes:video/x-flv,video/mp4,video/quicktime,video/x-msvideo,video/x-ms-wmv',
    ];

    public function mentor() {
        return $this->belongsTo(Mentor::class,'mentor_id');
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function wishlists () {
      return $this->morphMany(Wishlist::class, 'wishable');
    }

    public function registerMediaCollections()
    {
        $this
            ->addMediaCollection(self::LESSON_MEDIA_THUMBNAIL)
            ->singleFile();
        $this
            ->addMediaCollection(self::LESSON_MEDIA_TYPE_VIDEO)
            ->singleFile();
    }


}
