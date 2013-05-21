<?php

session_start();

include 'connect.php';
include 'functions_idea.php';
include 'functions_user.php';

$id = $_GET['id'];

$idea = getIdeaData($id, $con);

if(userHasVoted($idea, $_SESSION['usr'])){
	decrementIdeaUpvotes($idea, $_SESSION['usr'], $con);
}
else{
	incrementIdeaUpvotes($idea, $_SESSION['usr'], $con);
}

$_SESSION['usr']=getUserData($con, $_SESSION['usr']['username']);

?>