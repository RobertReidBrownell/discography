<?php
require_once '../includes/session_timeout.php';
?>
<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <title>Users Secret menu</title>
</head>

<body>
<h1>Restricted area Users</h1>
<p><a href="menu_db.php">Another secret page</a></p>
<?php echo $_SESSION['authenticated']; ?>
<?php include '../includes/logout_db.php'; ?>
</body>
</html>
