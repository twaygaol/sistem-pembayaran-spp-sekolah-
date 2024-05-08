<?php include 'header.php';
include 'koneksi.php';

if (isset($_GET['id_siswa'])) {
  $id_siswa = $_GET['id_siswa'];
  $exec     = mysqli_query($conn, "DELETE FROM siswa WHERE id_siswa='$id_siswa'");
  $exec1     = mysqli_query($conn, "DELETE FROM pembayaran WHERE id_siswa='$id_siswa'");
  if ($exec && $exec1) {
    echo "<script>alert('data siswa berhasil dihapus')
    document.location = 'editdatasiswa.php';
    </script>";
  } else {
    echo "<script>alert('data siswa gagal dihapus')
    document.location = 'editdatasiswa.php';
    </script>";
  }
}
$sqlx = "SELECT siswa.*, angkatan.*, jurusan.*, kelas.* FROM siswa, angkatan, jurusan, kelas WHERE siswa.id_angkatan = angkatan.nama_angkatan AND siswa.id_jurusan = jurusan.id_jurusan AND siswa.id_kelas = kelas.id_kelas";
$q = mysqli_query($conn, $sqlx);
while ($hasil = mysqli_fetch_array($q)) {
  //UPDATE `siswatemp` SET `kls11` = '1' WHERE `siswatemp`.`nisn` = '20220728092600';;

  $updates = "UPDATE `siswatemp` SET kls$hasil[kelas]='$hasil[nama_kelas]' WHERE `siswatemp`.`nisn` = '$hasil[nisn]'";
  //echo $updates;
  $qupd = mysqli_query($conn, $updates);
  //if($qupd) echo "berhasil";
  //else echo "gagal";
}

?>

<!-- button triger -->
<button  class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#exampleModal">Tambah Data</button>
<!-- button triger -->

<!-- DataTales Example -->
<div class="card shadow mb-4">
  <div class="card-header py-3">
    <h5 class="m-0 font-weight-bold text-primary">Data Siswa</h5>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
          <tr class="text-center">
            <th>NISN</th>
            <th>Nama</th>
            <th>Angkatan</th>
            <th>Jurusan</th>
            <th>Kelas</th>
            <th>Alamat</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $query = "SELECT siswa.*, angkatan.*, jurusan.*, kelas.* FROM siswa, angkatan, jurusan, kelas WHERE siswa.id_angkatan = angkatan.nama_angkatan AND siswa.id_jurusan = jurusan.id_jurusan AND siswa.id_kelas = kelas.id_kelas ORDER BY id_siswa";
          $exec = mysqli_query($conn, $query);
          while ($res = mysqli_fetch_assoc($exec)) :

          ?>
            <tr>
              <td><?= $res['nisn'] ?></td>
              <td><?= $res['nama'] ?></td>
              <td><?= $res['nama_angkatan'] ?></td>
              <td><?= $res['nama_jurusan'] ?></td>
              <td><?= $res['nama_kelas'] ?></td>
              <td><?= $res['alamat'] ?></td>
              <td>
                <a href="editdatasiswa.php?id_siswa=<?= $res['id_siswa'] ?>"  class="btn btn-sm btn-danger" onclick="return confirm ('Apakah yakin ingin menghapus data?')">Hapus</a>
                <a href="#" class="view_data btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#myModal" id="<?php echo $res['id_siswa']; ?>">Edit</a>
                <a href="pembayaran.php?nisn=<?= $res['nisn']?>&cari="  class="btn btn-sm btn-success" >Cari</a>
              </td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Modal Tambah Data -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Data Siswa</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">X</button>
      </div>
      <div class="modal-body">
        <form action="" method="POST">
          <input type="text" required name="nama" placeholder="Nama Siswa" class="form-control mb-2">
          <select class="form-control mb-2" name="id_angkatan">
            <option selected="">Pilih Angkatan</option>
            <?php
            $exec = mysqli_query($conn, "SELECT * FROM angkatan order by id_angkatan");
            while ($angkatan = mysqli_fetch_assoc($exec)) :
              echo "<option value = " . $angkatan['nama_angkatan'] . ">" . $angkatan['nama_angkatan'] . "</option>";
            endwhile;
            ?>
          </select>
          <select class="form-control mb-2" name="id_jurusan">
            <option selected="">Pilih Jurusan</option>
            <?php
            $exec = mysqli_query($conn, "SELECT * FROM jurusan order by id_jurusan");
            while ($angkatan = mysqli_fetch_assoc($exec)) :
              echo "<option value = " . $angkatan['id_jurusan'] . ">" . $angkatan['nama_jurusan'] . "</option>";
            endwhile;
            ?>
          </select>
          </select>
          <select class="form-control mb-2" name="id_kelas">
            <option selected="">Pilih Kelas</option>
            <?php
            $exec = mysqli_query($conn, "SELECT * FROM kelas order by id_kelas");
            while ($angkatan = mysqli_fetch_assoc($exec)) :
              echo "<option value = " . $angkatan['id_kelas'] . ">" . $angkatan['nama_kelas'] . "</option>";
            endwhile;
            ?>
          </select>
          <textarea class="form-control mb-2" required name="alamat" placeholder="Alamat Siswa"></textarea>

      </div>
      <div class="modal-footer">
        <input type="hidden" name="angkatane" value="<?= $angkatan['nama_angkatan']; ?>">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="Submit" name="simpan" class="btn btn-primary">Simpan</button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal Edit Data Siswa -->
<div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Data Siswa</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">X</button>
      </div>
      <div class="modal-body" id="datasiswa">
      </div>
    </div>
  </div>
</div>

<?php


if (isset($_POST['simpan'])) {
  $nama         = htmlentities(strip_tags(ucwords($_POST['nama'])));
  $id_angkatan  = htmlentities(strip_tags($_POST['id_angkatan']));
  $id_jurusan   = htmlentities(strip_tags($_POST['id_jurusan']));
  $id_kelas     = htmlentities(strip_tags($_POST['id_kelas']));
  $alamat       = htmlentities(strip_tags(ucwords($_POST['alamat'])));
  $nisn         = date('YmdHis');
  $tahun = htmlentities(strip_tags($_POST['id_angkatan']));

  $tahunanggaran = substr($tahun, 0, 4);
  $nexttahunanggaran = $tahunanggaran + 1;

  $query = "INSERT INTO siswa (nisn, nama, id_angkatan, id_jurusan, id_kelas, alamat) values('$nisn','$nama','$id_angkatan','$id_jurusan','$id_kelas','$alamat')";
  $exec = mysqli_query($conn, $query);

  $q2 = "insert into siswatemp (nisn, tahun) values ('$nisn','$tahun')";
  $qq = mysqli_query($conn, $q2);

  if ($exec) {

    $bulanIndo = [
      '1' => 'Januari',
      '2' => 'Februari',
      '3' => 'Maret',
      '4' => 'April',
      '5' => 'Mei',
      '6' => 'Juni',
      '7' => 'Juli',
      '8' => 'Agustus',
      '9' => 'September',
      '10' => 'Oktober',
      '11' => 'November',
      '12' => 'Desember'
    ];

    $query = "SELECT siswa.*,angkatan.* FROM siswa,angkatan WHERE siswa.id_angkatan = angkatan.nama_angkatan ORDER BY  siswa.id_siswa DESC LIMIT 1";
    $exec       = mysqli_query($conn, $query);
    $res        = mysqli_fetch_assoc($exec);
    $biaya      = $res['biaya'];
    $id_siswa   = $res['id_siswa'];
    $ket        = $res['ket'];
    $awaltempo  = date('d-m-Y');
    $id_kelas = $res['id_kelas'];

    $getkelas=mysqli_query($conn, "select kelas from kelas where id_kelas=$id_kelas");
    $hasil=mysqli_fetch_array($getkelas);

    for ($i = 7; $i <= 12; $i++) {
      // tanggal jatuh tempo setiap tanggal ?
      $jatuhtempo = date("d-m-Y", strtotime("+$i month", strtotime($awaltempo)));

      $bulan = "$bulanIndo[$i] $tahunanggaran";
      // simpan data

      $ket    = 'BELUM DIBAYAR';

      $add = mysqli_query($conn, "INSERT INTO pembayaran(id_siswa , jatuhtempo, bulan, jumlah, ket, tahun, kelas) VALUES ('$id_siswa','$tahunanggaran','$bulan','$biaya', '$ket','$tahunanggaran','$hasil[0]')");
    }
    for ($i = 1; $i <= 6; $i++) {
      // tanggal jatuh tempo setiap tanggal ?
      $jatuhtempo = date("d-m-Y", strtotime("+$i month", strtotime($awaltempo)));

      $bulan = "$bulanIndo[$i] $nexttahunanggaran";
      // simpan data

      $ket    = 'BELUM DIBAYAR';

      $add = mysqli_query($conn, "INSERT INTO pembayaran(id_siswa , jatuhtempo, bulan, jumlah, ket, tahun, kelas) VALUES ('$id_siswa','$nexttahunanggaran','$bulan','$biaya', '$ket','$tahunanggaran','$hasil[0]')");
    }

    echo "<script>alert('data siswa berhasil disimpan')
    document.location = 'editdatasiswa.php';
    </script>";
  } else {
    echo "<script>alert('data siswa gagal disimpan')
    document.location = 'editdatasiswa.php';
    </script>";
  }
}
?>

<?php include 'footer.php'; ?>

<script type="text/javascript">
  $('.view_data').click(function() {
    var id_siswa = $(this).attr('id');
    $.ajax({
      url: 'view.php',
      method: 'post',
      data: {
        id_siswa: id_siswa
      },
      success: function(data) {
        $('#datasiswa').html(data)
        $('#myModal').modal('show');
      }
    })
  })
</script>


<?php
if (isset($_POST['edit'])){
  $id_siswa   = $_POST['id_siswa'];
  $nama = htmlentities(strip_tags(ucwords($_POST['nama'])));
  $id_angkatan = htmlentities(strip_tags($_POST['id_angkatan']));
  $id_kelas = htmlentities(strip_tags($_POST['id_kelas']));
  $id_jurusan = htmlentities(strip_tags($_POST['id_jurusan']));
  $alamat = htmlentities(strip_tags($_POST['alamat']));
  
  $query        = "UPDATE siswa SET 
  nama  = '$nama',
  id_angkatan  = '$id_angkatan',
  id_kelas = '$id_kelas',
  id_jurusan = '$id_jurusan',
  alamat  = '$alamat' WHERE id_siswa = '$id_siswa' ";
  $exec         = mysqli_query($conn, $query);
  if($exec){
    echo "<script>alert('data siswa berhasil diedit')
    document.location = 'editdatasiswa.php'</script>;
    "
    ;

  }else {
   echo "<script>alert('data siswa gagal diedit')
   document.location = 'editdatasiswa.php'</script>;
   "
   ;
 }

}
?>

