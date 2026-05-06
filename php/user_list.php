<?php
    $start=($pagina>0)?(($pagina*$registers)-$registers):0;//si no se empieza desde 0 osea el inicio sin paginado
    $table="";

    if(isset($search)&& $search!="")
    {
        $query="SELECT * FROM users  WHERE ((id!='".$_SESSION['id']."') AND (nameUser LIKE '%$search%' OR lastnameUser LIKE '%$search%' OR loginName LIKE '%$search%' OR email LIKE '%$search%' )) ORDER BY nameUser ASC LIMIT $start,$registers"; 

        $query_total="SELECT COUNT(id) FROM users  WHERE (( id!='".$_SESSION['id']."') AND (nameUser LIKE '%$search%' OR lastnameUser LIKE '%$search%' OR loginName LIKE '%$search%' OR email LIKE '%$search%' ))";

    }else{
        $query="SELECT * FROM users  WHERE id!='".$_SESSION['id']."' ORDER BY nameUser ASC LIMIT $start,$registers"; 

        $query_total="SELECT COUNT(id) FROM users  WHERE id!='".$_SESSION['id']."'";
    } 

    $conection=Conection();

    $data=$conection->query($query);
    $dataResponse=$data->fetchAll();

    $totalRegister=$conection->query($query_total);
    $totalRegisterResponse=(int) $totalRegister->fetchColumn();//devuelve una unica columna 

    $nPages=ceil($totalRegisterResponse/$registers);


    $table.='
        <div class="table-container">
        <table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
            <thead>
                <tr class="has-text-centered">
                    <th>#</th>
                    <th>Nombres</th>
                    <th>Apellidos</th>
                    <th>Usuario</th>
                    <th>Email</th>
                    <th colspan="2">Opciones</th>
                </tr>
            </thead>
        <tbody>
    ';
    if($totalRegisterResponse>=1 &&  $pagina<=$nPages){
        $contador=$start+1;
        $paginator_start=$start+1;
        foreach($dataResponse as $rows){
            $table.='
                <tr class="has-text-centered" >
					<td>'.$contador.'</td>
                    <td>'.$rows['nameUser'].'</td>
                    <td>'.$rows['lastnameUser'].'</td>
                    <td>'.$rows['loginName'].'</td>
                    <td>'.$rows['email'].'</td>
                    <td>
                        <a href="index.php?view=user_update&user_id_up='.$rows['id'].'" class="button is-success is-rounded is-small">Actualizar</a>
                    </td>
                    <td>
                        <a href="'.$url.$pagina.'&user_id_del='.$rows['id'].'" class="button is-danger is-rounded is-small">Eliminar</a>
                    </td>
                </tr>
            ';
            $contador++;

        }
        $paginator_end=$contador-1;

    }else{
        if($totalRegisterResponse>=1){
            $table.='
                <tr class="has-text-centered" >
                    <td colspan="7">
                        <a href="'.$url.'1" class="button is-link is-rounded is-small mt-4 mb-4">
                            Haga clic acá para recargar el listado
                        </a>
                    </td>
                </tr>
            
            ';
        }else{
            $table.='
                <tr class="has-text-centered" >
                    <td colspan="7">
                        No hay registros en el sistema
                    </td>
                </tr>
            ';

        }
    }
    $table.='</tbody></table></div>';

    if($totalRegisterResponse>=1 &&  $pagina<=$nPages){
        $table.='
        <p class="has-text-right">Mostrando usuarios <strong>'.$paginator_start.'</strong> al <strong>'.$paginator_end.'</strong> de un <strong>total de '.$totalRegisterResponse.'</strong></p>
        ';
    }
    $conection=null;

    echo $table;

    if($totalRegisterResponse>=1 && $pagina<=$nPages){
        echo PaginatorTables($pagina,$nPages,$url,7);
    }
?>