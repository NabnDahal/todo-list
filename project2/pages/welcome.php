<h1 class="my-3">Welcome to myTasks!</h1>

<?php
if ($_SESSION['logged_in']) {
	//Instantiate Database object

	$database = new Database;

	//Get logged in user
	$list_user = $_SESSION['username'];

	//Query
	$database->query('SELECT * FROM lists WHERE list_user=:list_user');
	$database->bind(':list_user', $list_user);
	$rows = $database->resultset();
	echo '<div class ="container">';

	if ($rows) {
		echo '<h3 class="mb-3">Here are your current lists.</h4>';
		$i = 0;
?>
		<div class="row">
			<?php foreach ($rows as $list) : ?>

				<div class="col-md-3 col-sm-6 col-12">
					<div class="card">
						<div class="card-body">
							<h5 class="card-title"><?php echo $i = $i + 1 . '. ' . $list['list_name'] ?></h5>
							<h6 class="card-subtitle mb-2 text-muted"><?php echo $list['list_body'] ?></h6>
							<a href="?page=list&id=<?php echo $list['id'] ?>" class="btn btn-outline-info">View Details</a>
						</div>
					</div>
				</div>
			<?php endforeach ?>
		</div>
<?php
	} else {
		echo 'There are no lists available -<a href="index.php?page=new_list">Create One Now</a>';
	}
} else {
	echo "<p>myTasks is a small but helpful application where you can create and manage tasks to make your life easier. 
Just register and login and you can start adding tasks";
}
echo '</div>';
?>