<?php session_start();

include 'connect.php';
include 'functions_user.php';
include 'functions_idea.php';
include 'functions_input.php';

$i = 0;
for ($i; $i < 5; $i++)
{
	echo $i;
	echo "<br>";
	$n = "USER".$i;
	echo $n;
	echo "<br>";
	$e = "e";
	echo $e;
	echo "<br>";
	$p = "password";
	echo $p;
	echo "<br>";
	insertIntoDB($con, $n, $e, $p);

	$_SESSION['usr'] = getUserData($con, $n);
	//echo $_SESSION['usr']['username'];
	echo "<br>";
	$interests = rand(0, 504);
	$interests = $interests .",". rand(0, 504);
	$interests = $interests .",". rand(0, 504);
	$interests = $interests .",". rand(0, 504);
	$interests = $interests .",". rand(0, 504);
	//echo "<br>";
	//var_dump($interests);
	//echo '<br>';
	updateProfileInfo($con, "test user", $interests, "none, i am fictional");
	echo "<br>";
	sleep(3);
	//unset($_SESSION['usr']);
    //session_destroy();
}
echo 'ok';

?>
