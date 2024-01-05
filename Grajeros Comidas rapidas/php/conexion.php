<?php
$server='localhost';
$user='root';
$pass='';
$bd='producto';

$conexion=mysqli_connect($server,$user,$pass,$bd);

if($conexion){
    echo "conexion exitosa";
}
?>