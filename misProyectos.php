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
$idusuario=$USER->id;
echo encabezado($idusuario);
echo $OUTPUT->header ();

// El codigo siguiente va en el content de la pagina

// Se parte realizando una consulta para conocer las categorias en las cuales si existen proyectos
$userid=$USER->id;
$sql1 = 'SELECT id, nombre, descripcion, categoria, urlfoto1 FROM mdl_proyecto WHERE userid='.$userid;
$consulta1 = $DB->get_records_sql ( $sql1 );
if (empty($consulta1))
{
	echo get_string("no_existen","local_feria");
}
else {
	foreach ( $consulta1 as $llave => $dato )
	   {
		 foreach ( $dato as $llave1 => $dato1 )
		 {
	      $PPC [$llave] [$llave1] ['1'] = $llave1;
		  $PPC [$llave] [$llave1] ['2'] = $dato1;
		 }
		 $urlvermas= new moodle_url ( '/local/feria/proyecto.php?id='. $PPC [$llave] ['id'] ['2'].'' );
		 $urleliminar= new moodle_url ( '/local/feria/eliminar.php?id='. $PPC [$llave] ['id'] ['2'].'' );
		 echo "<table>";
		 echo '<tr>
		  			 <td><img src="' . $PPC [$llave] ['urlfoto1'] ['2'] . '"  class="fotoexplorar"></td>';
		 echo '<td><h2>' . $PPC [$llave] ['nombre'] ['2'] . '</h2>
			          <br> ' . get_string ( "descripcion", "local_feria" ) . ': ' . $PPC [$llave] ['descripcion'] ['2'] . ' ' . $PPC [$llave] ['lastname'] ['2'] . '
			          <br>  ' . get_string ( "cat_pert", "local_feria" ) . '' . get_string ( $PPC [$llave] ['categoria'] ['2'], "local_feria" ) . '
			          <br><a href= "' . $urlvermas . '">' . get_string ( 'ver', 'local_feria' ) . '</a>
			            <br><a href= "' . $urleliminar . '">' . get_string ( 'eliminar', 'local_feria' ) . '</a>
				 	  </td>
	                  </tr>';
		 echo '</table>';
		 echo '<hr>';
       }
	 }


// Finalmente se muestran los datos del footer
echo $OUTPUT->footer ();