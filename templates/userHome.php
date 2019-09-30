<?php
require_once __DIR__ . '/_header.php';
?>

<h1>Welcome <?= $username ?> </h1>

You can access to there function

<ul>
    <li>
        <a href="index.php?action=about">
            about page
        </a>
    </li>

    <li>
        <a href="index.php?action=browseFoods">
            browse foods
        </a>
    </li>

    <li>
        <a href="index.php?action=generateMealPlanPage">
            generate meal plan
        </a>
    </li>

    <li>
        <a href="index.php?action=editProfile">
            edit profile
        </a>
    </li>

    <li>
        <a href="index.php?action=userResetPassword">
            reset password
        </a>
    </li>

    <li>
        <a href="index.php?action=contact">
            contact
        </a>
    </li>

</ul>

<?php
require_once __DIR__ . '/_footer.php';
?>
