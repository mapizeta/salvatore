<?php
include "conexion.php";
include "imprimir_lib.php";
if($_POST)
{
    $keys_post = array_keys($_POST);
    foreach ($keys_post as $key_post)
     {
      $$key_post = $_POST[$key_post];
      error_log("variable $key_post viene desde $ _POST");
     }
} 

if($_GET)
{
    $keys_get = array_keys($_GET);
    foreach ($keys_get as $key_get)
     {
        $$key_get = $_GET[$key_get];
        error_log("variable $key_get viene desde $ _GET");
     }
} 
$items="SELECT si.quantity_purchased, i.name, si.discount_percent, si.item_unit_price FROM sales_items AS si, items AS i WHERE si.item_id = i.item_id AND si.sale_id=".$venta_id;
$fecha_hora="SELECT DATE_FORMAT(sale_time,'%d-%m-%Y') fecha, DATE_FORMAT(sale_time,'%h:%i:%s')hora FROM sales WHERE sale_id =".$venta_id;
echo $items."\n";
echo $fecha_hora."\n";

$result_items = mysql_query($items, $conexion);

$result_fecha_hora = mysql_query($fecha_hora, $conexion);
$row_fh = mysql_fetch_assoc($result_fecha_hora);





echo "**************".$compania_nombre."********************\n";
echo $compania_direccion."\n";
echo $compania_fono."\n";
echo $row_fh["fecha"]."                     ".$row_fh["hora"]."\n\n\n";
echo "****************".$venta_forma."**********************\n";
echo "Id de venta: ".$venta_id."\n";
echo "Empleado: ".$venta_empleado."\n";
echo "                                            ".$venta_total."\n\n";
echo "Que tenga un buen dia";

echo "prueba de impresion\n";

if($compania_nombre){
iniciaimpresora();
impr_cabecera($compania_nombre, $compania_direccion, $compania_fono);
fecha_hora($row_fh["fecha"], $row_fh["hora"]);
while( $row_i = mysql_fetch_assoc($result_items) ) {
	  
	impr_item(intval($row_i["quantity_purchased"]),$row_i["name"],$row_i["discount_percent"],intval($row_i["item_unit_price"]));
		
	}
impr_total($venta_total);
centrar();
barcode();
impr_empleado($venta_empleado);	
corte_cs(1);	
}
?>