<?php include_once('lib/header.php'); 
require_once('functions/user.php');
require_once('functions/redirect.php');

if(!isset($_SESSION['loggedIn']) || $_SESSION["role"] != "Medical Director"){
    // redirect to dashboard
    redirect_to("login.php");
} 
$tbody = view_staffs();
?>

<div class="container">
    <h1>View All staffs</h1>

    <table class="table table-striped">
    
    <thead>
      <tr>
        <th scope="col">S/N</th>
        <th scope="col">Staff Name</th>
        <th scope="col">Department</th>
      </tr>
    </thead>
    <tbody>
    <?php echo $tbody; ?>
    </tbody>
</table>

</div>
<?php include_once('lib/footer.php'); ?>