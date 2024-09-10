<?php
//vv CONEXION vv
session_start();
include_once 'conexion.php';
$conn = conexion($servername, $username, $password,$db);



//vv RECIBIR DATOS DEL FORMULARIO EDITADO vv
$nombre = $_POST["nombre"];
$autor = $_POST["autor"];
$fecha = $_POST["publicacion"];
$sinopsis = $_POST["sinopsis"];
$portada = "portadas/" . $_POST["portada"];
$cantidad = $_POST["cantidad"];
$id = $_SESSION["id"];

$genero = implode(" , ", $_POST["genero"]);

//vv QUERY PARA EDITAR LOS DATOS Y EJECUCION vv
if($_POST['portada'] != ""){
    $stmt = $conn->prepare('UPDATE libros SET imagen = :imagen, nombre = :nombre, autor = :autor, publicacion = :publicacion, intro = :intro, cantidad = :cantidad
WHERE id = :id');
$stmt -> bindParam(":imagen",$portada);
}else{
    $stmt = $conn->prepare('UPDATE libros SET nombre = :nombre, autor = :autor, publicacion = :publicacion, intro = :intro, cantidad = :cantidad
WHERE id = :id');
}


    

$stmt -> bindParam(":nombre",$nombre);
$stmt -> bindParam(":autor",$autor);
$stmt -> bindParam(":publicacion",$fecha);
$stmt -> bindParam(":intro",$sinopsis);
$stmt -> bindParam(":cantidad",$cantidad);
$stmt -> bindParam(":id",$id);
$stmt -> execute();



//OBTIENE LOS DATOS DE LA TABLA LIBGEN
$sql = $conn ->prepare('SELECT idLibro FROM libgen');
$sql -> execute();

$dosId = array();
$x=0;
while($row=$sql->fetch()) {
	$dosId[$x]=$row;
	$x++;
	}


//ELIMINA LOS DATOS CORRESPONDIENTES AL ID DEL LIBRO A EDITAR PARA LUEGO VOLVER A INSERTARLOS
$query = $conn ->prepare('DELETE FROM libgen WHERE idLibro = :id');
$query -> bindParam(':id', $id);
$query -> execute();

//INSERTA DE NUEVO EL ID DEL LIBRO Y GENERO AL LIBRO EDITADO
foreach($_POST['genero'] as $Gactual){
    $Mdb = $conn ->prepare('INSERT INTO libgen(idLibro, idGenero) VALUES (:idL, :idG)');
    $Mdb -> bindParam(':idL', $id); 
    $Mdb -> bindParam(':idG', $Gactual);
    $Mdb -> execute();
}

$_SESSION['id'] = null;

header("Location: mani.php");
?>