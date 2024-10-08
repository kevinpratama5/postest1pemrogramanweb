<?php
require_once 'db.php';

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = htmlspecialchars($_POST['username']);
    $email = htmlspecialchars($_POST['email']);
    $investasi = htmlspecialchars($_POST['investasi']);
    $pengalaman = htmlspecialchars($_POST['pengalaman']);

    // Update data
    $stmt = $pdo->prepare("UPDATE users SET username = ?, email = ?, investasi = ?, pengalaman = ? WHERE id = ?");
    $stmt->execute([$username, $email, $investasi, $pengalaman, $id]);

    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pengguna</title>
</head>
<body>

<h2>Edit Pengguna</h2>

<form action="edit.php?id=<?php echo $id; ?>" method="post">
    <div class="form-group">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>
    </div>
    <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
    </div>
    <div class="form-group">
        <label for="investasi">Inisiasi Investasi (USD):</label>
        <input type="number" id="investasi" name="investasi" value="<?php echo htmlspecialchars($user['investasi']); ?>" min="0" step="0.01" required>
    </div>
    <div class="form-group">
        <label for="pengalaman">Pengalaman Trading:</label>
        <select id="pengalaman" name="pengalaman" required>
            <option value="Pemula" <?php if ($user['pengalaman'] == 'Pemula') echo 'selected'; ?>>Pemula</option>
            <option value="Menengah" <?php if ($user['pengalaman'] == 'Menengah') echo 'selected'; ?>>Menengah</option>
            <option value="Pakar" <?php if ($user['pengalaman'] == 'Pakar') echo 'selected'; ?>>Pakar</option>
        </select>
    </div>
    <div class="form-group">
        <button type="submit" class="submit-btn">Update</button>
    </div>
</form>

</body>
</html>
