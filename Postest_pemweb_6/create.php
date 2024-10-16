<?php
require "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = htmlspecialchars($_POST['username']);
    $email = htmlspecialchars($_POST['email']);
    $investasi = htmlspecialchars($_POST['investasi']);
    $pengalaman = htmlspecialchars($_POST['pengalaman']);
    
    $file_name = null; // Default jika tidak ada file diupload
    $uploadDir = 'uploads/'; // Direktori penyimpanan file
    
    if ($_FILES['file']['error'] === UPLOAD_ERR_OK) {
        $file_tmp_name = $_FILES['file']['tmp_name'];
        $file_real_name = $_FILES['file']['name'];
        $file_ext = strtolower(pathinfo($file_real_name, PATHINFO_EXTENSION));
        $validExtensions = ['jpg', 'jpeg', 'png', 'pdf']; // Ekstensi yang diizinkan

        // Validasi ekstensi file
        if (in_array($file_ext, $validExtensions)) {
            // Penamaan file sesuai waktu
            $file_name = date('Y-m-d H.i.s') . '.' . $file_ext;
            move_uploaded_file($file_tmp_name, $uploadDir . $file_name);
        } else {
            echo "<script>alert('Format file tidak valid!');</script>";
            exit();
        }
    }

    // Insert ke database
    $sql = "INSERT INTO users (username, email, investasi, pengalaman, file) VALUES (?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$username, $email, $investasi, $pengalaman, $file_name]);

    header("Location: read.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Pengguna</title>
</head>
<body>
<h2>Tambah Pengguna</h2>
<form action="create.php" method="post" enctype="multipart/form-data">
    <label for="username">Username:</label>
    <input type="text" id="username" name="username" required>
    
    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required>
    
    <label for="investasi">Investasi (USD):</label>
    <input type="number" id="investasi" name="investasi" step="0.01" required>
    
    <label for="pengalaman">Pengalaman Trading:</label>
    <select id="pengalaman" name="pengalaman" required>
        <option value="Pemula">Pemula</option>
        <option value="Menengah">Menengah</option>
        <option value="Pakar">Pakar</option>
    </select>

    <label for="file">Upload File (Opsional):</label>
    <input type="file" id="file" name="file">
    
    <button type="submit">Tambah</button>
</form>
</body>
</html>
