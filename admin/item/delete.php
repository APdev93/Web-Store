<?php
require "../../db.php";

if (isset($_GET["action"]) && $_GET["action"] == "delete") {
    $id = $_GET["id"];
    $img = $_GET["img"];
    $path = "../../img/";

    // Menggunakan parameter binding untuk mencegah SQL Injection
    $stmt = $conn->prepare("DELETE FROM item WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        $gambar = $path . $img;
        
        // Menggunakan is_file() untuk memeriksa apakah file ada sebelum menghapusnya
        if (is_file($gambar) && unlink($gambar)) {
            header("Location: index.php");
            exit;
        } else {
            echo("<script>alert('Gagal menghapus gambar');</script>");
            exit;
        }
    } else {
        echo("<script>alert('Gagal menghapus data ". $stmt->error ."');</script>");
        exit;
    }
} else {
    // Tindakan lainnya di sini jika diperlukan
}
?>
