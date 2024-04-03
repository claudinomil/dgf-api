<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Esfera extends Model
{
    use HasFactory;

    protected $table = 'esferas';

    protected $fillable = [
        'name',
        'ordem_visualizacao'
    ];
}
