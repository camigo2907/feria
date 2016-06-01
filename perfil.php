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

Global $DB;
// Moodle pages require a context, that can be system, course or module (activity or resource)
$context = context_system::instance ();
$PAGE->set_context ( $context );

// Check that user is logued in the course.
require_login ();

// Page navigation and URL settin;
$PAGE->set_url ( new moodle_url ( '/local/feria/explorar.php' ) );
$PAGE->set_pagelayout ( "incourse" );
$PAGE->set_title ( get_string ( "titulo", "local_feria" ) );
// Esto sirve para el menu que existe arriba en la pagina
$idusuario=$USER->id;
echo'<form action="buscar.php" method="post" >
		<table align="center">
		<tr>
		<td><td><a href="'.new moodle_url('/local/feria/index.php').'" class="classname"> '.get_string("inicio","local_feria").' </a></td>
		<td><td><a href="' . new moodle_url ( '/local/feria/perfil.php?id='.$idusuario.'' ) . '" class="classname"> '.get_string("mi_perfil","local_feria").' </a> </td>
		<td><input type="text" name="buscar" value="'.get_string("buscar","local_feria").'" align ="center"></td>
		<td><input type="image" src="lupa.png" width="25" height="25></td>
		<td><a href=""></a></td>
		<td><a href="'.new moodle_url("/local/feria/FormularioProyecto.php").'" class="classname">'.get_string("subir_proyecto","local_feria").'</a></td>
		<td><a href="'.new moodle_url("/local/feria/explorar.php").'" class="classname">'.get_string("explorar","local_feria").'</a></td>
		</tr>
		</table>
		</form>';

echo $OUTPUT->header ();
$idusuario= $_REQUEST['id'];
$sql1 = 'SELECT u.firstname, u.lastname, u.email,sum(r.tipo) as MG, -sum(r.tipo-1) as COMENTARIO
				FROM mdl_retroalimentacion r
				JOIN mdl_user u ON r.userid = u.id 
                WHERE u.id='.$idusuario.'';

$consulta1 = $DB->get_records_sql ( $sql1 );
if (empty($consulta1))
{
	echo get_string("no_existe_usuario","local_feria");
}
else {

	foreach ( $consulta1 as $llave1 => $dato1 ) {
		foreach ( $dato1 as $llave2 => $dato2 ) {
		$cantidad[$llave2]=$dato2;
		}}
    print_r($cantidad); 
    }
     
// Show the page footer
echo $OUTPUT->footer ();
