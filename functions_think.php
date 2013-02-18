<?php

/*
 * Functions for getting data relevant for matchmaking from the database, and to output these
 * to the user
 */

/*function getUserInterests($u)
{
      $ids = $u['interests'];
      $ids = explode(',', $ids);
      //var_dump($ids);
      $u['interests'] = $ids;
      $_SESSION['usr'] = $u;
      //$sql = "SELECT name FROM interests WHERE ID IN ($ids)";
      //$result = mysql_query($sql, $c);
      //var_dump($result);
}
*/
function getAllInterests($c)
{
      $sql = "SELECT * FROM interests";
      $result = mysql_query($sql, $c);
      while(($row = mysql_fetch_row($result))!=null)
      {
            $GLOBALS['interests'][intval($row[1])] = $row[0];
      }
      //var_dump($GLOBALS['interests']);
}

?>
