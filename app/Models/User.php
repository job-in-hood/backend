<?php

namespace App\Models;

use App\Notifications\ResetPasswordNotification;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail, CanResetPassword
{
    use Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'created_at', 'updated_at', 'email_verified_at'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = ['companyRoles'];

    public function representations()
    {
        return $this->hasMany(Representation::class);
    }

    public function companies()
    {
        return $this->belongsToMany(Company::class, 'representations')
            ->using(Representation::class)
            ->withTimestamps();
    }

    /**
     * @param Company $company
     * @return Representation
     */
    public function forCompany(Company $company) {
        return $this->representations()->where('company_id', $company->id)->first();
    }

    public function getCompanyRolesAttribute()
    {
        return $this->representations()
            ->with('roles')
            ->with('company')
            ->get()
            ->map(function ($item) {
                return [
                    "company" => $item->company,
                    "role" => $item->roles->pluck("name")
                ];
            });
    }

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }
}
