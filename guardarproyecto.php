<?php
if(isset($_REQUEST ['nombre'], $_REQUEST ['categoria'],$_REQUEST['descripcion']) && $_FILES['foto1']['size']>0 && $_FILES['archivo']['size']>0)
{
require "../../config.php";// archivo que ayuda a subir los datos del formulario a BBDD
include '/feria_locallib.php'; //se incluyen dentro del codigo diferentes funciones 
error_reporting (E_ALL ^ E_WARNING);

// var_dump ( $_FILES ); 
// var_dump ( $_REQUEST );
//Datos obtenidos de la foto 1
$nombre1 = $_FILES['foto1']['name'];
$tempNombre1  =$_FILES['foto1']['tmp_name'];
$tamano1 =$_FILES['foto1']['size'];
$tipo1 =$_FILES['foto1']['type'];

//Datos obtenidos de la foto 2
$nombre2 = $_FILES['foto2']['name'];
$tempNombre2  =$_FILES['foto2']['tmp_name'];
$tamano2 =$_FILES['foto2']['size'];
$tipo2 =$_FILES['foto2']['type'];

//Datos obtenidos de la foto 3
$nombre3 = $_FILES['foto3']['name'];
$tempNombre3  =$_FILES['foto3']['tmp_name'];
$tamano3 =$_FILES['foto3']['size'];
$tipo3 =$_FILES['foto3']['type'];

//Datos obtenidos de la foto 4
$nombre4 = $_FILES['foto4']['name'];
$tempNombre4  =$_FILES['foto4']['tmp_name'];
$tamano4 =$_FILES['foto4']['size'];
$tipo4 =$_FILES['foto4']['type'];

//Datos obtenidos del archivo pdf
$nombre5 = $_FILES['archivo']['name'];
$tempNombre5  =$_FILES['archivo']['tmp_name'];
$tamano5 =$_FILES['archivo']['size'];
$tipo5 =$_FILES['archivo']['type'];
echo $tipo5;
//Se guardan las fotos, en la carpeta fotos, a traves de la función subirFoto creada en
//locallib.php
	$urlfoto1=subirFoto($nombre1,$tamano1,$tempNombre1,$tipo1);
	$urlarchivo=subirArchivo($nombre5, $tamano5, $tempNombre5, $tipo5);
	if( $_FILES['foto2']['size']>0)
	{
	$urlfoto2=subirFoto($nombre2,$tamano2,$tempNombre2,$tipo2);
	$foto2=$CFG->wwwroot . '/local/feria/' . $urlfoto2;
	}
	else 
	{
		$foto2=' ';
		echo "no tienes foto 2";
	}
	if( $_FILES['foto3']['size']>0)
	{
		$urlfoto3=subirFoto($nombre3,$tamano3,$tempNombre3,$tipo3);
		$foto3=$CFG->wwwroot . '/local/feria/' . $urlfoto3;
	}
	else
	{
		$foto3=' ';
	}
	if( $_FILES['foto4']['size']>0)
	{
		$urlfoto4=subirFoto($nombre4,$tamano4,$tempNombre4,$tipo4);
		$foto4=$CFG->wwwroot . '/local/feria/' . $urlfoto4;
	}
	else
	{
		$foto4=' ';
	}
	// idea para cambiar la cosa del null es poner las $proyecto->urlfoto dentro del if
		// Insertamos en la BBDD
		
		$proyecto = new stdClass ();
		$proyecto->nombre = $_REQUEST ['nombre'];
		$proyecto->categoria = $_REQUEST ['categoria'];
		$proyecto->urlarchivo =$CFG->wwwroot . '/local/feria/'.$urlarchivo;
		$proyecto->descripcion = $_REQUEST ['descripcion'];
		$proyecto->urlfoto1 = $CFG->wwwroot . '/local/feria/'.$urlfoto1;
		// no funciona y no se ponen en NULL si es que no hay foto subida
		$proyecto->urlfoto2 = $foto2; 
		$proyecto->urlfoto3 = $foto3;
		$proyecto->urlfoto4 = $foto4;
		$proyecto->urlvideo =$_REQUEST ['urlvideo'];
		$proyecto->userid = $USER->id;
		
		
		$DB->insert_record ( 'proyecto', $proyecto );
}
else {
	
	header('Location: FormularioProyecto.php');
	}
?>
                        
         
                      
            
 
                      