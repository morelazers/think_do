<?php session_start();

    if(!isset($_SESSION['usr'])){
        header("Location: login.php");
    }
	include 'header.php';
?>
    <div class="clear"></div>
        <div id="post-container">
            <div class="sidebar">
                From here you can see all the messages that other people have sent to you!<br><br>
                You can also send a message to someone by clicking the link below!<br><br><br>
                <a class="messageButton" href="message_send.php">Send a Message</a>
            </div>
          <div class="mainRight">
          <br>
            <?php 

            displayMessages(getAllMessages());

           ?>
            </div>
        </div>
    </div>
<?php include 'footer.php'; ?>