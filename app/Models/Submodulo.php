<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Submodulo extends Model
{
    use HasFactory;

    protected $table = 'submodulos';

    protected $fillable = [
        'modulo_id',
        'name',
        'menu_text',
        'menu_url',
        'menu_route',
        'menu_icon',
        'prefix_permissao',
        'prefix_route',
        'descricao',
        'ordem_visualizacao'
    ];
}
