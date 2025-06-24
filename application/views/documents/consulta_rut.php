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

	$sql = "SELECT * FROM document JOIN suppliers ON suppliers.person_id = document.person_id JOIN people ON people.person_id = document.person_id AND document.fk_rut = $rut";
	//echo $sql;
	$consulta=mysql_query($sql);//categoria (id) (opcion)
    $count=mysql_num_rows($consulta);
    $resultado=mysql_fetch_assoc($consulta);

    if($count >= 1){
        $response['existe'] = 1;
        $response['person_id'] = $resultado["person_id"];
        $response['company_name'] = $resultado["company_name"];
        $response['address_1'] = $resultado["address_1"];
        $response['contacto'] = $resultado["contacto"];
        $response['phone_number'] = $resultado["phone_number"];

    }
    else
        $response['existe'] = 0;

    echo json_encode($response);
    
?>