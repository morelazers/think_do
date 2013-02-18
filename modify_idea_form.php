<?php session_start();

include 'connect.php';

include 'mysql_functions.php';

$_SESSION['modIdea'] = getIdeaData();

include 'idea_form.php';

?>
