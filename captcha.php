<?php
session_start();
function acakCaptcha() {
    $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";// menggenerate hruuf dan angka dan disimpan di variabel $alphabet.

    $pass = array(); 

    $panjangAlpha = strlen($alphabet) - 2; //Fungsi kemudian membuat angka acak antara 0 dan 5, yang sama dengan 2 kurang dari panjang semua huruf dalam alfabet (26).
    for ($i = 0; $i < 5; $i++) {
        $n = rand(0, $panjangAlpha);
        $pass[] = $alphabet[$n];
    }

    return implode($pass); 
}

$code = acakCaptcha();//method untuk mengacak/random kode capctha
$_SESSION["code"] = $code;// untuk mensesi kode

$wh = imagecreatetruecolor(173, 50); // imagecreate digunakan untuk membuat gambar dengan ukuran dan warna yang ditentukan. 

$bgc = imagecolorallocate($wh, 22, 86, 165);

$fc = imagecolorallocate($wh, 223, 230, 233);
imagefill($wh, 0, 0, $bgc);

imagestring($wh, 10, 50, 15,  $code, $fc);//imagestring() digunakan untuk membuat string dari apa yang seharusnya hanya karakter acak dari $code dan menetapkannya sebagai variabel barunya sendiri yang disebut $wh yang akan mewakili seluruh dimensi lebar dan tinggi untuk kotak captcha kita.

header('content-type: image/jpg'); 
imagejpeg($wh); //generate gambar
imagedestroy($wh);// menghancurkan gambar
?>