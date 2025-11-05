<?php
require __DIR__.'/../config/db.php';
$s=$pdo->query("SELECT 1")->fetchColumn();
echo $s?'ok':'fail';