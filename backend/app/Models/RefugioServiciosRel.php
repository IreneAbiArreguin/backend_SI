<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RefugioServiciosRel extends Model
{
    protected $table = 'refugios_servicios_rel';
    protected $primaryKey = 'id_rel';
    public $timestamps = false;

    protected $fillable = ['id_refugio', 'id_servicio', 'disponible'];

    public function refugio()
    {
        return $this->belongsTo(Refugio::class, 'id_refugio', 'id_refugio');
    }

    public function servicio()
    {
        return $this->belongsTo(RefugioServicio::class, 'id_servicio', 'id_servicio');
    }
}