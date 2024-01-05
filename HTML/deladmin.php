<?php
session_start(); //Start the session


if (!isset($_SESSION["admin"])) {
     header("location:index.php");
}



$desc=$_GET["desc"];

if($desc == 'admin'){
	echo 'El usuario admin no puede ser eliminado';
}else{

$host="localhost";
$user="dialeruser";
$pass="dialerpass";
$db="dialerdb";

$link = new mysqli($host, $user,$pass, $db);
// Verificar la conexión
if ($link->connect_error) {
    die("Error de conexión: " . $link->connect_error);
}

$sql="DELETE FROM login_admin WHERE user_name = '".$desc."'";

$res = $link->query($sql) or die($link->error);

}
 
 header("Location: admins.php")

?>
