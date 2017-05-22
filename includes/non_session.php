<?php
session_start();
ob_start();
if (!isset($_SESSION['authenticated'])) {
        $_SESSION['authenticated'] = '';
}
// if session is active as admin apply admin menu
if (($_SESSION['authenticated']) == 'Christy')  {
      // set variable for nav menu
      $file = "/home/shanabro/private/includes/headernavadmin.php";
      // if session is active as standard user apply user menu
} elseif (($_SESSION['authenticated']) == 'Jethro') {
      // set variable for nav menu
      $file = "/home/shanabro/private/includes/headernavuser.php";
} else {
      // set variable for nav menu
      $file = "/home/shanabro/private/includes/headernav.php";
}
