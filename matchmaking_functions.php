<?php

/*
 * Functions for getting data relevant for matchmaking from the database, and to output these
 * to the user
 */

include 'connect.php';
function getUserInterests($u)
{
      $ids = join(',',$u['interests']);  
      $sql = "SELECT id FROM interests WHERE id IN ($ids)";
      $result = mysql_query($sql, $con);
      var_dump($result);
}

?>
