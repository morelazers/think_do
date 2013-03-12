<?php 
session_start();
echo'<script>
	$(function(){
		$( "#tabs" ).tabs();
	});
</script>
<script language="javascript" type="text/javascript">
$(function() {
    var availableInterests = [
    ';
    $count = 0;
    foreach($GLOBALS['interestsArray'] as $val)
    {
        $count++;
        echo '"' . $val . '"';
        if ($count <= $GLOBALS['maxInterestArrayIndex'])
        {
            echo ', ';
        }
    }
    echo '
    ];
    $( "#interests" ).tagit({
        availableTags: availableInterests,
        allowSpaces: true,
        removeConfirmation: true
    });
});
 </script>';
if (isset($_SESSION['usr']))
{

    $currentUser = $_SESSION['usr'];

    $oldPass = $_POST["oldPass"];
    $pass1 = $_POST["newPass"];
    $pass2 = $_POST["newPass2"];
    
    $aboutMe = $_POST["aboutMe"];
    $interests = $_POST["interests"];
    $skills = $_POST["skills"];
   
    
    if (isset($_POST["submitPass"]))
    {
        if (passInputIsComplete())
        {
            if (checkPass($con, $oldPass, $currentUser))
            {
                changePass($con, $currentUser, trim($pass1));
                $_SESSION['usr'] = getUserData($currentUser['username']);
                $currentUser = $_SESSION['usr'];
            }
        }
    }
    if (isset($_POST["submitAboutMe"]))
    {
        /*if (profileInputIsComplete())
        { */  
            $IDinterests = getInterestIDs($interests, $con);

            $aboutMe = mysql_real_escape_string($aboutMe);
            $IDinterests = mysql_real_escape_string($IDinterests);
            $skills = mysql_real_escape_string($skills);
            
            updateProfileInfo($con, $aboutMe, $IDinterests, $skills);
            $_SESSION['usr'] = getUserData($con, $currentUser['username']);
            $currentUser = $_SESSION['usr'];
        /*}*/
    }

    echo '
            <div id="tabs">
                <ul>
                    <li><a href="#tabs-1">Edit Profile</a></li>
                    <li><a href="#tabs-2">Change Avatar</a></li>
                    <li><a href="#tabs-3">Change Password</a></li>
                </ul>
                <div id="tabs-1">
            ';
    showAboutMeForm($currentUser);
    echo '
        </div>
        <div id="tabs-2">
        ';
    include 'form_avatar_upload.php';
    echo '</div>
        <div id="tabs-3">
        ';
    showPassForm();
    echo '</div></div>';
    
}
else
{
    header('Location: login.php');
}
	
		
	
	
    /**
	*	This function declares an empty array then adds each empty _POST value
	*	to the array. The function then checks to see if the array is empty at
	*	the end, returning true if it is, false if has any values in it.
	*/
function passInputIsComplete()
{  
	$emptyFields = array();
	$fields = array($_POST["oldPass"], $_POST["newPass"], $_POST["newPass2"]);
        foreach ($fields as $value)
        {
		if (empty($value))
           	{
                	array_push($emptyFields, $value);
            	}
        }
        if (empty($emptyFields))
        {
        	//echo "complete password input";
		    return true;
        }
        else
        {
        	//echo "incomplete password input";
		    return false;
        }
}

function profileInputIsComplete()
{  
	$emptyFields = array();
	$fields = array($_POST["aboutMe"], $_POST["interests"], $_POST["skills"]);
    foreach ($fields as $value)
    {
	if (empty($value))
       	{ 
            	array_push($emptyFields, $value);
        }
    }
    if (empty($emptyFields))
    {
    	//echo "complete profile input";
	    return true;
	
    }
    else
    {
    	//echo "incomplete profile input";
	    return false;
    }
}


    
	/**
	*	This function is responsible for outputting the login form to the page
	*/
function showPassForm() 
{
	echo '<form method="post" action="'; 
        echo $PHP_SELF; 
        echo '">
        <label for="old_password">Old password:</label><br>
        <input type="password" name="oldPass" id="old_password" value=""><br>
	<label for="new_password">New password:</label><br>
        <input type="password" name="newPass" id="new_password" value=""><br>
	<label for="new_password2">Retype new password:</label><br>
        <input type="password" name="newPass2" id="new_password2" value=""><br>
        <input type="submit" name="submitPass" class="normalButton" value="Change">
        </form>';
}

function showAboutMeForm($u)
{	
    //var_dump($u['interests']);
    $interestsToDisplay = getInterestsAsStrings($u['interests']);
    //var_dump($interestsToDisplay);
	echo '<form method="post" action="'; 
    echo $PHP_SELF; 
    echo '">
    <label for="aboutMe">Describe yourself:</label><br>
    <textarea rows="10" cols="30" name="aboutMe" id="aboutMe">';
    echo $u['aboutme'];
    echo '</textarea><br>
	<label for="interests">What are you interested in?</label><br>
    <input type="text" name="interests" id="interests" value="';
    echo $interestsToDisplay;
    echo '"><br>
	<label for="skills">What skills do you have?</label><br>
    <input type="text" name="skills" id="skills" value="';
    echo $u['skills'];
    echo '"><br>
    <input type="submit" name="submitAboutMe" class="normalButton" value="Update">
    </form>';
}
    

?> 
