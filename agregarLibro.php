<?php
include_once 'conexion.php';
$conn = conexion($servername, $username, $password,$db);
?>

<!DOCTYPE html>
<html>

<head>

<script src = 'funcionesJava.js'></script>

<link href="estilosCSS.css" rel="stylesheet" type="text/css">
</head>

<body>
    <form action = 'alta.php' method = 'post' id = 'formAgregar'>

<!-- PORTADA DEL LIBRO -->
        <input type = 'file' name = 'portada'>
        <br><br>

<!-- TUITULO -->
        <label> Titulo de la obra: </label>
        <input type = 'text' name = 'nombre'>
        <br><br>

<!-- AUTOR -->
        <label> Nombre del autor: </label>
        <input type = 'text' name = 'autor'>
        <br><br>

<!-- FECHA DE PUBLICACION -->
        <label> Fecha de publicacion </label>
        <input type = 'text' name = 'publicacion'>
        <br><br>

<!-- SINOPSIS -->
        <label> Sinopsis: </label><br>
        <textarea name = 'sinopsis' rows = '5' cols = '45'> </textarea>
        <br><br>

<!-- CANTIDAD DISPONIBLE -->
        <label> Cantidad: </label><br>
        <input type = 'number' name = 'cantidad'>
        <br><br>

<!-- INSERTA CHECKBOX DEPENDIENDO DE CUANTOS GENEROS EXISTAN -->
<?php
$stmt = $conn ->prepare('SELECT * FROM generos');
$stmt -> execute();

$registros = array();
$i=0;
while($row=$stmt->fetch()) {
	$registros[$i]=$row;
	$i++;
	}

foreach($registros as $info){
        $valor = htmlspecialchars($info['idGen']);
        echo "<label>" . htmlspecialchars($info['genero']) . "</label>";
        echo "<input type = 'checkbox' name = 'genero[]' value = '$valor'>";
}
?>

<!-- BOTON AGREGAR -->
        <br><button type = 'submit' class = 'buttonMenuBar'> Agregar </button>
</form>

<!-- BOTON DE CANCELAR -->
<button onclick = 'cerrarAgregar()' class = 'buttonMenuBar'> Cerrar </button>

</body>
</html>