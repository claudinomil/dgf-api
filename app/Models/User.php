<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'users';

    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar',
        'layout_mode',
        'layout_style',
        'grupo_id',
        'situacao_id',
        'militar_rg',
        'militar_nome',
        'militar_posto_graduacao',
        'militar_posto_graduacao_ordem',
        'user_confirmed_at'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function setNameAttribute($value) {$this->attributes['name'] = mb_strtoupper($value);}
    public function setEmailAttribute($value) {$this->attributes['email'] = mb_strtolower($value);}
    public function setAvatarAttribute($value) {$this->attributes['avatar'] = mb_strtolower($value);}
}
