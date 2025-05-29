<?php
session_start();

$usuarioValido = "admin";
$contrasenaValida = "1234";

if (isset($_POST['usuario']) && isset($_POST['password'])) {
    $usuario = $_POST['usuario'];
    $password = $_POST['password'];

    if ($usuario === $usuarioValido && $password === $contrasenaValida) {
        $_SESSION['loggedin'] = true;
        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Usuario o contraseña incorrectos.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Admin Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    body {
      background: linear-gradient(45deg, #1e272e, #485460);
      color: white;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    .login-box {
      background-color: #222831;
      padding: 30px;
      border-radius: 10px;
      width: 320px;
      box-shadow: 0 0 20px #00adb5;
    }
    input.form-control {
      background-color: #393e46;
      border: none;
      color: white;
    }
    input.form-control:focus {
      background-color: #222831;
      outline: none;
      box-shadow: 0 0 5px #00adb5;
      color: white;
    }
    .btn-login {
      background-color: #00adb5;
      border: none;
      font-weight: bold;
      transition: background-color 0.3s ease;
    }
    .btn-login:hover {
      background-color: #008f94;
    }
    .error-msg {
      color: #ff6b6b;
      margin-bottom: 10px;
      font-weight: bold;
      text-align: center;
    }
  </style>
</head>
<body>
  <div class="login-box">
    <h2 class="text-center mb-4">Ingreso Administrador</h2>
    <?php if (!empty($error)): ?>
      <div class="error-msg"><?php echo $error; ?></div>
    <?php endif; ?>
    <form method="post" action="">
      <div class="mb-3">
        <input type="text" name="usuario" class="form-control" placeholder="Usuario" required autofocus />
      </div>
      <div class="mb-3">
        <input type="password" name="password" class="form-control" placeholder="Contraseña" required />
      </div>
      <button type="submit" class="btn btn-login w-100">Entrar</button>
    </form>
  </div>
</body>
</html>
