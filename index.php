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
include 'feria_locallib.php';
Global $DB;
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
echo encabezado($idusuario);
// Show the page header
echo $OUTPUT->header();
// Here goes the content

$sql = 'SELECT p.id, p.nombre, u.firstname, u.lastname, p.categoria,p.urlfoto1
				FROM mdl_proyecto p
				JOIN mdl_user u
		        ON p.userid = u.id
				WHERE p. id ="' . $idProyecto . '"';

$consulta = $DB->get_records_sql ( $sql );
// Show the page footer
echo $OUTPUT->footer();


