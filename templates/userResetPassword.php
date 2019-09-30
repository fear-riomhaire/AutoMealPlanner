<?php
require_once __DIR__ . '/_header.php';
?>

<h1>Change password</h1>

<form method="POST" action="index.php">

    <input type="hidden" name="action" value="processUserResetPassword">

    <br>
    New password:
    <input type="password" name="newPassword">

    <br>
    Repeat new password:
    <input type="password" name="re-newPassword">

    <br>
    <input type="submit" value="CHANGE PASSWORD">

</form>


<?php
require_once __DIR__ . '/_footer.php';
?>
