<html>
<head>
<link rel="stylesheet" href="estilosCSS.css">
<style>
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}
</style>
</head>
<nav class = 'navbar'>
    <a href = 'mani.php' class = 'buttonMenuBar'>Inicio</a>
</nav>
<body>

<?php
include_once 'conexion.php';
$conn = conexion($servername, $username, $password,$db);

$stmt = $conn ->prepare('SELECT * FROM pedidos');
$stmt -> execute();

$registros = array();
$i=0;
while($row=$stmt->fetch()) {
	$registros[$i]=$row;
	$i++;
	}
echo "<table style = 'border: solid;'>
<tr>
    <th>Portada</th>
    <th>Titulo</th>
    <th>Autor</th>
    <th>Fecha Publicacion</th>
    <th>Sinopsis</th>
    <th>Disponibles</th>
    <th>Id</th>
    <th>Opciones</th>
  </tr>
";
foreach($registros as $datos){
    $img = htmlspecialchars($datos['imagen']);
    $id = htmlspecialchars($datos['id']);
    echo "<tr>";
    echo "<td> <img src = '$img' width = '100' height = '150'> </td>" ;
    echo "<td>" . htmlspecialchars($datos['nombre']) . "</td>";
    echo "<td>" . htmlspecialchars($datos['autor']) . "</td>";
    echo "<td>" . htmlspecialchars($datos['publicacion']) . "</td>";
    echo "<td>" . htmlspecialchars($datos['intro']) . "</td>";
    echo "<td>" . htmlspecialchars($datos['cantidad']) . "</td>";
    echo "<td>" . htmlspecialchars($datos['id']) . "</td>";
    echo "<td> <form action = 'eliminar.php' method = 'post'>
    <input type = 'hidden' value = '$id' name = 'Pedido'>
    <button>Aceptar</button>
    </form>
    </td>";
    echo "</tr>";
}
echo "</table>";
?>