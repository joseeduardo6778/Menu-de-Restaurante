<?php
// Establecer la conexión a la base de datos (asegúrate de reemplazar con tus credenciales)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "producto";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Obtener los datos del carrito de la solicitud POST
$productName = $_POST['product_name'];
$productPrice = $_POST['product_price'];
$quantity = $_POST['quantity'];

// Insertar los datos en la tabla del carrito
$sql = "INSERT INTO carrito (product_name, product_price, quantity) VALUES ('$productName', $productPrice, $quantity)";

if ($conn->query($sql) === TRUE) {
    echo "Elemento del carrito guardado con éxito";
} else {
    echo "Error al guardar el elemento del carrito: " . $conn->error;
}

// Cerrar la conexión a la base de datos
$conn->close();
?>
