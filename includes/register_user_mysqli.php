<?php
use Discography\Authenticate\CheckPassword;

require_once __DIR__ . '/Discography/Authenticate/CheckPassword.php';
$usernameMinChars = 6;
$errors = [];
if (strlen($username) < $usernameMinChars) {
  $errors[] = "Username must be atleast $usernameMinChars characters.";
}
if (preg_match('/\s/', $username)) {
  $errors[] = 'Username should not contain spaces.';
}
$checkPwd = new CheckPassword($password, 8);
$checkPwd->requireMixedCase(false);
$checkPwd->requireNumbers(0);
$checkPwd->requireSymbols(0);
$passwordOK = $checkPwd ->check();
if (!$passwordOK) {
    $errors = array_merge($errors, $checkPwd->getErrors());
}
if ($password != $retyped) {
  $errors[] = "Your passwords don't match.";
}
if (!$errors) {
  // encrypt password using default encryption
  $password = password_hash($password, PASSWORD_DEFAULT);
  // include the connection file
  require_once 'connection.php';
  $conn = dbConnect('write');
  // prepare the SQL statement
  $sql = 'INSERT INTO users (username, pwd) VALUES (?, ?)';
  $stmt = $conn->stmt_init();
  if ($stmt = $conn->prepare($sql)) {
      // bind parameters and insert the details into the database
      $stmt->bind_param(ss, $username, $password);
      $stmt->execute();
  }
  if ($stmt->affected_rows == 1) {
      $success = "$username has been registered. You may now log in.";
  } elseif ($stmt->errno == 1062) {
      $errors[] = "$username is already in use. Please choose another username.";
  } else {
      // before deploying this REPLACE the following line to a generic message.
      //$errors[] = $stmt->error;
      $errors[] = 'You cannot be registered at this time';
  }
}
