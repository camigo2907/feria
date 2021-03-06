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
// librer�as necesarias para que trabaje moodle
require_once (dirname ( dirname ( dirname ( __FILE__ ) ) ) . '/config.php');
include ('Style.css');

include '/feria_locallib.php';
Global $DB;
// Moodle pages require a context, that can be system, course or module (activity or resource)
$context = context_system::instance ();
$PAGE->set_context ( $context );

// Check that user is logued in the course.
require_login ();

// Page navigation and URL settin;
$PAGE->set_url ( new moodle_url ( '/local/feria/proyecto.php' ) );
$PAGE->set_pagelayout ( "incourse" );
$PAGE->set_title ( get_string ( "titulo", "local_feria" ) );

// El siguiente "echo" despliega el menu que se ve en el header
$idusuario=$USER->id;
echo encabezado($idusuario);
echo $OUTPUT->header ();

$idProyecto=$_REQUEST['id'];
$sql= 'SELECT id, nombre
				FROM mdl_proyecto 
				WHERE id ="' . $idProyecto . '"';

$consulta = $DB->get_records_sql ( $sql );
// se recorre la consulta 2 con un foreach
foreach ( $consulta as $llave => $dato ) {
	foreach ( $dato as $llave1 => $dato1 ) {
		$proyecto[$llave1]=$dato1;
	}
	}
	$urlatras= new moodle_url ( '/local/feria/misProyectos.php' );
	$urleliminar= new moodle_url ( '/local/feria/confirmacionEliminar.php?id='. $proyecto['id'].'' );	
echo '<div align="center">';
echo get_string ( 'advertencia01', 'local_feria' ).$proyecto['nombre'].get_string ( 'advertencia02', 'local_feria' );
echo ' <br><a href= "' . $urleliminar . '" class="b_e">' . get_string ( 'continuar', 'local_feria' ) . '</a>';
echo ' <a href= "' . $urlatras . '" class="b_e">' . get_string ( 'atras', 'local_feria' ) . '</a>';
echo '</div>';

// Finalmente se muestran los datos del footer
echo $OUTPUT->footer ();