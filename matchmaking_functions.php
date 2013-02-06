<?php

/*
 * Functions for getting data relevant for matchmaking from the database, and to output these
 * to the user
 */

include 'connect.php';
function getUserInterests($u)
{
      $ids = join(',',$u['interests']);  
      var_dump($ids);
      $sql = "SELECT ID FROM interests WHERE ID IN ($ids)";
      $result = mysql_query($sql, $con);
      var_dump($result);
}

?>
