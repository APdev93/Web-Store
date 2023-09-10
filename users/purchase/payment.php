<?php
session_start();

  $id = $_GET["id"];
  $harga = $_GET["harga"];
  $target = $_GET["target"];
  

$pesan = "
┏═════════════════════┓%0A
                    *MALZSTORE.ID*%0A
┗═════════════════════┛%0A
╔────────┤INFO├────────╗%0A
 %0A
      *ID PESANAN*   :  $id %0A
      *HARGA*             :  $harga%0A
%0A
╚─────────────────────╝%0A
%0A
*📌TARGET*%0A
LINK : $target%0A
%0A
*⚠️MOHON DIBACA!*%0A
- Segera Kirim Bukti Pembayaran Di Sini%0A
- Pastikan Akun Sosmed Anda Tidak Di Privat%0A
- Proses Masuk Followers/Likes/Views Cepat Atau Lambatnya Tergantung Antrian Pada Sistemnya%0A
";


  // Cek apakah pengguna sudah login
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
  

  
}else{
  header('Location: ../dashboard.php'); 
  exit;
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
  <link rel="stylesheet" href="style.css" type="text/css" media="all" />
  <title>Malzstore - payment</title>
  <style>
    @import url("https://fonts.googleapis.com/css2?family=Noticia+Text:wght@700&&display=swap");

    @import url("https://fonts.googleapis.com/css2?family=Mukta:wght@200&display=swap");

    .p-container {
      display: flex;
      flex-direction: column;
      justify-content: center;
      margin-top: 70px;
    }

    .p-title {
      background-color: #ff8805;
      text-align: left;
      height: 50px;
      margin-top: 70px;
      display: flex;
      flex-direction: row;
      align-items: center;
    }

    .p-title a {
      font-size: 20px;
      color: white;
      margin-left: 10px;
    }

    .p-title h2 {
      margin: auto;
      margin-top: 10px;
      margin-bottom: 10px;
      margin-left: 5px;
      font-family: "Helvetica", Sans-Serif;
      color: white;
      font-size: 25px;
      bottom: 0;
    }

    .p-card {
      width: 95%;
      height: auto;
      display: flex;
      flex-direction: column;
      margin: auto;
      margin-top: 10px;
      border: 1px solid #CED4DA;
      border-radius: 5px;
      margin-bottom: 30px;
    }

    .p-card h3 {
      margin-top: 15px;
      font-size: 20px;
      font-weight: bold;
      margin-bottom: 15px;
    }

    .p-c-desk {
      text-align: left;
    }

    .p-c-desk p {
      margin-bottom: 1px;
      margin-left: 20px;
      margin-right: 20px;
      font-family: "Lilita One", sans-serif;
      font-weight: bold;
      font-size: 15px;
    }

    .p-c-desk p:nth-child(1) {
      margin-top: 20px;
    }

    .p-c-desk p:nth-child(6) {
      margin-bottom: 10px;
    }

    .p-qr {
      text-align: center;
    }

    .detail {
      border-bottom: 1px solid #CED4DA;
      background-color: #4de758;
      border-top-right-radius: 5px;
      border-top-left-radius: 5px;
      color: white;
    }

    p span {
      color: blue;
    }

    .qr-info {
      width: 95%;
      margin-bottom: 10px;
    }

    .qr-info h3 {
      margin-left: 20px;
    }

    .qr-info p {
      font-size: 15px;
      font-family: "Lilita One", sans-serif;
      margin-left: 20px;
      margin-right: 20px;
      font-weight: bold;
    }

    .p-btn {
      display: flex;
      justify-content: center;
    }

    @media (width >=600px) {
      .p-card {
        width: 50%;
      }
    }
  </style>
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
      <li><a href="/">Home</a></li>
      <li><a href="../item.php">Price list</a></li>
      <li><a href="../dashboard.php">Dashboard</a></li>
      <li><a href="../page/faq/">Faq</a></li>
    </ul>
  </nav>
  <div class="p-container">
    <div class="mt-1 p-title">
      <a href="/">home &gt;</a>
      <a href="../dashboard.php">dashboard &gt;</a>
      <a href="../item.php">price &gt;</a>
      <a href="./index.php">confirm &gt;</a>
      <a href="./payment.php">payment</a>
    </div>
    <div class="shadow-lg p-card">
      <div class="detail">
        <h3 align="center">Detail Pembayaran</h3>
      </div>
      <div class="p-c-desk">
        <p>ID PESANAN :
          <?= $id?>
        </p>
        <p>METODE PEMBAYARAN : QRIS, SHOPEEPAY, GOPAY, DANA, OVO</p>
        <br />
        <p>E-WALLET: <span>089636303141</span></p>
      </div>
      <div class="mt-5 p-qr">
        <img src="/assets/image/qris.png" width="300" />
      </div>
      <div class="mb-5 p-qr">
        <img src="/assets/image/qr.png" width="350" alt="qr" />
      </div>
      <div class="qr-info">
        <h3>JUMLAH: Rp.
          <?= $harga?>
        </h3>
        <p>Silahkan transfer/scan sesuai dengan nominal yang sudah di tentukan</p>
      </div>
      <div class="p-btn btn-order">
        <a href="https://api.whatsapp.com/send?phone=62877592182744&text=<?= $pesan?>
" class="mt-2 mb-3 btn btn-primary btn-lg">
          kirim bukti
        </a>
      </div>
    </div>
  </div>
  <div class="footer fot">
    <p class="copyright">&copy; Malzstore.id</p>
  </div>
  <script src="index.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
    crossorigin="anonymous"></script>
</body>

</html>