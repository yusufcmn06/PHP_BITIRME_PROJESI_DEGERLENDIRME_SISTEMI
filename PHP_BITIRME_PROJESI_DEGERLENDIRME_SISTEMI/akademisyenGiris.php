<?php
session_start();
include "veritabani.php";
if ($baglanti->connect_error) {
    die("Veritabanına bağlanırken bir hata oluştu: " . $baglanti->connect_error);
}
// AKADEMİSYENLER LİSTELENİYOR
$akademisyenler = array();
$bilgiler = $baglanti->query("SELECT KULLANICI_ADI FROM akademisyenler");
while ($satir = $bilgiler->fetch_assoc()) {
    $akademisyenler[] = $satir["KULLANICI_ADI"];
}
function temizle($veri)
{
    $veri = trim($veri);
    $veri = stripslashes($veri);
    $veri = htmlspecialchars($veri);
    return $veri;
}
// AKADEMİSYENİN KULLANICI ADI VE ŞİFRE KONTROLÜ YAPILIYOR
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST["giris"])) {
        $girilenKullaniciAdi = temizle($_POST["akademisyen"]);
        $_SESSION["KulaniciAdi"] = $girilenKullaniciAdi;
        $girilenSifre = temizle($_POST["sifre"]);
        $kayitliSifre = $baglanti->prepare("SELECT SIFRE FROM akademisyenler WHERE KULLANICI_ADI = ?");
        $kayitliSifre->bind_param("s", $girilenKullaniciAdi); 
        $kayitliSifre->execute();
        $sonuc = $kayitliSifre->get_result();
        while($deger = $sonuc->fetch_assoc()){
          if($girilenSifre == $deger["SIFRE"]){
            echo "<script>alert('Giriş başarılı!');</script>";
            sleep(1);
            $_SESSION["kontrol"] = 1;
            header("location: akademisyen.php");
            exit();
          }
          else{
            echo "<script>alert('Girilen Şifre Yanlış.');</script>";
          }
        }
    }
}
$baglanti->close();
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Akademisyen Giriş Formu</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: #f3f3f3;
        }

        .container {
            max-width: 600px;
            margin: 10% auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: firebrick;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        select,
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
            color: #333;
            font-size: 16px;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: firebrick;
            border: none;
            border-radius: 5px;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background-color: #cc0000;
        }

        .footer {
            background-color: firebrick;
            padding: 1px;
            color: white;
            text-align: center;
            font-weight: bold;
            margin-top: 15.9%;
        }

        @media screen and (min-width: 1900px) {
            .footer {
                margin-top: 19.7%;
            }
        }
    </style>
</head>
<body>
 <div class="container">
    <h1>Akademisyen Giriş</h1>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div>
            <label for="akademisyen">Akademisyenler:</label>
            <select name="akademisyen" id="akademisyen">
                <?php
                foreach ($akademisyenler as $akademisyen) {
                    echo '<option value="' . htmlspecialchars($akademisyen) . '">' . htmlspecialchars($akademisyen) . '</option>';
                }
                ?>
            </select>
        </div>
        <div>
            <label for="sifre">Şifre:</label>
            <input type="password" id="sifre" name="sifre" autofocus/>
        </div>
        <div>
            <button type="submit" name="giris" id="giris">Giriş</button>
        </div>
    </form>
 </div>
 <footer class="footer">
    <p>&copy; 2024 <a href="http://www.yusufcimen.com.tr/" target="_blank" style="color: white;"><b>Yusuf Çimen</b></a> Tüm Hakları Saklıdır.</p>
 </footer>
</body>
</html>