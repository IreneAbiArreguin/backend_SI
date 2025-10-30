<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Municipio extends Model
{
    protected $table = 'municipios';
    protected $primaryKey = 'id_municipio';
    public $timestamps = false;

    protected $fillable = ['nombre', 'codigo_inegi'];

    public function refugios()
    {
        return $this->hasMany(Refugio::class, 'id_municipio', 'id_municipio');
    }

    public function reportes()
    {
        return $this->hasMany(ReporteInundacion::class, 'id_municipio', 'id_municipio');
    }
}