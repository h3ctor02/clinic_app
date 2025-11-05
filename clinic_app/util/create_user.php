<?php
require __DIR__.'/../config/db.php';
$full='Test User';
$email='test@clinic.test';
$phone='555-0000';
$hash=password_hash('test123',PASSWORD_BCRYPT);
$s=$pdo->prepare("INSERT INTO patients(full_name,email,phone,password_hash) VALUES(?,?,?,?)");
$s->execute([$full,$email,$phone,$hash]);
echo 'ok';