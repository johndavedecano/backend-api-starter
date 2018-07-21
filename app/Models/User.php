<?php namespace App\Models;

use Hash;

use App\Models\Traits\JwtSettings;
use App\Models\Traits\SetsPassword;
use App\Models\Traits\AuthNotifications;

use App\Notifications\ResetPasswordRequested;
use App\Notifications\AccountCreated;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;
    use JwtSettings;
    use SetsPassword;
    use HasRoles;
    use AuthNotifications;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
        'activation_token_expires_at',
        'email_reset_token_expires_at'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',

        'email',
        'password',

        'is_activated',
        'activation_token',
        'activation_token_expires_at',

        'email_reset',
        'email_reset_token',
        'email_reset_token_expires_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
}
