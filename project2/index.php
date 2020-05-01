<?php
//Start Session
session_start();
//Config File
require 'config.php';
//Database Class
require 'classes/database.php';

$database = new Database;

//Set Timezone
date_default_timezone_set('America/New_York');
?>

<?php
//LOG IN
if ($_POST['login_submit']) {
  $username = $_POST['username'];
  $password = $_POST['password'];
  $enc_password = md5($password);
  //Query
  $database->query("SELECT * FROM users WHERE username = :username AND password = :password");
  $database->bind(':username', $username);
  $database->bind(':password', $enc_password);
  $rows = $database->resultset();
  $count = count($rows);
  if ($count > 0) {
    session_start();
    //Assign session variables
    $_SESSION['username']   = $username;
    $_SESSION['password']   = $password;
    $_SESSION['logged_in']  = 1;
  } else {
    $login_msg[] = 'Sorry, that login does not work';
  }
}


//LOG OUT
if ($_POST['logout_submit']) {
  if (isset($_SESSION['username']))
    unset($_SESSION['username']);
  if (isset($_SESSION['password']))
    unset($_SESSION['password']);
  if (isset($_SESSION['logged_in']))
    unset($_SESSION['logged_in']);
  session_destroy();
}
?>

<!DOCTYPE html>

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <a href="index.php">
    <title>myTasks Application</title>
  </a>
  <link href="css/bootstrap.css" rel="stylesheet">
  <link href="css/bootstrap-grid.min.css" rel="stylesheet">
  <link href="css/bootstrap-reboot.min.css" rel="stylesheet">
  <link href="css/custom.css" rel="stylesheet">
</head>

<body>
  <script src="js/site.js"></script>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="index.php">My Tasks</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">
        <?php if ($_SESSION['logged_in']) : ?>
          <li class="nav-item active">
            <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="index.php?page=new_list">Add List</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="index.php?page=new_task">Add Task</a>
          </li>
        <?php endif; ?>
      </ul>

      <div class="form-inline my-2 my-lg-0">
        <?php if ($_SESSION['logged_in']) : ?>
          <p class="text-white my-auto mr-3">Hello, <?php echo $_SESSION['username']; ?></p>
          <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post">
            <input type="submit" class="btn btn-outline-success" value="Logout" name="logout_submit" />
          </form>
          <!-- <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Logout</button> -->
        <?php else : ?>
          <p class="text-white my-auto mr-3">User not logged in!</p>
          <a href="index.php?page=register" class="btn btn-outline-warning my-2 my-sm-0">Register</a>
        <?php endif; ?>
      </div>
    </div>
  </nav>

  <div class="container-fluid mt-3">
    <div class="row">
      <?php if (!$_SESSION['logged_in']) : ?>
        <div class="col-md-3">
          <div class="card">
            <div class="card-body">
              <h3>Login Form</h3>
              <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post">
                <?php foreach ($login_msg as $msg) : ?>
                  <?php echo $msg . '<br />'; ?>
                <?php endforeach; ?>
                <div class="form-group">
                  <label for="username">Email address</label>
                  <input type="text" class="form-control" id="username" name="username">
                </div>
                <div class="form-group">
                  <label for="password">Email address</label>
                  <input type="password" class="form-control" id="password" name="password">
                </div>
                <input type="submit" class="btn btn-primary" value="Login" name="login_submit" />
              </form>
            </div>
          </div>
        </div>
        <div class="col-md-9">
        <?php else : ?>
          <div class="col-md-12">
          <?php endif; ?>
          <?php
          if ($_GET['msg'] == 'listdeleted') {
            echo '<p class="msg">Your list has been deleted</p>';
          }
          if ($_GET['page'] == 'welcome' || $_GET['page'] == '') {
            include 'pages/welcome.php';
          } elseif ($_GET['page'] == 'list') {
            include 'pages/list.php';
          } elseif ($_GET['page'] == 'task') {
            include 'pages/task.php';
          } elseif ($_GET['page'] == 'new_task') {
            include 'pages/new_task.php';
          } elseif ($_GET['page'] == 'new_list') {
            include 'pages/new_list.php';
          } elseif ($_GET['page'] == 'edit_task') {
            include 'pages/edit_task.php';
          } elseif ($_GET['page'] == 'edit_list') {
            include 'pages/edit_list.php';
          } elseif ($_GET['page'] == 'register') {
            include 'pages/register.php';
          } elseif ($_GET['page'] == 'delete_list') {
            include 'pages/delete_list.php';
          }
          ?>
          </div>
        </div>


        <footer class="container-fluid">
          <hr>
          <p>Nabin Dahal @9862048265</p>
        </footer>
    </div>
    <!--/.fluid-container-->
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.bundle.js"></script>
</body>

</html>