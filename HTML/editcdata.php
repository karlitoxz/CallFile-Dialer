<?php
session_start();

if (!(isset($_SESSION['login']) && $_SESSION['login'] != '')) {
header ("Location: index.php");
}else{ //Continue to current page
header( 'Content-Type: text/html; charset=utf-8' );
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
	<title>Dialer System</title>
	<link rel="stylesheet" href="css/style.css" type="text/css" media="all" />
</head>
<body>

<!-- Container -->
<div id="container">
	<div class="shell">
		
		<!-- Small Nav -->
		<div class="small-nav">
			<!--<a href="#">Dashboard</a>
			<span>&gt;</span>
			Current Articles-->
		</div>
		<!-- End Small Nav -->
		
			
		
		<br />
		<!-- Main -->
		<div id="main">
			<div class="cl">&nbsp;</div>
			
			<!-- Content -->
			<div id="content4">
				
				<!-- Box -->
				<div class="box">
					<!-- Box Head -->
					<div class="box-head">
						<h2>Edit User Data<span class="req"></span></h2>>
					</div>
					<!-- End Box Head -->

<?php
if(isset($_POST['button'])){
        $errors = array(); // declaramos un array para almacenar los errores
        if($_POST['name'] == ''){
            $errors1 = '<span class="error2">Insert a Name</span>';
        }else if($_POST['lastname'] == ''){
            $errors2 = '<span class="error2">Insert a LastName</span>';
        }else if($_POST['tel'] == ''){
            $errors3 = '<span class="error2">Insert a Telephone</span>';
        }else{

		$host="localhost";
		$user="dialeruser";
		$pass="dialerpass";
		$db="dialerdb";
		$id=$_POST["id"];
		$name=$_POST["name"];
		$lastname=$_POST["lastname"];
		$tel=$_POST["tel"];
		$campname=$_POST['campname'];



$link = new mysqli("localhost", $user,$pass, $db);
// Verificar la conexión
if ($link->connect_error) {
    die("Error de conexión: " . $link->connect_error);
}


		$sql1 = "UPDATE " .$campname. " set Name='$name', LastName='$lastname', Tel='$tel'  where ID='$id'";

$result = $link->query($sql1) or die($link->error);


		$_POST['name'] = '';
		$_POST['lastname'] = '';
		$_POST['tel'] = '';
		//$_POST['prefix'] = '';
		
		
		echo "	<SCRIPT LANGUAGE='JavaScript'>
			 window.opener.document.location='campaigns.php?pin=$campname'
			 window.close();
			 </SCRIPT>";
				
            
        }
    }
?>

					
					<form  id="contact-form" action="" method="post">
						
						<!-- Form -->
						<div class="form">
	

					<?php

$link = new mysqli("localhost", "dialeruser", "dialerpass", "dialerdb");
// Verificar la conexión
if ($link->connect_error) {
    die("Error de conexión: " . $link->connect_error);
}
						$pin=$_GET['pin'];
						$campname=$_GET['campname'];

						$sql="SELECT ID,NameCamp,Name,LastName,Tel,Tries FROM " .$campname. " WHERE ID='$pin'";

						$res = $link->query($sql) or die($link->error);
						$row = mysqli_fetch_assoc($res);

						$id=$row['ID'];					
						$name=$row['Name'];
						$lastname=$row['LastName'];
						$tel=$row['Tel'];
						$campname=$row['NameCamp'];
						

						echo "<p>
							<label>Name<span><span><label>$errors1
							<input type='text' name=name class='field' value='$name'/>
							</p>
							
							<p>
							<label>Last Name<span><span><label>$errors2
							<input type='text' name=lastname class='field' value='$lastname'/>
							</p>
							
							<p>
							<label>Telephone<span><span><label>$errors3
							<input type='text' name=tel class='field' value='$tel'/>
							</p>
							
							
							<p>
							
							<input type='hidden' name=campname class='field' value='$campname'READONLY/>
							</p>
							<p>
							
							<input type='hidden' name=id class='field' value='$id'READONLY/>
							</p>
							
							</div>";
						$link->close();
					?>	
						
						<!-- Form Buttons -->
						<div class="buttons">
							
							<input name="button" type="submit" class="button" value="submit" />
							
						</div>
						<!-- End Form Buttons -->
					</form>
				</div>
				<!-- End Box -->

			</div>
			<!-- End Content -->
			
			
			<div class="cl">&nbsp;</div>			
		</div>
		<!-- Main -->
	</div>
</div>
<script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ=" crossorigin="anonymous"></script>
<script src='funciones.js'></script>
<p align="center">&copy; <a href="http://chocotemplates.com/" target="_blank">Design by ChocoTemplates</a> 2012 / Adapted for <a href="http://digital-merge.com" target="_blank">Digital-Merge</a></p><p align="center"><a href="http://about.me/navaismo" target="_blank"> Modified by Navaismo</a></p></body>
</html>
