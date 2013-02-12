<?php

/*
 * Functions for getting data relevant for matchmaking from the database, and to output these
 * to the user
 */

function getUserInterests($u, $c)
{
      $ids = $u['interests'];
      $ids = explode(',', $ids);
      //var_dump($ids);
      $intName;
      foreach($ids as &$val)
      {
            //var_dump(intval($val));
            echo $GLOBALS['interests'][intval($val)];
            echo '\n';
      }
      
      //$sql = "SELECT name FROM interests WHERE ID IN ($ids)";
      //$result = mysql_query($sql, $c);
      //var_dump($result);
}

function getAllInterests($c)
{
      $sql = mysql_real_escape_string("SELECT * FROM interests");
      $result = mysql_query($sql, $c);
      echo mysql_error();
      while($row = mysql_fetch_row($result))
      {
            $GLOBALS['interests'][intval($row[1])] = $row[0];
      }
      //var_dump($GLOBALS['interests']);
}

?>
