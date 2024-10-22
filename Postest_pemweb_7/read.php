<?php
require "db.php"; // Pastikan file koneksi sudah disertakan

$sql = "SELECT * FROM users";
$stmt = $conn->query($sql);
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($users as $user) {
    echo "<h2>" . htmlspecialchars($user['username']) . "</h2>";
    echo "<p>Email: " . htmlspecialchars($user['email']) . "</p>";
    echo "<p>Investasi: " . htmlspecialchars($user['investasi']) . " USD</p>";
    echo "<p>Pengalaman: " . htmlspecialchars($user['pengalaman']) . "</p>";
    
    // Cek apakah file_upload ada sebelum menampilkan gambar
    if (!empty($user['file_upload'])) {
        echo "<img src='uploads/" . htmlspecialchars($user['file_upload']) . "' alt='Uploaded File' style='max-width: 200px;'>";
    } else {
        echo "<p>No file uploaded</p>";
    }

    echo "<hr>";
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Pengguna</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<h2>Daftar Pengguna</h2>
<table>
    <thead>
        <tr>
            <th>Username</th>
            <th>Email</th>
            <th>Investasi (USD)</th>
            <th>Pengalaman</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($users as $user): ?>
        <tr>
            <td data-label="Username"><?php echo htmlspecialchars($user['username']); ?></td>
            <td data-label="Email"><?php echo htmlspecialchars($user['email']); ?></td>
            <td data-label="Investasi"><?php echo htmlspecialchars($user['investasi']); ?></td>
            <td data-label="Pengalaman"><?php echo htmlspecialchars($user['pengalaman']); ?></td>
            <td data-label="Aksi">
                <a href="edit.php?id=<?php echo $user['id']; ?>" class="edit-link">Edit</a> |
                <a href="index.php?delete=<?php echo $user['id']; ?>" class="hapus-link" onclick="return confirm('Apakah Anda yakin ingin menghapus?');">Hapus</a>
</td>

        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

</body>
</html>
