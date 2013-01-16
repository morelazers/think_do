<?php
    $con = mysql_connect("90.217.44.242:3306","230admin","philosophersturd");
    if (!$con)
    {
        die('Could not connect: ' . mysql_error());
    }
    else
    {
        echo 'connected to the database';
    }
    
    mysql_select_db("thinkdo", $con);
?>