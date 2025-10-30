<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NivelRiesgo extends Model
{
    protected $table = 'niveles_riesgo';
    protected $primaryKey = 'id_nivel';
    public $timestamps = false;

    protected $fillable = ['codigo', 'descripcion'];

    public function zonasRiesgo()
    {
        return $this->hasMany(ZonaRiesgo::class, 'id_nivel', 'id_nivel');
    }
}