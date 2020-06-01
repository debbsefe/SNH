<?php include_once('lib/header.php');
require_once('functions/user.php');
if(!isset($_SESSION['loggedIn'])){
    // redirect to dashboard
    header("Location: login.php"); 
}

$email = $_SESSION['email'];

        
?>
<div class="container">
    <?php  print_alert(); ?>
        <h2 class="mb-5">Pay your bills here</h2>
        <?php
        $appointments = get_patient_appointment($email);
        if(count($appointments) < 1 )  { ?>
            <p>You currently have not booked any appointment</p>
        <?php }else{ ?>

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
            <?php 
                $appointments = get_patient_appointment($email);
                for ($i = 0; $i < count($appointments); $i++) {  ?>
            <tr>
                <td><?php echo $i + 1;?></td>
                <td><?php echo $appointments[$i]->appointmentDate;?></td>
                <td><?php echo $appointments[$i]->appointmentTime;?></td>
                <td><?php echo $appointments[$i]->natureAppointment;?></td>
                <td><?php echo $appointments[$i]->initialComplaint; ?></td>
                <td><?php echo $appointments[$i]->paymentStatus; ?></td>
                
                <td> 
                <?php if ($appointments[$i]->paymentStatus == 'Not Paid') { ?>
                    <form>
                    <script type="text/javascript" src="https://ravesandboxapi.flutterwave.com/flwv3-pug/getpaidx/api/flwpbf-inline.js"></script>
                    <button class="btn btn-sm btn-primary" type="button" onClick="payWithRave()"
                    <?php              
                      echo "id=" . $appointments[$i]->id;                                                                         
                  ?>
                    
                    >Click to pay</button>
                    </form>
                
                <?php } ?>
                </td>
                </tr>
                <?php } ?>
            </tbody>
           
           
            
        </table> <?php } ?>
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