<?php include_once('lib/header.php'); 
require_once('functions/user.php');
require_once('functions/redirect.php');


if(!isset($_SESSION['loggedIn'])){
    // redirect to dashboard
    redirect_to("login.php");
}?>

<div class ="container">

<h2>View all appointments</h2>

<table class="table table-hover">
  <thead>
    <tr>
      <th scope="col">Patient Name</th>
      <th scope="col">Date of appointment</th>
      <th scope="col">Nature of appointment</th>
      <th scope="col">Initial complaint</th>
    </tr>
  </thead>
  <tbody>
  <?php echo $tbody; ?>
  </tbody>
</table>
</div>

<?php include_once('lib/footer.php'); ?>