<div class="container is-fluid mb-6">
    <h1 class="title has-text-centered">USUARIOS</h1>
    <h2 class="subtitle has-text-centered">LISTA DE USUARIOS</h2>
</div>

<div class="container pb-6 pt-6">

    <?php
        require_once "./php/main.php";

        //si en el get la pagina no esta definida entonces se le asigna el valor de 1
        if(!isset($_GET['page'])){
            $pagina=1;
        }else{
            $pagina=(int)$_GET['page'];//parseamos el valor de page que se pasa como string
            if($pagina<=1){
                $pagina=1;
            }
        } 
        $pagina=ClearData($pagina);
        $url="index.php?view=user_list&page=";
        $registers=15;//numero de regsitros a mostrar
        $search="";
        require_once "./php/user_list.php";

    ?>
</div>