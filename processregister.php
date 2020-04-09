<?php session_start();
    require_once('functions/user.php');
//Collecting the data

$errorCount = 0;

$errors = array();

//Verifying the data, validation

$first_name = $_POST['first_name'] != "" ? $_POST['first_name'] :  $errorCount++;
$last_name = $_POST['last_name'] != "" ? $_POST['last_name'] :  $errorCount++;
$email = $_POST['email'] != "" ? $_POST['email'] :  $errorCount++;
$password = $_POST['password'] != "" ? $_POST['password'] :  $errorCount++;
$gender = $_POST['gender'] != "" ? $_POST['gender'] :  $errorCount++;
$designation = $_POST['designation'] != "" ? $_POST['designation'] :  $errorCount++;
$department = $_POST['department'] != "" ? $_POST['department'] :  $errorCount++;

// check name


// 1. no number
if(!ctype_alpha($first_name)) {
    // firstname contains a number 
    array_push($errors,'Your first name must contain a number');
}

// 2. not less than 2 characters
if(strlen($first_name) < 2) {
    array_push($errors, "First name cannot be less than 2 characters");
}

// 3. not blank
if($first_name == "") {
    array_push($errors, "First name cannot be blank");
}


// check lastname

// 1. no number
if(!ctype_alpha($last_name)) {
    // lastname contains a number 
    array_push($errors, 'Your last name must contain a number');
}

// 2. not less than 2 characters
if(strlen($last_name) < 2) {
    array_push($errors, "Last name cannot be less than 2 characters");
}

// 3. not blank
if(empty($last_name)){
    array_push($errors, "Last name cannot be blank");
}

//check email

//1. email must not be empty
if ($email == "") {
    array_push($errors, "Email must not be empty");

  } 
//2. email must not be less than 5 characters
if(strlen($email) < 5) {
    array_push($errors, "Email must not be less than 5 characters");
}

//3. email must have . and @ in it/valid email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    array_push($errors, "Invalid email format / email must include @ and .");
  }



$errors_output = "<ul>";
foreach($errors as $error) {
    $errors_output .= '
        <li>'.$error.'</li>';
}

$errors_output .= '</ul>';

$_SESSION['errors_output'] = $errors_output;







$_SESSION['first_name'] = $first_name;
$_SESSION['last_name'] = $last_name;
$_SESSION['email'] = $email;
$_SESSION['gender'] = $gender;
$_SESSION['designation'] = $designation;
$_SESSION['department'] = $department;


if($errorCount > 0){

     $session_error = "You have " . $errorCount . " error";
    
    if($errorCount > 1) {        
        $session_error .= "s";
    }

    $session_error .=   " in your form submission";
    $_SESSION["error"] = $session_error ;

    header("Location: register.php");

}else{
    $allUsers = scandir("db/users");
    $countAllUsers = count($allUsers);

     $newUserId = ($countAllUsers - 1);
     date_default_timezone_set("Africa/Lagos");
     $registerDate = date("l, jS F Y - g:i:s A");

    $userObject = [
        'id'=>$newUserId,
        'first_name'=>$first_name,
        'last_name'=>$last_name,
        'email'=>$email,
        'password'=> password_hash($password, PASSWORD_DEFAULT), //password hashing
        'gender'=>$gender,
        'designation'=>$designation,
        'department'=>$department,
        'registerDate'=> $registerDate,
        'lastLogin' => '',
    ];

    //Check if the user already exists.
    $userExists = find_user($email);

        if($userExists){
            $_SESSION["error"] = "Registration Failed, User already exits ";
            header("Location: register.php");
            die();
        }
        

    //save in the database;
    save_user($userObject);

    $_SESSION["message"] = "Registration Successful, you can now login " . $first_name;
    header("Location: login.php");
}

