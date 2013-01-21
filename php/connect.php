<?php
    $con = mysql_connect("127.0.0.1:3306","root","");
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