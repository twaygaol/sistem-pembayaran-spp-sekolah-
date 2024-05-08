<?php

session_start();
if(isset($_SESSION['admin'])) {
	include 'koneksi.php';
	$awal	= $_GET['awal'] ;
	$akhir	= $_GET['akhir'] ;
?>

<!DOCTYPE html>
	<html>
	<head>
		
		<title>Laporan Pembayaran</title>

		<link href="img/logos.png" rel="shortcut icon">

		<style>
			body{
				font-family: arial;
			}
			
			table{
				border-collapse: collapse;
			}
		</style>
	</head>
	<body onload="window.print();">
		<h3>MA DARUL AZHAR<b><br/>LAPORAN PEMBAYARAN SPP</b></h3>
		<br/>
		<hr/>
		Tanggal <?= $awal." Sampai ".$akhir?>
		<br/>
		<br>
		<table border="1" cellpadding="6" width="100%">
			<tr>
				<th>No.</th>
				<th>NISN</th>
				<th>Nama Siswa</th>
				<th>Tanggal Bayar</th>
				<th>No. Bayar</th>
				<th>Pembayaran Bulan</th>
				<th>Jumlah</th>
				<th>Keterangan</th>
			</tr>

			<?php
			$spp	= mysqli_query($conn,"SELECT siswa.*,pembayaran.* FROM siswa, pembayaran WHERE pembayaran.id_siswa = siswa.id_siswa AND tglbayar BETWEEN '$awal' AND '$akhir' ORDER BY nobayar");
			$i		= 1;
			$total	= 0;
			while($dta=mysqli_fetch_assoc($spp)) :
			?>
			<tr>
				<td align="center">	<?= $i ?></td>
				<td align="left">	<?= $dta['nisn'] ?></td>
				<td align="left">	<?= $dta['nama'] ?></td>
				<td align="">		<?= $dta['tglbayar'] ?></td>
				<td align="">		<?= $dta['nobayar'] ?></td>
				<td align="">		<?= $dta['bulan'] ?></td>
				<td align="right">Rp. <?= number_format ($dta['jumlah']) ?></td>
				<td align="center">	<?= $dta['ket'] ?></td>
			</tr>
			<?php $i++; ?>
			<?php $total += $dta['jumlah'] ?>
		<?php endwhile; ?>
		<tr>
			<td colspan="6" align="center"><b>Total</b></td>
			<td align="right"><b>Rp. <?= number_format ($total) ?></b></td>
			<td></td>
		</tr>
		</table>

		<table width="100%">
			<tr>
					<td></td>


					<td width="200px">
						<br/>
						<p>Kutacane, <?= date('d-m-Y') ?> <br/>
							Bendahara,
							<br/>
							<br/>
							<br/>
							<br/>
							<p>Listinawati, S.pd.I</p>
							<!-- <p><?= $sw['nama'] ?></p> -->
						</td>
					</tr>
				</table>

	</body>
</html>

<?php
}else {
	header("location : index.php");
}
?>