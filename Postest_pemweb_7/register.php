<?php
require 'db.php'; // Koneksi database

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = htmlspecialchars($_POST['username']);
    $email = htmlspecialchars($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash password
    $investasi = htmlspecialchars($_POST['investasi']);
    $pengalaman = htmlspecialchars($_POST['pengalaman']);

    // SQL untuk insert data
    $sql = "INSERT INTO users (username, email, password, investasi, pengalaman) VALUES (?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);

    try {
        $stmt->execute([$username, $email, $password, $investasi, $pengalaman]);
        header("Location: login.php");
        exit();
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<form action="register.php" method="post">
    <input type="text" name="username" placeholder="Username" required>
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Password" required>
    <input type="number" name="investasi" placeholder="Investasi (USD)" step="0.01" required>
    <select name="pengalaman">
        <option value="Pemula">Pemula</option>
        <option value="Menengah">Menengah</option>
        <option value="Pakar">Pakar</option>
    </select>
    <button type="submit">Register</button>
</form>
