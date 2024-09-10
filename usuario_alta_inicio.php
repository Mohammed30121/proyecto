<?php
//CONEXION
session_start();
include_once 'conexion.php';
$conn = conexion($servername, $username, $password,$db);

$_SESSION['adminUser'] = 1;
$stmt = $conn ->prepare('SELECT * FROM usuarios WHERE usuario = :Uinsert AND contra = :Cinsert');
$stmt -> bindParam(':Uinsert',$_POST['adminUser']);
$stmt -> bindParam(':Cinsert',$_POST['adminPass']);
$stmt -> execute();
$stmt->setFetchMode(PDO:: FETCH_ASSOC);
$res = $stmt->fetchAll();
if(!empty($res)){
    $_SESSION['adminUser'] = 2;
}
header('Location: mani.php');
?>