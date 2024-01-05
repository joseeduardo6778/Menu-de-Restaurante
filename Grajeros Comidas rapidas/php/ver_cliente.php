<?php
// Configuración de la base de datos
$servername = "localhost";
$username = "root"; // Reemplaza con tu nombre de usuario de la base de datos
$password = ""; // Reemplaza con tu contraseña de la base de datos
$database = "producto";

// Conexión a la base de datos
$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("La conexión a la base de datos falló: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $clientID = $_GET['id'];
    
    // Consulta SQL para obtener la información del cliente
    $sql = "SELECT nombres, apellidos, direccion, telefono FROM clientes WHERE id = $clientID";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $nombres = $row['nombres'];
        $apellidos = $row['apellidos'];
        $direccion = $row['direccion'];
        $telefono = $row['telefono'];
    
        // Muestra la información del cliente dentro del cuadro con la clase 'client-info-box'
        echo "<div class='client-info-box'>";
        echo "<h2>Información del Cliente:</h2>";
        echo "<p><strong>Nombres:</strong> $nombres</p>";
        echo "<p><strong>Apellidos:</strong> $apellidos</p>";
        echo "<p><strong>Pedido direccion o mesa:</strong> $direccion</p>";
        echo "<p><strong>Teléfono:</strong> $telefono</p>";
        echo "</div>";
        
    } else {
        echo "No se encontró información para el cliente con ID $clientID.";
    }
}

$conn->close();
?>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700&display=swap');
    /* Estilo para el cuadro de información del cliente */
    

    body {
        font-family: 'Montserrat', sans-serif;
        background-color: var(--fondo);
    }
    .client-info-box {
        background-color: #659AA6;
        border: 1px solid #ddd;
        border-radius: 5px;
        padding: 20px;
        width: 400px;
        margin: 20px auto; /* Añade un margen superior e inferior para separar del botón */
        text-align: left;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        display: none; /* Oculta el cuadro por defecto */
    }
    button{
        background-color: #659AA6;
        color: #fff;
        border: none;
        border-radius: 5px;
        padding: 10px 20px;
        margin: 5px auto;
        cursor: pointer;
        font-family: 'Montserrat', sans-serif;
    }
    
</style>
<script>
    // Función para alternar la visibilidad del cuadro de información del cliente
    function toggleClientInfo() {
        var infoBox = document.querySelector('.client-info-box');
        if (infoBox.style.display === 'none' || infoBox.style.display === '') {
            infoBox.style.display = 'block';
        } else {
            infoBox.style.display = 'none';
        }
    }

    // Agrega un botón para mostrar u ocultar la información del cliente
    var toggleButton = document.createElement('button');
    toggleButton.textContent = 'Mostrar/ocultar información del cliente';
    toggleButton.addEventListener('click', toggleClientInfo);

    // Inserta el botón al principio de la página
    document.body.insertBefore(toggleButton, document.body.firstChild);
</script>