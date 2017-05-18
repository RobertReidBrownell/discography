<?php
include './includes/title.php';
if (isset($_POST['register'])) {
  $username = trim($_POST['username']);
  $password = trim($_POST['pwd']);
  $retyped = trim($_POST['conf_pwd']);
  //$userfile = '/Users/reidbrownell/private/encrypted.csv';
  require_once './includes/register_user_mysqli.php';
}
?>
<!DOCTYPE HTML>
<html>
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

<body>
<header>
  <div class="row">
  <?php
    $file =  './includes/headernav.php';
    if (file_exists($file) && is_readable($file)) {
        require $file;
    } else {
        throw new Exception("$file can't be found");
    }
  ?>
</div><!--row 1--></header>
    <h1>Japan Journey </h1>
</header>
<div id="wrapper">
    <main>
        <h2 class="login">Register for a user account</h2>

        <form method="post" action="" >
          <?php
          if (isset($result) || isset($errors)) {
            echo '<ul class="warning">';
            if (!empty($errors)) {
                foreach ($errors as $item) {
                  echo "<li>$item</li>";
                }
            } else {
                echo "<li>$result</li>";
            }
            echo '</ul>';
          }
          ?>
            <p>
                <label for="username">Username:</label>
                <input type="text" name="username" id="username">
            </p>
            <p>
                <label for="pwd">Password:</label>
                <input type="password" name="pwd" id="pwd">
            </p>
            <p>
                <label for="conf_pwd">Retype Password:</label>
                <input type="password" name="conf_pwd" id="conf_pwd">
            </p>

            <p id="newsletter">Have you signed up for our newsletter?<br>
                <input type="radio" name="signedup" id="yes">
                <label for="yes">yes</label>
                <input type="radio" name="signedup" id="no">
                <label for="no">no</label>
            </p>
            <p class="optional">
                <label for="email">Enter the email you signed up with:</label>
                <input type="email" name="email" id="email">
            </p>
            <p class="optional">
                <span id="getMoreInfo"><a href="info.php">Get our newsletter!</a></span>

            </p>
            <p>
                <input type="submit" name="register" value="Register">
            </p>
        </form>
    </main>

</div>
<script src="js/toggle_fields.js"></script>
</body>
</html>
