<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = htmlspecialchars($_POST['username']);
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);
    $investasi = htmlspecialchars($_POST['investasi']);
    $pengalaman = htmlspecialchars($_POST['pengalaman']);

    header('Location: index.php?username=' . urlencode($username) . '&email=' . urlencode($email) . '&investasi=' . urlencode($investasi) . '&pengalaman=' . urlencode($pengalaman));
    exit();
}
?>
