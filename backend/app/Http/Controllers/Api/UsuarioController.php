<?php

namespace App\Http\Controllers\Api;

use App\Models\Usuario;
use Illuminate\Http\Request;

class UsuarioController extends ApiController
{
    public function index()
    {
        $usuarios = Usuario::with('rol')->select([
            'id_usuario', 'nombre', 'apellido', 'email', 'telefono',
            'latitud', 'longitud', 'id_rol'
        ])->get();
        return $this->success($usuarios);
    }

    public function show(Usuario $usuario)
    {
        $usuario->load('rol');
        return $this->success($usuario->only([
            'id_usuario', 'nombre', 'apellido', 'email', 'telefono',
            'latitud', 'longitud', 'id_rol'
        ]));
    }
}