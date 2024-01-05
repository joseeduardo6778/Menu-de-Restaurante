<?php
// Configuración de la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$database = "producto";

// Conexión a la base de datos
$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("La conexión a la base de datos falló: " . $conn->connect_error);
}

// Recibe el ID enviado por la solicitud AJAX
$id = $_POST['id'];

// Elimina la fila correspondiente en la base de datos
$sql = "DELETE FROM compras WHERE cliente_id = '$id'";
$clienteSQL = "DELETE FROM clientes WHERE id = '$id'";

if ($conn->query($sql) === TRUE && $conn->query($clienteSQL) == TRUE) {
    echo "success"; // Devuelve "success" si la eliminación fue exitosa
} else {
    echo "Error al eliminar los datos: " . $conn->error;
}

$conn->close();
?>
