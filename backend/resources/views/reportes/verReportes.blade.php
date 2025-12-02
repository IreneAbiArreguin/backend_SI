El balde es este 
@extends('layouts.admin')

@section('title', 'Mis Reportes de Inundación')

@section('page-title', 'Mis Reportes')

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
                <h3 class="card-title">Mis Reportes de Inundación</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalCrearReporte">
                        <i class="fas fa-plus"></i> Nuevo Reporte
                    </button>
                    <button type="button" class="btn btn-primary btn-sm ml-2" onclick="cargarReportes()">
                        <i class="fas fa-sync-alt"></i> Recargar
                    </button>
                </div>
            </div>

            <div class="card-body">
                <!-- Loading -->
                <div id="loading" class="text-center py-5">
                    <div class="spinner-border text-primary" role="status"></div>
                    <p class="mt-2">Cargando tus reportes...</p>
                </div>

                <!-- Error -->
                <div id="error" class="alert alert-danger" style="display: none;">
                    <i class="fas fa-exclamation-triangle"></i>
                    <span id="errorMessage"></span>
                </div>

                <!-- Tabla -->
                <div id="tablaReportes" style="display: none;">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Fecha</th>
                                    <th>Ubicación</th>
                                    <th>Nivel Afectación</th>
                                    <th>Prioridad</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="reportesBody"></tbody>
                        </table>
                    </div>

                    <div id="noData" class="text-center py-5" style="display: none;">
                        <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                        <p class="text-muted">Aún no has creado ningún reporte</p>
                        <button class="btn btn-success mt-3" data-toggle="modal" data-target="#modalCrearReporte">
                            <i class="fas fa-plus"></i> Crear mi primer reporte
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Crear Reporte -->
<div class="modal fade" id="modalCrearReporte">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="formCrearReporte">
                <div class="modal-header bg-success">
                    <h5 class="modal-title">Reportar Inundación</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Calle Principal *</label>
                                <input type="text" name="calle_principal" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Entre calles (opcional)</label>
                                <input type="text" name="cruzamiento1" class="form-control" placeholder="Calle 1">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="text" name="cruzamiento2" class="form-control" placeholder="Calle 2">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Colonia *</label>
                                <input type="text" name="colonia" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nivel de Afectación *</label>
                                <select name="nivel_afectacion" class="form-control" required>
                                    <option value="">Seleccionar...</option>
                                    <option value="Leve">Leve (agua en calle)</option>
                                    <option value="Moderada">Moderada (ingreso a viviendas)</option>
                                    <option value="Severa">Severa (imposible transitar)</option>
                                    <option value="Crítica">Crítica (personas atrapadas)</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Prioridad (según tu percepción)</label>
                                <select name="prioridad" class="form-control">
                                    <option value="3">Baja</option>
                                    <option value="2" selected>Media</option>
                                    <option value="1">Alta</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label>Descripción detallada (opcional)</label>
                                <textarea name="descripcion" class="form-control" rows="3" placeholder="Ej: El agua llega a las rodillas, hay vehículos varados..."></textarea>
                            </div>
                        </div>
                        <div class="col-12">
                            <p class="text-muted"><small>
                                <i class="fas fa-info-circle"></i> 
                                Para desarrollo: Usaremos coordenadas de prueba para agilizar el proceso
                            </small></p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-paper-plane"></i> Enviar Reporte
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal para ver detalles del reporte -->
<div class="modal fade" id="modalDetallesReporte" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title">Detalles del Reporte</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body" id="detallesReporteBody">
                <!-- Aquí se cargarán los detalles -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    const API_GET_URL = '/api/reportes-inundaciones';
    const API_POST_URL = '/api/reportes-inundaciones';
    
    // ⚡ COORDENADAS POR DEFECTO PARA DESARROLLO (Mérida centro)
    const COORDENADAS_DEFAULT = { 
        lat: 20.967370, 
        lng: -89.623678,
        fuente: 'desarrollo'
    };

    document.addEventListener('DOMContentLoaded', function() {
        cargarReportes();
    });

    function cargarReportes() {
        document.getElementById('loading').style.display = 'block';
        document.getElementById('tablaReportes').style.display = 'none';
        document.getElementById('error').style.display = 'none';

        fetch(API_GET_URL)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Error en la respuesta del servidor');
                }
                return response.json();
            })
            .then(res => {
                document.getElementById('loading').style.display = 'none';
                document.getElementById('tablaReportes').style.display = 'block';

                const reportes = res.data || res;

                if (!reportes || reportes.length === 0) {
                    document.getElementById('noData').style.display = 'block';
                    document.getElementById('reportesBody').innerHTML = '';
                    return;
                }

                document.getElementById('noData').style.display = 'none';
                mostrarReportes(reportes);
            })
            .catch(err => {
                document.getElementById('loading').style.display = 'none';
                document.getElementById('error').style.display = 'block';
                document.getElementById('errorMessage').textContent = 'Error al cargar tus reportes: ' + err.message;
                console.error('Error:', err);
            });
    }

    function mostrarReportes(reportes) {
        const tbody = document.getElementById('reportesBody');
        tbody.innerHTML = '';

        reportes.forEach(r => {
            const prioridadBadge = r.prioridad == 1 ? 'badge-danger' : r.prioridad == 2 ? 'badge-warning' : 'badge-success';
            const prioridadTexto = r.prioridad == 1 ? 'Alta' : r.prioridad == 2 ? 'Media' : 'Baja';

            const estadoBadge = r.estado_reporte?.nombre?.toLowerCase().includes('pendiente') ? 'badge-warning' :
                               r.estado_reporte?.nombre?.toLowerCase().includes('verificado') ? 'badge-success' :
                               r.estado_reporte?.nombre?.toLowerCase().includes('rechazado') ? 'badge-danger' : 'badge-info';

            const ubicacion = [r.calle_principal, r.colonia].filter(Boolean).join(', ') || 'Sin ubicación';

            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td>#${r.id_reporte}</td>
                <td>${new Date(r.fecha_suceso || r.created_at).toLocaleString('es-MX')}</td>
                <td>${ubicacion}</td>
                <td>${r.nivel_afectacion || 'No especificado'}</td>
                <td><span class="badge ${prioridadBadge}">${prioridadTexto}</span></td>
                <td><span class="badge ${estadoBadge}">${r.estado_reporte?.nombre || 'Pendiente'}</span></td>
                <td>
                    <button class="btn btn-info btn-sm" onclick="verDetalle(${r.id_reporte})">
                        <i class="fas fa-eye"></i>
                    </button>
                </td>
            `;
            tbody.appendChild(tr);
        });
    }

    // ⚡ IMPLEMENTACIÓN OPTIMIZADA - MÁS RÁPIDA
    document.getElementById('formCrearReporte').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const calle = this.querySelector('[name="calle_principal"]').value;
        const colonia = this.querySelector('[name="colonia"]').value;
        
        if (!calle || !colonia) {
            Swal.fire('Error', 'Por favor ingresa calle principal y colonia', 'error');
            return;
        }

        // Mostrar loading inmediatamente
        const submitBtn = this.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Procesando...';
        submitBtn.disabled = true;

        // ⚡ ESTRATEGIA RÁPIDA: Usar coordenadas por defecto inmediatamente
        // Para desarrollo, comentar esta línea si quieres usar geolocalización real
        usarCoordenadasRapidas(calle, colonia, this, submitBtn, originalText);
        
        // ⚡ Para producción, descomenta esta línea:
        // obtenerUbicacionOptimizada(calle, colonia, this, submitBtn, originalText);
    });

    // ⚡ MÉTODO RÁPIDO: Coordenadas por defecto (instantáneo)
    function usarCoordenadasRapidas(calle, colonia, form, submitBtn, originalText) {
        console.log('⚡ Usando coordenadas rápidas para desarrollo');
        
        // Pequeño delay para simular procesamiento (opcional)
        setTimeout(() => {
            enviarReporteConCoordenadas(COORDENADAS_DEFAULT, form, submitBtn, originalText);
        }, 500);
    }

    // ⚡ MÉTODO OPTIMIZADO: Para producción
    function obtenerUbicacionOptimizada(calle, colonia, form, submitBtn, originalText) {
        // Intentar geolocalización RÁPIDA primero
        obtenerUbicacionRapida()
            .then(position => {
                enviarReporteConCoordenadas({
                    lat: position.coords.latitude,
                    lng: position.coords.longitude,
                    fuente: 'geolocalización'
                }, form, submitBtn, originalText);
            })
            .catch(() => {
                // Si falla, usar geocoding con timeout
                geocodeAddressRapido(calle + ', ' + colonia, form, submitBtn, originalText);
            });
    }

    // ⚡ GEOLOCALIZACIÓN RÁPIDA
    function obtenerUbicacionRapida() {
        return new Promise((resolve, reject) => {
            if (!navigator.geolocation) {
                reject(new Error('Geolocalización no soportada'));
                return;
            }

            // ⚡ Configuración rápida
            const options = {
                timeout: 3000,           // Solo 3 segundos
                maximumAge: 300000,      // Cache de 5 minutos
                enableHighAccuracy: false // Más rápido
            };

            navigator.geolocation.getCurrentPosition(resolve, reject, options);
        });
    }

    // ⚡ GEOCODING RÁPIDO CON TIMEOUT
    function geocodeAddressRapido(direccion, form, submitBtn, originalText) {
        const loadingAlert = Swal.fire({
            title: 'Buscando ubicación...',
            html: `
                <div class="text-center">
                    <div class="spinner-border text-primary mb-3"></div>
                    <p class="mb-1"><strong>${direccion}</strong></p>
                    <small class="text-muted">Usando servicio de mapas</small>
                </div>
            `,
            allowOutsideClick: false,
            showConfirmButton: false,
            timer: 5000 // Auto-cierre en 5 segundos
        });

        // ⚡ Timeout más corto
        const timeoutPromise = new Promise((_, reject) => 
            setTimeout(() => reject(new Error('Tiempo agotado')), 5000)
        );

        const geocodingPromise = fetch(
            `https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(direccion + ', Yucatán, México')}&limit=1`
        ).then(response => response.json());

        Promise.race([geocodingPromise, timeoutPromise])
            .then(data => {
                loadingAlert.then(alert => alert.close());
                
                if (data && data.length > 0) {
                    enviarReporteConCoordenadas({
                        lat: parseFloat(data[0].lat),
                        lng: parseFloat(data[0].lon),
                        fuente: 'geocoding'
                    }, form, submitBtn, originalText);
                } else {
                    // ⚡ Fallback a coordenadas por defecto
                    console.log('Geocoding falló, usando coordenadas por defecto');
                    enviarReporteConCoordenadas(COORDENADAS_DEFAULT, form, submitBtn, originalText);
                }
            })
            .catch(error => {
                loadingAlert.then(alert => alert.close());
                console.log('Error en geocoding:', error);
                // ⚡ Fallback a coordenadas por defecto
                enviarReporteConCoordenadas(COORDENADAS_DEFAULT, form, submitBtn, originalText);
            });
    }

    // ⚡ FUNCIÓN PARA ENVIAR REPORTE (optimizada)
    function enviarReporteConCoordenadas(coords, form, submitBtn, originalText) {
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Enviando...';
        
        const formData = new FormData(form);
        formData.append('latitud', coords.lat);
        formData.append('longitud', coords.lng);
        formData.append('metodo_origen', 'web_usuario');
        formData.append('fuente_ubicacion', coords.fuente);
        formData.append('estado_reporte_id', 1);

        fetch(API_POST_URL, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Error en el servidor: ' + response.status);
            }
            return response.json();
        })
        .then(res => {
            // Restaurar botón
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;

            if (res.success) {
                $('#modalCrearReporte').modal('hide');
                form.reset();
                cargarReportes();
                Swal.fire({
                    icon: 'success',
                    title: '¡Reporte enviado!',
                    text: `Ubicación obtenida por: ${coords.fuente}`,
                    confirmButtonText: 'Aceptar',
                    timer: 3000
                });
            } else {
                Swal.fire('Error', res.message || 'No se pudo enviar el reporte', 'error');
            }
        })
        .catch((error) => {
            // Restaurar botón
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
            
            console.error('Error:', error);
            Swal.fire('Error', 'Error de conexión: ' + error.message, 'error');
        });
    }

        // Función para ver detalles de un reporte en modal
    function verDetalle(id) {
        fetch(`${API_GET_URL}/${id}`)
            .then(response => {
                if (!response.ok) throw new Error('Error al cargar el reporte');
                return response.json();
            })
            .then(res => {
                const reporte = res.data || res;
                
                // Formatear fecha
                const fecha = reporte.fecha_suceso || reporte.created_at;
                const fechaFormateada = new Date(fecha).toLocaleString('es-MX');
                
                // Estado del reporte
                const estado = reporte.estado_reporte?.nombre || 'Pendiente';
                let estadoBadge = 'badge-info';
                if (estado.toLowerCase().includes('pendiente')) estadoBadge = 'badge-warning';
                else if (estado.toLowerCase().includes('verificado')) estadoBadge = 'badge-success';
                else if (estado.toLowerCase().includes('rechazado')) estadoBadge = 'badge-danger';
                
                // Nivel de afectación
                const nivel = reporte.nivel_afectacion || 'No especificado';
                
                // Prioridad
                const prioridadTexto = reporte.prioridad == 1 ? 'Alta' : 
                                    reporte.prioridad == 2 ? 'Media' : 'Baja';
                const prioridadBadge = reporte.prioridad == 1 ? 'badge-danger' : 
                                    reporte.prioridad == 2 ? 'badge-warning' : 'badge-success';
                
                // Ubicación
                const ubicacion = [reporte.calle_principal, reporte.colonia].filter(Boolean).join(', ') || 'Sin ubicación';
                
                // Coordenadas
                const coordenadas = reporte.latitud && reporte.longitud ? 
                    `<p><strong>Coordenadas:</strong> ${reporte.latitud}, ${reporte.longitud}</p>
                    <a href="https://www.google.com/maps?q=${reporte.latitud},${reporte.longitud}" 
                        target="_blank" class="btn btn-sm btn-success">
                        <i class="fas fa-map-marker-alt"></i> Ver en Google Maps
                    </a>` : '';
                
                document.getElementById('detallesReporteBody').innerHTML = `
                    <div class="row">
                        <div class="col-12">
                            <h5>Reporte #${reporte.id_reporte}</h5>
                            <hr>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Fecha:</strong> ${fechaFormateada}</p>
                            <p><strong>Ubicación:</strong> ${ubicacion}</p>
                            <p><strong>Nivel Afectación:</strong> ${nivel}</p>
                            <p><strong>Prioridad:</strong> <span class="badge ${prioridadBadge}">${prioridadTexto}</span></p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Estado:</strong> <span class="badge ${estadoBadge}">${estado}</span></p>
                            <p><strong>Método Origen:</strong> ${reporte.metodo_origen || 'N/A'}</p>
                            <p><strong>Fuente Ubicación:</strong> ${reporte.fuente_ubicacion || 'N/A'}</p>
                        </div>
                        <div class="col-12 mt-3">
                            <p><strong>Descripción:</strong></p>
                            <p>${reporte.descripcion || '<em>Sin descripción</em>'}</p>
                        </div>
                        ${coordenadas}
                    </div>
                `;
                $('#modalDetallesReporte').modal('show');
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire('Error', 'No se pudieron cargar los detalles del reporte', 'error');
            });
    }

    console.log('🔧 Modo: DESARROLLO - Usando coordenadas rápidas');
    console.log('📍 Coordenadas por defecto:', COORDENADAS_DEFAULT);
    console.log('💡 Para producción, cambiar a obtenerUbicacionOptimizada()');
</script>
@endpush