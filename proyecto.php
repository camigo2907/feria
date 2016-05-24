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
include '/feria_locallib.php';
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

$idProyecto=$_REQUEST['id'];
$sql= 'SELECT p.id, p.nombre, u.firstname, u.lastname, p.categoria, 
		p.urlfoto1, p.urlfoto2, p.urlfoto3, p.urlfoto4, p.descripcion, p.urlarchivo
				FROM mdl_proyecto p
				JOIN mdl_user u
		        ON p.userid = u.id
				WHERE p. id ="' . $idProyecto . '"';

$consulta = $DB->get_records_sql ( $sql );
// se recorre la consulta 2 con un foreach
foreach ( $consulta as $llave => $dato ) {
	foreach ( $dato as $llave1 => $dato1 ) {
		$proyecto[$llave][$llave1]['1']=$llave1;
		$proyecto[$llave][$llave1]['2']=$dato1;
	}
	

	//se crea el arreglo con las fotos existentes	  		
	$foto[]=$proyecto [$llave] ['urlfoto1'] ['2'];
	if(isset($proyecto [$llave] ['urlfoto2'] ['2']))
	{
		$foto[]=$proyecto [$llave] ['urlfoto2'] ['2'];
	}
	if(isset($proyecto [$llave] ['urlfoto3'] ['2']))
	{
		$foto[]=$proyecto [$llave] ['urlfoto3'] ['2'];
	}
	if (isset ( $proyecto [$llave] ['urlfoto4'] ['2'] )) {
		$foto [] = $proyecto [$llave] ['urlfoto4'] ['2'];
	}
	// print_r($foto);
	// termino de arreglo de foto
	echo '<h2>' . $proyecto [$llave] ['nombre'] ['2'] . '</h2>';
	
	echo '<div id="div">';
	if (count ( $foto ) == 1) {
		echo '<img class="imagensola" src="' . $foto ['0'] . '"/>';
	} else {
		echo '<div id="div1" class="slides">';
		for($i = 0; $i < count ( $foto ); $i ++) {
			echo '<img  alt="" src="' . $foto [$i] . '"/>';
		}
		echo '</div>';
		echo '<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
	<script src="js/jquery.slides.js"></script>
	<script>
      $(".slides").slidesjs({
      });
	</script>';
	}
	$sql1= 'SELECT SUM(r.tipo)
				FROM mdl_proyecto p
				JOIN mdl_retroalimentacion r
		        ON p.id = r.proyectoid
			   WHERE p.id ="'.$idProyecto.'"';
	
	$consulta1 = $DB->get_records_sql ( $sql1 );
	foreach ( $consulta1 as $llave2 => $dato2 ) {
		foreach ( $dato2 as $llave3 => $dato3 ) {
		 $cantidadMG=$dato3;
		}
	}
	if(!isset($cantidadMG))
	{
		$cantidadMG=0;
	}
	$sql2= 'SELECT r.comentario, u.firstname, u.lastname
				FROM mdl_user u
				JOIN mdl_retroalimentacion r
		        ON u.id = r.userid
			   WHERE r.proyectoid ="'.$idProyecto.'" AND r.tipo=0';
	$consulta2 = $DB->get_records_sql ( $sql2 );
	$l=0;
	foreach ( $consulta2 as $llave4 => $dato4 ) {
		$l++;
		foreach ( $dato4 as $llave5 => $dato5 ) {
			$comentario[$l][$llave5]=$dato5;
		}
	}
	
	//print_r($comentario);
	echo '<div id="div2"><table align="center"><form action="proyecto.php?id=' . $idProyecto . '" method="post" >';
	echo '<tr><td>' . get_string ( "realizado", "local_feria" ) . '     ' . $proyecto [$llave] ['firstname'] ['2'] . ' ' . $proyecto [$llave] ['lastname'] ['2'] . '</td></tr> 
		  <tr><td>' . get_string ( "descripcion", "local_feria" ) . ':  ' . $proyecto [$llave] ['descripcion'] ['2'] . '</td></tr>';
	echo '<tr><td>'.$cantidadMG.'<input type="submit" value="Me Gusta" name="1"> </td></tr>';
	echo '<tr><td><textarea name="comentario" rows="4" cols="65">Comente... </textarea></td> </tr>';
	echo '<tr><td align="right"><input type="submit" name="0" value="Comentar"></td></tr>';
	echo '</form></table>';
	echo '</div>';
	echo"hola<br><br><br><br><table>";
	for($l=1;$l<=count($l)+1;$l++){
	echo'<tr><td>'.$comentario[$l]["firstname"].' '.$comentario[$l]["lastname"].'  </td><td>'.$comentario[$l]["comentario"].'</td></tr>';
	}
	echo"</table>";
	echo '</div>';
	
	

}

if(isset($_REQUEST ['1']))
{
	$retroalimentacion = new stdClass ();
	$retroalimentacion->userid = $USER->id;
	$retroalimentacion-> proyectoid =$idProyecto;
	$retroalimentacion-> tipo=1;
	$retroalimentacion-> comentario=NULL;
	$DB->insert_record ( 'retroalimentacion', $retroalimentacion );
}
if($_REQUEST ['0']=='Comentar')
{
	$retroalimentacion = new stdClass ();
	$retroalimentacion->userid = $USER->id;
	$retroalimentacion-> proyectoid =$idProyecto;
	$retroalimentacion-> tipo=0;
	$retroalimentacion-> comentario=$_REQUEST['comentario'];
	$DB->insert_record ( 'retroalimentacion', $retroalimentacion );
}


// Finalmente se muestran los datos del footer
echo $OUTPUT->footer ();