<?php

session_start();

include "connect.php";
include "functions_idea.php";
include "functions_user.php";

$id = $_GET['id'];

$idea = getIdeaData($id, $con);

$status = userMemberStatus($idea, $_SESSION['usr'], $con);

if($status == 0){
	joinIdeaTeam($idea, $_SESSION['usr'], $con);
}
elseif($status == 1){
	removeInterestInIdea($idea, $_SESSION['usr'], $con);
}

$_SESSION['usr'] = getUserData($con, $_SESSION['usr']['username']);

?>