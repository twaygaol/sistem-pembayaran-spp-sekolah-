<div class="card shadow mb-4">
			<div class="card-header py-3">
				<h5 class="m-0 font-weight-bold text-primary">Data Pembayaran 
               
                
						<input type="hidden" name="id_siswa" value="<?=$id_siswa?>">
                        <a href="cetak_laporan_spp_tahunan.php?id_siswa=<?=$id_siswa?>&kelas=<?=$kelas?>&tahun=<?=$tahunanggaran;?>" class="btn btn-info" target="_blank"><i class="fa fa-print"></i> Cetak Rekap SPP</a>
						 </h5>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
						<thead>
							<tr>
								<td>No</td>
								<th>Bulan</th>
								<th>Jatuh Tempo</th>
								<th>No Bayar</th>
								<th>Tanggal Bayar</th>
								<th>Jumlah</th>
								<th>Keterangan</th>
								<th>Aksi</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$no=1;
							$query = "SELECT * FROM pembayaran WHERE id_siswa = '$id_siswa' AND kelas=$kelas ORDER BY idspp ASC";
							$exec = mysqli_query($conn,$query);
							while($res = mysqli_fetch_assoc($exec)) { ?>
								<tr>
									<td><?= $no++ ?></td>
									<td><?= $res['bulan'] ?></td>
									<td>15 <?= $res['bulan'] ?></td>
									<td><?= $res['nobayar'] ?></td>
									<td><?= $res['tglbayar'] ?></td>
									<td>Rp. <?= number_format ($res['jumlah']) ?></td>
									<td><?= $res['ket'] ?></td>
									<td>
										<?php
										if ($res['nobayar'] == ''){
											echo "<a href='proses_transaksi.php?nisn=$nisn&act=bayar&id=$res[idspp]'></a> ";
											echo "<a class='btn btn-primary btn-sm' href='proses_transaksi.php?nisn=$nisn&act=bayar&id=$res[idspp]'>Bayar</a> ";
										}else {
											echo "</a>";
											echo "<a class='btn btn-danger btn-sm' href='proses_transaksi.php?nisn=$nisn&act=batal&id=$res[idspp]'>Batal</a> ";
											echo "<a class='btn btn-success btn-sm' href='cetak_slip_pembayaran.php?nisn=$nisn&act=bayar&id=$res[idspp]' target='_blank'>Cetak</a> ";
										}
										?>
									</td>
								</tr>
							<?php } ?>
						</tbody>
					</table>

				</div>

			</div>