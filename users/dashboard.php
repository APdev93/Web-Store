<?php
session_start();
require "../db.php";

// Cek apakah pengguna sudah login
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
  $id = $_SESSION["user_id"];
  $sql = "SELECT * FROM cs WHERE id = '$id'";
  $get = mysqli_query($conn, $sql);
  $data = mysqli_fetch_assoc($get);

  $trx = [];
  $query = "SELECT * FROM trx WHERE userid = '$id' LIMIT 10";
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

//fungsi cancel pesanan
function cancel($id)
{
  global $conn;

  $sql = "DELETE FROM trx WHERE id = '$id'";

  if ($conn->query($sql)) {
    header("Location: index.php");
    exit();
  }
}

//ambil data dari form
if (isset($_POST["submit"])) {
  $trx = search($_POST["search"]);
} elseif (isset($_POST["cancel"])) {
  $value = $_POST["value"];
  $id = $_POST["id"];

  cancel($id);
  //echo("<script>alert('$id');</script>");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="user.css">
  <title>malzstore - User Page</title>
  <style type="text/css" media="all">
    nav {
      box-shadow: 0 0 10px #00000078;
    }

    body {
      align-items: center;
      display: flex;
      flex-direction: column;
    }

    .container {
      width: 90%;
      min-height: auto;
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
      width: 90%;
      display: flex;
      justify-content: center;
      align-items: center;
      flex-direction: column;
      border: 1px solid #00000078;
      border-radius: 5px;
      padding-top: 10px;
      margin-bottom: 20px;
    }

    .trx {
      box-sizing: border-box;
    }

    .trx-container h2 {
      color: #e4941d;
      margin-bottom: 20px;
    }

    thead {
      background-color: #e4941d;
      color: white;
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
      width: 100%;
      display: flex;
      justify-content: space-around;
      align-items: center;
      border-radius: 10px;
      margin-bottom: 20px;
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

    .main-container {
      width: 95%;
      display: flex;
      flex-direction: row;
      justify-content: center;
      align-items: center;
      gap: 20px;
    }

    /* nav menu */
    .nav-menu {
      width: 150px;
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
      gap: 15px;
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
      background-color: #e4941d;
      color: #fff;
      border-radius: 5px;
      padding: 4px;
    }

    .cancel {
      border: none;
      outline: none;
      background-color: #474747c1;
      padding: 2px;
      color: #fff;
      width: 100%;
      border-radius: 5px;
      margin-top: 3px;
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

    .selected {
      color: #e4941d;
      text-decoration: underline;
    }

    .c-t {
      margin-top: 10px;
    }

    @media (width < 600px) {
      .main-container {
        width: 95%;
        display: flex;
        flex-direction: column;
      }
      .container {
         width: 95%;
      }
    }

    @media (width >=600px) {
      .main-container {
        display: flex;
        flex-direction: row;
        gap: 30px;
        width: 95%;
      }
      

      .c-t {
        margin-top: 15px;
      }

      .container {
        width: 50%;
      }

      .ham-menu {
        display: none;
      }

      .hide {
        display: flex;
        margin-top: auto;
        margin-bottom: auto;
        gap: 20px;
        margin-left: auto;
        margin-right: 20px;
      }

      nav ul li {
        list-style: none;
      }

      nav ul li a:hover {
        color: var(--bg-black1);
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
      <li><a href="item.php">Price list</a></li>
      <li><a class="selected" href="dashboard.php">Dashboard</a></li>
      <li><a href="../page/faq/">Ketentuan layanan</a></li>
    </ul>
  </nav>

  <div class="container-tit">
    <img width="40"
      src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQBO4HKBPul4uUadbu0_a_6yMAHzJSYIPpNCQ&usqp=CAU" alt="">
    <h3>
      <?= $data["username"] ?>
    </h3>
    <h2>Dashboard</h2>
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
            <td>Buyer</td>
          </tr>
        </table>
        <ul class="action">
          <!--<li><a href="">update</a></li>
        <li><a href="">Delete</a></li>-->
          <li><a href="logout.php">Logout</a></li>
        </ul>
      </div>
    </div>
  <div class="container c-t">

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
              <?php
              $idt = $t["id"];
              if ($t["status"] == "pending") {
                echo "<h5 class='pending'>pending</h5>
                <form method='post' action=''>
                  <input type='hidden' name='value' value='cancel'>
                   <input type='hidden' name='id' value='$idt'>
                  <button class='cancel' type='submit' name='cancel'>cancel</button>
                </form>                  
                  ";
              } elseif ($t["status"] == "process") {
                echo '<h5 class="process">process </h5>';
              } elseif ($t["status"] == "success") {
                echo '<h5 class="success">success </h5>';
              } else {
                echo "else";
              }
              ?>

            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>

      </table>
    </div>
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