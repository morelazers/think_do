<?php
    $con = mysql_connect("mysql.thinkshare.it","lazorsql","laz0rbe4mz");
    if (!$con)
    {
        die('<div class="mysqlConnectError">Could not connect: '.mysql_error().'</div>');
    }
    mysql_select_db("lazors_dev", $con);
?>