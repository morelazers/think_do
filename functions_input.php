<?php

/**
*  Function to check if the inputs from a $_POST form are all filled in
*/
function inputIsComplete()
{
    //Add all empty fields to an array
    $emptyFields = array();
    foreach ($_POST as $value)
    {
        if (empty($value))
        {
            array_push($emptyFields, $value);
        }
    }
    if (empty($emptyFields))
    { 
        return true;
    }
    else
    {
        echo 'All forms must be filled in!';
        return false;
    }
}

function getInterestIDs($i, $c)
{
    if(!strpos($i, ','))
    {
        echo 'one value found';
        if(in_array($i, $GLOBALS['interests']))
        {
            $IDArray[] = $val;
            echo 'found a value in the database<br>';
            var_dump($val);
            echo '<br>';
        }
        else
        {
            $notInDB[] = $val;
            echo 'found a value not in the database<br>';
            var_dump($val);
            echo '<br>';
        }
    }
    else
    {
        $i = explode(',', $i);
        echo 'exploded array<br>';

        $IDArray = array();
        $notInDB = array();
        foreach($i as $val)
        {
            echo $val.'<br>';
            //$val = '"' .$val. '"';
            //var_dump($val);
            //if(in_array($val, $GLOBALS['interests']))
            $globalInterestCount = count($GLOBALS['interests']);
            $index = 0;
            for($index; $index == $globalInterestCount; $index++)
            {
                echo $GLOBALS['interests'][$index].'<br>';
                if(strcmp(strtolower($val), strtolower($GLOBALS['interests'][$index])) == 0)
                {
                    $IDArray[] = $val;
                    echo 'found a value in the database<br>';
                    var_dump($val);
                    echo '<br>';
                }
                else
                {
                    $notInDB[] = $val;
                    echo 'found a value not in the database<br>';
                    var_dump($val);
                    echo '<br>';
                }
            }
        }
    }

    if(!empty($notInDB))
    {
        echo 'inserting new values<br>';
        insertNewInterests($notInDB);
        echo 'getting new values<br>';
        $newIntResultSet = getNewInterests($notInDB, count($notInDB));
        while($newID = mysql_fetch_array($newIntResultSet))
        {
            $IDArray[] = $newID['ID'];
            var_dump($newID);
            echo '<br>';
        }
    }

    $IDString = implode(',', $IDArray);
    echo 'imploded array<br>';
    return $IDString;
   
    //var_dump($i);
    
    /*$sql = "SELECT ID FROM interests WHERE name IN ($i)";
    $result = mysql_query($sql, $c)
    or die(mysql_error());*/
    
    /*
    foreach($IDs as $val)
    {
        var_dump($val);
        //$val =  $val. ',';
        $IDArray[] = $val;
    }*/
    //var_dump($IDArray);
    
    //var_dump($IDString);
     
}

function insertNewInterests($newInterests)
{
    $sql = "INSERT INTO interests (name) VALUES ";
    $notInDBCount = count($newInterests);
    $i = 0;
    foreach($newInterests as $val)
    {
        $i++;
        if($i == $notInDBCount)
        {
            $sql = $sql . "('" . $val . "')";
        }
        else
        {
            $sql = $sql . "('" . $val . "'), ";
        }
    }
    mysql_query($sql) or die(mysql_error());
}

function getNewInterests($ints, $count)
{
    $i = 0;
    $sql = "SELECT * FROM interests WHERE name ";
    foreach($ints as $val)
    {
        $i++;
        if($i == $count)
        {
            $sql = $sql . "= '%".$val."%'";
        }
        else
        {
           $sql = $sql . "= '%".$val."%' OR name ";
        }
    }
    $result = mysql_query($sql) or die(mysql_error());
    return $result;
}

function getInterestsAsStrings($IDString)
{
    $IDArray = explode(',', $IDString);
    //var_dump($IDArray);
    $StringArray = array();
    foreach($IDArray as $val)
    {
        $StringArray[] = $GLOBALS['interests'][$val];
    }
    $interestString = implode(', ', $StringArray);
    //var_dump($interestString);
    return $interestString;
}

/**
 *  Fcuntion to encrypt string data
 *  @param string $str string to be encrypted
 *  @return hexadecimal string
 */
function encrypt_data($str)
{
	global $eKey;
	$salt = md5($eKey);
	$encrypted_text = sha1($salt.$str);
	return $encrypted_text;
}


?>
