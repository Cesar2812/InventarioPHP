<?php
    require_once "main.php"; 

    //limpiando datos
    $name=ClearData($_POST['user_name']);
    $lastName=ClearData($_POST['user_last']);
    $user=ClearData($_POST['user']);
    $email=ClearData($_POST['email']); 
    $pass=ClearData($_POST['user_pass_1']);
    $pass2=ClearData($_POST['user_pass_2']); 

    //verificando campos obligatorios
    if($name==""||$lastName==""||$user==""||$pass==""||$pass2==""||$email==""){
        echo '
            <div class="notification is-danger">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                No has llenado todos los campos que son obligatorios
            </div>
            '; //este echo se retorna al archivo JS mediante el response de la peticion
        exit();
    }

    //comprobando formato
    if(VerifyData("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}",$name))
    {
        echo '
            <div class="notification is-danger">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                Formato de nombre incorrecto
            </div>
            ';
        exit();
    }
    
    if(VerifyData("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}",$lastName))
    {
        echo '
            <div class="notification is-danger">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                Formato de apellido incorrecto
            </div>
            ';
        exit();
    } 

    if(VerifyData("[a-zA-Z0-9]{4,20}",$user))
    {
        echo '
            <div class="notification is-danger">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                Formato de usuario incorrecto
            </div>
            ';
        exit();
    } 

    if(VerifyData("[a-zA-Z0-9$@.-]{7,100}",$pass)||VerifyData("[a-zA-Z0-9$@.-]{7,100}",$pass2))
    {
        echo '
            <div class="notification is-danger">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                Las claves no coinciden con el formato solicitado
            </div>
            ';
        exit();
    } 

    if($email!=""){
        //si es valido
        if(filter_var($email,FILTER_VALIDATE_EMAIL)){
            //si existe en base de datos
            $checkEmailbd=Conection();
            $responseBD=$checkEmailbd->query("SELECT email FROM users WHERE email='$email'");
            if($responseBD->rowCount()>0){
                echo '
                    <div class="notification is-danger">
                        <strong>¡Ocurrio un error inesperado!</strong><br>
                        El correo electronico existe ya en el sistema
                    </div>
                    ';
                exit();
            }
            $checkEmailbd=null;//cerrando conexion
        }else{
            echo '
                <div class="notification is-danger">
                    <strong>¡Ocurrio un error inesperado!</strong><br>
                    El correo electronico no es valido
                </div>
                ';
            exit();
        }
    }  

    //validando usuario en base de datos
    $checkUserbd=Conection();
    $responseBD=$checkUserbd->query("SELECT loginName FROM users WHERE loginName='$user'");
        if($responseBD->rowCount()>0){
            echo '
                <div class="notification is-danger">
                    <strong>¡Ocurrio un error inesperado!</strong><br>
                        El nombre de  usuario existe ya en el sistema
                </div>';
            exit();
        }
    $checkUserbd=null;//cerrando conexion


    //validando igualdad de claves
    if($pass!=$pass2){
            echo '
                <div class="notification is-danger">
                    <strong>¡Ocurrio un error inesperado!</strong><br>
                    Las claves no coinciden
                </div>
                ';
            exit();
    }else{
        $passEncripted=password_hash($pass,PASSWORD_BCRYPT,["cost"=>10]);
    }

    //GUARDANDO DATOS EN BASE DE DATOS USANDO MARCADORES
    $conection=Conection();
    $requestBD=$conection->prepare("INSERT INTO users(nameUser,lastnameUser,loginName,pass,email) VALUES(
                            :name,:lastName,:user,:passEncripted,:email)");
    $markers=[
        ":name"=>$name,
        ":lastName"=>$lastName,
        ":user"=>$user,
        ":passEncripted"=>$passEncripted,
        ":email"=>$email
    ];
    $requestBD->execute($markers);
    if($requestBD->rowCount()==1){
            echo '
                <div class="notification is-primary">
                    <strong>¡Registro Exitoso!</strong><br>
                    Usuario ingresado correctamente
                </div>
            ';
    }else{
            echo '
                <div class="notification is-danger">
                    <strong>¡Ocurrio un error inesperado!</strong><br>
                    No se pudo ingresar el registro
                </div>
            ';
    }
    $conection=null;
?>