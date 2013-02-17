<?php session_start();

include 'connect.php';

include 'mysql_functions.php';

$_SESSION['modIdea'] = getIdeaData();

showModificationForm($_SESSION['modIdea']);

if (isset($_POST["submitIdeaModification"]))
{
  if (inputIsComplete())
   	{   
   		/*
   		 * Functionality needed to take the inputted interests and convert them to
   		 * a string of comma-separated integers to be passed into the update function
   		 */
   		$aboutMe = mysql_real_escape_string($aboutMe);
   		$interests = mysql_real_escape_string($interests);
   		$skills = mysql_real_escape_string($skills);
   		
   		updateIdea($con, $aboutMe, $interests, $skills);
   	}
}

/**
 *  Function to display the form for modifying an idea
 *  @param idea $i assosciative array containing all the fields for the current idea
 */
function showModificationForm($i)
{	
	echo '<form method="post" action="'; 
    echo $PHP_SELF; 
    echo '">
    <label for="description">Describe your idea:</label><br>
    <input type="text" name="description" id="description" value="';
    echo $i['description'];
    echo '"><br>
	<label for="interests">Related areas</label><br>
    <input type="text" name="interests" id="interests" value="';
    echo $i['interests'];
    echo '"><br>
	<label for="skills">Which skills would be useful?</label><br>
    <input type="text" name="skills" id="skills" value="';
    echo $i['skillsRequired'];
    echo '"><br>
    <input type="submit" name="submitIdeaModification" value="Update">
    </form>';
}

?>
