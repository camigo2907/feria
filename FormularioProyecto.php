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
// Minimum for Moodle to work, the basic libraries
require_once (dirname ( dirname ( dirname ( __FILE__ ) ) ) . '/config.php');
include('Style.css');
// Moodle pages require a context, that can be system, course or module (activity or resource)
$context = context_system::instance ();
$PAGE->set_context ( $context );

// Ve si el usuario esta conectado
require_login ();

// Page navigation and URL settings.
$PAGE->set_url ( new moodle_url ( '/local/feria/FormularioProyecto.php' ) );
$PAGE->set_pagelayout("incourse");
$PAGE->set_title ( get_string ( "titulo", "local_feria" ) );

$idusuario=$USER->id;
echo'<form action="buscar.php" method="post" >
		<table align="center">
		<tr>
		<td><td><a href="'.new moodle_url('/local/feria/index.php').'" class="classname"> '.get_string("inicio","local_feria").' </a></td>
		<td><td><a href="' . new moodle_url ( '/local/feria/perfil.php?id='.$idusuario.'' ) . '" class="classname"> '.get_string("mi_perfil","local_feria").' </a> </td>
		<td><input type="text" name="buscar" placeholder="'.get_string("buscar","local_feria").'" align ="center"></td>
		<td><input type="image" src="lupa.png" width="25" height="25></td>
		<td><a href=""></a></td>
		<td><a href="'.new moodle_url("/local/feria/FormularioProyecto.php").'" class="classname">'.get_string("subir_proyecto","local_feria").'</a></td>
		<td><a href="'.new moodle_url("/local/feria/explorar.php").'" class="classname">'.get_string("explorar","local_feria").'</a></td>
		</tr>
		</table>
		</form>';
echo $OUTPUT->header ();

// Formulario para subir el proyecto
echo '<form action="guardarProyecto.php" method="post" enctype="multipart/form-data">
<table>
<tr><td>' . get_string ( "nombre_proyecto", "local_feria" ) . ': </td><td><input type="text" name="nombre" >*</td></tr>
<tr><td>' . get_string ( "descripcion", "local_feria" ) . ':</td><td><input type="text" name="descripcion" >*</td></tr>
<tr><td>' . get_string ( "categoria", "local_feria" ) . ':</td><td> <select name="categoria">
<option value="arte">' . get_string ( "arte", "local_feria" ) . '</option>
<option value="biologia">' . get_string ( "biologia", "local_feria" ) . '</option>
<option value="deporte">' . get_string ( "deporte", "local_feria" ) . '</option>
<option value="fisica">' . get_string ( "fisica", "local_feria" ) . '</option>
<option value="historia">' . get_string ( "historia", "local_feria" ) . '</option>
<option value="matematicas">' . get_string ( "matematicas", "local_feria" ) . '</option>
<option value="medio">' . get_string ( "medio", "local_feria" ) . '</option>
<option value="musica">' . get_string ( "musica", "local_feria" ) . '</option>
<option value="negocios">' . get_string ( "negocios", "local_feria" ) . '</option>
<option value="quimica">' . get_string ( "quimica", "local_feria" ) . '</option>
</select>*</td></tr>
 <tr><td>' . get_string ( "foto", "local_feria" ) . ':</td><td><input TYPE="file" name="foto1" id="foto1" />*</td></tr>
<tr><td></td><td><input TYPE="file" name="foto2" id=�foto2� /></td></tr>
<tr><td></td><td><input TYPE="file" name="foto3" id=�foto3� /></td></tr>
<tr><td></td><td><input TYPE="file" name="foto4" id=�foto4�/></td></tr>
<tr><td>' . get_string ( "archivo", "local_feria" ) . ':  </td><td> <input type="file" name="archivo" id=�archivo� />*</td></tr>
 <tr><td>' . get_string ( "url_video", "local_feria" ) . ':  </td><td><input type="text" name="urlvideo" /></td></tr>
 <tr><td></td><td><p><input name=enviardatos type="submit" value="' . get_string ( "enviar", "local_feria" ) . '" /></p></td><td></td></tr>
<tr><td></td><td> * ' . get_string ( "campos_obligatorios", "local_feria" ) . '</td></tr></table>
		<tr><td></td><td> * ' . get_string ( "requerimientos", "local_feria" ) . '</td></tr></table></form> ';
// Show the page footer
echo $OUTPUT->footer ();