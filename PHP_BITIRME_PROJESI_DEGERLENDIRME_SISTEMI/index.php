<?php
// KULLANICI ÖĞRENCİ VEYA AKADEMİSYENSE YÖNLENDİRİLİYOR
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if(isset($_POST["akademisyen"])){
    header("location: akademisyenGiris.php");
    exit();
  }
  if(isset($_POST["ogrenci"])){
    header("location: ogrenci.php");
    exit();
  }
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Akademisyen Giriş Formu</title>
  </head>
  <style>
    body {
      margin: 0;
      font-family: Arial, sans-serif;
    }
    h1 {
      margin: 0;
      padding: 0.7%;
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
    .footer {
      background-color: firebrick;
      padding: 1px;
      color: white;
      text-align: center;
      font-weight: bold;
      margin-top: 40.5%;
    }
    .footer a {
      color: white;
    }
  </style>
  <body>
    <header>
      <h1>Bilgisayar Programcılığı</h1>
      <h1>Bitirme Projeleri Yönetim Sistemi</h1>
    </header>
    <main>
      <form action="index.php" method="post">
        <button type="submit" name="akademisyen" id="akademisyen">
          Akademisyen
        </button>
        <button type="submit" id="ogrenci" name="ogrenci">Öğrenci</button>
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
