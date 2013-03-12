<?php

/*
 * Functions for getting data relevant for matchmaking from the database, and to output these
 * to the user
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
            }
      }

      //var_dump($GLOBALS['interests']);
}

function think($c)
{
      $u = $_SESSION['usr'];
      $interestArray = explode(',', $u['interests']);
      $SQLArrayString = array();
      
      $interestCount = count($interestArray);
      $i = 0;
      
      $sql = "SELECT * FROM idea WHERE interests ";
      
      foreach($interestArray as $val)
      {
            //$val = "'".$val."'";
            //$SQLArrayString[] = $val;
            $i++;
            if($i == ($interestCount))
            {
                   $sql = $sql . "LIKE '%".$val."%'";
            }
            else
            {
                   $sql = $sql . "LIKE '%".$val."%' OR interests ";
            }
      }
      //var_dump($sql);
      
       //'Text%' OR column LIKE 'Hello%' OR column LIKE 'That%'
      
      
      //$sql = "SELECT * FROM idea WHERE interests LIKE (%".$SQLArrayString."%)";
      //var_dump($sql);
      $res = mysql_query($sql, $c);
      //var_dump($res);
/*      while ($resultIdea = mysql_fetch_array($res))
      {
            //var_dump($resultIdea);
            echo '<a href="view_ideas.php?pid='.$resultIdea["ideaID"].'">'.$resultIdea["ideaName"].'</a></br>';
      }*/
      outputIdeas($res);
}

?>
