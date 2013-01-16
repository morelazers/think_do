<?php
    $con = mysql_connect("localhost:3306","root","p");
    if (!$con)
    {
        die('Could not connect: ' . mysql_error());
    }
?>