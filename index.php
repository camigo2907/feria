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
$urlFormularioProyecto= new moodle_url("/local/feria/FormularioProyecto.php");

echo'<form action="guardarproyecto.php" method="post" >
		<table align="center">
		<tr>
		<td><td><a href="'.new moodle_url("/local/feria/index.php").'" class="classname"> '.get_string("inicio","local_feria").' </a></td>
		<td><td><a href="" class="classname"> '.get_string("mi_perfil","local_feria").' </a> </td>
		<td><input type="text" name="buscar" value="'.get_string("buscar","local_feria").'" align ="center"></td>
		<td><input type="image" src="lupa.png" width="25" height="25></td>
		<td><a href=""></a></td>
		<td><a href="'.new moodle_url("/local/feria/FormularioProyecto.php").'" class="classname">'.get_string("subir_proyecto","local_feria").'</a></td>
		<td><a href="'.new moodle_url("/local/feria/Explorar.php").'" class="classname">'.get_string("explorar","local_feria").'</a></td>
		</tr>
		</table>
		</form>';
echo '';
// Show the page header
echo $OUTPUT->header();
// Here goes the content

// Show the page footer
echo $OUTPUT->footer();


