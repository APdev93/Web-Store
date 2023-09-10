<?php
session_start();
require "../db.php";

$sql = "SELECT * FROM item";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
  $items = [];
  while ($d = mysqli_fetch_assoc($result)) {
    $items[] = $d;
  }
}
?>



<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>malzstore - price</title>
  <link rel="stylesheet" href="../style/styles.css">
  <style type="text/css" media="all">
    * {
      padding: 0;
      margin: 0;
      font-family: sans-serif;
      -webkit-tap-highlight-color: transparent;
    }

    body {
      display: flex;
      justify-content: center;
      align-items: center;
      flex-direction: column;
    }

    a {
      color: inherit;
      text-decoration: none;
    }

    .add {
      width: 30px;
      height: 30px;
      display: flex;
      justify-content: center;
      align-items: center;
      border-radius: 20px;
      font-size: 22pt;
      font-weight: bold;
      background-color: #fff;
      transition: 0.2s ease-in-out;
      cursor: pointer;
    }

    .add:hover {
      box-shadow: 0 0 7px #00000075;
      font-size: 20pt;
    }

    .container {
      width: 90%;
      position: auto;
      padding: 10px;
      list-style: none;
      display: flex;
      align-items: center;
      flex-wrap: wrap;
      justify-content: space-evenly;
    }

    .container li {
      box-shadow: 0 0 5px #00000048;
      width: 160px;
      height: 260px;
      padding-top: 10px;
      padding-bottom: 10px;
      border-radius: 10px;
      margin-top: 20px;
      display: flex;
      justify-content: space-around;
      align-items: center;
      flex-direction: column;
      transition: 0.2s ease-in-out;
    }

    .container li:hover {
      box-shadow: 0 0 13px #00000048;
    }

    .container li img {
      border-radius: 10px;
      width: 120px;
      height: 120px;
      margin-bottom: 9px;
    }

    .container li a {
      background-color: #00D5FF;
      padding: 5px;
      border-radius: 5px;
      color: #fff;
      margin-top: 25px;
    }

    .date {
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .item-inf {
      height: 60px;
      display: flex;
      justify-content: space-between;
      flex-direction: column;
    }

    .item-inf h4 {
      color: #545454;
    }

    .item-inf h5 {
      color: red;
      margin-top: 10px;
    }

    .date {
      padding-top: 5px;
    }

    .date h6 {
      color: #989898;
    }

    nav {
      background-color: white !important;
    }

    .jumlah {
      width: 100%;
      text-align: center;
    }
  </style>
  <style type="text/css" media="all">
    * {
      padding: 0;
      margin: 0;
      font-family: sans-serif;
      -webkit-tap-highlight-color: transparent;
    }

    body {
      display: flex;
      justify-content: center;
      align-items: center;
      flex-direction: column;
    }

    a {
      color: inherit;
      text-decoration: none;
    }

    nav {
      box-shadow: 0 0 5px #00000075;
    }

    nav h1 {
      color: #fff;
    }

    .add {
      width: 30px;
      height: 30px;
      display: flex;
      justify-content: center;
      align-items: center;
      border-radius: 20px;
      font-size: 22pt;
      font-weight: bold;
      background-color: #fff;
      transition: 0.2s ease-in-out;
      cursor: pointer;
    }

    .add:hover {
      box-shadow: 0 0 7px #00000075;
      font-size: 20pt;
    }

    .container {
      width: 95%;
      position: auto;
      padding: 10px;
      list-style: none;
      display: flex;
      align-items: center;
      flex-wrap: wrap;
      justify-content: space-evenly;
    }

    .container li {
      box-shadow: 0 0 5px #00000048;
      width: 160px;
      min-height: 290px;
      padding-top: 10px;
      padding-bottom: 10px;
      border-radius: 10px;
      margin-top: 20px;
      display: flex;
      justify-content: space-around;
      align-items: center;
      flex-direction: column;
      transition: 0.2s ease-in-out;
    }

    .container li:hover {
      box-shadow: 0 0 13px #00000048;
    }

    .container li img {
      border-radius: 10px;
      width: 120px;
      height: 120px;
      margin-bottom: 9px;
    }

    .action {
      width: 100%;
      display: flex;
      justify-content: space-evenly;
    }

    .action a {
      background-color: #00D5FF;
      padding: 5px;
      border-radius: 5px;
      color: #fff;
      margin-top: 25px;
      cursor: pointer;
    }

    .action a:hover {
      box-shadow: 0 0 10px #00000048;
    }

    .date {
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .item-inf {
      height: 60px;
      width: 145px;
      display: flex;
      justify-content: space-between;
      flex-direction: column;
    }

    .item-inf h4 {
      color: #545454;
      width: 100%;
      text-align: center;
    }

    .item-inf h5 {
      color: red;
      margin-top: 10px;
    }

    .date {
      padding-top: 5px;
    }

    .date h6 {
      color: #989898;
    }

    .jumlah {
      width: 100%;
      text-align: center;
    }

    .contain-tit {
      width: 100%;
      height: 50px;
      background-color: #ff8805;
      margin-top: 15%;
      display: flex;
      flex-direction: row;
      align-items: center;
    }

    .contain-tit h3 {
      margin-left: auto;
      color: white;
      margin-right: 20px;
    }

    .contain-tit a {
      color: white;
      margin-left: 10px;
    }
    @media (width >= 600px) {
       .contain-tit {
          margin-top:8%;
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
      <li><a href="./dashboard.php">Dashboard</a></li>
      <li><a href="../page/faq/">Faq</a></li>
    </ul>
  </nav>
  <div class="contain-tit">
    <a href="/">home &gt;</a>
    <a href="./dashboard.php">dashboard &gt;</a>
    <a href="item.php">price</a>
    <h3>price list</h3>
  </div>

  <ul class="container">
    <?php foreach ($items as $i): ?>

    <li>
      <img src="../../img/<?= $i["img"] ?>" alt="instagram.jpeg">
      <div class="item-inf">
        <h4 class="jumlah">
          <?= $i["jumlah"] ?>
        </h4>
        <h4>
          <?= $i["item"] ?>
        </h4>
        <h5>Rp
          <?= $i["harga"] ?>
        </h5>
        <div class="date">
          <h6>(
            <?= $i["kode_barang"] ?>)
          </h6>
          <h6>
            <?= $i["date"] ?>
          </h6>
        </div>
      </div>
      <a href="purchase/index.php?uid=<?= $_SESSION["user_id"] ?>&item=<?= $i[
  "id"
] ?>">Pesan</a>
    </li>

    <?php endforeach; ?>
  </ul>

  <script src="../style/index.js"></script>
</body>

</html>