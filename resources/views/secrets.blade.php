{{--  
    Plantilla de bienvenida con Navbar (Bootstrap)  

    @section Descripción  
    Esta vista muestra una barra de navegación con opciones y un mensaje de bienvenida.  
    Si el usuario está autenticado, muestra su nombre; de lo contrario, invita a iniciar sesión.  

    @uses Bootstrap 5.3.0 para estilos y funcionalidad de la barra de navegación.  
    @uses Auth::check() para verificar si el usuario está autenticado.  

    @return HTML - Renderiza la página de bienvenida con el navbar.  
--}}

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navbar con Bootstrap y Welcome</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        /*  
            Estilos personalizados para el texto "Welcome"  

            - Tamaño grande (5rem)  
            - Texto en negrita  
            - Color negro con 30% de opacidad  
            - Centrado en la pantalla  
            - No seleccionable por el usuario  
        */
        .welcome-text {
            font-size: 5rem;
            font-weight: bold;
            color: rgba(0, 0, 0, 0.3);
            text-align: center;
            margin-top: 20vh;
            user-select: none;
        }
    </style>
</head>
<body>

    {{-- Navbar con opciones de navegación --}}
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            {{-- Marca de la aplicación --}}
            <a class="navbar-brand" href="#">MiApp</a>

            {{-- Botón para menú colapsable en dispositivos pequeños --}}
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            {{-- Elementos del navbar --}}
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    {{-- Enlace a la página de inicio --}}
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Inicio</a>
                    </li>

                    {{-- Enlace al perfil del usuario --}}
                    <li class="nav-item">
                        <a class="nav-link" href="#">Perfil</a>
                    </li>

                    {{-- Enlace a configuración --}}
                    <li class="nav-item">
                        <a class="nav-link" href="#">Configuración</a>
                    </li>
                </ul>

                {{-- Opciones de autenticación --}}
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    {{-- Mostrar solo si el usuario está autenticado --}}
                    @if(Auth::check())
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('logout') }}">Cerrar Sesión</a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Iniciar Sesión</a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    {{-- Texto de bienvenida con verificación de usuario autenticado --}}
    <div class="welcome-text">
        @if(Auth::check())
            Welcome, {{ Auth::user()->name }}!
        @else
            Bienvenido, por favor inicie sesión.
        @endif
    </div>

    <!-- Bootstrap JS y dependencias -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>
