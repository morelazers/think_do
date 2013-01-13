<?php 
$ideaName = $_POST["ideaName"];
$ideaDesc = $_POST["ideaDescription"];
$skills = $_POST["iSkills"];
$tags = $_POST["iTags"];
if (isset($_POST["submit"]))
{
    foreach ($_POST as $value)
    {
        if (!empty($value))
        {      
        header('Location: http://think_do.morelazers_1.c9.io/html/incomplete_idea.html');
        }
    }
    if ($formComplete)
    {
    /*
    *
    *Save idea to the database
    *
    */
    }
}
else
{
    
}
?>