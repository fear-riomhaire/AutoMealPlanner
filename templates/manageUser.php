<?php
require_once __DIR__ . '/_header.php'
?>

<h1>Delete user</h1>
<form method="POST" action="index.php">

    <input type="hidden" name="action" value="deleteUser">

    Enter username to delete user:
    <input name="username">

    <br>
    <input type="submit" value="Delete user">

</form>

<hr>
<h1>Reset user password</h1>
<form method="POST" action="index.php">

    <input type="hidden" name="action" value="adminResetUserPassword">

    Enter username to reset user password:
    <input name="username">

    <br>
    <input type="submit" value="Reset password">

</form>

<hr>
<h1>Create user</h1>
<form method="POST" action="index.php">

    <input type="hidden" name="action" value="addUser">

    Username:
    <input name="username">

    <br>
    First name:
    <input name="firstName">

    <br>
    Last name:
    <input name="lastName">

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
    Age:
    <input type="number" name="age" min="18" max="70">

    <br>
    Password:
    <input type="password" name="password">

    <br>
    Repeat password:
    <input type="password" name="re-password">

    <br>
    <input type="submit" value="Add user">

</form>
<hr>

<h1>All user</h1>
<?php
use Tudublin\MainController;
$mainController = new MainController();

switch ($action) {
    default:
        $mainController->displayAllUser();
}

?>

<?php
require_once __DIR__ . '/_footer.php';
?>
