<?php
    $user=ClearData($_POST['login_user']);
    $pass=ClearData($_POST['login_pass']);

    if($user==""||$pass==""){
        echo '
            <div class="notification is-danger">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                No has llenado todos los campos que son obligatorios
            </div>
            '; 
        exit();
    }  

    if(VerifyData("[a-zA-Z0-9]{4,20}",$user))
    {
        echo '
            <div class="notification is-danger">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                Formato de nombre de usuario incorrecto
            </div>
            ';
        exit();
    } 

    
    if(VerifyData("[a-zA-Z0-9$@.-]{7,100}",$pass))
    {
        echo '
            <div class="notification is-danger">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                Formato de clave de usuario incorrecto
            </div>
            ';
        exit();
    } 


    $conection=Conection();
    $responseDB=$conection->query("SELECT * FROM users WHERE loginName='$user'");
    if($responseDB->rowCount()==1){
        $data=$responseDB->fetch();//realizando un array de datos del usuario encontrado

        if($data['loginName']==$user && password_verify($pass,$data['pass'])){

            $_SESSION['id']=$data['id'];
            $_SESSION['Name']=$data['nameUser'];
            $_SESSION['lastName']=$data['lastnameUser'];
            $_SESSION['User']=$data['loginnameUser'];

            if(headers_sent()){
                echo "<script>
                    window.location.href='index.php?view=home';
                </script>";

            }else{
                header("Location: index.php?view=home");
            }

        }else{
            echo '
                <div class="notification is-danger">
                    <strong>¡Ocurrio un error inesperado!</strong><br>
                    Usuario o claves incorrectos
                </div>
            ';
        }

    }else{
        echo '
            <div class="notification is-danger">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                Usuario o claves incorrectos
            </div>
        ';
    }
    $conection=null;
?>