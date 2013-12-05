<?php
include "conexion.php";
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

	$sql = 'SELECT * FROM items WHERE item_number = "'.$input_item.'"';
	//echo $sql;
	$consulta=mysql_query($sql);//categoria (id) (opcion)
    $count=mysql_num_rows($consulta);
    $resultado=mysql_fetch_assoc($consulta);

    if($count >= 1){

        $response['item_id'] = $resultado["item_id"];
        $response['name'] = $resultado["name"];
        $response['existe'] = 1;
        
    }
    else
        $response['existe'] = 0;

    echo json_encode($response);
    
?>