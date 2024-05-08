<?php include 'header.php'; 
include 'koneksi.php';
?>


<!-- DataTables Example -->
<div class="card shadow mb-4">
  <div class="card-header py-3">
    <h5 class="m-0 font-weight-bold text-primary">Data Siswa</h5>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th>NISN</th>
            <th>Nama</th>
            <th>Angkatan</th>
            <th>Jurusan</th>
            <th>Kelas</th>
            <th>Alamat</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $query = "SELECT siswa.*, angkatan.*, jurusan.*, kelas.* FROM siswa, angkatan, jurusan, kelas WHERE siswa.id_angkatan = angkatan.nama_angkatan AND siswa.id_jurusan = jurusan.id_jurusan AND siswa.id_kelas = kelas.id_kelas ORDER BY id_siswa";
          $exec = mysqli_query($conn, $query);
          while($res = mysqli_fetch_assoc($exec)) :

            ?>
            <tr>
              <td><?= $res['nisn'] ?></td>
              <td><?= $res['nama'] ?></td>
              <td><?= $res['nama_angkatan'] ?></td>
              <td><?= $res['nama_jurusan'] ?></td>
              <td><?= $res['nama_kelas'] ?></td>
              <td><?= $res['alamat'] ?></td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<?php include 'footer.php'; ?> 