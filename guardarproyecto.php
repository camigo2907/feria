<?php
require "../../config.php";
error_reporting ( E_ALL ^ E_WARNING );

var_dump ( $_FILES );
var_dump ( $_REQUEST );

$nombre = $_POST ['nombre'];
$descripcion = $_POST ['descripcion'];
$categoria = $_POST ['categoria'];
$urlvideo = $_POST ['urlvideo'];
// Guardado de foto1 esta tiene que esta si o si
$fileName1 = $_FILES ['uploadedfile'] ['name'];
$tmpName1 = $_FILES ['uploadedfile'] ['tmp_name'];
$fileSize1 = $_FILES ['uploadedfile'] ['size'];
$fileType1 = $_FILES ['uploadedfile'] ['type'];

$uploadedfileload = "true";
$uploadedfile_size = $_FILES ['uploadedfile'] ['size'];
echo $_FILES ['uploadedfile'] ['name'];
if ($_FILES ['uploadedfile'] ['size'] > 200000) {
	$msg = "El archivo es mayor que 200KB, debes reduzcirlo antes de subirlo<BR>";
	$uploadedfileload = "false";
}

if (! ($_FILES ['uploadedfile'] ['type'] == "image/jpeg" || $_FILES ['uploadedfile'] ['type'] == "image/gif")) {
	$msg = " Tu archivo tiene que ser JPG o GIF. Otros archivos no son permitidos<BR>";
	$uploadedfileload = "false";
}

$file_name = $_FILES ['uploadedfile'] ['navme'];
$add = "uploads/$file_name";
if ($uploadedfileload == "true") {
	
	if (move_uploaded_file ( $_FILES ['uploadedfile'] ['tmp_name'], $add )) {
		echo " Ha sido subido satisfactoriamente";
		
		// Insertamos en la BBDD
		
		$proyecto = new stdClass ();
		$proyecto->nombre = $_REQUEST ['nombre'];
		$proyecto->categoria = $_REQUEST ['categoria'];
		$proyecto->urlarchivo = '';
		$proyecto->descripcion = $_REQUEST ['descripcion'];
		$proyecto->urlfoto1 = $CFG->wwwroot . '/local/feria/' . $add;
		$proyecto->urlfoto2 = NULL;
		$proyecto->urlfoto3 = NULL;
		$proyecto->urlvideo = NULL;
		$proyecto->userid = $USER->id;
		
		$DB->insert_record ( 'proyecto', $proyecto );
	} else {
		echo "Error al subir el archivo";
	}
} else {
	echo $msg;
}
?>
                        
         
                      
            
 
                      