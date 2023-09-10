<?php
require "../db.php";
session_start();

// Cek apakah pengguna sudah login
if (isset($_SESSION['admin']) && $_SESSION['admin'] === true) {
  
  header('Location: dashboard.php'); 
  exit;
  //echo "<script>window.location.href='dashboard.php';</script>";

}

if (isset($_POST["submit"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Ambil data user berdasarkan username
    $query = "SELECT * FROM admin WHERE username = '$username'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $hashed_password = $row["password"];

        // Membandingkan password yang diinputkan dengan password yang sudah di-hash
        if (password_verify($password, $hashed_password)) {
            $_SESSION["admin"] = true;
            $_SESSION["admin_id"] = $row["id"];
            header("Location: dashboard.php");
            exit;
        } else {
            echo "<script>alert('password salah');</script>";
        }
    } else {
        echo "<script>alert('Akun Tidak Di Temukan');</script>";
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
  <link rel="stylesheet" href="../style/styles.css" type="text/css" media="all" />
  <title>MalzStore - login</title>
</head>

<body>
  <div class="home-log">
    <div class="shadow card card-log">
      <h2 class="title-log">Cpanel Login</h2>
      <form class="mb-5" action="" method='post'>

        <div class="form-floating mb-3">
          <input name="username" type="text" class="form-control" id="floatingInput" placeholder="username" value
            required>
          <label for="floatingInput">Username</label>
        </div>

        <div class="form-floating mb-3">
          <input name="password" type="password" class="form-control" id="floatingPassword" placeholder="Password" value
            required>
          <label for="floatingPassword">Password</label>
        </div>

        <div class="alert-log mt-3 mb-3">
          <input class="checkbox" type="checkbox" value required>
          <p>ingatkan saya</p>
          <a href="">lupa sandi?</a>
        </div>

        <button name="submit" type="submit" class="btn-login ">login</button>

      </form>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
    crossorigin="anonymous"></script>
</body>

</html>