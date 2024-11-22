<?php
// Configuración inicial
session_start();

// Incluir la conexión a la base de datos
include 'db.php';

// Verificar si se accede con un token válido
if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Validar el token
    $stmt = $conn->prepare("SELECT * FROM usuarios WHERE reset_token = :token AND reset_token_expiry > NOW()");
    $stmt->execute([':token' => $token]);

    if ($stmt->rowCount() === 0) {
        die("El token no es válido o ha expirado.");
    }

    // Si el formulario fue enviado
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $password = trim($_POST['password']);
        $confirm_password = trim($_POST['confirm_password']);

        if (empty($password) || $password !== $confirm_password) {
            die("Las contraseñas no coinciden.");
        }

        // Encriptar la nueva contraseña
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        // Actualizar la contraseña y eliminar el token
        $stmt = $conn->prepare("UPDATE usuarios SET password = :password, reset_token = NULL, reset_token_expiry = NULL WHERE reset_token = :token");
        $stmt->execute([
            ':password' => $hashed_password,
            ':token' => $token
        ]);

        echo "Contraseña restablecida correctamente. <a href='../public/login.html'>Inicia sesión</a>";
    }
} else {
    die("Acceso no autorizado.");
}
?>
