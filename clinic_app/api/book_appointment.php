<?php
session_start();
if(!isset($_SESSION['patient_id'])){header('Location: ../public/login.php');exit;}
require __DIR__.'/../config/db.php';
$pid=(int)$_SESSION['patient_id'];
$did=(int)($_POST['doctor_id']??0);
$date=trim($_POST['date']??'');
$time=trim($_POST['time']??'');
$notes=trim($_POST['notes']??'');
if($did<=0||!preg_match('/^\d{4}-\d{2}-\d{2}$/',$date)||!preg_match('/^\d{2}:\d{2}$/',$time)){header('Location: ../public/book.php');exit;}
$start=$date.' '.$time.':00';
$end=date('Y-m-d H:i:s',strtotime($start.' +30 minutes'));
if(strtotime($start)<=time()){echo 'Pick a future time. <a href="../public/book.php">Back</a>';exit;}
try{
  $pdo->beginTransaction();
  $q=$pdo->prepare("SELECT COUNT(*) FROM appointments WHERE patient_id=? AND status='scheduled' AND start_time>NOW()");
  $q->execute([$pid]);
  if((int)$q->fetchColumn()>=3){$pdo->rollBack();echo 'Limit reached (3). <a href=\"../public/book.php\">Back</a>';exit;}
  $q=$pdo->prepare("SELECT id FROM appointments WHERE doctor_id=? AND status='scheduled' AND ? < end_time AND ? > start_time LIMIT 1");
  $q->execute([$did,$end,$start]);
  if($q->fetch()){ $pdo->rollBack(); echo 'Time not available. <a href=\"../public/book.php\">Back</a>'; exit; }
  $q=$pdo->prepare("INSERT INTO appointments(doctor_id,patient_id,start_time,end_time,status,notes) VALUES(?,?,?,?, 'scheduled',?)");
  $q->execute([$did,$pid,$start,$end,$notes]);
  $pdo->commit();
  header('Location: ../public/my_appointments.php');
}catch(Throwable $e){
  if($pdo->inTransaction())$pdo->rollBack();
  echo 'Error. <a href=\"../public/book.php\">Back</a>';
}
