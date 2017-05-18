<?php
include './includes/title.php';
require_once './includes/connection.php';
// create the database connection
$conn = dbConnect('read');
//create sql for album name and image
$sql = "SELECT image_filename, album_name FROM album ORDER BY year_released DESC";
// submit the query
$album = $conn->query($sql);
if (!$album) {
    $error = $conn->error;
} else {
    // extract the first record as an array
    $line = $album->fetch_assoc();
    // get the name for the main image
    if (isset($_GET['image'])) {
        $mainImage = $_GET['image'];
    } else {
        $mainImage = $line['image_filename'];
    }

    $caption = $line['album_name'];
    $activeAlbum = $mainImage;
  }
// create sql query to get track names
$getTrackList = "SELECT album.album_id, album_name, image_filename, track_name, year_released
                 FROM album LEFT OUTER JOIN tracks
                 ON album.album_id = tracks.album_id
                 WHERE image_filename = '$activeAlbum'";
// submit the query
$trackList = $conn->query($getTrackList);
if (!$trackList) {
    $error = $conn->error;
} else {
// extract the first row as an array
    $row = $trackList->fetch_assoc();
}
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
  <body>
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
	<main role="main">
	  <div class="row">
		  <div class="col-sm-4">
				<nav class="albumList">
           <?php if (isset($error)) {
                    echo "<p>$error</p>";
            } else { ?>
             <ul>
               <?php do { ?>
                <li><a href="<?= $_SERVER['PHP_SELF'];?>?image=<?=$line['image_filename']; ?>"><?= $line['album_name'] ?></a></li>
            <?php } while ($line = $album->fetch_assoc()); ?>
             </ul>
            <?php } ?>
					</nav>
  			</div><!--column 1-->
		<div class="col-sm-8">
      <figure id="main_image" class="album">
          <img src="img/albumart/<?= $mainImage; ?>" alt="<?= $caption; ?>" >
           <ul class="songList">
           <?php do { ?>
                    <li><?= $row['track_name']; ?></li>
          <?php } while ($row = $trackList->fetch_assoc());  ?>
          </ul><!--song list-->
      </figure>
  	    </div><!--column 2-->
	</div><!--row 2-->
</main>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
  <!--  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed-->
    <script src="js/bootstrap.min.js"></script>
    <script src="js/app.js"></script>
  </body>
</html>
