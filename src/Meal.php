<?php
namespace Tudublin;

class Meal {
    private $mealId;
    private $mealName;
    private $category;
    private $foodCalories;
    private $foodCarbs;
    private $foodProtein;
    private $foodFat;

    public function getMealId()
    {
        return $this->mealId;
    }

    public function setMealId($mealId)
    {
        $this->mealId = $mealId;
    }

    public function getMealName()
    {
        return $this->mealName;
    }

    public function setMealName($mealName)
    {
        $this->mealName = $mealName;
    }

    public function getCategory()
    {
        return $this->category;
    }

    public function setCategory($category)
    {
        $this->category = $category;
    }

    public function getFoodCalories()
    {
        return $this->foodCalories;
    }

    public function setFoodCalories($foodCalories)
    {
        $this->foodCalories = $foodCalories;
    }

    public function getFoodCarbs()
    {
        return $this->foodCarbs;
    }

    public function setFoodCarbs($foodCarbs)
    {
        $this->foodCarbs = $foodCarbs;
    }

    public function getFoodProtein()
    {
        return $this->foodProtein;
    }

    public function setFoodProtein($foodProtein)
    {
        $this->foodProtein = $foodProtein;
    }

    public function getFoodFat()
    {
        return $this->foodFat;
    }

    public function setFoodFat($foodFat)
    {
        $this->foodFat = $foodFat;
    }

    public function displayMeal(){
        echo "<br><br> Meal name: " .$this->mealName .
            "<br> Category: " .$this->category .
            "<br> Meal calories: " . $this->foodCalories .
            "<br> Meal carbs: " . $this->foodCarbs .
            "<br> Meal protein: " . $this->foodProtein .
            "<br> Meal fat: " . $this->foodFat;
    }
}

