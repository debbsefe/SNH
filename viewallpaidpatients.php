<?php include_once('lib/header.php'); 
require_once('functions/user.php');
require_once('functions/redirect.php');

if(!isset($_SESSION['loggedIn']) || $_SESSION["role"] != "Medical Director"){
    // redirect to dashboard
    redirect_to("login.php");
} 
$tbody = viewallpayments();
?>
<div class="container">
<table class="table table-striped">
    
    <thead>
      <tr>
      <th scope="col">S/N</th>
      <th scope="col">Patient Name</th>
      <th scope="col">Date of appointment</th>
      <th scope="col">Time of appointment</th>   
      <th scope="col">Nature of appointment</th>
      <th scope="col">Initial complaint</th>
      <th scope="col">Department</th>
      <th scope="col">Payment Status</th>
      <th scope="col">Date of Payment</th>
      <th scope="col">Time of Payment</th>
      </tr>
    </thead>
    <tbody>
    <?php echo $tbody; ?>
    </tbody>
</table>
</div>

<?php include_once('lib/footer.php'); ?>