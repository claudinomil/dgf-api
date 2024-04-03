<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRelatorioViews extends Model
{
    use HasFactory;

    protected $table = 'users_relatorios_views';

    protected $fillable = [
        'user_id',
        'relatorio_id',
        'ordem_visualizacao'
    ];
}
