<?php
require '../db.php';

$id = $_POST['id'];
$nombre = $_POST['nombre'];
$descripcion = $_POST['descripcion'];
$precio = $_POST['precio'];
$cantidad = $_POST['cantidad'];

if ($_FILES['imagen']['name']) {
    // Eliminar imagen anterior
    $res = $conn->query("SELECT imagen FROM productos WHERE id = $id");
    $img = $res->fetch_assoc();
    unlink("uploads/" . $img['imagen']);

    $nombre_imagen = time() . "_" . $_FILES['imagen']['name'];
    move_uploaded_file($_FILES['imagen']['tmp_name'], "uploads/" . $nombre_imagen);

    $sql = "UPDATE productos SET nombre='$nombre', descripcion='$descripcion', precio=$precio, cantidad=$cantidad, imagen='$nombre_imagen' WHERE id=$id";
} else {
    $sql = "UPDATE productos SET nombre='$nombre', descripcion='$descripcion', precio=$precio, cantidad=$cantidad WHERE id=$id";
}

$conn->query($sql);
header("Location: dashboard.php");
exit;
?>
