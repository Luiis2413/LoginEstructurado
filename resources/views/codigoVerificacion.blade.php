{{--  
    Vista de Verificación de Código  

    @section Descripción  
    Esta vista muestra un formulario donde el usuario debe ingresar un código de verificación  
    de 6 dígitos enviado a su correo para completar el proceso de autenticación.  

    @uses Bootstrap 5.3 para diseño responsivo y estilos.  
    @uses CSRF Token para protección contra ataques Cross-Site Request Forgery (CSRF).  

    @return HTML - Renderiza una página con un formulario de verificación de código.  
--}}

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificación de Código</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    {{-- Mensajes de error en caso de código incorrecto --}}
    @if(session('error'))
        <div class="alert alert-danger text-center">
            {{ session('error') }}
        </div>
    @endif

    {{-- Contenedor principal con alineación al centro --}}
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card shadow p-4" style="max-width: 400px; width: 100%;">
            
            {{-- Título principal --}}
            <h4 class="text-center mb-4">Verificación de Código</h4>
            
            {{-- Descripción --}}
            <p class="text-muted text-center mb-4">
                Por favor, introduce el código de 6 dígitos enviado a tu correo. 
            </p>

            {{-- Formulario de verificación --}}
            <form method="POST" action="{{ route('verificarCodigo') }}">
                @csrf  {{-- Protección CSRF --}}

                {{-- Campo para ingresar el código --}}
                <div class="mb-3">
                    <label for="verificationCode" class="form-label">Código de Verificación</label>
                    <input type="text" class="form-control text-center" name="code" id="verificationCode" maxlength="6" placeholder="123456" required>
                </div>

                {{-- Botón de verificación --}}
                <button type="submit" class="btn btn-primary w-100">Verificar</button>
            </form>

            {{-- Enlace para regresar en caso de no recibir el código --}}
            <div class="text-center mt-3">
                <small class="text-muted">
                    Si no recibiste el código, intenta más tarde.  
                    <a href="{{ route('logout') }}" class="text-decoration-none">Regresar</a>
                </small>
            </div>

        </div>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
