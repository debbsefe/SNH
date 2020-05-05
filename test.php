<?php include_once('lib/header.php');
require_once('functions/user.php');
if(!isset($_SESSION['loggedIn']) || $_SESSION["role"] != "Patient"){
    // redirect to dashboard
    header("Location: login.php"); 
}

$email = $_SESSION['email'];

        
?>
<div class="container">
   
        <h2 class="mb-5">Pay your bills here</h2>
        
        <?php
        $rowNumber = 0;
        $allAppointments = scandir('db/appointments/');
        $countAllAppoints = count($allAppointments);
        for ($i = 2; $i < $countAllAppoints; $i++){
   
           $appointment = json_decode(file_get_contents('db/appointments/' . $allAppointments[$i]));
           if ($appointment->email == $email) {
            $rowNumber++;
        ?>

        <table class="table table-hover">
            <thead>
            <tr>
                <th scope="col">S/N</th>
                <th scope="col">Date of appointment</th>
                <th scope="col">Time of appointment</th>   
                <th scope="col">Nature of appointment</th>
                <th scope="col">Initial complaint</th>
                <th scope="col">Payment Status</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td><?php echo $rowNumber;?></td>
                <td><?php echo $appointment->appointmentDate;?></td>
                <td><?php echo $appointment->appointmentTime;?></td>
                <td><?php echo $appointment->natureAppointment;?></td>
                <td><?php echo $appointment->initialComplaint; ?></td>
                <td><?php echo $appointment->paymentStatus; ?></td>
                <?php if ($appointment->paymentStatus == 'Not Paid') { ?>
                <td> 
                    <form>
                    <script type="text/javascript" src="https://ravesandboxapi.flutterwave.com/flwv3-pug/getpaidx/api/flwpbf-inline.js"></script>
                    <button class="btn btn-sm btn-primary" type="button" onClick="payWithRave()"
                    <?php              
                      echo "id=" . $appointment->id;                                                                         
                  ?>
                    
                    >Click to pay</button>
                    </form>
                </td>
                <?php } ?>
                </tr>
            </tbody>
           
           
            
        </table>
        <?php }else{ ?>

        <p>You have no booked appointment, please click on the button below to book for an appointment and then return here to pay for your bill </p>  
        <?php } }?>
      
                <a href="bookappointments.php"><button class="btn btn-lg btn-primary">Book an appointment</button></a>

        

    <script>
        const API_publicKey = "FLWPUBK-ebd8ee278d96b79a039b38c9289aabdc-X";
        const sessionEmail = "<?php echo $_SESSION['email']; ?>";
        const txref = "<?php echo generateTxref(); ?>";
        const email = sessionEmail;

        const buttons = document.getElementsByClassName('btn btn-sm btn-primary')
        for (const button of buttons) {
            button.addEventListener('click', function(e) {
            e.preventDefault();
            const appointmentId = e.target.id;
            payWithRave(appointmentId);
            });
        }
        

        function payWithRave(appointmentId) {
            var x = getpaidSetup({
                PBFPubKey: API_publicKey,
                customer_email: email,
                amount: 2000,
                customer_phone: "234099940409",
                currency: "NGN",
                payment_options: "card,account",
                txref: txref,
                onclose: function() {},
                callback: function(response) {
                    var txref = response.tx.txRef; // collect flwRef returned and pass to a                     server page to complete status check.
                    console.log("This is the response returned after a charge", response);
                    if (
                        response.tx.chargeResponseCode == "00" ||
                        response.tx.chargeResponseCode == "0"
                    ) {
                        // redirect to a success page
                        //alert('Payment Successfully made');
                        window.location = "http://localhost:8080/SNH/processbills.php/?id=" + appointmentId;
                    } else {
                        // redirect to a failure page.
                        alert('Payment Failed, please try again')
                        window.location = "http://localhost:8080/SNH/paybills.php";
                    }

                    x.close(); // use this to close the modal immediately after payment.
                }
            });
        }
    </script>
</div>