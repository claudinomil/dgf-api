<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SadMilitaresInformacao extends Model
{
    use HasFactory;

    protected $table = 'sad_militares_informacoes';

    protected $fillable = [
        'setor_id',
        'funcao_id',
        'foto',
        'militar_rg',
        'militar_nome',
        'militar_posto_graduacao',
        'militar_posto_graduacao_ordem'
    ];

    protected $hidden = [];

    protected $casts = [];

    public function setFotoAttribute($value)
    {
        $this->attributes['foto'] = mb_strtolower($value);
    }
}
