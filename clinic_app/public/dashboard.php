<?php
session_start();
if(!isset($_SESSION['patient_id'])){header('Location: login.php');exit;}
$name=htmlspecialchars($_SESSION['patient_name']);
?>
<!doctype html><html><head><meta charset="utf-8"><title>Dashboard</title><link rel="stylesheet" href="css/style.css"></head><body>
<div class="box">
<h2>Welcome, <?php echo $name; ?></h2>
<a href="book.php">Book Appointment</a>
<a href="my_appointments.php">My Appointments</a>
<a href="profile.php">My Profile</a>
<a href="logout.php">Logout</a>
</div>
</body></html>