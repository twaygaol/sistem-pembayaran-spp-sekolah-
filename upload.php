<?php

// ambil data file
$gambar = $_FILES['gambar']['name'];
$namaSementara = $_FILES['gambar']['tmp_name'];

// tentukan lokasi file akan dipindahkan
$dirUpload = "gambar/";

// pindahkan file
$terupload = move_uploaded_file($namaSementara, $dirUpload.$gambar);

if ($terupload) {
    echo "Upload berhasil!<br/>";
    echo "Link: <a href='".$dirUpload.$gambar."'>".$gambar."</a>";
} else {
    echo "Upload Gagal!";
}

?>