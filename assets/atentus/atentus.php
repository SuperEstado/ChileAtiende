<?php

/*Aqui configuran los accesos a la base de datos*/
$host='localhost';
$db_user='root';
$db_pass='';
/*----------------------------------------------*/


$link = @mysql_connect($host, $db_user, $db_pass);
if ($link) {
    $estado= 'Exito';
    mysql_close($link);
} else{
    $estado=mysql_error();
}


header('Content-type: text/xml');

?>
<?='<?xml version="1.0" encoding="UTF-8"?>' ?>
<conexion>
	<estado><?=$estado?></estado>
</conexion>