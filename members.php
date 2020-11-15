<?php
  use Illuminate\Database\Capsule\Manager as DB;
  require_once 'header.php';

  if (!$loggedin) die("<meta http-equiv='Refresh' content='0;url=index.php'></div</body></html>");

  if (isset($_GET['view']))
  {
    $sql = DB::table('members')->where('usuario', $user)->first();

    $saldo = $sql->money;

    $data = "";

    if($id == 1)
    {
      $data = "<a href='#' type='button' class='button btn-color'>añadir producto</a>";
    }

    $view = sanitizeString($_GET['view']);

    if ($view != $user) $name = "Your";
    else                $name = "$view's";

    echo"<div class='container is-fluid'>
      <h3 class='animate__animated animate__lightSpeedInLeft animate__fast'>Saldo: <span class='money' style='display:inline-block;'><h3>$saldo</h3></span>$</h3>
      <h3 class='center'>$name Profile</h3>";
    showProfile($view);
    echo "
      <a href='profile.php' type='button' class='button btn-color'>Editar perfil</a>
      <a href='saldo.php' type='button' class='button btn-color'>añadir saldo</a>
      ".$data."
    </div>";
    die("</div></body></html>");
  }
?>