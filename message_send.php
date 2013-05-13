<?php session_start();

    if(!isset($_SESSION['usr'])){
        header("Location: login.php");
    }
    
	include 'header.php';
?>
    <div class="clear"></div>
        <div id="post-container">
            <div class="sidebar">
                <h1>Recipient:</h1>
                Type in the username of whoever you want to send the message to.<br><br>
                <h1>Subject:</h1>
                Give your message a subject!<br><br>
                <h1>Content:</h1>
                Write the body of your message.<br><br>
                <br><br><br>
                All of these fields need to be filled in before we can send your message.
            </div>
          <div class="mainRight">
            <?php include 'message_send_form.php'; ?>
            </div>
        </div>
    </div>
<?php include 'footer.php'; ?>