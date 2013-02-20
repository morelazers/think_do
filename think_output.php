<?php

include 'header.php';
include 'functions_think.php';
include 'connect.php';

?>
<div class="clear"></div>
        <div id="post-container">
          <div class="post">
                <?php think($con); ?>
            </div>
        </div>
    </div>
<?php include 'footer.php'; ?>
