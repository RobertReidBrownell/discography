<?php
// run this script only if the logout button has been clicked
if (isset($_POST['logout'])) {
    // empty the $_SESSION array
    $_SESSION = [];
    // invalidate the session cookie
    if (isset($_COOKIE[session_name()])) {
        setcookie(session_name(), '', time()-86400, '/');
    }
    // end session and redirect
    session_destroy();

    //header('Location: http://www.rrbconcepts.com/phpsols/ch17/authenticate/login_db.php');
      header('Location: http://localhost/discographyPHP/user.php');
    exit;
}
?>
<form method="post" action="">
    <input name="logout" type="submit" value="Log out">
</form>
