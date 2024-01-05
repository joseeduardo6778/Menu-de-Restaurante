<?php
// Conecta a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$database = "producto";

$conn = new mysqli($servername, $username, $password, $database);

// Verifica la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if (isset($_POST['btn-agregar'])) {
    // Recibe los datos del campo oculto y los decodifica desde JSON
    $detallesCompraJSON = $_POST['productos'];
    $detallesCompra = json_decode($detallesCompraJSON);

    $products = $detallesCompra->products;
    $total = 0.0;

    // Preparar la consulta para insertar el cliente
    $sqlCliente = 'INSERT INTO clientes (nombres, apellidos, direccion, telefono) VALUES (?, ?, ?, ?)';
    $stmtCliente = $conn->prepare($sqlCliente);

    // Vincular los parámetros
    $stmtCliente->bind_param('ssss', $nombre, $apellido, $direccion, $telefono);

    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $direccion = $_POST['direccion'];
    $telefono = $_POST['telefono'];

    // Ejecutar la consulta para insertar el cliente
    $stmtCliente->execute();

    if ($stmtCliente->error) {
        echo "Error al guardar los datos del cliente: " . $stmtCliente->error;
    } else {
        // Obtiene el ID del cliente recién insertado
        $cliente_id = $stmtCliente->insert_id;

        // Preparar la consulta para insertar los detalles de la compra
        $sqlCompra = 'INSERT INTO compras (cliente_id, producto, precio_unitario, cantidad, subtotal, textarea) VALUES (?, ?, ?, ?, ?, ?)';
        $stmtCompra = $conn->prepare($sqlCompra);

        // Vincular los parámetros
        $stmtCompra->bind_param('isidid', $cliente_id, $nombreProducto, $precio, $cantidad, $subtotal, $comentario);

        // Insertar los detalles de la compra en la base de datos
        foreach ($products as $product) {
            $nombreProducto = $product->name;
            $precio = $product->price;
            $cantidad = $product->quantity;
            $subtotal = $precio * $cantidad;
            $comentario = $product->Textarea;
            $total += $subtotal;

            $stmtCompra->execute();
        }

        // Actualizar el campo "total" en la tabla de clientes
        $sqlActualizarTotal = "UPDATE clientes SET total = $total WHERE id = $cliente_id";
        $conn->query($sqlActualizarTotal);

        echo "Los datos del cliente y los detalles de la compra se han guardado correctamente.";
        header("Location: ../index.php");
    }
}

// Cierra la conexión a la base de datos
$conn->close();
?>
