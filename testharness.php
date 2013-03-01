<?php session_start();

include 'connect.php';
include 'functions_user.php';
include 'functions_idea.php';
include 'functions_input.php';

$i = 0;
for ($i; $i < 5; $i++)
{
	$n = "USER".$i;
	$e = "e";
	$p = "password";
	insertIntoDB($con, $n, $e, $p);
	$_SESSION['usr'] = getUserData($con, $n);
	$interests = rand(0, 504);
	$interests = $interests .",". rand(0, 504);
	$interests = $interests .",". rand(0, 504);
	$interests = $interests .",". rand(0, 504);
	$interests = $interests .",". rand(0, 504);
	echo "<br>";
	var_dump($interests);
	echo '<br>';
	updateProfileInfo($con, "test user", $interests, "none, i am fictional");
	echo $i;
	echo "<br>";
	//unset($_SESSION['usr']);
    //session_destroy();
}
echo 'ok';

?>
