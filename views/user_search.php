<div class="container is-fluid mb-6">

    <h1 class="title has-text-centered">USUARIOS</h1>
    <h2 class="subtitle has-text-centered">BUSCAR USUARIO</h2>
</div>

<div class="container pb-6 pt-6">
    <?php
        require_once "./php/main.php";
        
        if(isset($_POST['modulo_buscador'])){
            require_once './php/search.php';

        }

        if(!isset($_SESSION['search_user']) && empty($_SESSION['search_user'])){
    ?>
    <div class="columns">
        <div class="column">
            <form action="" method="POST" autocomplete="off" >
                <input type="hidden" name="modulo_buscador" value="user">   
                <div class="field is-grouped">
                    <p class="control is-expanded">
                        <input class="input is-rounded" type="text" name="txt_buscador" placeholder="¿Qué estas buscando?" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{1,30}" maxlength="30" >
                    </p>
                    <p class="control">
                        <button class="button is-info" type="submit" >Buscar</button>
                    </p>
                </div>
            </form>
        </div>
    </div>
    <?php
        }else{
    ?>
    <div class="columns">
        <div class="column">
            <form class="has-text-centered mt-6 mb-6" action="" method="POST" autocomplete="off" >
                <input type="hidden" name="modulo_buscador" value="user"> 
                <input type="hidden" name="eliminar_buscador" value="user">
                <p>Estas buscando <strong><?php echo $_SESSION['search_user']?></strong></p>
                <br>
                <button type="submit" class="button is-danger is-rounded">Eliminar busqueda</button>
            </form>
        </div>
    </div>
    <?php
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
        $url="index.php?view=user_search&page=";
        $registers=15;//numero de regsitros a mostrar
        $search=$_SESSION['search_user'];
        require_once "./php/user_list.php";
        }
    ?>
</div>