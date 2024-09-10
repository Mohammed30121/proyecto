<htmL>
<head>
<link rel="stylesheet" href="estilosCSS.css">
</head>
<nav class = 'navbar'>
    <a href = 'mani.php' class = 'buttonMenuBar'>Inicio</a>
</nav>
</html>
<form  action = 'usuario_alta_inicio.php' method = 'post'>
            <label>Ingresa Usuario Administrador </label><br>
            <input type = 'text' name = 'adminUser' required><br><br>

            <label> Ingresa Contrase&ntildea de Administrador</label><br>
            <input type = 'password' name = 'adminPass' required><br><br>

            <button type = 'submit' class = 'buttonMenuBar'>Acceder</button>
            <a href = 'mani.php' class = 'buttonMenuBar'>Cancelar</a>
</form>