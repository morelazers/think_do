<?php
    $con = mysql_connect("http://scc230-4.lancs.ac.uk:3306","root","comicsans");
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