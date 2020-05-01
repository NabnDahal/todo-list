<?php
if ($_POST['submit']) {
	$task_id = $_GET['id'];
	$task_name = $_POST['task_name'];
	$task_body = $_POST['task_body'];
	$due_date = $_POST['due_date'];
	$list_id = $_POST['list_id'];
	$is_complete = $_POST['is_complete'];

	//Instantiate Database object
	$database = new Database;

	$database->query('UPDATE tasks SET task_name=:task_name,task_body=:task_body,due_date=:due_date,list_id=:list_id,is_complete=:is_complete WHERE id=:id');
	$database->bind(':task_name', $task_name);
	$database->bind(':task_body', $task_body);
	$database->bind(':due_date', $due_date);
	$database->bind(':list_id', $list_id);
	$database->bind(':id', $task_id);
	$database->bind(':is_complete', $is_complete);
	$database->execute();
	if ($database->rowCount()) {
		echo '<p class="msg">Your task has been updated</p>';
	}
}
?>
<?php
//Instantiate Database object
$database = new Database;
//Query
$database->query('SELECT * FROM lists');
$rows = $database->resultset();
?>
<?php
$task_id = $_GET['id'];

//Instantiate Database object
$database = new Database;
//Query
$database->query('SELECT * FROM tasks WHERE id = :id');
$database->bind(':id', $task_id);
$row = $database->single();
?>
<div class="container">
	<h1>Edit Task</h1>
	<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post">
		<div class="row">
			<div class="col-md-6">
				<div class="row">
					<div class="col-12">
						<div class="form-group">
							<label for="username">Task name</label>
							<input type="text" class="form-control" id="username" name="task_name" value="<?php echo $row['task_name']; ?>">
						</div>
					</div>
					<div class="col-12">
						<div class="form-group">
							<label for="username">Task Body</label>
							<textarea rows="5" class="form-control" cols="50" name="task_body"><?php echo $row['task_body']; ?></textarea><br />
						</div>
					</div>
					<div class="col-12">
						<div class="form-group">
							<label for="username">Due Date</label>
							<input type='date' class="form-control" name='due_date' value="<?php echo date($row['due_date']); ?>" />
						</div>
					</div>
					<div class="col-12">
						<div class="form-group">
							<label for="username">List</label>
							<select class="custom-select" name="list_id">
								<option value="" selected hidden>--Select List--</option>
								<?php foreach ($rows as $list) : ?>
									<option value="<?php echo $list['id']; ?>" <?php echo $list['id'] == $list_id ?  'selected' : null ?>>
										<?php echo $list['list_name']; ?></option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>
					<div class="col-12">
						Mark if Completed <input type="checkbox" name="is_complete" value="1" <?php echo $is_complete == 1 ?  'checked' : null ?> />
					</div>
					<div class="col-12">
						<input type="submit" class="btn btn-primary" value="Update" name="submit" />
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<img class="w-100" style="opacity: .5" src="https://pngimage.net/wp-content/uploads/2018/06/tasks-png-6.png" alt="" srcset="">
			</div>
		</div>

	</form>
</div>