@extends('layouts.admin')

@section('title', 'Levantar Reporte')

@section('page-title', 'Levantar Reporte')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('mapa') }}">Inicio</a></li>
    <li class="breadcrumb-item"><a href="{{ route('reportes.index') }}">Reportes</a></li>
    <li class="breadcrumb-item"><a href="{{ route('reportes.verReportes') }}">Ver mis Reportes</a></li>
  
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Formulario de Reporte</h3>
                <div class="card-tools">
                    <a href="{{ route('reportes.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-times"></i> Cancelar
                    </a>
                </div>
            </div>
            
            <div class="card-body p-0">
                <!-- Stepper Header -->
                <div class="stepper-header bg-white p-4 border-bottom">
                    <div class="stepper-progress-container position-relative">
                        <!-- Barra de progreso -->
                        <div class="stepper-track"></div>
                        <div class="stepper-progress" id="stepperProgress"></div>
                        
                        <!-- Círculos de pasos -->
                        <div class="stepper-steps">
                            <div class="stepper-step active" data-step="1">
                                <div class="stepper-circle">
                                    <span class="stepper-number">1</span>
                                    <i class="fas fa-check stepper-check"></i>
                                </div>
                                <div class="stepper-label">Tipo</div>
                            </div>
                            <div class="stepper-step" data-step="2">
                                <div class="stepper-circle">
                                    <span class="stepper-number">2</span>
                                    <i class="fas fa-check stepper-check"></i>
                                </div>
                                <div class="stepper-label">Ubicación</div>
                            </div>
                            <div class="stepper-step" data-step="3">
                                <div class="stepper-circle">
                                    <span class="stepper-number">3</span>
                                    <i class="fas fa-check stepper-check"></i>
                                </div>
                                <div class="stepper-label">Detalles</div>
                            </div>
                            <div class="stepper-step" data-step="4">
                                <div class="stepper-circle">
                                    <span class="stepper-number">4</span>
                                    <i class="fas fa-check stepper-check"></i>
                                </div>
                                <div class="stepper-label">Evidencia</div>
                            </div>
                            <div class="stepper-step" data-step="5">
                                <div class="stepper-circle">
                                    <span class="stepper-number">5</span>
                                    <i class="fas fa-check stepper-check"></i>
                                </div>
                                <div class="stepper-label">Confirmar</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Formulario -->
                <form id="reportForm" class="p-4">
                    @csrf
                    
                    <!-- Paso 1: Tipo de Reporte -->
                    <div class="step-content active" data-step="1">
                        <h4 class="mb-2">¿Qué deseas reportar?</h4>
                        <p class="text-muted mb-4">Selecciona el tipo de incidente que quieres reportar</p>
                        
                        <div class="alert alert-danger d-none" id="errorStep1"></div>
                        
                        <div class="row g-3">
                            <div class="col-md-4 col-sm-6">
                                <div class="report-type-card" data-type="inundacion">
                                    <div class="report-type-icon">💧</div>
                                    <div class="report-type-name">Inundación</div>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-6">
                                <div class="report-type-card" data-type="calle-bloqueada">
                                    <div class="report-type-icon">🚧</div>
                                    <div class="report-type-name">Calle Bloqueada</div>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-6">
                                <div class="report-type-card" data-type="refugio-lleno">
                                    <div class="report-type-icon">🏠</div>
                                    <div class="report-type-name">Refugio Lleno</div>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-6">
                                <div class="report-type-card" data-type="dano-infraestructura">
                                    <div class="report-type-icon">⚠️</div>
                                    <div class="report-type-name">Daño a Infraestructura</div>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-6">
                                <div class="report-type-card" data-type="persona-riesgo">
                                    <div class="report-type-icon">🆘</div>
                                    <div class="report-type-name">Persona en Riesgo</div>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-6">
                                <div class="report-type-card" data-type="otro">
                                    <div class="report-type-icon">📝</div>
                                    <div class="report-type-name">Otro</div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="tipo" id="inputTipo">
                        <input type="hidden" name="nivel_afectacion" id="inputNivelAfectacion">
                    </div>

                    <!-- Paso 2: Ubicación -->
                    <div class="step-content" data-step="2">
                        <h4 class="mb-2">Ubicación del incidente</h4>
                        <p class="text-muted mb-4">Selecciona la ubicación donde ocurrió el incidente</p>
                        
                        <div class="alert alert-danger d-none" id="errorStep2"></div>
                        
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <div class="location-option-card" data-location="current">
                                    <i class="fas fa-location-arrow fa-2x mb-3"></i>
                                    <h5>Mi ubicación actual</h5>
                                    <p class="text-muted mb-0">Usar mi ubicación GPS</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="location-option-card" data-location="map">
                                    <i class="fas fa-map-marked-alt fa-2x mb-3"></i>
                                    <h5>Seleccionar en mapa</h5>
                                    <p class="text-muted mb-0">Elegir ubicación manualmente</p>
                                </div>
                            </div>
                        </div>

                        <!-- Mapa (se muestra cuando se selecciona "map") -->
                        <div id="mapContainer" class="d-none">
                            <div id="reportMap" style="height: 400px; border-radius: 12px;"></div>
                            <p class="text-muted mt-2">
                                <i class="fas fa-info-circle"></i> Haz clic en el mapa para seleccionar la ubicación
                            </p>
                        </div>

                        <!-- Coordenadas seleccionadas -->
                        <div id="selectedLocation" class="alert alert-info d-none mt-3">
                            <strong>Ubicación seleccionada:</strong><br>
                            <span id="locationText"></span>
                        </div>

                        <input type="hidden" name="tipo_ubicacion" id="inputTipoUbicacion">
                        <input type="hidden" name="latitud" id="inputLatitud">
                        <input type="hidden" name="longitud" id="inputLongitud">
                    </div>

                    <!-- Paso 3: Detalles -->
                    <div class="step-content" data-step="3">
                        <h4 class="mb-2">Detalles del incidente</h4>
                        <p class="text-muted mb-4">Proporciona información detallada sobre el incidente</p>
                        
                        <div class="alert alert-danger d-none" id="errorStep3"></div>
                        
                        <div class="form-group mb-3">
                            <label for="inputTitulo">Título del reporte <span class="text-danger">*</span></label>
                            <input 
                                type="text" 
                                class="form-control" 
                                id="inputTitulo" 
                                name="titulo" 
                                maxlength="60"
                                placeholder="Ej: Inundación en la Avenida Principal">
                            <small class="form-text text-muted">
                                <span id="tituloCount">0</span>/60 caracteres
                            </small>
                        </div>

                        <div class="form-group mb-3">
                            <label for="inputDescripcion">Descripción <span class="text-danger">*</span></label>
                            <textarea 
                                class="form-control" 
                                id="inputDescripcion" 
                                name="descripcion" 
                                rows="5"
                                maxlength="500"
                                placeholder="Describe con detalle lo que está ocurriendo..."></textarea>
                            <small class="form-text text-muted">
                                <span id="descripcionCount">0</span>/500 caracteres
                            </small>
                        </div>

                        <div class="form-group mb-3">
                            <label>Nivel de urgencia</label>
                            <div class="urgency-options">
                                <div class="urgency-card" data-urgency="low">
                                    <span class="urgency-emoji">🟢</span>
                                    <span class="urgency-label">Baja</span>
                                </div>
                                <div class="urgency-card active" data-urgency="medium">
                                    <span class="urgency-emoji">🟡</span>
                                    <span class="urgency-label">Media</span>
                                </div>
                                <div class="urgency-card" data-urgency="high">
                                    <span class="urgency-emoji">🔴</span>
                                    <span class="urgency-label">Alta</span>
                                </div>
                            </div>
                            <input type="hidden" name="urgencia" id="inputUrgencia" value="medium">
                        </div>
                    </div>

                    <!-- Paso 4: Evidencia -->
                    <div class="step-content" data-step="4">
                        <h4 class="mb-2">Evidencia fotográfica</h4>
                        <p class="text-muted mb-4">Agrega hasta 3 fotos del incidente (opcional)</p>
                        
                        <div class="row g-3">
                            <div class="col-md-4" id="photoSlot1">
                                <div class="photo-upload-card">
                                    <i class="fas fa-camera fa-2x mb-2"></i>
                                    <p class="mb-2">Agregar foto</p>
                                    <input type="file" class="photo-input" accept="image/*" data-slot="1">
                                </div>
                            </div>
                            <div class="col-md-4" id="photoSlot2">
                                <div class="photo-upload-card">
                                    <i class="fas fa-camera fa-2x mb-2"></i>
                                    <p class="mb-2">Agregar foto</p>
                                    <input type="file" class="photo-input" accept="image/*" data-slot="2">
                                </div>
                            </div>
                            <div class="col-md-4" id="photoSlot3">
                                <div class="photo-upload-card">
                                    <i class="fas fa-camera fa-2x mb-2"></i>
                                    <p class="mb-2">Agregar foto</p>
                                    <input type="file" class="photo-input" accept="image/*" data-slot="3">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Paso 5: Resumen -->
                    <div class="step-content" data-step="5">
                        <h4 class="mb-2">Confirma tu reporte</h4>
                        <p class="text-muted mb-4">Revisa la información antes de enviar</p>
                        
                        <div class="card border-0 shadow-sm">
                            <div class="card-body">
                                <div class="summary-item">
                                    <strong>Tipo de incidente:</strong>
                                    <span id="summaryTipo"></span>
                                </div>
                                <div class="summary-item">
                                    <strong>Ubicación:</strong>
                                    <span id="summaryUbicacion"></span>
                                </div>
                                <div class="summary-item">
                                    <strong>Título:</strong>
                                    <span id="summaryTitulo"></span>
                                </div>
                                <div class="summary-item">
                                    <strong>Urgencia:</strong>
                                    <span id="summaryUrgencia"></span>
                                </div>
                                <div class="summary-item">
                                    <strong>Fotos adjuntas:</strong>
                                    <span id="summaryFotos"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Botones de navegación -->
            <div class="card-footer bg-white border-top">
                <div class="d-flex justify-content-between">
                    <button type="button" class="btn btn-secondary" id="btnPrevious" style="display: none;">
                        <i class="fas fa-arrow-left"></i> Anterior
                    </button>
                    <button type="button" class="btn btn-primary ml-auto" id="btnNext">
                        Siguiente <i class="fas fa-arrow-right"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de éxito -->
<div class="modal fade" id="modalExito" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-body text-center p-5">
                <div class="success-checkmark mb-4">
                    <i class="fas fa-check-circle fa-5x text-success"></i>
                </div>
                <h4 class="mb-3">¡Reporte enviado con éxito!</h4>
                <p class="text-muted mb-4">Tu reporte ha sido registrado y será atendido a la brevedad.</p>
                <button type="button" class="btn btn-primary" onclick="window.location.href='{{ route('reportes.index') }}'">
                    Ver mis reportes
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
    /* Stepper Styles */
    .stepper-header {
        position: relative;
    }
    
    .stepper-progress-container {
        padding: 20px 0;
    }
    
    .stepper-track {
        position: absolute;
        top: 50%;
        left: 16px;
        right: 16px;
        height: 2px;
        background: #E2E8F0;
        transform: translateY(-50%);
        z-index: 0;
    }
    
    .stepper-progress {
        position: absolute;
        top: 50%;
        left: 16px;
        height: 2px;
        background: linear-gradient(90deg, #0891B2, #06B6D4);
        transform: translateY(-50%);
        transition: width 0.3s ease;
        z-index: 1;
        width: 0%;
    }
    
    .stepper-steps {
        display: flex;
        justify-content: space-between;
        position: relative;
        z-index: 2;
    }
    
    .stepper-step {
        display: flex;
        flex-direction: column;
        align-items: center;
        flex: 1;
    }
    
    .stepper-circle {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: white;
        border: 2px solid #E2E8F0;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        position: relative;
    }
    
    .stepper-number {
        font-size: 14px;
        color: #94A3B8;
        transition: color 0.3s ease;
    }
    
    .stepper-check {
        display: none;
        color: white;
        font-size: 14px;
    }
    
    .stepper-label {
        margin-top: 8px;
        font-size: 11px;
        color: #94A3B8;
        transition: color 0.3s ease;
    }
    
    .stepper-step.active .stepper-circle {
        background: #0891B2;
        border-color: #0891B2;
    }
    
    .stepper-step.active .stepper-number {
        color: white;
    }
    
    .stepper-step.active .stepper-label {
        color: #0891B2;
    }
    
    .stepper-step.completed .stepper-circle {
        background: #10B981;
        border-color: #10B981;
    }
    
    .stepper-step.completed .stepper-number {
        display: none;
    }
    
    .stepper-step.completed .stepper-check {
        display: block;
    }

    /* Step Content */
    .step-content {
        display: none;
        animation: fadeIn 0.3s ease;
    }
    
    .step-content.active {
        display: block;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; transform: translateX(20px); }
        to { opacity: 1; transform: translateX(0); }
    }

    /* Report Type Cards */
    .report-type-card {
        background: white;
        border: 2px solid #E2E8F0;
        border-radius: 16px;
        padding: 30px 20px;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s ease;
        height: 150px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }
    
    .report-type-card:hover {
        border-color: #0891B2;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(8, 145, 178, 0.15);
    }
    
    .report-type-card.selected {
        background: #F0FDFA;
        border-color: #0891B2;
        box-shadow: 0 4px 12px rgba(8, 145, 178, 0.15);
    }
    
    .report-type-icon {
        font-size: 36px;
        margin-bottom: 12px;
    }
    
    .report-type-card.selected .report-type-icon {
        background: linear-gradient(135deg, #0891B2, #06B6D4);
        padding: 12px;
        border-radius: 12px;
    }
    
    .report-type-name {
        font-weight: 600;
        color: #334155;
    }

    /* Location Cards */
    .location-option-card {
        background: white;
        border: 2px solid #E2E8F0;
        border-radius: 16px;
        padding: 40px 20px;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s ease;
        min-height: 200px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }
    
    .location-option-card:hover {
        border-color: #0891B2;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(8, 145, 178, 0.15);
    }
    
    .location-option-card.selected {
        background: #F0FDFA;
        border-color: #0891B2;
        box-shadow: 0 4px 12px rgba(8, 145, 178, 0.15);
    }
    
    .location-option-card i {
        color: #64748B;
        transition: color 0.3s ease;
    }
    
    .location-option-card.selected i {
        color: #0891B2;
    }

    /* Urgency Cards */
    .urgency-options {
        display: flex;
        gap: 12px;
    }
    
    .urgency-card {
        flex: 1;
        background: white;
        border: 2px solid #E2E8F0;
        border-radius: 12px;
        padding: 20px;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .urgency-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }
    
    .urgency-card.active {
        background: #F0FDFA;
        border-color: #0891B2;
    }
    
    .urgency-emoji {
        font-size: 32px;
        display: block;
        margin-bottom: 8px;
    }
    
    .urgency-label {
        font-weight: 600;
        color: #334155;
    }

    /* Photo Upload Cards */
    .photo-upload-card {
        background: white;
        border: 2px dashed #E2E8F0;
        border-radius: 12px;
        padding: 40px 20px;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s ease;
        min-height: 200px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        position: relative;
        overflow: hidden;
    }
    
    .photo-upload-card:hover {
        border-color: #0891B2;
        background: #F8FAFC;
    }
    
    .photo-upload-card i {
        color: #94A3B8;
    }
    
    .photo-upload-card.has-photo {
        border-style: solid;
        border-color: #10B981;
        padding: 0;
    }
    
    .photo-upload-card img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 10px;
    }
    
    .photo-input {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        opacity: 0;
        cursor: pointer;
    }
    
    .photo-remove {
        position: absolute;
        top: 8px;
        right: 8px;
        background: rgba(239, 68, 68, 0.9);
        color: white;
        border: none;
        border-radius: 50%;
        width: 28px;
        height: 28px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        z-index: 10;
    }

    /* Summary */
    .summary-item {
        padding: 12px 0;
        border-bottom: 1px solid #E2E8F0;
    }
    
    .summary-item:last-child {
        border-bottom: none;
    }
    
    .summary-item strong {
        display: inline-block;
        min-width: 150px;
        color: #64748B;
    }
</style>
@endpush

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="{{ asset('js/reportes-form.js') }}"></script>
@endpush