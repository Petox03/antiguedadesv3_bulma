<?php
    use Illuminate\Database\Capsule\Manager as DB;
    require_once 'header.php';

    if($loggedin)
    {
      //consulta de members
      $sql = DB::table('members')->where('usuario', $user)->first();

      $saldo = $sql->money;

    }
    //consulta de productos
    $sql2 = DB::table('productos')->where('idproducto', $_GET['id'])->first();

    echo'
      <div class="container is-fluid">';

        if($loggedin)
        {
          echo'<h3 class="animate__animated animate__lightSpeedInLeft animate__fast">Saldo: <span class="money" style="display:inline-block;"><h3>' . $saldo . '</h3></span>$</h3>';
        }

    echo'
      <div class="columns producto mb-4">
      ';

    if($sql2)
    {
      echo'
          <div class="textcard column is-4">
            <br>
            <div class="card">
              <div class="card-image">
                <figure class="image is-4by3">
                  <img src="images/' . $sql2->img . '" class="card-img-top" width="286px" height="190px" alt="Upps, no se ha encontrado la imágen">
                <figure>
              </div>
              <div class="card-content">
                <div class="content">
                  <h5 class="card-title">' . $sql2->name . '</h5>
                  <p class="card-text">' . $sql2->detalles . '</p>
                  <p style="color: green; name="price">$' . $sql2->precio . '</p>
                  <p class="card-text" name="stock">stock:' . $sql2->stock . '</p>';
                  if($loggedin){
                    echo'
                    <a href="shop.php" type="button" class="button btn-color">Compra ahora!</a>
                    ';
                }
                echo'
                </div>
              </div>
            </div>
          </div>
      ';
    }

    echo'

        </div>
      </div>

      <!-- js bootstrap and jquery -->
      <script src="../js/jquery-3.4.1.js"></script>
      <script src="../js/popper.js"></script>
      <script src="../js/bootstrap.js"></script>

    </body>
    </html>

    ';

    ?>