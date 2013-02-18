<?php session_start();

include 'header.php';

include 'connect.php';

include 'mysql_functions.php';

$_SESSION['modIdea'] = getIdeaData();

include 'idea_form.php';

include 'footer.php';

?>
