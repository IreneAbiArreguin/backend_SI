<?php

namespace App\Http\Controllers\Api;

use App\Models\ReporteInundacion;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ReporteInundacionController extends ApiController
{
    public function index()
    {
        $reportes = ReporteInundacion::with(['usuario', 'municipio', 'estado'])->get();
        return $this->success($reportes);
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'id_usuario' => 'nullable|exists:usuarios,id_usuario',
                'id_municipio' => 'nullable|exists:municipios,id_municipio',
                'estado_reporte_id' => 'required|exists:estados_reporte,id_estado',
                'nivel_afectacion' => 'nullable|string|max:50',
                'metodo_origen' => 'required|string|max:30',
                'latitud' => 'required|numeric',
                'longitud' => 'required|numeric',
                'calle_principal' => 'nullable|string|max:150',
                'colonia' => 'nullable|string|max:100',
                'descripcion' => 'nullable|string',
            ]);

            $reporte = ReporteInundacion::create($request->all());
            return $this->success($reporte, 'Reporte creado', 201);
        } catch (ValidationException $e) {
            return $this->error('Datos inválidos', 422);
        }
    }

    public function show(ReporteInundacion $reporte)
    {
        $reporte->load(['usuario', 'municipio', 'estado', 'verificadoPor']);
        return $this->success($reporte);
    }

    public function update(Request $request, ReporteInundacion $reporte)
    {
        try {
            $request->validate([
                'estado_reporte_id' => 'sometimes|exists:estados_reporte,id_estado',
                'verificado_por' => 'nullable|exists:usuarios,id_usuario',
                'descripcion' => 'sometimes|string',
            ]);

            $reporte->update($request->all());
            return $this->success($reporte, 'Reporte actualizado');
        } catch (ValidationException $e) {
            return $this->error('Datos inválidos', 422);
        }
    }

    public function destroy(ReporteInundacion $reporte)
    {
        $reporte->delete();
        return $this->success(null, 'Reporte eliminado');
    }
}