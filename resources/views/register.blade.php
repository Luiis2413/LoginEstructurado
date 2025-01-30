{{--  
    Vista de Registro de Usuarios  

    @section Descripción  
    Esta vista proporciona un formulario para que los usuarios se registren en la aplicación.  
    Incluye validaciones, protección contra bots mediante Google reCAPTCHA y usa Bootstrap 5.3.3.  

    @uses Bootstrap 5.3.3 para estilos y diseño responsivo.  
    @uses Google reCAPTCHA para protección contra bots.  
    @uses Auth::check() para verificar si el usuario ya está autenticado.  

    @return HTML - Renderiza la página de registro con un formulario.  
--}}

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- Bootstrap JS y dependencias -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <!-- Google reCAPTCHA -->
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>
<body>

    {{-- Sección principal con diseño responsivo y fondo gris --}}
    <section class="vh-100" style="background-color: #eee;">
        <div class="container h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-lg-12 col-xl-11">
                    <div class="card text-black" style="border-radius: 25px;">
                        <div class="card-body p-md-5">
                            <div class="row justify-content-center">

                                {{-- Columna del formulario --}}
                                <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1">
                                    <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">Registro</p>

                                    {{-- Mensajes de error --}}
                                    @if ($errors->any())
                                        <div class="alert alert-danger">
                                            <ul>
                                                <li>Credenciales incorrectas</li>
                                            </ul>
                                        </div>
                                    @endif

                                    {{-- Formulario de registro --}}
                                    <form class="mx-1 mx-md-4" method="POST" action="{{ route('registrar') }}" onsubmit="return grecaptcha.getResponse() != '';">
                                        @csrf

                                        {{-- Campo Nombre --}}
                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <i class="fas fa-user fa-lg me-3 fa-fw"></i>
                                            <div class="form-outline flex-fill mb-0">
                                                <input type="text" id="form3Example1c" class="form-control" name="name" value="{{ old('name') }}" required />
                                                <label class="form-label" for="form3Example1c">Nombre</label>
                                            </div>
                                        </div>

                                        {{-- Campo Email --}}
                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <i class="fas fa-envelope fa-lg me-3 fa-fw"></i>
                                            <div class="form-outline flex-fill mb-0">
                                                <input type="email" id="form3Example3c" class="form-control" name="email" value="{{ old('email') }}" required />
                                                <label class="form-label" for="form3Example3c">Email</label>
                                            </div>
                                        </div>

                                        {{-- Campo Contraseña --}}
                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <i class="fas fa-lock fa-lg me-3 fa-fw"></i>
                                            <div class="form-outline flex-fill mb-0">
                                                <input type="password" id="form3Example4c" class="form-control" name="password" required />
                                                <label class="form-label" for="form3Example4c">Contraseña</label>
                                            </div>
                                        </div>

                                        {{-- Google reCAPTCHA --}}
                                        <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                                            <div class="g-recaptcha" data-sitekey="6LcZsMYqAAAAAE7F8LvuRJuaC8lLGGQhcaNfN7yh"></div>
                                        </div>

                                        {{-- Botón de Registro --}}
                                        <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                                            <button type="submit" class="btn btn-primary btn-lg">Registrar</button>
                                        </div>

                                        {{-- Enlace a iniciar sesión --}}
                                        <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                                            <a href="{{ route('login') }}" class="ml-3">Iniciar sesión</a>
                                        </div>
                                    </form>
                                </div>

                                {{-- Columna de imagen ilustrativa --}}
                                <div class="col-md-10 col-lg-6 col-xl-7 d-flex align-items-center order-1 order-lg-2">
                                    <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-registration/draw1.webp"
                                         class="img-fluid" alt="Ilustración de Registro">
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</body>
</html>

<!-- Bootstrap JS y dependencias -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
