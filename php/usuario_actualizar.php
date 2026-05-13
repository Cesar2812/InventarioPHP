<?php
	require_once "../inc/session_start.php";

	require_once "main.php";

    /*== Almacenando id ==*/
    $id=limpiar_cadena($_POST['usuario_id']);

    /*== Verificando usuario ==*/
	$check_usuario=conexion();
	$check_usuario=$check_usuario->query("SELECT * FROM users WHERE id='$id'");

    if($check_usuario->rowCount()<=0){
    	echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                El usuario no existe en el sistema
            </div>
        ';
        exit();
    }else{
    	$datos=$check_usuario->fetch();
    }
    $check_usuario=null;  






    if($id==$_SESSION['id']){

        $usuario=limpiar_cadena($_POST['usuario_usuario']);
        $email=limpiar_cadena($_POST['usuario_email']); 

        $clave_1=limpiar_cadena($_POST['usuario_clave_1']);
        $clave_2=limpiar_cadena($_POST['usuario_clave_2']);

        if(verificar_datos("[a-zA-Z0-9]{4,20}",$usuario)){
            echo '
                <div class="notification is-danger is-light">
                    <strong>¡Ocurrio un error inesperado!</strong><br>
                    El USUARIO no coincide con el formato solicitado
                </div>
            ';
            exit();
        }

        /*== Verificando email ==*/
        if($email!="" && $email!=$datos['email']){
            if(filter_var($email, FILTER_VALIDATE_EMAIL)){
                $check_email=conexion();
                $check_email=$check_email->query("SELECT email FROM users WHERE email='$email'");
                if($check_email->rowCount()>0){
                    echo '
                        <div class="notification is-danger is-light">
                            <strong>¡Ocurrio un error inesperado!</strong><br>
                            El correo electrónico ingresado ya se encuentra registrado, por favor elija otro
                        </div>
                    ';
                    exit();
                }
                $check_email=null;
            }else{
                echo '
                    <div class="notification is-danger is-light">
                        <strong>¡Ocurrio un error inesperado!</strong><br>
                        Ha ingresado un correo electrónico no valido
                    </div>
                ';
                exit();
            } 
        } 

        /*== Verificando usuario ==*/
            if($usuario!=$datos['loginName']){
                $check_usuario=conexion();
                $check_usuario=$check_usuario->query("SELECT loginName FROM users WHERE loginName='$usuario'");
                if($check_usuario->rowCount()>0){
                    echo '
                        <div class="notification is-danger is-light">
                            <strong>¡Ocurrio un error inesperado!</strong><br>
                            El USUARIO ingresado ya se encuentra registrado, por favor elija otro
                        </div>
                    ';
                    exit();
                }
                $check_usuario=null;
            } 


            /*== Verificando campos obligatorios del usuario ==*/
            if($usuario=="" || $email==""){
                echo '
                    <div class="notification is-danger is-light">
                        <strong>¡Ocurrio un error inesperado!</strong><br>
                        No has llenado todos los campos que son obligatorios
                    </div>
                ';
                exit();
            } 

        /*== Verificando claves ==*/
        //si son vacios los iputs entran al sino
        if($clave_1!="" || $clave_2!=""){
            if(verificar_datos("[a-zA-Z0-9$@.-]{7,100}",$clave_1) || verificar_datos("[a-zA-Z0-9$@.-]{7,100}",$clave_2)){
                echo '
                    <div class="notification is-danger is-light">
                        <strong>¡Ocurrio un error inesperado!</strong><br>
                        Las CLAVES no coinciden con el formato solicitado
                    </div>
                ';
                exit();
            }else{
                if($clave_1!=$clave_2){
                    echo '
                        <div class="notification is-danger is-light">
                            <strong>¡Ocurrio un error inesperado!</strong><br>
                            Las CLAVES que ha ingresado no coinciden
                        </div>
                    ';
                    exit();
                }else{
                    $clave=password_hash($clave_1,PASSWORD_BCRYPT,["cost"=>10]);
                }
            }
        }else{
            $clave=$datos['pass'];//la clave se mantiene igual que es la misma de la base de datos
        }  

        /*== Actualizar datos ==*/
        $actualizar_usuario=conexion();
        $actualizar_usuario=$actualizar_usuario->prepare("UPDATE users SET loginName=:usuario,pass=:clave,email=:email WHERE id=:id");

        $marcadores=[
            ":usuario"=>$usuario,
            ":clave"=>$clave,
            ":email"=>$email,
            ":id"=>$id
        ];

        if($actualizar_usuario->execute($marcadores)){
            echo '
                <div class="notification is-primary is-light">
                    <strong>¡USUARIO ACTUALIZADO!</strong><br>
                    El usuario se actualizo con exito
                </div>
            ';
        }else{
            echo '
                <div class="notification is-danger is-light">
                    <strong>¡Ocurrio un error inesperado!</strong><br>
                    No se pudo actualizar el usuario, por favor intente nuevamente
                </div>
            ';
        }
        $actualizar_usuario=null;

    }else{ 

        /*== Almacenando datos del administrador ==*/
        $admin_usuario=limpiar_cadena($_POST['administrador_usuario']);
        $admin_clave=limpiar_cadena($_POST['administrador_clave']); 

        $clave_1=limpiar_cadena($_POST['usuario_clave_1']);
        $clave_2=limpiar_cadena($_POST['usuario_clave_2']); 




        /*== Verificando campos obligatorios del administrador ==*/
        if($admin_usuario=="" || $admin_clave==""){
            echo '
                <div class="notification is-danger is-light">
                    <strong>¡Ocurrio un error inesperado!</strong><br>
                    No ha llenado los campos que corresponden a su USUARIO o CLAVE
                </div>
            ';
            exit();
        }

        /*== Verificando integridad de los datos (admin) ==*/
        if(verificar_datos("[a-zA-Z0-9]{4,20}",$admin_usuario)){
            echo '
                <div class="notification is-danger is-light">
                    <strong>¡Ocurrio un error inesperado!</strong><br>
                    Su USUARIO no coincide con el formato solicitado
                </div>
            ';
            exit();
        }

        if(verificar_datos("[a-zA-Z0-9$@.-]{7,100}",$admin_clave)){
            echo '
                <div class="notification is-danger is-light">
                    <strong>¡Ocurrio un error inesperado!</strong><br>
                    Su CLAVE no coincide con el formato solicitado
                </div>
            ';
            exit();
        }  
        
        


        /*== Verificando el administrador en DB ==*/
        $check_admin=conexion();
        $check_admin=$check_admin->query("SELECT loginName,pass FROM users WHERE loginName='$admin_usuario'");
        if($check_admin->rowCount()==1){

            $check_admin=$check_admin->fetch();

            if(!password_verify($admin_clave, $check_admin['pass'])){
                echo '
                    <div class="notification is-danger is-light">
                        <strong>¡Ocurrio un error inesperado!</strong><br>
                        Clave Incorrecta
                    </div>
                ';
                exit();
            }

        }else{
            echo '
                <div class="notification is-danger is-light">
                    <strong>¡Ocurrio un error inesperado!</strong><br>
                    Usuario Incorrecto
                </div>
            ';
            exit();
        }
        $check_admin=null; 

        /*== Verificando claves ==*/
        if($clave_1!="" || $clave_2!=""){
            if(verificar_datos("[a-zA-Z0-9$@.-]{7,100}",$clave_1) || verificar_datos("[a-zA-Z0-9$@.-]{7,100}",$clave_2)){
                echo '
                    <div class="notification is-danger is-light">
                        <strong>¡Ocurrio un error inesperado!</strong><br>
                        Las CLAVES no coinciden con el formato solicitado
                    </div>
                ';
                exit();
            }else{
                if($clave_1!=$clave_2){
                    echo '
                        <div class="notification is-danger is-light">
                            <strong>¡Ocurrio un error inesperado!</strong><br>
                            Las CLAVES que ha ingresado no coinciden
                        </div>
                    ';
                    exit();
                }else{
                    $clave=password_hash($clave_1,PASSWORD_BCRYPT,["cost"=>10]);
                }
            }
        }else{
            $clave=$datos['pass'];
        } 


        /*== Actualizar datos ==*/
        $actualizar_usuario=conexion();
        $actualizar_usuario=$actualizar_usuario->prepare("UPDATE users SET pass=:clave WHERE id=:id");

        $marcadores=[
            ":clave"=>$clave,
            ":id"=>$id
        ];

        if($actualizar_usuario->execute($marcadores)){
            echo '
                <div class="notification is-primary is-light">
                    <strong>¡USUARIO ACTUALIZADO!</strong><br>
                    El usuario se actualizo con exito
                </div>
            ';
        }else{
            echo '
                <div class="notification is-danger is-light">
                    <strong>¡Ocurrio un error inesperado!</strong><br>
                    No se pudo actualizar el usuario, por favor intente nuevamente
                </div>
            ';
        }
        $actualizar_usuario=null;
    }