<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Usuario extends Authenticatable
{
    use Notifiable;

    protected $table = 'usuarios';
    protected $primaryKey = 'id_usuario';

    protected $fillable = [
        'nombre', 'apellido', 'email', 'password', 'telefono',
        'ubicacion', 'latitud', 'longitud', 'email_verificado_at', 'id_rol'
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'email_verificado_at' => 'datetime',
        'latitud' => 'decimal:8',
        'longitud' => 'decimal:8',
    ];

    public function rol()
    {
        return $this->belongsTo(Rol::class, 'id_rol', 'id_rol');
    }

    public function reportes()
    {
        return $this->hasMany(ReporteInundacion::class, 'id_usuario', 'id_usuario');
    }

    public function reportesVerificados()
    {
        return $this->hasMany(ReporteInundacion::class, 'verificado_por', 'id_usuario');
    }

    public function historicoReportes()
    {
        return $this->hasMany(HistoricoReporte::class, 'id_usuario', 'id_usuario');
    }
}