<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario'])) {
    // El usuario no ha iniciado sesión, redirige a login.html
    header("Location: login.html");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Visualización de las Ordenes</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/stylePedido.css">
    <link rel="shortcut icon" href="img/icono_pagina.png">
    <meta http-equiv=refresh content=20>
</head>
<body>
    <header>
        <a href="#" class="logo">
            <img src="img/icono_pagina.png" class="logo-img">
            <p class="logo-nombre">Visualizacion de los pedidos</p>
        </a>
        <a href="index.php" class="dropdown-menu">
            <i class="fas fa-home"></i>
            Pagina inicial
        </a>
        <a href="Registro.php" class="dropdown-menu">
            <i class="fas fa-home"></i>
            Registro de productos
        </a>
    </header>
    <h1>Orden de Pedidos</h1>
    <div class="container_listapedidos">

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


        // Consulta SQL para obtener datos de la tabla compras
        $sql = "SELECT cliente_id, producto, precio_unitario, cantidad, subtotal FROM compras";
        $result = $conn->query($sql);
      

        if ($result->num_rows > 0) {
            $currentClienteID = null; // Variable para rastrear el cliente actual
            $totalSubtotal = 0.0; // Variable para rastrear el total de subtotales por cliente

            while ($row = $result->fetch_assoc()) {
                if ($row['cliente_id'] !== $currentClienteID) {
                    // Comienza una nueva tabla para un cliente diferente
                    if ($currentClienteID !== null) {
                        // Muestra el total de subtotales para el cliente anterior
                        echo "<tr>";
                        echo "<td colspan='4'><strong>Total:</strong></td>";
                        echo "<td>" . number_format($totalSubtotal, 3) . "</td>";
                        echo "</tr>";
                        echo "</table>";
                    }
                    $currentClienteID = $row['cliente_id'];
                    $totalSubtotal = 0.0; // Restablece el total de subtotales
                    echo "<h2>Pedido $currentClienteID : </h2>";
                    echo "<table>";
                    echo "<tr>";
                    echo "<th>Opciones</th>";
                    echo "<th>Producto</th>";
                    echo "<th>Precio Unitario</th>";
                    echo "<th>Cantidad</th>";
                    echo "<th>Subtotal</th>";
                    echo "</tr>";
                }
                
                // Muestra los detalles de la compra para el cliente actual
                echo "<tr data-id='{$row['cliente_id']}'>";
                echo "<td><button class='btn-primary' onclick='deleteRow(this)'>Eliminar</button> <br><br> <button class='btn-primary' onclick='openClientInfo($currentClienteID)'>Ver Cliente</button></td>";
                echo "<td>" . $row['producto'] . "</td>";
                echo "<td>" . $row['precio_unitario'] . "</td>";
                echo "<td>" . $row['cantidad'] . "</td>";
                echo "<td>" . $row['subtotal'] . "</td>";
                echo "</tr>";

                // Suma el subtotal al total del cliente
                $totalSubtotal += $row['subtotal'];
            }

            // Muestra el total de subtotales para el último cliente
            echo "<tr>";
            echo "<td colspan='4'><strong>Total:</strong></td>";
            echo "<td>" . number_format($totalSubtotal, 3) . "</td>";
            echo "</tr>";

            echo "</table>"; // Cierra la última tabla

        } else {
            echo "No se encontraron registros en la tabla de compras.";
        }

        $conn->close();
        ?>
    </div>

<script>
function deleteRow(button) {
    // Obtén la fila actual
    const row = button.parentElement.parentElement;

    // Obtén el ID de la fila que deseas eliminar
    const id = row.dataset.id; // Asegúrate de asignar un atributo "data-id" a la fila que contenga el ID

    // Realiza una solicitud AJAX para eliminar el registro en la base de datos
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "php/eliminar_compra.php", true); // Reemplaza "eliminar_compra.php" por tu script de eliminación
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            if (xhr.responseText === "success") {
                const container = document.querySelector(".container_listapedidos");
                location.reload();
                row.remove();
            } else {
                alert("Error al eliminar los datos.");
            }
        }
    };
    // Envía el ID al servidor para eliminar el registro específico
    xhr.send(`id=${id}`);
}
function deleteTable() {
    // Realiza una solicitud AJAX al servidor para eliminar la tabla completa en la base de datos
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "eliminar_tabla_compras.php", true); // Reemplaza "eliminar_tabla_compras.php" por tu script de eliminación de tabla
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            if (xhr.responseText === "success") {
                // Si la eliminación de la tabla es exitosa, elimina la tabla completa del DOM
                const container = document.querySelector('.container_listapedidos');
                container.innerHTML = "Tabla eliminada con éxito.";
            } else {
                alert("Error al eliminar la tabla.");
            }
        }
    };
    // Envía una solicitud al servidor para eliminar la tabla completa
    xhr.send();
}
function openClientInfo(clientID) {
    // Abre una nueva ventana emergente con la información del cliente
    const url = `php/ver_cliente.php?id=${clientID}`; // Reemplaza 'ver_cliente.php' con la página que muestra la información del cliente
    window.open(url, "ClienteInfo", "width=400, height=380");
}
window.addEventListener("beforeunload", function (e) {
            // Realizar una solicitud AJAX para cerrar la sesión en el servidor
    const xhr = new XMLHttpRequest();
    xhr.open("GET", "php/cerrar_sesion.php", false); // Reemplaza con la ruta correcta de tu script de cierre de sesión
    xhr.send();

            // Puedes mostrar un mensaje de despedida si lo deseas
    e.returnValue = "¡Hasta pronto!"; // Este mensaje se mostrará en un cuadro de confirmación del navegador
});


</script>
<style>
    
    .btn-primary {
    background-color: #C9C6C6;
    color: #383838;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
  }

  /* Estilo para el botón en hover (al pasar el ratón sobre él) */
  .btn-primary:hover {
    background-color: #7abaff;
  }
   
</style>
</body>
</html>
