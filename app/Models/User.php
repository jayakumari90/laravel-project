<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasRoles, HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'company',
        'name',
        'vat_number',
        'email',
        'join_date',
        'phone_number',
        'website',
        'status',
        'role',
        'avatar',
        'position',
        'department',
        'email_verified_at',
        'password',
        'groups',
        'default_language',
        'country',
        'state',
        'city',
        'address',
        'zipcode',
        'currancy',
        'remember_token',
        'last_login',
        'import_update',
        'created_at',
        'updated_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getRole()
    {
        return $this->belongsTo('App\Models\RoleType', 'role');
    }
}
