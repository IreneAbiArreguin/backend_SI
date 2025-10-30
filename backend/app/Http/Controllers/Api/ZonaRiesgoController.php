<?php

namespace App\Http\Controllers\Api;

use App\Models\ZonaRiesgo;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ZonaRiesgoController extends ApiController
{
    public function index()
    {
        $zonas = ZonaRiesgo::with('nivel')->get();
        return $this->success($zonas);
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'identificador' => 'required|string|max:50|unique:zonas_riesgo',
                'id_nivel' => 'required|exists:niveles_riesgo,id_nivel',
                'poligono' => 'required|array|min:3',
                'poligono.*.latitude' => 'required|numeric',
                'poligono.*.longitude' => 'required|numeric',
            ]);

            $zona = ZonaRiesgo::create($request->all());
            return $this->success($zona, 'Zona de riesgo creada', 201);
        } catch (ValidationException $e) {
            return $this->error('Datos inválidos: ' . implode(', ', $e->errors()), 422);
        }
    }

    public function show(ZonaRiesgo $zona)
    {
        $zona->load('nivel');
        return $this->success($zona);
    }

    public function update(Request $request, ZonaRiesgo $zona)
    {
        try {
            $request->validate([
                'identificador' => 'sometimes|string|max:50|unique:zonas_riesgo,identificador,' . $zona->id_zona . ',id_zona',
                'id_nivel' => 'sometimes|exists:niveles_riesgo,id_nivel',
                'poligono' => 'sometimes|array|min:3',
                'poligono.*.latitude' => 'required_with:poligono|numeric',
                'poligono.*.longitude' => 'required_with:poligono|numeric',
            ]);

            $zona->update($request->all());
            return $this->success($zona, 'Zona de riesgo actualizada');
        } catch (ValidationException $e) {
            return $this->error('Datos inválidos: ' . implode(', ', $e->errors()), 422);
        }
    }

    public function destroy(ZonaRiesgo $zona)
    {
        $zona->delete();
        return $this->success(null, 'Zona de riesgo eliminada');
    }
}