<?php

include 'koneksi.php';
include 'header.php';
?>
<?php
if (isset($_GET['nisn']) && $_GET['nisn'] != ''){
	$nisn 		= $_GET['nisn'];
	$query 		= "SELECT siswa.*,angkatan.*,jurusan.*,kelas.* FROM siswa,angkatan,jurusan,kelas WHERE siswa.id_angkatan = angkatan.nama_angkatan AND siswa.id_jurusan = jurusan.id_jurusan AND siswa.id_kelas = kelas.id_kelas AND siswa.nisn = '$nisn'";
	$exec 		= mysqli_query($conn,$query);
	$siswa 		= mysqli_fetch_assoc($exec);

	if($siswa == ''){ ?>

		<h5 class="text-center mt-5">Data tidak ditemukan!</h5>

	<?php
	}else{
		$id_siswa	= $siswa['id_siswa'];
		$nisn 		= $siswa['nisn'];
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
		<?php
//ambil hostory sekolah siswa dari kelas 10 sd 12
$qdata="select * from siswatemp where nisn='$nisn'";
$query=mysqli_query($conn, $qdata);
$hasil=mysqli_fetch_array($query);
$tahunanggaran = substr($hasil['tahun'], 0, 4); //2021
$nexttahunanggaran=$tahunanggaran+1;



if($hasil['kls10']!=NULL){
	$kelas=10;
	$namakelas=$hasil['kls10'];

	$ceklunas=mysqli_query($conn,"select count(tglbayar) from pembayaran where tglbayar!=0 and kelas=10 and id_siswa=$id_siswa");
	$lunas=mysqli_fetch_array($ceklunas);
	$lebar=$lunas[0]/12*100;
	if($lebar<=45) $progress="progress-bar bg-danger";
	elseif($lebar<=65) $progress="progress-bar bg-warning";
	elseif($lebar<=75) $progress="progress-bar bg-info";
	elseif($lebar<=100) $progress="progress-bar bg-success";
	if($lunas[0]==12) $katakata="SPP Lunas&nbsp;";
	elseif($lunas[0]<12) $katakata="SPP Dibayar $lunas[0] bulan&nbsp;";
	
?>

<div class="card">
                                <!-- Card Header - Accordion -->
                                <a href="#collapseCardExamplex" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExamplex">
                                    <h6 class="m-0 font-weight-bold text-primary">Data Pembayaran SPP Kelas <?=$kelas;?> / <?=$namakelas?> [Tahun <?=$tahunanggaran;?>/<?=$nexttahunanggaran;?>]</h6> 								
									<div class="row no-gutters align-items-center">
                                                <div class="col-auto">
                                                    <div ><?=$katakata?></div>
                                                </div>
                                                <div class="col">
                                                    <div class="progress progress-sm mr-2">
                                                        <div class="<?=$progress?>" role="progressbar" style="width: <?=$lebar?>%" aria-valuenow="<?=$lunas[0]?>" aria-valuemin="0" aria-valuemax="12"></div>
                                                    </div>
                                                </div>
                                            </div>
                                </a>
                                <!-- Card Content - Collapse -->
                                <div class="collapse show" id="collapseCardExamplex" style="">
                                    <div class="card-body">
                                        <?php include "tampildata.php"; ?>
                                    </div>
                                </div>
                            </div>


<?php
}
if($hasil['kls11']!=NULL){
	$kelas=11;
	$namakelas=$hasil['kls11'];
	$tahunanggaran=$tahunanggaran+1;
	$nexttahunanggaran=$nexttahunanggaran+1;

	$ceklunas=mysqli_query($conn,"select count(tglbayar) from pembayaran where tglbayar!=0 and kelas=11 and id_siswa=$id_siswa");
	$lunas=mysqli_fetch_array($ceklunas);
	$lebar=$lunas[0]/12*100;
	if($lebar<=45) $progress="progress-bar bg-danger";
	elseif($lebar<=65) $progress="progress-bar bg-warning";
	elseif($lebar<=75) $progress="progress-bar bg-info";
	elseif($lebar<=100) $progress="progress-bar bg-success";
	if($lunas[0]==12) $katakata="SPP Lunas&nbsp;";
	elseif($lunas[0]<12) $katakata="SPP Dibayar $lunas[0] bulan&nbsp;";

	?>
<div class="card">
                                <!-- Card Header - Accordion -->
                                <a href="#collapseCardExamplexx" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExamplexx">
                                    <h6 class="m-0 font-weight-bold text-primary">Data Pembayaran SPP Kelas <?=$kelas;?> / <?=$namakelas?> [Tahun <?=$tahunanggaran;?>/<?=$nexttahunanggaran;?>]</h6> 								
									<div class="row no-gutters align-items-center">
                                                <div class="col-auto">
                                                    <div ><?=$katakata?></div>
                                                </div>
                                                <div class="col">
                                                    <div class="progress progress-sm mr-2">
                                                        <div class="<?=$progress?>" role="progressbar" style="width: <?=$lebar?>%" aria-valuenow="<?=$lunas[0]?>" aria-valuemin="0" aria-valuemax="12"></div>
                                                    </div>
                                                </div>
                                            </div>
                                </a>
                                <!-- Card Content - Collapse -->
                                <div class="collapse show" id="collapseCardExamplexx" style="">
                                    <div class="card-body">
                                        <?php include "tampildata.php"; ?>
                                    </div>
                                </div>
                            </div>


<?php
}
if($hasil['kls12']!=NULL){
	$kelas=12;
	$namakelas=$hasil['kls12'];
	$tahunanggaran=$tahunanggaran+1;
	$nexttahunanggaran=$nexttahunanggaran+1;

	$ceklunas=mysqli_query($conn,"select count(tglbayar) from pembayaran where tglbayar!=0 and kelas=12 and id_siswa=$id_siswa");
	$lunas=mysqli_fetch_array($ceklunas);
	$lebar=$lunas[0]/12*100;
	if($lebar<=45) $progress="progress-bar bg-danger";
	elseif($lebar<=65) $progress="progress-bar bg-warning";
	elseif($lebar<=75) $progress="progress-bar bg-info";
	elseif($lebar<=100) $progress="progress-bar bg-success";
	if($lunas[0]==12) $katakata="SPP Lunas&nbsp;";
	elseif($lunas[0]<12) $katakata="SPP Dibayar $lunas[0] bulan&nbsp;";

	?>
<div class="card ">
                                <!-- Card Header - Accordion -->
                                <a href="#collapseCardExamplexxx" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExamplexxx">
                                    <h6 class="m-0 font-weight-bold text-primary">Data Pembayaran SPP Kelas <?=$kelas;?> / <?=$namakelas?> [Tahun <?=$tahunanggaran;?>/<?=$nexttahunanggaran;?>]   
								</h6> 	
                      							
									<div class="row no-gutters align-items-center">
                                                <div class="col-auto">
                                                    <div ><?=$katakata?></div>
                                                </div>
                                                <div class="col">
                                                    <div class="progress progress-sm mr-2">
                                                        <div class="<?=$progress?>" role="progressbar" style="width: <?=$lebar?>%" aria-valuenow="<?=$lunas[0]?>" aria-valuemin="0" aria-valuemax="12"></div>
                                                    </div>
                                                </div>
                                            </div>
                                </a>
                                <!-- Card Content - Collapse -->
                                <div class="collapse show" id="collapseCardExamplexxx" style="">
                                    <div class="card-body">
                                        <?php include "tampildata.php"; ?>
                                    </div>
                                </div>
                            </div>

<?php
}

?>
			

		

		<?php } 
	} ?>
<?php
if (isset($_GET['nisn']) && $_GET['nisn'] != ''){

?>
		<div class="card shadow mb-4">
                <div class="card-header py-3">
                  <h5 class="m-0 font-weight-bold text-primary">Cetak Data Laporan</h5>
                </div>
                <div class="card-body">
                  <form action="cetak_laporan2.php" method="get" target="_blank">
                    <div class="form-group row">
                      <div class="col-sm-2 mb-3 mb-sm-0">
                        <input type="date" name="awal" class="form-control mb-2">
                      </div>
                      <div class="col-sm-2 mb-3 mb-sm-0">
                        <input type="date" name="akhir" class="form-control mb-2">
                      </div>
                      <div class="col-sm-2">.
						<input type="hidden" name="id_siswa" value="<?=$id_siswa?>">
                        <button type="submit" class="btn btn-primary" name="cetak">Cetak</button>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
<?php } ?>

		<?php include 'footer.php'; ?>
	</div>