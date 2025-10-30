<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Refugio extends Model
{
    protected $table = 'refugios';
    protected $primaryKey = 'id_refugio';

    protected $fillable = [
        'nombre', 'direccion', 'capacidad_total', 'capacidad_actual',
        'id_municipio', 'estado_refugio_id', 'telefono_contacto',
        'responsable', 'latitud', 'longitud'
    ];

    protected $casts = [
        'latitud' => 'decimal:8',
        'longitud' => 'decimal:8',
    ];

    public function municipio()
    {
        return $this->belongsTo(Municipio::class, 'id_municipio', 'id_municipio');
    }

    public function estado()
    {
        return $this->belongsTo(EstadoRefugio::class, 'estado_refugio_id', 'id_estado_refugio');
    }

    public function servicios()
    {
        return $this->belongsToMany(
            RefugioServicio::class,
            'refugios_servicios_rel',
            'id_refugio',
            'id_servicio'
        )->withPivot('disponible');
    }
}