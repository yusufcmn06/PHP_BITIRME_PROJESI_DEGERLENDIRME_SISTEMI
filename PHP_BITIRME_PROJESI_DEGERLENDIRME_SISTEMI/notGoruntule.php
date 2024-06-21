<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Öğrenci</title>
  <style>
    body {
      margin: 0;
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
      margin-top: 20px;
      display: flex;
      justify-content: center;
    }
    table {
      width: 80%;
      border-collapse: collapse;
      border-radius: 10px;
      overflow: hidden;
      box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
    }
    th, td {
      padding: 12px 15px;
      text-align: left;
      border-bottom: 1px solid #ddd;
    }
    th {
      background-color: firebrick;
      color: white;
    }
    tr:nth-child(even) {
      background-color: #f2f2f2;
    }
    .footer {
        background-color: firebrick;
        padding: 1px;
        color: white;
        text-align: center;
        font-weight: bold;
        margin-top: 2%;
    }
  </style>
</head>
<body>
  <header>
    <h1>Not Görüntüleme</h1>
  </header>
  <main>
    <?php
    // ÖĞRENCİLERE AİT NOTLARIN TABLO ŞEKLİNDE GÖRÜNTÜLENMESİNİ SAĞLAYAN KOD PARÇASI
    include "veritabani.php";
    if($baglanti->connect_error){
      die("Bağlantı hatası: ". $baglanti->connect_error);
    }
    $komut = "SELECT Ogrenci_No, Ogrenci_Ad_Soyad, Puan FROM ogrenciler";
    $veriler = $baglanti->query($komut);
    echo "
    <table>
    <tr>
      <th>Öğrenci No</th>
      <th>Ad Soyad</th>
      <th>Puan</th>
    </tr>";
    while($satir = $veriler->fetch_assoc()){
      echo "
      <tr>
       <td>". $satir["Ogrenci_No"]."</td>".
       "<td>".$satir["Ogrenci_Ad_Soyad"]."</td>".
       "<td>".$satir["Puan"]."</td>".
      "</tr>";
    }
    echo "</table>";
    $baglanti->close();
    ?>
  </main>
  <footer class="footer">
      <p>&copy; 2024 <a href="http://www.yusufcimen.com.tr/" target="_blank" style="color: white;"><b>Yusuf Çimen</b></a> Tüm Hakları Saklıdır.</p>
  </footer>
</body>
</html>
