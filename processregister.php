<?php session_start();
    require_once('functions/user.php');
//error array

$errors = array();

//Verifying the data, validation

$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$email = $_POST['email'];
$password = $_POST['password'];
$gender = $_POST['gender'];
$designation = $_POST['designation'];
$department = $_POST['department'];

// check name
// 1. no number
if(!ctype_alpha($first_name)) {
    // firstname contains a number 
    array_push($errors,'Your first name must contain a number');
}
// 2. not less than 2 characters
else if(strlen($first_name) < 2) {
    array_push($errors, "First name cannot be less than 2 characters");
}
// 3. not blank
else if($first_name == "") {
    array_push($errors, "First name cannot be blank");
}else{
    $_SESSION['first_name'] = $first_name;
}

// check lastname
// 1. no number
if(!ctype_alpha($last_name)) {
    // lastname contains a number 
    array_push($errors, 'Your last name must contain a number');
}
// 2. not less than 2 characters
else if(strlen($last_name) < 2) {
    array_push($errors, "Last name cannot be less than 2 characters");
}
// 3. not blank
else if(empty($last_name)){
    array_push($errors, "Last name cannot be blank");
}else{
    $_SESSION['last_name'] = $last_name;
}

//check email
//1. email must not be empty
if ($email == "") {
    array_push($errors, "Email must not be empty");
  } 
//2. email must not be less than 5 characters
else if(strlen($email) < 5) {
    array_push($errors, "Email must not be less than 5 characters");
}
//3. email must have . and @ in it/valid email
else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    array_push($errors, "Invalid email format / email must include @ and .");
}else{
    $_SESSION['email'] = $email;
}

//CHECK PASSWORD
if ($password == "") {
    array_push($errors, "Password  cannot be empty");
  } 

//CHECK GENDER
if ($gender == "") {
    array_push($errors, "Gender cannot be empty");
  } 
//CHECK DESIGNATION
if ($designation == "") {
    array_push($errors, "Designation cannot be empty");
  } 

//Store error in a list
$errors_output = "<ul>";
foreach($errors as $error) {
    $errors_output .= '
        <li>'.$error.'</li>';
}
$errors_output .= '</ul>';

//FORM INPUT SESSIONS
$_SESSION['gender'] = $gender;
$_SESSION['designation'] = $designation;
$_SESSION['department'] = $department;


if(!empty($errors)){
    $_SESSION['error'] = $errors_output;
    header("Location: register.php");

} else{
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