<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

class Mentor extends Model implements HasMedia
{
    use HasMediaTrait;

    protected $primaryKey = 'mentor_id';
    public $incrementing = false;
    public $timestamps = false;
    protected $fillable = ['mentor_id', 'primary_p_id', 'highlight_v_id', 'profesi', 'desc', 'price', 'description_p_id', 'visit_count'];
    protected $with = ['user'];
    public $username;

    public static $createRules = [
        'name' => 'required|max:255',
        'username' => 'required|unique:users|max:255',
        'email' => 'required|email|unique:users|max:255',
        'password' => 'required|max:255',
        'confirm_password' => 'required|same:password',
        'gender' => 'required',
        'profesi' => 'required|max:50',
        'desc' => 'required',
        'avatar_photo' => 'image',
        'primary_photo' => 'required|image',
        'description_photo' => 'image',
        'highlight_video' => 'mimetypes:video/x-flv,video/mp4,video/quicktime,video/x-msvideo,video/x-ms-wmv|max:10000',
    ];

    public static $updateRules = [
        'name' => 'required|max:255',
        'email' => 'sometimes|required|email|unique:users',
        'username' => 'sometimes|required|unique:users',
        'gender' => 'required|numeric',
        'profesi' => 'required|max:50',
        'desc' => 'required',
        'avatar_photo' => 'image',
        'primary_photo' => 'image',
        'description_photo' => 'image',
        'highlight_video' => 'mimetypes:video/x-flv,video/mp4,video/quicktime,video/x-msvideo,video/x-ms-wmv|max:200000',
    ];

    public function user()
    {
        return $this->belongsTo('App\User','mentor_id');
    }
    public function lessons()
    {
        return $this->hasMany(Lesson::class,'mentor_id','mentor_id');
    }

    public function wishlists () {
      return $this->morphMany(Wishlist::class, 'wishable');
    }

    public static function getMentorByUsername($username){
        return self::whereHas('user', function ($q) use ($username) {
            $q->where('username', '=', $username);
        })->firstOrFail();
    }
    /**
     * Set the polymorphic relation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function media()
    {
        return $this->morphMany(config('medialibrary.media_model'), 'model','model_type','model_id','mentor_id');
    }

    public function registerMediaCollections()
    {
        $this
            ->addMediaCollection('primary-photo')
            ->singleFile();
        $this
            ->addMediaCollection('description-photo')
            ->singleFile();
        $this
            ->addMediaCollection('highlight-video')
            ->singleFile();
    }

    public function getBestComment(){
      return MentorRating::where('mentor_id',$this->mentor_id)->orderBy('rating','desc')->orderBy('created_at','desc')->first();
    }
    public function getAvatar(){
        $user = User::find($this->mentor_id);
        return $user->getFirstMediaUrl('avatar-photo');
    }

    public function discounts(){
        return $this->belongsToMany(Discount::class,'discount_mentor',"mentor_id", "discount_id");
    }

}
