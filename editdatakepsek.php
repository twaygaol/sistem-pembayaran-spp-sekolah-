<?php include 'header.php'; 
include 'koneksi.php';

if(isset($_GET['id_kepsek'])){
  $id_kepsek = $_GET['id_kepsek'];
  $exec     = mysqli_query($conn, "DELETE FROM kepala_sekolah WHERE id_kepsek='$id_kepsek'");
  if($exec){
    echo "<script>alert('data kepala sekolah berhasil dihapus')
    document.location = 'editdatakepsek.php';
    </script>";
  }else{
    echo "<script>alert('data kepala sekolah gagal dihapus')
    document.location = 'editdatakepsek.php';
    </script>";
  }
}

?>

<!-- button triger -->
<button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#exampleModal">Tambah Data</button>
<!-- button triger -->

<!-- DataTales Example -->
<div class="card shadow mb-4">
  <div class="card-header py-3">
    <h5 class="m-0 font-weight-bold text-primary">Data Kepala Sekolah</h5>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th>ID Kepala Sekolah</th>
            <th>Nama Kepala Sekolah</th>
            <th>Periode</th>
            <th>Aksi</th>
          </tr>
        </thead>
        
        <tbody>
         <?php
         $no=1;
         $query  = "SELECT * FROM kepala_sekolah";
         $exec   = mysqli_query($conn, $query);
         while($res = mysqli_fetch_assoc($exec)) :

          ?>
          <tr>
            <td><?= $no++ ?></td>
            <td><?= $res['nama_kepsek'] ?></td>
            <td><?= $res['periode'] ?></td>
            <td>
              <a href = "editdatakepsek.php?id_kepsek=<?= $res['id_kepsek'] ?>" class = "btn btn-sm btn-danger" onclick = "return confirm ('Apakah yakin ingin menghapus data?')">Hapus</a>
              <a href = "#" class = "view_data btn btn-sm btn-warning"  data-bs-toggle="modal" data-bs-target="#myModal" id="<?php echo $res['id_kepsek']; ?>">Edit</a>
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
        <h5 class="modal-title" id="exampleModalLabel">Data Kepala Sekolah</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">X</button>
      </div>
      <div class="modal-body">
        <form action="" method="POST">
          <input type="text" required name="nama_kepsek" placeholder="Nama Kepala Sekolah" class="form-control mb-2">
          <input type="text" required name="periode" placeholder="Periode" class="form-control mb-2">
         
          
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="Submit" name="simpan" class="btn btn-primary">Simpan</button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal Edit Data admin -->
<div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Data Kepala Sekolah</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">X</button>
      </div>
      <div class="modal-body" id="datakepsek">
      </div>
    </div>
  </div>
</div>

<?php

if(isset($_POST['simpan'])){
  $nama_kepsek = htmlentities(strip_tags(ucwords($_POST['nama_kepsek'])));
  $periode = htmlentities(strip_tags($_POST['periode']));
  
  
  $query      = "INSERT INTO kepala_sekolah (nama_kepsek, periode) VALUES ('$nama_kepsek','$periode')";
  $exec       = mysqli_query($conn, $query);
  if($exec){
    echo "<script>alert('data kepala sekolah berhasil disimpan')
    document.location = 'editdatakepsek.php';
    </script>";
  }else {
    echo "<script>alert('data kepala sekola gagal disimpan')
    document.location = 'editdatakepsek.php';
    </script>";
  }
}
?>

<?php include 'footer.php'; ?> 

<script type="text/javascript">
  $('.view_data').click(function(){
    var id_kepsek = $(this).attr('id');
    $.ajax({
      url : 'view.php',
      method : 'post',
      data : {id_kepsek:id_kepsek},
      success : function(data){
        $('#datakepsek').html(data)
        $('#myModal').modal('show');
      }
    })
  })
</script>


<?php
if (isset($_POST['edit'])){
  $id_kepsek   = $_POST['id_kepsek'];
  $nama_kepsek = htmlentities(strip_tags(ucwords($_POST['nama_kepsek'])));
  $periode = htmlentities(strip_tags($_POST['periode']));
  
  
  $query        = "UPDATE kepala_sekolah SET 
  nama_kepsek   = '$nama_kepsek',
  periode       = '$periode' WHERE id_kepsek = '$id_kepsek' ";
  $exec         = mysqli_query($conn, $query);
  if($exec){
    echo "<script>alert('data kepala sekolah berhasil diedit')
    document.location = 'editdatakepsek.php'</script>;
    "
    ;

  }else {
   echo "<script>alert('data kepala sekolah gagal diedit')
   document.location = 'editdatakepsek.php'</script>;
   "
   ;
 }

}
?>

