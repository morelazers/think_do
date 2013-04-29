<?php

function sendMessage($toUser, $subject, $message)
{
	$now = date("Y-m-d H:i:s");
	$sql = "INSERT INTO messages (fromUser, toUser, subject, content, msgDate) 
	VALUES ('".$_SESSION['usr']['username']."', '".$toUser."', '".$subject."', '".$message."', '".$now."')";
	mysql_query($sql) or die(mysql_error());
}

function checkForNewMessages()
{
	$count = 0;
	$sql = "SELECT * FROM messages WHERE toUser='".$_SESSION['usr']."' AND msgRead=0";
	$res = mysql_query($sql) or die(mysql_error());
	$newMsgs = mysql_fetch_array($res);
	if($newMsgs != NULL)
	{
		$count = 1;
		while(mysql_fetch_array($res))
		{
			$count++;
		}
	}
	return $count;
}

function getAllMessages()
{
	$sql = "SELECT * FROM messages WHERE toUser='".$_SESSION['usr']."'";
	$res = mysql_query($sql) or die(mysql_error());
	return $res;
}

function displayMessages($resultSet)
{
	while(mysql_fetch_array($resultSet))
	{
		//display messages
	}
}

?>
