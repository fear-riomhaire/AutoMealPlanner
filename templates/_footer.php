<hr>

<?php
if(isset($isLoggedin) && $isLoggedin && $username== 'admin'):
    ?>

    <a href="index.php?action=adminLogin">admin home page</a>
<?php
elseif(isset($isLoggedin) && $isLoggedin):
    ?>
    <a href="index.php?action=userLogin">home page</a>

<?php
else:
    ?>
    <a href="index.php">home page</a>
<?php
endif;
?>