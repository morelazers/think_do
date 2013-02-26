<?php

include 'connect.php';
include 'functions_user.php';
include 'functions_idea.php';
include 'functions_input.php';

$i = 0;
for ($i; $i <= 5; $i++)
{
	$u = "USER ".$i;
	insertIntoDB($con, $u, "", "password");
	$_SESSION['usr'] = getUserData($u);
	$interests = rand(0, 504);
	$interests = $interests .",". rand(0, 504);
	$interests = $interests .",". rand(0, 504);
	$interests = $interests .",". rand(0, 504);
	$interests = $interests .",". rand(0, 504);
	updateProfileInfo($con, "test user", $interests, "none, i am fictional");
}

?>