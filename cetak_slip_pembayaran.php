<?php

session_start();
if(isset($_SESSION['admin'])) {
	include 'koneksi.php';


?>
<!DOCTYPE html>
	<html>
	<head>
		
		<title>Slip Pembayaran SPP</title>

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
		<?php
		$nisn	= $_GET['nisn'];
		$siswa	= mysqli_query($conn,"SELECT siswa.*,angkatan.*,jurusan.*,kelas.* FROM siswa, angkatan, jurusan, kelas WHERE siswa.id_angkatan = angkatan.nama_angkatan AND siswa.id_jurusan = jurusan.id_jurusan AND siswa.id_kelas = kelas.id_kelas AND siswa.nisn = '$nisn'");
		$sw		= mysqli_fetch_assoc($siswa);
		$idspp	= $_GET['id'];

		?>
		<table cellpadding="6">
			<tr>
				<td>Nama Siswa</td>
				<td>: </td>
				<td> <?= $sw['nama'] ?></td>
			</tr>
			<tr>
				<td>NISN</td>
				<td>: </td>
				<td> <?= $sw['nisn'] ?></td>
			</tr>
			<tr>
				<td>Kelas</td>
				<td>: </td>
				<td> <?= $sw['nama_kelas'] ?></td>
			</tr>
			<tr>
				<td>Angkatan</td>
				<td>: </td>
				<td> <?= $sw['nama_angkatan'] ?></td>
			</tr>
			<tr>
				<td>Jurusan</td>
				<td>:</td>
				<td> <?= $sw['nama_jurusan'] ?></td>
			</tr>
		</table>
		<hr>
		<table border="1" cellspacing="" cellpadding="6" width="100%">
			<tr>
				<th>No.</th>
				<th>No. Bayar</th>
				<th>Pembayaran Bulan</th>
				<th>Jumlah</th>
				<th>Keterangan</th>
			</tr>
			<?php
			$spp	= mysqli_query($conn, "SELECT siswa.*,pembayaran.* FROM siswa,pembayaran WHERE pembayaran.id_siswa = siswa.id_siswa AND pembayaran.idspp = '$idspp' ORDER BY nobayar ASC");
			$i 		= 1;
			$total	= 0;
			while ($dta=mysqli_fetch_assoc($spp)) :
			?>
			<tr>
				<td align="center">	<?= $i ?></td>
				<td align="">		<?= $dta['nobayar'] ?></td>
				<td align="">		<?= $dta['bulan'] ?></td>
				<td align="right">Rp. <?= number_format ($dta['jumlah']) ?></td>
				<td align="center">	<?= $dta['ket'] ?></td>
			</tr>
			<?php $i++; ?> 
			<?php $total += $dta['jumlah'] ?>

<?php endwhile; ?>
<tr>
	<td colspan="3" align="center"><b>TOTAL</b></td>
	<td align="right"><b>Rp. <?= number_format ($total) ?></b></td>
	<td></td>
</tr>

		</table>
		<table width="100%">
			<tr>
					<td></td>


					<td width="200px">
						<br/>
						<p>Kotacane, <?= date('d-m-Y') ?> <br/>
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
