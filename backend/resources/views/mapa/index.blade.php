@extends('layouts.admin')

@section('title', 'Mapa de Refugios y Zonas de Riesgo')

@section('page-title', 'Mapa de Refugios y Zonas de Riesgo')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('welcome') }}">Inicio</a></li>
    <li class="breadcrumb-item active">Mapa</li>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Mapa de Refugios y Zonas de Riesgo</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-primary btn-sm" id="btnMiUbicacion">
                    <i class="fas fa-location-arrow"></i> Mi Ubicación
                </button>
                <button type="button" class="btn btn-info btn-sm ml-2" id="btnOthonBlanco">
                    <i class="fas fa-map-marker-alt"></i> Othón P. Blanco
                </button>
            </div>
        </div>
        <div class="card-body p-0">
            <!-- Filtros -->
            <div class="p-3 bg-light border-bottom">
                <div class="row">
                    <div class="col-md-3">
                        <label for="selectMunicipio">Filtrar por Municipio:</label>
                        <select id="selectMunicipio" class="form-control">
                            <option value="">Todos los municipios</option>
                            <!-- Se llenarán dinámicamente -->
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="selectEstado">Estado del Refugio:</label>
                        <select id="selectEstado" class="form-control">
                            <option value="">Todos los estados</option>
                            <option value="disponible">Disponible</option>
                            <option value="ocupado">Ocupado</option>
                            <option value="lleno">Lleno</option>
                            <option value="cerrado">Cerrado</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="toggleZonasRiesgo">Mostrar Zonas de Riesgo:</label>
                        <div class="form-check form-switch mt-2">
                            <input class="form-check-input" type="checkbox" id="toggleZonasRiesgo" checked>
                            <label class="form-check-label" for="toggleZonasRiesgo">Activar/Desactivar</label>
                        </div>
                    </div>
                    <div class="col-md-3 d-flex align-items-end">
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
                <div class="row">
                    <div class="col-md-6">
                        <strong>Leyenda Refugios:</strong>
                        <span class="ml-3"><i class="fas fa-circle text-success"></i> Disponible</span>
                        <span class="ml-3"><i class="fas fa-circle text-warning"></i> Ocupado</span>
                        <span class="ml-3"><i class="fas fa-circle text-danger"></i> Lleno</span>
                        <span class="ml-3"><i class="fas fa-circle text-secondary"></i> Cerrado</span>
                    </div>
                    <div class="col-md-6">
                        <strong>Leyenda Zonas:</strong>
                        <span class="ml-3"><i class="fas fa-square text-red" style="color: #ff4444;"></i> Alta Inundación</span>
                        <span class="ml-3"><i class="fas fa-square text-orange" style="color: #ff8800;"></i> Media Inundación</span>
                    </div>
                </div>
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
    <script src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google.maps_api_key') }}&libraries=places,geometry"></script>

    <script>
        let map;
        let markers = [];
        let refugiosData = [];
        let municipiosData = [];
        let infoWindows = [];
        let zonasRiesgo = [];
        let zonasRiesgoActivas = true;

        // Coordenadas por defecto (Chetumal, Quintana Roo)
        const DEFAULT_CENTER = { lat: 18.5001, lng: -88.2960 };
        
        // Coordenadas específicas para Othón P. Blanco
        const OTHON_BLANCO_CENTER = { lat: 18.5001, lng: -88.2960 }; // Chetumal es la cabecera

        // Zonas de riesgo de ejemplo para Othón P. Blanco
        const ZONAS_RIESGO_OTHON = [
            {
                nombre: "Zona Centro - Alta Inundación",
                tipo: "alta",
                coordenadas: [
                    { lat: 18.5050, lng: -88.3050 },
                    { lat: 18.5080, lng: -88.3000 },
                    { lat: 18.5020, lng: -88.2950 },
                    { lat: 18.4980, lng: -88.3020 }
                ],
                descripcion: "Zona con historial de inundaciones severas"
            },
            {
                nombre: "Colonia Bojorquez - Media Inundación", 
                tipo: "media",
                coordenadas: [
                    { lat: 18.5150, lng: -88.3100 },
                    { lat: 18.5180, lng: -88.3050 },
                    { lat: 18.5120, lng: -88.3000 },
                    { lat: 18.5080, lng: -88.3080 }
                ],
                descripcion: "Zona con inundaciones moderadas en temporada de lluvias"
            },
            {
                nombre: "Río Hondo - Área Costeras",
                tipo: "alta",
                coordenadas: [
                    { lat: 18.4900, lng: -88.3200 },
                    { lat: 18.4950, lng: -88.3150 },
                    { lat: 18.4850, lng: -88.3100 },
                    { lat: 18.4800, lng: -88.3180 }
                ],
                descripcion: "Zona afectada por crecidas del Río Hondo"
            }
        ];

        // Inicializar mapa
        function initMap() {
            map = new google.maps.Map(document.getElementById('map'), {
                center: DEFAULT_CENTER,
                zoom: 12,
                mapTypeId: 'roadmap',
                mapTypeControl: true,
                streetViewControl: true,
                fullscreenControl: true,
                styles: [
                    {
                        "featureType": "administrative",
                        "elementType": "geometry",
                        "stylers": [{ "visibility": "off" }]
                    },
                    {
                        "featureType": "poi",
                        "stylers": [{ "visibility": "simplified" }]
                    },
                    {
                        "featureType": "road",
                        "elementType": "labels.icon",
                        "stylers": [{ "visibility": "off" }]
                    },
                    {
                        "featureType": "transit",
                        "stylers": [{ "visibility": "off" }]
                    }
                ]
            });

            // Cargar datos
            cargarMunicipios();
            cargarRefugios();
            
            // Dibujar zonas de riesgo iniciales
            dibujarZonasRiesgo();
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

        // Dibujar zonas de riesgo en el mapa
        function dibujarZonasRiesgo() {
            // Limpiar zonas anteriores
            zonasRiesgo.forEach(zona => zona.setMap(null));
            zonasRiesgo = [];

            if (!zonasRiesgoActivas) return;

            ZONAS_RIESGO_OTHON.forEach(zona => {
                const polygon = new google.maps.Polygon({
                    paths: zona.coordenadas,
                    strokeColor: zona.tipo === 'alta' ? '#FF4444' : '#FF8800',
                    strokeOpacity: 0.8,
                    strokeWeight: 2,
                    fillColor: zona.tipo === 'alta' ? '#FF4444' : '#FF8800',
                    fillOpacity: 0.35,
                    map: map,
                    title: zona.nombre
                });

                // InfoWindow para la zona de riesgo
                const infoWindow = new google.maps.InfoWindow({
                    content: `
                        <div style="max-width: 250px; padding: 10px;">
                            <h6 style="margin-bottom: 8px; color: #333; font-weight: bold;">${zona.nombre}</h6>
                            <p style="margin: 3px 0; font-size: 13px;"><strong>Tipo:</strong> 
                                <span style="color: ${zona.tipo === 'alta' ? '#FF4444' : '#FF8800'}; font-weight: bold;">
                                    ${zona.tipo === 'alta' ? 'Alta Inundación' : 'Media Inundación'}
                                </span>
                            </p>
                            <p style="margin: 3px 0; font-size: 13px;">${zona.descripcion}</p>
                        </div>
                    `
                });

                polygon.addListener('click', function(event) {
                    infoWindow.setPosition(event.latLng);
                    infoWindow.open(map);
                });

                zonasRiesgo.push(polygon);
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
            }
            
            if (filtros.estado) {
                refugiosFiltrados = refugiosFiltrados.filter(r => {
                    const codigo = r.estado?.codigo?.toLowerCase();
                    return codigo === filtros.estado.toLowerCase();
                });
            }

            // Crear marcadores - TODOS VERDES como solicitaste
            refugiosFiltrados.forEach(refugio => {
                if (refugio.latitud && refugio.longitud) {
                    const marker = crearMarcador(refugio);
                    markers.push(marker);
                }
            });

            // Ajustar zoom para mostrar todos los marcadores
            if (markers.length > 0) {
                const bounds = new google.maps.LatLngBounds();
                markers.forEach(marker => bounds.extend(marker.getPosition()));
                map.fitBounds(bounds);
                
                google.maps.event.addListenerOnce(map, 'bounds_changed', function() {
                    if (this.getZoom() > 15) {
                        this.setZoom(15);
                    }
                });
            } else {
                map.setCenter(DEFAULT_CENTER);
                map.setZoom(12);
            }
        }

        // Crear marcador personalizado - SIEMPRE VERDE
        function crearMarcador(refugio) {
            const disponible = refugio.capacidad_total - (refugio.capacidad_actual || 0);
            
            // TODOS LOS REFUGIOS EN VERDE como solicitaste
            const iconColor = '#28a745'; // Verde fijo para todos

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

        // Botón: Othón P. Blanco
        document.getElementById('btnOthonBlanco').addEventListener('click', function() {
            map.setCenter(OTHON_BLANCO_CENTER);
            map.setZoom(13);
            
            // Resaltar zonas de riesgo de Othón P. Blanco
            dibujarZonasRiesgo();
        });

        // Botón: Aplicar Filtros
        document.getElementById('btnFiltrar').addEventListener('click', function() {
            const filtros = {
                municipio: document.getElementById('selectMunicipio').value,
                estado: document.getElementById('selectEstado').value
            };
            
            mostrarRefugiosEnMapa(refugiosData, filtros);
        });

        // Toggle Zonas de Riesgo
        document.getElementById('toggleZonasRiesgo').addEventListener('change', function() {
            zonasRiesgoActivas = this.checked;
            if (zonasRiesgoActivas) {
                dibujarZonasRiesgo();
            } else {
                zonasRiesgo.forEach(zona => zona.setMap(null));
                zonasRiesgo = [];
            }
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