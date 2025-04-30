<?php

namespace App\Models;

use App\Facades\SuporteFacade;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RessarcimentoConfiguracao extends Model
{
    use HasFactory;

    protected $table = 'ressarcimento_configuracoes';

    protected $fillable = [
        'referencia',
        'data_vencimento',
        'diretor_identidade_funcional',
        'diretor_rg',
        'diretor_nome',
        'diretor_posto',
        'diretor_quadro',
        'diretor_cargo',
        'dgf2_identidade_funcional',
        'dgf2_rg',
        'dgf2_nome',
        'dgf2_posto',
        'dgf2_quadro',
        'dgf2_cargo'
    ];

    protected function setDataVencimentoAttribute($value) {
        $value = SuporteFacade::getDataFormatada(4, $value);
        $this->attributes['data_vencimento'] = $value;
    }
    protected function getDataVencimentoAttribute($value) {
        return SuporteFacade::getDataFormatada(1, $value);
    }

    public function setDiretorNomeAttribute($value) {$this->attributes['diretor_nome'] = mb_strtoupper($value);}
    public function setDiretorPostoAttribute($value) {$this->attributes['diretor_posto'] = mb_strtoupper($value);}
    public function setDiretorQuadroAttribute($value) {$this->attributes['diretor_quadro'] = mb_strtoupper($value);}

    public function setDgf2NomeAttribute($value) {$this->attributes['dgf2_nome'] = mb_strtoupper($value);}
    public function setDgf2PostoAttribute($value) {$this->attributes['dgf2_posto'] = mb_strtoupper($value);}
    public function setDgf2QuadroAttribute($value) {$this->attributes['dgf2_quadro'] = mb_strtoupper($value);}
}
