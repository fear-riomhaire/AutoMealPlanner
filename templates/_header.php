<?php
if(isset($isLoggedin) && $isLoggedin):
?>
    You are logged in as: <strong> <?= $username ?> </strong>
<br>
    <a href="index.php?action=logout">logout</a>
<?php
else:
?>
    <a href="index.php?action=login">login</a>
<?php
endif;
?>
<hr>

