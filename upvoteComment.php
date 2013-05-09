<?php

session_start();

include "connect.php";
include "functions_comment.php";
include "functions_user.php";

$comID = $_GET['com'];

$comment = getCommentData($comID);

if(userHasVotedOnComment($comment, $_SESSION['usr']))
{
	decrementCommentUpvotes($comment, $_SESSION['usr']);
}
else
{
	incrementCommentUpvotes($comment, $_SESSION['usr']);
}

$_SESSION['usr'] = getUserData($con, $_SESSION['usr']['username']);

?>