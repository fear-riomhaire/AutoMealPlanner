<?php
namespace Tudublin;


class MainController
{
    private $userRepository;
    private $sessionManager;
    private $username;
    private $meal;

    public function __construct()
    {
        $this->userRepository = new UserRepository();
        $this->sessionManager = new SessionManager();
    }

    // check if the user login or not
    public function userHome()
    {
        $isLoggedin = $this->sessionManager->isLoggedIn();
        $username = $this->sessionManager->usernameFromSession();
        require_once __DIR__ . '/../templates/userHome.php';
    }

    public function adminHome()
    {
        $isLoggedin = $this->sessionManager->isLoggedIn();
        $username = $this->sessionManager->usernameFromSession();
        require_once __DIR__ . '/../templates/adminHome.php';
    }

    public function home()
    {
        $isLoggedin = $this->sessionManager->isLoggedIn();
        $username = $this->sessionManager->usernameFromSession();
        require_once __DIR__ . '/../templates/home.php';
    }

    public function contact()
    {
        $isLoggedin = $this->sessionManager->isLoggedIn();
        $username = $this->sessionManager->usernameFromSession();
        require_once __DIR__ . '/../templates/contact.php';
    }

    public function browesFoods()
    {
        $isLoggedin = $this->sessionManager->isLoggedIn();
        $username = $this->sessionManager->usernameFromSession();
        require_once __DIR__ . '/../templates/browesFoods.php';
    }

    public function manageUser()
    {
        $isLoggedin = $this->sessionManager->isLoggedIn();
        $username = $this->sessionManager->usernameFromSession();
        require_once __DIR__ . '/../templates/manageUser.php';
    }

    public function about()
    {
        $isLoggedin = $this->sessionManager->isLoggedIn();
        $username = $this->sessionManager->usernameFromSession();
        require_once __DIR__ . '/../templates/about.php';
    }

    public function generateMealPlanPage()
    {
        $isLoggedin = $this->sessionManager->isLoggedIn();
        $username = $this->sessionManager->usernameFromSession();
        require_once __DIR__ . '/../templates/generateMealPlanPage.php';
    }

    public function editProfile()
    {
        $isLoggedin = $this->sessionManager->isLoggedIn();
        $username = $this->sessionManager->usernameFromSession();
        require_once __DIR__ . '/../templates/editProfile.php';
    }

    public function loginForm()
    {
        $isLoggedin = $this->sessionManager->isLoggedIn();
        $username = $this->sessionManager->usernameFromSession();
        require_once __DIR__ . '/../templates/login.php';
    }

    public function registerForm()
    {
        $isLoggedin = $this->sessionManager->isLoggedIn();
        $username = $this->sessionManager->usernameFromSession();
        require_once __DIR__ . '/../templates/register.php';
    }

    public function userResetPassword()
    {
        $isLoggedin = $this->sessionManager->isLoggedIn();
        $username = $this->sessionManager->usernameFromSession();
        require_once __DIR__ . '/../templates/userResetPassword.php';
    }

    public function manageMeal()
    {
        $isLoggedin = $this->sessionManager->isLoggedIn();
        $username = $this->sessionManager->usernameFromSession();
        require_once __DIR__ . '/../templates/manageMeal.php';
    }

    public function processLogin()
    {
        $this->username = filter_input(INPUT_POST, 'username');
        $password = filter_input(INPUT_POST, 'password');

        if ($this->validLoginCredentials($this->username, $password)) {
            $this->validLoginActions();
        } else {
            $message = 'invalid login credentials - try again';
            require_once __DIR__ . '/../templates/error.php';
        }
    }

    private function validLoginActions()
    {
        $this->sessionManager->storeUsername($this->username);

        $isLoggedin = $this->sessionManager->isLoggedIn();

        if($isLoggedin) {
            $username = $this->sessionManager->usernameFromSession();
            if ($username == 'admin') {
                require_once __DIR__ . '/../templates/adminHome.php';
            } else {
                require_once __DIR__ . '/../templates/userHome.php';
            }
        }
    }

    private function validLoginCredentials($username, $password)
    {
        if ($this->userRepository->existsUser($username, $password)) {
            return true;
        }

        return false;
    }

    public function processRegistration()
    {
        $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        $username = filter_input(INPUT_POST, 'username');
        $gender = $_POST['gender'];
        $email = filter_input(INPUT_POST, 'email');
        $password = filter_input(INPUT_POST, 'password');
        $passwordRepeat = filter_input(INPUT_POST, 're-password');

        if (empty($username) || empty($email) || empty($password) || empty($passwordRepeat) || empty($gender)){
            $message = "Fill in all fields.";
            require_once __DIR__ . '/../templates/error.php';
        }
        elseif (!filter_var($email, FILTER_VALIDATE_EMAIL) && !preg_match("/^[a-zA-Z0-9]{4,30}$/", $username)){
            $message = "Invalid username and e-mail.";
            require_once __DIR__ . '/../templates/error.php';
        }
        elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $message = "Invalid e-mail.";
            require_once __DIR__ . '/../templates/error.php';
        }
        elseif (!preg_match("/^[a-zA-Z0-9]{4,30}$/", $username)){
            $message = "Invalid username.(username length must be between 4 to 30, only lowercase, uppercase and number are permit.)";
            require_once __DIR__ . '/../templates/error.php';
        }
        elseif ($password !== $passwordRepeat){
            $message = "Password do not match.";
            require_once __DIR__ . '/../templates/error.php';
        }
        else{

            // enter the database
            $sql = "SELECT userName FROM users WHERE userName=?";
            $stmt = mysqli_stmt_init($conn);
            if(!mysqli_stmt_prepare($stmt, $sql)){
                $message = "SQL error.";
                require_once __DIR__ . '/../templates/error.php';
            }
            else {
                // what data type are passing in s= string
                mysqli_stmt_bind_param($stmt, "s", $username);
                mysqli_stmt_execute($stmt);

                // result we got from the database and store back in the variable
                mysqli_stmt_store_result($stmt);

                // check the result in the database
                $resultCheck = mysqli_stmt_num_rows($stmt);
                if ($resultCheck > 0){
                    $message = "Username is already exist.";
                    require_once __DIR__ . '/../templates/error.php';
                }
                else{
                    $sql = "INSERT INTO users(userName, gender, password, email) VALUE(?, ?, ?,?)";
                    $stmt = mysqli_stmt_init($conn);
                    if(!mysqli_stmt_prepare($stmt, $sql)){
                        $message = "SQL error.";
                        require_once __DIR__ . '/../templates/error.php';
                    }
                    else{
                        mysqli_stmt_bind_param($stmt, "ssss", $username, $gender, $password, $email);
                        mysqli_stmt_execute($stmt);
                        $message = "Signup successful.";
                        require_once __DIR__ . '/../templates/message.php';
                    }
                }
            }
            mysqli_stmt_close($stmt);
            mysqli_close($conn);
        }
    }

    public function addUser()
    {
        $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        $username = filter_input(INPUT_POST, 'username');
        $firstName = filter_input(INPUT_POST, 'firstName');
        $lastName = filter_input(INPUT_POST, 'lastName');
        $gender = $_POST['gender'];
        $email = filter_input(INPUT_POST, 'email');
        $age = filter_input(INPUT_POST, 'age');
        $password = filter_input(INPUT_POST, 'password');
        $passwordRepeat = filter_input(INPUT_POST, 're-password');

        if (empty($username) || empty($email) || empty($password) || empty($passwordRepeat) || empty($gender) || empty($firstName) || empty($lastName) || empty($age)){
            $message = "Fill in all fields.";
            require_once __DIR__ . '/../templates/error.php';
        }
        elseif (!filter_var($email, FILTER_VALIDATE_EMAIL) && !preg_match("/^[a-zA-Z0-9]*$/", $username)){
            $message = "Invalid username and e-mail.";
            require_once __DIR__ . '/../templates/error.php';
        }
        elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $message = "Invalid e-mail.";
            require_once __DIR__ . '/../templates/error.php';
        }
        elseif (!preg_match("/^[a-zA-Z0-9]{4,30}$/", $username)){
            $message = "Invalid username.(username length must be between 4 to 30, only lowercase, uppercase and number are permit.)";
            require_once __DIR__ . '/../templates/error.php';
        }
        elseif (!preg_match("/^[a-zA-Z]{4,30}$/", $firstName)){
            $message = "Invalid first name.(minimum 4 letter, maximum 30 letter.)";
            require_once __DIR__ . '/../templates/error.php';
        }
        elseif (!preg_match("/^[a-zA-Z]{4,30}$/", $lastName)){
            $message = "Invalid last name.(minimum 4 letter, maximum 30 letter.)";
            require_once __DIR__ . '/../templates/error.php';
        }
        elseif (!preg_match("/^[0-9]*$/", $age)){
            $message = "Invalid age.";
            require_once __DIR__ . '/../templates/error.php';
        }
        elseif ($password !== $passwordRepeat){
            $message = "Password do not match.";
            require_once __DIR__ . '/../templates/error.php';
        }
        else{

            // enter the database
            $sql = "SELECT userName FROM users WHERE userName=?";
            $stmt = mysqli_stmt_init($conn);
            if(!mysqli_stmt_prepare($stmt, $sql)){
                $message = "SQL error.";
                require_once __DIR__ . '/../templates/error.php';
            }
            else {
                // what data type are passing in s= string
                mysqli_stmt_bind_param($stmt, "s", $username);
                mysqli_stmt_execute($stmt);

                // result we got from the database and store back in the variable
                mysqli_stmt_store_result($stmt);

                // check the result in the database
                $resultCheck = mysqli_stmt_num_rows($stmt);
                if ($resultCheck > 0){
                    $message = "Username is already exist.";
                    require_once __DIR__ . '/../templates/error.php';
                }
                else{
                    $sql = "INSERT INTO users(userName, gender, password, email, firstName, lastName, age) VALUE(?, ?, ?, ?, ?, ? , ?)";
                    $stmt = mysqli_stmt_init($conn);
                    if(!mysqli_stmt_prepare($stmt, $sql)){
                        $message = "SQL error.";
                        require_once __DIR__ . '/../templates/error.php';
                    }
                    else{
                        mysqli_stmt_bind_param($stmt, "sssssss", $username, $gender, $password, $email, $firstName, $lastName, $age);
                        mysqli_stmt_execute($stmt);
                        $message = "Signup successful.";
                        require_once __DIR__ . '/../templates/message.php';
                    }
                }
            }
            mysqli_stmt_close($stmt);
            mysqli_close($conn);
        }
    }

    public function userEditProfile()
    {
        $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        $username = $this->sessionManager->usernameFromSession();
        $firstName = filter_input(INPUT_POST, 'firstName');
        $lastName = filter_input(INPUT_POST, 'lastName');
        $age = filter_input(INPUT_POST, 'age');

        if (empty($firstName) || empty($lastName) || empty($age)){
            $message = "Fill in all fields.";
            require_once __DIR__ . '/../templates/error.php';
        }
        elseif (!preg_match("/^[a-zA-Z]{4,30}$/", $firstName) && !preg_match("/^[a-zA-Z]{4,30}$/", $lastName)){
            $message = "Invalid first name and last name.";
            require_once __DIR__ . '/../templates/error.php';
        }
        elseif (!preg_match("/^[a-zA-Z]{4,30}$/", $firstName)){
            $message = "Invalid first name.(minimum 4 letter, maximum 30 letter.)";
            require_once __DIR__ . '/../templates/error.php';
        }
        elseif (!preg_match("/^[a-zA-Z]{4,30}$/", $lastName)){
            $message = "Invalid last name.(minimum 4 letter, maximum 30 letter.)";
            require_once __DIR__ . '/../templates/error.php';
        }
        elseif (!preg_match("/^[0-9]*$/", $age)){
            $message = "Invalid age.";
            require_once __DIR__ . '/../templates/error.php';
        }
        else{

            // enter the database
            $sql = "SELECT userName FROM users WHERE userName=?";
            $stmt = mysqli_stmt_init($conn);
            if(!mysqli_stmt_prepare($stmt, $sql)){
                $message = "SQL error.";
                require_once __DIR__ . '/../templates/error.php';
            }
            else {
                // what data type are passing in s= string
                mysqli_stmt_bind_param($stmt, "s", $username);
                mysqli_stmt_execute($stmt);

                // result we got from the database and store back in the variable
                mysqli_stmt_store_result($stmt);

                $sql = "UPDATE users SET firstName=?, lastName=?, age=? WHERE userName=?";
                $stmt = mysqli_stmt_init($conn);
                if(!mysqli_stmt_prepare($stmt, $sql)){
                    $message = "SQL error.";
                    require_once __DIR__ . '/../templates/error.php';
                }
                else{
                    mysqli_stmt_bind_param($stmt, "sssss", $firstName,$lastName, $age, $username);
                    mysqli_stmt_execute($stmt);
                    $message = "Update successful.";
                    require_once __DIR__ . '/../templates/message.php';
                }
            }
            mysqli_stmt_close($stmt);
            mysqli_close($conn);
        }
    }

    public function processUserResetPassword()
    {
        $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        $username = $this->sessionManager->usernameFromSession();
        $newPassword = filter_input(INPUT_POST, 'newPassword');
        $repeatNewPassword = filter_input(INPUT_POST, 're-newPassword');

        if (empty($newPassword) || empty($repeatNewPassword)){
            $message = "Fill in all fields.";
            require_once __DIR__ . '/../templates/error.php';
        }
        elseif ($newPassword !== $repeatNewPassword){
            $message = "Password do not match.";
            require_once __DIR__ . '/../templates/error.php';
        }
        else{

            // enter the database
            $sql = "SELECT userName FROM users WHERE userName=?";
            $stmt = mysqli_stmt_init($conn);
            if(!mysqli_stmt_prepare($stmt, $sql)){
                $message = "SQL error.";
                require_once __DIR__ . '/../templates/error.php';
            }
            else {
                // what data type are passing in s= string
                mysqli_stmt_bind_param($stmt, "s", $username);
                mysqli_stmt_execute($stmt);

                // result we got from the database and store back in the variable
                mysqli_stmt_store_result($stmt);

                $sql = "UPDATE users SET password=? WHERE userName=?";
                $stmt = mysqli_stmt_init($conn);
                if(!mysqli_stmt_prepare($stmt, $sql)){
                    $message = "SQL error.";
                    require_once __DIR__ . '/../templates/error.php';
                }
                else{
                    mysqli_stmt_bind_param($stmt, "ss", $newPassword, $username);
                    mysqli_stmt_execute($stmt);
                    $message = "Password update successful.";
                    require_once __DIR__ . '/../templates/message.php';
                }
            }
            mysqli_stmt_close($stmt);
            mysqli_close($conn);
        }
    }

    public function adminResetUserPassword()
    {
        $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        $username = filter_input(INPUT_POST, 'username');

        if (empty($username)){
            $message = "Enter the username to reset the user password.";
            require_once __DIR__ . '/../templates/error.php';
        }
        elseif (!preg_match("/^[a-zA-Z0-9]*$/", $username)){
            $message = "Invalid username.(only lowercase, uppercase and number are permit.";
            require_once __DIR__ . '/../templates/error.php';
        }
        else{
            $sql = "SELECT userName FROM users WHERE userName=?";
            $stmt = mysqli_stmt_init($conn);
            if(!mysqli_stmt_prepare($stmt, $sql)){
                $message = "SQL error.";
                require_once __DIR__ . '/../templates/error.php';
            }
            else {
                // what data type are passing in s= string
                mysqli_stmt_bind_param($stmt, "s", $username);
                mysqli_stmt_execute($stmt);

                // result we got from the database and store back in the variable
                mysqli_stmt_store_result($stmt);

                // check the result in the database
                $resultCheck = mysqli_stmt_num_rows($stmt);
                if ($resultCheck == 0){
                    $message = "no username exist.";
                    require_once __DIR__ . '/../templates/error.php';
                }
                else{

                    $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
                    $pass = array(); //remember to declare $pass as an array
                    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
                    for ($i = 0; $i < 8; $i++) {
                        $n = rand(0, $alphaLength);
                        $pass[] = $alphabet[$n];
                    }
                    $resetPassword = implode($pass); //turn the array into a string

                    $sql = "UPDATE users SET password='$resetPassword' WHERE userName=?";
                    $stmt = mysqli_stmt_init($conn);
                    if(!mysqli_stmt_prepare($stmt, $sql)){
                        $message = "SQL error.";
                        require_once __DIR__ . '/../templates/error.php';
                    }
                    else{

                        mysqli_stmt_bind_param($stmt, "s", $username);
                        mysqli_stmt_execute($stmt);
                        $message = "User password has been reset, new password is ".$resetPassword;
                        require_once __DIR__ . '/../templates/message.php';
                        $to = "example@gmail.com";
                        $subject = "New Password";
                        $txt = "Hi, this is your new password ".$resetPassword . ", Please change to new password as fast as possible.";
                        $headers = "From: automaticMealPlanner@example.com";

                        mail($to,$subject,$txt,$headers);
                    }
                }

            }
            mysqli_stmt_close($stmt);
            mysqli_close($conn);
        }
    }

    public function deleteUser()
    {
        $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        $username = filter_input(INPUT_POST, 'username');

        if (empty($username)){
            $message = "Enter the username to delete user.";
            require_once __DIR__ . '/../templates/error.php';
        }
        elseif (!preg_match("/^[a-zA-Z0-9]*$/", $username)){
            $message = "Invalid username.(only lowercase, uppercase and number are permit.";
            require_once __DIR__ . '/../templates/error.php';
        }
        else{
            $sql = "SELECT userName FROM users WHERE userName=?";
            $stmt = mysqli_stmt_init($conn);
            if(!mysqli_stmt_prepare($stmt, $sql)){
                $message = "SQL error.";
                require_once __DIR__ . '/../templates/error.php';
            }
            else {
                // what data type are passing in s= string
                mysqli_stmt_bind_param($stmt, "s", $username);
                mysqli_stmt_execute($stmt);

                // result we got from the database and store back in the variable
                mysqli_stmt_store_result($stmt);

                // check the result in the database
                $resultCheck = mysqli_stmt_num_rows($stmt);
                if ($resultCheck == 0){
                    $message = "no username exist.";
                    require_once __DIR__ . '/../templates/error.php';
                }
                else{

                    $sql = "DELETE FROM users WHERE userName=?";
                    $stmt = mysqli_stmt_init($conn);
                    if(!mysqli_stmt_prepare($stmt, $sql)){
                        $message = "SQL error.";
                        require_once __DIR__ . '/../templates/error.php';
                    }
                    else{

                        mysqli_stmt_bind_param($stmt, "s", $username);
                        mysqli_stmt_execute($stmt);
                        $message = "User has been delete";
                        require_once __DIR__ . '/../templates/message.php';
                    }
                }

            }
            mysqli_stmt_close($stmt);
            mysqli_close($conn);
        }
    }

    public function deleteMeal()
    {
        $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        $mealName = filter_input(INPUT_POST, 'mealName');

        if (empty($mealName)){
            $message = "Enter the meal name to delete.";
            require_once __DIR__ . '/../templates/error.php';
        }
        elseif (!preg_match("/^[a-zA-Z_ -]*$/", $mealName)){
            $message = "Invalid meal name.";
            require_once __DIR__ . '/../templates/error.php';
        }
        else{
            $sql = "SELECT mealName FROM meal WHERE mealName=?";
            $stmt = mysqli_stmt_init($conn);
            if(!mysqli_stmt_prepare($stmt, $sql)){
                $message = "SQL error.";
                require_once __DIR__ . '/../templates/error.php';
            }
            else {
                // what data type are passing in s= string
                mysqli_stmt_bind_param($stmt, "s", $mealName);
                mysqli_stmt_execute($stmt);

                // result we got from the database and store back in the variable
                mysqli_stmt_store_result($stmt);

                // check the result in the database
                $resultCheck = mysqli_stmt_num_rows($stmt);
                if ($resultCheck == 0){
                    $message = "no meal exist.";
                    require_once __DIR__ . '/../templates/error.php';
                }
                else{

                    $sql = "DELETE FROM meal WHERE mealName=?";
                    $stmt = mysqli_stmt_init($conn);
                    if(!mysqli_stmt_prepare($stmt, $sql)){
                        $message = "SQL error.";
                        require_once __DIR__ . '/../templates/error.php';
                    }
                    else{

                        mysqli_stmt_bind_param($stmt, "s", $mealName);
                        mysqli_stmt_execute($stmt);
                        $message = "Meal has been delete";
                        require_once __DIR__ . '/../templates/message.php';
                    }
                }

            }
            mysqli_stmt_close($stmt);
            mysqli_close($conn);
        }
    }

    public function processGenerateMeal()
    {
        $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        $mealName = filter_input(INPUT_POST, 'mealName');
        $category = filter_input(INPUT_POST, 'mealCategory');
        $calories = filter_input(INPUT_POST, 'mealCalories');
        $carbohydrates = filter_input(INPUT_POST, 'mealCarbohydrates');
        $protein = filter_input(INPUT_POST, 'mealProtein');
        $fat = filter_input(INPUT_POST, 'mealFat');

        if (empty($mealName) || empty($category) || empty($calories) || empty($carbohydrates)|| empty($protein)|| empty($fat)){
            $message = "Fill in all fields.";
            require_once __DIR__ . '/../templates/error.php';
        }
        elseif (!preg_match("/^[a-zA-Z_ -]*$/", $mealName)){
            $message = "Invalid meal name.";
            require_once __DIR__ . '/../templates/error.php';
        }
        elseif (!preg_match("/^[a-zA-Z_ -]*$/", $category)){
            $message = "Invalid category.";
            require_once __DIR__ . '/../templates/error.php';
        }
        elseif (!preg_match("/^[0-9.]*$/", $calories)){
            $message = "Invalid calories.";
            require_once __DIR__ . '/../templates/error.php';
        }
        elseif (!preg_match("/^[0-9.]*$/", $carbohydrates)){
            $message = "Invalid carbohydrates.";
            require_once __DIR__ . '/../templates/error.php';
        }
        elseif (!preg_match("/^[0-9.]*$/", $protein)){
            $message = "Invalid protein.";
            require_once __DIR__ . '/../templates/error.php';
        }
        elseif (!preg_match("/^[0-9.]*$/", $fat)){
            $message = "Invalid fat.";
            require_once __DIR__ . '/../templates/error.php';
        }
        else {

            // enter the database
            $sql = "SELECT mealName FROM meal WHERE mealName=?";
            $stmt = mysqli_stmt_init($conn);
            if(!mysqli_stmt_prepare($stmt, $sql)){
                $message = "SQL error.";
                require_once __DIR__ . '/../templates/error.php';
            }
            else{
                // what data type are passing in s= string
                mysqli_stmt_bind_param($stmt, "s", $mealName);
                mysqli_stmt_execute($stmt);

                // result we got from the database and store back in the variable
                mysqli_stmt_store_result($stmt);

                // check the result in the database
                $resultCheck = mysqli_stmt_num_rows($stmt);
                if ($resultCheck > 0){
                    $message = "Meal is already exist.";
                    require_once __DIR__ . '/../templates/error.php';
                }
                else {
                    $sql = "INSERT INTO meal(mealName, category, foodCalories, foodCarbs, foodProtein, foodFat) VALUE(?, ?, ?, ?, ?, ?)";
                    $stmt = mysqli_stmt_init($conn);
                    if (!mysqli_stmt_prepare($stmt, $sql)) {
                        $message = "SQL error.";
                        require_once __DIR__ . '/../templates/error.php';
                    } else {
                        mysqli_stmt_bind_param($stmt, "ssssss", $mealName, $category, $calories, $carbohydrates, $protein, $fat);
                        mysqli_stmt_execute($stmt);
                        $message = "Meal create successful.";
                        require_once __DIR__ . '/../templates/message.php';
                    }
                }
            }
            mysqli_stmt_close($stmt);
            mysqli_close($conn);
        }
    }

    public function processGenerateMealPlan()
    {
        $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        $calories = filter_input(INPUT_POST, 'calories');
        $meal = filter_input(INPUT_POST, 'meal');
        $caloriesPerMeal = $calories/$meal;
        $minCalories = $caloriesPerMeal - 25;
        $maxCalories = $caloriesPerMeal + 25;


        if (empty($calories) || empty($meal)){
            $message = "Fill in all fields.";
            require_once __DIR__ . '/../templates/error.php';
        }
        elseif (!preg_match("/^[0-9]*$/", $calories)){
            $message = "Invalid calories.";
            require_once __DIR__ . '/../templates/error.php';
        }
        elseif (!preg_match("/^[0-9]*$/", $meal)){
            $message = "Invalid meal.";
            require_once __DIR__ . '/../templates/error.php';
        }
        else {
            for ($x = 1; $x <= $meal; $x++){
                echo "<hr>";
                if($x == 1){
                    echo "<br><br>". "First meal";
                }
                elseif($x == 2){
                    echo "<br><br>". "Second meal";
                }
                elseif($x == 3){
                    echo "<br><br>". "Third meal";
                }
                elseif($x == 4){
                    echo "<br><br>". "Fourth meal";
                }
                $sql = "SELECT * FROM meal WHERE foodCalories BETWEEN $minCalories AND $maxCalories ORDER BY RAND() LIMIT 1";
                $stmt = mysqli_stmt_init($conn);
                $qryResult = mysqli_query($conn, $sql);

                if(!mysqli_stmt_prepare($stmt, $sql)){
                    $message = "SQL error.";
                    require_once __DIR__ . '/../templates/error.php';
                }
                else{
                    $myMeal = New meal();
                    $meals = array();

                    if (mysqli_num_rows($qryResult) > 0) {
                        while ($row = mysqli_fetch_assoc($qryResult)) {

                            $myMeal->setMealId($row["mealID"]); // $row[from database]
                            $myMeal->setMealName($row["mealName"]);
                            $myMeal->setCategory($row["category"]);
                            $myMeal->setFoodCalories($row["foodCalories"]);
                            $myMeal->setFoodCarbs($row["foodCarbs"]);
                            $myMeal->setFoodProtein($row["foodProtein"]);
                            $myMeal->setFoodFat($row["foodFat"]);

                            $myMeal->displayMeal();
                            array_push($meals, $myMeal);

                            $Id = $myMeal->getMealId();
                            echo "<br>this is meal id:" .$Id;

                            $mealPlanIdSql = "SELECT * from mealplan";
                            $mealPlanIdStmt = mysqli_stmt_init($conn);
                            $mealPlanQryResult = mysqli_query($conn, $mealPlanIdSql);

                            if (!mysqli_stmt_prepare($mealPlanIdStmt, $mealPlanIdSql)) {
                                echo "SQL error.";
                            } else {
                                $mealPlanId = New mealPlan();
                                $displayMealPlanId = 0;

                                if (mysqli_num_rows($mealPlanQryResult) > 0) {
                                    while ($mealPlanIdRow = mysqli_fetch_assoc($mealPlanQryResult)) {

                                        $mealPlanId->setMealPlanId($mealPlanIdRow["mealPlanId"]);
                                        $displayMealPlanId = $mealPlanIdRow["mealPlanId"];
                                    }
                                }
                                $sql = "SELECT * FROM mealplanhasmeal;";
                                $stmt = mysqli_stmt_init($conn);
                                echo "<br>this is meal plan id".$displayMealPlanId;
                                if(!mysqli_stmt_prepare($stmt, $sql)){
                                    echo "SQL error.";
                                }
                                else{
                                    $sql = "INSERT INTO mealplanhasmeal (mealPlanId, mealId) VALUES (?,?)";

                                    $stmt = mysqli_stmt_init($conn);
                                    if (!mysqli_stmt_prepare($stmt, $sql)) {
                                        echo "SQL error.";
                                    } else {
                                        mysqli_stmt_bind_param($stmt, "ii", $displayMealPlanId,$Id);
                                        mysqli_stmt_execute($stmt);
                                    }
                                }
                            }
                        }
                    }
                    else {
                        echo "<br>Please enter smaller calories.";
                    }
                    mysqli_stmt_close($stmt);
                }
            }
            mysqli_close($conn);
        }
    }

    public function insertAmountMealToMealPlan()
    {
        $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        $meal = filter_input(INPUT_POST, 'meal');

        $sql = "SELECT * From mealplan WHERE amountOfMeal=?; ";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $sql)){
            echo "SQL error.";
        }
        else{
            $sql = "INSERT INTO mealplan(amountOfMeal) VALUE(?)";
            $stmt = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($stmt, $sql)) {
                echo "SQL error.";
            } else {
                mysqli_stmt_bind_param($stmt, "i", $meal);
                mysqli_stmt_execute($stmt);
            }
        }
    }

    public function insertDataToMealPlanHasMeal()
    {
        $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        $mealPlanIdSql = "SELECT * from mealplan";
        $mealPlanIdStmt = mysqli_stmt_init($conn);
        $mealPlanQryResult = mysqli_query($conn, $mealPlanIdSql);

        if (!mysqli_stmt_prepare($mealPlanIdStmt, $mealPlanIdSql)) {
            echo "SQL error.";
        } else {
            $mealPlanId = New mealPlan();
            $displayMealId = 0;

            if (mysqli_num_rows($mealPlanQryResult) > 0) {
                while ($mealPlanIdRow = mysqli_fetch_assoc($mealPlanQryResult)) {

                    $mealPlanId->setMealPlanId($mealPlanIdRow["mealPlanId"]);
                    $displayMealId = $mealPlanIdRow["mealPlanId"];
                }
            }
            $sql = "INSERT INTO mealplanhasmeal(mealPlanId) VALUE(?)";
            $Stmt = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($Stmt, $sql)) {
                echo "SQL error";
            } else {
                mysqli_stmt_bind_param($Stmt, "i", $displayMealId);
                mysqli_stmt_execute($Stmt);
            }
        }
    }

    public function insertUserIdToMealPlan(){

        $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        $username = $this->sessionManager->usernameFromSession();
        $sql = "SELECT * From users WHERE userName = '$username'";
        $Stmt = mysqli_stmt_init($conn);
        $qryResult = mysqli_query($conn, $sql);

        if(!mysqli_stmt_prepare($Stmt, $sql)){
            echo "SQL error.";
        }
        else {
            $userId = New user();
            $displayUserId = 0;

            if (mysqli_num_rows($qryResult) > 0) {
                while ($row = mysqli_fetch_assoc($qryResult)) {

                    $userId->setUserId($row["userId"]);
                    $displayUserId = $row["userId"];
                }
            }
        }
        $mealPlanIdSql = "SELECT * from mealplan";
        $mealPlanIdStmt = mysqli_stmt_init($conn);
        $mealPlanQryResult = mysqli_query($conn, $mealPlanIdSql);

        if(!mysqli_stmt_prepare($mealPlanIdStmt, $mealPlanIdSql)){
            echo "SQL error.";
        }
        else {
            $mealPlanId = New mealPlan();
            $displayMealId = 0;

            if (mysqli_num_rows($mealPlanQryResult) > 0) {
                while ($mealPlanIdRow = mysqli_fetch_assoc($mealPlanQryResult)) {

                    $mealPlanId->setMealPlanId($mealPlanIdRow["mealPlanId"]);
                    $displayMealId = $mealPlanIdRow["mealPlanId"];
                }
            }
        }
        $takeUserIdSql = "UPDATE mealPlan SET userId=? WHERE mealPlanId = $displayMealId;";
        $takeUserIdStmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($takeUserIdStmt, $takeUserIdSql)) {
            echo "SQL error";
        } else {
            mysqli_stmt_bind_param($takeUserIdStmt, "i", $displayUserId);
            mysqli_stmt_execute($takeUserIdStmt);
        }
    }

    public function createReview()
    {
        $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        $mealPlanIdSql = "SELECT * from mealplan";
        $mealPlanIdStmt = mysqli_stmt_init($conn);
        $mealPlanQryResult = mysqli_query($conn, $mealPlanIdSql);

        if (!mysqli_stmt_prepare($mealPlanIdStmt, $mealPlanIdSql)) {
            echo "SQL error.";
        } else {
            $mealPlanId = New mealPlan();
            $displayMealId = 0;

            if (mysqli_num_rows($mealPlanQryResult) > 0) {
                while ($mealPlanIdRow = mysqli_fetch_assoc($mealPlanQryResult)) {

                    $mealPlanId->setMealPlanId($mealPlanIdRow["mealPlanId"]);
                    $displayMealId = $mealPlanIdRow["mealPlanId"];
                }
            }
        }

        $insertMealIdToReviewSql = "INSERT INTO review(mealPlanId) VALUE(?)";
        $insertMealIdToReviewStmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($insertMealIdToReviewStmt, $insertMealIdToReviewSql)) {
            $message = "SQL error.";
            require_once __DIR__ . '/../templates/error.php';
        } else {
            mysqli_stmt_bind_param($insertMealIdToReviewStmt, "i", $displayMealId);
            mysqli_stmt_execute($insertMealIdToReviewStmt);
        }

        $CreateReviewIdSql = "SELECT * From review;";
        $CreateReviewIdStmt = mysqli_stmt_init($conn);
        $qryResult = mysqli_query($conn, $CreateReviewIdSql);

        if(!mysqli_stmt_prepare($CreateReviewIdStmt, $CreateReviewIdSql)){
            echo "SQL error.";
        }
        else {
            $reviewId = New review();
            $displayReviewId = 0;

            if (mysqli_num_rows($qryResult) > 0) {
                while ($row = mysqli_fetch_assoc($qryResult)) {

                    $reviewId->setReviewId($row["reviewId"]);
                    $displayReviewId = $row["reviewId"];
                }
            }
            echo "<p><b>Review ID is: " . $displayReviewId;
        }
    }

    public function editProcessGenerateMeal()
    {
        $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        $mealName = filter_input(INPUT_POST, 'mealName');
        $category = filter_input(INPUT_POST, 'mealCategory');
        $calories = filter_input(INPUT_POST, 'mealCalories');
        $carbohydrates = filter_input(INPUT_POST, 'mealCarbohydrates');
        $protein = filter_input(INPUT_POST, 'mealProtein');
        $fat = filter_input(INPUT_POST, 'mealFat');

        if (empty($mealName) || empty($category) || empty($calories) || empty($carbohydrates)|| empty($protein)|| empty($fat)){
            $message = "Fill in all fields.";
            require_once __DIR__ . '/../templates/error.php';

        }
        elseif (!preg_match("/^[a-zA-Z_ -]*$/", $mealName)){
            $message = "Invalid meal name.";
            require_once __DIR__ . '/../templates/error.php';
        }
        elseif (!preg_match("/^[a-zA-Z_ -]*$/", $category)){
            $message = "Invalid category.";
            require_once __DIR__ . '/../templates/error.php';
        }
        elseif (!preg_match("/^[0-9.]*$/", $calories)){
            $message = "Invalid calories.";
            require_once __DIR__ . '/../templates/error.php';
        }
        elseif (!preg_match("/^[0-9.]*$/", $carbohydrates)){
            $message = "Invalid carbohydrates.";
            require_once __DIR__ . '/../templates/error.php';
        }
        elseif (!preg_match("/^[0-9.]*$/", $protein)){
            $message = "Invalid protein.";
            require_once __DIR__ . '/../templates/error.php';
        }
        elseif (!preg_match("/^[0-9.]*$/", $fat)){
            $message = "Invalid fat.";
            require_once __DIR__ . '/../templates/error.php';
        }
        else {

            // enter the database
            $sql = "SELECT mealName FROM meal WHERE mealName=?";
            $stmt = mysqli_stmt_init($conn);
            if(!mysqli_stmt_prepare($stmt, $sql)){
                $message = "SQL error.";
                require_once __DIR__ . '/../templates/error.php';
            }
            else{
                // what data type are passing in s= string
                mysqli_stmt_bind_param($stmt, "s", $mealName);
                mysqli_stmt_execute($stmt);

                // result we got from the database and store back in the variable
                mysqli_stmt_store_result($stmt);

                // check the result in the database
                $resultCheck = mysqli_stmt_num_rows($stmt);
                if ($resultCheck == 0){
                    $message = "Meal is not exist.";
                    require_once __DIR__ . '/../templates/error.php';
                }
                else {
                    $sql = "UPDATE meal SET category=?, foodCalories=?, foodCarbs=?, foodProtein=?, foodFat=? WHERE mealname=?";
                    $stmt = mysqli_stmt_init($conn);
                    if (!mysqli_stmt_prepare($stmt, $sql)) {
                        $message = "SQL error.";
                        require_once __DIR__ . '/../templates/error.php';
                    } else {
                        mysqli_stmt_bind_param($stmt, "ssssss", $category, $calories, $carbohydrates, $protein, $fat, $mealName);
                        mysqli_stmt_execute($stmt);
                        $message = "Meal edit create successful.";
                        require_once __DIR__ . '/../templates/message.php';
                    }
                }
            }
            mysqli_stmt_close($stmt);
            mysqli_close($conn);
        }
    }

    public function displayAllUser()
    {
        $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        $sql = "SELECT * FROM users;";
        $qryResult = mysqli_query($conn, $sql);

        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        $myUser = New user();
        $users = array();

        if (mysqli_num_rows($qryResult) > 0) {

            while ($row = mysqli_fetch_assoc($qryResult)) {

                $myUser->setUserId($row["userId"]); // $row[from database]
                $myUser->setUserName($row["userName"]);
                $myUser->setPassword($row["password"]);
                $myUser->setEmail($row["email"]);
                $myUser->setFirstName($row["firstName"]);
                $myUser->setLastName($row["lastName"]);
                $myUser->setGender($row["gender"]);
                $myUser->setAge($row["age"]);

                $myUser->displayUsers();
                array_push($users, $myUser);
            }
        }
        else {
            echo "0 results";
        }
        mysqli_close($conn);
    }

    public function displayFoods()
    {
        $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        $sql = "SELECT * FROM meal;";
        $qryResult = mysqli_query($conn, $sql);

        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        $myMeal = New meal();
        $meals = array();

        if (mysqli_num_rows($qryResult) > 0) {

            while ($row = mysqli_fetch_assoc($qryResult)) {

                $myMeal->setMealId($row["mealID"]); // $row[from database]
                $myMeal->setMealName($row["mealName"]);
                $myMeal->setCategory($row["category"]);
                $myMeal->setFoodCalories($row["foodCalories"]);
                $myMeal->setFoodCarbs($row["foodCarbs"]);
                $myMeal->setFoodProtein($row["foodProtein"]);
                $myMeal->setFoodFat($row["foodFat"]);

                $myMeal->displayMeal();
                array_push($meals, $myMeal);
            }
        }
        else {
            echo "0 results";
        }
        mysqli_close($conn);
    }
}