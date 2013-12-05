<?php
$conexion = mysql_connect("localhost", "informat_root", "pepe123");
if(!$conexion){
die('No se pudo conectar: ' . mysql_error());
}
mysql_select_db("informat_pdv", $conexion);?>