<?php

/*
 * Functions for getting data relevant for matchmaking from the database, and to output these
 * to the user
 */

include 'connect.php';
function getUserInterests($u, $con)
{
      $ids = $u['interests'];
      $sql = "SELECT name FROM interests WHERE ID IN ($ids)";
      $result = mysql_query($sql, $con);
      var_dump($result);
}

function getAllInterests($con)
{
      $sql = mysql_real_escape_string("SELECT * FROM 'interests' WHERE 1 LIMIT 0,10");
      if (!$con)
    {
        die('Could not connect: ' . mysql_error());
    }
      $result = mysql_query($sql, $con)
      or die(mysql_error());
      echo mysql_error();
      var_dump($result);
      while($row = mysql_fetch_assoc($result))
      {
            $GLOBALS['interests'] = $row;
            var_dump($row);
      }
      var_dump($GLOBALS['interests']);
}

?>
