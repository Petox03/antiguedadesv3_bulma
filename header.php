<?php
@ob_start();
session_start();
use Illuminate\Database\Capsule\Manager as DB;


require_once 'functions.php';
$userstr = 'Welcome Guest';
if (isset($_SESSION['user'])) {
    $user     = $_SESSION['user'];
    $loggedin = TRUE;
    $userstr  = "Sesión: $user";
    $datos = DB::table('members')->select(['idaccess', 'idmembers'])->where('usuario', $user)->first();
    $id = $datos->idaccess;
    $id_miembro = $datos->idmembers;
}
else $loggedin = FALSE;

echo <<<_INIT
<!DOCTYPE html>
<html>
    <head>
        <link rel='shortcut icon' href='images/logo.png'>
        <meta charset='utf-8'>
        <meta name='viewport' content='width=device-width,
        initial-scale=1'>
        <script src='node_modules/jquery/dist/jquery.min.js'></script>
        <script type="text/javascript" src="js/javascript.js"></script>
        <link href="node_modules/animate.css/animate.min.css" rel="stylesheet">
        <link href="node_modules/bulma/css/bulma.css" rel="stylesheet">
        <link rel='stylesheet' href='css/styles.css' type='text/css'>
        <title>Tienda. $userstr</title>
    </head>
    <body class='is-unselectable'>
_INIT;

if ($loggedin) {
echo <<<_LOGGEDIN
    <nav class="navbar bg-dark" role="navigation" aria-label="main navigation">
        <img src='images/logo.png' class="mt-2 ml-2 mb-2" id='icon'>
        <div class="navbar-brand">
            <a role="button" class="navbar-burger burger" aria-label="menu" aria-expanded="false" data-target="navbarBasicExample">
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
            </a>
        </div>
        <div id="navbarBasicExample" class="navbar-menu">
            <div class="navbar-start a">
                <a class="navbar-item a" href='shop.php'>
                    Tienda
                </a>
                <a class="navbar-item a" href='members.php?view=$user'>
                    Perfil
                </a>
                <a class="navbar-item a" href='logout.php'>
                    Salir
                </a>
            </ul>
        </div>
    </nav>
_LOGGEDIN;
    }
else {
echo <<<_GUEST
    <nav class="navbar bg-dark" role="navigation" aria-label="main navigation">
        <img src='images/logo.png' class="mt-2 ml-2 mb-2" id='icon'>
        <div class="navbar-brand">
            <a role="button" class="navbar-burger burger" aria-label="menu" aria-expanded="false" data-target="navbarBasicExample">
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
            </a>
        </div>
        <div id="navbarBasicExample" class="navbar-menu">
            <div class="navbar-start a">
                <a class="navbar-item a" href='shop.php'>
                    Inicio
                </a>
                <a class="navbar-item a" href='login.php'>
                    Iniciar sesión
                </a>
                <a class="navbar-item a" href='singup.php'>
                    Regístrate
                </a>
            </ul>
        </div>
    </nav>
    _GUEST;
}
echo <<<_MAIN
        <div data-role='page' class='mb-3'>
            <div data-role='header'>
                <div class= 'username'>$userstr</div>
            </div>
        </div>
    _MAIN;
if(!$loggedin)
{
    echo"
    <p class='info'>(Debes tener una cuenta para usar esta app)</p>
    ";
}

?>