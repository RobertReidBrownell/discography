<?php
require_once 'connection.php';
$conn = dbConnect('read');
$errors = [];
// location to redirect on success for admin
$redirect = 'http://localhost/discographyPHP/authenticated/menu_db.php';
// location to redirect on success for users
$redirected = 'http://localhost/discographyPHP/authenticated/menu_users.php';
// get the username's encrypted password from the database
$sql = 'SELECT pwd, user_level FROM users WHERE username = ?';
// initialize and prepare statement
$stmt = $conn->stmt_init();
$stmt->prepare($sql);
// bind the input parameter
$stmt->bind_param('s', $username);
$stmt->execute();
// bind the results, using a new variable for the password
$stmt->bind_result($storedPwd, $userLevel);
$stmt->fetch();
// check the submitted password against the stored version
if (password_verify($password, $storedPwd)) {
    if ($userLevel == 'admin') {
     $_SESSION['authenticated'] = 'Christy';
     // get the time the session started
     $_SESSION['start'] = time();
     session_regenerate_id();
     header("Location: $redirect");
     exit;
     } else {
     $_SESSION['authenticated'] = 'Jethro';
     // get the time the session started
     $_SESSION['start'] = time();
     session_regenerate_id();
     header("Location: $redirected");
     exit;
   }
} else {
    // if not verified, prepare error Message
    $error = 'Invalid username or password';

}
