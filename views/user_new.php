    <div class="container is-fluid mb-6">
        <h1 class="title has-text-centered">GESTION DE USUARIOS</h1>
        <h2 class="subtitle has-text-centered">Nuevo usuario</h2>
    </div>

    <div class="container pb-6 pt-6">

        <div class="form-rest mb-6 mt-6">

        </div>

        <form action="./php/user_save.php" method="POST" class="FormAjax" autocomplete="off" >
            <div class="columns">
                <div class="column">
                    <div class="control">
                        <label>Nombres</label>
                        <input class="input" type="text" name="user_name" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}" maxlength="40" required >
                    </div>
                </div>
                <div class="column">
                    <div class="control">
                        <label>Apellidos</label>
                        <input class="input" type="text" name="user_last" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}" maxlength="40" required >
                    </div>
                </div>
            </div>
            <div class="columns">
                <div class="column">
                    <div class="control">
                        <label>Usuario</label>
                        <input class="input" type="text" name="user" pattern="[a-zA-Z0-9]{4,20}" maxlength="20" required >
                    </div>
                </div>
                <div class="column">
                    <div class="control">
                        <label>Email</label>
                        <input class="input" type="email" name="email" maxlength="70" required>
                    </div>
                </div>
            </div>
            <div class="columns">
                <div class="column">
                    <div class="control">
                        <label>Clave</label>
                        <input class="input" type="password" name="user_pass_1" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100" required >
                    </div>
                </div>
                <div class="column">
                    <div class="control">
                        <label>Repetir clave</label>
                        <input class="input" type="password" name="user_pass_2" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100" required >
                    </div>
                </div>
            </div>
            <p class="has-text-centered">
                <button type="submit" class="button is-link">Guardar</button>
            </p>
        </form>
    </div> 