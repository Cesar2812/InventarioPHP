<?php
    require "./inc/session_start.php";//incia sesion al entrar al sistema importando el session start
?>

<!DOCTYPE html>
<html lang="es">
<head>

    <?php
        include_once "./inc/head.php";//cabecera del diseno 
    ?>

</head>

<body>

    <?php
        //si el get de la vista no esta definido, el router carga el login por defult osea cuando entre al sistema 
        if(!isset($_GET['view'])|| $_GET['view']=="" ){
            $_GET['view']="login";
        } 

        if(is_file("./views/".$_GET['view'].".php")&&  $_GET['view']!="login" && $_GET['view']!="404" ){
            
            //cerrie de sesion forzado si no se ha logueado el usuario
            //si la variable de sesion no esta definida
            if(!isset($_SESSION['id'])||$_SESSION['id']==""){
                include_once "./views/login.php";
                exit();
            }
            include_once "./inc/nav.php";
            include_once "./views/".$_GET['view'].".php";
            echo "<br><br>";
            
            include_once "./inc/script.php";
        }else{
            if( $_GET['view']=="login"){
                include_once "./views/login.php";
            }else{
                include_once "./views/404.php";
            }
        }


        include_once "./inc/footer.php";
    ?>
    
</body>
</html>