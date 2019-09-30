<?php
namespace Tudublin;

class Review {
    private $reviewId;
    private $recommendMealPlan;
    private $mealPlanId;

    public function getReviewId()
    {
        return $this->reviewId;
    }

    public function setReviewId($reviewId)
    {
        $this->reviewId = $reviewId;
    }

    public function getRecommendMealPlan()
    {
        return $this->recommendMealPlan;
    }

    public function setRecommendMealPlan($recommendMealPlan)
    {
        $this->recommendMealPlan = $recommendMealPlan;
    }

    public function getMealPlanId()
    {
        return $this->mealPlanId;
    }

    public function setMealPlanId($mealPlanId)
    {
        $this->mealPlanId = $mealPlanId;
    }



    public function displayReview(){
        echo "<br><br> Review ID: " .$this->reviewId .
            "<br> Recommend meal plan: " .$this->recommendMealPlan .
            "<br> Meal plan ID: " .$this->mealPlanId;
    }
}

