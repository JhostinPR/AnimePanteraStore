<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}

$conn = new mysqli("localhost", "root", "", "inventario");
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$mensaje = "";

// Agregar producto
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nombre'])) {
    $nombre = $conn->real_escape_string($_POST['nombre']);
    $descripcion = $conn->real_escape_string($_POST['descripcion']);
    $precio = floatval($_POST['precio']);
    $cantidad = intval($_POST['cantidad']);

    $imagenNombre = "";
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === 0) {
        $imagenNombre = time() . "_" . basename($_FILES['imagen']['name']);
        $destino = __DIR__ . "/uploads/" . $imagenNombre;
        move_uploaded_file($_FILES['imagen']['tmp_name'], $destino);
    }

    $sql = "INSERT INTO productos (nombre, descripcion, precio, cantidad, imagen)
            VALUES ('$nombre', '$descripcion', $precio, $cantidad, '$imagenNombre')";
    if ($conn->query($sql)) {
        $mensaje = "Producto agregado correctamente.";
    } else {
        $mensaje = "Error: " . $conn->error;
    }
}

// Obtener productos
$sql = "SELECT * FROM productos ORDER BY id DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Panel Administrador</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    body {
      background: #121212;
      color: #f5f5f5;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    .container {
      padding-top: 20px;
    }
    h1 {
      color: #f39c12;
      text-align: center;
      margin-bottom: 20px;
    }
    .btn-logout {
      background: #e74c3c;
      border: none;
      color: white;
      font-weight: bold;
      float: right;
      margin-bottom: 20px;
    }
    .btn-logout:hover {
      background: #c0392b;
    }
    .form-control, .btn {
      border-radius: 0;
    }
    .card {
      background-color: #222;
      margin-bottom: 15px;
    }
    table {
      color: #f5f5f5;
    }
    .btn-add {
      background-color: #f39c12;
      border: none;
      color: black;
      font-weight: bold;
    }
    .btn-add:hover {
      background-color: #e67e22;
      color: white;
    }
    .btn-edit {
      background-color: #3498db;
      border: none;
    }
    .btn-edit:hover {
      background-color: #2980b9;
    }
    .btn-delete {
      background-color: #e74c3c;
      border: none;
    }
    .btn-delete:hover {
      background-color: #c0392b;
    }
  </style>
</head>
<body>
  <div class="container">
    <a href="logout.php" class="btn btn-logout">Cerrar sesión</a>
    <h1>Panel de administración</h1>

    <?php if ($mensaje): ?>
      <div class="alert alert-info"><?php echo $mensaje; ?></div>
    <?php endif; ?>

    <form method="post" enctype="multipart/form-data" class="mb-4">
      <h4>Agregar nuevo producto</h4>
      <div class="mb-3">
        <input type="text" name="nombre" class="form-control" placeholder="Nombre del producto" required />
      </div>
      <div class="mb-3">
        <textarea name="descripcion" class="form-control" placeholder="Descripción" required></textarea>
      </div>
      <div class="mb-3">
        <input type="number" step="0.01" name="precio" class="form-control" placeholder="Precio" required />
      </div>
      <div class="mb-3">
        <input type="number" name="cantidad" class="form-control" placeholder="Cantidad" required />
      </div>
      <div class="mb-3">
        <input type="file" name="imagen" accept="image/*" required />
      </div>
      <button type="submit" class="btn btn-add">Agregar producto</button>
    </form>

    <h4>Productos agregados</h4>
    <?php if ($result && $result->num_rows > 0): ?>
      <table class="table table-dark table-striped">
        <thead>
          <tr>
            <th>Imagen</th>
            <th>Nombre</th>
            <th>Descripción</th>
            <th>Precio</th>
            <th>Cantidad</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($row = $result->fetch_assoc()): ?>
          <tr>
            <td><img src="uploads/<?php echo htmlspecialchars($row['imagen']); ?>" alt="" width="60" height="60" style="object-fit: cover;"></td>
            <td><?php echo htmlspecialchars($row['nombre']); ?></td>
            <td><?php echo htmlspecialchars($row['descripcion']); ?></td>
            <td>$<?php echo number_format($row['precio'], 2); ?></td>
            <td><?php echo intval($row['cantidad']); ?></td>
            <td>
              <a href="editar.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-edit text-white">Editar</a>
              <a href="eliminar.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-delete text-white" onclick="return confirm('¿Estás seguro de eliminar este producto?');">Eliminar</a>
            </td>
          </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    <?php else: ?>
      <p>No hay productos agregados.</p>
    <?php endif; ?>
  </div>
</body>
</html>
<?php $conn->close(); ?>
