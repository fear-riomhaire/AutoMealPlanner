<?php
session_start();

require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../vendor/autoload.php';

use Tudublin\MainController;

$action = filter_input(INPUT_GET, 'action');
if(empty($action)){
    $action = filter_input(INPUT_POST, 'action');
}

$mainController = new MainController();
switch ($action){
    case'about':
        $mainController->about();
        break;

    case 'userLogin':
        $mainController->userHome();
        break;

    case 'adminLogin':
        $mainController->adminHome();
        break;

    case 'contact':
        $mainController->contact();
        break;

    case 'browseFoods':
        $mainController->browesFoods();
        break;

    case 'login':
        $mainController->loginForm();
        break;

    case 'logout':
        unset($_SESSION['username']);
        $mainController->home();
        break;

    case 'register':
        $mainController->registerForm();
        break;

    case 'manageMeal':
        $mainController->manageMeal();
        break;

    case 'processLogin':
        $mainController->processLogin();
        break;

    case 'processRegistration':
        $mainController->processRegistration();
        break;

    case 'processGenerateMeal':
        $mainController->processGenerateMeal();
        break;

    case 'editProcessGenerateMeal':
        $mainController->editProcessGenerateMeal();
        break;

    case 'generateMealPlanPage':
        $mainController->generateMealPlanPage();
        break;

    case 'processGenerateMealPlan':
        $mainController->processGenerateMealPlan();
        break;

    case 'editProfile':
        $mainController->editProfile();
        break;

    case 'manageUser':
        $mainController->manageUser();
        break;

    case 'addUser':
        $mainController->addUser();
        break;

    case 'deleteUser':
        $mainController->deleteUser();
        break;

    case 'deleteMeal':
        $mainController->deleteMeal();
        break;

    case 'userEditProfile':
        $mainController->userEditProfile();
        break;

    case 'userResetPassword':
        $mainController->userResetPassword();
        break;

    case 'processUserResetPassword':
        $mainController->processUserResetPassword();
        break;

    case 'adminResetUserPassword':
        $mainController->adminResetUserPassword();
        break;

    case 'reviewMealPlan':
        $mainController->reviewMealPlan();
        break;

    case 'printMealPlan':
        $mainController->printMealPlan();
        break;


    default:
        $mainController->home();

}