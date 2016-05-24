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
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.
/**
 *
 * @package local
 * @subpackage feria
 * @copyright 2016 Catalina Amigo Martinez <camigomartinez@gmail.com>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
// Minimum for Moodle to work, the basic libraries
require "../../config.php"; // archivo que ayuda a subir los datos del formulario a BBDD
include '/feria_locallib.php'; // se incluyen dentro del codigo diferentes funciones
include('Style.css');
// Moodle pages require a context, that can be system, course or module (activity or resource)
$context = context_system::instance();
$PAGE->set_context($context);

// Check that user is logued in the course.
require_login();

// Page navigation and URL settin;
$PAGE->set_url(new moodle_url('/local/feria/guardarProyecto.php'));
$PAGE->set_pagelayout("incourse");
$PAGE->set_title(get_string("titulo","local_feria"));

echo '<form action="buscar.php" method="post" >
		<table align="center">
		<tr>
		<td><td><a href="' . new moodle_url ( "/local/feria/index.php" ) . '" class="classname"> ' . get_string ( "inicio", "local_feria" ) . ' </a></td>
		<td><td><a href="' . new moodle_url ( "/local/feria/perfil.php" ) . '" class="classname"> ' . get_string ( "mi_perfil", "local_feria" ) . ' </a> </td>
		<td><input type="text" name="buscar" value="' . get_string ( "buscar", "local_feria" ) . '" align ="center"></td>
		<td><input type="image" src="lupa.png" width="25" height="25></td>
		<td><a href=""></a></td>
		<td><a href="' . new moodle_url ( "/local/feria/FormularioProyecto.php" ) . '" class="classname">' . get_string ( "subir_proyecto", "local_feria" ) . '</a></td>
		<td><a href="' . new moodle_url ( "/local/feria/explorar.php" ) . '" class="classname">' . get_string ( "explorar", "local_feria" ) . '</a></td>
		</tr>
		</table>
		</form>';



// Show the page header
echo $OUTPUT->header();
// Here goes the content

// El siguiente if, sirve para saber si es que se han rellenado las casillas obligatorias..
// si es que se rellenaron se prosigue a guardar los datos en la tabla proyectos
if (isset ( $_REQUEST ['nombre']) 
		&& isset( $_REQUEST ['categoria']) 
		&& isset( $_REQUEST ['descripcion'] ) 
		&&($_FILES ['foto1'] ['type'] == "image/jpeg" || $_FILES ['foto1'] ['type'] == "image/gif")
		&& $_FILES ['archivo'] ['type']=="application/pdf" 
		&& $_FILES ['foto1'] ['size'] > 0 
		&& $_FILES ['foto1'] ['size'] < 600000 
		&& $_FILES ['archivo'] ['size'] > 0
		&& $_FILES ['archivo'] ['size'] < 3000000
		&& $_FILES ['foto1'] ['size'] > 0
		&& $_FILES ['foto2'] ['size'] < 600000 
		&& $_FILES ['foto3'] ['size'] < 600000
		&& $_FILES ['foto4'] ['size'] < 600000) {
	
	 //var_dump ( $_FILES );
	 //var_dump ( $_REQUEST );
	// Datos obtenidos de la foto 1
	$nombre1 = $_FILES ['foto1'] ['name'];
	echo cambioNombreArchivo($nombre1);
	$tempNombre1 = $_FILES ['foto1'] ['tmp_name'];
	$tamano1 = $_FILES ['foto1'] ['size'];
	$tipo1 = $_FILES ['foto1'] ['type'];

	// Datos obtenidos de la foto 2
	$nombre2 = cambioNombreArchivo($_FILES ['foto2'] ['name'],false);
	$tempNombre2 = $_FILES ['foto2'] ['tmp_name'];
	$tamano2 = $_FILES ['foto2'] ['size'];
	$tipo2 = $_FILES ['foto2'] ['type'];

	// Datos obtenidos de la foto 3
	$nombre3 = cambioNombreArchivo($_FILES ['foto3'] ['name'],false);
	$tempNombre3 = $_FILES ['foto3'] ['tmp_name'];
	$tamano3 = $_FILES ['foto3'] ['size'];
	$tipo3 = $_FILES ['foto3'] ['type'];

	// Datos obtenidos de la foto 4
	$nombre4 = cambioNombreArchivo($_FILES ['foto4'] ['name'],false);
	$tempNombre4 = $_FILES ['foto4'] ['tmp_name'];
	$tamano4 = $_FILES ['foto4'] ['size'];
	$tipo4 = $_FILES ['foto4'] ['type'];

	// Datos obtenidos del archivo pdf
	$nombre5 = cambioNombreArchivo($_FILES ['archivo'] ['name'],false);
	$tempNombre5 = $_FILES ['archivo'] ['tmp_name'];
	$tamano5 = $_FILES ['archivo'] ['size'];
	$tipo5 = $_FILES ['archivo'] ['type'];
	
	// Se guardan las fotos, en la carpeta fotos, a traves de la función subirFoto creada en
	// locallib.php
	$urlfoto1 = subirFoto ( $nombre1, $tamano1, $tempNombre1, $tipo1 );
	
	$urlarchivo = subirArchivo ( $nombre5, $tamano5, $tempNombre5, $tipo5 );

	// idea para cambiar la cosa del null es poner las $proyecto->urlfoto dentro del if
	// Insertamos en la BBDD
	$descripcion=$_REQUEST['descripcion'];
	echo cambioDescripcion($descripcion);
	$proyecto = new stdClass ();
	$proyecto->descripcion = cambioDescripcion($_REQUEST ['descripcion']);
	$proyecto->nombre = $_REQUEST ['nombre'];
	$proyecto->categoria = $_REQUEST ['categoria'];
	$proyecto->urlarchivo = $CFG->wwwroot . '/local/feria/' . $urlarchivo;
	$proyecto->descripcion = $_REQUEST ['descripcion'];
	$proyecto->urlfoto1 = $CFG->wwwroot . '/local/feria/' . $urlfoto1;
	$proyecto->urlvideo = $_REQUEST ['urlvideo'];
	$proyecto->userid = $USER->id;

	// El Codigo siguiente sirve para que las fotos que no son obligatorias de subir, se guarden o no dependiendo de si existe o no
	if ($_FILES ['foto2'] ['size'] > 0) {
		$urlfoto2 = subirFoto ( $nombre2, $tamano2, $tempNombre2, $tipo2 );
		$foto2 = $CFG->wwwroot . '/local/feria/' . $urlfoto2;
		$proyecto->urlfoto2 = $foto2;
	}
	else {
		$proyecto->urlfoto2 = NULL;
	}
	if ($_FILES ['foto3'] ['size'] > 0) {
		$urlfoto3 = subirFoto ( $nombre3, $tamano3, $tempNombre3, $tipo3 );
		$foto3 = $CFG->wwwroot . '/local/feria/' . $urlfoto3;
		$proyecto->urlfoto3 = $foto3;
	}
	else {
		$proyecto->urlfoto3 = NULL;
	}
	if ($_FILES ['foto4'] ['size'] > 0) {
		$urlfoto4 = subirFoto ( $nombre4, $tamano4, $tempNombre4, $tipo4 );
		$foto4 = $CFG->wwwroot . '/local/feria/' . $urlfoto4;
		$proyecto->urlfoto4 = $foto4;
	}
	else {
		$proyecto->urlfoto4 = NULL;
	}
	// Se inserta la clase creada anteriormente en la tabla proyecto

	$DB->insert_record ( 'proyecto', $proyecto );
	echo get_string("subido_bien","local_feria");

		} 
else {
	
	if (!($_FILES ['foto1'] ['type'] == "image/jpeg" || $_FILES ['foto1'] ['type'] == "image/gif")&& $_FILES ['foto1'] ['type']!=Null)
	    {
		$msj[] = " Tu archivo tiene que ser JPG o GIF. Otros archivos no son permitidos<BR>";
		}
	if ( $_REQUEST ['nombre']==NULL)
		{ $msj[]="req_nom";}
	if($_REQUEST ['descripcion']==NULL )
		{ $msj[]="req_des";}
	if($_FILES ['archivo'] ['type']!="application/pdf" && $_FILES ['archivo'] ['type']!=Null) 
	    {$msj[]="tipo_arc";}
	if( $_FILES ['foto1'] ['size'] <= 0)
		{ $msj[]="no_f1";}
	if ($_FILES ['foto1'] ['size'] > 600000)
	    {$msj[]="gran_f1";}
	if ($_FILES ['archivo'] ['size'] <= 0)
		{ $msj[]="no_arc";}
	if($_FILES ['archivo'] ['size'] > 3000000)
		{$msj[]="gran_arch";}
	if( $_FILES ['foto2'] ['size']> 600000)
		{$msj[]="gran_f2";}
	if( $_FILES ['foto3'] ['size'] > 600000)
		{$msj[]="gran_f3";}
	if( $_FILES ['foto4'] ['size'] > 600000)
		{$msj[]="gran_f4";}
		//print_r($msj);
		// Si es que no se rellenaron todas las casillas necesarias, se redirecciona al formulario
	echo '<form action="guardarProyecto.php" method="post" enctype="multipart/form-data">
<table>
<tr><td>' . get_string ( "nombre_proyecto", "local_feria" ) . ': </td><td><input type="text" name="nombre" />*</td></tr>
<tr><td>' . get_string ( "descripcion", "local_feria" ) . ':</td><td><input type="text" name="descripcion" />*</td></tr>
<tr><td>' . get_string ( "categoria", "local_feria" ) . ':</td><td> <select name="categoria"/>
<option value="arte">' . get_string ( "arte", "local_feria" ) . '</option>
<option value="biologia">' . get_string ( "biologia", "local_feria" ) . '</option>
<option value="deporte">' . get_string ( "deporte", "local_feria" ) . '</option>
<option value="fisica">' . get_string ( "fisica", "local_feria" ) . '</option>
<option value="historia">' . get_string ( "historia", "local_feria" ) . '</option>
<option value="matematicas">' . get_string ( "matematicas", "local_feria" ) . '</option>
<option value="medio">' . get_string ( "medio", "local_feria" ) . '</option>
<option value="musica">' . get_string ( "musica", "local_feria" ) . '</option>
<option value="negocios">' . get_string ( "negocios", "local_feria" ) . '</option>
<option value="quimica">' . get_string ( "quimica", "local_feria" ) . '</option>
</select>*</td></tr>
 <tr><td>' . get_string ( "foto", "local_feria" ) . ':</td><td><input TYPE="file" name="foto1" id="foto1" />*</td></tr>
<tr><td></td><td><input TYPE="file" name="foto2" id=”foto2” /></td></tr>
<tr><td></td><td><input TYPE="file" name="foto3" id=”foto3” /></td></tr>
<tr><td></td><td><input TYPE="file" name="foto4" id=”foto4”/></td></tr>
<tr><td>' . get_string ( "archivo", "local_feria" ) . ':  </td><td> <input type="file" name="archivo" id=”archivo” />*</td></tr>
 <tr><td>' . get_string ( "url_video", "local_feria" ) . ':  </td><td><input type="text" name="urlvideo" /></td></tr>
 <tr><td></td><td><p><input name=enviardatos type="submit" value="' . get_string ( "enviar", "local_feria" ) . '" /></p></td><td></td></tr>
<tr><td></td><td> * ' . get_string ( "campos_obligatorios", "local_feria" ) . '</td></tr>';

	for ($i = 0; $i <= count($msj)-1; $i++) {
		echo '<tr><td></td><td><font color="red" ><b>'. get_string($msj[$i],"local_feria").'</b></font></td></tr>';
	}
		echo'</table></form>';

}
// Show the page footer
echo $OUTPUT->footer();

?>
                        
         
                      
            
 
                      