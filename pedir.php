<?php
include_once 'conexion.php';
$conn = conexion($servername, $username, $password,$db);

$stmt = $conn ->prepare('SELECT * FROM libros WHERE id = :idP');
$stmt -> bindParam(':idP',$_POST['id']);
$stmt -> execute();
$stmt->setFetchMode(PDO:: FETCH_ASSOC);

$data = $stmt -> fetch();

$sql = $conn ->prepare('INSERT INTO pedidos(imagen, nombre, autor, publicacion, intro, cantidad, id) 
VALUES (:img, :nombre, :autor, :publicacion, :intro, :cantidad, :id)');
$sql -> bindParam(':img',$data['imagen']);
$sql -> bindParam(':nombre',$data['nombre']);
$sql -> bindParam(':autor',$data['autor']);
$sql -> bindParam(':publicacion',$data['publicacion']);
$sql -> bindParam(':intro',$data['intro']);
$sql -> bindParam(':cantidad',$data['cantidad']);
$sql -> bindParam(':id',$data['id']);
$sql -> execute();

header('Location: mani.php');
?>