<?php
namespace Tudublin;

class mealPlan {
    private $mealPlanId;
    private $weight;
    private $height;
    private $amountOfMeal;

    public function getMealPlanId()
    {
        return $this->mealPlanId;
    }

    public function setMealPlanId($mealPlanId)
    {
        $this->mealPlanId = $mealPlanId;
    }

    public function getWeight()
    {
        return $this->weight;
    }

    public function setWeight($weight)
    {
        $this->weight = $weight;
    }

    public function getHeight()
    {
        return $this->height;
    }

    public function setHeight($height)
    {
        $this->height = $height;
    }

    public function getAmountOfMeal()
    {
        return $this->amountOfMeal;
    }

    public function setAmountOfMeal($amountOfMeal)
    {
        $this->amountOfMeal = $amountOfMeal;
    }

    public function displayMealPlan(){
        echo "<br><br>Meal Plan ID: " .$this->mealPlanId .
            "<br> Weight: " .$this->weight .
            "<br> Height: " . $this->height .
            "<br> Amount Of Meal : " . $this->amountOfMeal;
    }
}

