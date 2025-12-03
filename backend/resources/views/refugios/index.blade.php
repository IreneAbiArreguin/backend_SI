@extends('layouts.admin')

@section('title', 'Refugios')

@section('page-title', 'Lista de Refugios')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('mapa') }}">Inicio</a></li>
    <li class="breadcrumb-item active">Refugios</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Refugios Disponibles</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-primary btn-sm" id="recargarRefugios">
                        <i class="fas fa-sync-alt"></i> Recargar
                    </button>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <!-- Loading spinner -->
                <div id="loading" class="text-center py-5">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Cargando...</span>
                    </div>
                    <p class="mt-2">Cargando refugios...</p>
                </div>

                <!-- Error message -->
                <div id="error" class="alert alert-danger" style="display: none;">
                    <i class="fas fa-exclamation-triangle"></i>
                    <span id="errorMessage"></span>
                </div>

                <!-- Tabla de refugios -->
                <div id="tablaRefugios" style="display: none;">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Dirección</th>
                                    <th>Capacidad</th>
                                    <th>Disponible</th>
                                    <th>Teléfono</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="refugiosBody">
                                <!-- Los datos se cargarán aquí dinámicamente -->
                            </tbody>
                        </table>
                    </div>

                    <!-- Mensaje si no hay datos -->
                    <div id="noData" class="text-center py-4" style="display: none;">
                        <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                        <p class="text-muted">No hay refugios registrados</p>
                    </div>
                </div>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
</div>

<!-- Modal para ver detalles -->
<div class="modal fade" id="modalDetalles" tabindex="-1" aria-labelledby="modalDetallesLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title" id="modalDetallesLabel">Detalles del Refugio</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body" id="detallesBody">
                <!-- Detalles se cargarán aquí -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // URL de tu API
    const API_URL = '/api/refugios';

    // Cargar refugios al iniciar la página
    document.addEventListener('DOMContentLoaded', function() {
        cargarRefugios();
        
        // Botón recargar
        document.getElementById('recargarRefugios').addEventListener('click', function() {
            cargarRefugios();
        });
    });

    // Función para cargar refugios desde la API
    function cargarRefugios() {
        document.getElementById('loading').style.display = 'block';
        document.getElementById('error').style.display = 'none';
        document.getElementById('tablaRefugios').style.display = 'none';

        fetch(API_URL, {
            headers: {
                'Accept': 'application/json'
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Error en la red: ' + response.status);
            }
            return response.json();
        })
        .then(data => {
            document.getElementById('loading').style.display = 'none';
            document.getElementById('tablaRefugios').style.display = 'block';

            // Asumimos que la API devuelve un array directo
            const refugios = Array.isArray(data) ? data : (data.data || []);

            if (!refugios || refugios.length === 0) {
                document.getElementById('noData').style.display = 'block';
                document.getElementById('refugiosBody').innerHTML = '';
            } else {
                document.getElementById('noData').style.display = 'none';
                mostrarRefugios(refugios);
            }
        })
        .catch(error => {
            console.error('Error al cargar refugios:', error);
            document.getElementById('loading').style.display = 'none';
            document.getElementById('error').style.display = 'block';
            document.getElementById('errorMessage').textContent = 'No se pudieron cargar los refugios. ' + (error.message || '');
        });
    }

    // Función para mostrar refugios en la tabla
    function mostrarRefugios(refugios) {
        const tbody = document.getElementById('refugiosBody');
        tbody.innerHTML = '';

        refugios.forEach(refugio => {
            const disponible = refugio.capacidad_total - (refugio.capacidad_actual || 0);
            const estadoCodigo = (refugio.estado?.codigo || 'Desconocido').toLowerCase();
            
            let estadoBadge = '';
            switch(estadoCodigo) {
                case 'disponible':
                    estadoBadge = `<span class="badge bg-success">${refugio.estado.codigo}</span>`;
                    break;
                case 'ocupado':
                    estadoBadge = `<span class="badge bg-warning text-dark">${refugio.estado.codigo}</span>`;
                    break;
                case 'lleno':
                    estadoBadge = `<span class="badge bg-danger">${refugio.estado.codigo}</span>`;
                    break;
                case 'cerrado':
                case 'mantenimiento':
                    estadoBadge = `<span class="badge bg-secondary">${refugio.estado.codigo}</span>`;
                    break;
                default:
                    estadoBadge = `<span class="badge bg-info">${refugio.estado.codigo || 'N/A'}</span>`;
            }

            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td>${refugio.id_refugio || ''}</td>
                <td><strong>${refugio.nombre || 'Sin nombre'}</strong></td>
                <td>${refugio.direccion || 'Sin dirección'}</td>
                <td>${refugio.capacidad_total || 0}</td>
                <td>${disponible >= 0 ? disponible : 'N/A'}</td>
                <td>${refugio.telefono_contacto || 'N/A'}</td>
                <td>${estadoBadge}</td>
                <td>
                    <button class="btn btn-info btn-sm" onclick="verDetalles(${refugio.id_refugio})">
                        <i class="fas fa-eye"></i> Ver
                    </button>
                </td>
            `;
            tbody.appendChild(tr);
        });
    }

    // Función para ver detalles de un refugio
    function verDetalles(id) {
        if (!id) {
            alert('ID de refugio no válido');
            return;
        }

        fetch(`${API_URL}/${id}`, {
            headers: {
                'Accept': 'application/json'
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Refugio no encontrado');
            }
            return response.json();
        })
        .then(refugio => {
            const disponible = refugio.capacidad_total - (refugio.capacidad_actual || 0);
            const municipio = refugio.municipio?.nombre || 'N/A';
            const estadoCodigo = refugio.estado?.codigo || 'N/A';
            const estadoDescripcion = refugio.estado?.descripcion || '';

            // Badge para estado
            let estadoBadgeClass = 'bg-info';
            switch(estadoCodigo.toLowerCase()) {
                case 'disponible':
                    estadoBadgeClass = 'bg-success';
                    break;
                case 'ocupado':
                    estadoBadgeClass = 'bg-warning text-dark';
                    break;
                case 'lleno':
                    estadoBadgeClass = 'bg-danger';
                    break;
                case 'cerrado':
                case 'mantenimiento':
                    estadoBadgeClass = 'bg-secondary';
                    break;
            }

            // Servicios
            let serviciosHTML = '';
            if (refugio.servicios && refugio.servicios.length > 0) {
                serviciosHTML = `
                    <div class="col-12 mt-3">
                        <p><strong>Servicios:</strong></p>
                        <ul class="mb-0">
                            ${refugio.servicios.map(s => `
                                <li>
                                    ${s.nombre || 'Servicio'}
                                    ${s.pivot?.disponible ? '<span class="badge bg-success ms-2">Disponible</span>' : '<span class="badge bg-secondary ms-2">No disponible</span>'}
                                </li>
                            `).join('')}
                        </ul>
                    </div>
                `;
            }

            // Coordenadas
            const coordenadasHTML = refugio.latitud && refugio.longitud ? `
                <div class="col-12 mt-3">
                    <p><strong>Coordenadas:</strong></p>
                    <p>Lat: ${refugio.latitud}, Lng: ${refugio.longitud}</p>
                    <a href="https://www.google.com/maps?q=${refugio.latitud},${refugio.longitud}" 
                       target="_blank" class="btn btn-sm btn-success">
                        <i class="fas fa-map-marker-alt"></i> Ver en Google Maps
                    </a>
                </div>
            ` : '';

            document.getElementById('detallesBody').innerHTML = `
                <div class="row">
                    <div class="col-12">
                        <h5>${refugio.nombre || 'Refugio'}</h5>
                        <hr>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Dirección:</strong><br>${refugio.direccion || 'Sin dirección'}</p>
                        <p><strong>Municipio:</strong> ${municipio}</p>
                        <p><strong>Teléfono:</strong> ${refugio.telefono_contacto || 'N/A'}</p>
                        <p><strong>Responsable:</strong> ${refugio.responsable || 'N/A'}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Capacidad Total:</strong> ${refugio.capacidad_total || 0}</p>
                        <p><strong>Capacidad Actual:</strong> ${refugio.capacidad_actual || 0}</p>
                        <p><strong>Disponible:</strong> ${disponible >= 0 ? disponible : 'N/A'}</p>
                        <p><strong>Estado:</strong> <span class="badge ${estadoBadgeClass}">${estadoCodigo}</span></p>
                        ${estadoDescripcion ? `<p class="text-muted small mb-0">${estadoDescripcion}</p>` : ''}
                    </div>
                    ${serviciosHTML}
                    ${coordenadasHTML}
                </div>
            `;

            // ✅ ABRIR MODAL CON BOOTSTRAP 5 (SIN JQUERY)
            const modal = new bootstrap.Modal(document.getElementById('modalDetalles'));
            modal.show();
        })
        .catch(error => {
            console.error('Error al cargar detalles:', error);
            document.getElementById('detallesBody').innerHTML = `
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-triangle"></i>
                    Error al cargar los detalles: ${error.message || 'Desconocido'}
                </div>
            `;
            const modal = new bootstrap.Modal(document.getElementById('modalDetalles'));
            modal.show();
        });
    }
</script>
@endpush