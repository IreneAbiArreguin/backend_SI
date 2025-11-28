@extends('layouts.admin')

@section('title', 'Información - Yáanal Ha\'')

@section('page-title', 'Sistema de Refugios - Yáanal Ha\'')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('mapa') }}">Inicio</a></li>
    <li class="breadcrumb-item active">Refugios Yáanal Ha'</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Información sobre Yáanal Ha' comentario-->
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-info-circle mr-2"></i>
                        ¿Qué es Yáanal Ha'?
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <h4 class="text-info">Sistema de Monitoreo de Inundaciones</h4>
                            <p class="lead">
                                <strong>Yáanal Ha'</strong> es un sistema integral diseñado para la prevención 
                                y gestión de emergencias por inundaciones en la región.
                            </p>
                            
                            <h5>Nuestra Misión:</h5>
                            <p>
                                Proteger a la comunidad mediante el monitoreo en tiempo real de condiciones 
                                climáticas críticas y proporcionar refugios seguros durante eventos de inundación.
                            </p>

                            <h5>Características Principales:</h5>
                            <ul>
                                <li><strong>Monitoreo en Tiempo Real:</strong> Seguimiento continuo de niveles de agua y condiciones meteorológicas</li>
                                <li><strong>Sistema de Alertas Tempranas:</strong> Notificaciones inmediatas ante riesgos inminentes</li>
                                <li><strong>Red de Refugios:</strong> Espacios seguros distribuidos estratégicamente</li>
                                <li><strong>Mapas Interactivos:</strong> Visualización geográfica de zonas de riesgo y refugios</li>
                                <li><strong>Reportes Comunitarios:</strong> Los ciudadanos pueden reportar situaciones de emergencia</li>
                            </ul>
                        </div>
                        <div class="col-md-4">
                            <div class="text-center">
                                <div class="bg-info p-4 rounded mb-3">
                                    <i class="fas fa-house-flood-water fa-3x text-white"></i>
                                    <h5 class="text-white mt-2">Refugios Disponibles</h5>
                                    <h2 class="text-white">15</h2>
                                </div>
                                
                                <div class="bg-success p-3 rounded mb-3">
                                    <i class="fas fa-users fa-2x text-white"></i>
                                    <h6 class="text-white mt-1">Capacidad Total</h6>
                                    <h4 class="text-white">2,500 personas</h4>
                                </div>

                                <div class="bg-warning p-3 rounded">
                                    <i class="fas fa-exclamation-triangle fa-2x text-white"></i>
                                    <h6 class="text-white mt-1">Zonas Monitoreadas</h6>
                                    <h4 class="text-white">8 zonas</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Información específica sobre Refugios -->
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-home mr-2"></i>
                        Sistema de Refugios
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h5>¿Qué son los refugios?</h5>
                            <p>
                                <strong>Los refugios </strong> son espacios designados y equipados 
                                para brindar protección temporal durante eventos de inundación. Cada refugio 
                                cuenta con:
                            </p>
                            <ul>
                                <li>Áreas seguras elevadas</li>
                                <li>Suministros de emergencia</li>
                                <li>Comunicaciones de emergencia</li>
                                <li>Personal capacitado</li>
                                <li>Primeros auxilios</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h5>¿Cómo acceder a un refugio?</h5>
                            <ol>
                                <li>Monitorea las alertas en tiempo real</li>
                                <li>Identifica el refugio más cercano en el mapa</li>
                                <li>Sigue las rutas de evacuación señalizadas</li>
                                <li>Lleva solo artículos esenciales</li>
                                <li>Regístrate al llegar al refugio</li>
                            </ol>
                            
                            <div class="alert alert-warning mt-3">
                                <i class="fas fa-exclamation-triangle mr-2"></i>
                                <strong>Importante:</strong> En caso de emergencia, sigue siempre 
                                las instrucciones del personal autorizado.
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-md-6">
                            <small class="text-muted">
                                <i class="fas fa-phone mr-1"></i>
                                Emergencias: 911
                            </small>
                        </div>
                        <div class="col-md-6 text-right">
                            <small class="text-muted">
                                <i class="fas fa-clock mr-1"></i>
                                Sistema activo 24/7
                            </small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Llamado a la acción -->
            <div class="card card-success">
                <div class="card-body text-center">
                    <h4 class="text-success">
                        <i class="fas fa-shield-alt mr-2"></i>
                        Tu Seguridad es Nuestra Prioridad
                    </h4>
                    <p class="mb-3">
                        <strong>Yáanal Ha'</strong> trabaja continuamente para mantener segura a nuestra comunidad. 
                        Mantente informado y preparado.
                    </p>
                    <div class="row">
                        <div class="col-md-4">
                            <a href="{{ route('mapa') }}" class="btn btn-outline-primary btn-block">
                                <i class="fas fa-map mr-2"></i>Ver Mapa
                            </a>
                        </div>
                        <div class="col-md-4">
                            <a href="#" class="btn btn-outline-info btn-block">
                                <i class="fas fa-bell mr-2"></i>Alertas
                            </a>
                        </div>
                        <div class="col-md-4">
                            <a href="#" class="btn btn-outline-warning btn-block">
                                <i class="fas fa-file-alt mr-2"></i>Reportar
                            </a>
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
    .card {
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        margin-bottom: 1.5rem;
    }
    .lead {
        font-size: 1.1rem;
        font-weight: 400;
    }
</style>
@endsection