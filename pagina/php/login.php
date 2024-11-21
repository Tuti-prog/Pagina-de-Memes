<?php

// Configuración inicial
session_start(); // Iniciar sesión para almacenar datos del usuario si es necesario

// Datos simulados (deberías reemplazarlos con tu base de datos)
$usuarios = [
    "admin" => "123456", // Usuario: admin, Contraseña: 123456
    "usuario" => "password", // Usuario: usuario, Contraseña: password
];

// Verificar si se enviaron los datos del formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Validar que los campos no estén vacíos
    if (empty($username) || empty($password)) {
        die("Por favor, completa todos los campos.");
    }

    // Verificar credenciales
    if (isset($usuarios[$username]) && $usuarios[$username] === $password) {
        // Inicio de sesión exitoso
        $_SESSION['usuario'] = $username;
        header("Location: dashboard.php"); // Redirigir a otra página (ej. un dashboard)
        exit;
    } else {
        // Error en las credenciales
        echo "Nombre de usuario o contraseña incorrectos.";
    }
} else {
    // Si no se accede por POST, redirigir al formulario de inicio de sesión
    header("Location: ../login.html");
    exit;
}
?>
