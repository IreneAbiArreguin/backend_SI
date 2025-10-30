<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReporteInundacion extends Model
{
    protected $table = 'reportes_inundacion';
    protected $primaryKey = 'id_reporte';

    protected $fillable = [
        'id_usuario', 'id_municipio', 'estado_reporte_id', 'nivel_afectacion',
        'metodo_origen', 'fecha_suceso', 'prioridad', 'calle_principal',
        'cruzamiento1', 'cruzamiento2', 'colonia', 'cp', 'descripcion',
        'latitud', 'longitud', 'verificado_por'
    ];

    protected $casts = [
        'fecha_suceso' => 'datetime',
        'latitud' => 'decimal:8',
        'longitud' => 'decimal:8',
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario', 'id_usuario');
    }

    public function municipio()
    {
        return $this->belongsTo(Municipio::class, 'id_municipio', 'id_municipio');
    }

    public function estado()
    {
        return $this->belongsTo(EstadoReporte::class, 'estado_reporte_id', 'id_estado');
    }

    public function verificadoPor()
    {
        return $this->belongsTo(Usuario::class, 'verificado_por', 'id_usuario');
    }

    public function historico()
    {
        return $this->hasMany(HistoricoReporte::class, 'id_reporte', 'id_reporte');
    }
}