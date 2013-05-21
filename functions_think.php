<?php

/*
 * Functions for getting data relevant for matchmaking from the database, and to output these
 * to the user
 */


/*
* gets the interests for the current user
*/
function getUserInterests($u)
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

/*
* gets all the interests from the database and loads them into the global array
*/
function getAllInterests($c)
{
      $maxVal = -1;
      $currentVal = 0;
      $sql = "SELECT * FROM interests ORDER BY name";
      $result = mysql_query($sql, $c);
      while(($row = mysql_fetch_row($result))!=null)
      {
            $GLOBALS['interestsArray'][intval($row[1])] = $row[0];
            $currentVal = intval($row[1]);
            if($currentVal > $maxVal)
            {
                  $GLOBALS['maxInterestArrayIndex'] = $currentVal;
                  $maxVal = $currentVal;
            }
      }

      //var_dump($GLOBALS['interests']);
}

/*
* selects all the ideas from the database relevant to the interests of the current user, then outputs them
*/
function think($c)
{
      $u = $_SESSION['usr'];
      $interestArray = explode(',', $u['interests']);
      $SQLArrayString = array();
      
      $interestCount = count($interestArray);
      $i = 0;
      
      $sql = "SELECT * FROM idea WHERE isOpen = 1 AND (interests ";
      
      foreach($interestArray as $val)
      {
            $i++;
            if($i == ($interestCount))
            {
                   $sql = $sql . "LIKE '%".$val."%') ORDER BY upVotes DESC";
            }
            else
            {
                   $sql = $sql . "LIKE '%".$val."%' OR interests ";
            }
      }
      $res = mysql_query($sql, $c);
      outputIdeas($res);
}


/*
function think($c)
{
      $u = $_SESSION['usr'];
      $interestArray = explode(',', $u['interests']);
      $SQLArrayString = array();
      
      $interestCount = count($interestArray);
      $i = 0;
      
      $sql = "SELECT * FROM idea WHERE isOpen = 1 AND (interests ";
      
      foreach($interestArray as $val)
      {
            $i++;
            if($i == ($interestCount))
            {
                   $sql = $sql . "LIKE '%".$val."%') ORDER BY upVotes DESC";
            }
            else
            {
                   $sql = $sql . "LIKE '%".$val."%' OR interests ";
            }
      }
      $res = mysql_query($sql, $c);
      outputIdeas($res);
}
*/

?>
