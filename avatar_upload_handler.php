<?php

	session_start();

	include 'connect.php';
    include 'functions_user.php';

	//mkdir('www/test',0777,true);
	
	$allowedExts = array("jpg", "jpeg", "gif", "png");
	$extension = end(explode(".", $_FILES["file"]["name"]));
	if ((($_FILES["file"]["type"] == "image/gif")
	|| ($_FILES["file"]["type"] == "image/jpeg")
	|| ($_FILES["file"]["type"] == "image/png")
	|| ($_FILES["file"]["type"] == "image/pjpeg"))
	&& ($_FILES["file"]["size"] < 2000000)
	&& in_array($extension, $allowedExts))
	{
		if ($_FILES["file"]["error"] > 0)
		{
			echo "<div class=fileUploadError>Error: " . $_FILES["file"]["error"] . "<br></div>";
		}
		else
		{
			//echo "Upload: " . $_FILES["file"]["name"] . "<br>";
			//echo "Type: " . $_FILES["file"]["type"] . "<br>";
			//echo "Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
			
			$dirToStoreIn = "/home/moarlazers/dev.thinkshare.it/avatars/".$_SESSION['usr']['username']."/";
			
			$dirExists = is_dir($dirToStoreIn);
			//var_dump($dirExists);
			
			//echo dirname( __FILE__ );
			
			if(!$dirExists)
			{
			   	if(!mkdir($dirToStoreIn))
			   	{
			   		echo '<div class="ftpError">Error creating directory!</div>';
			   		die();
			   	}
			   	//var_dump($success);
			}
			
			//echo "Stored in: " . $_FILES["file"]["tmp_name"];

			//$_FILES["file"]["name"] = "avatar.jpg";

			//NEED SOMETHING HERE TO HANDLE IF THE FILE ALREADY EXISTS. NEED A DEFAULT NAME.
	
			if (file_exists($dirToStoreIn . $_FILES["file"]["name"]))
	      	{
	      		header("Location: modify_profile.php#tabs-2");
	     	}
	    	else
	      	{
	      		$dirToStoreIn = $dirToStoreIn . basename($_FILES["file"]["name"]);
			    if (move_uploaded_file($_FILES["file"]["tmp_name"],
			    $dirToStoreIn))
			    {
                			//"/upload/".$u['username']."/".basename($_FILES["file"]["name"]);
			   		$sqlDir = "/avatars/".$_SESSION['usr']['username']."/".basename($_FILES["file"]["name"]);
			   		$sql = "UPDATE user SET avatarLocation = '".$sqlDir."' WHERE userID =".$_SESSION['usr']['userID'];
			   		//var_dump($sql);
			   		mysql_query($sql, $con) or die(mysql_error());
			   		$_SESSION['usr'] = getUserData($con, $_SESSION['usr']['username']);
			   		header("Location: modify_profile.php#tabs-2");
			    }
			    else
			    {
			   		echo '<div class="ftpError">Error moving the file to the correct directory!</div>';
			   		die();
			    }
			   
			    //$dirToStoreIn = "upload/".$u['username'];
			    //echo "Stored in: " . $dirToStoreIn;
		      }
		}
	}
	else
	{
		echo "<h2>Invalid file</h2>";
	}

?>