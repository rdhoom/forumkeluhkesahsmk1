<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Silakan login terlebih dahulu!'); window.location.href='login.php';</script>";
    exit();
}
include 'connect.php';

// Ambil data keluhan dari database
$keluhan_query = $conn->query("SELECT k.message, k.created_at, u.username FROM keluhan k JOIN users u ON k.user_id = u.id ORDER BY k.created_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="bootstrap/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Selamat Datang, <?= $_SESSION['username'] ?></h2>
        <a href="process/logout.php" class="btn btn-danger mb-3">Logout</a>
        <h3>Keluh Kesah Anak SMKN 1 SUMBAWA BESAR</h3>
        <form action="process/post_keluhan.php" method="POST">
            <div class="mb-3">
                <textarea class="form-control" name="message" rows="3" placeholder="Tulis keluhanmu di sini..." required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Kirim</button>
        </form>
        <hr>
        <h3>Daftar Keluh Kesah</h3>
        <ul class="list-group">
            <?php while ($keluhan = $keluhan_query->fetch_assoc()) : ?>
                <li class="list-group-item">
                    <strong><?= htmlspecialchars($keluhan['username']) ?>:</strong> <?= htmlspecialchars($keluhan['message']) ?>
                    <br><small class="text-muted"><?= $keluhan['created_at'] ?></small>
                </li>
            <?php endwhile; ?>
        </ul>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
