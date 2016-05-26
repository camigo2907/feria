<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle. If not, see <http://www.gnu.org/licenses/>.
/**
 *
 * @package local
 * @subpackage feria
 * @copyright 2016 Catalina Amigo Martinez <camigomartinez@gmail.com>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 *         
 */


function subirFoto($nombre,$tamano,$tempNombre,$tipo)// ($_FILES['uploadedfile']['size'],$_FILES ['uploadedfile'] ['name'],$_FILES ['uploadedfile'] ['tmp_name'])
{
	
$archivo = "true";
$archivo_tamano = $tamano;
if ($tamano > 600000) {
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


function subirArchivo($nombre,$tamano,$tempNombre,$tipo)// ($_FILES['uploadedfile']['size'],$_FILES ['uploadedfile'] ['name'],$_FILES ['uploadedfile'] ['tmp_name'])
{
	$archivo = "true";
	$archivo_tamano = $tamano;
	if ($tamano > 3000000) {
		$msj = "El archivo es mayor que 1000KB, debes reducirlo antes de subirlo <BR>";
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
function cambioNombreArchivo($nombreArchivo, $slash = false) {
 $cambiar = array(
 		' ',
			'á',
			'é',
			'í',
			'ó',
			'ú',
			'ñ',
			'Ñ',
 			'Á',
			'É',
			'Í',
			'Ó',
			'Ú',
 		'(',
			')',
			',');
    $cambiarpor = array(
        '-',
        'a',
        'e',
        'i',
        'o',
        'u',
        'n',
        'N',
        'A',
        'E',
        'I',
        'O',
        'U',
        '-',
        '-',
        '-');
    if ($slash) {
        $cambiar [] = '/';
        $cambiarpor [] = '-';
    }
    $nuevoNombre = str_replace($cambiar, $cambiarpor, $nombreArchivo);
    return $nuevoNombre;
}


function cambioDescripcion($descripcion) {
	$cambiar = array(
			' ',
			'&aacute',
			'&eacute',
			'&iacute',
			'&oacute',
			'&uacute',
			'&ntilde',
			'&Ntilde',
			'&Aacute',
			'&Eacute',
			'&Iacute',
			'&Oacute',
			'&Uacute',
			'(',
			')',
			',');
	$cambiarpor = array(
			'&aacute',
			'&eacute',
			'&iacute',
			'&oacute',
			'&uacute',
			'&ntilde',
			'&Ntilde',
			'&Aacute',
			'&Eacute',
			'&Iacute',
			'&Oacute',
			'&Uacute');
	$nuevoNombre = str_replace($cambiar, $cambiarpor, $descripcion);
	return $nuevoNombre;
}
?>
