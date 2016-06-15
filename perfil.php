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
include 'feria_locallib.php';
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
echo encabezado($idusuario);
echo $OUTPUT->header ();
$idusuario=$_REQUEST['id'];

$sql1 = 'SELECT u.firstname, u.lastname, u.email,sum(r.tipo) as MG, -sum(r.tipo-1) as COMENTARIO, u.country, u.city
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
		$datos[$llave2]=$dato2;
		}} 
    }
echo '<table width=100%>
	<tr bgcolor=#e0e2e5>';
echo '<td width=35% align="center"><h3>'.$datos['firstname'].' '. $datos['lastname'].'</h3></td>';
echo '<td></td>';
echo '</tr></table>';
echo '<table width=100%><tr>';
echo'<tr>';
echo '<td align="center" width=35%>';
$otrouser = $DB->get_record('user', array('id'=>$idusuario)); 
echo $OUTPUT->user_picture($otrouser, array('size' => 280, 'link'=>false, 'class'=>'fotoperfil', 'alttext'=>"hola"));
 echo '</td>';
  echo '<td width=65%>';
 echo '<h6>'.get_string("email","local_feria").'</h6> <h5> '.$datos['email'].'</h5>';
 echo '<h6>'.get_string("ciudad","local_feria").'</h6> <h5>'.$datos['city'].'</h5>';
 echo '<h6>'.get_string("pais","local_feria").'</h6> <h5>'.$datos['country'].'</h5>';
 echo '<h6>'.get_string("pag_fav","local_feria").'</h6> <h5>'.$datos['mg'].' </h5>';
 echo '<h6>'.get_string("comentarios_hechos","local_feria").'</h6><h5>'.$datos['comentario'].'</h5></td>';
 echo '</tr><tr>';
 echo '<td></td><td>';
 if($idusuario==$USER->id){
 echo'<a href="'.new moodle_url("/local/feria/misProyectos.php").'" class="b_e">'.get_string("mis_proyectos","local_feria").'</a>';
 }
 echo'</td>';
 echo '</tr></table></font>';
// Show the page footer
echo $OUTPUT->footer ();
