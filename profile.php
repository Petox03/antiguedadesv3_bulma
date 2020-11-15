<?php
use Illuminate\Database\Capsule\Manager as DB;
require_once 'header.php';
if (!$loggedin) die("<meta http-equiv='Refresh' content='0;url=index.php'></div></body></html>");
echo "<div class='container is-fluid'>
<h3 class='center'>Your Profile</h3>";
$result = DB::table('profiles')->where('user', $user)->first();

if (isset($_POST['text'])){
    $text = sanitizeString($_POST['text']);
    $text = preg_replace('/\s\s+/', ' ',$text);
    if ($result)
    {
            DB::table('profiles')
                ->where('user', $user)
                ->update(['text' => $text]);
    }
    else{
        DB::table('profiles')->insert(['members_idmembers'=>$id_miembro, 'user'=>$user, 'text'=>$text]);
    }
}else {
    if ($result) {
        $text = stripslashes($result->text);
    }
    else $text = "";
}

$text = stripslashes(preg_replace('/\s\s+/', ' ', $text));

if(isset($_FILES['image']['name'])){
    $saveto = "$user.jpg";
    move_uploaded_file($_FILES['image']['tmp_name'], $saveto);
    $typeok = TRUE;

    switch($_FILES['image']['type']) {
        case "image/gif":   $src = imagecreatefromgif($saveto); break;
        case "image/jpeg":  //Both regular and progressive jpegs
        case "image/pjpeg": $src = imagecreatefromjpeg($saveto); break;
        case "image/png":   $src = imagecreatefrompng($saveto); break;
        default:            $typeok = FALSE; break;
    }

        if($typeok) {
            list($w, $h) = getimagesize($saveto);

            $max = 100;
            $tw  = $w;
            $th  = $h;

            if($w > $h && $max < $w) {
                $th = $max / $w * $h;
                $tw = $max;
            }
            elseif ($h > $w && $max < $h) {
                $tw = $max / $h * $w;
                $th = $max;
            }
            elseif($max < $w){
                $tw = $th = $max;
            }

            $tmp = imagecreatetruecolor($tw, $th);
            imagecopyresampled($tmp, $src, 0, 0, 0, 0, $tw, $th, $w, $h);
            imageconvolution($tmp, array(array(-1, -1, -1),
                array(-1, 16, -1), array(-1, -1, -1)), 8, 0);
            imagejpeg($tmp, $saveto);
            imagedestroy($tmp);
            imagedestroy($src);
        }
    }
    showProfile($user);
echo <<<_END
                <form method='post' action='profile.php' enctype='multipart/form-data'>
                    <div class="form-group col-md-8">
                        <h3>Enter or edit your details and/or upload image</h3>
                        <textarea name='text' class="form-control">$text</textarea><br>
                    </div>
                    <div class="form-group col-md-8">
                        Image: <input type='file' name='image' size='14'>
                    </div>
                    <button type='submit' class='button btn-color mt-2'>Guardar</button>
                </form>
            </div><br>
        </div>
    </body>
</html>
_END;
?>