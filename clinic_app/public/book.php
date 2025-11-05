<?php
session_start();
if(!isset($_SESSION['patient_id'])){header('Location: login.php');exit;}
require __DIR__.'/../config/db.php';
$docs=$pdo->query("SELECT d.id,d.full_name,s.name AS spec FROM doctors d JOIN specialties s ON s.id=d.specialty_id ORDER BY d.full_name")->fetchAll();
$dates=[];
$start=new DateTime('today');
$end=new DateTime('last day of December');
while($start<=$end){$dates[]=['v'=>$start->format('Y-m-d'),'t'=>$start->format('D M j')];$start->modify('+1 day');}
$times=[];
for($h=9;$h<=16;$h++){$times[]=sprintf('%02d:00',$h);$times[]=sprintf('%02d:30',$h);}
?>
<!doctype html><html><head><meta charset="utf-8"><title>Book</title><link rel="stylesheet" href="css/style.css"></head><body>
<div class="box">
<h2>Book Appointment</h2>
<form method="post" action="../api/book_appointment.php">
<select name="doctor_id" required>
<option value="">Select Doctor</option>
<?php foreach($docs as $d): ?>
<option value="<?php echo $d['id'];?>"><?php echo htmlspecialchars($d['full_name'].' — '.$d['spec']);?></option>
<?php endforeach; ?>
</select>
<select name="date" required>
<option value="">Select Date</option>
<?php foreach($dates as $d): ?>
<option value="<?php echo $d['v'];?>"><?php echo htmlspecialchars($d['t']);?></option>
<?php endforeach; ?>
</select>
<select name="time" required>
<option value="">Select Time</option>
<?php foreach($times as $t): ?>
<option value="<?php echo $t;?>"><?php echo $t;?></option>
<?php endforeach; ?>
</select>
<input name="notes" placeholder="Notes">
<button type="submit">Book</button>
</form>
<a href="dashboard.php">Back</a>
</div>
</body></html>
