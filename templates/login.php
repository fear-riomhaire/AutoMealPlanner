<?php
require_once __DIR__ . '/_header.php';
?>

<form method="POST" action="index.php">

    <input type="hidden" name="action" value="processLogin">

    Username:
    <input name="username">

    <br>
    Password:
    <input name="password">

    <br>
    <input type="submit" value="LOGIN">

</form>

<hr>
or
<a href="index.php?action=register">
    register
</a>
as a new user

<?php
require_once __DIR__ . '/_footer.php';
?>
