<?php
session_start();
if(!isset($_SESSION['patient_id'])){header('Location: login.php');exit;}
require __DIR__.'/../config/db.php';
$pid=(int)$_SESSION['patient_id'];
$rows=$pdo->prepare("SELECT a.id,a.start_time,a.end_time,a.status,d.full_name,s.name AS spec FROM appointments a JOIN doctors d ON d.id=a.doctor_id JOIN specialties s ON s.id=d.specialty_id WHERE a.patient_id=? ORDER BY a.start_time DESC");
$rows->execute([$pid]);
$data=$rows->fetchAll();
?>
<!doctype html><html><head><meta charset="utf-8"><title>My Appointments</title><link rel="stylesheet" href="css/style.css"></head><body>
<div class="box">
<h2>My Appointments</h2>
<table>
<tr><th>Doctor</th><th>Specialty</th><th>Start</th><th>End</th><th>Status</th><th>Action</th></tr>
<?php foreach($data as $r): ?>
<tr>
<td><?php echo htmlspecialchars($r['full_name']);?></td>
<td><?php echo htmlspecialchars($r['spec']);?></td>
<td><?php echo htmlspecialchars($r['start_time']);?></td>
<td><?php echo htmlspecialchars($r['end_time']);?></td>
<td><?php echo htmlspecialchars($r['status']);?></td>
<td>
<?php if($r['status']==='scheduled'): ?>
<form method="post" action="../api/cancel_appointment.php">
<input type="hidden" name="appointment_id" value="<?php echo $r['id'];?>">
<button type="submit">Cancel</button>
</form>
<?php endif; ?>
</td>
</tr>
<?php endforeach; ?>
</table>
<a href="dashboard.php">Back</a>
</div>
</body></html>
