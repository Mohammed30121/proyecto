<?php
//CONEXION
include_once 'conexion.php';
$conn = conexion($servername, $username, $password,$db);
session_start();

session_destroy();
header('Location: mani.php');
?>