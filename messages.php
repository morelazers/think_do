<?php 
	include 'header.php';
?>
    <div class="clear"></div>
        <div id="post-container">
            <div class="sidebar">
                <?php  ?>
            </div>
          <div class="mainRight">
            <?php 
            echo '<a href="message_send.php">Send a Message</a></br>';

            displayMessages(getAllMessages());

           ?>
            </div>
        </div>
    </div>
<?php include 'footer.php'; ?>