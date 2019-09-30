<?php
require_once __DIR__ . '/_header.php';
?>

<h1>Delete meal</h1>
<form method="POST" action="index.php">

    <input type="hidden" name="action" value="deleteMeal">

    Enter meal name to delete meal:
    <input name="mealName">

    <br>
    <input type="submit" value="Delete meal">

</form>

<hr>
<h1>Generate Meal</h1>

<form method="POST" action="index.php">

    <input type="hidden" name="action" value="processGenerateMeal">

    meal name:
    <input name="mealName">

    <br>
    meal category:
    <input name="mealCategory">

    <br>
    meal calories
    <input name="mealCalories">

    <br>
    meal carbohydrates
    <input name="mealCarbohydrates">

    <br>
    meal protein
    <input name="mealProtein">

    <br>
    meal fat
    <input name="mealFat">

    <br>
    <input type="submit" value="Create Meal">

</form>

<hr>
<h1>Edit Meal</h1>

<form method="POST" action="index.php">

    <input type="hidden" name="action" value="editProcessGenerateMeal">

    meal name:
    <input name="mealName">

    <br>
    meal category:
    <input name="mealCategory">

    <br>
    meal calories
    <input name="mealCalories">

    <br>
    meal carbohydrates
    <input name="mealCarbohydrates">

    <br>
    meal protein
    <input name="mealProtein">

    <br>
    meal fat
    <input name="mealFat">

    <br>
    <input type="submit" value="Create Meal">

</form>

<hr>
<h1>All meal</h1>
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
