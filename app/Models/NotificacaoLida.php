<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificacaoLida extends Model
{
    use HasFactory;

    protected $table = 'notificacoes_lidas';

    protected $fillable = [
        'user_id',
        'notificacao_id',
        'date',
        'time'
    ];
}
