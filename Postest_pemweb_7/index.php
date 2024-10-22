<?php
// Memulai session
session_start();
require_once 'db.php';

// Memeriksa apakah pengguna sudah login
$logged_in = isset($_SESSION['user_id']);

// Logout handling
if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    header("Location: index.php");
    exit();
}

// Koneksi ke database
$conn = mysqli_connect("localhost", "root", "", "buycoin");
if (!$conn) {
    die("Gagal terhubung ke database: " . mysqli_connect_error());
}

// Menangani registrasi pengguna baru
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, htmlspecialchars($_POST['username']));
    $email = mysqli_real_escape_string($conn, htmlspecialchars($_POST['email']));
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash password
    $investasi = mysqli_real_escape_string($conn, htmlspecialchars($_POST['investasi']));
    $pengalaman = mysqli_real_escape_string($conn, htmlspecialchars($_POST['pengalaman']));

    $sql = "INSERT INTO users (username, email, password, investasi, pengalaman) 
            VALUES ('$username', '$email', '$password', '$investasi', '$pengalaman')";

    if (mysqli_query($conn, $sql)) {
        header("Location: index.php?username=$username&email=$email&investasi=$investasi&pengalaman=$pengalaman");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

// Menangani penghapusan pengguna
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $sql = "DELETE FROM users WHERE id = $id";

    if (mysqli_query($conn, $sql)) {
        header("Location: index.php");
        exit();
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
    }
}

// Menampilkan daftar pengguna hanya jika sudah login
$users = [];
if ($logged_in) {
    $sql = "SELECT * FROM users";
    $result = mysqli_query($conn, $sql);
    $users = mysqli_fetch_all($result, MYSQLI_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BuyCoin - Platform Trading</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
    <nav class="container">
        <div class="logo">
            <img src="buycoin-logo.png" alt="Logo BuyCoin">
            BuyCoin
        </div>
        <ul class="nav-links">
            <li><a href="#home">Home</a></li>
            <li><a href="#about">About</a></li>
            <?php if ($logged_in): ?>
                <li><a href="?logout">Logout</a></li>
            <?php else: ?>
                <li><a href="login.php">Login</a></li>
                <li><a href="#register">Register</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>

<main class="container">
    <section id="home">
        <div class="hero-content">
            <h1>BuyCoin Blockchain</h1>
            <p class="subtitle">Aman & Mudah melakukan trading</p>
            <div class="cta-buttons">
                <button class="cta-btn primary-btn" data-action="Mulai">Mulai</button>
                <button class="cta-btn secondary-btn" data-action="Whitepaper">WHITEPAPER</button>
            </div>
        </div>
        <div class="ico-card">
            <h2>BuyCoin ICO:</h2>
            <p>Diskon 33% dari harga asli</p>
            <div class="progress-bar">
                <div class="progress"></div>
            </div>
            <div class="ico-details">
                <span>900K</span>
                <span>12M USD</span>
            </div>
            <p>Edisi token tetap 3,000,000 BITS</p>
            <button class="buy-tokens-btn" data-action="Beli Token">BELI TOKEN</button>
            <div class="payment-methods">
                <img src="visa-logo.png" alt="Visa">
                <img src="paypal-logo.png" alt="PayPal">
            </div>
        </div>
    </section>

    <section id="about">
        <h2>Tentang Saya</h2>
        <p>Nama: Kevin Pratama</p>
        <p>Pengalaman: 2 tahun dalam trading cryptocurrency</p>
        <p>Visi: Membuat trading cryptocurrency dapat diakses oleh semua orang</p>
    </section>
    

    <section id="register">
        <h2>Registrasi BuyCoin</h2>
        <?php if (isset($_GET['username'])): ?>
            <div class="form-success">
                <h3>Registrasi Berhasil!</h3>
                <p>Terima kasih telah mendaftar, <strong><?php echo htmlspecialchars($_GET['username']); ?></strong>.</p>
                <p>Email: <?php echo htmlspecialchars($_GET['email']); ?></p>
                <p>Investasi Inisiasi: <?php echo htmlspecialchars($_GET['investasi']); ?> USD</p>
                <p>Pengalaman Trading: <?php echo htmlspecialchars($_GET['pengalaman']); ?></p>
            </div>
        <?php endif; ?>

        <form id="registrationForm" action="index.php" method="post">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="investasi">Inisiasi Investasi (USD):</label>
                <input type="number" id="investasi" name="investasi" min="0" step="0.01" required>
            </div>
            <div class="form-group">
                <label for="pengalaman">Pengalaman Trading:</label>
                <select id="pengalaman" name="pengalaman" required>
                    <option value="">Pilih Pengalaman kamu</option>
                    <option value="Pemula">Pemula</option>
                    <option value="Menengah">Menengah</option>
                    <option value="Pakar">Pakar</option>
                </select>
            </div>
            <div class="form-group">
                <button type="submit" class="submit-btn">Register</button>
            </div>
        </form>

        <?php if ($logged_in): ?>
        <form action="search.php" method="GET" class="search-bar-mahasiswa"> <br>
            <input type="text" name="search" placeholder="Cari nama atau email di sini" class="search-input-mahasiswa" required />
        <button type="submit" class="search-button-mahasiswa">
            <i class="fa-solid fa-magnifying-glass fa-xl"></i>
        </button>
      </form>
<div id="searchResult"></div>

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
                    <td><?php echo htmlspecialchars($user['username']); ?></td>
                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                    <td><?php echo htmlspecialchars($user['investasi']); ?></td>
                    <td><?php echo htmlspecialchars($user['pengalaman']); ?></td>
                    <td>
                        <a href="edit.php?id=<?php echo $user['id']; ?>">Edit</a>
                        <a href="index.php?delete=<?php echo $user['id']; ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus?');">Hapus</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>
    </section>
</main>

<footer>
    <p>&copy; 2024 BuyCoin. Hak cipta dilindungi undang-undang.</p>
</footer>

<script src="script.js"></script>
</body>
</html>