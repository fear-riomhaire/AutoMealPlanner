<?php
require_once __DIR__ . '/_header.php';
?>

<h1>Edit profile</h1>

<form method="POST" action="index.php">

    <input type="hidden" name="action" value="userEditProfile">

    <br>
    First name:
    <input name="firstName">

    <br>
    Last name:
    <input name="lastName">

    <br>
    Age:
    <input type="number" name="age" min="18" max="70">

    <br>
    <input type="submit" value="UPDATE">

</form>


<?php
require_once __DIR__ . '/_footer.php';
?>
