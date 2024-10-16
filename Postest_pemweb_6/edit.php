<?php
require "db.php";

$id = $_GET['id'];
$sql = "SELECT * FROM users WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = htmlspecialchars($_POST['username']);
    $email = htmlspecialchars($_POST['email']);
    $investasi = htmlspecialchars($_POST['investasi']);
    $pengalaman = htmlspecialchars($_POST['pengalaman']);
    $oldFile = $_POST['oldfile'];

    $uploadDir = 'uploads/';
    $file_name = $oldFile; // Default ke file lama

    if ($_FILES['file']['error'] === UPLOAD_ERR_OK) {
        $file_tmp_name = $_FILES['file']['tmp_name'];
        $file_real_name = $_FILES['file']['name'];
        $file_ext = strtolower(pathinfo($file_real_name, PATHINFO_EXTENSION));
        $validExtensions = ['jpg', 'jpeg', 'png', 'pdf'];

        if (in_array($file_ext, $validExtensions)) {
            if ($oldFile) {
                unlink($uploadDir . $oldFile);
            }
            $file_name = date('Y-m-d H.i.s') . '.' . $file_ext;
            move_uploaded_file($file_tmp_name, $uploadDir . $file_name);
        } else {
            echo "<script>alert('Format file tidak valid!');</script>";
            exit();
        }
    }

    $sql = "UPDATE users SET username = ?, email = ?, investasi = ?, pengalaman = ?, file_upload = ? WHERE id = ?";
    $stmt = $pdo->prepare($sql);
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
        <input type="hidden" name="oldfile" value="<?= $user['file_upload']; ?>">

        <div class="edit-form-group">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" value="<?= $user['username']; ?>" required>
        </div>

        <div class="edit-form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?= $user['email']; ?>" required>
        </div>

        <div class="edit-form-group">
            <label for="investasi">Investasi (USD):</label>
            <input type="number" id="investasi" name="investasi" value="<?= $user['investasi']; ?>" step="0.01" required>
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
