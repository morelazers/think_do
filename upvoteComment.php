<?php

include "functions_comment.php";

$upComID=$_GET['upCom'];
$u=$_SESSION['usr'];

$commentToUpvote = getCommentData($upComID);

incrementCommentUpvotes($commentToUpvote, $u);

?>