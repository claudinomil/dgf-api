<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    protected $table = 'users';

    protected $fillable = [
        'name',
        'email',
        'grupo_id',
        'situacao_id',
        'layout_mode',
        'layout_style',
        'email_verified_at',
        'user_confirmed_at',
        'password',
        'avatar',
        'militar_rg',
        'militar_nome',
        'militar_posto_graduacao',
        'militar_posto_graduacao_ordem'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function setNameAttribute($value) {$this->attributes['name'] = mb_strtoupper($value);}
    public function setEmailAttribute($value) {$this->attributes['email'] = mb_strtolower($value);}
    public function setAvatarAttribute($value) {$this->attributes['avatar'] = mb_strtolower($value);}

    public function getJWTIdentifier() {return $this->getKey();}
    public function getJWTCustomClaims() {return [];}
}
