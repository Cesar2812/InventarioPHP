<?php
    require_once "./main.php"; 

    //almacendo datos
    $name=ClearData($_POST['user_name']);
    $lastName=ClearData($_POST['user_last']);
    $user=ClearData($_POST['user']);
    $email=ClearData($_POST['email']); 
    $pass=ClearData($_POST['user_pass_1']);
    $pass2=ClearData($_POST['user_pass_2']); 

    //verificando campos obligatorios
    if($name==""||$lastName==""||$user==""||$pass==""||$pass==""){
        echo '
            <div class="notification is-danger">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                No has llenado todos los campos que son obligatorios
            </div>
            ';
        exit();
    }
?>