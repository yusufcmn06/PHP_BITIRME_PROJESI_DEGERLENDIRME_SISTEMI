<?php
@session_start();
if (!isset($_SESSION["kontrol"])) {
  header("Location: akademisyenGiris.php");
  exit();
}

function temizle($veri){
  $veri = trim($veri);
  $veri = stripslashes($veri);
  $veri = htmlspecialchars($veri);
  return $veri;
}
$kullaniciAdi = $_SESSION["KulaniciAdi"];
$ogrenciNumarasi;
$ogrenciAdiSoyadi;
$projeId;
$projeAd;
$puan;
$juri_1;
$juri_2;
$juri_3;
$juri_4;

if($_SERVER["REQUEST_METHOD"] == "POST") {
  // AKADEMİSYENİN NOT VEREBİLECEĞİ ÖĞRENCİYE AİT ÖĞRENCİ NUMARASINI GİREREK
  // BİLGİLERİN GELMESİNİ SAĞLAYAN KOD PARÇASI
  if(isset($_POST["ara"])) {
    $vtOgrenciNo = [];
    include "veritabani.php";
    if($baglanti -> connect_error){
      die("Veritabanına bağlanırken bir hata oluştu: " + $baglanti -> connect_error);
    }
    $notVerecekJuri = $baglanti -> prepare("SELECT * FROM ogrenciler WHERE ? IN(Juri_1, Juri_2, Juri_3, Juri_4)");
    $notVerecekJuri -> bind_param("s",$kullaniciAdi);
    $notVerecekJuri -> execute();
    $deger = $notVerecekJuri -> get_result();
    while($vtOgrenciNumarasi = $deger -> fetch_assoc()){
      $vtOgrenciNo [] = $vtOgrenciNumarasi["Ogrenci_No"];
    }
    $devam = 1;
    foreach($vtOgrenciNo as $numara){
      if($_POST["ogrenciNo"] == $numara){
        include "listele.php";
        $devam = 0;
      }
    }
    if($devam != 0){
      echo "<script>alert('Bu öğrenciye not verme yetkiniz yok.!');</script>";
    }
  }
  // AKADEMİSYENİN NOT HESAPLATTIĞI KISIM
  if(isset($_POST["hesapla"])) {
    $degerlendirme1 = $_POST["degerlendirme1"];
    $degerlendirme2 = $_POST["degerlendirme2"];
    $degerlendirme3 = $_POST["degerlendirme3"];
    $araDegerlendirme = ($degerlendirme1 + $degerlendirme2 + $degerlendirme3) / 3;
    include "listele.php";
  }
  // AKADEMİSYENİN VERDİĞİ NOTLARIN TEMİZLENME KISIMI (TUMUNU SİL BUTTONU)
  if(isset($_POST["tumunuSil"])) {
    $degerlendirme1 = "";
    $degerlendirme2 = "";
    $degerlendirme3 = "";
    include "listele.php";
  }
 // AKADEMİSYENİN VERDİĞİ NOTLARIN KAYDEDİLDİĞİ KISIMI (KAYDET BUTTONU)
  if(isset($_POST["kaydet"])){
    $puan;
    $yaniPuan;
    include "veritabani.php";
    if($baglanti -> connect_error){
      die("Veritabanına bağlanırken bir hata oluştu: " + $baglanti -> connect_error);
    }

    $vtPuan = $baglanti -> prepare("SELECT Puan FROM ogrenciler WHERE Ogrenci_No = ?");
    $vtPuan -> bind_param("s",$_POST["ogrenciNo"]);
    $vtPuan -> execute();
    $sonuc = $vtPuan -> get_result();
    while($bilgi = $sonuc -> fetch_assoc()){
      $puan = $bilgi["Puan"];
    }
    // KAYDEDİLCEK OLAN PUANIN KAÇTA KAÇININ VERİLECEĞİNİN HESAPLANDIĞI KISIM
    $yeniPuan = $puan + ($_POST["araDegerlendirme"] / 4);

    $kaydedilcekPuan = $baglanti->prepare("UPDATE ogrenciler SET Puan = ? WHERE Ogrenci_No = ?");
    $kaydedilcekPuan -> bind_param("is",$yeniPuan,$_POST["ogrenciNo"]);
    if($kaydedilcekPuan -> execute() && $_POST["araDegerlendirme"] <= 100 && $_POST["araDegerlendirme"] != 0){
      echo "<script>alert('Başarıyla öğrenciye not verildi.!');</script>";
    }
    else{
      echo "<script>alert('Öğrenciye not verilirken bir hata ie karşılaşıldı.!');</script>";
      include "listele.php";
    }
    $baglanti ->  close();
  }
}
?>

<!DOCTYPE html>
<html lang="tr">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Proje Değerlendirme</title>
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
        margin: 20px auto;
        width: 90%;
        max-width: 800px;
      }

      table {
        width: 100%;
        border-collapse: collapse;
        background-color: white;
        border-radius: 10px;
        overflow: hidden;
      }

      td,
      th {
        padding: 6px;
        text-align: left;
      }

      label {
        font-weight: bold;
      }

      input[type="text"] {
        width: calc(100% - 10px);
        padding: 8px;
        margin: 5px;
        border: 2px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
        font-size: 16px;
      }

      button {
        width: 100%;
        padding: 12px;
        background-color: #d32f2f;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        box-sizing: border-box;
        font-size: 16px;
        margin-top: 10px;
        transition: background-color 0.3s ease;
      }

      button:hover {
        background-color: #b71c1c;
      }
      .footer {
        background-color: firebrick;
        padding: 1px;
        color: white;
        text-align: center;
        font-weight: bold;
        margin-top: 3.5%;
      }
    </style>
  </head>
  <body>
    <header>
      <h1>Proje Değerlendirme</h1>
    </header>
    <main>
      <form action="notKaydet.php" method="post">
        <table>
          <tbody>
            <tr>
              <td><label for="ogrenciAdiSoyadi">Öğrenci Adı Soyadı:</label></td>
              <td><input type="text" id="ogrenciAdiSoyadi" value="<?php echo @$ogrenciAdiSoyadi ?>" readonly/></td>
              <td><label for="bitirmeProjesiId">Bitirme Projesi Id:</label></td>
              <td><input type="text" id="bitirmeProjesiId" value="<?php echo @$projeId ?>" readonly/></td>
            </tr>
            <tr>
              <td><label for="ogrenciNo">Öğrenci No:</label></td>
              <td><input type="text" id="ogrenciNo" name="ogrenciNo" required value="<?php echo @$ogrenciNumarasi; ?>" autofocus placeholder="Öğrenci numarasını giriniz."/></td>
              <td><label for="projeAd">Proje Adı:</label></td>
              <td rowspan="6">
                <textarea
                  name="projeAd"
                  id="projeAd"
                  cols="29"
                  rows="20"
                  readonly
                ><?php echo @$projeAd; ?></textarea>
              </td>
            </tr>
            <tr>
            </tr>
            <tr>
              <td></td>
              <td><button style="margin: 0px;" type="submit" name="ara" id="ara">Öğrenci Ara</button></td>
            </tr>
            <tr>
              <td><label for="juriUyesi1">1.Juri Üyesi:</label></td>
              <td><input type="text" id="juriUyesi1" value="<?php echo @$juri_1; ?>"  readonly/></td>
            </tr>
            <tr>
              <td><label for="juriUyesi2">2.Juri Üyesi:</label></td>
              <td><input type="text" id="juriUyesi2" value="<?php echo @$juri_2; ?>"  readonly/></td>
            </tr>
            <tr>
              <td><label for="juriUyesi3">3.Juri Üyesi:</label></td>
              <td><input type="text" id="juriUyesi3" value="<?php echo @$juri_3; ?>"  readonly/></td>
            </tr>
            <tr>
              <td><label for="juriUyesi4">4.Juri Üyesi:</label></td>
              <td><input type="text" id="juriUyesi4" value="<?php echo @$juri_4; ?>"  readonly/></td>
              <td colspan="2">
                <label for="puan">Puan: </label>
                <input type="text" name="puan" id="puan" value="<?php echo @$puan; ?>"  readonly>
              </td>
              <table>
                <tbody>
                  <tr>
                    <td colspan="4">
                      <label
                        style="color: #d32f2f; font-size: 25px"
                        for="degerlendirme"
                        >Değerlendirme:</label
                      ><br />
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <label for="degerlendirme1"
                        >1- Genel görünüm, tavır ve sunuş:
                      </label>
                    </td>
                    <td>
                      <input
                        type="text"
                        name="degerlendirme1"
                        id="degerlendirme1"
                        value="<?php echo @$degerlendirme1; ?>"
                      />
                    </td>
                    <td><label for="juriUyesi">Juri Üyesi: </label></td>
                    <td>
                      <input type="text" name="juriUyesi" id="juriUyesi" value="<?php echo $_SESSION["KulaniciAdi"];?>" readonly/>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <label for="degerlendirme2"
                        >2- Konuya yaklaşım ve yaptığı çalışmalar:</label
                      >
                    </td>
                    <td>
                      <input
                        type="text"
                        name="degerlendirme2"
                        id="degerlendirme2"
                        value="<?php echo @$degerlendirme2; ?>"
                      />
                    </td>
                    <td colspan="4"><button type="hesapla" id="hesapla" name="hesapla">Hesapla</button></td>
                  </tr>
                  <tr>
                    <td>
                      <label for="degerlendirme3"
                        >3- Gelecek çalışma planı ve hazırlık düzeyi:</label
                      >
                    </td>
                    <td>
                      <input
                        type="text"
                        name="degerlendirme3"
                        id="degerlendirme3"
                        value="<?php echo @$degerlendirme3; ?>"
                      />
                    </td>
                    <td colspan="4">
                      <button type="submit" name="kaydet" id="kaydet">
                        Kaydet
                      </button>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <label for="araDegerlendirme"
                        >Ara Değerlendirme Puanı(1+2+3)/3:</label
                      >
                    </td>
                    <td>
                      <input
                        type="text"
                        name="araDegerlendirme"
                        id="araDegerlendirme"
                        value="<?php echo (int)@$araDegerlendirme; ?>"
                        readonly
                      />
                    </td>
                    <td colspan="4">
                      <button type="submit" name="tumunuSil" id="tumunuSil">
                        Tümünü Sil
                      </button>
                    </td>
                  </tr>
                </tbody>
              </table>
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
