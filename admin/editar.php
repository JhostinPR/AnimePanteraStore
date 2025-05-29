<?php
require '../db.php';
$id = $_GET['id'];
$res = $conn->query("SELECT * FROM productos WHERE id = $id");
$row = $res->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Editar Producto</title>
  <link rel="stylesheet" href="../css/style.css">
</head>
<body>
  <h1>Editar Producto</h1>
  <form action="actualizar.php" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?= $row['id'] ?>">
    <input type="text" name="nombre" value="<?= $row['nombre'] ?>" required><br>
    <textarea name="descripcion"><?= $row['descripcion'] ?></textarea><br>
    <input type="number" name="precio" value="<?= $row['precio'] ?>" step="0.01" required><br>
    <input type="number" name="cantidad" value="<?= $row['cantidad'] ?>" required><br>
    <img src="uploads/<?= $row['imagen'] ?>" width="100"><br>
    <label>Nueva imagen (opcional)</label>
    <input type="file" name="imagen"><br><br>
    <button type="submit">Actualizar</button>
  </form>
</body>
</html>
