<?php

$tasks = getIdeaTasks($idea);
displayTasks($tasks);

include 'task_form.php';

?>