<h1>Welcome to myTasks!</h1>

<?php
if($_SESSION['logged_in']){
//Instantiate Database object

$database = new Database;

//Get logged in user
$list_user = $_SESSION['username'];

//Query
$database->query('SELECT * FROM lists WHERE list_user=:list_user');
$database->bind(':list_user',$list_user);
$rows = $database->resultset();
echo'<div class="card" style="width: 18rem;">';
echo '<h4 class="card-title">Here are your current lists</h4><br />';

if($rows){
echo '<ol class="list-group list-group-flush">';
foreach($rows as $list){
    echo '<li class="list-group-item"><a href="?page=list&id='.$list['id'].'">'.$list['list_name'].'</a></li>';

	echo '<li><a href="?page=list&id='.$list['id'].'">'.$list['list_name'].'</a></li>';
}
	echo '</ol>';
} else {
	echo 'There are no lists available -<a href="index.php?page=new_list">Create One Now</a>';
}	
} else {
	echo "<p>myTasks is a small but helpful application where you can create and manage tasks to make your life easier. 
Just register and login and you can start adding tasks";
}
echo '</div>';
?>