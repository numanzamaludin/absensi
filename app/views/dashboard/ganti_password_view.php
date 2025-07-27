<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ganti Password</title>
    <link rel="stylesheet" href="assets/css/ganti_password.css">
</head>

<body>

    <div class="card">
        <h2>🔐 Ganti Password</h2>

        <?php foreach ($errors as $e): ?>
            <div class="message error"><?= htmlspecialchars($e) ?></div>
        <?php endforeach; ?>

        <?php if ($success): ?>
            <div class="message success"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>

        <form method="post">
            <label>Password Lama:
                <input type="password" name="password_lama" required>
            </label>

            <label>Password Baru:
                <input type="password" name="password_baru" required>
            </label>

            <label>Konfirmasi Password Baru:
                <input type="password" name="konfirmasi" required>
            </label>

            <button type="submit">Ganti Password</button>
        </form>

        <div class="back-link">
            <a href="?page=dashboard">← Kembali ke Dashboard</a>
        </div>
    </div>

</body>

</html>