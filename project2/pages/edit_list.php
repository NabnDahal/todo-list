<?php
if ($_POST['submit']) {
	$list_id = $_GET['id'];
	$list_name = $_POST['list_name'];
	$list_body = $_POST['list_body'];

	//Instantiate Database object
	$database = new Database;

	//query
	$database->query('UPDATE lists SET list_name = :list_name,list_body = :list_body WHERE id = :id');
	$database->bind(':list_name', $list_name);
	$database->bind(':list_body', $list_body);
	$database->bind(':id', $list_id);
	$database->execute();

	if ($database->rowCount()) {
		echo '<p class="msg">your list has been updated</p>';
	}
}
?>
<?php
$list_id = $_GET['id'];

//Instantiate Database object
$database = new Database;
//Query
$database->query('SELECT * FROM lists WHERE id = :id');
$database->bind(':id', $list_id);
$row = $database->single();
?>


<h1>Edit List</h1>

<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post">
	<div class="row">
		<div class="col-md-6">
			<div class="row">
				<div class="col-12">
					<div class="form-group">
						<label for="username">Task name</label>
						<input type="text" class="form-control" id="username" name="list_name" value="<?php echo $row['list_name']; ?>">
					</div>
				</div>
				<div class="col-12">
					<div class="form-group">
						<label for="username">Task Body</label>
						<textarea rows="5" class="form-control" cols="50" name="list_body"><?php echo $row['list_body']; ?></textarea>
					</div>
				</div>
				<div class="col-12">
					<input class="btn btn-primary" type="submit" value="Update" name="submit" />
				</div>
			</div>
		</div>
	</div>
</form>