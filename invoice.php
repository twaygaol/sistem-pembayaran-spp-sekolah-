<?php include 'header.php'; 
include 'koneksi.php';

if(isset($_GET['id_siswa'])){
  $id_siswa = $_GET['id_siswa'];
  $exec       = mysqli_query($conn, "DELETE FROM invoice WHERE id_siswa='$id_siswa'");
  if($exec){
    echo "<script>alert('data jurusan berhasil dihapus')
    document.location = 'invoice.php';
    </script>";
  }else{
    echo "<script>alert('data jurusan gagal dihapus')
    document.location = 'invoice.php';
    </script>";
  }
}

?>


<!-- DataTables Example -->
<div class="card shadow mb-4">
  <div class="card-header py-3">
    <h5 class="m-0 font-weight-bold text-primary">Data Siswa</h5>
    <P>" Data Siswa Di bawah Ini Merupakan Siswa Yang Melakukan Pembayaran Via Transfer Bank "</P>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
          <tr class="text-center bold">
          
            <th>Nama</th>
            <th>Nisn</th>
            <th>Kelas</th>
            <th>Bayar bulan</th>
            <th>Total bayar</th>
            <th>Keterangan</th>
            <th>bukti</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $query = "SELECT invoice.*, angkatan.*, jurusan.*, kelas.* FROM invoice, angkatan, jurusan, kelas WHERE invoice.id_angkatan = angkatan.nama_angkatan AND invoice.id_jurusan = jurusan.id_jurusan AND invoice.id_kelas = kelas.id_kelas  ORDER BY id_siswa";
          $exec = mysqli_query($conn, $query);
          while($res = mysqli_fetch_assoc($exec)) :

            ?>
            <tr class="text-center">
              <td><?= $res['nisn_siswa'] ?></td>
              <td><?= $res['nama'] ?></td>
              <td><?= $res['nama_kelas'] ?></td>
              <td><?= $res['id_bulan'] ?></td>
              <td>Rp. <?= $res['jumlah'] ?></td>
              <td><?= $res['nama_jurusan'] ?></td>
              <td>
                <button type="button" class="btn btn-danger" data-toggle="modal"     data-target="#exampleModalLong">
                Lihat
                </button>
                <!-- lihat bukti bayar -->
                <!-- Modal -->
                <div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title text-center" id="exampleModalLongTitle">Struk Bukti Transfer <b>#<?php echo $res['nama'] ?></b></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                      <img src="./gambar/<?= $res['gambar'] ?>" width="100%" height="450"/>
                      </div>
                    </div>
                  </div>
              </td>
              <td>
                <a href="invoice.php?id_siswa=<?= $res['id_siswa'] ?>"  class="btn btn-sm btn-primary" onclick="return confirm ('Apakah yakin ingin menghapus data?')">Hapus</a>
                <a href="pembayaran.php?nisn=<?= $res['nama']?>&cari="  class="btn btn-sm btn-success" >Cari</a>
              </td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>



<?php include 'footer.php'; ?> 