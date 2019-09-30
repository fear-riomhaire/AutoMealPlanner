<?php
require_once __DIR__ . '/_header.php';
?>

<h1>Generate Meal Plan</h1>

<form method="POST" action="index.php">

    <input type="hidden" name="action" value="reviewMealPlan">

    <br>
    I want to eat around
    <input type="number" name="calories" min="100" max="20000" step="100">
    Calories

    <br>
    in
    <select name="meal">
        <option value="">Select...</option>
        <option value="1">1 meal</option>
        <option value="2">2 meals</option>
        <option value="3">3 meals</option>
        <option value="4">4 meals</option>
    </select>

    <br>
    <input type="submit" value="Generate meal plan">

</form>

</ul>


<?php
require_once __DIR__ . '/_footer.php';
?>
