<htmL>
<head>
<link rel="stylesheet" href="estilosCSS.css">
</head>
<nav class = 'navbar'>
    <a href = 'mani.php' class = 'buttonMenuBar'>Inicio</a>
</nav>
</html>

<?php
//CONEXION
session_start();
include_once 'conexion.php';
$conn = conexion($servername, $username, $password,$db);



//vv RECUPERAR DATOS DEL LIBRO DESDE LA BASE DE DATOS POR MEDIO DE ID vv
$stmt = $conn->prepare('SELECT imagen, nombre, autor, publicacion, intro, cantidad, id FROM libros WHERE id = :id');
$_SESSION['id'] = $_POST['id'];
$stmt -> bindParam(':id', $_POST['id']);
$stmt -> execute();
$stmt->setFetchMode(PDO:: FETCH_ASSOC);



//vv AQUI INICIA LA RECUPERACION DE DATOS PARA PODER MOSTRAR EN EDICION vv
//vv CICLO PARA GENERAR UN ARREGLO QUE CONTENGA LOS DATOS DE LA BASE DE DATOS vv
$registros = array();
$i=0;
while($row=$stmt->fetch()) {
	$registros[$i]=$row;
	$i++;
	}



//vv CICLO PARA INSETAR LOS DATOS DE LA BASE DE DATOS A VARIABLES PARA MANEJO vv
foreach($registros as $info){
    $img = htmlspecialchars($info['imagen']);
    echo "<td> <img src = '$img' width = '150' height = '200'> </td> <br>";
    $nombre = htmlspecialchars($info['nombre']);
    $autor = htmlspecialchars($info['autor']);
    $publicacion = htmlspecialchars($info['publicacion']);
    $intro = htmlspecialchars($info['intro']);
    $cantidad = htmlspecialchars($info['cantidad']);

}
//^^ AQUI ACABA LA RECUPERACION DE DATOS ^^
?>




<html>
<form action = 'editar.php' method = 'post'>

<!-- PORTADA DEL LIBRO -->
        <input type = 'file' name = 'portada'>
        <br><br>

<!-- TUITULO -->
        <label> Titulo de la obra: </label>
        <input type = 'text' name = 'nombre' value = '<?php echo "$nombre" ?>'>
        <br><br>

<!-- AUTOR -->
        <label> Nombre del autor: </label>
        <input type = 'text' name = 'autor' value = '<?php echo "$autor" ?>'>
        <br><br>

<!-- FECHA DE PUBLICACION -->
        <label> Fecha de publicacion </label>
        <input type = 'text' name = 'publicacion' value = '<?php echo "$publicacion" ?>'>
        <br><br>

<!-- SINOPSIS -->
        <label> Sinopsis: </label><br>
        <textarea name = 'sinopsis' rows = '5' cols = '45'><?php echo "$intro" ?> </textarea>
        <br><br>

<!-- CANTIDAD DISPONIBLE -->
        <label> Cantidad: </label><br>
        <input type = 'number' name = 'cantidad' value = '<?php echo "$cantidad" ?>'>
        <br><br>

        
<!-- GENEROS (CHECKBOX) -->
<?php
$stmt = $conn ->prepare('SELECT * FROM generos');
$stmt -> execute();

//CICLO PARA METER LOS DATOS A UN ARREGLO PARA EL CICLO FOREACH QUE CREA CHECKBOX
$registros = array();
$i=0;
while($row=$stmt->fetch()) {
	$registros[$i]=$row;
	$i++;
	}

//PARA AGARRAR LOS DATOS DE LA TABLA QUE TIENE EL ID DE LIBRO Y DE GENERO JUNTOS
$sql = $conn ->prepare('SELECT * FROM libgen');
$sql -> execute();

$dosId = array();
$x=0;
while($row=$sql->fetch()) {
	$dosId[$x]=$row;
	$x++;
	}

//CICLO FOREACH QUE CREA LOS CHECKBOX DEPENDIENDO DE CUANTOS GENEROS EXISTEN
foreach($registros as $Tgeneros){
        $Val = htmlspecialchars($Tgeneros['idGen']);
        $checked = false;
        foreach($dosId as $Tids){
            if(htmlspecialchars($Tids['idLibro']) == $_POST['id'] && htmlspecialchars($Tids['idGenero']) == htmlspecialchars($Tgeneros['idGen'])){
                $checked = true;
                break;
            }
        }
        if($checked){
            echo "<label>" . htmlspecialchars($Tgeneros['genero']) . "</label>";
            echo "<input type = 'checkbox' name = 'genero[]' value = '$Val' checked>";
            echo ".      ";
        } else {
            echo "<label>" . htmlspecialchars($Tgeneros['genero']) . "</label>";
            echo "<input type = 'checkbox' name = 'genero[]' value = '$Val'>";
            echo ".      ";
        }
    }
?>
<!--AQUI ACABA LO DE MOSTRAR CHECKBOX-->


<!-- BOTON AGREGAR -->
        <button> Editar </button>
</form>

<!-- BOTON DE CANCELAR -->
<form action = 'mani.php'><br>
    <button> cancelar </button>
</form>
</html>