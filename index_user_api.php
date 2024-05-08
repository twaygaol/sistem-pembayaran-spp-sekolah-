<?php
include_once("koneksi.php");

if (isset($_GET['nisn'])) {
    $nisn = $_GET['nisn'];

    $query = "SELECT id_siswa, id_angkatan as angkatan, nama_jurusan as jurusan, nama_kelas as kelas, alamat, nama, j.id_jurusan, k.id_kelas
        FROM siswa 
        JOIN jurusan j on siswa.id_jurusan = j.id_jurusan 
        JOIN kelas k on siswa.id_kelas = k.id_kelas 
        WHERE nisn = '$nisn'";
    $result = mysqli_query($conn, $query);
    $siswa = mysqli_fetch_assoc($result);

    echo json_encode($siswa);
    return;
}

if (isset($_GET['id_siswa'])) {
    $idSiswa = $_GET['id_siswa'];
    $idKelas = $_GET['id_kelas'];

    $query = " SELECT idspp as id, bulan, jumlah FROM pembayaran WHERE id_siswa = '$idSiswa' AND ket = 'BELUM DIBAYAR'";
    $result = mysqli_query($conn, $query);

    $pembayaran = [];
    for ($i = 0; $i < mysqli_num_rows($result); $i++) {
        $pembayaran[$i] = mysqli_fetch_assoc($result);
    }

    echo json_encode($pembayaran);
    return;
}