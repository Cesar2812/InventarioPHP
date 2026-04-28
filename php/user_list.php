<?php
    $start=($pagina>0)?(($pagina*$registers)-$registers):0;//si no se empieza desde 0

    $table="";

    if(isset($search)&& $search!="")
    {
        $query="SELECT * FROM users  WHERE ((id!='".$_SESSION['id']."') AND (nameUser LIKE '%$search%' OR lastnameUser LIKE '%$search%' OR loginName LIKE '%$search%' OR email LIKE '%$search%' )) ORDER BY nameUser ASC LIMIT $start,$registers"; 

        $query_total="SELECT COUNT(id) FROM users  WHERE (( id!='".$_SESSION['id']."') AND (nameUser LIKE '%$search%' OR lastnameUser LIKE '%$search%' OR loginName LIKE '%$search%' OR email LIKE '%$search%' ))";

    }else{
        $query="SELECT * FROM users  WHERE id!='".$_SESSION['id']."' ORDER BY nameUser ASC LIMIT $start,$registers "; 

        $query_total="SELECT COUNT(id) FROM users  WHERE id!='".$_SESSION['id']."'";
    } 

    $conection=Conection();
    




?>