<?php
function subirFoto($nombre,$tamaño,$tempNombre,$tipo)// ($_FILES['uploadedfile']['size'],$_FILES ['uploadedfile'] ['name'],$_FILES ['uploadedfile'] ['tmp_name'])
{
$archivo = "true";
$archivo_tamaño = $tamaño;
if ($tamaño > 200000) {
	$msj = "El archivo es mayor que 200KB, debes reducirlo antes de subirlo <BR>";
	$archivo = "false";
}

if (! ($tipo == "image/jpeg" || $tipo == "image/gif"))
{
	$msj = " Tu archivo tiene que ser JPG o GIF. Otros archivos no son permitidos<BR>";
	$archivo = "false";
}

$archivo_nombre = $nombre;
$agregar = "fotos/".$archivo_nombre;
if ($archivo == "true") 
{	
	if ( move_uploaded_file( $tempNombre, $agregar)) 
	{
		$url=$agregar;
	}
else {
	echo "Error al subir el archivo";
	}
}
else
{ $url=$msj; }
return $url;
}


function subirArchivo($nombre,$tamaño,$tempNombre,$tipo)// ($_FILES['uploadedfile']['size'],$_FILES ['uploadedfile'] ['name'],$_FILES ['uploadedfile'] ['tmp_name'])
{
	$archivo = "true";
	$archivo_tamaño = $tamaño;
	if ($tamaño > 500000) {
		$msj = "El archivo es mayor que 500KB, debes reducirlo antes de subirlo <BR>";
		$archivo = "false";
	}

	if (! ($tipo == "application/pdf"))
	{
		$msj = " Tu archivo tiene que ser PDF. Otros archivos no son permitidos<BR>";
		$archivo = "false";
	}

	$archivo_nombre = $nombre;
	$agregar = "archivos/".$archivo_nombre;
	if ($archivo == "true")
	{
		if ( move_uploaded_file( $tempNombre, $agregar))
		{
		  $url=$agregar;
		}
		else {
			echo "Error al subir el archivo";
		}
	}
	else
	{ $url=$msj; }
	return $url;
}
?>
