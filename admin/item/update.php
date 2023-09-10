<?php
session_start();
require "../../db.php";

// Cek apakah pengguna sudah login
if (isset($_SESSION["admin"]) && $_SESSION["admin"] === true) {
  $id = $_GET["id"];
  $sql = "SELECT * FROM item WHERE id = '$id'";
  $get = mysqli_query($conn, $sql);
  $data = mysqli_fetch_assoc($get);
} else {
  header("Location: ../index.php");
  exit();
}

//fungsi ubah data with img
function imgubah()
{
  global $conn;
  global $data;

  //data
  $id = $data["id"];
  $judul = $_POST["judul"];
  $jumlah = $_POST["jumlah"];
  $harga = $_POST["harga"];
  $desc = $_POST["deskripsi"];
  $date = $_POST["date"];
  $kode_barang = $_POST["kode_barang"];

  //file
  $tmp = $_FILES["img"]["tmp_name"];
  $file_name = $_POST["gambarlama"];

  //upload file
  $path = "../../img/";
  $unpath = "../../img/";

  /*if (unlink($unpath . $file_name)) {
        echo("<script>alert('gambar dihapus');</script>");
      }*/
  unlink($unpath . $file_name);

  if (move_uploaded_file($tmp, $path . $file_name)) {
    $sql = "UPDATE item SET 
          item = '$judul',
          img = '$file_name',
          description = '$desc',
          harga = '$harga',
          jumlah = '$jumlah',
          date = '$date',
          kode_barang = '$kode_barang'
          WHERE id = '$id'";

    if (mysqli_query($conn, $sql)) {
      header("Location: index.php");
      exit();
    } else {
      echo "Terjadi kesalahan: " . mysqli_error($conn);
    }
  } else {
    echo "<script>alert('gambar tidak terkirim');</script>";
  }
}

//fungsi ubah data no img
function ubah()
{
  global $conn;
  global $data;
  //data
  $id = $data["id"];
  $judul = $_POST["judul"];
  $jumlah = $_POST["jumlah"];
  $harga = $_POST["harga"];
  $desc = $_POST["deskripsi"];
  $date = $_POST["date"];
  $kode_barang = $_POST["kode_barang"];
  $gambarlama = $_POST["gambarlama"];
  $file_name = $gambarlama;

  $sql = "UPDATE item SET 
      item = '$judul',
      img = '$file_name',
      description = '$desc',
      harga = '$harga',
      jumlah = '$jumlah',
      date = '$date',
      kode_barang = '$kode_barang'
      WHERE id = '$id'";

  if (mysqli_query($conn, $sql)) {
    header("Location: index.php");
    exit();
  } else {
    echo "Terjadi kesalahan: " . mysqli_error($conn);
  }
}

// data
if (isset($_POST["submit"])) {
  if ($_FILES["img"]["error"] === 4) {
    ubah();
  } else {
    imgubah();
  }
}
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>update item</title>
  <style type="text/css" media="all">
   
     *{
      padding:0;
      margin:0;
      font-family: sans-serif;
       -webkit-tap-highlight-color: transparent;
    }
    body{
      width:100%;
      height:100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      background-color: white;
    }
    .container{
      margin-top: 20px;
      box-shadow: 0 0 10px #00000078;
      width:300px;
      border-radius: 20px;
      padding: 10px;
      background-color: #fff;
    }
    .header{
      display: flex;
      justify-content: center;
      align-items: center;
    }
    .header h2{
      color: #ff8805;
    }
    .img{
      display: flex;
      justify-content:space-evenly;
      flex-direction: column;
      height: 200px;
    }
    .img img{
      align-self: center;
      width: 100px;
      height: 100px;
    }
    input,textarea{
      border: none;
      outline:none;
    }
    .data{
      display: flex;
      justify-content: center;
      flex-direction: column;
      align-items: center;
    }
    .data input, textarea{
      width: 90%;
      padding: 10px;
      margin-bottom: 10px;
      box-shadow: 0 0 5px #00000048;
      border-radius: 5px;      
    }
    textarea{
      resize: none;
    }
    button{
      border: 1px solid #ff8805;
      padding: 10px;
      background-color: #ff8805;
      border-radius: 5px;
      color: #fff;
      transition: 0.2s ease-in-out;
    }
    button:hover{
      background-color: white;
      border: 1px solid #ff8805;
      color: #000;
    }
  </style>
</head>

<body>
  

  <form class="container" action="" method="post" enctype="multipart/form-data">
    <input type="hidden" name="gambarlama" id="gambarlama" value="<?= $data[
      "img"
    ] ?>">
    <div class="header">
      <h2>Update Item</h2>
    </div>
    <div id="img" class="img">
      <img id="gambar" class="gambar" src="../../img/<?= $data["img"] ?>" />
      <input name="img" type="file" id="pilih" onchange="img()" accept="image/*">
    </div>
    <div class="data">
      <?php
/*var_dump(isset($_POST));
        var_dump($_POST)*/
?>
      <input type="text" name="judul" id="judul" placeholder="judul item / barang" value="<?= $data[
        "item"
      ] ?>">
      
      <input type="text" name="jumlah" id="jumlah" placeholder="jumlah item / barang" value="<?= $data[
        "jumlah"
      ] ?>">
      
      <input type="text" name="harga" id="harga" placeholder="harga" value="<?= $data[
        "harga"
      ] ?>">
      
      <input type="text" name="kode_barang" id="kode_barang" placeholder="masukkan kode barang" value="<?= $data[
        "kode_barang"
      ] ?>">
      
      
      <textarea name="deskripsi" id="" rows="8" cols="40" placeholder="deskripsi"><?= $data[
        "description"
      ] ?></textarea>
      
      <input type="date" name="date" id="date" value="<?= $data["date"] ?>">
      <button name="submit" type="submit">Tambah</button>
    </div>
  </form>

<script>
   function img(){
     let input = document.getElementById("pilih");
     let gambar = document.getElementById("gambar");
     
     if (input.files && input.files[0]) {

        var reader = new FileReader();
        
        reader.onload = function (e) {
            gambar.style.display = 'block';
            gambar.src = e.target.result;
        }
        
        reader.readAsDataURL(input.files[0]);
     }
   }
 </script>
 
</body>

</html>