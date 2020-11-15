<?php
    use Illuminate\Database\Capsule\Manager as DB;
    require 'vendor/autoload.php';
    require 'config/database.php';

    function destroySession()
    {
        $_SESSION=array();

        if (session_id() != "" || isset($_COOKIE[session_name()]))
            setcookie(session_name(), '', time()-2592000, '/');

        session_destroy();
    }

    function sanitizeString($var)
    {
        $var = strip_tags($var);
        $var = htmlentities($var);
        return $var;
    }

    function showProfile($user)
    {
        if (file_exists("$user.jpg"))
            echo "<img src='$user.jpg' style='float:left;'>";

        $result = DB::table('profiles')->where('user','=',$user)->first();

        if ($result)
        {
            $row = $result->text;
            echo "<br style='clear:left;'>" . $row . "<br style='clear:left;'><br>";
        }
        else echo "<p><i>Escribe algo aquí</i></p><br>";
    }
?>

