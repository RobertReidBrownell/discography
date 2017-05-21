<?php
include './includes/title.php';
require_once './includes/connection.php';
require_once './includes/non_session.php';
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

    <main role="main">
      <h2>Cite</h2>
	  <ul class="citelinks">
	  	<li><a href=" http://owtk.com/2014/10/5-reasons-you-should-listen-new-jukebox-the-ghost-album-with-kids/
">Out With the Kids (info page image)</a></li>
		<li><a href="http://www.jukeboxtheghost.com/
">Jukebox The Ghost (logo)</a></li>
		<li><a href="https://www.amazon.com/">Amazon (Album art images)</a></li>
	  </ul>

    </main>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>

    <script src="js/app.js"></script>
  </body>
</html>
