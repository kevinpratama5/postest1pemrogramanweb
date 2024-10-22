<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Pencarian - BuyCoin</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Hasil Pencarian</h2>
        <?php
        session_start();
        require_once 'db.php';

        if (!isset($_SESSION['user_id'])) {
            echo "<p>Anda harus login untuk menggunakan fitur pencarian.</p>";
            exit();
        }

        if (isset($_GET['search'])) {
            $search = $_GET['search'];
            $sql = "SELECT * FROM users WHERE username LIKE :search OR email LIKE :search";
            $stmt = $conn->prepare($sql);
            $searchTerm = '%' . $search . '%';
            $stmt->bindParam(':search', $searchTerm, PDO::PARAM_STR);
            $stmt->execute();
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (count($users) > 0) {
                echo "<table class='search-results'>
                        <thead>
                            <tr>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Investasi (USD)</th>
                                <th>Pengalaman</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>";
                foreach ($users as $user) {
                    echo "<tr>
                            <td>" . htmlspecialchars($user['username']) . "</td>
                            <td>" . htmlspecialchars($user['email']) . "</td>
                            <td>" . htmlspecialchars($user['investasi']) . "</td>
                            <td>" . htmlspecialchars($user['pengalaman']) . "</td>
                            <td>
                                <a href='edit.php?id=" . $user['id'] . "' class='edit-btn'>Edit</a>
                                <a href='index.php?delete=" . $user['id'] . "' class='delete-btn' 
                                   onclick='return confirm(\"Apakah Anda yakin ingin menghapus?\");'>Hapus</a>
                            </td>
                        </tr>";
                }
                echo "</tbody></table>";
            } else {
                echo "<p class='no-results'>Tidak ada hasil yang ditemukan.</p>";
            }
        } else {
            echo "<p class='error-message'>Masukkan kata kunci untuk mencari pengguna.</p>";
        }
        ?>
    </div>
</body>
</html>
