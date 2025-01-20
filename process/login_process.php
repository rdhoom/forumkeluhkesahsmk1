<?php
session_start();
include '../connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Cek username di database
    $stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($user_id, $hashed_password);
        $stmt->fetch();

        // Verifikasi password
        if (password_verify($password, $hashed_password)) {
            // Login berhasil
            $_SESSION['user_id'] = $user_id;
            $_SESSION['username'] = $username;
            echo "<script>alert('Login berhasil!'); window.location.href='../dashboard.php';</script>";
        } else {
            echo "<script>alert('Password salah!'); window.location.href='../login.php';</script>";
        }
    } else {
        echo "<script>alert('Username tidak ditemukan!'); window.location.href='../login.php';</script>";
    }

    $stmt->close();
    $conn->close();
}
?>
