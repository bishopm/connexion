<?php

namespace Bishopm\Connexion\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Actuallymab\LaravelComment\CanComment;

class User extends Authenticatable
{
    use Notifiable;
    use HasRoles;
    use CanComment;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'individual_id','google_calendar','calendar_colour'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function individual(){
        return $this->belongsTo('Bishopm\Connexion\Models\Individual');
    }
}
