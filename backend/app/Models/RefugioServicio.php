<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RefugioServicio extends Model
{
    protected $table = 'refugios_servicios';
    protected $primaryKey = 'id_servicio';
    public $timestamps = false;

    protected $fillable = ['nombre', 'descripcion'];

    public function refugiosRel()
    {
        return $this->hasMany(RefugioServiciosRel::class, 'id_servicio', 'id_servicio');
    }
}