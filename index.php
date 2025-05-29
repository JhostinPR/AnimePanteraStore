<?php
$conn = new mysqli("localhost", "root", "", "inventario");
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$sql = "SELECT * FROM productos ORDER BY id DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Catálogo de Productos</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #1a1a1a;
      color: #fff;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    .product-card {
      background: #2c2c2c;
      border: 2px solid #f39c12;
      border-radius: 15px;
      padding: 15px;
      box-shadow: 0 0 10px #f39c12;
      transition: transform 0.3s ease;
    }
    .product-card:hover {
      transform: scale(1.05);
      box-shadow: 0 0 15px #e76f51;
    }
    .btn-details {
      background-color: #e76f51;
      color: white;
      font-weight: bold;
      border: none;
    }
    .btn-details:hover {
      background-color: #f39c12;
    }
    h1 {
      font-family: 'Comic Sans MS', cursive;
      color: #e9c46a;
      text-align: center;
      margin-top: 20px;
    }
    .modal-content {
      background-color: #2c2c2c;
      color: white;
      border: 2px solid #f39c12;
    }
  </style>
</head>
<body>
  <div class="container py-4">
    <h1>Catálogo Anime</h1>
    <div class="row">
      <?php while ($row = $result->fetch_assoc()): ?>
        <div class="col-md-4 mb-4">
          <div class="product-card">
            <img src="admin/uploads/<?php echo htmlspecialchars($row['imagen']); ?>" class="img-fluid rounded" alt="Producto">
            <h4 class="mt-2"><?php echo htmlspecialchars($row['nombre']); ?></h4>
            <p><strong>Precio:</strong> $<?php echo number_format($row['precio'], 2); ?></p>
            <p><strong>Cantidad:</strong> <?php echo intval($row['cantidad']); ?></p>
            <button class="btn btn-details" data-bs-toggle="modal" data-bs-target="#modal<?php echo $row['id']; ?>">
              Ver detalles
            </button>
          </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="modal<?php echo $row['id']; ?>" tabindex="-1" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title"><?php echo htmlspecialchars($row['nombre']); ?></h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
              </div>
              <div class="modal-body">
                <img src="admin/uploads/<?php echo htmlspecialchars($row['imagen']); ?>" class="img-fluid rounded mb-2">
                <p><strong>Descripción:</strong><br><?php echo nl2br(htmlspecialchars($row['descripcion'])); ?></p>
                <p><strong>Precio:</strong> $<?php echo number_format($row['precio'], 2); ?></p>
                <p><strong>Cantidad disponible:</strong> <?php echo intval($row['cantidad']); ?></p>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
              </div>
            </div>
          </div>
        </div>
      <?php endwhile; ?>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php $conn->close(); ?>
