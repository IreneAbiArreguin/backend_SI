/**
 * Formulario de Reportes - Stepper Interactivo
 * Adaptado para trabajar con ReporteInundacionController
 */

// Estado del formulario
const formState = {
    currentStep: 1,
    totalSteps: 5,
    selectedType: null,
    selectedLocation: null,
    coordinates: null,
    photos: [],
    map: null,
    marker: null
};

// Mapeo de tipos de reporte a niveles de afectación
const reportTypes = {
    'inundacion': { nombre: 'Inundación', nivel: 'Moderada' },
    'calle-bloqueada': { nombre: 'Calle Bloqueada', nivel: 'Moderada' },
    'refugio-lleno': { nombre: 'Refugio Lleno', nivel: 'Severa' },
    'dano-infraestructura': { nombre: 'Daño a Infraestructura', nivel: 'Moderada' },
    'persona-riesgo': { nombre: 'Persona en Riesgo', nivel: 'Crítica' },
    'otro': { nombre: 'Otro', nivel: 'Leve' }
};

// Mapeo de urgencias a prioridad numérica
const urgencyToPriority = {
    'high': 1,    // Alta
    'medium': 2,  // Media
    'low': 3      // Baja
};

// Inicialización
document.addEventListener('DOMContentLoaded', function() {
    initializeForm();
    setupEventListeners();
    updateStepperUI();
});

function initializeForm() {
    showStep(1);
    updateCharacterCount('inputTitulo', 'tituloCount');
    updateCharacterCount('inputDescripcion', 'descripcionCount');
}

function setupEventListeners() {
    document.getElementById('btnNext').addEventListener('click', handleNext);
    document.getElementById('btnPrevious').addEventListener('click', handlePrevious);
    
    document.querySelectorAll('.report-type-card').forEach(card => {
        card.addEventListener('click', function() {
            selectReportType(this.dataset.type);
        });
    });
    
    document.querySelectorAll('.location-option-card').forEach(card => {
        card.addEventListener('click', function() {
            selectLocationType(this.dataset.location);
        });
    });
    
    document.querySelectorAll('.urgency-card').forEach(card => {
        card.addEventListener('click', function() {
            selectUrgency(this.dataset.urgency);
        });
    });
    
    document.getElementById('inputTitulo').addEventListener('input', function() {
        updateCharacterCount('inputTitulo', 'tituloCount');
    });
    
    document.getElementById('inputDescripcion').addEventListener('input', function() {
        updateCharacterCount('inputDescripcion', 'descripcionCount');
    });
    
    document.querySelectorAll('.photo-input').forEach(input => {
        input.addEventListener('change', function(e) {
            handlePhotoUpload(e, this.dataset.slot);
        });
    });
}

function updateStepperUI() {
    document.querySelectorAll('.stepper-step').forEach(step => {
        const stepNumber = parseInt(step.dataset.step);
        step.classList.remove('active', 'completed');
        
        if (stepNumber < formState.currentStep) {
            step.classList.add('completed');
        } else if (stepNumber === formState.currentStep) {
            step.classList.add('active');
        }
    });
    
    const progress = ((formState.currentStep - 1) / (formState.totalSteps - 1)) * 100;
    document.getElementById('stepperProgress').style.width = progress + '%';
    
    const btnPrevious = document.getElementById('btnPrevious');
    const btnNext = document.getElementById('btnNext');
    
    if (formState.currentStep === 1) {
        btnPrevious.style.display = 'none';
    } else {
        btnPrevious.style.display = 'inline-block';
    }
    
    if (formState.currentStep === formState.totalSteps) {
        btnNext.innerHTML = '<i class="fas fa-paper-plane"></i> Enviar Reporte';
    } else {
        btnNext.innerHTML = 'Siguiente <i class="fas fa-arrow-right"></i>';
    }
}

function showStep(step) {
    document.querySelectorAll('.step-content').forEach(content => {
        content.classList.remove('active');
    });
    
    const stepContent = document.querySelector(`.step-content[data-step="${step}"]`);
    if (stepContent) {
        stepContent.classList.add('active');
    }
    
    if (step === 5) {
        updateSummary();
    }
}

function handleNext() {
    if (validateCurrentStep()) {
        if (formState.currentStep === formState.totalSteps) {
            submitForm();
        } else {
            formState.currentStep++;
            showStep(formState.currentStep);
            updateStepperUI();
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }
    }
}

function handlePrevious() {
    if (formState.currentStep > 1) {
        formState.currentStep--;
        showStep(formState.currentStep);
        updateStepperUI();
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }
}

function validateCurrentStep() {
    hideError(formState.currentStep);
    
    switch(formState.currentStep) {
        case 1:
            if (!formState.selectedType) {
                showError(1, 'Por favor selecciona un tipo de reporte');
                return false;
            }
            break;
            
        case 2:
            if (!formState.selectedLocation || !formState.coordinates) {
                showError(2, 'Por favor selecciona una ubicación');
                return false;
            }
            break;
            
        case 3:
            const titulo = document.getElementById('inputTitulo').value.trim();
            const descripcion = document.getElementById('inputDescripcion').value.trim();
            
            if (!titulo) {
                showError(3, 'Por favor ingresa un título');
                return false;
            }
            
            if (titulo.length < 10) {
                showError(3, 'El título debe tener al menos 10 caracteres');
                return false;
            }
            
            if (!descripcion) {
                showError(3, 'Por favor ingresa una descripción');
                return false;
            }
            
            if (descripcion.length < 20) {
                showError(3, 'La descripción debe tener al menos 20 caracteres');
                return false;
            }
            break;
    }
    
    return true;
}

function showError(step, message) {
    const errorDiv = document.getElementById(`errorStep${step}`);
    if (errorDiv) {
        errorDiv.textContent = message;
        errorDiv.classList.remove('d-none');
    }
}

function hideError(step) {
    const errorDiv = document.getElementById(`errorStep${step}`);
    if (errorDiv) {
        errorDiv.classList.add('d-none');
    }
}

function selectReportType(type) {
    document.querySelectorAll('.report-type-card').forEach(card => {
        card.classList.remove('selected');
    });
    
    const selectedCard = document.querySelector(`.report-type-card[data-type="${type}"]`);
    if (selectedCard) {
        selectedCard.classList.add('selected');
    }
    
    formState.selectedType = type;
    document.getElementById('inputTipo').value = type;
}

function selectLocationType(type) {
    document.querySelectorAll('.location-option-card').forEach(card => {
        card.classList.remove('selected');
    });
    
    const selectedCard = document.querySelector(`.location-option-card[data-location="${type}"]`);
    if (selectedCard) {
        selectedCard.classList.add('selected');
    }
    
    formState.selectedLocation = type;
    document.getElementById('inputTipoUbicacion').value = type;
    
    if (type === 'current') {
        getCurrentLocation();
    } else if (type === 'map') {
        showMap();
    }
}

function getCurrentLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            position => {
                const coords = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude
                };
                setCoordinates(coords);
                showLocationInfo('Mi ubicación actual', coords);
            },
            error => {
                showError(2, 'No se pudo obtener tu ubicación. Por favor, selecciona manualmente en el mapa.');
                selectLocationType('map');
            }
        );
    } else {
        showError(2, 'Tu navegador no soporta geolocalización. Por favor, selecciona manualmente en el mapa.');
        selectLocationType('map');
    }
}

function showMap() {
    const mapContainer = document.getElementById('mapContainer');
    mapContainer.classList.remove('d-none');
    
    if (!formState.map) {
        // Inicializar el mapa centrado en Chetumal, Quintana Roo
        formState.map = L.map('reportMap').setView([18.5001, -88.2960], 13);
        
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(formState.map);
        
        formState.map.on('click', function(e) {
            setCoordinates(e.latlng);
            
            if (formState.marker) {
                formState.map.removeLayer(formState.marker);
            }
            
            formState.marker = L.marker(e.latlng).addTo(formState.map);
            
            showLocationInfo('Ubicación seleccionada en mapa', e.latlng);
        });
    }
    
    setTimeout(() => {
        formState.map.invalidateSize();
    }, 100);
}

function setCoordinates(coords) {
    formState.coordinates = coords;
    document.getElementById('inputLatitud').value = coords.lat;
    document.getElementById('inputLongitud').value = coords.lng;
}

function showLocationInfo(label, coords) {
    const selectedLocation = document.getElementById('selectedLocation');
    const locationText = document.getElementById('locationText');
    
    locationText.textContent = `${label}: ${coords.lat.toFixed(6)}, ${coords.lng.toFixed(6)}`;
    selectedLocation.classList.remove('d-none');
}

function selectUrgency(level) {
    document.querySelectorAll('.urgency-card').forEach(card => {
        card.classList.remove('active');
    });
    
    const selectedCard = document.querySelector(`.urgency-card[data-urgency="${level}"]`);
    if (selectedCard) {
        selectedCard.classList.add('active');
    }
    
    document.getElementById('inputUrgencia').value = level;
}

function updateCharacterCount(inputId, countId) {
    const input = document.getElementById(inputId);
    const counter = document.getElementById(countId);
    
    if (input && counter) {
        counter.textContent = input.value.length;
    }
}

function handlePhotoUpload(event, slot) {
    const file = event.target.files[0];
    if (!file) return;
    
    if (!file.type.startsWith('image/')) {
        alert('Por favor selecciona un archivo de imagen válido');
        return;
    }
    
    if (file.size > 5 * 1024 * 1024) {
        alert('La imagen no debe superar 5MB');
        return;
    }
    
    const reader = new FileReader();
    reader.onload = function(e) {
        const slotDiv = document.getElementById(`photoSlot${slot}`);
        const card = slotDiv.querySelector('.photo-upload-card');
        
        card.innerHTML = '';
        card.classList.add('has-photo');
        
        const img = document.createElement('img');
        img.src = e.target.result;
        card.appendChild(img);
        
        const removeBtn = document.createElement('button');
        removeBtn.type = 'button';
        removeBtn.className = 'photo-remove';
        removeBtn.innerHTML = '<i class="fas fa-times"></i>';
        removeBtn.onclick = function() {
            removePhoto(slot);
        };
        card.appendChild(removeBtn);
        
        formState.photos[slot - 1] = file;
    };
    
    reader.readAsDataURL(file);
}

function removePhoto(slot) {
    const slotDiv = document.getElementById(`photoSlot${slot}`);
    const card = slotDiv.querySelector('.photo-upload-card');
    
    card.classList.remove('has-photo');
    card.innerHTML = `
        <i class="fas fa-camera fa-2x mb-2"></i>
        <p class="mb-2">Agregar foto</p>
        <input type="file" class="photo-input" accept="image/*" data-slot="${slot}">
    `;
    
    card.querySelector('.photo-input').addEventListener('change', function(e) {
        handlePhotoUpload(e, slot);
    });
    
    formState.photos[slot - 1] = null;
}

function updateSummary() {
    const tipo = reportTypes[formState.selectedType] || { nombre: 'N/A' };
    document.getElementById('summaryTipo').textContent = tipo.nombre;
    
    let ubicacionText = 'N/A';
    if (formState.selectedLocation === 'current') {
        ubicacionText = 'Mi ubicación actual';
    } else if (formState.selectedLocation === 'map') {
        ubicacionText = 'Ubicación seleccionada en mapa';
    }
    if (formState.coordinates) {
        ubicacionText += ` (${formState.coordinates.lat.toFixed(6)}, ${formState.coordinates.lng.toFixed(6)})`;
    }
    document.getElementById('summaryUbicacion').textContent = ubicacionText;
    
    document.getElementById('summaryTitulo').textContent = document.getElementById('inputTitulo').value;
    
    const urgencia = document.getElementById('inputUrgencia').value;
    const urgencyLabels = { 'high': '🔴 Alta', 'medium': '🟡 Media', 'low': '🟢 Baja' };
    document.getElementById('summaryUrgencia').textContent = urgencyLabels[urgencia] || 'Media';
    
    const photoCount = formState.photos.filter(p => p !== null).length;
    document.getElementById('summaryFotos').textContent = photoCount > 0 ? `${photoCount} foto(s)` : 'Sin fotos';
}

/**
 * Envía el formulario - ADAPTADO para tu API
 */
function submitForm() {
    const formData = new FormData();
    
    // Token CSRF
    formData.append('_token', document.querySelector('input[name="_token"]').value);
    
    // Campos requeridos según tu modelo ReporteInundacion
    const urgencia = document.getElementById('inputUrgencia').value;
    const titulo = document.getElementById('inputTitulo').value;
    const descripcion = document.getElementById('inputDescripcion').value;
    
    // Mapear tipo de reporte a nivel de afectación
    const tipoInfo = reportTypes[formState.selectedType] || { nivel: 'Moderada' };
    
    // Campos básicos
    formData.append('estado_reporte_id', '1'); // Estado inicial: Pendiente
    formData.append('nivel_afectacion', tipoInfo.nivel);
    formData.append('metodo_origen', 'web_usuario');
    formData.append('prioridad', urgencyToPriority[urgencia]);
    
    // Ubicación
    formData.append('latitud', formState.coordinates.lat);
    formData.append('longitud', formState.coordinates.lng);
    
    // Usar el título como calle_principal y descripción
    formData.append('calle_principal', titulo);
    formData.append('descripcion', descripcion);
    formData.append('colonia', 'Reportada desde web');
    
    // Información adicional
    formData.append('fuente_ubicacion', formState.selectedLocation === 'current' ? 'geolocalización' : 'mapa');
    
    // Usuario (si está autenticado, Laravel lo agregará automáticamente)
    //formData.append('id_usuario', USER_ID); // Si tienes el ID del usuario
    
    // Fotos (si las soportas en tu modelo actual)
    formState.photos.forEach((photo, index) => {
        if (photo) {
            formData.append(`fotos[${index}]`, photo);
        }
    });
    
    // Deshabilitar botón
    const btnNext = document.getElementById('btnNext');
    const originalText = btnNext.innerHTML;
    btnNext.disabled = true;
    btnNext.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Enviando...';
    
    // Enviar a TU API endpoint
    fetch('/api/reportes-inundaciones', {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    })
    .then(response => {
        if (!response.ok) {
            return response.json().then(data => {
                throw new Error(data.message || 'Error en el servidor');
            });
        }
        return response.json();
    })
    .then(data => {
        if (data.success || data.data) {
            // Mostrar modal de éxito
            $('#modalExito').modal('show');
            
            // Redirigir después de 2 segundos
            setTimeout(() => {
                window.location.href = '/mis-reportes';
            }, 2000);
        } else {
            throw new Error(data.message || 'Error desconocido');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error al enviar el reporte: ' + error.message);
        btnNext.disabled = false;
        btnNext.innerHTML = originalText;
    });
}

console.log('✅ Formulario de reportes inicializado');
console.log('📡 API Endpoint: /api/reportes-inundaciones');