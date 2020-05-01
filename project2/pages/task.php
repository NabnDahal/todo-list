<?php
$task_id = $_GET['id'];

//Instantiate Database object
$database = new Database;
//Query
$database->query('SELECT *FROM tasks WHERE id = :id');
$database->bind(':id', $task_id);
$row = $database->single();

?>
<div class="container">
	<h1 class="text-info mb-3"><?php echo $row['task_name'] ?></h1>
	<h4>Tash Description</h4>
	<p><?php echo $row['task_body'] ?></p>
	<?php

	echo '<h3> Due date</h3>';
	echo '<p>' . $row['due_date'] . '</p>';

	if ($row['is_complete'] == 1) {
		echo 'Status: <strong>Complete</strong>';
	} else {
		echo 'Status: <strong>Incomplete</strong>';
	}
	?>
	<br />
	<br />
	<a href="?page=edit_task&id=<?php echo $row['id']; ?>" class="btn btn-primary">Edit Task</a>

</div>