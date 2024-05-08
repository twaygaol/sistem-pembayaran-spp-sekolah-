<?php
session_start();

if (isset($_SESSION['siswa'])) {

include 'koneksi.php';

if (isset($_POST['simpan'])) {
    $nama = htmlentities(strip_tags(ucwords($_POST['nama'])));
    $nisn_siswa = htmlentities(strip_tags(ucwords($_POST['nisn_siswa'])));
    $id_angkatan = htmlentities(strip_tags($_POST['id_angkatan']));
    $id_jurusan = htmlentities(strip_tags($_POST['id_jurusan']));
    $id_kelas = htmlentities(strip_tags($_POST['id_kelas']));
    $id_bulan = htmlentities(strip_tags(ucwords($_POST['bulan'])));
    $jumlah = htmlentities(strip_tags(ucwords($_POST['jumlah'])));
    $alamat = htmlentities(strip_tags(ucwords($_POST['alamat'])));

    $rand = rand();
    $ekstensi = array('png', 'jpg', 'jpeg', 'gif');
    $filename = $_FILES['gambar']['name'];
    $ext = pathinfo($filename, PATHINFO_EXTENSION);
    if (!in_array($ext, $ekstensi)) {
        header("location: index_user.php?alert=gagal_ekstensi");
        return;
    }

    $gambar = $rand . '_' . $filename;
    move_uploaded_file($_FILES['gambar']['tmp_name'], 'gambar/' . $rand . '_' . $filename);

    $nisn = date('YmdHis');
    $tahun = htmlentities(strip_tags($_POST['id_angkatan']));

    $tahunanggaran = substr($tahun, 0, 4);
    $nexttahunanggaran = $tahunanggaran + 1;

    $query = "SELECT bulan FROM pembayaran WHERE idspp = $id_bulan";
    $exec = mysqli_query($conn, $query);
    $q_bulan = mysqli_fetch_assoc($exec)['bulan'];
    $bulan = explode(" ", $q_bulan)[0];

    $query = "INSERT INTO invoice (nisn, nisn_siswa, nama, id_angkatan, id_jurusan, id_kelas, id_bulan, jumlah, alamat,gambar) 
        values('$nisn','$nama','$nisn_siswa','$id_angkatan','$id_jurusan','$id_kelas','$bulan','$jumlah','$alamat','$gambar')";
    $exec = mysqli_query($conn, $query);

    $tgl = date('Y-m-d');
    $query = "UPDATE pembayaran SET nobayar = '', tglbayar = '$tgl'
              WHERE idspp = $id_bulan";
    $exec = mysqli_query($conn, $query);

    echo "<script>alert('data siswa berhasil disimpan'); document.location = 'index_user.php'; </script>";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Pembayaran SPP MA DARUL AZHAR</title>

    <link href="img/logo.jpeg" rel="shortcut icon">

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
          rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

</head>

<body id="page-top">

<!-- Page Wrapper -->
<div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-success sidebar sidebar-dark accordion" id="accordionSidebar">

        <!-- Sidebar - Brand -->
        <a class="sidebar-brand d-flex align-items-center justify-content-center">

            <img class="img-profile" height="120" width="150" src="img/logosekolah.png">
        </a>

        <!-- Divider -->
        <hr class="sidebar-divider my-0">

        <!-- Nav Item - Dashboard -->

        <li class="nav-item active">
            <a class="nav-link" href="index_user.php">
                <i class="fas fa-fw fa-folder"></i>
                <span>Data Pembayaran SPP</span></a>
        </li>


        <!-- Divider -->
        <hr class="sidebar-divider d-none d-md-block">

        <!-- Sidebar Toggler (Sidebar) -->
        <div class="text-center d-none d-md-inline">
            <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>

    </ul>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">

            <!-- Topbar -->
            <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                <!-- Sidebar Toggle (Topbar) -->
                <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                    <i class="fa fa-bars"></i>
                </button>

                <!-- Topbar Search -->

                <div class="input-group">
                    <h1></h1>
                </div>

                <!-- Topbar Navbar -->
                <ul class="navbar-nav ml-auto">


                    <div class="topbar-divider d-none d-sm-block"></div>

                    <!-- Nav Item - User Information -->
                    <li class="nav-item dropdown no-arrow">
                        <a class="nav-link dropdown-toggle" href="index.php" id="userDropdown" role="button"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="mr-2 d-none d-lg-inline text-gray-600 small"
                                  style="font-size:15px;"><strong><?= $_SESSION['nama'] ?></strong></span>
                            X
                        </a>
                        <!-- Dropdown - User Information -->
                        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                             aria-labelledby="userDropdown">


                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="index.php" data-toggle="modal" data-target="#logoutModal">
                                <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                Logout
                            </a>
                        </div>
                    </li>

                </ul>

            </nav>
            <!-- End of Topbar -->

            <!-- Begin Page Content -->
            <div class="container-fluid">


                <!-- Page Heading -->
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="h3 mb-0 text-gray-800">Data Pembayaran SPP</h1>
                </div>


                <?php

                $tampilsiswa = mysqli_query($conn, "SELECT siswa.*, angkatan.*, jurusan.*, kelas.* FROM siswa, angkatan, jurusan, kelas WHERE siswa.id_angkatan = angkatan.nama_angkatan AND siswa.id_jurusan = jurusan.id_jurusan AND siswa.id_kelas = kelas.id_kelas AND id_siswa = '$_SESSION[siswa]'");

                $siswa = mysqli_fetch_assoc($tampilsiswa);
                $id_siswa = $_SESSION['siswa'];

                ?>


                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h5 class="m-0 font-weight-bold text-primary">Biodata Siswa</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <tr>
                                    <td>NISN</td>
                                    <td><?= $siswa['nisn'] ?></td>
                                </tr>
                                <tr>
                                    <td>Nama</td>
                                    <td><?= $siswa['nama'] ?></td>
                                </tr>
                                <tr>
                                    <td>Kelas</td>
                                    <td><?= $siswa['nama_kelas'] ?></td>
                                </tr>
                                <tr>
                                    <td>Angkatan</td>
                                    <td><?= $siswa['nama_angkatan'] ?></td>
                                </tr>

                            </table>
                        </div>
                    </div>
                </div>

                <!-- NO tujuan transfer -->
                <div class="card" style="width: 18rem;">
                    <img src="img/bankaceh.jpeg" class="card-img-top" alt="...">
                    <div class="card-body">
                        <table width="135%">
                            <tr>
                                <td>Metode</td>
                                <td>Transfer Bank</td>
                            </tr>
                            <tr>
                                <td>Bank</td>
                                <td>BANK ACEH</td>
                            </tr>
                            <tr>
                                <td>No Rek</td>
                                <td>07002414141414</td>
                            </tr>
                            <tr>
                                <td>Atas Nama</td>
                                <td>SRIWAHYUNI</td>
                            </tr>


                        </table>

                    </div>
                </div>
                <br>

                <!-- Button trigger modal -->
                <button id="buttonModal" style="border:1px solid blue; background-color:green; width:100%;"
                        type="button"
                        class="btn btn-tomato" data-toggle="modal" data-target="#exampleModal">
                    <span style="color:white;">BAYAR</span>
                </button>

                <!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                     aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Konfirmasi Pembayaran</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <!-- Modal Tambah Data -->

                            <div class="modal-body">
                                <form action="index_user.php" enctype="multipart/form-data" method="POST">
                                    <input id="nisn_siswa" type="text" name="nisn_siswa" readonly
                                           value="<?= $_SESSION['nisn'] ?>"
                                           class="form-control mb-2">

                                    <input id="nama_siswa" type="text" name="nama" placeholder="Nama Siswa" readonly
                                           class="form-control mb-2">

                                    <input id="id_angkatan" type="text" name="id_angkatan" placeholder="Angkatan"
                                           readonly
                                           class="form-control mb-2">

                                    <select id="id_jurusan" name="id_jurusan" class="form-control mb-2" readonly>
                                        <option selected="">Jurusan</option>
                                    </select>

                                    <select id="id_kelas" name="id_kelas" class="form-control mb-2" readonly>
                                        <option selected="">Kelas</option>
                                    </select>

                                    <textarea id="alamat" class="form-control mb-2" name="alamat" readonly
                                              placeholder="Alamat Siswa"></textarea>

                                    <select id="bulan" name="bulan" class="form-control mb-2">
                                        <option selected="">Pilih Bulan</option>
                                    </select>

                                    <input id="jumlah" type="none" name="jumlah" placeholder="RP." readonly
                                           class="form-control mb-2">
                                    <br>

                                    <h6><b>Upload Bukti Pembayaran </b|></h6>
                                    <input type="file" required name="gambar" class="form-control mb-2">

                                    <div class="modal-footer">
                                        <!--                                        <input type="hidden" name="angkatan" value="-->
                                        <?php //= $angkatan['nama_angkatan']; ?><!--">-->
                                        <button type="Submit" name="simpan" class="btn btn-primary">Simpan</button>
                                    </div>
                                </form>
                            </div>
                            <?php


                            //                            if (isset($_POST['simpan'])) {
                            //                                $nama = htmlentities(strip_tags(ucwords($_POST['nama'])));
                            //                                $nisn_siswa = htmlentities(strip_tags(ucwords($_POST['nisn_siswa'])));
                            //                                $id_angkatan = htmlentities(strip_tags($_POST['id_angkatan']));
                            //                                $id_jurusan = htmlentities(strip_tags($_POST['id_jurusan']));
                            //                                $id_kelas = htmlentities(strip_tags($_POST['id_kelas']));
                            //                                $id_bulan = htmlentities(strip_tags(ucwords($_POST['bulan'])));
                            //                                $jumlah = htmlentities(strip_tags(ucwords($_POST['jumlah'])));
                            //                                $alamat = htmlentities(strip_tags(ucwords($_POST['alamat'])));
                            //                                $rand = rand();
                            //                                $ekstensi = array('png', 'jpg', 'jpeg', 'gif');
                            //                                $filename = $_FILES['gambar']['name'];
                            //                                $ukuran = $_FILES['gambar']['size'];
                            //                                $ext = pathinfo($filename, PATHINFO_EXTENSION);
                            //
                            //                                if (!in_array($ext, $ekstensi)) {
                            //                                    header("location:index_user.php?alert=gagal_ekstensi");
                            //                                } else {
                            //                                    if ($ukuran < 1044070) {
                            //                                        $gambar = $rand . '_' . $filename;
                            //                                        move_uploaded_file($_FILES['gambar']['tmp_name'], 'gambar/' . $rand . '_' . $filename);
                            //                                        mysqli_query($koneksi, "INSERT INTO invoice VALUES(NULL,'$nama','$nisn_siswa','$id_angkatan','$id_jurusan','$id_kelas','$id_bulan','$alamat','$gambar')");
                            //                                        header("location:index_user.php?alert=berhasil");
                            //                                    } else {
                            //                                        header("location:index_user.php?alert=gagak_ukuran");
                            //                                    }
                            //                                }
                            //                                $nisn = date('YmdHis');
                            //                                $tahun = htmlentities(strip_tags($_POST['id_angkatan']));
                            //
                            //                                $tahunanggaran = substr($tahun, 0, 4);
                            //                                $nexttahunanggaran = $tahunanggaran + 1;
                            //
                            //                                $query = "INSERT INTO invoice (nisn,nisn_siswa, nama, id_angkatan, id_jurusan, id_kelas,id_bulan,jumlah, alamat,gambar) values('$nisn','$nama','$nisn_siswa','$id_angkatan','$id_jurusan','$id_kelas','$id_bulan','$jumlah','$alamat','$gambar')";
                            //                                $exec = mysqli_query($conn, $query);
                            //
                            //
                            //                                $q2 = "insert into siswatemp (nisn, tahun) values ('$nisn','$tahun')";
                            //                                $qq = mysqli_query($conn, $q2);
                            //
                            //                                if ($exec) {
                            //
                            //                                    $bulanIndo = [
                            //                                        '1' => 'Januari',
                            //                                        '2' => 'Februari',
                            //                                        '3' => 'Maret',
                            //                                        '4' => 'April',
                            //                                        '5' => 'Mei',
                            //                                        '6' => 'Juni',
                            //                                        '7' => 'Juli',
                            //                                        '8' => 'Agustus',
                            //                                        '9' => 'September',
                            //                                        '10' => 'Oktober',
                            //                                        '11' => 'November',
                            //                                        '12' => 'Desember'
                            //                                    ];
                            //
                            //
                            //                                    $query = "SELECT siswa.*,angkatan.* FROM siswa,angkatan WHERE siswa.id_angkatan = angkatan.nama_angkatan ORDER BY  siswa.id_siswa DESC LIMIT 1";
                            //                                    $exec = mysqli_query($conn, $query);
                            //                                    $res = mysqli_fetch_assoc($exec);
                            //                                    $biaya = $res['biaya'];
                            //                                    $id_siswa = $res['id_siswa'];
                            //                                    $ket = $res['ket'];
                            //                                    $awaltempo = date('d-m-Y');
                            //                                    $id_kelas = $res['id_kelas'];
                            //
                            //                                    $getkelas = mysqli_query($conn, "select kelas from kelas where id_kelas=$id_kelas");
                            //                                    $hasil = mysqli_fetch_array($getkelas);
                            //
                            //                                    for ($i = 7; $i <= 12; $i++) {
                            //                                        // tanggal jatuh tempo setiap tanggal ?
                            //                                        $jatuhtempo = date("d-m-Y", strtotime("+$i month", strtotime($awaltempo)));
                            //
                            //                                        $bulan = "$bulanIndo[$i] $tahunanggaran";
                            //                                        // simpan data
                            //
                            //                                        $ket = 'BELUM DIBAYAR';
                            //
                            //                                        $add = mysqli_query($conn, "INSERT INTO pembayaran(id_siswa , jatuhtempo, bulan, jumlah, ket, tahun, kelas) VALUES ('$id_siswa','$tahunanggaran','$bulan','$biaya', '$ket','$tahunanggaran','$hasil[0]')");
                            //                                    }
                            //                                    for ($i = 1; $i <= 6; $i++) {
                            //                                        // tanggal jatuh tempo setiap tanggal ?
                            //                                        $jatuhtempo = date("d-m-Y", strtotime("+$i month", strtotime($awaltempo)));
                            //
                            //                                        $bulan = "$bulanIndo[$i] $nexttahunanggaran";
                            //                                        // simpan data
                            //
                            //                                        $ket = 'BELUM DIBAYAR';
                            //
                            //                                        $add = mysqli_query($conn, "INSERT INTO pembayaran(id_siswa , jatuhtempo, bulan, jumlah, ket, tahun, kelas) VALUES ('$id_siswa','$nexttahunanggaran','$bulan','$biaya', '$ket','$tahunanggaran','$hasil[0]')");
                            //                                    }
                            //
                            //                                    echo "<script>alert('data siswa berhasil disimpan')
                            //                          document.location = 'index_user.php';
                            //                          </script>";
                            //                                } else {
                            //                                    echo "<script>alert('data siswa gagal disimpan')
                            //                          document.location = 'index_user.php';
                            //                          </script>";
                            //                                }
                            //                            }
                            //                            ?>


                        </div>
                    </div>
                </div>
                <br>


                <?php
                //ambil hostory sekolah siswa dari kelas 10 sd 12
                $qdata = "select * from siswatemp where nisn='$siswa[nisn]'";
                $query = mysqli_query($conn, $qdata);
                $hasil = mysqli_fetch_array($query);
                $tahunanggaran = substr($hasil['tahun'], 0, 4); //2021
                $nexttahunanggaran = $tahunanggaran + 1;


                if ($hasil['kls10'] != NULL) {
                    $kelas = 10;
                    $namakelas = $hasil['kls10'];

                    $ceklunas = mysqli_query($conn, "select count(tglbayar) from pembayaran where tglbayar!=0 and kelas=10 and id_siswa=$id_siswa");
                    $lunas = mysqli_fetch_array($ceklunas);
                    $lebar = $lunas[0] / 12 * 100;
                    if ($lebar <= 45) $progress = "progress-bar bg-danger";
                    elseif ($lebar <= 65) $progress = "progress-bar bg-warning";
                    elseif ($lebar <= 75) $progress = "progress-bar bg-info";
                    elseif ($lebar <= 100) $progress = "progress-bar bg-success";
                    if ($lunas[0] == 12) $katakata = "SPP Lunas&nbsp;";
                    elseif ($lunas[0] < 12) $katakata = "SPP Dibayar $lunas[0] bulan&nbsp;";

                    ?>

                    <div class="card" style="margin-top:5px;">
                        <!-- Card Header - Accordion -->
                        <a href="#collapseCardExamplex" class="d-block card-header py-3" data-toggle="collapse"
                           role="button" aria-expanded="true" aria-controls="collapseCardExamplex">
                            <h6 class="m-0 font-weight-bold text-primary">Data Pembayaran SPP Kelas <?= $kelas; ?>
                                / <?= $namakelas ?> [Tahun <?= $tahunanggaran; ?>/<?= $nexttahunanggaran; ?>]</h6>
                            <div class="row no-gutters align-items-center">
                                <div class="col-auto">
                                    <div><?= $katakata ?></div>
                                </div>
                                <div class="col">
                                    <div class="progress progress-sm mr-2">
                                        <div class="<?= $progress ?>" role="progressbar" style="width: <?= $lebar ?>%"
                                             aria-valuenow="<?= $lunas[0] ?>" aria-valuemin="0"
                                             aria-valuemax="12"></div>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <!-- Card Content - Collapse -->
                        <div class="collapse show" id="collapseCardExamplex" style="">
                            <div class="card-body">
                                <?php include "tampildata_user.php"; ?>
                            </div>
                        </div>
                    </div>


                    <?php
                }
                if ($hasil['kls11'] != NULL) {
                    $kelas = 11;
                    $namakelas = $hasil['kls11'];
                    $tahunanggaran = $tahunanggaran + 1;
                    $nexttahunanggaran = $nexttahunanggaran + 1;

                    $ceklunas = mysqli_query($conn, "select count(tglbayar) from pembayaran where tglbayar!=0 and kelas=11 and id_siswa=$id_siswa");
                    $lunas = mysqli_fetch_array($ceklunas);
                    $lebar = $lunas[0] / 12 * 100;
                    if ($lebar <= 45) $progress = "progress-bar bg-danger";
                    elseif ($lebar <= 65) $progress = "progress-bar bg-warning";
                    elseif ($lebar <= 75) $progress = "progress-bar bg-info";
                    elseif ($lebar <= 100) $progress = "progress-bar bg-success";
                    if ($lunas[0] == 12) $katakata = "SPP Lunas&nbsp;";
                    elseif ($lunas[0] < 12) $katakata = "SPP Dibayar $lunas[0] bulan&nbsp;";

                    ?>
                    <div class="card">
                        <!-- Card Header - Accordion -->
                        <a href="#collapseCardExamplexx" class="d-block card-header py-3" data-toggle="collapse"
                           role="button" aria-expanded="true" aria-controls="collapseCardExamplexx">
                            <h6 class="m-0 font-weight-bold text-primary">Data Pembayaran SPP Kelas <?= $kelas; ?>
                                / <?= $namakelas ?> [Tahun <?= $tahunanggaran; ?>/<?= $nexttahunanggaran; ?>]</h6>
                            <div class="row no-gutters align-items-center">
                                <div class="col-auto">
                                    <div><?= $katakata ?></div>
                                </div>
                                <div class="col">
                                    <div class="progress progress-sm mr-2">
                                        <div class="<?= $progress ?>" role="progressbar" style="width: <?= $lebar ?>%"
                                             aria-valuenow="<?= $lunas[0] ?>" aria-valuemin="0"
                                             aria-valuemax="12"></div>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <!-- Card Content - Collapse -->
                        <div class="collapse show" id="collapseCardExamplexx" style="">
                            <div class="card-body">
                                <?php include "tampildata_user.php"; ?>
                            </div>
                        </div>
                    </div>


                    <?php
                }
                if ($hasil['kls12'] != NULL) {
                    $kelas = 12;
                    $namakelas = $hasil['kls12'];
                    $tahunanggaran = $tahunanggaran + 1;
                    $nexttahunanggaran = $nexttahunanggaran + 1;

                    $ceklunas = mysqli_query($conn, "select count(tglbayar) from pembayaran where tglbayar!=0 and kelas=12 and id_siswa=$id_siswa");
                    $lunas = mysqli_fetch_array($ceklunas);
                    $lebar = $lunas[0] / 12 * 100;
                    if ($lebar <= 45) $progress = "progress-bar bg-danger";
                    elseif ($lebar <= 65) $progress = "progress-bar bg-warning";
                    elseif ($lebar <= 75) $progress = "progress-bar bg-info";
                    elseif ($lebar <= 100) $progress = "progress-bar bg-success";
                    if ($lunas[0] == 12) $katakata = "SPP Lunas&nbsp;";
                    elseif ($lunas[0] < 12) $katakata = "SPP Dibayar $lunas[0] bulan&nbsp;";

                    ?>
                    <div class="card ">
                        <!-- Card Header - Accordion -->
                        <a href="#collapseCardExamplexxx" class="d-block card-header py-3" data-toggle="collapse"
                           role="button" aria-expanded="true" aria-controls="collapseCardExamplexxx">
                            <h6 class="m-0 font-weight-bold text-primary">Data Pembayaran SPP Kelas <?= $kelas; ?>
                                / <?= $namakelas ?> [Tahun <?= $tahunanggaran; ?>/<?= $nexttahunanggaran; ?>]
                            </h6>

                            <div class="row no-gutters align-items-center">
                                <div class="col-auto">
                                    <div><?= $katakata ?></div>
                                </div>
                                <div class="col">
                                    <div class="progress progress-sm mr-2">
                                        <div class="<?= $progress ?>" role="progressbar" style="width: <?= $lebar ?>%"
                                             aria-valuenow="<?= $lunas[0] ?>" aria-valuemin="0"
                                             aria-valuemax="12"></div>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <!-- Card Content - Collapse -->
                        <div class="collapse show" id="collapseCardExamplexxx" style="">
                            <div class="card-body">
                                <?php include "tampildata_user.php"; ?>
                            </div>
                        </div>
                    </div>

                    <?php
                }

                ?>




                <?php }
                ?>


                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h5 class="m-0 font-weight-bold text-primary">Cetak Data Laporan Sudah Lunas</h5>
                    </div>
                    <div class="card-body">
                        <form action="cetak_laporan2.php?id_siswa=<?= $id_siswa ?>" method="get" target="_blank">
                            <div class="form-group row">
                                <div class="col-sm-2 mb-3 mb-sm-0">
                                    <input type="date" name="awal" class="form-control mb-2">
                                    <input type="hidden" name="id_siswa" value="<?= $id_siswa; ?>"
                                           class="form-control mb-2">
                                </div>
                                <div class="col-sm-2 mb-3 mb-sm-0">
                                    <input type="date" name="akhir" class="form-control mb-2">
                                </div>
                                <div class="col-sm-2">
                                    <button type="submit" class="btn btn-primary" name="cetak">Cetak</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- End of Main Content -->
</div>
<!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Anda Yakin ingin Keluar?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">X</span>
                </button>
            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <a class="btn btn-primary" href="index.php">Logout</a>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap core JavaScript-->
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="js/sb-admin-2.min.js"></script>

<!-- Page level plugins -->
<script src="vendor/chart.js/Chart.min.js"></script>

<!-- Page level custom scripts -->
<script src="js/demo/chart-area-demo.js"></script>
<script src="js/demo/chart-pie-demo.js"></script>
<script src="vendor/datatables/jquery.dataTables.min.js"></script>
<script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/popper.min.js"></script>

<!-- Page level custom scripts -->
<script src="js/demo/datatables-demo.js"></script>

<script>
    const buttonModal = document.querySelector('#buttonModal');

    const nisnSiswa = document.querySelector('#nisn_siswa');
    const namaSiswa = document.querySelector('#nama_siswa');
    const idAngkatan = document.querySelector('#id_angkatan');
    const idKelas = document.querySelector('#id_kelas');
    const idJurusan = document.querySelector('#id_jurusan');
    const alamat = document.querySelector('#alamat');

    let dataPembayaran = {};
    const bulan = document.querySelector('#bulan');
    const jumlah = document.querySelector('#jumlah');

    async function getUserInfo(nisn) {
        const res = await fetch('index_user_api.php?nisn=' + nisn);
        return await res.json();
    }

    async function getUserPayment(idSiswa, idKelas) {
        const res = await fetch('index_user_api.php?id_siswa=' + idSiswa + '&id_kelas=' + idKelas);
        return await res.json();
    }

    function setContent(json) {
        console.log(json);
        namaSiswa.value = json['nama'];
        alamat.value = json['alamat'];
        idAngkatan.value = json['angkatan'];

        idKelas.innerHTML = `<option value='${json['id_kelas']}'>${json['kelas']}</option>`;
        idJurusan.innerHTML = `<option value='${json['id_jurusan']}'>${json['jurusan']}</option>`;
    }

    function setBulanPembayaran(data) {
        if (data) {
            dataPembayaran = data;
            bulan.disabled = false;
            data.forEach(v => {
                bulan.innerHTML += `<option value='${v['id']}'>${v['bulan']}</option>`
            });
        } else {
            bulan.disabled = true;
            bulan.innerHTML = `<option value=''>Pilih Bulan</option>`
            jumlah.value = '';
        }
    }

    bulan.addEventListener('change', e => {
        const id = e.target.value;
        const data = dataPembayaran.find(v => v['id'] === id);
        jumlah.value = data['jumlah'];
    });

    buttonModal.addEventListener('click', async _ => {
        const nisn = nisnSiswa.value;
        jumlah.value = '';
        const json = await getUserInfo(nisn);
        setContent(json);

        const payment = await getUserPayment(json['id_siswa'], json['id_kelas']);
        setBulanPembayaran(payment)
    })

</script>

</body>
</html>