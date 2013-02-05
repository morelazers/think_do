<?php

/*
 * Functions for getting data relevant for matchmaking from the database, and to output these
 * to the user
 */


function getUserInterests($u, $c)
{
      $ids = join(',',$u['interests']);  
      $sql = "SELECT id FROM interests WHERE id IN ($ids)";
      $result = mysql_query($sql, $c);
      var_dump($result);
}

?>
