<?php
session_start();
if(!isset($_SESSION['patient_id'])){header('Location: ../public/login.php');exit;}
require __DIR__.'/../config/db.php';
$pid=(int)$_SESSION['patient_id'];
$aid=(int)($_POST['appointment_id']??0);
$q=$pdo->prepare("UPDATE appointments SET status='canceled' WHERE id=? AND patient_id=? AND status='scheduled'");
$q->execute([$aid,$pid]);
header('Location: ../public/my_appointments.php');