<?php
session_start();
require __DIR__.'/../config/db.php';
$err='';
if($_SERVER['REQUEST_METHOD']==='POST'){
  $email=trim($_POST['email']??'');
  $pass=trim($_POST['password']??'');
  $st=$pdo->prepare("SELECT id,full_name,password_hash FROM patients WHERE email=?");
  $st->execute([$email]);
  $u=$st->fetch();
  if($u&&password_verify($pass,$u['password_hash'])){
    session_regenerate_id(true);
    $_SESSION['patient_id']=$u['id'];
    $_SESSION['patient_name']=$u['full_name'];
    header('Location: dashboard.php');
    exit;
  }else{$err='Invalid login';}
}
?>
<!doctype html><html><head><meta charset="utf-8"><title>Login</title><link rel="stylesheet" href="css/style.css"></head><body>
<div class="box">
<h2>Patient Login</h2>
<form method="post">
<input name="email" type="email" placeholder="Email" required>
<input name="password" type="password" placeholder="Password" required>
<button type="submit">Login</button>
<p class="err"><?php echo htmlspecialchars($err??''); ?></p>
</form>
<a href="register.php">Create an account</a>
</div>
</body></html>