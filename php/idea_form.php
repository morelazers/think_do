<?php
    error_reporting(0);
    showForm();
    $ideaName = $_POST["ideaName"];
    $ideaDesc = $_POST["ideaDescription"];
    $skills = $_POST["iSkills"];
    $tags = $_POST["iTags"];
    $emptyFields = array();
	
    //Attempt database connection
    $con = mysql_connect("127.0.0.1:3306","root","");
    if (!$con)
    {
        die('Could not connect: ' . mysql_error());
    }
    //Select thinkdo database
    mysql_select_db("thinkdo", $con);
    
    if (isset($_POST["submit"]))
    {
		//Add all empty fields to an array
        foreach ($_POST as $value)
        {
            if (empty($value))
            { 
                array_push($emptyFields, $value);
            }
        }
		//If no fields are empty, add to database
        if (empty($emptyFields))
        { 
            $iName = $_POST["ideaName"];
            $iDesc = $_POST["ideaDescription"];
			$iSkills = $_POST["iSkills"];
			$iTags = $_POST["iTags"];
			$iDate = date("Y-m-d H:i:s");
			//Convert radio button value to integer representation of boolean
			if($_POST["iPrivacy"]=="public")
			{
				$iOpen = 1;
			}
			else
			{
				$iOpen = 0;
			}
			//Execute query to insert new tuple
            $sql="INSERT INTO project (projectName, description, skillsRequired, tags, dateCreated, isOpen) VALUES ('".$iName."', '".$iDesc."', '".$iSkills."', '".$iTags."', '".$iDate."', '".$iOpen."')";
            if (!mysql_query($sql, $con))
			//If error durying query execution report error
            {
                echo 'failed to add record';
                die('Error: ' . mysql_error());
            }
            
            mysql_close($con);
            echo 'Idea submitted!';
        }
        else
        { 
            echo 'All forms must be filled in!';
        }
    }
    
    function showForm() 
    {
		/*
		This function echos the idea input form to the page. If a value was previously entered into an input
		it is echoed back into that input to remove the need to reenter data in the case of a field being
		invalid.
		*/
        echo '<form method="post" action="'; echo $PHP_SELF; echo '">
              <label for="idea_title">Name your idea:</label><br>
              <input type="text" name="ideaName" id="idea_title" value="';
			echo $_POST["ideaName"];
            echo '"><br>
              <label for="idea_desc">Describe your idea:</label><br>
              <input type="text" name="ideaDescription" id="idea_desc" size="50" value="';
            echo $_POST["ideaDescription"]; 
            echo '"><br>
              <label for="skills">Beneficial Skills:</label><br>
              <input type="text" name="iSkills" id="skills" value="';
            echo $_POST["iSkills"];
            echo '"><br>
              <label for="tags">Tags:</label><br>
              <input type="text" name="iTags" id="tags" value="';
            echo $_POST["iTags"];
			echo '"><br><label for="Privacy">Privacy:</label><br>';
			//This if is responsible for preselecting a one of the radio buttons for privacy
			if(array_key_exists("iPrivacy", $_POST))
			{
				if($_POST["iPrivacy"] == "public")
				{
					echo '
					  <input type="radio" name="iPrivacy" id="privacy" value="public" checked="checked">Public';
				}
				else
				{
					echo '
					  <input type="radio" name="iPrivacy" id="privacy" value="public">Public';
				}
				if($_POST["iPrivacy"] == "private")
				{
					echo '
					  <input type="radio" name="iPrivacy" id="privacy" value="private" checked="checked">Private';
				}
				else
				{
					echo '
					  <input type="radio" name="iPrivacy" id="privacy" value="private">Private';
				}
				
			}
			else
			{
				echo '<input type="radio" name="iPrivacy" id="privacy" value="public" checked="checked">Public
					<input type="radio" name="iPrivacy" id="privacy" value="private">Private';
			}
			echo '<br><input type="submit" name="submit" value="Submit"></form>';
    }
?> 