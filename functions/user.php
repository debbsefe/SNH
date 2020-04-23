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
    file_put_contents("db/appointments/". $appointmentObject['id'] . $appointmentObject['department'] . ".json", json_encode($appointmentObject));
}

function find_appointment(){
    //$allAppointments = scandir("db/appointments/"); //return @array (2 filled)
    $tbody = '';
    $appointments = file_get_contents("db/appointments/1Cardio.json");
    $decodeappoint = json_decode($appointments);
    foreach($decodeappoint as $decode){
        $tbody .= "
             <tr>
                <td>$decode->appointmentDate</td>
                <td>$decode->appointmentTime</td>
                <td>$decode->natureAppointment</td>
                <td>$decode->initialComplaint</td>
                <td>$decode->fullName</td>
            </tr>
            ";
        return $tbody;
    }
}