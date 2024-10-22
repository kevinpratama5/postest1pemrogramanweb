<?php
$host = 'localhost';
$dbname = 'buycoin'; 
$username = 'root';
$password = '';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = null; 
} catch (PDOException $e) {
    die("Koneksi gagal: " . $e->getMessage());
}
?>
