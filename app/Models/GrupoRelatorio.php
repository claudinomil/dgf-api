<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GrupoRelatorio extends Model
{
    use HasFactory;

    protected $table = 'grupos_relatorios';

    protected $fillable = [
        'grupo_id',
        'relatorio_id'
    ];
}
