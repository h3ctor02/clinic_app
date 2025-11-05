<?php
session_start();
if(!isset($_SESSION['patient_id'])){header('Location: login.php');exit;}
require __DIR__.'/../config/db.php';
$pid=(int)$_SESSION['patient_id'];
$err='';
$st=$pdo->prepare("SELECT full_name,email,phone,dob,address,insurance_provider,insurance_number,emergency_name,emergency_phone FROM patients WHERE id=?");
$st->execute([$pid]);
$u=$st->fetch();
if($_SERVER['REQUEST_METHOD']==='POST'){
  $full=trim($_POST['full_name']??'');
  $phone=trim($_POST['phone']??'');
  $dob=trim($_POST['dob']??'');
  $addr=trim($_POST['address']??'');
  $ins=trim($_POST['insurance_provider']??'');
  $pol=trim($_POST['insurance_number']??'');
  $en=trim($_POST['emergency_name']??'');
  $ep=trim($_POST['emergency_phone']??'');
  if($full===''){ $err='Name required'; }
  else{
    $up=$pdo->prepare("UPDATE patients SET full_name=?,phone=?,dob=?,address=?,insurance_provider=?,insurance_number=?,emergency_name=?,emergency_phone=? WHERE id=?");
    $up->execute([$full,$phone,$dob?:null,$addr?:null,$ins?:null,$pol?:null,$en?:null,$ep?:null,$pid]);
    header('Location: profile.php'); exit;
  }
}
?>
<!doctype html><html><head><meta charset="utf-8"><title>My Profile</title><link rel="stylesheet" href="css/style.css"></head><body>
<div class="box">
<h2>My Profile</h2>
<form method="post">
<input name="full_name" value="<?php echo htmlspecialchars($u['full_name']??''); ?>" placeholder="Full Name" required>
<input name="phone" value="<?php echo htmlspecialchars($u['phone']??''); ?>" placeholder="Phone">
<input name="dob" type="date" value="<?php echo htmlspecialchars($u['dob']??''); ?>" placeholder="DOB">
<input name="address" value="<?php echo htmlspecialchars($u['address']??''); ?>" placeholder="Address">
<input name="insurance_provider" value="<?php echo htmlspecialchars($u['insurance_provider']??''); ?>" placeholder="Insurance Provider">
<input name="insurance_number" value="<?php echo htmlspecialchars($u['insurance_number']??''); ?>" placeholder="Policy Number">
<input name="emergency_name" value="<?php echo htmlspecialchars($u['emergency_name']??''); ?>" placeholder="Emergency Contact Name">
<input name="emergency_phone" value="<?php echo htmlspecialchars($u['emergency_phone']??''); ?>" placeholder="Emergency Contact Phone">
<button type="submit">Save</button>
<p class="err"><?php echo htmlspecialchars($err??''); ?></p>
</form>
<a href="dashboard.php">Back</a>
</div>
</body></html>
