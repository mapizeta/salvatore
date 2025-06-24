<?php

/* 
 Libreria para manejo de Termo Impresora.
 Manuel Pizarro Mendoza.
 Pyzarro.
*/

/*  
--------------------------------------------------------------------------------------------------------
				      	Manejo de Hoja y Lineas
*/

function br_linea($nlin) 	   //--------------------- Salta $nlin lineas
{ global $handle;
fwrite($handle, chr(27). chr(100). chr($nlin));
}

function corte_ss()		   //--------------------- Corta sin saltar linea
{ global $handle;
fwrite($handle, chr(29). chr(86). chr(0));
}

function corte_cs($xlin)	   //--------------------- Corta saltando $xlin lineas **//// AREGLAR!!!
{ global $handle;
fwrite($handle,chr(27). chr(100). chr($xlin). chr(29). chr(86). chr(66). chr(100));
}


/* 
--------------------------------------------------------------------------------------------------------
					Manejo de Fuentes
*/

function negrita() // Establece Fuente Resaltado 
{ global $handle;
fwrite($handle, chr(27). chr(33). chr(8));
}

function subrayado($grosor) // Establece Fuente Subrayada (grosor 0 desactiva, 1 y 2 -> delgado y grueso)
{ global $handle;
fwrite($handle, chr(27). chr(45). chr($grosor));
}

function dobancho() // Fuente con doble Ancho
{ global $handle;
fwrite($handle, chr(27). chr(33). chr(32));
}

function dobaltura() // Fuente con doble altura
{ global $handle;
fwrite($handle, chr(27). chr(33). chr(16));
}

function peque�a() // Fuente peque�a
{ global $handle;
fwrite($handle, chr(27). chr(33). chr(1));
}

function centrar()
{ global $handle;					
fwrite($handle, chr(27). chr(97). chr(1));
}		
function izquierda()
{ global $handle;					
fwrite($handle, chr(27). chr(97). chr(0));
}
function derecha()
{ global $handle;					
fwrite($handle, chr(27). chr(97). chr(2));
}					
							
function bn_nb($tipo)					// Selecciona de tipo Blanco o negro
{ global $handle;					// segun lo siguiente:
fwrite($handle, chr(29). chr(66). chr($tipo));		// $tipo = 0 -> Fondo blanco letras negras
}							// $tipo = 1 -> Fondo negro letras blancas

function normal() // Establece Fuente Normal
{ global $handle;
fwrite($handle, chr(27). chr(33). chr(0));
}


/*
----------------------------------------------------------------------------------------------------------
				Otros Comandos Importantes
*/
function barcode(){
  global $handle;
fwrite($handle, chr(29). chr(107). chr(0). chr(48). chr(0));			//IMPRIME CODIGO BARRAS
}

function abrecaja()
{ global $handle;
fwrite($handle, chr(27). chr(112). chr(48));		// Abrir el Cajon Monedero
}

function alarma()					// Suena la alarma de la impresora
{ global $handle;
fwrite($handle, chr(30));
}

function reinicia()					// Reinicia la impresora
{ global $handle;
fwrite($handle,chr(27). chr(64));
}

function texto($texto)
{ global $handle;
fwrite($handle,$texto);
}

function iniciaimpresora()
{ global $handle;
if(($handle = @fopen("COM1", "w")) === FALSE){ die('No se puedo Imprimir, Verifique su conexion con el Terminal');}
}

function imprime()
{ global $handle;
fclose($handle); 		  // cierra el fichero PRN
$salida = shell_exec('lpr COM1'); //lpr->puerto impresora, imprimir archivo PRN
}

function imprimecaja()
{ global $handle;
fclose($handle); 		  // cierra el fichero PRN
$salida = shell_exec('lpr COM1'); //lpr->puerto impresora, imprimir archivo PRN
}

/*
----------------------------------------------------------------------------------------------------------
				Cabeceras Completas
*/

function impr_cabecera($nombre, $direccion, $fono)
{

normal();
texto("************************************************");
br_linea(1);
dobancho();
centrar();
texto($nombre); 
normal();
br_linea(1);
texto($direccion);
br_linea(1);
texto($fono);
br_linea(1);
texto("************************************************");
br_linea(3);

}

function impr_item($cantidad, $nombre, $descuento, $precio){
	$lng_item= strlen($nombre);
	$espacio_precio="   ";
	$espacio_second="";

	if($lng_item > 38){
		$lng_string = $l * -1;
	    $second = substr($nombre, 38 , 38);
		$l2 =  strlen($second);
		$spaces = 39-$l2;
	   
		for($i=0; $i < $spaces; $i++){
			$espacio_second=$espacio_second." ";
		}	
		$lng_string = $lng_item * -1;
		$rest = substr($nombre, $lng_string , 38);
	}
	else{
		//texto($lng_item);
		$rest=$nombre;
		$cant_espacios=39-$lng_item;
		$espacios="";
		for($j=0;$j<$cant_espacios;$j++){
			$espacios=$espacios." ";
		}
	}
	normal();
	izquierda();
	texto($cantidad." ");
	texto($rest);
	if($lng_item > 38){
		br_linea(1);
		texto($second);
		texto($espacio_second);
	}
	texto($espacios);
	texto($espacio_precio);
	texto($precio);
	br_linea(1);
}

function impr_total($total){
br_linea(2);
dobancho();
derecha();
texto("TOTAL : ".$total);
br_linea(2);
}
function impr_empleado($empleado){
//br_linea(2);
normal();
izquierda();
texto("Empleado: ");
texto($empleado);
br_linea(1);
texto("Comprobante no valido como boleta");
br_linea(2);
centrar();
normal();
texto("Que tenga un buen dia");
}
function fecha_hora($fecha, $hora){

izquierda();
texto("Fecha: ");
texto($fecha);
texto("                 ");
texto("Hora: ");
texto($hora);
br_linea(2);

}
/*

FIN DE LA LIBRERIA

*/

?>