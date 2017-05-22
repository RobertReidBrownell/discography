<?php
include 'title.php';
require_once 'connection.php';
require_once 'non_session.php';
// initating $errors and $missing as arrays so they can store multiple values
$errors = [];
$missing = [];
// create the database connection
$conn = dbConnect('write');
if (isset($_POST['send'])) {
    // initialize flag
    $OK = false;
    // list expected fields
    $expected = ['fname','lname', 'email', 'address', 'city', 'state', 'zcode', 'bday', 'agreetoterms', 'epref'];
    $required = ['fname','lname', 'email', 'address', 'city', 'state', 'zcode', 'bday', 'agreetoterms', 'epref'];
    // set default values for variables that might not exist
    if (!isset($_POST['epref'])) {
        $_POST['epref'] = '';
    }
    if (!isset($_POST['agreetoterms'])) {
        $_POST['agreetoterms'] = '';
        $errors['agreetoterms'] = true;
    }
    require 'forminsert.php';
    if (!empty($_POST['fname']) && !empty($_POST['lname']) && !empty($_POST['email']) && !empty($_POST['address']) && !empty($_POST['city']) &&
        !empty($_POST['state']) && !empty($_POST['zcode']) && !empty($_POST['bday']) && !empty($_POST['agreetoterms']) && !empty($_POST['epref'])) {
        // initialize prepared statement
        $stmt = $conn->stmt_init();
        // create SQL
        $sql = 'INSERT INTO userdata (first_name, last_name, address, city, state, zip_code, birthday, email, email_preference)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)';
        if ($stmt->prepare($sql)) {
            // bind parameters and execute statement
            $stmt->bind_param('sssssssss', $_POST['fname'], $_POST['lname'], $_POST['address'], $_POST['city'], $_POST['state'], $_POST['zcode'], $_POST['bday'], $_POST['email'], $_POST['epref']);
            $stmt->execute();
            if ($stmt->affected_rows > 0) {
              $OK = true;
            }
        }
        //redirect if successful or display error
        if ($OK) {
             header('Location: https://www.rrbconcepts.com/discographyPHP/thank_you.php');
            exit;
        } else {
              $error = $stmt->error;
        }
      } else {
          $error;
  }
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
      <img src="img/infopage/info.jpg" alt="An image of the band Jukebox the ghost wakling across the street" class="infoImg">
      <h2>Jukebox The Ghost</h2>
      <p>
        Jukebox the Ghost is a band that began in 2003, consisting of Ben Thornewill, Tommy Siegel, and Jesse Kristen. They love touring and have tons of shows, and they feature a piano rock style with a fair bit of experimentation.
      </p>
      <form class="inputForm" action="info.php" method="post" >
        <?php  if ($missing || $errors) { ?>
            <p class="warning">Please fix the item(s) indicated.</p>
        <?php } elseif (($_POST && $suspect) || ($_POST && isset($errors['mailfail']))) { ?>
            <p class="warning">We are sorry. Your response email has failed.</p>
        <?php } ?>
		<h3>Sign up for updates</h3>
    <p><b>All fields are required</b></p>
        <?php if ($missing && in_array('fname', $missing)) { ?>
                  <span class="warning">Please enter your first name</span><br>
        <?php } ?>
        <span class="inputspan">First Name: </span><input class="formInput" type="text" name="fname" id="fname"
        <?php if ($missing || $errors) {
            echo 'value="' . htmlentities($fname) . '"';
        } ?>><br>
        <?php if ($missing && in_array('lname', $missing)) { ?>
                  <span class="warning">Please enter your last name</span><br>
        <?php } ?>
        <span class="inputspan">Last Name: </span><input class="formInput" type="text" name="lname" id="lname"
        <?php if ($missing || $errors) {
            echo 'value="' . htmlentities($lname) . '"';
        } ?>><br>
        <?php if ($missing && in_array('address', $missing)) { ?>
                  <span class="warning">Please enter your address</span><br>
        <?php } ?>
        <span class="inputspan">Address: </span> <input class="formInput" type="text" name="address" id="address"
        <?php if ($missing || $errors) {
            echo 'value="' . htmlentities($address) . '"';
        } ?>><br>
        <?php if ($missing && in_array('city', $missing)) { ?>
                  <span class="warning">Please enter your city</span><br>
        <?php } ?>
        <span class="inputspan">City: </span><input class="formInput" type="text" name="city" id="city"
        <?php if ($missing || $errors) {
            echo 'value="' . htmlentities($city) . '"';
        } ?>><br>
        <?php if ($missing && in_array('state', $missing)) { ?>
                  <span class="warning">Please enter your state</span><br>
        <?php } ?>
        <span class="inputspan">State: </span><input class="formInput" type="text" name="state" id="state"
        <?php if ($missing || $errors) {
            echo 'value="' . htmlentities($state) . '"';
        } ?>><br>
        <?php if ($missing && in_array('zcode', $missing)) { ?>
                  <span class="warning">Please enter your zipcode</span><br>
        <?php } ?>
        <span class="inputspan">Zip: </span><input class="formInput" type="text" name="zcode" id="zcode"
        <?php if ($missing || $errors) {
            echo 'value="' . htmlentities($zcode) . '"';
        } ?>><br>
        <?php if ($missing && in_array('bday', $missing)) { ?>
                  <span class="warning">Please enter your birthday</span><br>
        <?php } ?>
        <span class="inputspan">Birthday: </span><input class="formInput" type="date" name="bday" id="bday"
        <?php if ($missing || $errors) {
            echo 'value="' . htmlentities($bday) . '"';
        } ?>><br>
        <?php if ($missing && in_array('email', $missing)) { ?>
                <span class="warning">Please enter your email address</span><br>
        <?php } elseif (isset($errors['email'])) { ?>
                <span class="warning">Invalid email address</span><br>
        <?php }  elseif (isset($errors['duplicate'])) { ?>
                 <span class="warning">This email is already signed up for our newsletter.</span><br>
        <?php } ?>
        <span class="inputspan">Email: </span><input class="formInput" type="text" name="email" id="email"
        <?php if ($missing || $errors) {
            echo 'value="' . htmlentities($email) . '"';
        } ?>><br>
        <?php if ($missing && in_array('epref', $missing)) {?>
                <span class="warning">Please select an email preference</span><br>
        <?php } ?>
        <span class="inputspan">Email Preference: </span><br>
        <input class="formInput" type="radio" name="epref" value="HTML" id="epref-html"
        <?php
        if ($_POST && $_POST['epref'] == 'HTML') {
            echo 'checked';
        } ?>>
        <span class="radinputspan">HTML</span><br>
        <input type="radio" name="epref" value="Plain text" id="epref-plaintext"
        <?php
        if ($_POST && $_POST['epref'] == 'Plain text') {
            echo 'checked';
        } ?>>
         <span class="radinputspan">Plain text</span><br>
         <?php if (isset($errors['agreetoterms'])) { ?>
             <span class="warning">Please agree to the terms and conditions</span><br>
         <?php } ?>
        <input type="checkbox" name="agreetoterms" id="agreetoterms"> <span class="checkinputspan">I agree to the terms </span>
        <input class="formSubmit" type="submit" name="send" value="Get Updates!">
      </form>
    </main>
  </body>
</html>
