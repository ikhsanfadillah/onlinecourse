<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements HasMedia, MustVerifyEmail
{
    use HasMediaTrait;
    use Notifiable;
    use HasRoles;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'username', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function mentor()
    {
        return $this->hasOne('App\Mentor');
    }

    public function supportDesk() {
      return $this->hasMany('App\SupportDesk', 'author');
    }
    public function registerMediaCollections()
    {
        $this
            ->addMediaCollection('avatar-photo')
            ->singleFile();
    }

    public static function findByUsername($username){
        return self::where('username',$username)->firstOrFail();
    }

    public function hasMentorLesson($mentor_id){
        $mentor = Mentor::find($mentor_id);
        $mentorLesson = $mentor->lessons[0];
        $userLesson = UserLesson::where('user_id',$this->id)
            ->where('lesson_id',$mentorLesson->lesson_id)->first();
        return !empty($userLesson);
    }
}
