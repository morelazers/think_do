<?php
    $con = mysql_connect("localhost:3306","root","comicsans");
    if (!$con)
    {
        die('<div class="mysqlConnectError">Could not connect: '.mysql_error().'</div>');
    }
    mysql_select_db("thinkdo", $con);
?>