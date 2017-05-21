<?php
include './includes/title.php';
if (isset($_POST['register'])) {
  $username = trim($_POST['username']);
  $password = trim($_POST['pwd']);
  $retyped = trim($_POST['conf_pwd']);
  //$userfile = '/Users/reidbrownell/private/encrypted.csv';
  require_once '../includes/register_user_mysqli.php';
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
<body class="infoPage">
  <div class="row">
  <?php
    $file =  './includes/headernav.php';
    if (file_exists($file) && is_readable($file)) {
        require $file;
    } else {
        throw new Exception("$file can't be found");
    }
  ?>
</div><!--row 1-->
<div id="wrapper">
    <main>
      <h2 class="thankYou">Thank You</h2>
      <form class="inputForm">
        <p>You have signed up for our newsletter. We appreciate your support, and wouldn't be where we are today without fans like you.</p>
        <p>We hope you'll continue to enjoy our website and hope to see you again.</p>
        </form>
</div>
</body>
</html>
