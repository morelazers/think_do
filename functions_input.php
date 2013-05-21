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
        echo '<div class="incompleteError">All forms must be filled in!</div>';
        return false;
    }
}

/*
* gets the ids for the given interest string
*/
function getInterestIDs($i, $c)
{
    $nameArray = array();
    $IDArray = array();
    $notInDB = array();
    if(!strpos($i, ','))
    {
        if(in_array($i, $GLOBALS['interestsArray']))
        {
            $nameArray[] = $i;
        }
        else
        {
            $notInDB[] = $i;
        }
    }
    else
    {
        $i = explode(',', $i);
        foreach($i as $val)
        {
            $inDB = false;
            $index = 0;
            for($index; $index <= $GLOBALS['maxInterestArrayIndex']; $index++)
            {
                if(strcmp(strtolower($val), strtolower($GLOBALS['interestsArray'][$index])) == 0)
                {
                    $inDB = true;
                    break;
                }
            }
            if(!$inDB)
            {
            	if(strcmp($val, mysql_escape_string($val))==0){
                	$notInDB[] = $val;
                }
            }
            $nameArray[] = $val;
        }
    }

    if(!empty($notInDB))
    {
        insertNewInterests($notInDB);
    }
    
    $newIntResultSet = getNewInterests($nameArray, count($nameArray));
    while($newID = mysql_fetch_array($newIntResultSet))
    {
        $IDArray[] = $newID['ID'];
    }

    $IDString = implode(',', $IDArray);
    return $IDString;
}

//inserts new interests into the database
function insertNewInterests($newInterests)
{
    $sql = "INSERT INTO interests (name) VALUES ";
    $notInDBCount = count($newInterests);
    $GLOBALS['maxInterestArrayIndex'] = $GLOBALS['maxInterestArrayIndex'] + $notInDBCount;
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

//gets the new interests from the database, so they can be used instantly 
function getNewInterests($ints, $count)
{
    $i = 0;
    $sql = "SELECT * FROM interests WHERE name ";
    foreach($ints as $val)
    {
        $i++;
        if($i == $count)
        {
            $sql = $sql . "= '".$val."'";
        }
        else
        {
           $sql = $sql . "= '".$val."' OR name ";
        }
    }
    //var_dump($sql);
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
        $StringArray[] = $GLOBALS['interestsArray'][$val];
    }
    $interestString = implode(', ', $StringArray);
    //var_dump($interestString);
    return $interestString;
}

/**
 *  Function to encrypt string data
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
