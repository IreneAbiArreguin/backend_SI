<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yáanal Ha' - Sistema de Inundación</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/welcomeApp.css') }}">
</head>
<body>

    <div class="background"></div>
    <div class="overlay"></div>

    <!-- Gotas -->
    <div class="rain" id="rain"></div>

    <div class="container">
        <div class="logo-circle">
            <img src="{{ asset('image/Logo.png') }}" alt="Yáanal Ha'">
        </div>

        <h1 class="logo">Yáanal Ha'</h1>
        <p class="subtitle">Sistema de Inundación</p>
    </div>

    <script>
        const rain = document.getElementById('rain');
        for (let i = 0; i < 100; i++) {
            const drop = document.createElement('div');
            drop.classList.add('drop');
            drop.style.left = Math.random() * 100 + 'vw';
            drop.style.animationDuration = Math.random() * 0.8 + 0.5 + 's';
            drop.style.animationDelay = Math.random() * 5 + 's';
            drop.style.opacity = Math.random() * 0.6 + 0.3;
            rain.appendChild(drop);
        }
        setTimeout(function() {
            window.location.href = "{{ route('mapa') }}";
        }, 3000);
    </script>
</body>
</html>