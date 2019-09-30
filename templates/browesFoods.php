<?php
require_once __DIR__ . '/_header.php'
?>

<h1>Browse foods</h1>
<?php
use Tudublin\MainController;

$mainController = new MainController();

switch ($action) {
    default:
        $mainController->displayFoods();
}

?>

<?php
require_once __DIR__ . '/_footer.php';
?>
