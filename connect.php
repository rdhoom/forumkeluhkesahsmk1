<?php
$conn = new mysqli("localhost", "root", "", "smk_keluh_kesah");

if ($conn->connect_error) {
    die("Koneksi database gagal: " . $conn->connect_error);
}
?>
