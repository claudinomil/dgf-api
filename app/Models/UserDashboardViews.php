<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDashboardViews extends Model
{
    use HasFactory;

    protected $table = 'users_dashboards_views';

    protected $fillable = [
        'user_id',
        'grupo_dashboard_id',
        'ordem_visualizacao'
    ];
}
