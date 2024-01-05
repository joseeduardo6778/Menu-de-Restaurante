<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "producto";

$compras = array(); // Un array para almacenar los datos de las compras

// Conexión a la base de datos
$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("La conexión a la base de datos falló: " . $conn->connect_error);
}

// Consulta SQL para obtener datos de la tabla compras
$sql = "SELECT cliente_id, producto, precio_unitario, cantidad, subtotal FROM compras";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $compras[] = $row; // Almacena los datos de compra en el array
    }
}

$conn->close();
?>
