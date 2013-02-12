<?php

/*
 * Functions for getting data relevant for matchmaking from the database, and to output these
 * to the user
 */

include 'connect.php';
function getUserInterests($u)
{
      $ids = $u['interests'];
      $sql = "SELECT name FROM interests WHERE ID IN ($ids)";
      $result = mysql_query($sql, $con);
      var_dump($result);
}

function getAllInterests()
{
      $sql = "SELECT * FROM interests";
      $result = mysql_query($sql, $con);
      var_dump($result);
      while($row = mysql_fetch_assoc($result))
      {
            $GLOBALS['interests'] = $row;
            var_dump($row);
      }
      var_dump($GLOBALS['interests']);
}

?>
