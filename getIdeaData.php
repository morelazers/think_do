<?php

include "connect.php";
include "functions_idea.php";

$idea = getIdeaFromID($_POST['ideaID']);
outputIdeas($idea);

?>