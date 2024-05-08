
<?php

include 'koneksi.php';
$idsiswa=$_POST['idsiswa'];
//echo "id siswa =$_POST[idsiswa]";



if(isset($idsiswa)){
	//$id_siswa= $_POST['id_siswa'];
	$query	 = "SELECT siswa.*, angkatan.*, jurusan.*, kelas.* FROM siswa, angkatan, jurusan, kelas WHERE siswa.id_angkatan = angkatan.nama_angkatan AND siswa.id_jurusan = jurusan.id_jurusan AND siswa.id_kelas = kelas.id_kelas AND siswa.id_siswa = $idsiswa";
  $exec = mysqli_query($conn, $query);
  $res = mysqli_fetch_assoc($exec);

  $tahunmasuk=substr($res['nama_angkatan'],0,4);
  $tahunbaru=$tahunmasuk+1;

$qceklunas=mysqli_query($conn, "select count(tglbayar) from pembayaran where tglbayar!=0 and id_siswa=$idsiswa and tahun=$tahunmasuk");
//echo "select count(tglbayar) from pembayaran where tglbayar!=0 and id_siswa=$idsiswa and tahun=$tahunmasuk";
$hceklunas=mysqli_fetch_array($qceklunas);
if($hceklunas[0]<12){
    $togel="disabled";
    echo "<i class='border-bottom-danger text-danger'>SPP Belum Lunas (dibayar $hceklunas[0] bulan) </i>&nbsp;&nbsp;&nbsp;<a class='btn btn-sm btn-info' href='pembayaran.php?nisn=$res[nisn]' target='_blank'><i class='fa fa-check'></i> Cek SPP </a><br><br>";
}
elseif($hceklunas[0]==12){
    $togel="";
    echo "<i class='border-bottom-success text-success'>SPP Sudah Lunas</i> - Klik tombol <b>simpan</b> untuk menyimpan kenaikan kelas<br><br>";
}

  ?>

  <form action="editdatasiswa.php" method="post">
     <input type="hidden" name="id_siswa" value="<?=$res['id_siswa'] ?>">
     <input type="hidden" name="nisn" value="<?= $res['nisn'] ?>">
     <input type="text" class="form-control mb-2" name="" disabled="" value="<?= $res['nisn'] ?>">
     <input type="text" class="form-control mb-2" required name="nama" value="<?= $res['nama'] ?>">
     Tahun masuk: <b><?= $res['nama_angkatan'] ?></b>, jika naik kelas, ubah pada angkatan di bawah ini dengan angkatan baru <b>(<?=$tahunbaru?>/<?=$tahunbaru+1?>)</b>
     <select class="form-control mb-2" name="namaangkatan">
      <option selected="" > Ubah Angkatan</option>
        <option value="<?=$tahunbaru?>/<?=$tahunbaru+1?>"><?=$tahunbaru?>/<?=$tahunbaru+1?></option>
     </select>

     Kelas sebelumnya: <b><?=$res['nama_kelas']?> / Kelas <?=$res['kelas']?></b>, jika naik kelas, ubah kelas di bawah ini satu tingkat lebih tinggi <b>(Kelas <?php $kelasbaru=$res['kelas']+1; echo $kelasbaru;?>)</b>
     <input type="hidden" value="<?=$kelasbaru?>" name="kelasbaru">
     <select class="form-control mb-2" name="namakelas">
      <option selected="">Pilih Kelas</option>
          <?php
          $exec = mysqli_query($conn, "SELECT * FROM kelas where kelas=$kelasbaru");
          while ($angkatan = mysqli_fetch_assoc($exec)){
         echo "<option value='$angkatan[nama_kelas]'>$angkatan[nama_kelas]</option>";
             }
        ?>
    </select>
      

    <div class="modal-footer">
     <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
     <button type="Submit" name="edit" class="btn btn-primary" <?=$togel?>>Simpan</button>
</form>

<?php }?>

