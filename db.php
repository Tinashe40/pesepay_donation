<?php
$host = '127.0.0.1';
$db = 'pesepay_donation';
$user = 'tina';
$pass = 'sudo0047';
$dsn = "pgsql:host=$host;port=5432;dbname=$db;user=$user;password=$pass";

try {
  $pdo = new PDO($dsn);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  die("Database connection failed: " . $e->getMessage());
}
?>