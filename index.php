<?php
include './includes/title.php';
require_once './includes/connection.php';
// create the database connection
$conn = dbConnect('read');
$testing = 3;
// create sql to get track names
$getTrackList = "SELECT album.album_id, album_name, image_filename, track_name, year_released
                 FROM album LEFT OUTER JOIN tracks
                 ON album.album_id = tracks.album_id
                 WHERE tracks.album_id = $testing
                 ORDER BY year_released" ;
// submit the query
$trackList = $conn->query($getTrackList);
if (!$trackList) {
    $error = $conn->error;
} else {
    // extract the first row as an array
    $row = $trackList->fetch_assoc();
    // get the name for the main Album
    if (isset($_GET['image'])) {
        $activeAlbum = $_GET['image'];
    } else {
        $activeAlbum = $row['image_filename'];
        $activeName = $row['album_name'];
        $activeId = $row['album_id'];
    }
    if (file_exists('img/albumart/'.$activeAlbum)) {
        $albumArt = 'Still finding the file' ;
  } else {
        $error = 'Image not found.';
  }
}
//create sql for album name and image
$sql  = 'SELECT album_id, album_name, image_filename
         FROM album
         ORDER BY year_released';
// submit the query
$album = $conn->query($sql);
if (!$album) {
    $error = $conn->error;
} else {
    $line = $album->fetch_assoc();
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
                 <li><a href="<?=$_SERVER['PHP_SELF'];?>?album_id=<?=$line['image_filename'];?>"><?=$line['album_name'];?></a></li>
            <?php } while ($line = $album->fetch_assoc()); ?>
             </ul>
            <?php } ?>
					</nav>
  			</div><!--column 1-->
		<div class="col-sm-8">
  	        <section class="album">
  	          <h2 class="albumTitle"><?=$activeName; ?></h2>
  	          <img src="img/albumart/<?= $activeAlbum; ?>" alt="">
  	          <ul class="songList">
               <?php do { ?>
                        <li><?= $row['track_name']; ?></li>
              <?php } while ($row = $trackList->fetch_assoc());  ?>

  	          </ul><!--song list-->
              <pre>
                <?php echo $albumArt; ?>
              </pre>
  	    </div><!--column 2-->
	</div><!--row 2-->
</main>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
    <script src="js/app.js"></script>
  </body>
</html>
