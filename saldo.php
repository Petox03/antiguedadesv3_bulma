<?php
use Illuminate\Database\Capsule\Manager as DB;
require_once 'header.php';
if (!$loggedin) die("<meta http-equiv='Refresh' content='0;url=index.php'></div></body></html>");

$sql = DB::table('members')->where('usuario', $user)->first();
$saldo = $sql->money;

$data = "";

if(isset($_POST['dinero']))
{
    $saldo += $_POST['dinero'];
    $sql = DB::table('members')
        ->where('usuario', $user)
        ->update(['money' => $saldo]);

    $data='
        <div class="center">
            <h2>
                Saldo añadido correctamente.
                <br>
                Saldo agregado:'.$_POST['dinero'].'
                <br>
                Su saldo actual es: '.$saldo.'
            </h2>
        </div>
    ';
}

echo "
        <div class='container is-fluid'>
            <h3 class='center'>Your Profile</h3>
            <h3 class='animate__animated animate__lightSpeedInLeft animate__fast'>Saldo: <span class='money' style='display:inline-block;'><h3>$saldo</h3></span>$</h3>";

showProfile($user);

echo <<<_END
            <form method='post' action='saldo.php' enctype='multipart/form-data'>
                <div class="field is-8">
                    <h3>Ingresa la cantidad a añadir</h3>
                    <input class="input" name="dinero" value="0" type="number" required>
                </div>
                <button type='submit' class='button btn-color ml-2'>Guardar</button>
            </form>
        </div><br>
        $data
    </body>
</html>
_END;
?>