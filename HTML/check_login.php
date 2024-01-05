<?php
$username = $_POST['user']; //Set UserName
$password = $_POST['pwd']; //Set Password
$msg ='';
if(isset($username, $password)) {
    ob_start();

$conexion = new mysqli("localhost", "dialeruser", "dialerpass", "dialerdb");
// Verificar la conexión
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

	$myusername = stripslashes($username);
	$mypassword = stripslashes($password);

	$sql="SELECT * FROM login_admin WHERE user_name='$myusername' and user_pass=SHA('$mypassword')";

	$result = $conexion->query($sql);
	$count = $result->num_rows;

    // If result matched $myusername and $mypassword, table row must be 1 row
    if($count==1){
        // Register $myusername, $mypassword and redirect to file "admin.php"
        /*session_register("admin");
        session_register("password");
        $_SESSION['name']= $myusername;*/

	session_start();
        $_SESSION['login'] = "1";
        $_SESSION['name']= $myusername;

        header("location:upload.php");
    }
    else {
        $msg = "Wrong Username or Password. Please retry&type=0";
        header("location:index.php?msg=$msg");
    }
    ob_end_flush();
}
else {
    header("location:index.php?msg=Please enter  username and password");
}
?>
