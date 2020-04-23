<?php include_once('lib/header.php'); 

if(!isset($_SESSION['loggedIn'])){
    // redirect to dashboard
    header("Location: login.php");
}
require_once('functions/alert.php');
?>


<div class="container">

<h3>Book appointments</h3>
<p>Fill the form below to book an appointment</p>

        <form class="form-group" action="processappointments.php" method="post">
            <p>
            <?php  print_alert(); ?>
            </p>
            <p>
                <label>Date of Appointment</label><br>
                <input 
                <?php              
                    if(isset($_SESSION['appointmentDate'])){
                        echo "value=" . $_SESSION['appointmentDate'];;                                                            
                    }                
                ?>
                type="date" id="appointmentDate" name="appointmentDate" class="form-control" value="">
            </p>
            <p>
                <label>Time of Appointment</label>
                <input 
                <?php              
                    if(isset($_SESSION['appointmentTime'])){
                        echo "value=" . $_SESSION['appointmentTime'];;                                                             
                    }                
                ?>
                type="time" id="appointmentTime" name="appointmentTime" class="form-control" value="">

            </p>
            <p>
                <label>Nature of Appointment</label><br>
                <input 
                <?php              
                    if(isset($_SESSION['natureAppointment'])){
                        echo "value=" . $_SESSION['natureAppointment'];                                                             
                    }                
                ?>
                type="text" id="natureAppointment" name="natureAppointment" class="form-control" value="">
            </p>
            <p>
                <label>Initial Complaint</label>
                <input 
                <?php              
                    if(isset($_SESSION['initialComplaint'])){
                        echo "value=" . $_SESSION['initialComplaint'];                                                             
                    }                
                ?>
                type="text" id="initialComplaint" name="initialComplaint" class="form-control" value="">
            </p>
            <p>
                <label>Department you are booking for</label>
                <select class="form-control" name="department">
                    <option value="">Select One</option>
                    <option
                    <?php              
                        if(isset($_SESSION['department']) && $_SESSION['department'] == 'Cardio'){
                            echo "selected";                                                           
                        }                
                    ?>
                    >Cardio</option>
                    <option
                    <?php              
                        if(isset($_SESSION['department']) && $_SESSION['department'] == 'Surgery'){
                            echo "selected";                                                           
                        }                
                    ?>
                    >Surgery</option>
                    <option
                    <?php              
                        if(isset($_SESSION['department']) && $_SESSION['department'] == 'Paediatrics'){
                            echo "selected";                                                           
                        }                
                    ?>
                    >Paediatrics</option>
                    <option
                    <?php              
                        if(isset($_SESSION['department']) && $_SESSION['department'] == 'Dentistry'){
                            echo "selected";                                                           
                        }                
                    ?>
                    >Dentistry</option>
                    <option
                    <?php              
                        if(isset($_SESSION['department']) && $_SESSION['department'] == 'Laboratory'){
                            echo "selected";                                                           
                        }                
                    ?>
                    >Laboratory</option>
                </select>
            </p>
            <p>
                <button class="btn btn-block btn-primary" type="submit">Submit</button>
            </p>
        </form>
    
</div>
