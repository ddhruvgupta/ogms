<?php 
if (isset($_SERVER['HTTP_HOST']))
{
    if($_SERVER['HTTP_HOST'] == "localhost")
    {
        $root =  realpath($_SERVER["CONTEXT_DOCUMENT_ROOT"]);
        define("ROOT",$root."/student/ogms/public_html");
        $root = ROOT;
        include "connection.php";
        include "test.php";
        $_SESSION['displ'] = 1;

    }
    else
    {
        $root =  realpath($_SERVER["CONTEXT_DOCUMENT_ROOT"]);
        include "pdo_connection_server.php";
        require "security.php";

    }
}
else
{
    $root =  realpath($_SERVER["CONTEXT_DOCUMENT_ROOT"]);
}

?>