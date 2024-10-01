<?php
require_once 'formulir.php';
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
                <li><a href="#register">Register</a></li>
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
        </section>
    </main>

    <footer>
        <p>&copy; 2024 BuyCoin. Hak cipta dilindungi undang-undang.</p>
    </footer>

    <button id="darkModeToggle" aria-label="Aktifkan Mode Gelap">Aktifkan Mode Gelap</button>

    <script src="script.js"></script>
</body>
</html>