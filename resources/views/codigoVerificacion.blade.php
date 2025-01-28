<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Verificación de Código</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

  <div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="card shadow p-4" style="max-width: 400px; width: 100%;">
      <h4 class="text-center mb-4">Verificación de Código</h4>
      <p class="text-muted text-center mb-4">
        Por favor, introduce el código de 6 dígitos enviado a tu correo. 
      </p>
      <form method='POST' action="{{route('verificarCodigo')}}">
      @csrf  <!-- Agregar este campo CSRF aquí -->

        <div class="mb-3">
          <label for="verificationCode" class="form-label">Código de Verificación</label>
          <input type="text" class="form-control text-center" name='code' id="verificationCode" maxlength="6" placeholder="123456" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Verificar</button>
      </form>
      <div class="text-center mt-3">
        <small class="text-muted">¿No recibiste el código? <a href="#" class="text-decoration-none">Reenviar</a></small>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS Bundle -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
