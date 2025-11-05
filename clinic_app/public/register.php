<?php
session_start();
require __DIR__.'/../config/db.php';
$err='';
if($_SERVER['REQUEST_METHOD']==='POST'){
  $full=trim($_POST['full_name']??'');
  $email=trim($_POST['email']??'');
  $phone=trim($_POST['phone']??'');
  $pass=trim($_POST['password']??'');
  $dob=trim($_POST['dob']??'');
  $addr=trim($_POST['address']??'');
  $ins=trim($_POST['insurance_provider']??'');
  $pol=trim($_POST['insurance_number']??'');
  $en=trim($_POST['emergency_name']??'');
  $ep=trim($_POST['emergency_phone']??'');
  if($full===''||$email===''||$pass===''){ $err='Missing required fields'; }
  else{
    $st=$pdo->prepare("SELECT id FROM patients WHERE email=?");
    $st->execute([$email]);
    if($st->fetch()){ $err='Email already exists'; }
    else{
      $hash=password_hash($pass,PASSWORD_BCRYPT);
      $insrt=$pdo->prepare("INSERT INTO patients(full_name,email,phone,password_hash,dob,address,insurance_provider,insurance_number,emergency_name,emergency_phone) VALUES(?,?,?,?,?,?,?,?,?,?)");
      $insrt->execute([$full,$email,$phone,$hash,$dob?:null,$addr?:null,$ins?:null,$pol?:null,$en?:null,$ep?:null]);
      header('Location: login.php'); exit;
    }
  }
}
?>
<!doctype html><html><head><meta charset="utf-8"><title>Register</title><link rel="stylesheet" href="css/style.css"></head><body>
<div class="box">
<h2>Create Patient Account</h2>
<form method="post">
<input name="full_name" placeholder="Full Name" required>
<input name="email" type="email" placeholder="Email" required>
<input name="phone" placeholder="Phone">
<input name="password" type="password" placeholder="Password" required>
<input name="dob" type="date" placeholder="DOB">
<input name="address" placeholder="Address">
<input name="insurance_provider" placeholder="Insurance Provider">
<input name="insurance_number" placeholder="Policy Number">
<input name="emergency_name" placeholder="Emergency Contact Name">
<input name="emergency_phone" placeholder="Emergency Contact Phone">
<button type="submit">Create Account</button>
<p class="err"><?php echo htmlspecialchars($err??''); ?></p>
</form>
<a href="login.php">Back to Login</a>
</div>
</body></html>
