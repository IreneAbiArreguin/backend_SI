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
                        <span class="sr-only">Cargando...</span>
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
<div class="modal fade" id="modalDetalles" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title">Detalles del Refugio</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body" id="detallesBody">
                <!-- Detalles se cargarán aquí -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
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
    });

    // Botón recargar
    document.getElementById('recargarRefugios').addEventListener('click', function() {
        cargarRefugios();
    });

    // Función para cargar refugios desde la API
    function cargarRefugios() {
        document.getElementById('loading').style.display = 'block';
        document.getElementById('error').style.display = 'none';
        document.getElementById('tablaRefugios').style.display = 'none';

        fetch(API_URL)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Error al cargar los datos');
                }
                return response.json();
            })
            .then(response => {
                // Ocultar loading
                document.getElementById('loading').style.display = 'none';
                document.getElementById('tablaRefugios').style.display = 'block';

                // Tu API devuelve {success: true, data: [...]}
                const refugios = response.data || response;

                // Verificar si hay datos
                if (!refugios || refugios.length === 0) {
                    document.getElementById('noData').style.display = 'block';
                    document.getElementById('refugiosBody').innerHTML = '';
                } else {
                    document.getElementById('noData').style.display = 'none';
                    mostrarRefugios(refugios);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                document.getElementById('loading').style.display = 'none';
                document.getElementById('error').style.display = 'block';
                document.getElementById('errorMessage').textContent = 'No se pudieron cargar los refugios. ' + error.message;
            });
    }

    // Función para mostrar refugios en la tabla
    function mostrarRefugios(refugios) {
        const tbody = document.getElementById('refugiosBody');
        tbody.innerHTML = '';

        refugios.forEach(refugio => {
            const tr = document.createElement('tr');
            
            // Calcular disponible
            const disponible = refugio.capacidad_total - (refugio.capacidad_actual || 0);
            
            // Badge para estado - usa 'codigo' en lugar de 'nombre'
            const estadoCodigo = refugio.estado?.codigo || 'Desconocido';
            
            // Badge según el código del estado
            let estadoBadge = '';
            switch(estadoCodigo.toLowerCase()) {
                case 'disponible':
                    estadoBadge = `<span class="badge badge-success">${estadoCodigo}</span>`;
                    break;
                case 'ocupado':
                    estadoBadge = `<span class="badge badge-warning">${estadoCodigo}</span>`;
                    break;
                case 'lleno':
                    estadoBadge = `<span class="badge badge-danger">${estadoCodigo}</span>`;
                    break;
                case 'cerrado':
                case 'mantenimiento':
                    estadoBadge = `<span class="badge badge-secondary">${estadoCodigo}</span>`;
                    break;
                default:
                    estadoBadge = `<span class="badge badge-info">${estadoCodigo}</span>`;
            }

            tr.innerHTML = `
                <td>${refugio.id_refugio}</td>
                <td><strong>${refugio.nombre}</strong></td>
                <td>${refugio.direccion}</td>
                <td>${refugio.capacidad_total}</td>
                <td>${disponible}</td>
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
        fetch(`${API_URL}/${id}`)
            .then(response => response.json())
            .then(response => {
                const refugio = response.data || response;
                const detallesBody = document.getElementById('detallesBody');
                
                const disponible = refugio.capacidad_total - (refugio.capacidad_actual || 0);
                const municipio = refugio.municipio?.nombre || 'N/A';
                
                // CORREGIDO: usa 'codigo' y 'descripcion'
                const estadoCodigo = refugio.estado?.codigo || 'N/A';
                const estadoDescripcion = refugio.estado?.descripcion || '';
                
                // Badge según el código del estado
                let estadoBadgeClass = 'badge-info';
                switch(estadoCodigo.toLowerCase()) {
                    case 'disponible':
                        estadoBadgeClass = 'badge-success';
                        break;
                    case 'ocupado':
                        estadoBadgeClass = 'badge-warning';
                        break;
                    case 'lleno':
                        estadoBadgeClass = 'badge-danger';
                        break;
                    case 'cerrado':
                    case 'mantenimiento':
                        estadoBadgeClass = 'badge-secondary';
                        break;
                }
                
                // Mostrar servicios
                let serviciosHTML = '';
                if (refugio.servicios && refugio.servicios.length > 0) {
                    serviciosHTML = `
                        <div class="col-12 mt-3">
                            <p><strong>Servicios:</strong></p>
                            <ul>
                                ${refugio.servicios.map(s => `
                                    <li>
                                        ${s.nombre}
                                        ${s.pivot?.disponible ? '<span class="badge badge-success badge-sm ml-2">Disponible</span>' : '<span class="badge badge-secondary badge-sm ml-2">No disponible</span>'}
                                    </li>
                                `).join('')}
                            </ul>
                        </div>
                    `;
                }
                
                detallesBody.innerHTML = `
                    <div class="row">
                        <div class="col-12">
                            <h5>${refugio.nombre}</h5>
                            <hr>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Dirección:</strong><br>${refugio.direccion}</p>
                            <p><strong>Municipio:</strong> ${municipio}</p>
                            <p><strong>Teléfono:</strong> ${refugio.telefono_contacto || 'N/A'}</p>
                            <p><strong>Responsable:</strong> ${refugio.responsable || 'N/A'}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Capacidad Total:</strong> ${refugio.capacidad_total}</p>
                            <p><strong>Capacidad Actual:</strong> ${refugio.capacidad_actual || 0}</p>
                            <p><strong>Disponible:</strong> ${disponible}</p>
                            <p><strong>Estado:</strong> <span class="badge ${estadoBadgeClass}">${estadoCodigo}</span></p>
                            ${estadoDescripcion ? `<small class="text-muted">${estadoDescripcion}</small>` : ''}
                        </div>
                        ${serviciosHTML}
                        ${refugio.latitud && refugio.longitud ? `
                            <div class="col-12 mt-3">
                                <p><strong>Coordenadas:</strong></p>
                                <p>Lat: ${refugio.latitud}, Lng: ${refugio.longitud}</p>
                                <a href="https://www.google.com/maps?q=${refugio.latitud},${refugio.longitud}" 
                                   target="_blank" class="btn btn-sm btn-success">
                                    <i class="fas fa-map-marker-alt"></i> Ver en Google Maps
                                </a>
                            </div>
                        ` : ''}
                    </div>
                `;
                $('#modalDetalles').modal('show');
            })
            .catch(error => {
                console.error('Error:', error);
                alert('No se pudieron cargar los detalles del refugio');
            });
    }
</script>
@endpush