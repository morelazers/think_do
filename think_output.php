<?php

include 'header.php';
include 'functions_idea.php';
//include 'connect.php';

?>
<div class="clear"></div>
        <div id="post-container">
        	<div class="sidebar">
        		We've handpicked these ideas for you based on your interests!
        		<br>
        		:)
          	</div>
          <div class="mainRight">
                <?php think($con); ?>
            </div>
        </div>
    </div>
<?php include 'footer.php'; ?>
