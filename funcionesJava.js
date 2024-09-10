function mostrarAgregar(){
    document.getElementById('popup-container').style.display = 'block';
    document.getElementById("fondoAgregar").style.display = 'block';
}

function cerrarAgregar(){
    document.getElementById('popup-container').style.display = 'none';
    document.getElementById('fondoAgregar').style.display = 'none';
}

function mostrarMenu(){
    var x = document.getElementById("menu-container");
    if (x.style.display == "none") {
        x.style.display = "block";
    } else {
        x.style.display = "none";
    }

}

function masinfo(){
    document.getElementById('').style.display = 'block';
}