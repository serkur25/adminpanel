<?php
session_start();
include('config.php'); // Veritabanı bağlantısı

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Kullanıcı adı ve şifre doğrulama
    $sql = "SELECT * FROM kullanicilar WHERE kullanici_adi = '$username' AND sifre = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $_SESSION['username'] = $username;
        header("Location: admin_panel.php");
    } else {
        echo "Yanlış kullanıcı adı veya şifre.";
    }
}
?>