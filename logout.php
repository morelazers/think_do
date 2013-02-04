<?php
session_start();
                	if (isset($_SESSION['usr']))
                	{
                		unset($_SESSION['usr']);
                		session_destroy();
                	}
header('Location: index.php');
?>
