<?php require "./inc/session_start.php"; ?>
<!DOCTYPE html>
<html>

    <head>
        <?php include "./inc/head.php"; ?>
    </head>

    <body>
        <?php

            //si el get de la vista no existe al iniciar el servidor, se le asigna el valor del login 
            if(!isset($_GET['vista']) || $_GET['vista']==""){
                $_GET['vista']="login";// se crea el get con el valor o nombre de la vista a cargar login
            }


            if(is_file("./vistas/".$_GET['vista'].".php") && $_GET['vista']!="login" && $_GET['vista']!="404"){

                /*== Cerrar sesion ==*/
                if((!isset($_SESSION['id']) || $_SESSION['id']=="") || (!isset($_SESSION['usuario']) || $_SESSION['usuario']=="")){
                    include "./vistas/logout.php";
                    exit();
                } 

                include "./inc/navbar.php";

                include "./vistas/".$_GET['vista'].".php";

                

                include "./inc/script.php";

            }else{
                if($_GET['vista']=="login"){
                    include "./vistas/login.php";
                }else{
                    include "./vistas/404.php";
                }
            }
            require_once "./inc/footer.php";
        ?>
        
    </body>
</html>