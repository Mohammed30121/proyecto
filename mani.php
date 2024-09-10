<!DOCTYPE html>
<html>
<head>
<script src = 'funcionesjava.js'></script>
<link rel="stylesheet" href="estilosCSS.css">
</head>
<!-- BARRA DE BUSQUEDA -->
    <nav class = 'navbar'>

        
    <!-- DIV PARA VOLVER OPACA LA PANTALLA CUANDO LE DAS AL BOTON DE AGREGAR LIBRO-->
    <div id = 'fondoAgregar' class = 'fondoAgregar'></div>
        


        <!-- BOTON PARA MOSTRAR EL SELECTOR DE CATEGORIAS, MENU Y FORMULARIOS -->
        <button onclick = "mostrarMenu()" class = 'buttonMenuBar' >
         = </button>

        <!--MOSTRAR OPCIONES PARA INICIAR O CERRAR SESION -->
        
        <div id = 'menu-container' style = 'display: none;'>
        <h3 style = 'color: white;'>Admin Tools</h3>
        <a href = 'inicioSesion.php'class = 'buttonMenuBar'>Ingresar</a>
        <a href = 'cerrarSesion.php' class = 'buttonMenuBar'>Finalizar</a>
            <?php
            session_start();
            //vv CONEXION vv
            require 'conexion.php';
            $conn = conexion($servername, $username, $password,$db);


        //FORMULARIO PARA LA BARRA DE BUSQUEDA
        echo "<form action = 'masInfo.php' method = 'post' class = 'formMenuBar'>
            <input type = 'search' name = 'busqueda'>
            <button class = 'buttonMenuBar'> Buscar </button>
        </form><br><br>";


            //INFO PARA RECIBIR LOS GNEROS Y CREAR LAS OPCIONES DEL SELECT
            $stmt = $conn ->prepare('SELECT * FROM generos');
            $stmt -> execute();

            //ARREGLO QUE TIENE LOS DATOS
            $registros = array();
            $i=0;
            while($row=$stmt->fetch()) {
	            $registros[$i]=$row;
	            $i++;
	            }
            
            //FORMULARIO Y CICLO PARA CREAR EL SELECT CON TODO EL AUSNTO
            echo "<form action = 'masInfo.php' method = 'post' class = 'formMenuBar'>";
            echo "<select name = 'genFiltro'>";
            echo "<option></option>";
            foreach($registros as $info){
                $valor = htmlspecialchars($info['idGen']);
                $nombre = htmlspecialchars($info['genero']);
                echo "<option value = '$valor'> $nombre </option>";
                
            }
            echo "</select>";
            echo "<button class = 'buttonMenuBar'>Filtrar</button>";
            echo "</form>";
            ?>

            </form>
        </div>
    </nav>
</html>



<?php
//ESTO SE ASEGURA QUE LA VARIABLE DE SESION PARA EL ADMIN SIEMPRE TENGA CONTENIDO

if(empty($_SESSION['adminUser'])){
    $idAdmin = 1;
}else{ $idAdmin = $_SESSION['adminUser']; }


//AQUI INICIAN LAS COSAS PARA PODER MOSTRAR LOS LIBROS 
//vv QUERY PARA MOSTRAR Y COMANDO PARA EJECUTARLO vv
$stmt = $conn->prepare('SELECT * FROM libros');

$stmt -> execute();
$stmt->setFetchMode(PDO:: FETCH_ASSOC);



//vv CICLO PARA GENERAR UN ARREGLO QUE CONTENGA LOS DATOS DE LA BASE DE DATOS vv
$registros = array();
$i=0;
while($row=$stmt->fetch()) {
	$registros[$i]=$row;
	$i++;
	}



//vv CILCO PARA MOSTRAR LOS DATOS DE LA BASE DE DATOS EN UNA TABLA vv
//vv TAMBIEN TIENE UN FORMULARIO PARA PONER BOTONES ESCENCIALES vv
$datos = $registros;
$cont = 0;
echo "<table class = 'tablas'>
<tr>
<th>Portada</th>
    <th>Titulo</th>
    <th>Disponibles</th>
    <th></th>
    <th></th>
</tr>
";
foreach($datos as $info){

    //vv MOSTRAR TEXTO E IMAGEN DEL LIBRO vvs
    $img = htmlspecialchars($info['imagen']);
    $id = htmlspecialchars($info['id']);
    echo "<tr><td><a href='masInfo.php?id=" . htmlspecialchars($info['id']) . "'>
    <img src = '$img' width = '200' height = '250'><br>
    </a>";
    echo "<td>" . htmlspecialchars($info['nombre']) . "</td>";
    echo "<td>" . htmlspecialchars($info['cantidad']) . "  </td>";


    //vv FORMULARIO PARA EL BOTON DE EDITAR vv
    if($idAdmin == 2){
    echo " 
    <td><form action = 'editarLibros.php' method = 'post'>
    <input type = 'hidden' value = '$id' name = 'id'>
    <button class = 'btnEdit'> Editar </button>
    </td></form>


     " . //vv FORMULARIO PARA EL BOTON DE ELIMINAR vv
     "<td>
    <form action = 'eliminar.php' method = 'post'>
    <input type = 'hidden' value = '$id' name = 'id'>
    <button class = 'btnDelete'> Eliminar </button>
    </form><br><br>
    
    </td><br>";
    }

    //BOTON PARA SOLICITAR LIBRO
    if($idAdmin == 1){
    echo "
    <td>
    <form action = 'pedir.php' method = 'post'>
    <input type = 'hidden' value = '$id' name = 'id'>
    <button class = 'btnEdit' onclick = 'alerta()'> Solicitar </button>
    </form><br><br>
    </td></tr><br>";
    }
}
echo " </table>";
//^^ AQUI ACABA EL CODIGO PARA MOSTRAR TODO ^^
?>

<html>
    <head>
    <script src = 'funcionesJava.js'></script>
</head>
<!-- vv BOTON DE AGREGAR vv -->
    <?php
    if($idAdmin == 2){
        echo "
        <form action = 'pedidos.php'>
        <button class = 'btnPedidos' >Pedidos</button>
        </form>";
        echo "<div> <button class='botonAgregar' onclick = 'mostrarAgregar()'> Agregar </button> </div>";
    }
    ?>

<!-- CONTENEDORES -->
    <div class="popup" id="popup-container">
    <!-- Contenido del popup -->
    <div id="popup-content" class = 'popupC' style = 'align: center;'>
        <!-- Formulario de agregar libro -->
        <?php include 'agregarLibro.php'; ?>
    </div>
</html>