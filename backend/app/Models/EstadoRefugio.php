<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EstadoRefugio extends Model
{
    protected $table = 'estados_refugio';
    protected $primaryKey = 'id_estado_refugio';
    public $timestamps = false;

    protected $fillable = ['codigo', 'descripcion'];

    public function refugios()
    {
        return $this->hasMany(Refugio::class, 'estado_refugio_id', 'id_estado_refugio');
    }
}