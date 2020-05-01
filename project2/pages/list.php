<?php
$list_id = $_GET['id'];

//Instantiate Database object
$database = new Database;
//Query
$database->query('SELECT * FROM lists WHERE id = :id');
$database->bind(':id', $list_id);
$row = $database->single();
?>
<div class="container">
	<?php
	echo '<h1 class="text-info">' . $row['list_name'] . '</h1>';
	echo '<p>' . $row['list_body'] . '</p>';
	echo '<a href="?page=edit_list&id=' . $row['id'] . '" class="btn btn-warning">Edit List</a> ';
	echo '<a href="?page=delete_list&id=' . $row['id'] . '" class="btn btn-danger">Delete List</a>';


	//Instantiate Database object
	$database = new Database;
	//Query
	$database->query('SELECT* FROM tasks WHERE list_id = :list_id ');
	$database->bind(':list_id', $list_id);
	$rows = $database->resultset();

	echo '<h3>Tasks</h3>';

	if ($rows) {
		echo '<ul class="list-group" style="width:400px">';
		foreach ($rows as $task) {
			if ($task['is_complete'] == 1) {
				echo '<li class="list-group-item"><a href="?page=task&id=' . $task['id'] . '">' . $task['task_name'] . '</a> <span class="badge badge-success">Completed</span> </li>';
			} else {
				echo '<li class="list-group-item"><a href="?page=task&id=' . $task['id'] . '">' . $task['task_name'] . '</a></li>';
			}
		}
		echo '</ul>';
	} else {
		echo 'No tasks for this list-<a href="index.php?page=new_task&listid=' . $_GET['id'] . '">Create One Now</a>';
	}
	?>
</div>