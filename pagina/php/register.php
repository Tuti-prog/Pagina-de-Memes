<?php
// Incluir la conexión a la base de datos
include 'db.php'; // Asegúrate de que la ruta sea correcta

// Obtener los datos del formulario
$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];

// Validaciones
if ($password !== $confirm_password) {
    die("Las contraseñas no coinciden.");
}

if (empty($username) || empty($email) || empty($password)) {
    die("Por favor, completa todos los campos.");
}

// Encriptar la contraseña
$hashed_password = password_hash($password, PASSWORD_BCRYPT);

// Insertar el usuario en la base de datos
try {
    $stmt = $conn->prepare("INSERT INTO usuarios (username, email, password) VALUES (:username, :email, :password)");
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $hashed_password);
    $stmt->execute();
    
    // Redirigir a la página principal
    header("Location: ../public/index.html"); // Cambia esto a la URL o página principal que desees
    exit;

} catch (PDOException $e) {
    echo "Error al registrar el usuario: " . $e->getMessage();
}
?>
