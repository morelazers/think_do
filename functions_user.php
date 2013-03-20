<?php

$eKey = 'TOPSECRET';

/**
 *  MySQL function for connecting to and querying the database for user data
 *  @param MySQLConnection $c Connection to MySQL database, necessary to perform queries
 *  @param string $u Username for the current user
 *  @return either false, if there is no such user, or an assosciative array containing all the fields from the users table
 */
 function getUserData($c, $u)
 {
    //Query database get the data for the user (will use sessions later)
    $sql = "SELECT * FROM user WHERE username = '" . $u . "'";
    $resultRow = mysql_query($sql, $c);

    //Get the row with the user's data
    $user = mysql_fetch_array($resultRow);

	//If there is no user with the inputted name in the database
	if ($user == null)
    {
    	//echo 'no user';
       	return false;
    }
	else
	{
		return $user;
	}
 }

/*function getUserAvatar()
{
    $u = $_SESSION['usr'];
    $sql = "SELECT avatarLocation FROM user WHERE userID = ".$u['userID'];
    $res = mysql_query($sql) or die(mysql_error());
    $avatarLocation = mysql_fetch_array($res);
    $u['avatar'] = $avatarLocation['fileLocation'];
    $_SESSION['usr'] = $u;
}*/


/**
 *  MySQL function to verify that the entered password is correct during a login attempt
 *  @param MySQLConnection $c Connection to MySQL database, necessary to perform queries
 *  @param string $text the entered password
 *  @param user $user the the current user
 */
function checkPass($c, $text, $user)
{
    global $eKey;
    $salt = md5($eKey);
    $decPass = (sha1($salt.$text));
    /*
    $sql = "SELECT password FROM user WHERE username = '" . $user['username'] . "'";
    $resultRow = mysql_query($sql, $c);
    $pass = mysql_fetch_assoc($resultRow);
    var_dump($pass);
    var_dump($decPass);
    */
    /*
    *   Replaced '==' comparison with strcmp() and surrounded the args with trim()
    *   to ensure an accurate comparison
    *   -Nathan
    */
    //var_dump($user);
    //var_dump($decPass);
    if (strcmp(trim($user['password']), trim($decPass)) == 0)
    {
        return true;
    }
    else
    {
        echo '<h2>Your password is incorrect!</h2>';
        return false;
    }
}


/**
 *  MySQL function to change a user's password
 *  @param MySQLConnection $c Connection to MySQL database, necessary to perform operations
 *  @param user $user the current user
 *  @param password $newpass the entered password
 */
function changePass($c, $user, $newPass)
{
    $encP = encrypt_data($newPass);
    $sql="UPDATE user SET password='".$encP."' WHERE username='".trim($user['username'])."'";
    if(!mysql_query($sql, $c))
    {
        echo "Could not update password!";
        die('Error: ' . mysql_error());
    }
    $user['password'] = $encP;
}


/**
 *  MySQL function to change the current user's profile information
 *  @param MySQLConnection $c Connection to MySQL database, necessary to perform operations
 *  @param string $a the user's 'About Me'
 *  @param string $i the user's interests, as comma-seperated indices
 *  @param string $s the user's skills, as a string (for now)
 */
function updateProfileInfo($c, $a, $i, $s)
{
    $u = $_SESSION['usr'];
    $sql = "UPDATE user SET aboutMe ='".$a."', interests = '".$i."', skills = '".$s."' WHERE username='".$u['username']."'";
    
    if(!mysql_query($sql, $c))
    {
        echo "Could not update profile information!";
        die('Error: ' . mysql_error());
    }
}

/**
 *  MySQL function to insert the data from the register form into the database
 *  @param MySQLConnection $c Connection to MySQL database, necessary to perform operations
 *  @param string $u the entered username
 *  @param string $e the entered email address
 *  @param string $p the entered password
 */
function insertIntoDB($c, $u, $e, $p)
{
    $encP = encrypt_data($p);

    function emailNewUser($eA)
    {
        $subject = "Welcome to thinkdo!";
        $message = "Thanks for signing up to thinkdo!";
        $from = "admin@think.do";
        $headers = "From: " . $from;
        mail($eA, $subject, $message, $headers);
    }

    $sql="INSERT INTO user (username, email, password) VALUES ('$u', '$e', '$encP')";
    if (!mysql_query($sql, $c))
    {
        echo 'Failed to add record';
        die('Error: ' . mysql_error());
    }
    else
    {
        echo 'You are registered!<br>Please login';
        emailNewUser($e);
        //header('Location: index.php');
    }
    mysql_close($con);
}

/**
 *  MySQL function to check that an inputted username has not already been taken
 *  @param string $u the entered username
 *  @param MySQLConnection $c Connection to MySQL database, necessary to perform operations
 */
function userIsNotTaken($u, $c)
{
    //Query database to check if username is taken
    $sql = "SELECT username FROM user WHERE username ='".$u."'";
    $result = mysql_query($sql, $c);
    $user = mysql_fetch_assoc($result);
    //If username is not taken, add new user to database
    if($user == null)
    {
        return true;
    }
    else
    {
        echo 'Username is already taken!';
        return false;
    }
}

/**
*   Function to display the profile of the user passed into it
*   @param array $u the array of the user's data
*/
function displayProfile($u)
{
    /*include 'functions_idea.php';*/
    echo '<h2>'.$u['username'].'</h2><br>';
    echo '<h3>About Me:</h3><br>';
    echo '<p>'.$u['aboutme'].'</p><br>';
    echo '<h3>Skills:</h3><br>';
    echo '<p>'.$u['skills'].'</p><br>';
    echo '<h3>Interests:</h3><br>';
    echo '<p>'.getInterestsAsStrings($u['interests']).'</p><br>';
    echo "<h3>Ideas I've Shared:</h3><br>";
    $sql = "SELECT * FROM idea WHERE createdBy = '".$u['username']."'";
    $res = mysql_query($sql);
    outputIdeas($res);
    /*while($idea = mysql_fetch_array($res))
    {
        echo '<h2><a href="./view_ideas.php?pid='.$idea['ideaID'].'">'.$idea['ideaName'].'</a></h2></br>';
    }*/
    echo "<h3>Ideas I've Liked:</h3><br>";


    $likedIdeasArray = explode(',', $u['ideasVotedFor']);
    $SQLArrayString = array();

    $ideasCount = count($likedIdeasArray);
    $i = 0;

    $sql = "SELECT * FROM idea WHERE ideaID ";

    foreach($likedIdeasArray as $val)
    {
        //$val = "'".$val."'";
        //$SQLArrayString[] = $val;
        $i++;
        if($i == ($ideasCount))
        {
               $sql = $sql . "LIKE '%".$val."%'";
        }
        else
        {
               $sql = $sql . "LIKE '%".$val."%' OR ideaID ";
        }
    }

    $res = mysql_query($sql) or die(mysql_error());
    outputIdeas($res);

    /*while($idea = mysql_fetch_array($res))
    {
        echo '<h2><a href="./view_ideas.php?pid='.$idea['ideaID'].'">'.$idea['ideaName'].'</a></h2></br>';
    }*/

}

?>
