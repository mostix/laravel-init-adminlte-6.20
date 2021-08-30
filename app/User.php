<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\Traits\CausesActivity;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use SoftDeletes;
    use LogsActivity;
    use CausesActivity;
    use Notifiable;
    use HasRoles;

    protected static $logName = "users";
    protected static $logAttributes = ['username','first_name','middle_name','last_name','email','password_change_at','last_login_at'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email', 'password','password_change_at','last_login_at'
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

    public static function createRequestValidationRules()
    {
        $rules = [
            'username'          => ['required', 'string', 'unique:users','max:255'],
            'first_name'        => ['nullable', 'string', 'max:255'],
            'last_name'         => ['nullable', 'string', 'max:255'],
            'email'             => ['required', 'string','unique:users', 'email', 'max:255'],
//            'password'          => ['required', 'string', 'min:8', 'confirmed', 'regex:/^(?=.*[a-z])(?=.*\d)(?=.*(_|[^\w])).+$/'],
//            'password_confirmation' => ['required', 'same:password'],
            'role'              =>  ['required'],
        ];

        return $rules;
    }

    public static function editRequestValidationRules()
    {
        $rules = [
            'username'          => ['required', 'string', 'max:255'],
            'first_name'        => ['nullable', 'string', 'max:255'],
            'last_name'         => ['nullable', 'string', 'max:255'],
            'email'             => ['required', 'string', 'email', 'max:255'],
            'password'          => ['nullable', 'string', 'min:8', 'confirmed', 'regex:/^(?=.*[a-z])(?=.*\d)(?=.*(_|[^\w])).+$/'],
            'password_confirmation' => ['nullable','same:password'],
            'role'              =>  ['required'],
        ];

        return $rules;
    }

    public static function passwordRequestValidationRules()
    {
        $rules = [
            'password'          => ['required', 'string', 'min:8', 'confirmed', 'regex:/^(?=.*[a-z])(?=.*\d)(?=.*(_|[^\w])).+$/'],
            'password_confirmation' => ['required','same:password']
        ];

        return $rules;
    }
}
