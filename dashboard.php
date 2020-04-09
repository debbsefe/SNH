<?php include_once('lib/header.php'); 

if(!isset($_SESSION['loggedIn'])){
    // redirect to dashboard
    header("Location: login.php");
}

?>
<h3>Dashboard</h3>

Welcome, <?php echo $_SESSION['fullname'] ?>, You are logged in as (<?php echo $_SESSION['role'] ?>), and your ID is <?php echo $_SESSION['loggedIn'] ?>.


<?php if($_SESSION["role"] == "Medical Team (MT)") {?>
<p>Access Level : <?php echo $_SESSION['role'] ?></p>
<p>Department : <?php echo $_SESSION['department'] ?></p>
<p>Date of registration : <?php echo  $_SESSION['registerDate'] ?></p>
<p>Date of Last Login : <?php echo $_SESSION['lastLogin'] ?></p>

<a href="register.php?adminAuth"><button class="btn btn-sm btn-primary">Add new User</button></a>
<?php }else{ ?>

<p>Access Level : <?php echo $_SESSION['role'] ?></p>
<p>Department : <?php echo $_SESSION['department'] ?></p>
<p>Date of registration : <?php echo  $_SESSION['registerDate'] ?></p>
<p>Date of Last Login : <?php echo $_SESSION['lastLogin'] ?></p>

<?php } 

include_once('lib/footer.php'); ?>