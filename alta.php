<!DOCTYPE html>
<?php
//CONEXION
include_once 'conexion.php';
$conn = conexion($servername, $username, $password,$db);



//RECIBIR DATOS DE FORMULARIOS
$nombre = $_POST["nombre"];
$autor = $_POST["autor"];
$fecha = $_POST["publicacion"];
$sinopsis = $_POST["sinopsis"];
$portada = "portadas/" . $_POST["portada"];
$cantidad = $_POST["cantidad"];


//QUERY DE ALTAS
    $stmt = $conn ->prepare('INSERT INTO libros (imagen, nombre, autor, publicacion, intro, cantidad) 
    VALUES (:portada, :nombre, :autor, :publicacion, :sinopsis, :cantidad)');



    //INSETAR TEXTO DE LAS VARIABLES A LOS TEXTOS CON BINDPARAM
    $stmt -> bindParam(":portada", $portada);
    $stmt -> bindParam(":nombre", $nombre);
    $stmt -> bindParam(":autor", $autor);
    $stmt -> bindParam(":publicacion", $fecha);
    $stmt -> bindParam(":sinopsis", $sinopsis);
    $stmt -> bindParam(":cantidad", $cantidad);
    $stmt ->fetch(PDO::FETCH_ASSOC);
    $stmt -> execute();



    $ultimoID  = $conn-> lastInsertId();

    foreach($_POST['genero'] as $select){
        $sql = $conn ->prepare('INSERT INTO libgen(idLibro, idGenero) VALUES (:idLibro, :idGen)');
        $sql -> bindParam(":idLibro", $ultimoID);
        $sql -> bindParam(":idGen", $select);
        $sql -> execute();
    }


    
//OTRAS COSAS
    $portada = "";
    header("Location: mani.php");
?>