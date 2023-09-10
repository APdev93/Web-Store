<?php
require "../../db.php";
session_start();

// Cek apakah pengguna sudah login
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
} else {
  header("Location: ../dashboard.php");
  exit();
}

//fungsi nomor acak
function randnum($length)
{
  $characters = "0123456789";
  $randomNumber = "";

  for ($i = 0; $i < $length; $i++) {
    $randomNumber .= $characters[rand(0, strlen($characters) - 1)];
  }

  return $randomNumber;
}

//ambil data dari parameter
$uid = $_GET["uid"];
$item = $_GET["item"];

//ambil data item
$sql = "SELECT * FROM item WHERE id = '$item' ";
$query = mysqli_query($conn, $sql);
$data = mysqli_fetch_assoc($query);

//data transaksi
$id = randnum(10);
$jumlah = $data["jumlah"];
$harga = $data["harga"];
$status = "pending";

if (isset($_POST["submit"])) {
  $target = $_POST["target"];
  date_default_timezone_set("Asia/Jakarta");
  $date = date("Y-m-d H:i:s");

  $perintah = "INSERT INTO trx(`id`, `date`, `jumlah`, `harga`, `userid`, `status`, `item`, `target`) VALUES ('$id','$date','$jumlah','$harga','$uid','$status','$item','$target')";
  if ($conn->query($perintah)) {
    header("Location: payment.php?id=$id&harga=$harga&target=$target");
    exit();
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
  <link rel="stylesheet" href="/style/styles.css" type="text/css" media="all" />
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Lilita+One&display=swap');

    .in-head {
      margin-top: 70px;
      background-color: #ff8805;
      height: 50px;
      display: flex;
      flex-direction: row;
      align-items: center;
      gap: 10px;
    }

    .in-head a {
      margin-left: 10px;
      color: white;
    }

    .in-head h3 {
      font-family: "Lilita One", sans-serif;
      color: white;
      margin-top: 10px;
      margin-bottom: 0;
      margin-left: 5px;
    }

    .in-head h4 {
      color: white;
      font-size: 20px;
      margin-left: 5px;
      margin-bottom: 10px;
      font-weight: bold;
    }

    .in-container {
      display: flex;
      justify-content: center;
      flex-direction: column;
      height: 100%;
    }

    .in-card {
      margin: auto;
      margin-top: 10px;
      margin-bottom: 10px;
      border: 1px solid #CED4DA;
      width: 95%;
      border-radius: 5px;
    }

    .in-c-head {
      border-bottom: 1px solid #CED4DA;
      display: flex;
      flex-direction: row;
    }

    .in-c-head img {
      margin-left: 5px;
    }

    .in-c-head h3 {
      color: black;
      font-size: 15px;
      font-weight: bold;
      margin-top: auto;
      margin-bottom: auto;
      margin-left: 10px;
    }

    .in-c-head .petir {
      height: 40px;
      margin-top: auto;
      margin-bottom: auto;
      margin-left: auto;
    }

    form h4 {
      color: black;
    }

    .payment-info {
      display: flex;
      flex-direction: row;
      justify-content: center;
      gap: 20px;
      margin-bottom: 50px;
    }

    .payment-info img {
      width: 50px;
      height: 20px;
    }

    .payment-info img:nth-child(1) {
      height: 19px;
      width: 65px;
    }

    .payment-info img:nth-child(2) {
      height: 16px;
      width: 70px;
    }

    .btn-order {
      display: flex;
      justify-content: center;
      flex-basis: column;
    }

    .instruction h3 {
      color: #faa835;
      margin-left: 10px;
      font-size: 20px;
      text-shadow: 1px 1px 1px black;
      border-left: 5px solid #9a4f0f;
    }

    .instruction h4 {
      margin-left: 30px;
      font-size: 15px;

    }

    .fot {
      margin-top: 30px;
      opacity: 0.5;
      bottom: 0;
      position: bottom;
    }

    .pp {
      margin-top: auto;
      font-size: 30px;
      font-family: sans-serif;
    }

    @media (width < 600px) {
      .in-container {
        display: flex;
        flex-direction: column;
        gap: 0;
      }
    }

    @media (width >=600px) {
      .in-container {
        display: flex;
        flex-direction: row;
        gap: 0;
      }

      .in-card {
        width: 40%;
      }
    }
  </style>
  <title>Malzstore - confirm</title>
</head>

<body>
  <nav class="shadow-sm">
    <div class="logo">
      <h1>Malzstore.<span>id</span></h1>
    </div>
    <div id="menu" class="ham-menu">
      <input type="checkbox" name="check" id="check" href="#nav-menu" />
      <span id="ham1"></span>
      <span id="ham2"></span>
      <span id="ham3"></span>
    </div>
    <ul id="nav-menu" class="hide">
      <li><a class="selected" href="/">Home</a></li>
      <li><a href="price/">Price list</a></li>
      <li><a href="/users/">Dashboard</a></li>
      <li><a href="/page/faq/">Ketentuan layanan</a></li>
      <li><a class="button bg-warning" href="">login</a></li>
    </ul>
  </nav>
  <div class="in-head">
    <a href="/">home &gt;</a>
    <a href="../dashboard.php">dashboard &gt;</a>
    <a href="../item.php">price &gt;</a>
    <a href="index.php">confirm &gt;</a>
  </div>
  <div class="in-container">

    <div class="shadow-lg in-card mb-2">
      <div class="bg-white in-c-head">
        <img src="/assets/image/troli.png" class="mb-2 mt-2" width="30" alt="" />
        <h3 class="pp">PEMESANAN SOSIAL MEDIA</h3>
        <img class="petir" src="/assets/image/petir.png" width="25" alt="" />
      </div>

      <form action="" method="post">
        <div class="form-floating mb-4 mt-3">
          <input type="text" class="form-control" id="floatingInput" value="<?= $data[
            "item"
          ] ?>" readonly />
          <label for="floatingInput">nama item</label>
        </div>
        <div class="form-floating mb-4 mt-3">
          <input type="text" class="form-control" id="floatingInput" value="<?= $data[
            "description"
          ] ?>" readonly />
          <label for="floatingInput">Deskripsi item</label>
        </div>
        <div class="form-floating mb-4">
          <input type="text" class="form-control" id="floatingInput" value="<?= $data[
            "jumlah"
          ] ?>" readonly />
          <label for="floatingInput">Jumlah pesanan</label>
        </div>
        <div class="form-floating mb-4">
          <input type="text" class="form-control" id="floatingInput" value="Rp.<?= $data[
            "harga"
          ] ?>" readonly />
          <label for="floatingInput">Harga/Total</label>
        </div>
        <div class="form-floating mb-4">
          <input name="target" type="text" class="form-control" id="floatingInput" />
          <label for="floatingInput">Target/link profile</label>
        </div>
        <div class="payment-info">
          <img src="/assets/image/dana.png" />
          <img src="/assets/image/gopay.png" />
          <img src="/assets/image/ovo.png" />
          <img src="/assets/image/shope.png" />
        </div>
        <div class="btn-order">
          <button name="submit" type="submit" class="mt-2 mb-3 btn btn-primary btn-lg">
            Buat Pesanan
          </button>
        </div>
      </form>
    </div>
    <div class="in-card c-2 mt-0 bg-white shadow">
      <div class="instruction mt-2 mb-4">
        <h3>Cara Pemesanan</h3>
        <h4>• Memasukan link akun target</h4>
        <h4>• Pastikan akun tidak bersifat pribadi</h4>
        <h4>• Klik tombol biru di bawah untuk membuat pesanan</h4>
        <h4>• Jangan lupa bayar ya :)</h4>
      </div>
      <div class="instruction mb-2">
        <h3>Peraturan</h3>
        <h4>• Tidak boleh membuat pesanan apabila tidak niat untuk membeli</h4>
        <h4>• Proses masuk Followers/Like/Views cepat atau lambatnya tergantung sistem</h4>
      </div>
    </div>
  </div>

  <div class="footer fot">
    <p class="copyright">&copy; Malzstore.id</p>
  </div>

  <script src="/style/index.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
    crossorigin="anonymous"></script>
</body>

</html>