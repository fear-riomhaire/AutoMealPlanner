<?php

use Tudublin\MainController;

require_once __DIR__ . '/_header.php';
?>

<h1>Review Meal Plan</h1>



<?php

$mainController = new MainController();

$mainController->insertAmountMealToMealPlan();//when meal plan Id create
$mainController->processGenerateMealPlan();
$mainController->insertUserIdToMealPlan();
$mainController->insertDataToMealPlanHasMeal();
$mainController->createReview();

?>

<p><button onclick="myFunction()">Print meal plan</button></p>

<script>
    function myFunction() {
        window.print();
    }
</script>

</form>


<?php
require_once __DIR__ . '/_footer.php';
?>
