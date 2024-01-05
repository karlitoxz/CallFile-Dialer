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
<script>
function popup(mylink, windowname)
{
if (! window.focus)return true;
var href;
if (typeof(mylink) == 'string')
   href=mylink;
else
   href=mylink.href;
window.open(href, windowname, 'location=0,width=320,height=420,resizable=0,scrollbars=no');
return false;
}
</script>

</head>
<body>
<!-- Header -->
<div id="header">
	<div class="shell">
		<!-- Logo + Top Nav -->
		<div id="top">
			<h1><a href="#">Dialer System</a></h1>
			<div id="top-navigation">
				Welcome <strong><?php echo $_SESSION['name'];?></strong>
				<span>|</span>
				<a href="#">Help</a>
				<span>|</span>
                                <a href="logout.php">logout</a>

			</div>
		</div>
		<!-- End Logo + Top Nav -->
		
		<!-- Main Nav -->
		<div id="navigation">
			<ul>
  			    <li><a href="upload.php"><span>Create New Campaign</span></a></li>
                            <li><a href="campaigns.php"><span>Campaigns</span></a></li>
                            <li><a href="start.php"><span>Start Campiagn</span></a></li>
                            <li><a href="admins.php" class"active"><span>Administrators</span></a></li>
			</ul>
		</div>
		<!-- End Main Nav -->
	</div>
</div>
<!-- End Header -->

<!-- Container -->
<div id="container">
	
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
			





<!--------------------       ------->

<?php

	$host="localhost";
	$user="dialeruser";
	$pass="dialerpass";
	$db="dialerdb";

	

$link = new mysqli($host, $user,$pass, $db);
// Verificar la conexión
if ($link->connect_error) {
    die("Error de conexión: " . $link->connect_error);
}


	$sql="SELECT user_name FROM login_admin order by user_name asc";
	$res = $link->query($sql) or die($link->error);
	
	$fields_num = $res->num_rows;
			
			echo"	<!-- Content -->
				<div id='sidebar'>
				<!-- Box -->
				<div class='box'>
				<!-- Box Head -->
				<div class='box-head'>
				<h2>Administrators<span class='req'></span></h2>>
				</div>
				<form  id='contact-form' >
				<!-- Form -->
				<div class='form'>";

			 echo " <div class='table'>
				<table width='100%' border='0' cellspacing='0' cellpadding='0'>";

			echo "<tr>";
			for($i=0; $i<$fields_num; $i++)
			{
				$field = mysqli_fetch_field_direct($res, 0);	
			    	echo "<th><b>{$field->name}</b></th>";
			}
			echo "<th>Control</th>";
			echo "</tr>\n";
			$id="test";
			while($row = mysqli_fetch_row($res))
			{
				echo "<tr>";

			    foreach($row as $cell)
		        echo "<td>$cell</td>";
			echo "<td><a href='deladmin.php?desc=$cell' class='ico del'>Delete</a>";
echo '<a href=\'editadmin.php?desc='.$cell.'\' onclick="return popup(this,\'windi\')" class="ico edit">Edit</a></td>
			</tr>';
			}

 			 echo "</table></div></div></div></form></div></div>";
			mysqli_free_result($res);
			?>

			
			
			<!-- Content -->
			<div id="content3">
				
				<!-- Box -->
				<div class="box">
					<!-- Box Head -->
					<div class="box-head">
						<h2>Add New Administrator<span class="req"></span></h2>>
					</div>
					<!-- End Box Head -->
<?php
    if(isset($_POST['button'])){
        $errors = array(); // declaramos un array para almacenar los errores
        if($_POST['username'] == ''){
            $errors1 = '<span class="error2">Insert a UserName</span>';
        }else if($_POST['password'] == ''){
            $errors2 = '<span class="error2">Insert a Password</span>';
        }else{

		$host="localhost";
		$user="dialeruser";
		$pass="dialerpass";
		$db="dialerdb";
		$username=$_POST["username"];
		$password=$_POST["password"];

		$link = new mysqli($host, $user,$pass, $db);
		// Verificar la conexión
		if ($link->connect_error) {
		    die("Error de conexión: " . $link->connect_error);
		}

		$sql1 = "INSERT INTO login_admin (user_name,user_pass) VALUES('$username',SHA('$password'))";
		$ressult = $link->query($sql1) or die($link->error);

	

		$_POST['username'] = '';
		$_POST['password'] = '';
		header("Location: admins.php");
				
            
        }
    }
?>



					
					<form  id="contact-form" action="" method="post">
						
						<!-- Form -->
						<div class="form">
								
								
								<p>
									<label>UserName<span></span></label><?php echo $errors1 ?>
									<input type=text class='field' name=username id=username value='<?php echo $_POST['prefix']; ?>'>

								</p>	


								<p>
									<label>Password<span></span></label><?php echo $errors2 ?>
									<input type=password class='field' name=password id=password value='<?php echo $_POST['cost']; ?>'>

								</p>	

							
							
						</div>
						<!-- End Form -->
						
						<!-- Form Buttons -->
						<div class="buttons">
							
							<input name="button" type="submit" class="button" value="submit" />
							
						</div>
						<!-- End Form Buttons -->
					</form>
				</div>
				<!-- End Box -->
			
			<div class="cl">&nbsp;</div>			
		</div>
		<!-- Main -->
	</div>
</div>

<!-- End Container -->

<script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ=" crossorigin="anonymous"></script>
<script src='funciones.js'></script>
	
<p align="center">&copy; <a href="http://chocotemplates.com/" target="_blank">Design by ChocoTemplates</a> 2012 / Adapted for <a href="http://digital-merge.com" target="_blank">Digital-Merge</a></p><p align="center"><a href="http://about.me/navaismo" target="_blank"> Modified by Navaismo</a></p></body>
</html>
