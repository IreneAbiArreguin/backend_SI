@extends('layouts.admin')

@section('title', 'Reportes')

@section('page-title', 'Reportes - Yáanal Ha\'')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('welcome') }}">Inicio</a></li>
    <li class="breadcrumb-item active">Reportes</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Card para crear nuevo reporte -->
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-plus-circle mr-2"></i>
                        Crear Nuevo Reporte
                    </h3>
                </div>
                <div class="card-body">
                    <a href="{{ route('reportes.create') }}" class="btn btn-primary btn-lg">
                        <i class="fas fa-plus mr-2"></i>Reportar Inundación
                    </a>
                    <small class="text-muted d-block mt-2">
                        Reporta situaciones de inundación en tu comunidad para ayudar a las autoridades.
                    </small>
                </div>
            </div>

            <!-- Lista de reportes del usuario -->
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-list mr-2"></i>
                        Mis Reportes
                    </h3>
                </div>
                <div class="card-body">
                    @if($reportes->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Fecha del Suceso</th>
                                        <th>Ubicación</th>
                                        <th>Nivel Afectación</th>
                                        <th>Prioridad</th>
                                        <th>Estado</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($reportes as $reporte)
                                        <tr>
                                            <td>
                                                <i class="far fa-calendar-alt mr-1"></i>
                                                {{ \Carbon\Carbon::parse($reporte->fecha_suceso)->format('d/m/Y H:i') }}
                                            </td>
                                            <td>
                                                <i class="fas fa-map-marker-alt mr-1"></i>
                                                {{ $reporte->calle_principal ?: 'Ubicación no especificada' }}
                                                @if($reporte->colonia)
                                                    <br><small class="text-muted">{{ $reporte->colonia }}</small>
                                                @endif
                                            </td>
                                            <td>
                                                @if($reporte->nivel_afectacion)
                                                    <span class="badge 
                                                        @if($reporte->nivel_afectacion == 'bajo') badge-success
                                                        @elseif($reporte->nivel_afectacion == 'medio') badge-warning
                                                        @elseif($reporte->nivel_afectacion == 'alto') badge-danger
                                                        @else badge-secondary @endif">
                                                        {{ ucfirst($reporte->nivel_afectacion) }}
                                                    </span>
                                                @else
                                                    <span class="badge badge-secondary">No especificado</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($reporte->prioridad == 1)
                                                    <span class="badge badge-danger">Alta</span>
                                                @elseif($reporte->prioridad == 2)
                                                    <span class="badge badge-warning">Media</span>
                                                @else
                                                    <span class="badge badge-info">Baja</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($reporte->estado_reporte_id == 1)
                                                    <span class="badge badge-success">Activo</span>
                                                @elseif($reporte->estado_reporte_id == 2)
                                                    <span class="badge badge-warning">En Proceso</span>
                                                @elseif($reporte->estado_reporte_id == 3)
                                                    <span class="badge badge-secondary">Resuelto</span>
                                                @else
                                                    <span class="badge badge-info">Pendiente</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('reportes.show', $reporte->id_reporte) }}" 
                                                   class="btn btn-info btn-sm"
                                                   title="Ver detalles">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                @if($reporte->estado_reporte_id == 1)
                                                    <button class="btn btn-warning btn-sm" title="Editar">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Paginación -->
                        <div class="d-flex justify-content-center mt-3">
                            {{ $reportes->links() }}
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">No tienes reportes registrados</h5>
                            <p class="text-muted">Crea tu primer reporte de inundación para comenzar.</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Estadísticas rápidas -->
            <div class="row">
                <div class="col-md-3">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ $reportes->count() }}</h3>
                            <p>Total Reportes</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-file-alt"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{ $reportes->where('estado_reporte_id', 1)->count() }}</h3>
                            <p>Reportes Activos</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ $reportes->where('estado_reporte_id', 3)->count() }}</h3>
                            <p>Resueltos</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>{{ $reportes->where('prioridad', 1)->count() }}</h3>
                            <p>Alta Prioridad</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-flag"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .small-box {
        border-radius: 0.25rem;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        margin-bottom: 1rem;
    }
    .small-box .inner {
        padding: 10px;
    }
    .small-box .icon {
        transition: all 0.3s ease;
    }
    .small-box:hover .icon {
        transform: scale(1.1);
    }
    .table th {
        border-top: none;
        font-weight: 600;
    }
</style>
@endsection