#!/usr/bin/php -q
<?php
set_time_limit(30);

/************** obtenemos el nombre del directorio que es el nombre de la campania *********/
$campname=exec("pwd | awk -F/ '{ print \$NF;}'");
echo $campname;


/************* Verificamos que los Archivos Call que existen en el Spool de nuestra*****************/ 
/************* campania se hayan ejecutado al menos una vez para mover los demas archivos **********/


//$exist=exec("ls -lha /var/spool/asterisk/outgoing/*" .$campname. "* | grep -c call");

$directorio = "/var/spool/asterisk/outgoing/";
$palabraBuscada = $campname;

$exist=exec("ls -1 $directorio | grep '$palabraBuscada'| grep -c call | wc -l");
$exist=exec("grep -c 'StartRetry' *" .$campname. "* | wc -w");




/************ Si ningun archivo ha sido ejecutado por el spool no enviamos mas llamdas ***********/
if($exist == 0){
	exit();
}else{

/************ Conexion a la BD ****************/	


$host='localhost';
$user='dialeruser';
$pass='dialerpass';
$db='dialerdb';
$range=0;


$link = new mysqli($host, $user,$pass, $db);
// Verificar la conexión
if ($link->connect_error) {
    die("Error de conexión: " . $link->connect_error);
}
//var_dump($link);exit();

/********************* Obtenemos el ultimo ID de la campania *******************/
	$sql1="SELECT ID from " .$campname. " ORDER BY ID DESC LIMIT 1";
	$res = $link->query($sql1) or die($link->error);
        $row = mysqli_fetch_assoc($res);
        $topID = $row['ID'];
	echo "topID: $topID\r\n";

/******************* Obtenemos el ultimo id marcado de la campania *****************/
	$sql="SELECT LastIdDial from Campaign WHERE CampaignName='" .$campname. "'";
	$res = $link->query($sql) or die($link->error);
        $row = mysqli_fetch_assoc($res);
        $lastID = $row['LastIdDial'];
	echo "lastID: $lastID\r\n";

/***************** obtenemos el maximo de llamadas a ejecutar ***********************/
	$sql="SELECT MaxCalls from Campaign WHERE CampaignName='" .$campname. "'";
	$res = $link->query($sql) or die($link->error);
        $row = mysqli_fetch_assoc($res);
        $calls = $row['MaxCalls'];
	echo "calls: $calls\r\n";

/*************** el rango de archivos a mover ******************/
	$range = $lastID + $calls;
	echo "range: $range\r\n";

/************** Si el rango es mayor al ultimo ID no movemos mas *****************/
	if($range >= $topID){
	  $range=$topID;
	}

/************* Movemos los archivos en modo secuencial al spool de asterisk definidos por el rango ********/
	for( $i=$lastID; $i<=$range; $i++){
		exec("mv /var/lib/asterisk/agi-bin/DialerCamps/" .$campname. "/" .$i. "_* /var/spool/asterisk/outgoing/");
	echo "i: $i\r\n";
	}

/************** Actualizamos el ultimo ID movido al Spool ******************/
	$sqlu="UPDATE Campaign SET LastIdDial='" .$range. "' WHERE CampaignName='" .$campname. "'";
	$res = $link->query($sqlu) or die($link->error);
}
?>
