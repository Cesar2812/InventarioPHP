<div class="main-container">
    <form class="box login" action="" method="POST" autocomplete="off">

        <h5 class="title is-5 has-text-centered is-uppercase">SISTEMA DE INVENTARIO</h5>

        <div class="field">
            <label class="label">Usuario</label>
            <div class="control">
                <input class="input" type="text" name="login_user" required>
            </div>
        </div>

        <div class="field">
            <label class="label">Clave</label>
            <div class="control">
                <input class="input" type="password" name="login_pass" patern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100" required>
            </div>
        </div> 

        <p class="has-text-centered mb-4 mt-3">
            <button type="subtmit" class="button is-info is-rounded">INICIAR SESION</button>
        </p>
    </form>
</div>