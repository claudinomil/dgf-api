<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Modulo extends Model
{
    use HasFactory;

    protected $table = 'modulos';

    protected $fillable = [
        'setor_id',
        'name',
        'menu_text',
        'menu_url',
        'menu_route',
        'menu_icon',
        'ordem_visualizacao'
    ];
}
