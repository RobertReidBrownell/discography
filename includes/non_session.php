<?php
session_start();
ob_start();
if (!isset($_SESSION['authenticated'])) {
        $_SESSION['authenticated'] = '';
}
// if session is active as admin apply admin menu
if (($_SESSION['authenticated']) == 'Christy')  {
      $file = $_SERVER['DOCUMENT_ROOT']."/discographyPHP/includes/headernavadmin.php";
      // if session is active as standard user apply user menu
} elseif (($_SESSION['authenticated']) == 'Jethro') {
      $file = $_SERVER['DOCUMENT_ROOT']."/discographyPHP/includes/headernavuser.php";
} else {
      $file = $_SERVER['DOCUMENT_ROOT']."/discographyPHP/includes/headernav.php";
}
