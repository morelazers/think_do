<?php

include "connect.php";
include "functions_comment.php";


$upComID = $_GET['upCom'];

/*var_dump($upComID);*/

$commentToUpvote = getCommentData($upComID);
var_dump($commentToUpvote);
echo '<br>';
var_dump($_SESSION['usr']);

incrementCommentUpvotes($commentToUpvote, $_SESSION['usr']);

?>