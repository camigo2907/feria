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
// Show the page header
echo $OUTPUT->header();
// Here goes the content
$busqueda=$_REQUEST['buscar'];

			$sql1 = 'SELECT p.id, p.nombre, p.categoria, p.urlfoto1, p.urlfoto2, p.urlfoto3, p.urlfoto4, p.descripcion,  u.firstname, u.lastname
				FROM mdl_proyecto p 
				JOIN mdl_user u 
				ON p.userid = u.id 
				WHERE p.nombre LIKE "%' . $busqueda . '%"';
			
			$consulta2 = $DB->get_records_sql ( $sql1 );
			if (empty($consulta2))
			{
				echo get_string("no_encontrado","local_feria");
			}
			else {

				echo "<h1>". get_string("busqueda","local_feria")." ". $busqueda."</h1>";
				// se recorre la consulta 2 con un foreach
			foreach ( $consulta2 as $llave2 => $dato2 ) {

				foreach ( $dato2 as $llave3 => $dato3 ) {
					// se crea un arreglo con los datos obtenidos de cada proyecto
				    $PPC [$llave2] [$llave3] ['1'] = $llave3;
					$PPC [$llave2] [$llave3] ['2'] = $dato3;
				}
				$urlvermas= new moodle_url ( '/local/feria/proyecto.php?id='. $PPC [$llave2] ['id'] ['2'].'' );
				
				// print_r( $PPC[$llave2] );
				// se muestran los datos obtenidos ordenados en una tabla
			
				echo "<table>";
				echo '<tr>
		  			 <td><img src="' . $PPC [$llave2] ['urlfoto1'] ['2'] . '" height="200"></td>';
				echo '<td><h2>' . $PPC [$llave2] ['nombre'] ['2'] . '</h2>
			          <br> ' . get_string ( "realizado", "local_feria" ) . ' ' . $PPC [$llave2] ['firstname'] ['2'] . ' ' . $PPC [$llave2] ['lastname'] ['2'] . '
			          <br>  ' . get_string ( "cat_pert", "local_feria" ) . '' . get_string ( $PPC [$llave2] ['categoria'] ['2'], "local_feria" ) . ' 
			           <br><a href= "' . $urlvermas . '">' . get_string ( 'ver', 'local_feria' ) . '</a>
				 	  		           </td>
	                  </tr>';
				echo '</table>';
				echo '<hr>';
	
			}}

// Show the page footer
echo $OUTPUT->footer();
