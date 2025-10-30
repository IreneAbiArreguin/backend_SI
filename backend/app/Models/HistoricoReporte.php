<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HistoricoReporte extends Model
{
    protected $table = 'historico_reportes';
    protected $primaryKey = 'id_historico';
    public $timestamps = false;

    protected $fillable = [
        'id_reporte', 'id_usuario', 'estado_anterior',
        'estado_nuevo', 'comentario'
    ];

    public function reporte()
    {
        return $this->belongsTo(ReporteInundacion::class, 'id_reporte', 'id_reporte');
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario', 'id_usuario');
    }
}