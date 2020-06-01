<?php include_once('alert.php');

function is_user_loggedIn(){

    if($_SESSION['loggedIn'] && !empty($_SESSION['loggedIn'])) {
        return true;
    }

    return false;
}

function is_token_set(){

    return is_token_set_in_get() || is_token_set_in_session();

}

function is_token_set_in_session(){

    return  isset($_SESSION['token']);

}

function is_token_set_in_get(){

    return isset($_GET['token']); 

}

function find_user($email = ""){
    //check the database if the user exsits
    if(!$email){
        set_alert('error','User Email is not set');
        die();
    }

    $allUsers = scandir("db/users/"); //return @array (2 filled)
    $countAllUsers = count($allUsers);

    for ($counter = 0; $counter < $countAllUsers ; $counter++) {
       
        $currentUser = $allUsers[$counter];

        if($currentUser == $email . ".json"){
          //check the user password.
            $userString = file_get_contents("db/users/".$currentUser);
            $userObject = json_decode($userString);
                       
            return $userObject;     
        }               
    }

    return false;
}

function save_user($userObject){
    file_put_contents("db/users/". $userObject['email'] . ".json", json_encode($userObject));
}

function save_appointment($appointmentObject){
    file_put_contents("db/appointments/". $appointmentObject['id'] . ".json", json_encode($appointmentObject));
}

function get_appointments($department){
    $tbody = '';
    $rowNumber = 0;
    $allAppointments = scandir('db/appointments/');
    $countAllAppoints = count($allAppointments);
    for ($i = 2; $i < $countAllAppoints; $i++){

        $appointment = json_decode(file_get_contents('db/appointments/' . $allAppointments[$i]));
        if ($appointment->department == $department) {
            $rowNumber++;
            $tbody .= "
             <tr>
                <td>$rowNumber</td>
                <td>$appointment->fullName</td>
                <td>$appointment->appointmentDate</td>
                <td>$appointment->appointmentTime</td>
                <td>$appointment->natureAppointment</td>
                <td>$appointment->initialComplaint</td>
                <td>$appointment->paymentStatus</td>
            </tr>
            ";
        }
    }
    if (!empty($tbody)) {
        return $tbody;
    }
}

function view_staffs(){
    $tbody = '';
    $rowNumber = 0;
    $allStaffs = scandir('db/users/');
    $countAllStaffs = count($allStaffs);
    for($i = 2; $i < $countAllStaffs; $i++){
        $staffs = json_decode(file_get_contents('db/users/' . $allStaffs[$i]));
        if ($staffs->designation == 'Medical Team (MT)') {
            $rowNumber++;
            $tbody .= "
             <tr>
                <td>$rowNumber</td>
                <td>$staffs->first_name  $staffs->last_name </td>
                <td>$staffs->department</td>
            </tr>
            ";
        }
    }
    return $tbody;
}

function view_patients(){
    $tbody = '';
    $rowNumber = 0;
    $allPatients = scandir('db/users/');
    $countAllPatients = count($allPatients);
    for($i = 2; $i < $countAllPatients; $i++){
        $patients = json_decode(file_get_contents('db/users/' . $allPatients[$i]));
        if ($patients->designation == 'Patient') {
            $rowNumber++;
            $tbody .= "
             <tr>
                <td>$rowNumber</td>
                <td>$patients->first_name  $patients->last_name </td>
            </tr>
            ";
        }
    }
    return $tbody;
}

function generateTxref(){
    $txref = "SNH";
    for($i = 0; $i<12; $i++){
        $txref .= mt_rand(0, 11);

    }
    return $txref;
}

function getUserAppointment($email){

    $tbody = '';
    $rowNumber = 0;
    $allAppointments = scandir('db/appointments/');
    $countAllAppoints = count($allAppointments);
    for ($i = 2; $i < $countAllAppoints; $i++){

        $appointment = json_decode(file_get_contents('db/appointments/' . $allAppointments[$i]));
        if ($appointment->email == $email) {
            $rowNumber++;
            $tbody .= "
             <tr>
                <td>$rowNumber</td>
                <td>$appointment->appointmentDate</td>
                <td>$appointment->appointmentTime</td>
                <td>$appointment->natureAppointment</td>
                <td>$appointment->initialComplaint</td>
                <td>$appointment->paymentStatus</td>
            </tr>
            ";
        }
    }
    if (!empty($tbody)) {
        return $tbody;
    }

}

function viewallpayments(){

    $tbody = '';
    $rowNumber = 0;
    $allAppointments = scandir('db/appointments/');
    $countAllAppoints = count($allAppointments);
    for ($i = 2; $i < $countAllAppoints; $i++){

        $appointment = json_decode(file_get_contents('db/appointments/' . $allAppointments[$i]));
        if ($appointment->paymentStatus == 'Paid') {
            $rowNumber++;
            $tbody .= "
             <tr>
                <td>$rowNumber</td>
                <td>$appointment->fullName</td>
                <td>$appointment->appointmentDate</td>
                <td>$appointment->appointmentTime</td>
                <td>$appointment->natureAppointment</td>
                <td>$appointment->initialComplaint</td>
                <td>$appointment->department</td>
                <td>$appointment->paymentStatus</td>
                <td>$appointment->timeOfPayment</td>
                <td>$appointment->dateOfPayment</td>
            </tr>
            ";
        }
    }
    if (!empty($tbody)) {
        return $tbody;
    }

}

function get_patient_appointment($patient_email) {
    $allAppointments = [];
  
    $appointmentsInDb = scandir("db/appointments");
    $countAllAppointments = count($appointmentsInDb);
  
    for ($counter = 2; $counter < $countAllAppointments; $counter++) {
      $currentAppointment = $appointmentsInDb[$counter];
      $currentAppointmentString = file_get_contents("db/appointments/".$currentAppointment);
      $currentAppointmentObject = json_decode($currentAppointmentString);
      $patientEmail = $currentAppointmentObject->email;
      if ($patient_email == $patientEmail) {
        array_push($allAppointments, $currentAppointmentObject);
      }
    }
    return $allAppointments;
  }
//THIS DOES NOT RETURN ANYTHING DESPITE LOADS BEING IN THERE