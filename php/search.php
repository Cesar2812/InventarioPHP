<?php
    $module_search=ClearData($_POST['modulo_buscador']); 

    $modules=["user","category","product"];

    //si el modulo esta en el array
    if(in_array($module_search,$modules)){

        $modules_urls=[
            "user"=> "user_search",
            "category" => "category_search",
            "product" => "product_search"
        ];

        $modules_urls=$modules_urls[$module_search];

        $module_search="search_".$module_search;
        
        //iniciar busqueda en la tabla
        if(isset($_POST['txt_buscador'])){
            $txt=ClearData($_POST['txt_buscador']);

            if($txt ==""){
                echo '
                    <div class="notification is-danger">
                        <strong>¡Ocurrio un error inesperado!</strong><br>
                        Introduzca un termino de busqueda
                    </div>
                ';
            }else{
                if(VerifyData("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{1,30}",$txt)){
                    echo '
                        <div class="notification is-danger">
                            <strong>¡Ocurrio un error inesperado!</strong><br>
                            El termino de Busqueda no coincide con el formato solicitado
                        </div>
                    ';
                }else{
                    $_SESSION[$module_search]=$txt;
                    header("Location: index.php?view=$modules_urls",true,303);
                    exit();
                }
            }
        }
        //eliminar busqueda
        if(isset($_POST['eliminar_buscador'])){
            unset($_SESSION[$module_search]);
            header("Location: index.php?view=$modules_urls",true,303);
            exit();
        }
    }else{
        echo '
            <div class="notification is-danger">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                No podemos procesar la busqueda
            </div>
        ';
    } 
?>