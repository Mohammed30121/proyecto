<?php
//CONEXION
include_once 'conexion.php';
$conn = conexion($servername, $username, $password,$db);

if(empty($_POST['Pedido'])){
$id = $_POST['id'];
//QUERY ELIMINAR
$stmt = $conn->prepare('DELETE FROM libros WHERE id = :id');
$stmt -> bindParam(':id', $id);
$stmt -> execute();

$sql = $conn->prepare('DELETE FROM libgen WHERE idLibro = :id');
$sql -> bindParam(':id', $id);
$sql -> execute();
header('Location: mani.php');
}else{
    $stmt = $conn ->prepare('DELETE FROM pedidos WHERE id = :id');
    $stmt -> bindParam(':id',$_POST['Pedido']);
    $stmt -> execute();
    header('Location: pedidos.php');
}
?>