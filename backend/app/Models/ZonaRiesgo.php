<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ZonaRiesgo extends Model
{
    protected $table = 'zonas_riesgo';
    protected $primaryKey = 'id_zona';

    protected $fillable = ['identificador', 'id_nivel', 'poligono'];

    protected $casts = [
        'poligono' => 'array',
    ];

    public function nivel()
    {
        return $this->belongsTo(NivelRiesgo::class, 'id_nivel', 'id_nivel');
    }
}