<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vocativo extends Model
{
    use HasFactory;

    protected $table = 'vocativos';

    protected $fillable = [
        'name',
        'ordem_visualizacao'
    ];
}
