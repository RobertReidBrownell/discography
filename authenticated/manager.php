<?php
include 'title.php';
require_once 'connection.php';
require_once 'a_session_timeout.php';

use Discography\File\Upload;
// set the maximum upload size in bytes
$max = 100000;
// create database connections
$conn = dbConnect('write');
if (isset($_POST['insert'])) {
    if ((is_numeric($_POST['year'])) && (($_POST['year']) > 1000) && (($_POST['year']) < 3000)) {
    // initialize flag
    $OK = false;
    $stmt = $conn->stmt_init();
    // move the file to the upload folder and rename it
    require_once '../Discography/File/Upload.php';
    $albumOK = false;
    $loader = new Upload("../img/albumart/");
    $loader->setMaxSize($max);
    $loader->allowAllTypes();
    $loader->upload();
    $name = $loader->getFilenames();
    // $name will be an empty array if the upload failed
    if ($name) {
      $sql = 'INSERT INTO album (album_name, year_released, artist_id, image_filename) VALUES (?, ?, ?, ?)';
      if ($stmt->prepare($sql)) {
          $stmt->bind_param('siis', $_POST['album'], $_POST['year'], $_POST['artistId'], $name[0]);
          $stmt->execute();
          $albumOK = $stmt->affected_rows;
          }
        }
        if ($albumOK > 0) {
          // get the albums primary key
          if (isset($_POST['trackName'])) {
              $album_id = $stmt->insert_id;
              $track_order = 1;
              foreach ($_POST['trackName'] as $track_name) {
                      $values[] = "($track_order, " . "$album_id," . "'$track_name'" . ")";
                      $track_order++;
              }
              if ($values) {
                  $sql = 'INSERT INTO tracks (track_order, album_id, track_name) VALUES ' . implode(',', $values);
                  // execute the query and get error message if it fails
                  if (!$conn->query($sql)) {
                      //$error = $conn->error;
                      $error = 'Unable to update the database at this time.';
                   }
                }
              }
             } else {
               //$error = implode(' ', $loader->getMessages());
               $error = 'Unable to update the database at this time.';
             }
         } else {
           $error = 'The year needs to be a four digit number';
         }
        if ($albumOK && !isset($error)) {
            header('Location: http://www.rrbconcepts.com/discographyPHP/index.php');
            exit;
        }
      }
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
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/styles.css">
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
    <form class="inputForm" method="post" action="manager.php" enctype="multipart/form-data">
      <?php if (isset($error)) {
                echo "<p class=\"warning\">$error</p>";
      } ?>
      <?php
      if (isset($values)) {
          echo '<ul>';
          foreach ($values as $message) {
            echo "<li class=\"warning\">$message</li>";
          }
        echo '</ul>';
      }
       ?>
       <p>
          <label for="artistId">Artist:</label>
          <select name="artistId" id="artistId">
              <option value="">Select</option>
              <?php
              // get the list of bands
              $sql = 'SELECT artist_id, artist_name FROM artist ORDER BY artist_name';
              $bandName = $conn->query($sql);
              while ($row = $bandName->fetch_assoc()) {
                  ?>
                  <option value="<?= $row['artist_id']; ?>"
                      <?php
                      if (isset($_POST['artistId']) && $row['artist_id'] == $_POST['artistId']) {
                          echo 'selected';
                      }
                      ?>><?= $row['artist_name']; ?></option>
              <?php } ?>
          </select>
      </p>
        <p>
            <label for="album">Name of album:</label>
            <input name="album" type="text" id="album"  class="forminput"
                value="<?php if (isset($error)) {echo htmlentities($_POST['album']); } ?>">
        </p>
        <p>
            <label for="year">Year released:</label>
            <input name="year" id="year"
                value="<?php if (isset($error)) {echo htmlentities($_POST['year']);} ?>">
        </p>
        <p>
          <label for="image">Select image:</label>
          <input type="file" name="image" id="image">
        </p>
        <p id="tracks">
            <input type="checkbox" name="addTracks" id="addTracks"
            value="<?php if (isset($error)) {echo htmlentities($_POST['addTracks']); } ?>">
            <label for="addTracks">Add track names</label>
        </p>
        <div class="optional">
            <label for="trackName">Enter tracks in the order they appear:</label>
            <p id="dynamicInput">Track 1<br><input type="text" class="trackInput" name="trackName[]">
            </p>
            <input type="button" class="trackSubmit" value="Add another track" onClick="addInput('dynamicInput');">
        </div>
        <p>
            <input class="formSubmit" type="submit" name="insert" value="Add album" id="insert">
        </p>
      </form>
  </main>
  <script src="../js/tracks.js"></script>
  </body>
  </html>
