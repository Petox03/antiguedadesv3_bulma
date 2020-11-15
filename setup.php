<!DOCTYPE html>
<html>
    <head>
        <title>Creando bases de datos</title>
    </head>
    <body>

        <h3>Configurando ...</h3>

<?php //Example 26-3: setup.php

    use Illuminate\Database\Capsule\Manager as DB;

    require_once 'functions.php';
    require "vendor/autoload.php";
    require "config/database.php";

    DB::schema()->create('members', function ($table) {
        $table->integer('idmembers')->autoIncrement();
        $table->string('usuario')->unique();
        $table->string('pass');
        $table->integer('money');
        $table->integer('idaccess');
    });

    DB::schema()->create('profiles', function ($table) {
        $table->foreignId('members_idmembers');
        $table->string('user')->unique();
        $table->text('text');
    });

    DB::schema()->create('productos', function ($table) {
        $table->integer('idproducto')->autoIncrement();
        $table->string('name');
        $table->float('precio');
        $table->integer('stock');
        $table->text('description');
        $table->text('detalles');
        $table->string('img');
    });

    DB::schema()->create('pedidos', function ($table) {
        $table->integer('idpedido')->autoIncrement();
        $table->foreignId('members_idmembers');
    });

    DB::schema()->create('pedidos_productos', function ($table) {
        $table->foreignId('pedidos_idpedido');
        $table->foreignId('productos_idproductos');
    });

    DB::table('members')->insertGetId(['user' => 'admin', 'pass' => '123', 'money'=>0, ' idaccess' => '1']);

    DB::table('productos')->insertGetId(['name'=>'Silla', 'precio'=>300, 'stock'=>5, 'description'=>'Silla antigüa en buen estado', 'detalles'=>'Silla del siglo XIII en muy buen estado', 'img'=>'silla.png']);
    DB::table('productos')->insertGetId(['name'=>'Objetos varios', 'precio'=>1000, 'stock'=>1, 'description'=>'Objetos del siglo XV, se vende todo junto', 'detalles'=>'Hay jarrones, un escritorio, lámparas, una maquina de escribir y una pintura', 'img'=>'anti.png']);
    DB::table('productos')->insertGetId(['name'=>'Sofa', 'precio'=>750, 'stock'=>3, 'description'=>'Sofá antiguo del siglo XIII restaurado', 'detalles'=>'Es un sofá de 2 x 1.5 metros', 'img'=>'sofa.png']);

?>

        <br>... listo!.
        <br>
        <meta http-equiv="Refresh" content="3;url=index.php">
    </body>
</html>