<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ReporteInundacion; 
class ReporteInundacionController extends Controller
{
    public function index()
    {
        // Lógica para mostrar reportes en la vista web
        return view('reportes.index');
    }

    public function create()
    {
        // Mostrar formulario de creación
        return view('reportes.create');
    }

    public function store(Request $request)
    {
        // Validar y guardar reporte
        // Redireccionar a alguna vista
        return redirect()->route('reportes.index');
    }

   public function show($id)
{
    $reporte = ReporteInundacion::with(['usuario', 'municipio', 'estado', 'verificadoPor'])
        ->findOrFail($id);

    return response()->json([
        'success' => true,
        'data' => $reporte
    ]);
}

        public function verReportes()   
    {
        return view('reportes.verReportes');
    }
}