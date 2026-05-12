<?php
	/*== Almacenando datos ==*/
    $usuario=limpiar_cadena($_POST['login_usuario']);
    $clave=limpiar_cadena($_POST['login_clave']);


    /*== Verificando campos obligatorios ==*/
    if($usuario=="" || $clave==""){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                No has llenado todos los campos que son obligatorios
            </div>
        ';
        exit();
    }


    /*== Verificando integridad de los datos ==*/
    if(verificar_datos("[a-zA-Z0-9]{4,20}",$usuario)){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                El USUARIO no coincide con el formato solicitado
            </div>
        ';
        exit();
    }

    if(verificar_datos("[a-zA-Z0-9$@.-]{7,100}",$clave)){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                Las CLAVE no coinciden con el formato solicitado
            </div>
        ';
        exit();
    }


    $check_user=conexion();
    $check_user=$check_user->query("SELECT * FROM users WHERE loginName='$usuario'");
    if($check_user->rowCount()==1){

    	$check_user=$check_user->fetch();

    	if(password_verify($clave, $check_user['pass'])){

    		$_SESSION['id']=$check_user['id'];
    		$_SESSION['nombre']=$check_user['nameUser'];
    		$_SESSION['usuario']=$check_user['loginName'];
           $_SESSION['apellido']=$check_user['lastnameUser'];

    		if(headers_sent()){
				echo "<script> window.location.href='index.php?vista=home'; </script>";
			}else{
				header("Location: index.php?vista=home");
			}

    	}else{
    		echo '
	            <div class="notification is-danger is-light">
	                <strong>¡Ocurrio un error inesperado!</strong><br>
	                Clave Incorrecta
	            </div>
	        ';
    	}
    }else{
    	echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                Usuario  incorrecto
            </div>
        ';
    }
    $check_user=null;