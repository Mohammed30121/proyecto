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
include_once 'conexion.php';
$conn = conexion($servername, $username, $password,$db);


//vv ESTO SIRVE PARA INSETAR LOS VALORES PARA EJECUTAR EL QUERY vv
if(!empty($_POST['busqueda'])){
    $gen = $_POST['busqueda'];
}else if(!empty($_GET['id'])){
    $gen = $_GET['id'];
}else {
    $gen = $_POST['genFiltro'];
}

    

    //PARA MOSTRAR LOS LIBROS POR LOS DATOS EN LA BARRA DE BUSQUEDA
    if(!empty($_POST['busqueda'])){
            $gen = '%' . $gen . '%';
            $stmt = $conn ->prepare('SELECT imagen, nombre, autor, publicacion, intro, cantidad FROM libros WHERE nombre LIKE :res');
            $stmt -> bindParam(':res', $gen);

        //PARA MOSTRAR LOS LIBROS POR ID ES DECIR DANDOLE CLICK A LA PORTADA EN EL MENU
    }else if(!empty($_GET['id'])){
            $stmt = $conn ->prepare('SELECT imagen, nombre, autor, publicacion, intro, cantidad FROM libros WHERE id = :id');
            $stmt -> bindParam(':id', $gen);
        }else{
//PARA MOSTRAR LOS IBROS POR GENERO
$numero = $_POST['genFiltro'];

$stmt = $conn->prepare('
    SELECT l.imagen, l.nombre, l.autor, l.publicacion, l.intro, l.cantidad, g.genero
    FROM libros l
    JOIN libgen lg ON l.id = lg.idLibro
    JOIN generos g ON lg.idGenero = g.idGen
    WHERE g.idGen = :numero
');
$stmt->bindParam(':numero', $numero);
}
//AQUI ACABA EL SELECTOR DE FORMAS DE MOSTRAR

$stmt -> execute();


//vv CREA UN ARREGLO CON LOS VALORES RECUPERADOS DE LA BASE DE DATOS vv
$registros = array();
$i=0;
while($row=$stmt->fetch()) {
	$registros[$i]=$row;
	$i++;
	}


//vv REVISA SI EL ARREGLO TIENE DATOS Y SI ESTA VACIO TE REGRESA A LA PAGINA PRINCIPAL vv
if(count($registros) == 0){
    header("Location: mani.php");
}


//vv CICLO PARA MOSTRAR LOS DATOS RECUPERADOS vv
echo "<table class = 'tablas'>
<tr>
    <th>Portada</th>
    <th>Titulo</th>
    <th>Autor</th>
    <th>Fecha Publicacion</th>
    <th>Sinopsis</th>
    <th>Disponibles</th>
  </tr>"; 
foreach($registros as $datos){
    //vv MOSTRAR TEXTO E IMAGEN DEL LIBRO vv
    echo "<div class ='consulta'>";
    $img = htmlspecialchars($datos['imagen']);
    echo "<tr>";
    echo "<td> <img src = '$img' width = '100' height = '150'> </td>" ;
    echo "<td>" . htmlspecialchars($datos['nombre']) . "</td>";
    echo "<td>" . htmlspecialchars($datos['autor']) . "</td>";
    echo "<td>" . htmlspecialchars($datos['publicacion']) . "</td>";
    echo "<td>" . htmlspecialchars($datos['intro']) . "</td>";
    echo "<td>" . htmlspecialchars($datos['cantidad']) . "</td>";
    echo "</td>";
    echo "</tr>";
}
echo "</table>";

echo "
<form action = 'mani.php'>
<button class = 'buttonMenuBar'> Volver </button>
</form>
";
?>