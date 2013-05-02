<?php

include "connect.php";
include "functions_comment.php";


$upComID = $_GET['upCom'];
var_dump($upComID);

/*var_dump($upComID);*/

$commentToUpvote = getCommentData($upComID);
var_dump($commentToUpvote);

incrementCommentUpvotes($commentToUpvote, $_SESSION['usr']);

?>