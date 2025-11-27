@extends('layouts.admin')

@section('title', 'Mapa de Refugios')

@section('page-title', 'Mapa de Refugios')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('welcome') }}">Inicio</a></li>
    <li class="breadcrumb-item active">Mapa</li>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Mapa de Refugios</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-primary btn-sm" id="btnMiUbicacion">
                    <i class="fas fa-location-arrow"></i> Mi Ubicación
                </button>
            </div>
        </div>
        <div class="card-body p-0">
            <!-- Filtros -->
            <div class="p-3 bg-light border-bottom">
                <div class="row">
                    <div class="col-md-4">
                        <label for="selectMunicipio">Filtrar por Municipio:</label>
                        <select id="selectMunicipio" class="form-control">
                            <option value="">Todos los municipios</option>
                            <!-- Se llenarán dinámicamente -->
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="selectEstado">Estado del Refugio:</label>
                        <select id="selectEstado" class="form-control">
                            <option value="">Todos los estados</option>
                            <option value="disponible">Disponible</option>
                            <option value="ocupado">Ocupado</option>
                            <option value="lleno">Lleno</option>
                            <option value="cerrado">Cerrado</option>
                        </select>
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
                        <button type="button" class="btn btn-success btn-block" id="btnFiltrar">
                            <i class="fas fa-filter"></i> Aplicar Filtros
                        </button>
                    </div>
                </div>
            </div>

            <!-- Mapa -->
            <div class="map-card p-0">
                <div id="map"></div>
            </div>

            <!-- Leyenda -->
            <div class="p-3 bg-light border-top">
                <strong>Leyenda:</strong>
                <span class="ml-3"><i class="fas fa-circle text-success"></i> Disponible</span>
                <span class="ml-3"><i class="fas fa-circle text-warning"></i> Ocupado</span>
                <span class="ml-3"><i class="fas fa-circle text-danger"></i> Lleno</span>
                <span class="ml-3"><i class="fas fa-circle text-secondary"></i> Cerrado</span>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
    .map-card {
        height: 600px;
    }
    #map {
        width: 100%;
        height: 100%;
    }
    .gm-style-iw {
        max-width: 300px;
    }
</style>
@endpush

@push('scripts')
    <!-- Google Maps JS -->
    <script src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google.maps_api_key') }}&libraries=places"></script>

    <script>
        let map;
        let markers = [];
        let refugiosData = [];
        let municipiosData = [];
        let infoWindows = []; // Para cerrar ventanas anteriores

        // Coordenadas por defecto (Chetumal, Quintana Roo)
        const DEFAULT_CENTER = { lat: 18.5001, lng: -88.2960 };

        // Inicializar mapa
        function initMap() {
            map = new google.maps.Map(document.getElementById('map'), {
                center: DEFAULT_CENTER,
                zoom: 12,
                mapTypeId: 'roadmap',
                mapTypeControl: true,
                streetViewControl: true,
                fullscreenControl: true
            });

            // Cargar datos
            cargarMunicipios();
            cargarRefugios();
        }

        // Cargar municipios para el selector
        function cargarMunicipios() {
            fetch('/api/refugios')
                .then(response => response.json())
                .then(response => {
                    const refugios = response.data || response;
                    
                    // Extraer municipios únicos
                    const municipiosMap = new Map();
                    refugios.forEach(r => {
                        if (r.municipio && r.municipio.id_municipio) {
                            municipiosMap.set(r.municipio.id_municipio, {
                                id: r.municipio.id_municipio,
                                nombre: r.municipio.nombre
                            });
                        }
                    });

                    municipiosData = Array.from(municipiosMap.values());
                    
                    const select = document.getElementById('selectMunicipio');
                    // Limpiar opciones previas (excepto "Todos")
                    select.innerHTML = '<option value="">Todos los municipios</option>';
                    
                    municipiosData.forEach(municipio => {
                        const option = document.createElement('option');
                        option.value = municipio.id;
                        option.textContent = municipio.nombre;
                        select.appendChild(option);
                    });
                })
                .catch(error => console.error('Error al cargar municipios:', error));
        }

        // Cargar refugios y mostrar marcadores
        function cargarRefugios() {
            fetch('/api/refugios')
                .then(response => response.json())
                .then(response => {
                    refugiosData = response.data || response;
                    console.log('Refugios cargados:', refugiosData.length);
                    mostrarRefugiosEnMapa(refugiosData);
                })
                .catch(error => {
                    console.error('Error al cargar refugios:', error);
                    alert('No se pudieron cargar los refugios');
                });
        }

        // Mostrar refugios en el mapa
        function mostrarRefugiosEnMapa(refugios, filtros = {}) {
            // Limpiar marcadores anteriores
            markers.forEach(marker => marker.setMap(null));
            markers = [];
            
            // Cerrar todas las ventanas de información
            infoWindows.forEach(iw => iw.close());
            infoWindows = [];

            // Aplicar filtros
            let refugiosFiltrados = refugios;
            
            if (filtros.municipio) {
                refugiosFiltrados = refugiosFiltrados.filter(r => 
                    r.id_municipio == filtros.municipio
                );
                console.log('Filtrado por municipio:', refugiosFiltrados.length);
            }
            
            if (filtros.estado) {
                refugiosFiltrados = refugiosFiltrados.filter(r => {
                    const codigo = r.estado?.codigo?.toLowerCase();
                    return codigo === filtros.estado.toLowerCase();
                });
                console.log('Filtrado por estado:', refugiosFiltrados.length);
            }

            // Crear marcadores
            refugiosFiltrados.forEach(refugio => {
                if (refugio.latitud && refugio.longitud) {
                    const marker = crearMarcador(refugio);
                    markers.push(marker);
                }
            });

            console.log('Marcadores creados:', markers.length);

            // Ajustar zoom para mostrar todos los marcadores
            if (markers.length > 0) {
                const bounds = new google.maps.LatLngBounds();
                markers.forEach(marker => bounds.extend(marker.getPosition()));
                map.fitBounds(bounds);
                
                // Evitar zoom excesivo si hay solo un marcador
                google.maps.event.addListenerOnce(map, 'bounds_changed', function() {
                    if (this.getZoom() > 15) {
                        this.setZoom(15);
                    }
                });
            } else {
                // Si no hay marcadores, volver al centro por defecto
                map.setCenter(DEFAULT_CENTER);
                map.setZoom(12);
                alert('No se encontraron refugios con los filtros seleccionados');
            }
        }

        // Crear marcador personalizado
        function crearMarcador(refugio) {
            const estadoCodigo = refugio.estado?.codigo?.toLowerCase() || 'desconocido';
            const disponible = refugio.capacidad_total - (refugio.capacidad_actual || 0);
            
            // Color del marcador según estado
            let iconColor = 'blue';
            switch(estadoCodigo) {
                case 'disponible':
                    iconColor = '#28a745'; // Verde Bootstrap
                    break;
                case 'ocupado':
                    iconColor = '#ffc107'; // Amarillo Bootstrap
                    break;
                case 'lleno':
                    iconColor = '#dc3545'; // Rojo Bootstrap
                    break;
                case 'cerrado':
                case 'mantenimiento':
                    iconColor = '#6c757d'; // Gris Bootstrap
                    break;
            }

            // Crear marcador con icono personalizado
            const marker = new google.maps.Marker({
                position: { lat: parseFloat(refugio.latitud), lng: parseFloat(refugio.longitud) },
                map: map,
                title: refugio.nombre,
                icon: {
                    path: google.maps.SymbolPath.CIRCLE,
                    scale: 12,
                    fillColor: iconColor,
                    fillOpacity: 0.9,
                    strokeColor: 'white',
                    strokeWeight: 3
                },
                animation: google.maps.Animation.DROP
            });

            // Contenido del InfoWindow
            const infoContent = `
                <div style="max-width: 300px; padding: 10px;">
                    <h5 style="margin-bottom: 10px; color: #333; font-weight: bold;">${refugio.nombre}</h5>
                    <p style="margin: 5px 0;"><strong>Dirección:</strong> ${refugio.direccion}</p>
                    <p style="margin: 5px 0;"><strong>Municipio:</strong> ${refugio.municipio?.nombre || 'N/A'}</p>
                    <p style="margin: 5px 0;"><strong>Capacidad:</strong> ${disponible} / ${refugio.capacidad_total} disponibles</p>
                    <p style="margin: 5px 0;"><strong>Estado:</strong> <span style="padding: 3px 8px; border-radius: 3px; background-color: ${iconColor}; color: white; font-size: 12px;">${refugio.estado?.codigo || 'N/A'}</span></p>
                    <p style="margin: 5px 0;"><strong>Teléfono:</strong> ${refugio.telefono_contacto || 'N/A'}</p>
                    <p style="margin: 5px 0;"><strong>Responsable:</strong> ${refugio.responsable || 'N/A'}</p>
                    <div style="margin-top: 15px; display: flex; gap: 5px;">
                        <a href="https://www.google.com/maps/dir/?api=1&destination=${refugio.latitud},${refugio.longitud}" 
                           target="_blank" 
                           style="padding: 5px 10px; background-color: #28a745; color: white; text-decoration: none; border-radius: 3px; font-size: 12px;">
                            <i class="fas fa-directions"></i> Cómo llegar
                        </a>
                        <a href="{{ route('refugios') }}" 
                           style="padding: 5px 10px; background-color: #17a2b8; color: white; text-decoration: none; border-radius: 3px; font-size: 12px;">
                            <i class="fas fa-info-circle"></i> Más detalles
                        </a>
                    </div>
                </div>
            `;

            const infoWindow = new google.maps.InfoWindow({
                content: infoContent
            });

            infoWindows.push(infoWindow);

            marker.addListener('click', function() {
                // Cerrar todas las ventanas anteriores
                infoWindows.forEach(iw => iw.close());
                infoWindow.open(map, marker);
            });

            return marker;
        }

        // Botón: Mi Ubicación
        document.getElementById('btnMiUbicacion').addEventListener('click', function() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    const pos = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                    };
                    map.setCenter(pos);
                    map.setZoom(14);
                    
                    // Marcador de ubicación actual
                    new google.maps.Marker({
                        position: pos,
                        map: map,
                        icon: {
                            path: google.maps.SymbolPath.CIRCLE,
                            scale: 10,
                            fillColor: '#4285F4',
                            fillOpacity: 1,
                            strokeColor: 'white',
                            strokeWeight: 3
                        },
                        title: 'Tu ubicación'
                    });
                }, function() {
                    alert('No se pudo obtener tu ubicación');
                });
            } else {
                alert('Tu navegador no soporta geolocalización');
            }
        });

        // Botón: Aplicar Filtros
        document.getElementById('btnFiltrar').addEventListener('click', function() {
            const filtros = {
                municipio: document.getElementById('selectMunicipio').value,
                estado: document.getElementById('selectEstado').value
            };
            
            console.log('Aplicando filtros:', filtros);
            mostrarRefugiosEnMapa(refugiosData, filtros);
        });

        // Inicializar cuando se cargue la página
        window.addEventListener('load', function() {
            if (typeof google !== 'undefined' && google.maps) {
                initMap();
            } else {
                let tries = 0;
                const interval = setInterval(function() {
                    tries++;
                    if (window.google && google.maps) {
                        clearInterval(interval);
                        initMap();
                    }
                    if (tries > 20) clearInterval(interval);
                }, 200);
            }
        });
    </script>
@endpush