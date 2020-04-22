<?php include_once('lib/header.php'); 

if(!isset($_SESSION['loggedIn'])){
    // redirect to dashboard
    header("Location: login.php");
}

?>
<div class ="container">
<h3>Dashboard</h3>

Welcome, <?php echo $_SESSION['fullname'] ?>, You are logged in as (<?php echo $_SESSION['role'] ?>), and your ID is <?php echo $_SESSION['loggedIn'] ?>.


<?php if($_SESSION["role"] == "Medical Director") {?>
<p>Access Level : <?php echo $_SESSION['role'] ?></p>
<p>Department : <?php echo $_SESSION['department'] ?></p>
<p>Date of registration : <?php echo  $_SESSION['registerDate'] ?></p>
<p>Date of Last Login : <?php echo $_SESSION['lastLogin'] ?></p>

<a href="register.php?adminAuth"><button class="btn btn-sm btn-primary">Add new User</button></a>
<a href="staff.php"><button class="btn btn-sm btn-primary">View all Staffs</button></a>
<a href="patient.php"><button class="btn btn-sm btn-primary">View all patients</button></a>

<?php }else if($_SESSION["role"] == "Medical Team (MT)"){ ?>

<p>Access Level : <?php echo $_SESSION['role'] ?></p>
<p>Department : <?php echo $_SESSION['department'] ?></p>
<p>Date of registration : <?php echo  $_SESSION['registerDate'] ?></p>
<p>Date of Last Login : <?php echo $_SESSION['lastLogin'] ?></p>
<a href="appointment.php"><button class="btn btn-sm btn-primary">View all Appointments</button></a>

<?php }else{?>
    <p>Access Level : <?php echo $_SESSION['role'] ?></p>
    <p>Department : <?php echo $_SESSION['department'] ?></p>
    <p>Date of registration : <?php echo  $_SESSION['registerDate'] ?></p>
    <p>Date of Last Login : <?php echo $_SESSION['lastLogin'] ?></p>
    <a href="paybills.php"><button class="btn btn-sm btn-primary">Pay Bills</button></a>
    <a href="bookappointments.php"><button class="btn btn-sm btn-primary">Book Appointments</button></a>
    </div>
<?php }

include_once('lib/footer.php'); ?>