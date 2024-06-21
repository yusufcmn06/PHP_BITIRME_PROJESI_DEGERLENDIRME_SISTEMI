<?php
@session_start();
if (!isset($_SESSION["kontrol"])) {
  header("Location: akademisyenGiris.php");
  exit();
}
// ÖĞRENCİ BİLGİLERİNİN DEĞİŞKENLERE AKTARILDIĞI KISIM
@$egitimOgretimDonemi = $_POST["egitimOgretimDonemi"];
@$ogrenciNo = $_POST["ogrenciNo"];
@$ogrenciAdSoyad = $_POST["ogrenciAdSoyad"];
@$projeId = $_POST["projeId"];
@$projeAd = $_POST["projeAdı"];
@$juri1 = $_POST["juri1"];
@$juri2 = $_POST["juri2"];
@$juri3 = $_POST["juri3"];
@$juri4 = $_POST["juri4"];

include "veritabani.php";
if ($baglanti->connect_error) {
    die("Veritabanına bağlanırken bir hata oluştu: " . $baglanti->connect_error);
}

function temizle($veri)
{
    $veri = trim($veri);
    $veri = stripslashes($veri);
    $veri = htmlspecialchars($veri);
    return $veri;
}

// ÖĞRENCİNİN KAYDEDİLDİĞİ KISIM
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["kaydet"])) {
        $yapi = $baglanti->prepare("INSERT INTO ogrenciler (Egitim_Ogretim_Donemi, Ogrenci_No, Ogrenci_Ad_Soyad, Proje_Id, Proje_Ad, Puan, Juri_1, Juri_2, Juri_3, Juri_4) VALUES (?,?,?,?,?,0,?,?,?,?)");
        $yapi->bind_param("sisisssss", temizle($egitimOgretimDonemi), temizle($ogrenciNo), temizle( $ogrenciAdSoyad), temizle($projeId), temizle($projeAd), temizle($juri1), temizle($juri2), 
        temizle($juri3), temizle($juri4));
        if ($yapi->execute()) {
          sleep(1);
          echo "<script>alert('Öğrenci Kaydedildi!');</script>";
          header("location: ogrenciKaydet.php");
          exit();
      } else {
          echo "Hata: Öğrenci kaydedilirken bir sorun oluştu.";
      }

    }
    // GİRİLEN TÜM BİLGİLERİN TEMİZLENDİĞİ KISIM (TUMUNU TEMİZLE BUTTONU)
    if (isset($_POST["tumunuTemizle"])) {
        $egitimOgretimDonemi = "";
        $ogrenciNo = "";
        $ogrenciAdSoyad = "";
        $projeId = "";
        $projeAd = "";
        $juri1 = "";
        $juri2 = "";
        $juri3 = "";
        $juri4 = "";
    }
}
$baglanti->close();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Öğrenci Kayıt</title>
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
        margin-top: 4%;
      }

      table {
        width: 80%;
        margin: 0 auto;
        border-collapse: collapse;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
      }

      th,
      td {
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
      label {
        display: block;
        margin-bottom: 15px;
        color: firebrick;
        font-weight: bold;
        font-size: 1rem;
        color: black;
      }
      input[type="text"],
      textarea {
        width: 100%;
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 5px;
        box-sizing: border-box;
        font-size: 1rem;
      }
      button {
        background-color: firebrick;
        color: white;
        padding: 10px 20px;
        border-radius: 10px;
        border: none;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s, box-shadow 0.3s;
        cursor: pointer;
      }
      button:hover {
        background-color: #cc0000;
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        transform: translateY(-3px);
      }
      .button-container {
        text-align: right;
        padding-top: 10px;
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
      <h1>Öğrenci Kayıt</h1>
    </header>
    <main>
      <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <table>
          <tbody>
            <tr>
              <td>
                <label for="egitimOgretimDonemi">Eğitim Öğretim Dönemi:</label>
              </td>
              <td>
                <input
                  type="text"
                  name="egitimOgretimDonemi"
                  id="egitimOgretimDonemi"
                  required
                  autofocus
                  placeholder="Eğitim öğretim yılını giriniz."
                />
              </td>
            </tr>
            <tr>
              <td><label for="ogrenciNo">Öğrenci No:</label></td>
              <td><input type="text" name="ogrenciNo" id="ogrenciNo" required 
              placeholder="Öğrenci numarasını giriniz."/></td>
            </tr>
            <tr>
              <td>
                <label for="ogrenciAdSoyad">Öğrenci Adı Soyadı:</label>
              </td>
              <td>
                <input type="text" name="ogrenciAdSoyad" id="ogrenciAdSoyad" required
                placeholder="Öğrenci adı ve soyadını giriniz."/>
              </td>
            </tr>
            <tr>
              <td><label for="projeId">Proje Id:</label></td>
              <td><input type="text" name="projeId" id="projeId" 
              placeholder="Proje ID giriniz."/></td>
            </tr>
            <tr>
              <td><label for="projeAdı">Proje Adı:</label></td>
              <td>
                <textarea
                  name="projeAdı"
                  id="projeAdı"
                  cols="20"
                  rows="4"
                  placeholder="Proje adını giriniz."
                ></textarea>
              </td>
            </tr>
            <tr>
              <td><label for="juri1">Juri 1</label></td>
              <td><input type="text" name="juri1" id="juri1" required 
              placeholder="1. Juri'nin unvan ve adını giriniz."/></td>
            </tr>
            <tr>
              <td><label for="juri2">Juri 2</label></td>
              <td><input type="text" name="juri2" id="juri2" required
              placeholder="2. Juri'nin unvan ve adını giriniz."/></td>
            </tr>
            <tr>
              <td><label for="juri3">Juri 3</label></td>
              <td><input type="text" name="juri3" id="juri3" required
              placeholder="3. Juri'nin unvan ve adını giriniz."/></td>
            </tr>
            <tr>
              <td><label for="juri4">Juri 4</label></td>
              <td><input type="text" name="juri4" id="juri4" required
              placeholder="4. Juri'nin unvan ve adını giriniz."/></td>
            </tr>
            <tr>
              <td class="button-container" colspan="2">
                <button type="reset" name="tumunuTemizle">
                  Tümünü Temizle
                </button>
                <button type="submit" name="kaydet">Kaydet</button>
              </td>
            </tr>
          </tbody>
        </table>
      </form>
    </main>
    <footer class="footer">
       <p>&copy; 2024 <a href="http://www.yusufcimen.com.tr/" target="_blank" style="color: white;"><b>Yusuf Çimen</b></a> Tüm Hakları Saklıdır.</p>
    </footer>
  </body>
</html>