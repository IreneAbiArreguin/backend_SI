<?php

namespace App\Http\Controllers\Api;

use App\Models\Refugio;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class RefugioController extends ApiController
{
    public function index()
    {
        $refugios = Refugio::with(['municipio', 'estado', 'servicios'])->get();
        return $this->success($refugios);
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'nombre' => 'required|string|max:150',
                'direccion' => 'required|string',
                'capacidad_total' => 'required|integer|min:1',
                'id_municipio' => 'nullable|exists:municipios,id_municipio',
                'estado_refugio_id' => 'required|exists:estados_refugio,id_estado_refugio',
                'latitud' => 'required|numeric',
                'longitud' => 'required|numeric',
            ]);

            $refugio = Refugio::create($request->all());
            return $this->success($refugio, 'Refugio creado', 201);
        } catch (ValidationException $e) {
            return $this->error('Datos inválidos', 422);
        }
    }

    public function show(Refugio $refugio)
    {
        $refugio->load(['municipio', 'estado', 'servicios']);
        return $this->success($refugio);
    }

    public function update(Request $request, Refugio $refugio)
    {
        try {
            $request->validate([
                'capacidad_actual' => 'sometimes|integer|min:0|max:' . $refugio->capacidad_total,
                'estado_refugio_id' => 'sometimes|exists:estados_refugio,id_estado_refugio',
            ]);

            $refugio->update($request->all());
            return $this->success($refugio, 'Refugio actualizado');
        } catch (ValidationException $e) {
            return $this->error('Datos inválidos', 422);
        }
    }

    public function destroy(Refugio $refugio)
    {
        $refugio->delete();
        return $this->success(null, 'Refugio eliminado');
    }
}