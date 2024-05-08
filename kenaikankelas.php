<?php include 'header.php';
include 'koneksi.php';

?>

<!-- DataTales Example -->
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
            <th>Kelas</th>
            <th>Kelas Skrg</th>
            <th>Alamat</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $query = "SELECT siswa.*, angkatan.*, kelas.*, siswatemp.* FROM siswa, angkatan, kelas, siswatemp WHERE siswa.id_angkatan = angkatan.nama_angkatan AND siswa.id_kelas = kelas.id_kelas AND siswatemp.nisn = siswa.nisn";
          $exec = mysqli_query($conn, $query);
          while ($res = mysqli_fetch_assoc($exec)) {

          ?>
            <tr>
              <td><?= $res['nisn'] ?></td>
              <td><?= $res['nama'] ?></td>
              <td><?= $res['nama_angkatan'] ?></td>
              <td><?= $res['nama_kelas'] ?></td>
              <td><?= $res['kelas'] ?></td>
              <td><?= $res['alamat'] ?></td>
              <td>
                <?php
                $idku = $res['id_siswa'];
                if ($res['kelas'] == "12") {
                ?>

                  <button type="button" class="btn btn-sm btn-secondary" disabled>Kelas 12</button>

                <?php } ?>
                <?php
                //cek naik kelas berapa
                if ($res['kelas'] == "10") {

                ?>
                  <a href=# class="view_data btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#myModal" id=<?=$idku; ?>>Naik Kelas 11</a>
                <?php } ?>
                <?php if ($res['kelas'] == "11") {

                ?>
                  <a href=# class="view_data btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#myModal" id=<?=$idku; ?>>Naik Kelas 12</a>
                <?php } ?>
    </div>
  </div>
</div>


</td>
</tr>
<?php } ?>
</tbody>
</table>
</div>
</div>
</div>


<!-- Modal Kenaikan Kelas Siswa -->
<div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Kenaikan Kelas Siswa</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">X</button>
      </div>
      <div class="modal-body" id="datasiswa">
      </div>
    </div>
  </div>
</div>
<?php include 'footer.php'; ?>

<script type="text/javascript">
  $('.view_data').click(function(){
    var idsiswa = $(this).attr('id');
    $.ajax({
      url : 'viewx.php',
      method : 'post',
      data : 'idsiswa=' + idsiswa,
      success : function(data){
        $('#datasiswa').html(data)
        $('#myModal').modal('show');
      }
    })
  })
</script>

<script type="text/javascript">
  /*
  $(function() {
    $('.view_data').click(function() {
      var idsiswa = $(this).attr('id');
      $.ajax({
        type: 'post',
        url: 'viewx.php', // in here you should put your query 
        data: 'post_id=' + idsiswa, // here you pass your id via ajax .
        // in php you should use $_POST['post_id'] to get this value 
        success: function(r) {
          // now you can show output in your modal 
          $('#mymodal').show(); // put your modal id 
          $('#datasiswa').html(data)
        }
      });


    });

  });
  */
</script>


<?php
if (isset($_POST['naik'])) {
  $id_siswa     = $_POST['id_siswa'];
  $id_angkatan  = htmlentities(strip_tags($_POST['id_angkatan']));
  $id_kelas     = htmlentities(strip_tags($_POST['id_kelas']));

  "INSERT INTO siswa (nisn, nama, id_angkatan, id_jurusan, id_kelas, alamat) values('$nisn','$nama','$id_angkatan','$id_jurusan','$id_kelas','$alamat'";
  $exec         = mysqli_query($conn, $query);
  if ($exec) {

    $bulanIndo = [
      '01' => 'Januari',
      '02' => 'Februari',
      '03' => 'Maret',
      '04' => 'April',
      '05' => 'Mei',
      '06' => 'Juni',
      '07' => 'Juli',
      '08' => 'Agustus',
      '09' => 'September',
      '10' => 'Oktober',
      '11' => 'November',
      '12' => 'Desember'
    ];

    $query = "SELECT siswa.*,angkatan.* FROM siswa,angkatan WHERE siswa.id_angkatan = angkatan.id_angkatan AND siswa.id_siswa='$id_siswa' ORDER BY  siswa.id_siswa DESC LIMIT 1";

    $exec       = mysqli_query($conn, $query);
    $res        = mysqli_fetch_assoc($exec);
    $biaya      = $res['biaya'];
    $id_siswa   = $res['id_siswa'];
    $ket        = $res['ket'];
    $awaltempo  = date('d-m-Y');
    for ($i = 0; $i < 12; $i++) {
      // tanggal jatuh tempo setiap tanggal ?
      $jatuhtempo = date("d-m-Y", strtotime("+$i month", strtotime($awaltempo)));

      $bulan = $bulanIndo[date('m', strtotime($jatuhtempo))] . "  " . date('Y', strtotime($jatuhtempo));
      // simpan data

      $ket    = 'BELUM DIBAYAR';

      $add = mysqli_query($conn, "INSERT INTO pembayaran(id_siswa , jatuhtempo, bulan, jumlah, ket) VALUES ('$id_siswa','$jatuhtempo','$bulan','$biaya', '$ket')");
    }

    echo "<script>alert('Kenaikan kelas siswa berhasil')
  document.location ='kenaikankelas.php' </script>
  ";
  } else {
    echo "<script>alert('Kenaikan kelas siswa gagal')
  document.location ='kenaikankelas.php' </script>
  ";
  }
}
?>