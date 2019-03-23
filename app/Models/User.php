<?php

namespace App\Models;

use App\Notifications\TopicReplied;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Traits\LastActivedAtHelper;

    use Traits\ActiveUserHelper;

    use Notifiable;


    public function replyNotify(Reply $reply)
    {
        if ($this->id == \Auth::id()) {
            return;
        }
        $this->increment('notification_count');
        $this->notify(new TopicReplied($reply));
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','introduction','avatar','email_verified','phone',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified'=>'boolean',
    ];

    public function topics()
    {
        return $this->hasMany(Topic::class);
    }

    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    public function markAsRead()
    {
        $this->notification_count = 0;
        $this->save();
        $this->unreadNotifications->markAsRead();
    }

    protected static function boot()
    {
        parent::boot(); // TODO: Change the autogenerated stub
        static::created(function ($model) {
            $model->update(['avatar' => 'https://www.gravatar.com/avatar/205e460b479e2e5b48aec07710c08d50?s=200']);
        });
    }
}
