<?php session_start();

require_once('functions/alert.php');
require_once('functions/redirect.php');
require_once('functions/user.php');

//TODO REDIRECT PROPERLY AND CHANGE STATUS TO PAID
$id = $_GET['id'];
//$appointmentObject = get_appointment_by_id($appointmentId);

if($id != ''){
$appointmentString = file_get_contents("db/appointments/".$id . ".json");
$appointmentObject = json_decode($appointmentString);  
date_default_timezone_set("Africa/Lagos");
$timeOfPayment = date("Y/m/d");
$dateOfPayment = date("h:i:sa"); 
$appointmentObject->paymentStatus = 'Paid';
$appointmentObject->timeOfPayment = $timeOfPayment;
$appointmentObject->dateOfPayment = $dateOfPayment; 
file_put_contents("db/appointments/".$id . ".json", json_encode($appointmentObject));
set_alert('message',"Payment Successful");

redirect_to("/SNH/paybills.php");
die();
}else{
    set_alert('error',"Payment may have been successful, but we could not find your appointment");
    redirect_to('/SNH/dashboard.php');
    die();
}
    
                               
//TODO still not redirecting properly