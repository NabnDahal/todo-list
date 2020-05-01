<?php
if ($_POST['task_submit']) {
	$task_name = $_POST['task_name'];
	$task_body = $_POST['task_body'];
	$due_date = $_POST['due_date'];
	$list_id = $_POST['list_id'];

	//Instantiate Database object
	$database = new Database;

	$database->query('INSERT INTO tasks (task_name,task_body,due_date,list_id) VALUES(:task_name,:task_body,:due_date,:list_id)');
	$database->bind(':task_name', $task_name);
	$database->bind(':task_body', $task_body);
	$database->bind(':due_date', $due_date);
	$database->bind(':list_id', $list_id);
	$database->execute();
	if ($database->lastInsertId()) {
		echo '<p class="msg">Your task has been created</p>';
	}
}

?>

<?php
//Instantiate Database object
$database = new Database;

//Get logged in user
$list_user = $_SESSION['username'];

//Query
$database->query('SELECT * FROM lists WHERE list_user = :list_user');
$database->bind(':list_user', $list_user);
$rows = $database->resultset();
?>


<h1>Add a Task</h1>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post">
	<div class="row">
		<div class="col-md-6">
			<div class="card">
				<div class="card-body">
					<div class="row">
						<div class="col-12">
							<div class="form-group">
								<label for="username">Task name</label>
								<input type="text" class="form-control" id="username" name="task_name">
							</div>
						</div>
						<div class="col-12">
							<div class="form-group">
								<label for="username">List</label>
								<select class="custom-select" name="list_id">
									<option value="" selected hidden>--Select List--</option>
									<?php foreach ($rows as $list) : ?>
										<option value="<?php echo $list['id']; ?>">
											<?php echo $list['list_name']; ?></option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>
						<div class="col-12">
							<div class="form-group">
								<label for="username">Task Body</label>
								<textarea rows="5" class="form-control" cols="50" name="task_body"></textarea><br />
							</div>
						</div>
						<div class="col-12">
							<div class="form-group">
								<label for="username">Due Date</label>
								<input type='date' class="form-control" name='due_date' />
							</div>
						</div>
						<div class="col-12">
							<input type="submit" class="btn btn-primary" value="Create" name="task_submit" />
						</div>
					</div>
				</div>
			</div>

		</div>
		<div class="col-md-6">
			<img class="w-100" style="opacity: .5" src="https://pngimage.net/wp-content/uploads/2018/06/tasks-png-6.png" alt="" srcset="">
		</div>
	</div>
</form>