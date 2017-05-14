<?php
function dbConnect($usertype, $connectionType = 'mysqli') {
  $host = 'usm10.siteground.biz';
  $db = 'shanabro_phpsols';
  if ($usertype == 'read') {
      $user = 'shanabro_psread';
      $pwd = '8h~I^=xDio]t';
  } elseif ($usertype == 'write') {
      $user = 'shanabro_pswrite';
      $pwd = 'lU_CU_]kd@2O';
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
