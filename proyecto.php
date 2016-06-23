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
// librerias necesarias para que trabaje moodle
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
$PAGE->set_url ( new moodle_url ( '/local/feria/proyecto.php' ) );
$PAGE->set_pagelayout ( "incourse" );
$PAGE->set_title ( get_string ( "titulo", "local_feria" ) );

// El siguiente "echo" despliega el menu que se ve en el header
$idusuario = $USER->id;
echo encabezado($idusuario);
echo $OUTPUT-> header();
// se crea una consulta  para obtener todos los datos de la tabla proyecto, cuando el id del proyecto es el recib
$idProyecto = $_REQUEST ['id'];
$sql = 'SELECT p.id, p.nombre, u.firstname, u.lastname, p.categoria, 
		p.urlfoto1, p.urlfoto2, p.urlfoto3, p.urlfoto4, p.descripcion, p.urlarchivo
				FROM mdl_proyecto p
				JOIN mdl_user u
		        ON p.userid = u.id
				WHERE p. id ="' . $idProyecto . '"';

$consulta = $DB->get_records_sql ( $sql );
// se recorre la consulta 2 con un foreach
foreach ( $consulta as $llave => $dato ) {
	foreach ( $dato as $llave1 => $dato1 ) {
		$proyecto [$llave] [$llave1] ['1'] = $llave1;
		$proyecto [$llave] [$llave1] ['2'] = $dato1;
	}
	
	// se crea el arreglo con las fotos existentes
	$foto [] = $proyecto [$llave] ['urlfoto1'] ['2'];
	if (isset ( $proyecto [$llave] ['urlfoto2'] ['2'] )) {
		$foto [] = $proyecto [$llave] ['urlfoto2'] ['2'];
	}
	if (isset ( $proyecto [$llave] ['urlfoto3'] ['2'] )) {
		$foto [] = $proyecto [$llave] ['urlfoto3'] ['2'];
	}
	if (isset ( $proyecto [$llave] ['urlfoto4'] ['2'] )) {
		$foto [] = $proyecto [$llave] ['urlfoto4'] ['2'];
	}
	// termino de arreglo de foto
	// print_r($foto);
	echo '<div id="div">';
	echo '<h2>' . $proyecto [$llave] ['nombre'] ['2'] . '</h2>';
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
	$sql1 = 'SELECT SUM(r.tipo)
				FROM mdl_proyecto p
				JOIN mdl_retroalimentacion r
		        ON p.id = r.proyectoid
			   WHERE p.id ="' . $idProyecto . '"';
	$consulta1 = $DB->get_records_sql ( $sql1 );
	foreach ( $consulta1 as $llave2 => $dato2 ) {
		foreach ( $dato2 as $llave3 => $dato3 ) {
			$cantidadMG = $dato3;
		}
	}
	if (! isset ( $cantidadMG )) {
		$cantidadMG = 0;
	}
	$MG = false;
	if (isset ( $_REQUEST ['1'] )) {
		$cantidadMG = $cantidadMG + 1;
		$MG = true;
	}
	if (isset ( $_REQUEST ['3'] )) {
		$cantidadMG = $cantidadMG - 1;
	}
	$sql2 = 'SELECT r.id, r.comentario, u.firstname, u.lastname, r.userid
				FROM mdl_user u
				JOIN mdl_retroalimentacion r
		        ON u.id = r.userid
			   WHERE r.proyectoid ="' . $idProyecto . '" AND r.tipo=0
			   	ORDER BY r.id DESC';
	$consulta2 = $DB->get_records_sql ( $sql2 );
	
		if ($_REQUEST ['0'] == get_string ( "comentar", "local_feria" ))
		{
		$l = 0;
		$comentario [$l] ['firstname'] = $USER->firstname;
		$comentario [$l] ['lastname'] = $USER->lastname;
		$comentario [$l] ['comentario'] = $_REQUEST ['comentario'];
		$comentario [$l] ['userid'] = $USER->id;
	    }
	foreach ( $consulta2 as $llave4 => $dato4 ) {
		$l++;
		foreach ( $dato4 as $llave5 => $dato5 ) {
			$comentario [$l] [$llave5] = $dato5;
		}
	}
	$id = $USER->id;
	$sql3 = 'SELECT r.userid, r.tipo
			FROM mdl_proyecto p
			JOIN mdl_retroalimentacion r
		    ON p.id = r.proyectoid
			WHERE p.id ="' . $idProyecto . '" AND r.userid="' . $id . '" AND r.tipo=1';
	$consulta3 = $DB->get_records_sql ( $sql3 );
	$partes = explode ( '/', $proyecto [$llave] ['urlarchivo'] ['2'] );
	$urlarchivo = $partes [count ( $partes ) - 1];
	$urlarchivo = $CFG->wwwroot . '/local/feria/archivos/' . $urlarchivo;
	// print_r($comentario);
	$infoproyecto = '<table align="center"><form action="proyecto.php?id=' . $idProyecto . '" method="post" >';
	$infoproyecto .= '<tr><td>' . get_string ( "realizado", "local_feria" ) . '     ' . $proyecto [$llave] ['firstname'] ['2'] . ' ' . $proyecto [$llave] ['lastname'] ['2'] . '</td></tr> 
		  <tr><td>' . get_string ( "descripcion", "local_feria" ) . ':  ' . $proyecto [$llave] ['descripcion'] ['2'] . '</td></tr>
		  	<tr><td> <a href="' . $urlarchivo . '" >' . get_string ( "ver_pdf", "local_feria" ) . '</a></td></tr>';
	$infoproyecto .= '<tr><td>' . $cantidadMG . ' <IMG SRC="MG.PNG" width=20>';
	// ve si es que ya puse me gusta
	if (empty ( $consulta3 ) && ! ($MG)) {
		$infoproyecto .= '<input type="submit" value="' . get_string ( "MG", "local_feria" ) . '" name="1">';
	} else {
		if (isset ( $_REQUEST ['3'] )) {
			$infoproyecto .= '<input type="submit" value="' . get_string ( "MG", "local_feria" ) . '" name="1">';
		} else {
			$infoproyecto .= '<input type="submit" value="' . get_string ( "NOMG", "local_feria" ) . '" name="3">';
		}
	}
	$infoproyecto .= '</td></tr>';
	$infoproyecto .= '<tr><td><textarea placeholder="' . get_string ( "escribir_comentario", "local_feria" ) . '" name="comentario" rows="4" cols="65"></textarea></td> </tr>';
	$infoproyecto .= '<tr><td align="right"><input type="submit" name="0" value="' . get_string ( "comentar", "local_feria" ) . '"></td></tr>';
	$infoproyecto .= '</form></table>';
	$infoproyecto .= '';
	echo html_writer::div($infoproyecto, '', array('id'=>'div2'));
	echo '</div>';
	echo '<div id="div3"><table style="margin-left:30%;">';
	$cant_comentario = count ( $comentario ) + 1;
	$l = 1;
	if (isset ( $_REQUEST ['0'] )) {
		$cant_comentario = count ( $comentario );
		$l = 0;
	}
	// se muestran los comentarios
	for($l = $l; $l < $cant_comentario; $l ++) {
		echo '<tr><td width=5% > ';
		$i = $comentario [$l] ['userid'];
		$otrouser = $DB->get_record ( 'user', array (
				'id' => $i 
		) );
		echo $OUTPUT->user_picture ( $otrouser );
		echo '</td><td width=15% style="min-width: 150px;"><h6>' . $comentario [$l] ["firstname"] . ' ' . $comentario [$l] ["lastname"] . ' </h6> </td><td width=80% style="min-width: 200px;"><h5>' . $comentario [$l] ["comentario"] . '</h5></td></tr>';
	}
	echo "</table></div>";
}
// se guarda en la base de datos si puso me gusta, o si comento
if (isset ( $_REQUEST ['1'] )) {
	$retroalimentacion = new stdClass ();
	$retroalimentacion->userid = $USER->id;
	$retroalimentacion->proyectoid = $idProyecto;
	$retroalimentacion->tipo = 1;
	$retroalimentacion->comentario = NULL;
	$DB->insert_record ( 'retroalimentacion', $retroalimentacion );
}
if ($_REQUEST ['0'] == get_string ( "comentar", "local_feria" )) {
	$retroalimentacion = new stdClass ();
	$retroalimentacion->userid = $USER->id;
	$retroalimentacion->proyectoid = $idProyecto;
	$retroalimentacion->tipo = 0;
	$retroalimentacion->comentario = $_REQUEST ['comentario'];
	$DB->insert_record ( 'retroalimentacion', $retroalimentacion );
}
// se elimina el gusta que puse
if (isset ( $_REQUEST ['3'] )) {
	$DB-> delete_records( 'retroalimentacion', array (
			'proyectoid' => $idProyecto,
			'userid' => $id,
			'tipo'=> '1'
	) );
}

// Finalmente se muestran los datos del footer
echo $OUTPUT->footer ();