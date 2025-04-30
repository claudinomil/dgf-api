<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GrupoDashboard extends Model
{
    use HasFactory;

    protected $table = 'grupos_dashboards';

    protected $fillable = [
        'grupo_id',
        'dashboard_id'
    ];
}
