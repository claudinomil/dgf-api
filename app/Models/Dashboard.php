<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dashboard extends Model
{
    use HasFactory;

    protected $table = 'dashboards';

    protected $fillable = [
        'modulo_id',
        'name',
        'descricao',
        'ordem_visualizacao'
    ];
}
