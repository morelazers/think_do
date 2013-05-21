<?php

function sendMessage($toUser, $subject, $message)
{
	$now = date("Y-m-d H:i:s");
	$sql = "INSERT INTO messages (fromUser, toUser, subject, content, msgDate, msgRead) 
	VALUES ('".$_SESSION['usr']['username']."', '".$toUser."', '".$subject."', '".$message."', '".$now."', 0)";
	mysql_query($sql) or die(mysql_error());
}

function checkForNewMessages()
{
	$count = 0;
	$sql = "SELECT * FROM messages WHERE toUser='".$_SESSION['usr']['username']."' AND msgRead=0";
	$res = mysql_query($sql) or die(mysql_error());
	$count = 0;
	while($newMsgs = mysql_fetch_array($res))
	{
		$count++;
	}
	return $count;
}

function getAllMessages()
{
	$sql = "SELECT * FROM messages WHERE toUser='".$_SESSION['usr']['username']."' ORDER BY msgDate DESC";
	$res = mysql_query($sql) or die(mysql_error());
	//var_dump($sql);
	return $res;
}

function displayMessages($resultSet)
{
	$count = 0;
	//Create a table and output the messages
	while($msgArray = mysql_fetch_array($resultSet))
	{
		//var_dump($msgArray);
		$from = $msgArray['fromUser'];
		$subject = $msgArray['subject'];
		$content = $msgArray['content'];
        //var_dump($msgArray['msgDate']);
		$dateSent = $msgArray['msgDate'];
		//$dateSent = date("d m Y", $dateSent);
		$read = $msgArray['msgRead'];
		echo "From: <a href='profile.php?user=".$from."'>".$from."</a><br>";
		echo "Subject: ".$subject."<br><br>";
		echo $content."<br><br>";
		echo "Sent: ".$dateSent."<br>";
        echo "<a href='message_send.php?user=".$from."'>Reply</a><br><br><br><br>";
		$sql = "UPDATE messages SET msgRead=1 WHERE messageID=".$msgArray['messageID'];
		mysql_query($sql) or die(mysql_error()); 
		$count++;
	}
	if($count == 0)
	{
		echo '<h2>There seem to be no messages here!<br><br></h2>';
	}
}

?>
