<?php


$q=$_GET['q'];

	$host="localhost";
	$user="dialeruser";
	$pass="dialerpass";
	$db="dialerdb";

$con = new mysqli($host, $user,$pass, $db);
// Verificar la conexión
if ($con->connect_error) {
    die("Error de conexión: " . $con->connect_error);
}



$sql="SELECT ID,Name,LastName,Tel,Tries,CallStatus,Deliver,SIP_CAUSE FROM " .$q. "  WHERE NameCamp = '" .$q. "'";
$result = $con->query($sql) or die($con->error);
$count = $result->num_rows;


for ($i = 0; $i < $count; $i++){ 

    $field_info = mysqli_fetch_field_direct($result, $i);
    $header .= $field_info->name . "\t";

} 

while($row = mysqli_fetch_row($result)){ 
  $line = ''; 
  foreach($row as $value){ 
    if(!isset($value) || $value == ""){ 
      $value = "\t"; 
    }else{ 
# important to escape any quotes to preserve them in the data. 
      $value = str_replace('"', '""', $value); 
# needed to encapsulate data in quotes because some data might be multi line. 
# the good news is that numbers remain numbers in Excel even though quoted. 
      $value = '"' . $value . '"' . "\t"; 
    } 
    $line .= $value; 
  } 
  $data .= trim($line)."\n"; 
} 
# this line is needed because returns embedded in the data have "\r" 
# and this looks like a "box character" in Excel 
  $data = str_replace("\r", "", $data); 


# Nice to let someone know that the search came up empty. 
# Otherwise only the column name headers will be output to Excel. 
//if ($data == "") { 
//  $data = "\nno matching records found\n"; 
//} 

# This line will stream the file to the user rather than spray it across the screen 
header("Content-type: application/octet-stream"); 

# replace $dbname.xls with whatever you want the filename to default to 
# Default $dbname uses the Database name you are exporting from 
header("Content-Disposition: attachment; filename=" .$q. "_Data.xls"); 
header("Pragma: no-cache"); 
header("Expires: 0"); 

echo $header."\n".$data;  
$con->close();

?>
