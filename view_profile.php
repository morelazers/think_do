 <?php
/*
 *  Will later hold methods to display any user's profile details, at the moment it is restricted to the logged-in user
 */
if(isset($_SESSION['usr']))
{
	displayProfile($_SESSION['usr']);
}
?>
