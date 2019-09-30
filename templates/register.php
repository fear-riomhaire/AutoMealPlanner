<?php
require_once __DIR__ . '/_header.php';
?>


<form method="POST" action="index.php">

    <input type="hidden" name="action" value="processRegistration">

    Username:
    <input name="username">

    <br>
    Gender:
    <select name="gender">
        <option value="">Select...</option>
        <option value="male">Male</option>
        <option value="female">Female</option>
    </select>

    <br>
    Email:
    <input name="email">

    <br>
    Password:
    <input type="password" name="password">

    <br>
    Repeat password:
    <input type="password" name="re-password">

    <br>
    <input type="submit" value="REGISTER">

</form>

<?php
require_once __DIR__ . '/_footer.php';
?>
