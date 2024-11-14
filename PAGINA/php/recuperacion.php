<?php
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];

    // Verificar si el correo existe
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Aquí iría el envío del enlace de recuperación por correo
        echo "Se ha enviado un enlace de recuperación a tu correo.";
    } else {
        echo "No se encontró una cuenta con ese correo.";
    }
}
?>