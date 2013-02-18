<?php session_start();

include 'connect.php';

include 'functions_idea.php';

$_SESSION['modIdea'] = getIdeaData();

include 'idea_form.php';

?>
