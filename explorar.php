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
$PAGE->set_url ( new moodle_url ( '/local/feria/explorar.php' ) );
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

// El codigo siguiente va en el content de la pagina

// Se parte realizando una consulta para conocer las categorias en las cuales si existen proyectos

$sql1 = 'SELECT categoria FROM mdl_proyecto GROUP BY categoria';
$consulta1 = $DB->get_records_sql ( $sql1 );

// Se abre un form para que el usuario pueda elegir la categoria de los proyectos que quiere ver

echo '<form action="explorar.php" method="post">';

// Se realiza un foreach para obtener los datos que se pidieron en la consulta 1
// deben hacerse dos por que los datos estan en un arreglo que esta en un arreglo

foreach ( $consulta1 as $llave => $dato ) {
	foreach ( $dato as $llave1 => $dato1 ) {
		
		// se crea un boton por da categoría existente...
		
		echo '<input type="submit" name="' . $dato1 . '" value="' . get_string ( $dato1, "local_feria" ) . ' " style=" ' . $styleexplorar . '"   ><hr>';
		// Si se apreta el boton entonces se desplegara una lista con los datos
		if (isset ( $_REQUEST [$dato1] )) {
			// la siguiente consulta permite obtener algunos datos de los proyectos que son de la categoria que esta dentro de $dato1
			$sql2 = 'SELECT p.id, p.nombre, u.firstname, u.lastname, p.categoria, p.urlfoto1
				FROM mdl_proyecto p 
				JOIN mdl_user u 
				ON p.userid = u.id 
				WHERE categoria ="' . $dato1 . '"';
			
			$consulta2 = $DB->get_records_sql ( $sql2 );
			// se recorre la consulta 2 con un foreach
			foreach ( $consulta2 as $llave2 => $dato2 ) {
				foreach ( $dato2 as $llave3 => $dato3 ) {
					// se crea un arreglo con los datos obtenidos de cada proyecto
					$PPC [$llave2] [$llave3] ['1'] = $llave3;
					$PPC [$llave2] [$llave3] ['2'] = $dato3;
				}
				// print_r( $PPC[$llave2] );
				// se muestran los datos obtenidos ordenados en una tabla

				$urlvermas= new moodle_url ( '/local/feria/proyecto.php?id='. $PPC [$llave2] ['id'] ['2'].'' );
				
				echo "<table>";
				echo '<tr>
		  			 <td><img src="' . $PPC [$llave2] ['urlfoto1'] ['2'] . '"  class="fotoexplorar"></td>';
				echo '<td align="center"><h2>' . $PPC [$llave2] ['nombre'] ['2'] . '</h2>
			          <br> ' . get_string ( "realizado", "local_feria" ) . ' ' . $PPC [$llave2] ['firstname'] ['2'] . ' ' . $PPC [$llave2] ['lastname'] ['2'] . '
			          <br>  ' . get_string ( "cat_pert", "local_feria" ) . '' . get_string ( $PPC [$llave2] ['categoria'] ['2'], "local_feria" ) . ' 
			          <br><a href= "' . $urlvermas . '">' . get_string ( 'ver', 'local_feria' ) . '</a>
				 	  </td>
	                  </tr>';
				echo '</table>';
				echo '<hr>';
			}
		}
	}
}
echo '</form>';

// Finalmente se muestran los datos del footer
echo $OUTPUT->footer ();