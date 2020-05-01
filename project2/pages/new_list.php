<?php

if ($_POST['submit']) {
	$list_name = $_POST['list_name'];
	$list_body = $_POST['list_body'];
	$list_user = $_SESSION['username'];

	//Instantiate database object
	$database = new Database;

	$database->query('INSERT INTO lists(list_name,list_body,list_user)
							VALUES(:list_name,:list_body,:list_user)');
	$database->bind(':list_name', $list_name);
	$database->bind(':list_body', $list_body);
	$database->bind(':list_user', $list_user);
	$database->execute();

	if ($database->LastInsertId()) {
		echo '<p class="msg">Your list has been created</p>';
	}
}

?>



<h1>Add a List</h1>

<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post">
	<div class="row">
		<div class="col-md-6">
			<div class="card">
				<div class="card-body">
					<div class="row">
						<div class="col-12">
							<div class="form-group">
								<label for="username">Task name</label>
								<input type="text" class="form-control" id="username" name="list_name">
							</div>
						</div>
						<div class="col-12">
							<div class="form-group">
								<label for="username">Task Body</label>
								<textarea rows="5" class="form-control" cols="50" name="list_body"></textarea>
							</div>
						</div>
						<div class="col-12">
							<input class="btn btn-primary" type="submit" value="Create" name="submit" />
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</form>