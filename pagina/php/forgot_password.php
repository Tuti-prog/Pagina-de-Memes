<?php
// Incluir la conexión a la base de datos
include 'db.php';

// Verificar si se envió el formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);

    // Validar correo electrónico
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Correo electrónico no válido.");
    }

    // Verificar si el correo existe
    $stmt = $conn->prepare("SELECT * FROM usuarios WHERE email = :email");
    $stmt->execute([':email' => $email]);

    if ($stmt->rowCount() === 0) {
        die("No se encontró una cuenta asociada a este correo.");
    }

    // Generar un token único
    $token = bin2hex(random_bytes(50)); // Genera un token único
    $expiry = date('Y-m-d H:i:s', strtotime('+1 hour')); // Token expira en 1 hora

    // Guardar el token en la base de datos
    $stmt = $conn->prepare("UPDATE usuarios SET reset_token = :token, reset_token_expiry = :expiry WHERE email = :email");
    $stmt->execute([
        ':token' => $token,
        ':expiry' => $expiry,
        ':email' => $email
    ]);

    // Crear el enlace de recuperación
    $resetLink = "http://localhost/mi_proyecto/public/reset_password.html?token=$token"; // Cambia 'mi_proyecto' por el nombre de tu carpeta

    // Asunto y cuerpo del correo
    $subject = "Recuperación de Contraseña";
    $body = "Hola, \n\nHaz clic en el siguiente enlace para restablecer tu contraseña:\n\n$resetLink\n\nEste enlace expirará en 1 hora.";

    // Cabeceras del correo
    $headers = "From: no-reply@yourwebsite.com\r\n";
    $headers .= "Reply-To: no-reply@yourwebsite.com\r\n";
    $headers .= "X-Mailer: PHP/" . phpversion();

    // Enviar el correo
    if (mail($email, $subject, $body, $headers)) {
        echo "Correo enviado. Revisa tu bandeja de entrada.";
    } else {
        echo "Error al enviar el correo.";
    }
} else {
    // Redirigir al formulario si no se accede por POST
    header("Location: ../public/forgot_password.html");
    exit;
}
?>
