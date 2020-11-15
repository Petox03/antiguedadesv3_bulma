<?php
use Illuminate\Database\Capsule\Manager as DB;
require_once 'header.php';
if (!$loggedin) die("<meta http-equiv='Refresh' content='0;url=index.php'></div></body></html>");

$sql = DB::table('members')->where('usuario', $user)->first();
$saldo = $sql->money;

if(isset($_GET['idcompra']))
{
    $idc = $_GET['idcompra'];
    $cantidad = $_GET['cantidad'];

    $sql2 = DB::table('productos')->where('idproducto', $idc)->first();

    $stock = $sql2->stock;

    if($stock > $cantidad)
    {
        if($saldo >= $sql2->precio * $cantidad)
        {
            if($cantidad > 0)
            {
                $precio = $sql2->precio * $cantidad;
                $compra = '<h1 class="check">GRACIAS POR SU COMPRA!</h1>
                            <meta http-equiv="Refresh" content="3;url=shop.php">';
                $saldo -= $precio;
                $stock = $sql2->stock;
                $newstock = $stock - $cantidad;
                $venta = DB::table('productos')
                    ->where('idproducto', $idc)
                    ->update(['stock' => $newstock]);
                if($venta)
                {
                    $hoy = date("Y/m/d");
                    DB::table('pedidos')->insertGetId(
                        ['members_idmembers' => $id_miembro, 'fecha'=> $hoy]
                    );
                    $id_pedido = DB::table('pedidos')->max('idpedido');
                    DB::table('productos_pedidos')->insert(
                        ['pedidos_idpedido'=>$id_pedido, 'productos_idproductos'=>$idc, 'cantidad'=>$cantidad]
                    );
                }
            }
            else
            {
                die("<meta http-equiv='Refresh' content='3;url=shop.php'><h1 class='error center'>NO SELECCIONASTE UNA CANTIDAD VÁLIDA</h1>");
            }
        }
        else
        {
            $compra = "<h1 class='error center'>USTED NO CUENTA CON EL SALDO SUFICIENTE</h1>
                        <meta http-equiv='Refresh' content='3;url=shop.php'>";
        }
    }
    else
    {
        $compra = "<h1 class='error center'>NO HAY PRODUCTOS DISPONIBLES</h1>
        <meta http-equiv='Refresh' content='3;url=shop.php'>";
    }

    echo'
    <div class="container is-fluid">';

    echo'<h3>Saldo: <span class="money" style="display:inline-block;"><h3>' . $saldo . '</h3></span>$</h3>
    <div class="container-fluid">
        '.$compra.'
    </div>';

    DB::table('members')
        ->where('usuario', $user)
        ->update(['money' => $saldo]);
}
else{
    die("<meta http-equiv='Refresh' content='3;url=shop.php'><h1 class='error center'>NO SELECCIONASTE UN PRODUCTO</h1>");
}

?>