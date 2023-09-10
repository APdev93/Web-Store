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
    $phone_number = $_POST["phone_number"];
    $password = $_POST["password"];
    $id = acak(16);
    

    // Escape data yang akan dimasukkan ke dalam query SQL untuk mencegah SQL injection
    $username = mysqli_real_escape_string($conn, $username);
    $phone_number = mysqli_real_escape_string($conn, $phone_number);
    $password = mysqli_real_escape_string($conn, $password);

    // Hash password sebelum disimpan ke database
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Kirim data registrasi user ke database
    $query = "INSERT INTO cs(`id`, `username`, `password`, `phone_number`) VALUES ('$id', '$username', '$hashed_password', '$phone_number')";
    $kirim = mysqli_query($conn, $query);

    if ($kirim) {
        $_SESSION['loggedin'] = true;
        $_SESSION['user_id'] = $id;
        header("Location: index.php");
    } else {
        echo "Terjadi kesalahan: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />
  <link rel="stylesheet" href="user.css" type="text/css" media="all" />
  <title>MalzStore - register</title>
</head>

<body>
  <div class="home-log">
    <div class="shadow card card-log">
      <h2 class="title-log">Register</h2>
      <form action="" method="post" >
        <div class="form-floating mb-3">
          <input name="username" type="text" class="form-control" id="floatingInput" placeholder="username" value required>
          <label for="floatingInput">Username</label>
        </div>


        <div class="form-floating mb-3">
          <input name="password" type="password" class="form-control" id="floatingPassword" placeholder="Password" value required>
          <label for="floatingPassword">Password</label>
        </div>

        <div class="form-floating mb-3">
          <input name="phone_number" type="number" class="form-control" id="floatingInput" placeholder="username" value required>
          <label for="floatingInput">Whatsapp number</label>
        </div>

        <div class="alert-log mb-3">
          <input class="checkbox" type="checkbox" value required>
          <p>saya setuju dengan</p>
          <a href="/page/faq/">ketentuan layanan</a>
        </div>
        <button name="submit" type="submit" class="btn-login ">Daftar</button>
        <div class="register-info mt-3">
          <p>
            sudah punya akun? <a href="index.php"> Login</a>
          </p>
          
        </div>
        <p>
        <a href="/">kembali ke halaman utama</a>
        </p>
      </form>
    </div>
  </div>

  <div class="card">
     
  </div>
  
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
    crossorigin="anonymous"></script>
</body>

</html>