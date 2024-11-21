<?php
// Configuración de la base de datos
$host = "localhost"; // El servidor de base de datos (localhost si es local)
$dbname = "mi_base_de_datos"; // El nombre de tu base de datos
$username_db = "root"; // El usuario de la base de datos (por defecto en XAMPP es "root")
$password_db = ""; // La contraseña (en XAMPP por defecto no hay contraseña)

// Conectar a la base de datos usando PDO
try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username_db, $password_db);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Habilitar manejo de errores
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage()); // Si no se puede conectar, muestra el error
}
?>
