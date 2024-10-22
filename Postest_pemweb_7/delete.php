<?php
require "db.php";

$id = $_GET['id'];

$sql = "SELECT file_upload FROM users WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user['file_upload']) {
    unlink('uploads/' . $user['file_upload']);
}

$sql = "DELETE FROM users WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id]);

header("Location: read.php");
exit();
?>
