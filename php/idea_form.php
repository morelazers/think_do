<?php
    showForm();
    $ideaName = $_POST["ideaName"];
    $ideaDesc = $_POST["ideaDescription"];
    $skills = $_POST["iSkills"];
    $tags = $_POST["iTags"];
    $emptyFields = array();
    if (isset($_POST["submit"]))
    {
        foreach ($_POST as $value)
        {
            if (empty($value))
            { 
                array_push($emptyFields, $value);
            }
        }
        if (empty($emptyFields))
        { 
            /*
            * php to add the idea into the database
            */
            echo 'Idea submitted!';
        }
        else
        { 
            echo 'All forms must be filled in!';
        }
    } 
    function showForm() 
    {
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
              echo '"><br>
              <input type="submit" name="submit" value="Submit">
              </form>';
    }
?> 