<?php

/*
 * Functions for getting data relevant for matchmaking from the database, and to output these
 * to the user
 */

function getUserInterests($u, $c)
{
      $ids = $u['interests'];
      $sql = "SELECT name FROM interests WHERE ID IN ($ids)";
      $result = mysql_query($sql, $c);
      var_dump($result);
}

function getAllInterests($c)
{
      $sql = mysql_real_escape_string("SELECT * FROM interests");
      $result = mysql_query($sql, $c);
      echo mysql_error();
      while($row = mysql_fetch_array($result))
      {
            $GLOBALS['interests'][$row['id']] = $row['name'];
      }
      var_dump($GLOBALS['interests']);
}

?>
