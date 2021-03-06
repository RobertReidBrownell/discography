<?php
include 'title.php';
require_once 'connection.php';
$error = '';
require_once 'non_session.php';
if (isset($_POST['login'])) {
    session_start();
    $username = trim($_POST['username']);
    $password = trim($_POST['pwd']);
    require_once 'authenticate_mysqli.php';
}
// run this script only if the logout button has been clicked
require_once 'logout.php';
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Discography<?php if (isset($title)) {echo "&#8212;{$title}";} ?></title>
    <style>
    @import url('https://fonts.googleapis.com/css?family=Amatica+SC:400,700|Overpass:200');
    </style>
      <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
      <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
      <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
      <![endif]-->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/styles.css">
  </head>
  <body class="infoPage">
    <div class="row">
      <?php
        if (file_exists($file) && is_readable($file)) {
            require $file;
        } else {
            throw new Exception("$file can't be found");
        }
      ?>
	</div><!--row 1-->
  <main>
  <div class="row">
    <h2 class="login">Login</h2>
  <form class="inputForm" method="post" action="login.php">
    <?php if ($error) {
        echo "<p class=\"warning\">$error</p>";
    } elseif (isset($_GET['expired'])) {
        ?>
        <p class="warning">Your session has expired. Please log in again.</p>
    <?php } ?>
      <p>
          <label for="username">Username:</label>
          <input type="text" name="username" id="username">
      </p>
      <p>
          <label for="pwd">Password:</label>
          <input type="password" name="pwd" id="pwd">
      </p>
      <p>
          <input class="formSubmit" name="login" type="submit" id="login" value="Log in">
          <a href="register.php" class="registration">Register new account</a>
      </p>
  </form>
</div><!-- row 2-->
</main>
</body>
</html>
