<?php
	require_once "./php/main.php";

    $id = (isset($_GET['user_id_up'])) ? $_GET['user_id_up'] : 0;
    $id=limpiar_cadena($id);//viene del paginador
?>
<div class="container is-fluid mb-6">
		<?php if($id==$_SESSION['id']){ ?>
			<h1 class="title has-text-centered">Mi cuenta</h1>
			<h2 class="subtitle has-text-centered">Actualizar datos de cuenta</h2>
		<?php }else{ ?>
			<h1 class="title has-text-centered">USUARIOS</h1>
			<h2 class="subtitle has-text-centered">ACTUALIZAR USUARIO</h2>
		<?php } ?>
</div>

<div class="container pb-6 pt-6">
	<?php

		include "./inc/btn_back.php";

        /*== Verificando usuario ==*/
    	$check_usuario=conexion();
    	$check_usuario=$check_usuario->query("SELECT * FROM users WHERE id='$id'");

        if($check_usuario->rowCount()>0){
        	$datos=$check_usuario->fetch();//obtiene al usuario de la base de datos que se va a editar
	?>

	<div class="form-rest mb-6 mt-6"></div>

	<form action="./php/usuario_actualizar.php" method="POST" class="FormularioAjax" autocomplete="off" >

		<input type="hidden" name="usuario_id" value="<?php echo $datos['id']; ?>" required >
		
		<div class="columns">

				<div class="column">
					<div class="control">
						<label>Nombres</label>
						<input class="input" type="text" name="usuario_nombre" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}" maxlength="40" required value="<?php echo $datos['nameUser'];?>" disabled >
					</div>
				</div>

				<div class="column">
					<div class="control">
						<label>Apellidos</label>
						<input class="input" type="text" name="usuario_apellido" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}" maxlength="40" required value="<?php echo $datos['lastnameUser']; ?>" disabled >
					</div>
				</div>
			
		</div>

		<?php
			if($id==$_SESSION['id']){
		?>

		<div class="columns">

				<div class="column">
					<div class="control">
						<label>Usuario</label>
						<input class="input" type="text" name="usuario_usuario" pattern="[a-zA-Z0-9]{4,20}" maxlength="20" required value="<?php echo $datos['loginName']; ?>">
					</div>
				</div>

				<div class="column">
					<div class="control">
						<label>Email</label>
						<input class="input" type="email" name="usuario_email" maxlength="70" value="<?php echo $datos['email']; ?>">
					</div>
				</div>
		</div>

		<?php
			}else{
		?>
		<div class="columns">

				<div class="column">
					<div class="control">
						<label>Usuario</label>
						<input class="input" type="text" name="usuario_usuario" pattern="[a-zA-Z0-9]{4,20}" maxlength="20" required value="<?php echo $datos['loginName']; ?>" disabled>
					</div>
				</div>

				<div class="column">
					<div class="control">
						<label>Email</label>
						<input class="input" type="email" name="usuario_email" maxlength="70" value="<?php echo $datos['email']; ?>" disabled>
					</div>
				</div>
		</div> 

		<?php
			}
		?>

		<br><br> 

		<?php
			if($id==$_SESSION['id']){
		?>

		<p class="has-text-centered">
			Cambiar Clave del usuario Opcional
		</p>

		<br>
		<div class="columns">

				<div class="column">
					<div class="control">
						<label>Clave</label>
						<input class="input" type="password" name="usuario_clave_1" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100">
					</div>
				</div>

				<div class="column">
					<div class="control">
						<label>Repetir clave</label>
						<input class="input" type="password" name="usuario_clave_2" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100">
					</div>
				</div>
		</div> 

		<?php
			}else{
		?>

		<p class="has-text-centered">
			Cambiar Clave del usuario
		</p>

		<br>

		<div class="columns">
				<div class="column">
					<div class="control">
						<label>Clave</label>
						<input class="input" type="password" name="usuario_clave_1" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100" required>
					</div>
				</div>

				<div class="column">
					<div class="control">
						<label>Repetir clave</label>
						<input class="input" type="password" name="usuario_clave_2" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100" required>
					</div>
				</div>

		</div> 
		<br><br><br>

			<p class="has-text-centered">
			Para poder camiar la clave de este usuario por favor ingrese su USUARIO y CLAVE con la que ha iniciado sesión
		</p>

		<div class="columns">
				<div class="column">
					<div class="control">
						<label>Usuario</label>
						<input class="input" type="text" name="administrador_usuario" pattern="[a-zA-Z0-9]{4,20}" maxlength="20" required >
					</div>
				</div>
				<div class="column">
						<div class="control">
							<label>Clave</label>
							<input class="input" type="password" name="administrador_clave" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100" required >
						</div>
				</div>
		</div> 
		
		<?php
			}
		?>
		<p class="has-text-centered">
			<button type="submit" class="button is-success is-rounded">Actualizar</button>
		</p>

	</form>

	<?php 
		}else{
			include "./inc/error_alert.php";
		}
		$check_usuario=null;
	?>

</div>