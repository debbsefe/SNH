<?php session_start();
require_once('functions/user.php');

//error array
$errors = array();

//Verifying the data, validation
$appointmentDate = $_POST['appointmentDate'];
$appointmentTime = $_POST['appointmentTime'];
$natureAppointment = $_POST['natureAppointment'];
$initialComplaint = $_POST['initialComplaint'];
$department = $_POST['department'];

//check for appointment date
if($appointmentDate == "") {
    array_push($errors, "Date of appointment date cannot be blank");
}else{
    $_SESSION['appointmentDate'] = $appointmentDate;
}

//check for appointment time
if($appointmentTime == "") {
    array_push($errors, "Time of appointment cannot be blank");
}else{
    $_SESSION['appointmentTime'] = $appointmentTime;
}

// check for nature of appointment
if(strlen($natureAppointment) < 3) {
    array_push($errors, "Nature of appointment cannot be less than 3 characters");
}else if($natureAppointment == "") {
    array_push($errors, "Nature of appointment cannot be blank");
}else{
    $_SESSION['natureAppointment'] = $natureAppointment;
}

//check for initial complaint
if(strlen($initialComplaint) < 3) {
    array_push($errors, "Initial Complaint cannot be less than 3 characters");
}else if($initialComplaint == "") {
    array_push($errors, "Initial Complaint cannot be blank");
}else{
    $_SESSION['initialComplaint'] = $initialComplaint;
}

//check for department
if($department == "") {
    array_push($errors, "Department cannot be blank");
}else{
    $_SESSION['department'] = $department;
}

//Insert into database
if(!empty($errors)){
    $errors_output = "<ul>";
        foreach($errors as $error) {
        $errors_output .= '
        <li>'.$error.'</li>';
    }
    $errors_output .= '</ul>';
    $_SESSION['error'] = $errors_output;
    header("Location: bookappointments.php");

}else{
    
    $allAppointments = scandir("db/appointments");
    $countAllAppointments = count($allAppointments);

     $newAppointmentId = ($countAllAppointments - 1);
    
    $appointmentObject = [
        'id'=>$newAppointmentId,
        'appointmentDate'=>$appointmentDate,
        'appointmentTime'=>$appointmentTime,
        'natureAppointment'=>$natureAppointment,
        'initialComplaint'=>$initialComplaint,
        'department'=>$department,
        'fullName' => $_SESSION['fullname'],
    ];
        
    //save in the database;
    save_appointment($appointmentObject);

    $_SESSION["message"] = "Appointment Booked Successfully";
    header("Location: dashboard.php");
}

//TODO CLEAR FORM AFTER SUBMIT