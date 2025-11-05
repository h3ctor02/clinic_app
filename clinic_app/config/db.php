<?php
$host='127.0.0.1';
$port='8889';
$db='clinic_app';
$user='root';
$pass='root';
try{
  $pdo=new PDO("mysql:host=$host;port=$port;dbname=$db;charset=utf8mb4",$user,$pass,[PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC,PDO::ATTR_EMULATE_PREPARES=>false]);
}catch(PDOException $e){
  exit('db fail');
}