<?php
$conexion = mysql_connect("localhost", "root", "mysql");
if(!$conexion){
die('No se pudo conectar: ' . mysql_error());
}
mysql_select_db("informat_pdv", $conexion);?>