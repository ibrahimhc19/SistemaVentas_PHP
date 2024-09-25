<?php 


if (isset($_POST["botonInicio"])){
    if(!empty($_POST['usuario']) and !empty($_POST['password'])){
        echo $_POST['usuario']. " " .$_POST['password'];
        $usuario = $_POST['usuario'];
        $password = $_POST['password'];
    } else{
        echo "Campos vacíos";
    }
}


?>