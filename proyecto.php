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
// librerías necesarias para que trabaje moodle
require_once (dirname ( dirname ( dirname ( __FILE__ ) ) ) . '/config.php');
include ('Style.css');
Global $DB;
$styleexplorar = "background-image: -webkit-linear-gradient(top, #ffffff, #f0f0f0);
  background-image: -moz-linear-gradient(top, #ffffff, #f0f0f0);
  background-image: -ms-linear-gradient(top, #ffffff, #f0f0f0);
  background-image: -o-linear-gradient(top, #ffffff, #f0f0f0);
  background-image: linear-gradient(to bottom, #ffffff, #f0f0f0);
  -webkit-border-radius: 3;
  -moz-border-radius: 3;
  border-radius: 3px;
  color: #423f42;
  font-size: 20px;
  background: #ffffff;
  height:60px;
  line-height:60px;
  width: 1050px;
  border: solid #e0e2e5 1px;
  text-decoration: none;";
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

echo '<form action="buscar.php" method="post" >
		<table align="center">
		<tr>
		<td><a href="' . new moodle_url ( "/local/feria/index.php" ) . '" class="classname"> ' . get_string ( "inicio", "local_feria" ) . ' </a></td>
		<td><td><a href="' . new moodle_url ( "/local/feria/perfil.php" ) . '" class="classname"> ' . get_string ( "mi_perfil", "local_feria" ) . ' </a> </td>
		<td><input type="text" name="buscar" value="' . get_string ( "buscar", "local_feria" ) . '" align ="center"></td>
		<td><input type="image" src="lupa.png" width="25" height="25></td>
		<td><a href=""></a></td>
		<td><a href="' . new moodle_url ( "/local/feria/FormularioProyecto.php" ) . '" class="classname">' . get_string ( "subir_proyecto", "local_feria" ) . '</a></td>
		<td><a href="' . new moodle_url ( "/local/feria/explorar.php" ) . '" class="classname">' . get_string ( "explorar", "local_feria" ) . '</a></td>
		</tr>
		</table>
		</form>';

echo $OUTPUT->header ();



// Finalmente se muestran los datos del footer
echo $OUTPUT->footer ();