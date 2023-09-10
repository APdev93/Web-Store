<?php
session_start();
require "../../db.php";

//fungsi string acak
function acak($i)
{
  $rb = random_bytes($i);
  $rs = bin2hex($rb);
  return $rs;
}

if (isset($_POST["submit"])) {
  if (isset($_FILES["img"])) {
    //data
    $id = acak(16);
    $judul = $_POST["judul"];
    $jumlah = $_POST["jumlah"];
    $harga = $_POST["harga"];
    $desc = $_POST["deskripsi"];
    $date = $_POST["date"];
    $kode_barang = $_POST["kode_barang"];

    //file
    $tmp = $_FILES["img"]["tmp_name"];
    $file_name = acak(16) . ".png";

    //upload file
    $path = "../../img/";
    if (move_uploaded_file($tmp, $path . $file_name)) {
      $sql = "INSERT INTO `item` (`id`, `item`, `img`, `description`, `harga`, `jumlah`, `date`, `kode_barang`) VALUES ('$id', '$judul', '$file_name', '$desc', '$harga', '$jumlah', '$date', '$kode_barang')";

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
}
?>



<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>add item</title>
  <style type="text/css" media="all">
  .gambar{
    display: none;
  }
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
      color: #FFCF00;
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
      border: 1px solid #ff8906;
      padding: 10px;
      background-color: #f1932b;
      border-radius: 5px;
      color: #fff;
      transition: 0.2s ease-in-out;
    }
    button:hover{
      background-color: white;
      border: 1px solid #f1932b;
      color: #000;
    }
  </style>
</head>

<body>
  

  <form class="container" action="" method="post" enctype="multipart/form-data">
    <div class="header">
      <h2>add Item</h2>
    </div>
    <div id="img" class="img">
      <img id="gambar" class="gambar" src="" />
      <input type="file" name="img" id="pilih" onchange="img()" accept="image/*">
    </div>
    <div class="data">
      <input type="text" name="judul" id="judul" placeholder="judul item / barang">
      
      <input type="text" name="jumlah" id="jumlah" placeholder="jumlah item / barang">
      
      <input type="text" name="harga" id="harga" placeholder="harga">
      
      <input type="text" name="kode_barang" id="kode_barang" placeholder="masukkan kode barang">
      
      <textarea name="deskripsi" id="" rows="8" cols="40" placeholder="deskripsi"></textarea>
      
      <input type="date" name="date" id="date">
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