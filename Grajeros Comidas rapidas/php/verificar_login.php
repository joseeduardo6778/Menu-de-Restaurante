<?php
session_start();

// Define el número máximo de intentos permitidos
$maxIntentos = 3;

// Comprueba si la variable de sesión para el contador de intentos existe
if (!isset($_SESSION['intentos'])) {
    $_SESSION['intentos'] = 0;
}

// Comprueba si el formulario se envió
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Comprueba si se han excedido los intentos máximos
    if ($_SESSION['intentos'] >= $maxIntentos) {
        // El usuario ha excedido el número máximo de intentos permitidos, bloquea su acceso
        echo "Demasiados intentos fallidos. Por favor, inténtalo de nuevo más tarde.";
    } else {
        // Comprueba las credenciales (usuario y contraseña). Aquí debes realizar tu propia lógica de autenticación.
        $usuario_valido = "Admin248778";
        $password_hash_valido = password_hash("gXpGPqd8CMjT5Y", PASSWORD_DEFAULT); // Hash de la contraseña válida

        $usuario_ingresado = $_POST["usuario"];
        $contrasena_ingresada = $_POST["pass"];

        if ($usuario_ingresado == $usuario_valido && password_verify($contrasena_ingresada, $password_hash_valido)) {
            // Las credenciales son válidas, inicia sesión
            $_SESSION['usuario'] = $usuario_valido;
            
            // Reinicia el contador de intentos
            $_SESSION['intentos'] = 0;

            // Redirige al usuario a la página deseada
            header("Location: ../lista_pedidos.php");
            exit();
        } else {
            // Las credenciales no son válidas, muestra un mensaje de error
            echo "Credenciales incorrectas. Por favor, inténtalo de nuevo.";
            
            // Incrementa el contador de intentos fallidos
            $_SESSION['intentos']++;
        }
    }
}

?>

