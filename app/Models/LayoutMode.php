<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LayoutMode extends Model
{
    use HasFactory;

    protected $table = 'layouts_modes';

    protected $fillable = [
        'name',
        'descricao',
        'ativo'
    ];
}
