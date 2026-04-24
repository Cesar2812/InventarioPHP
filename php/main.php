<?php
    //funciones que se van a utilizar en todo el sistema

    //coneccion a la base de datos
    function Conection(){
        $pdo=new PDO('mysql:host=localhost;dbname=inventory','root','adminroot');
        return $pdo;
    } 

    //verificar datos con formato correcto
    function VerifyData($filter,$data){
        if(preg_match("/^".$filter."$/",$data)){
            return false;//no hay error
        }else{
            return true;//true si hay error
        }
    } 

    //funcion para limpiar cadenas de texto y evitar sqlIjection
    function ClearData($data){
        $data=trim($data);//limpiando espcacios en blanco
        $data=stripslashes($data);//quitando barras o comillas escapadas 
        $data=str_ireplace("<script>","",$data);//reemplaza codigo js en php
        $data=str_ireplace("</script>","",$data);
        $data=str_ireplace("<script src>","",$data);
        $data=str_ireplace("<script type=","",$data);
        $data=str_ireplace("SELECT * FROM", "", $data);
		$data=str_ireplace("DELETE FROM", "", $data);
		$data=str_ireplace("INSERT INTO", "", $data);
		$data=str_ireplace("DROP TABLE", "", $data);
		$data=str_ireplace("DROP DATABASE", "", $data);
		$data=str_ireplace("TRUNCATE TABLE", "", $data);
		$data=str_ireplace("SHOW TABLES;", "", $data);
		$data=str_ireplace("SHOW DATABASES;", "", $data);
		$data=str_ireplace("<?php", "", $data);
		$data=str_ireplace("?>", "", $data);
		$data=str_ireplace("--", "", $data);
		$data=str_ireplace("^", "", $data);
		$data=str_ireplace("<", "", $data);
		$data=str_ireplace("[", "", $data);
		$data=str_ireplace("]", "", $data);
		$data=str_ireplace("==", "", $data);
		$data=str_ireplace(";", "", $data);
		$data=str_ireplace("::", "", $data);
		$data=trim($data);
		$data=stripslashes($data);
		return $data;
    }


    # Funcion renombrar fotos #
	function RenamePhoto($name){
		$name=str_ireplace(" ", "_", $name);
		$name=str_ireplace("/", "_", $name);
		$name=str_ireplace("#", "_", $name);
		$name=str_ireplace("-", "_", $name);
		$name=str_ireplace("$", "_", $name);
		$name=str_ireplace(".", "_", $name);
		$name=str_ireplace(",", "_", $name);
		$name=$name."_".rand(0,100);
		return $nombre;
	} 


	//paginadores de tablas 
	function PaginatorTables($page,$Npages,$url,$botons){
		$table='<nav class="pagination is-centered is-rounded" role="navigation" aria-label="pagination">';

		if($page<=1){
			$table.='
			<a class="pagination-previous is-disabled" disabled >Anterior</a>
			<ul class="pagination-list">';
		}else{
			$table.='
			<a class="pagination-previous" href="'.$url.($page-1).'" >Anterior</a>
			<ul class="pagination-list">
				<li><a class="pagination-link" href="'.$url.'1">1</a></li>
				<li><span class="pagination-ellipsis">&hellip;</span></li>
			';
		}

		$ci=0;
		for($i=$page; $i<=$Npages; $i++){
			if($ci>=$botons){
				break;
			}
			if($page==$i){
				$table.='<li><a class="pagination-link is-current" href="'.$url.$i.'">'.$i.'</a></li>';
			}else{
				$table.='<li><a class="pagination-link" href="'.$url.$i.'">'.$i.'</a></li>';
			}
			$ci++;
		}

		if($page==$Npages){
			$table.='
			</ul>
			<a class="pagination-next is-disabled" disabled >Siguiente</a>
			';
		}else{
			$table.='
				<li><span class="pagination-ellipsis">&hellip;</span></li>
				<li><a class="pagination-link" href="'.$url.$Npages.'">'.$Npages.'</a></li>
			</ul>
			<a class="pagination-next" href="'.$url.($page+1).'" >Siguiente</a>
			';
		}

		$table.='</nav>';
		return $table;
	}
?>