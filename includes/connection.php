<?php
function dbConnect($usertype, $connectionType = 'mysqli') {
  $host = 'localhost';
  $db = 'discographyPHP';
  if ($usertype == 'read') {
      $user = 'psread';
      $pwd = 'Bropt3401';
  } elseif ($usertype == 'write') {
      $user = 'pswrite';
      $pwd = 'Bropt3401';
  } else {
      exit('Unrecognized user');
  }
  // Connection code goes here
  if ($connectionType == 'mysqli') {
      $conn = @ new mysqli($host, $user, $pwd, $db);
      if ($conn->connect_error) {
          exit($conn->connect_error);
      }
      return $conn;
  } else {
      try {
          return new PDO("mysql:host=$host;dbname=$db", $user, $pwd);
      } catch (PDOException $e) {
          echo $e->getMessage();
      }

  }
}
