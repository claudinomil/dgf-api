<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LayoutStyle extends Model
{
    use HasFactory;

    protected $table = 'layouts_styles';

    protected $fillable = [
        'name',
        'descricao',
        'ativo'
    ];
}
