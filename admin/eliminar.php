<?php
require '../db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Eliminar imagen del servidor
    $res = $conn->query("SELECT imagen FROM productos WHERE id = $id");
    $img = $res->fetch_assoc();
    unlink("uploads/" . $img['imagen']);

    // Eliminar de la base de datos
    $conn->query("DELETE FROM productos WHERE id = $id");
}

header("Location: dashboard.php");
exit;
?>
