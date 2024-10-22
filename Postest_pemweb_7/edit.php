<?php
session_start();
require "db.php"; // Menginisialisasi koneksi PDO

// Cek jika parameter id ada di URL
if (!isset($_GET['id'])) {
    echo "ID pengguna tidak ditemukan.";
    exit();
}

// Mengambil ID dari URL
$id = $_GET['id'];

// Query untuk mengambil pengguna
$sql = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($sql); // Menggunakan $conn untuk menyiapkan query
$stmt->execute([$id]); // Menjalankan query dengan ID
$user = $stmt->fetch(PDO::FETCH_ASSOC); // Mengambil hasil

if (!$user) {
    echo "Pengguna tidak ditemukan.";
    exit();
}

// Proses update pengguna
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = htmlspecialchars($_POST['username']);
    $email = htmlspecialchars($_POST['email']);
    $investasi = htmlspecialchars($_POST['investasi']);
    $pengalaman = htmlspecialchars($_POST['pengalaman']);
    $oldFile = $_POST['oldfile'];

    // Proses upload file...
    $uploadDir = 'uploads/';
    $file_name = $oldFile; // Default ke file lama

    if ($_FILES['file']['error'] === UPLOAD_ERR_OK) {
        $file_tmp_name = $_FILES['file']['tmp_name'];
        $file_real_name = $_FILES['file']['name'];
        $file_ext = strtolower(pathinfo($file_real_name, PATHINFO_EXTENSION));
        $validExtensions = ['jpg', 'jpeg', 'png', 'pdf'];

        if (in_array($file_ext, $validExtensions)) {
            if ($oldFile) {
                unlink($uploadDir . $oldFile); // Hapus file lama jika ada
            }
            $file_name = date('Y-m-d H.i.s') . '.' . $file_ext; // Ganti nama file
            move_uploaded_file($file_tmp_name, $uploadDir . $file_name); // Pindahkan file
        } else {
            echo "<script>alert('Format file tidak valid!');</script>";
            exit();
        }
    }

    // Update ke database
    $sql = "UPDATE users SET username = ?, email = ?, investasi = ?, pengalaman = ?, file_upload = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$username, $email, $investasi, $pengalaman, $file_name, $id]);

    header("Location: read.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Pengguna</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="edit-container">
    <h2 class="edit-title">Edit Pengguna</h2>
    <form method="post" enctype="multipart/form-data">
        <input type="hidden" name="oldfile" value="<?= htmlspecialchars($user['file_upload']); ?>">
        <div class="edit-form-group">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" value="<?= htmlspecialchars($user['username']); ?>" required>
        </div>
        <div class="edit-form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?= htmlspecialchars($user['email']); ?>" required>
        </div>
        <div class="edit-form-group">
            <label for="investasi">Investasi (USD):</label>
            <input type="number" id="investasi" name="investasi" value="<?= htmlspecialchars($user['investasi']); ?>" step="0.01" required>
        </div>
        <div class="edit-form-group">
            <label for="pengalaman">Pengalaman:</label>
            <select id="pengalaman" name="pengalaman" required>
                <option <?= $user['pengalaman'] == 'Pemula' ? 'selected' : ''; ?>>Pemula</option>
                <option <?= $user['pengalaman'] == 'Menengah' ? 'selected' : ''; ?>>Menengah</option>
                <option <?= $user['pengalaman'] == 'Pakar' ? 'selected' : ''; ?>>Pakar</option>
            </select>
        </div>
        <div class="edit-form-group">
            <label for="file">Upload File:</label>
            <input type="file" id="file" name="file">
        </div>
        <button type="submit" class="edit-submit-btn">Update</button>
        <button type="button" class="edit-cancel-btn" onclick="window.location.href='read.php'">Cancel</button>
    </form>
</div>
</body>
</html>
