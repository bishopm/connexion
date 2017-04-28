<?php

namespace Bishopm\Connexion\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Actuallymab\LaravelComment\CanComment;
use Bishopm\Connexion\Notifications\ResetPasswordNotification;
use Laratrust\Traits\LaratrustUserTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use Notifiable;
    use LaratrustUserTrait;    
    use CanComment;
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $guarded = array('id');
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function individual(){
        return $this->belongsTo('Bishopm\Connexion\Models\Individual');
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    public function routeNotificationForSlack()
    {
        return 'https://hooks.slack.com/services/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';
    }

}
