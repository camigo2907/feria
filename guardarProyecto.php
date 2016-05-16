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

// Show the page header
echo $OUTPUT->header();
// Here goes the content

// El siguiente if, sirve para saber si es que se han rellenado las casillas obligatorias..
// si es que se rellenaron se prosigue a guardar los datos en la tabla proyectos
if (isset ( $_REQUEST ['nombre'], $_REQUEST ['categoria'], $_REQUEST ['descripcion'] ) && $_FILES ['foto1'] ['size'] > 0 && $_FILES ['archivo'] ['size'] > 0) {
	

	// var_dump ( $_FILES );
	// var_dump ( $_REQUEST );
	// Datos obtenidos de la foto 1
	$nombre1 = $_FILES ['foto1'] ['name'];
	$tempNombre1 = $_FILES ['foto1'] ['tmp_name'];
	$tamano1 = $_FILES ['foto1'] ['size'];
	$tipo1 = $_FILES ['foto1'] ['type'];

	// Datos obtenidos de la foto 2
	$nombre2 = $_FILES ['foto2'] ['name'];
	$tempNombre2 = $_FILES ['foto2'] ['tmp_name'];
	$tamano2 = $_FILES ['foto2'] ['size'];
	$tipo2 = $_FILES ['foto2'] ['type'];

	// Datos obtenidos de la foto 3
	$nombre3 = $_FILES ['foto3'] ['name'];
	$tempNombre3 = $_FILES ['foto3'] ['tmp_name'];
	$tamano3 = $_FILES ['foto3'] ['size'];
	$tipo3 = $_FILES ['foto3'] ['type'];

	// Datos obtenidos de la foto 4
	$nombre4 = $_FILES ['foto4'] ['name'];
	$tempNombre4 = $_FILES ['foto4'] ['tmp_name'];
	$tamano4 = $_FILES ['foto4'] ['size'];
	$tipo4 = $_FILES ['foto4'] ['type'];

	// Datos obtenidos del archivo pdf
	$nombre5 = $_FILES ['archivo'] ['name'];
	$tempNombre5 = $_FILES ['archivo'] ['tmp_name'];
	$tamano5 = $_FILES ['archivo'] ['size'];
	$tipo5 = $_FILES ['archivo'] ['type'];

	// Se guardan las fotos, en la carpeta fotos, a traves de la función subirFoto creada en
	// locallib.php
	$urlfoto1 = subirFoto ( $nombre1, $tamano1, $tempNombre1, $tipo1 );
	$urlarchivo = subirArchivo ( $nombre5, $tamano5, $tempNombre5, $tipo5 );

	if ($_FILES ['foto3'] ['size'] > 0) {
		$urlfoto3 = subirFoto ( $nombre3, $tamano3, $tempNombre3, $tipo3 );
		$foto3 = $CFG->wwwroot . '/local/feria/' . $urlfoto3;
	} else {
		$foto3 = ' ';
	}
	if ($_FILES ['foto4'] ['size'] > 0) {
		$urlfoto4 = subirFoto ( $nombre4, $tamano4, $tempNombre4, $tipo4 );
		$foto4 = $CFG->wwwroot . '/local/feria/' . $urlfoto4;
	} else {
		$foto4 = ' ';
	}
	// idea para cambiar la cosa del null es poner las $proyecto->urlfoto dentro del if
	// Insertamos en la BBDD

	$proyecto = new stdClass ();
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
} else {
	// Si es que no se rellenaron todas las casillas necesarias, se redirecciona al formulario
	header ( 'Location: FormularioProyecto.php' );
}
// Show the page footer
echo $OUTPUT->footer();




?>
                        
         
                      
            
 
                      