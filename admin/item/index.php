<?php
session_start();
require "../../db.php";

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
  <link rel="stylesheet" href="/style/styles.css">
  <title>add price</title>
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
      background-color: rgb(108, 108, 108);
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
      margin-top: 70px;
      background-color: #ff8805;
      height: 50px;
      display: flex;
      flex-direction: row;
      align-items: center;
      gap: 10px;
      width: 100%;
    }

    .contain-tit a {
      color: white;
      margin-left: 10px;
    }

    .contain-tit h3 {
      margin-left: auto;
      color: white;
    }

    .contain-tit .add {
      margin-right: 10px;
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
  <div class="contain-tit">
    <a href="/">home &gt;</a>
    <a href="../dashboard.php">dashboard &gt;</a>
    <a href="index.php">price list</a>
    <h3>price list</h3>
    <a class="add" href="add.php">+
    </a>
  </div>

  <ul class="container">

    <?php foreach ($items as $i): ?>

    <li>
      <img src="../../img/<?= $i["img"] ?>" alt="image.jpeg">
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
      <div class="action">
        <a href="update.php?id=<?= $i["id"] ?>">Update</a>
        <a href="delete.php?action=delete&id=<?= $i["id"] ?>&img=<?= $i[
  "img"
] ?>">Delete</a>
      </div>
    </li>

    <?php endforeach; ?>

  </ul>


</body>

</html>