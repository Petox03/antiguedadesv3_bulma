<?php
use Illuminate\Database\Capsule\Manager as DB;
require_once 'header.php';

$error = "";

if(!$loggedin)
{

    if (isset($_POST['user']))
    {
        $user = sanitizeString ($_POST['user']);
        $pass = sanitizeString($_POST['pass']);

        if($user == "" || $pass == "")
            $error = 'Falta algún dato';
        else
        {
            $result = DB::table('members')->select(['usuario', 'pass'])->where('usuario', $user)->where('pass', $pass)->first();

            if(!$result)
            {
                $error = "cuenta y/o contraseña inválida";
            }
            else
            {
                $_SESSION['user'] = $user;
                $_SESSION['pass'] = $pass;
                die("
                <div class='check'>
                    <meta http-equiv='Refresh' content='3;url=index.php'>
                    <h1 class='animate__animated animate__zoomIn animate__faster'>Haz iniciado sesión correctamente, serás redirigido en breve, sino<h1>
                    <a href='shop.php' class='linkC'><h1 class='animate__animated animate__zoomIn animate__faster'>haz click aquí</h1</a>
                </div>
                </div></body></html>");
            }
        }
    }

echo<<<_login
<div class="container is-fluid">

    <div class="columns accessform-container">
        <div class="column is-5 accessform animate__animated animate__zoomIn animate__faster">
            <h3 class="accessform-title">INICIA SESIÓN </h3>
            <h4 class="error animate__animated animate__shakeX animate__fast">$error</h4>
            <form action="login.php" method="POST">
                <div class="field">
                    <div class="form-group col-md-12">
                        <label class="label ml-1" for="usuario">Usuario</label>
                        <input type="text" class="input" name="user" id="usuario" aria-describedby="usuario"
                            placeholder="Usuario" required>
                    </div>
                    <div class="form-group col-md-12">
                        <label class="label ml-1" for="contraseña">Contraseña</label>
                        <input type="password" class="input" name="pass" id="contraseña" placeholder="Contraseña"
                            required>
                    </div>
                </div>
                <button type="submit" class="button btn-color">Iniciar sesión</button>
            </form>
        </div>
    </div>

</div>

</body>
_login;

}

?>

</html>