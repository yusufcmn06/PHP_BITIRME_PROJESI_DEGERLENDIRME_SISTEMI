<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if(isset($_POST["notGoruntule"])){
    header("location: notGoruntule.php");
    exit();
  }
  if(isset($_POST["bitirmeProjeleri"])){
    header("location: bitirmeProjeleri.php");
    exit();
  }
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Öğrenci</title>
  </head>
  <style>
    body {
      margin: 0;
      font-family: Arial, sans-serif;
    }
    h1 {
      margin: 0;
      padding: 1.9%;
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
        margin-top: 41.5%;
    }
  </style>
  <body>
    <header>
      <h1>Öğrenci</h1>
    </header>
    <main>
      <form action="ogrenci.php" method="post">
        <button type="submit" name="notGoruntule" id="notGoruntule">
          Not Görüntüle
        </button>
        <button type="submit" id="bitirmeProjeleri" name="bitirmeProjeleri">
          Bitirme Projeleri
        </button>
      </form>
    </main>
    <footer class="footer">
       <p>&copy; 2024 <a href="http://www.yusufcimen.com.tr/" target="_blank" style="color: white;"><b>Yusuf Çimen</b></a> Tüm Hakları Saklıdır.</p>
    </footer>
  </body>
</html>
