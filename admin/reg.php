<?php
require "../db.php";
session_start();

//fungsi string acak
function acak($i){
    $rb = random_bytes($i);
    $rs = bin2hex($rb);
    return $rs;
}
  

// Ambil data dari form
if (isset($_POST["submit"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $nomor = $_POST['nomor'];
    $id = acak(16);

    // Escape data yang akan dimasukkan ke dalam query SQL untuk mencegah SQL injection
    $username = mysqli_real_escape_string($conn, $username);
    $password = mysqli_real_escape_string($conn, $password);
    $nomor = mysqli_real_escape_string($conn, $nomor);

    // Hash password sebelum disimpan ke database
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Kirim data registrasi admin ke database
    $query = "INSERT INTO admin(`id`,`phone_number`, `username`, `password`) VALUES ('$id', '$nomor', '$username', '$hashed_password')";
    $kirim = mysqli_query($conn, $query);

    if ($kirim) {
        $_SESSION["admin"] = true;
        $_SESSION["admin_id"] = $id;
        header("Location: index.php");
        exit;
    } else {
        echo "Terjadi kesalahan: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=Edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>register cuy</title>
  
  <!-- Custom Styles -->
  <link rel="stylesheet" href="style.css">
</head>

<body>
  
 <form action="" method="post">
   <input type="text" name="username" id="username" placeholder="username">
    <input type="text" name="nomor" id="nomor" placeholder="phone number">    
   <input type="text" name="password" id="password" placeholder="password">
   <button type="submit" name="submit">Register</button>
 </form>
 
 
 
  <!-- Javascript -->
  <script src="main.js"></script>
</body>
</html>