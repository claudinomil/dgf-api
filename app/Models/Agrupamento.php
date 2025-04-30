<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agrupamento extends Model
{
    use HasFactory;

    protected $table = 'agrupamentos';

    protected $fillable = [
        'name',
        'ordem_visualizacao'
    ];
}
