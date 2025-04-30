<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ferramenta extends Model
{
    use HasFactory;

    protected $table = 'ferramentas';

    protected $fillable = [
        'name',
        'descricao',
        'url',
        'icon',
        'ordem_visualizacao',
        'user_id'
    ];

    public function setNameAttribute($value) {$this->attributes['name'] = mb_strtoupper($value);}
    public function setUrlAttribute($value) {$this->attributes['url'] = mb_strtolower($value);}
    public function setIconAttribute($value) {$this->attributes['icon'] = mb_strtolower($value);}
}
