<?php
require_once '../includes/a_session_timeout.php';
?>
<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <title>Secret menu</title>
</head>

<body>
<h1>Restricted area Admin</h1>
<p><a href="menu_users.php">Another secret page</a></p>
<?php echo $_SESSION['authenticated']; ?> <br>
<?php echo session_status(); ?>
<?php include '../includes/logout_db.php'; ?>
</body>
</html>
