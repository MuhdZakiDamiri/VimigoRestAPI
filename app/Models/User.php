<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
// use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
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


    public static function get_by_name_or_email($filter)
    {

        $user = User::query()
                ->where(function($q) use ($filter){

                    if (!empty($filter['name']) && User::where('name', $filter['name'])->exists()){
                        $q->where('name', $filter['name']);
                    }

                    if (!empty($filter['email']) && User::where('email', $filter['email'])->exists()){
                        $q->where('email', $filter['email']);
                    }
                })
                ->paginate(15);

        return $user;
    }
}
