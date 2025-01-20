<?php
session_start();
include '../connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $message = $_POST['message'];

    $stmt = $conn->prepare("INSERT INTO keluhan (user_id, message) VALUES (?, ?)");
    $stmt->bind_param("is", $user_id, $message);

    if ($stmt->execute()) {
        echo "<script>alert('Keluhan berhasil dikirim!'); window.location.href='../dashboard.php';</script>";
    } else {
        echo "<script>alert('Terjadi kesalahan!'); window.location.href='../dashboard.php';</script>";
    }

    $stmt->close();
    $conn->close();
}
?>
