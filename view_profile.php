 <?php
/*
 *  Will later hold methods to display the current user's profile details
 */
if(isset($_SESSION['usr']))
{
	displayProfile($_SESSION['usr']);
}
?>
