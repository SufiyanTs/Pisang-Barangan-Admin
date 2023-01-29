<?php
include("./config.php");

// cek apa tombol daftar udah di klik blom
if (isset($_POST['tambah'])) {
    // ambil data dari form
    $nama = $_POST['nama'];
    $Pmasuk = $_POST['Pmasuk'];
    $jenis_barang = $_POST['jenis_barang'];
    $harga = $_POST['harga'];
    $tgl_masuk = $_POST['tgl_masuk'];
    // query
    $sql = "INSERT INTO barang(nama, Pmasuk, jenis_barang, harga, tgl_masuk)
    VALUES('$nama', '$Pmasuk', '$jenis_barang', '$harga', '$tgl_masuk')";
    $query = mysqli_query($db, $sql);

    // cek apa query berhasil disimpan?
    if ($query)
        header('Location: ./index.php?status=sukses');
    else
        header('Location: ./index.php?status=gagal');
} else
    die("Akses dilarang...");
