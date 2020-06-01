<?php include_once('lib/header.php'); 
require_once('functions/user.php');
require_once('functions/redirect.php');

if(!isset($_SESSION['loggedIn']) || $_SESSION["role"] != "Medical Team (MT) "){
    // redirect to dashboard
    redirect_to("login.php");
} 

$department = $_SESSION['department'];

?>

<div class ="container">

<h2>View all appointments</h2>

<?php
        $tbody = get_appointments($department);
        if ($tbody) {

        ?>
<table class="table table-hover">
    
  <thead>
    <tr>
      <th scope="col">S/N</th>
      <th scope="col">Patient Name</th>
      <th scope="col">Date of appointment</th>
      <th scope="col">Time of appointment</th>   
      <th scope="col">Nature of appointment</th>
      <th scope="col">Initial complaint</th>
      <th scope="col">Payment Status</th>
    </tr>
  </thead>
  <tbody>
  <?php echo $tbody; ?>
  </tbody>
</table>
<?php 
} else { ?>
            <p>You have no pending appointments</p>
            <?php } ?>
</div>

<?php include_once('lib/footer.php'); ?>