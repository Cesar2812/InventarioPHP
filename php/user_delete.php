<?php
    $userDelete=ClearData($_GET['user_id_del']);

    //verificando el usuario en la base de datos
    $checkUser=Conection();
    
    $requestDataBase=$checkUser->query("SELECT id FROM users WHERE id='$userDelete'");  






?>