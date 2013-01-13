<?php 
    $uName = $_POST["userName"];
    $pass = $_POST["password"];
    $emptyFields = array();
    if (isset($_POST["submit"]))
    {
        foreach ($_POST as $value)
        {
            if (!empty($value))
            { 
                array_push($emptyFields, $value);
            }
        }
        if (empty($emptyFields))
        {
            //validate login
        }
        else
        {
            echo "Fields cannot be empty!";
        }
    } 
?> 