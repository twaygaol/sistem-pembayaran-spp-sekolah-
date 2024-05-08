<?php 
include 'header.php'; 
include 'koneksi.php';
?>

<div class="card shadow mb-4">
	<div class="card-header py-3">
		<h5 class="m-0 font-weight-bold text-primary">Cetak Data Laporan</h5>
	</div>
	<div class="card-body">
		<form action="cetak_laporan.php" method="get" target="_blank">
			<div class="form-group row">
				<div class="col-sm-2 mb-3 mb-sm-0">
					<input type="date" name="awal" class="form-control mb-2">
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

<?php include 'footer.php'; ?>