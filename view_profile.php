 <?php
 
 include 'connect.php';
 include 'functions_user.php';
 include 'functions_idea.php';
/*
 *  Will later hold methods to display any user's profile details, at the moment it is restricted to the logged-in user
 */
if(isset($_SESSION['usr']))
{
	displayProfile($_SESSION['usr']);
}

if(array_key_exists("user", $_GET))
{
	$u = $_GET["user"];
	displayProfile($u);
}

?>
