<?php if ($_POST['register_submit']) {
	$first_name = $_POST['first_name'];
	$last_name = $_POST['last_name'];
	$email = $_POST['email'];
	$username = $_POST['username'];
	$password = $_POST['password'];
	$password2 = $_POST['password2'];
	$errors = array();

	//Check passwords match
	if ($password != $password2) {
		$errors[] = "Your passwords do not match";
	}
	//Check first name
	if (empty($first_name)) {
		$errors[] = "First Name is Required";
	}
	//Check email
	if (empty($email)) {
		$errors[] = "Email is Required";
	}
	//Check username
	if (empty($username)) {
		$errors[] = "Username is Required";
	}
	//Match passwords
	if (empty($password)) {
		$errors[] = "Password is Required";
	}


	//Instantiate Database object
	$database = new Database;

	/* Check to see if username has been used */

	//Query
	$database->query('SELECT username FROM users WHERE username = :username');
	$database->bind(':username', $username);
	//Execute
	$database->execute();
	if ($database->rowCount() > 0) {
		$errors[] = "Sorry, that username is taken";
	}

	/* Check to see if email has been used */

	//Query
	$database->query('SELECT email FROM users WHERE email = :email');
	$database->bind(':email', $email);
	//Execute
	$database->execute();
	if ($database->rowCount() > 0) {
		$errors[] = "Sorry, that email is taken";
	}

	//If there are no errors, proceed with registration
	if (empty($errors)) {
		//Encrypt Password
		$enc_password = md5($password);

		//Query
		$database->query('INSERT INTO users (first_name,last_name,email,username,password)
			              VALUES(:first_name,:last_name,:email,:username,:password)');
		//Bind Values
		$database->bind(':first_name', $first_name);
		$database->bind(':last_name', $last_name);
		$database->bind(':email', $email);
		$database->bind(':username', $username);
		$database->bind(':password', $enc_password);

		//Execute
		$database->execute();

		//If row was inserted
		if ($database->lastInsertId()) {
			echo '<div class="alert alert-success" role="alert"><p class="msg">You are now registered! Please Log In</p></div>';
		} else {
			echo '<div class="alert alert-danger" role="alert"><p class="error">Sorry, something went wrong. Contact the site admin</p></div>';
		}
	}
}
?>
<div class="card">
	<div class="card-body">

		<h3>Register</h3>
		<p>Please use the form below to register at our site</p>
		<?php
		if (!empty($errors)) {
			echo "<div class='alert alert-danger' role='alert'><ul>";
			foreach ($errors as $error) {
				echo "<li class=\"error\">" . $error . "</li>";
			}
			echo "</ul></div>";
		}
		?>
		<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post">
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label for="username">First Name</label>
						<input type="text" class="form-control" id="username" name="first_name" value="<?php if ($_POST['first_name']) echo $_POST['first_name'] ?>">
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label for="last_name">Last Name</label>
						<input type="text" class="form-control" id="last_name" name="last_name" value="<?php if ($_POST['first_name']) echo $_POST['last_name'] ?>">
					</div>
				</div>
				<div class="col-md-12">
					<div class="form-group">
						<label for="email">Email</label>
						<input type="email" class="form-control" id="email" name="email" value="<?php if ($_POST['email']) echo $_POST['email'] ?>">
					</div>
				</div>
				<div class="col-md-12">
					<div class="form-group">
						<label for="username">Username</label>
						<input type="text" class="form-control" id="username" name="username" value="<?php if ($_POST['username']) echo $_POST['username'] ?>">
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label for="password">Password</label>
						<input type="password" class="form-control" id="password" name="password" value="<?php if ($_POST['password']) echo $_POST['password'] ?>">
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label for="password2">Confirm Password</label>
						<input type="password" class="form-control" id="password2" name="password2" value="<?php if ($_POST['password2']) echo $_POST['password2'] ?>">
					</div>
				</div>
				<div class="col-md-12">
					<input type="submit" value="Register" name="register_submit" />

				</div>
			</div>
		</form>
	</div>
</div>