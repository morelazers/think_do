<?php
    $con = mysql_connect("scc230-4.lancs.ac.uk","root","comicsans");
    if (!$con)
    {
        die('<div class="mysqlConnectError">Could not connect: '.mysql_error().'</div>');
    }
    mysql_select_db("thinkdo", $con);
?>