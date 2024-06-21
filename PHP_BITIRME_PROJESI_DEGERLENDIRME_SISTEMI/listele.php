<?php
// AKADEMİSYEN ÖĞRENCİYE NOT VERECEĞİ ZAMAN ÖĞRENCİ NUMARASI İLE ÖĞRENCİYE 
// AİT BİLGİLERİN SAYFAYA GELMESİNİ SAĞLIYOR
 $ogrenciNumarasi = $_POST["ogrenciNo"];
 include "veritabani.php";
 if($baglanti -> connect_error) {
   die("Veritabanına bağlanırken bir hata oluştu: " . $baglanti -> connect_error);
 }
 $bilgiler = $baglanti->prepare("SELECT Ogrenci_No, Ogrenci_Ad_Soyad, Proje_Id, Proje_Ad, Puan, Juri_1, Juri_2, Juri_3, Juri_4 FROM ogrenciler WHERE Ogrenci_No = ?");
 $bilgiler -> bind_param("s", $ogrenciNumarasi);
 $bilgiler -> execute();
 $sonuc = $bilgiler -> get_result();
 while($bilgi = $sonuc -> fetch_assoc()) {
   $ogrenciAdiSoyadi = $bilgi["Ogrenci_Ad_Soyad"];
   $ogrenciNumarasi = $bilgi["Ogrenci_No"];
   $projeId = $bilgi["Proje_Id"];
   $projeAd = $bilgi["Proje_Ad"];
   $puan = $bilgi["Puan"];
   $juri_1 = $bilgi["Juri_1"];
   $juri_2 = $bilgi["Juri_2"];
   $juri_3 = $bilgi["Juri_3"];
   $juri_4 = $bilgi["Juri_4"];
 }
 if(empty($ogrenciAdiSoyadi)) {
   echo "<script>alert('Öğrenci Bulunamadı!');</script>";
 }
 $baglanti -> close();
?>