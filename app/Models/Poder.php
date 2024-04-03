<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Poder extends Model
{
    use HasFactory;

    protected $table = 'poderes';

    protected $fillable = [
        'name',
        'ordem_visualizacao'
    ];
}
