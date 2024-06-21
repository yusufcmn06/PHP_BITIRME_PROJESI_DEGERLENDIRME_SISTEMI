<?php
// BU SAYFA DA AKADEMİSYEN YÖNLENDİRİLİYOR NOT KAYDET VEYA ÖĞRENCİ KAYDET GİBİ
@session_start();
if (!isset($_SESSION["kontrol"])) {
  header("Location: akademisyenGiris.php");
  exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if(isset($_POST["notKaydet"])){
    header("location: notKaydet.php");
    exit();
  }
  if(isset($_POST["ogrenciKaydet"])){
    header("location: ogrenciKaydet.php");
    exit();
  }
  if(isset($_POST["cikis"])){
    header("Location: cikis.php");
    exit();
  }
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Akademisyen</title>
    <style>
      body {
        margin: 0;
        padding: 0;
        font-family: Arial, sans-serif;
      }
      h1 {
        margin: 0;
        padding: 2%;
        background-color: firebrick;
        color: white;
        text-align: center;
        font-size: 2rem;
      }
      main {
        position: absolute;
        top: 40%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 90%;
        max-width: 500px;
        box-sizing: border-box;
        padding: 40px;
        background-color: firebrick;
        border-radius: 20px;
      }

      label {
        display: block;
        margin-bottom: 15px;
        color: white;
        font-weight: bold;
        font-size: 20px;
        margin-right: 20px;
      }

      select,
      input[type="password"] {
        width: 100%;
        padding: 10px;
        margin-bottom: 20px;
        border: 2px solid #fff;
        border-radius: 5px;
        background-color: rgba(255, 255, 255, 0.2);
        color: white;
        font-size: 16px;
      }
      select option {
        color: black;
      }

      button {
        width: 100%;
        padding: 12px 20px;
        background-color: #fff;
        color: black;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        box-sizing: border-box;
        font-size: 16px;
        margin: 10px;
      }

      button:hover {
        background-color: #eee;
      }
      @media screen and (max-width: 600px) {
        main {
          width: 90%;
        }
      }
      .cikis {
        background-color: firebrick;
        margin-right: 20px;
        margin-top: 20px;
        color: white;
        width: 10%;
        float: right;
      }
      .cikis:hover {
        color: red;
        border: solid 1px firebrick;
        background-color: #fff;
        transition: 0.6s;
      }
      .footer {
        background-color: firebrick;
        padding: 1px;
        color: white;
        text-align: center;
        font-weight: bold;
        margin-top: 35%;
      }
      @media screen and (min-width: 1900px) {
        .footer {
          margin-top: 41.5%;
        }
      }
    </style>
  </head>
  <body>
    <header>
      <h1>Akademisyen</h1>
      <form action="cikis.php" method="get">
        <button class="cikis" name="cikis">Çıkış Yap</button>
      </form>
    </header>
    <main>
      <form action="akademisyen.php" method="post">
        <button type="submit" name="notKaydet" id="notKaydet">
          Not Kaydet
        </button>
        <button type="submit" id="ogrenciKaydet" name="ogrenciKaydet">
          Öğrenci Kaydet
        </button>
      </form>
    </main>
    <footer class="footer">
      <p>
        &copy; 2024
        <a
          href="http://www.yusufcimen.com.tr/"
          target="_blank"
          style="color: white"
          ><b>Yusuf Çimen</b></a
        >
        Tüm Hakları Saklıdır.
      </p>
    </footer>
  </body>
</html>
