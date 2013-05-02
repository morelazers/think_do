<?php

/*include "functions_comment.php";*/

$upComID=$_GET['upCom'];
$u=$_SESSION['usr'];

/*var_dump($upComID);*/

$commentToUpvote = getCommentData($upComID);

incrementCommentUpvotes($commentToUpvote, $u);

?>