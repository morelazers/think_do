<?php
    $con = mysql_connect("localhost:3306","root","comicsans");
    if (!$con)
    {
        die('Could not connect: ' . mysql_error());
    }
    mysql_select_db("thinkdo", $con);
?>