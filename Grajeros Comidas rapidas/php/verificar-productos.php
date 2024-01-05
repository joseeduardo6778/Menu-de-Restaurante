<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$database = "producto";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Recibir los datos de productos (nombre y precio) enviados desde el cliente
$data = json_decode(file_get_contents('php://input'));

if (empty($data)) {
    echo json_encode(['valid' => false, 'message' => 'No se enviaron productos para verificar.']);
} else {
    $validProducts = [];
    $invalidProducts = [];

    foreach ($data as $product) {
        // Escapar y formatear los datos de productos para la consulta SQL
        $productName = $conn->real_escape_string($product->nombre);
        $productPrice = floatval($product->precio);

        // Consulta SQL para verificar la existencia de productos en la base de datos
        $sql = "SELECT nombre, precio FROM productos WHERE nombre = '$productName' AND precio = $productPrice";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $validProducts[] = $product;
        } else {
            $invalidProducts[] = $product;
        }
    }

    // Si hay productos no válidos, responde con un mensaje de error
    if (!empty($invalidProducts)) {
        echo json_encode(['valid' => false, 'message' => 'Algunos productos no están disponibles.', 'invalidProducts' => $invalidProducts]);
    } else {
        // Todos los productos son válidos
        echo json_encode(['valid' => true, 'message' => 'Todos los productos son válidos.', 'validProducts' => $validProducts]);
    }
}

$conn->close();
?>
