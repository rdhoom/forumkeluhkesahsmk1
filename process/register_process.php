<?php
include '../connect.php';

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];
    
        // Validasi password
        if ($password !== $confirm_password) {
            echo "<script>alert('Password dan konfirmasi password tidak cocok!'); window.location.href='../register.php';</script>";
            exit();
        }
    
        // Hash password
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);
    
        // Periksa apakah username sudah terdaftar
        $check_user = $conn->prepare("SELECT id FROM users WHERE username = ?");
        $check_user->bind_param("s", $username);
        $check_user->execute();
        $check_user->store_result();
    
        if ($check_user->num_rows > 0) {
            echo "<script>alert('Username sudah terdaftar!'); window.location.href='../register.php';</script>";
            exit();
        }
    
        // Simpan data ke database
        $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        $stmt->bind_param("ss", $username, $hashed_password);
    
        if ($stmt->execute()) {
            echo "<script>alert('Registrasi berhasil! Silakan login.'); window.location.href='../login.php';</script>";
        } else {
            echo "<script>alert('Terjadi kesalahan!'); window.location.href='../register.php';</script>";
        }
    
        $stmt->close();
        $conn->close();
    }
    ?>
    