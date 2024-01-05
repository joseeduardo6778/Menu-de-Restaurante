<?php
require_once('php/conexion.php');

if(isset($_REQUEST['btn-agregar'])){

    $name = trim($_POST['name']);
    $precio = trim($_POST['precio']);
    $descripcion = trim($_POST['descripcion']);
    $tipos = trim($_POST['tipo_producto']);


    $nombre_imagen=$_FILES['foto']['name'];
    $temporal=$_FILES['foto']['tmp_name'];
    $carpeta='img_pro';
    $ruta=$carpeta.'/'.$nombre_imagen;
    move_uploaded_file($temporal,$carpeta.'/'. $nombre_imagen);

    $query="INSERT INTO productos (nombre,precio,imagen,descripcion,tipos) VALUES('$name','$precio','$ruta','$descripcion','$tipos')";
    $execute= mysqli_query($conexion,$query) or die(mysqli_error ($conexion));

    if($execute){
        header("Location: Registro.php");
    }else{
        echo "hubo un error";
    }
}



?>