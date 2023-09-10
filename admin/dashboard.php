<?php
session_start();
require "../db.php";

// Cek apakah pengguna sudah login
if (isset($_SESSION["admin"]) && $_SESSION["admin"] === true) {
  $id = $_SESSION["admin_id"];
  $sql = "SELECT * FROM admin WHERE id = '$id'";
  $get = mysqli_query($conn, $sql);
  $data = mysqli_fetch_assoc($get);

  $trx = [];
  $query = "SELECT * FROM trx LIMIT 10";
  $trx_data = mysqli_query($conn, $query);

  while ($d = mysqli_fetch_assoc($trx_data)) {
    $trx[] = $d;
  }
} else {
  header("Location: index.php");
  exit();
}

//fungsi pencarian
function search($id)
{
  global $conn;

  $data = [];
  $query = "SELECT * FROM trx WHERE id = '$id'";
  $trx_data = mysqli_query($conn, $query);
  while ($d = mysqli_fetch_assoc($trx_data)) {
    $data[] = $d;
  }
  return $data;
}

//fungsi ambil nama item
function iname($i)
{
  global $conn;

  $sql = "SELECT * FROM item WHERE id = '$i'";
  $query = mysqli_query($conn, $sql);
  $item = mysqli_fetch_assoc($query);
  return $item["item"];
}

//fungsi ubah status
function status($id, $value)
{
  global $conn;

  $data = search($id);

  //data pama
  $date = $data[0]["date"];
  $jumlah = $data[0]["jumlah"];
  $harga = $data[0]["harga"];
  $userid = $data[0]["userid"];
  $item = $data[0]["item"];
  $target = $data[0]["target"];
  // var_dump($data[0]);
  //echo( "<script>alert('$date');</script>");
  // var_dump($data[0]["status"]);
  $sql = "UPDATE trx SET
    date = '$date',
    jumlah = '$jumlah',
    harga = '$harga',
    userid = '$userid',
    status = '$value',
    item = '$item',
    target = '$target'
    WHERE id = '$id'";

  $update = mysqli_query($conn, $sql);

  if ($update) {
    header("Location: blank.php");
    exit();
  } else {
    $err = mysqli_error($conn);
    echo "<script>alert('Gagal: $err');</script>";
  }

  /*if ($conn->query($sql) === TRUE) {
    echo "<script>alert('Berhasil update');</script>";
    $trx = [];
    $query = "SELECT * FROM trx";
    $trx_data = $conn->query($query);
  
    while ($d = $trx_data->fetch_assoc()) {
      $trx[] = $d;
    }
  } else {
    echo "<script>alert('Gagal update: " . $conn->error . "');</script>";
  }*/
}

//ambil data dari form
if (isset($_POST["submit"])) {
  $trx = search($_POST["search"]);
} elseif (isset($_POST["aply"])) {
  status($_POST["trx_id"], $_POST["status"]);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="style.css">
  <title>malzstore - admin Page</title>
  <style type="text/css" media="all">
    .aply {
      border: none;
      outline: none;
      width: 95%;
      background-color: #e99a09;
      border-radius: 5px;
      padding: 2px;
      margin: 2px;
    }

    nav {
      box-shadow: 0 0 10px #00000078;
    }

    body {
      align-items: center;
      display: flex;
      flex-direction: column;
    }

    .container {
      width: 450px;
      height: auto;
      display: flex;
      align-items: center;
      flex-direction: column;
      margin-top: 10px;
      box-shadow: 0 0 7px #0000008A;
      border-radius: 10px;
    }

    .container h2 {
      font-weight: bold;
    }

    .trx-container {
      margin-top: 10px;
      width: 400px;
      display: flex;
      justify-content: center;
      align-items: center;
      flex-direction: column;
      border: 1px solid #00000078;
      border-radius: 5px;
      padding-top: 10px;
      margin-bottom: 10px;
    }

    .trx {
      box-sizing: border-box;
    }

    .trx-container h2 {
      color: #e99a09;
      margin-bottom: 20px;
    }

    thead {
      background-color: #e99a09;
    }

    tr,
    td {
      padding: 7px;
    }

    .trx-container tbody tr:hover {
      background-color: #D9D9D9;
    }

    .pending {
      padding: 4px;
      background-color: red;
      border-radius: 10px;
      color: white;
    }

    .success {
      padding: 4px;
      background-color: limegreen;
      border-radius: 10px;
      color: white;
    }

    .process {
      padding: 4px;
      background-color: #AD03FF;
      border-radius: 10px;
      color: white;
    }

    select {
      border: none;
      outline: none;
    }

    /* admin */
    .admin {
      margin-top: 20px;
      margin-bottom: 20px;
      width: 450px;
      display: flex;
      justify-content: space-around;
      align-items: center;
      border-radius: 10px;
    }

    /* search */
    .search {
      width: 96%;
      margin-bottom: 10px;
      display: flex;
      justify-content: center;
    }

    .search input {
      height: 40px;
      border-radius: 10px;
      border-top-right-radius: 0;
      border-bottom-right-radius: 0;
      width: 78%;
      outline: none;
      border: none;
      padding: 3px;
      box-shadow: 0 0 5px #00000030;
      font-size: 12pt
    }

    .search button {
      background-color: transparent;
      border: none;
      background-color: #e4941d;
      padding: 4px;
      border-radius: 10px;
      border-top-left-radius: 0;
      border-bottom-left-radius: 0;
      color: #fff;
    }

    .search button:hover {
      background-color: #8b5a11;
      color: #00000078;
    }

    .menu {
      display: flex;
      justify-content: space-evenly;
      align-items: center;
      flex-direction: column;
      width: 35px;
      height: 45px;
    }

    .ham-menu {
      display: flex;
      justify-content: space-between;
      align-items: center;
      flex-direction: column;
      width: 30px;
      height: 25px;
      transition: 0.3s;
      cursor: pointer;
      margin-right: 20px;
    }

    .ham-menu span {
      background-color: var(--bg-white1);
      height: 5px;
      width: 30px;
      border-radius: 5px;
      transition: 0.3s ease-in-out;
      box-shadow: 1px 1px 1px black;
    }

    .ham-menu span:nth-child(2) {
      transform-origin: 0 0;
    }

    .ham-menu span:nth-child(4) {
      transform-origin: 0 100%;
    }

    .ham-menu input {
      top: 5px;
      z-index: 9;
      position: absolute;
      width: 50px;
      height: 50px;
      opacity: 0;
      cursor: pointer;
      border: 1px solid black;
    }

    .ham-menu input:checked~span:nth-child(2) {
      background-color: var(--bg-black1);
      box-shadow: none;
      transform: rotate(45deg);
    }

    .ham-menu input:checked~span:nth-child(3) {
      transform: scale(0);
    }

    .ham-menu input:checked~span:nth-child(4) {
      background-color: var(--bg-black1);
      box-shadow: none;
      transform: rotate(-45deg);
    }

    /* nav menu */
    .nav-menu {
      width: 190px;
      height: auto;
      position: absolute;
      box-shadow: 0 5px 10px #00000070;
      border-radius: 5px;
      background-color: #fff;
      padding: 10px;
      list-style: none;
      top: 65px;
      display: flex;
      justify-content: space-between;
      flex-direction: column;
      z-index: -3;
      right: -200px;
      animation: moveLeft 0.5s forwards;
    }

    @keyframes moveLeft {
      0% {
        right: -200px;
      }

      100% {
        right: -1px;
      }
    }

    .nav-menu li {
      padding: 5px;
      border-radius: 15px;
      transition: 0.3s;
      list-style: none;
    }

    .nav-menu li:hover {
      margin-left: 10px;
    }

    .nav-menu li a {
      font-size: 15px;
      color: black;
      text-decoration: none;
      font-family: "Play", sans-serif;
    }

    .hide {
      display: none;
    }

    a {
      text-decoration: none;
    }

    .action {
      height: 90px;
      width: 80px;
      display: flex;
      justify-content: space-between;
      flex-direction: column;
      align-items: center;
      list-style: none;
    }

    .action li {
      width: 60px;
      height: 40px;
      align-items: center;
      height: auto;
      display: flex;
      justify-content: center;
    }

    .action li a {
      background-color: #FFCF00;
      color: #fff;
      border-radius: 5px;
      padding: 4px;
    }

    .main-container {
      display: flex;
      gap: 0;
      flex-direction: column;
    }


    .container-tit {
      margin-top: 70px;
      width: 100%;
      height: 50px;
      text-align: center;
      background: linear-gradient(45deg, #e4941d, #ffb548);
      color: white;
      display: flex;
      flex-direction: row;
      align-items: center;
    }

    .container-tit img {
      border-radius: 100px;
      margin-left: 10px;
      margin-right: 10px;
    }

    .container-tit h2 {
      margin-left: auto;
      margin-right: auto;
    }

    .button {
      margin-right: 10px;
    }

    @media (width >=600px) {
      .main-container {
        flex-direction: row;
        gap: 20px;
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
      <li><a href="item">Price list</a></li>
    </ul>
  </nav>

  <div class="container-tit">
    <img width="40"
      src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQBO4HKBPul4uUadbu0_a_6yMAHzJSYIPpNCQ&usqp=CAU" alt="">
    <h3>
      <?= $data["username"] ?>
    </h3>
    <h2>admin</h2>
    <a class="button" href="logout.php">Logout</a>
  </div>

  <div class="main-container">

    <div class="container">
      <div class="admin">
        <table>
          <tr>
            <td>Username</td>
            <td>:</td>
            <td>
              <?= $data["username"] ?>
            </td>
          </tr>
          <tr>
            <td>nomor Hp</td>
            <td>:</td>
            <td>
              <?= $data["phone_number"] ?>
            </td>
          </tr>
          <tr>
            <td>account type</td>
            <td>:</td>
            <td>Admin</td>
          </tr>
        </table>
        <ul class="action">
        </ul>
      </div>
    </div>
    <div class="container">
      <h2>Riwayat pesanan masuk</h2>
      <div class="trx-container">
        <form class="search" action="" method="POST">
          <input type="search" name="search" id="seaech" placeholder="cari id pembelian">
          <button name="submit" type="submit">Search</button>
        </form>
        <table cellspacing="0" cellpadding="0" class="trx">
          <thead align="center" style="font-weight: bold;">
            <td>ID</td>
            <td>item</td>
            <td>harga</td>
            <td>status</td>
          </thead>
          <tbody padding="10px">
            <?php foreach ($trx as $t): ?>
            <tr>
              <td>
                <?= $t["id"] ?>
              </td>
              <td>
                <?= iname($t["item"]) ?>
              </td>
              <td>
                <?= $t["harga"] ?>
              </td>
              <td>
                <form action="" method="post">

                  <?php if ($t["status"] == "pending") {
                    echo '<select name="status" class="pending" id="status">
                  <option class="select" name="pending" value="pending">pending</option>
                  <option class="select" value="process">process</option>
                  <option class="select" value="success">success</option>
                </select>';
                  } elseif ($t["status"] == "process") {
                    echo '<select name="status" class="process" id="status">
                  <option class="select" value="process">process</option>
                  <option class="select" name="pending" value="pending">pending</option>
                  <option class="select" value="success">success</option>
                </select>';
                  } elseif ($t["status"] == "success") {
                    echo '<select name="status" class="success" id="status">
                   <option class="select" value="success">success</option>
                  <option class="select" value="process">process</option>
                  <option class="select" name="pending" value="pending">pending</option>
                </select>';
                  } else {
                    echo "else";
                  } ?>



                  <input type="hidden" name="trx_id" value="<?= $t["id"] ?>">
                  <button name="aply" class="aply" type="submit">aply</button>

                </form>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <script>



    let menu = document.getElementById("menu");
    let check = document.getElementById("check");
    let ham2 = document.getElementById("ham2");
    let nav_menu = document.getElementById("nav-menu");

    window.onbeforeunload = function () {
      check.checked = false;
      if (check.checked) {
        menu.style.rotate = "180deg";
        nav_menu.classList = "nav-menu";
      } else {
        menu.style.rotate = "0deg";
        nav_menu.classList = "hide";
      }
    };

    check.addEventListener("click", function () {
      if (check.checked) {
        menu.style.rotate = "180deg";
        nav_menu.classList = "nav-menu";
        nav_menu.classList.add('muncul');
      } else {
        menu.style.rotate = "0deg";
        nav_menu.classList = "hide";
      }
    });
  </script>
</body>

</html>