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
require_once(dirname(dirname(dirname(__FILE__))) . '/config.php');
include('Style.css');
include 'feria_locallib.php';
Global $DB;
// Moodle pages require a context, that can be system, course or module (activity or resource)

$context = context_system::instance();
$PAGE->set_context($context);

// Check that user is logued in the course.
require_login();

// Page navigation and URL settin;
$PAGE->set_url(new moodle_url('/local/feria/index.php'));
$PAGE->set_pagelayout("incourse");
$PAGE->set_title(get_string("titulo","local_feria"));
//
$idusuario=$USER->id;
echo encabezado($idusuario);
// Show the page header
echo $OUTPUT->header();
// Here goes the content
echo '<img src="imagen_index.jpg" width=100%><br>';
$sql = 'SELECT p.id, p.nombre, p.userid, u.firstname, u.lastname, p.categoria,p. urlfoto1, sum( r.tipo) as cantidad
				FROM mdl_proyecto p
				JOIN mdl_user u
		        ON p.userid = u.id
				JOIN mdl_retroalimentacion r
		        ON p.id = r.proyectoid
                group by nombre order by cantidad desc LIMIT 5';
$consulta = $DB->get_records_sql ( $sql );
echo '<h4>'.get_string("destacado","local_feria").'</h4>';
echo "<table width=100%>";
echo '<tr>';
foreach ( $consulta as $llave => $dato ) {

	foreach ( $dato as $llave1 => $dato1 ) {
		$proyecto [$llave1] ['1'] = $llave1;
		$proyecto [$llave1] ['2'] = $dato1;
	}
		$urlvermas= new moodle_url ( '/local/feria/proyecto.php?id='. $proyecto  ['id'] ['2'].'' );
		$urlperfil= new moodle_url ( '/local/feria/perfil.php?id='. $proyecto  ['userid'] ['2'].'' );
		echo '<td align="center"><img src="' . $proyecto ['urlfoto1']['2'] . '"width="150" height="100" ><br>';
		echo   ' <br><b><a href= "' . $urlvermas . '">' .$proyecto  ['nombre'] ['2'] . '</a></b>
				<br> ' . get_string ( "realizado", "local_feria" ) . '<a href= "' . $urlperfil . '"> ' . $proyecto  ['firstname'] ['2'] . ' ' . $proyecto  ['lastname'] ['2'] . '</a>
			  <br>  ' . get_string ( "cat_pert", "local_feria" ) . '' . get_string ( $proyecto  ['categoria'] ['2'], "local_feria" ) . '
			 
			 </td>';
	
}
echo'</tr>';
echo '</table>';
		          
// Show the page footer
echo $OUTPUT->footer();


