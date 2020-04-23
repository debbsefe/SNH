<?php include_once('lib/header.php'); 
require_once('functions/user.php');
require_once('functions/redirect.php');

if(!isset($_SESSION['loggedIn'])){
    // redirect to dashboard
    redirect_to("login.php");
} 
$tbody = view_patients();
?>
<div class="container">
<table class="table table-hover">
    
    <thead>
      <tr>
        <th scope="col">S/N</th>
        <th scope="col">Patient Name</th>
      </tr>
    </thead>
    <tbody>
    <?php echo $tbody; ?>
    </tbody>
</table>
</div>
<?php include_once('lib/footer.php'); ?>