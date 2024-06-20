<!-- membuat koneksi database -->
<?php
    $koneksi = mysqli_connect('localhost','root','','2024_pw_uas') or die('koneksi gagal');  
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Cetak - Laporan Jadwal Kuliah</title>
	<!-- data tables css -->
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap4.min.css">
</head>
<body>
	<div style="height: 20px; width: 100%; background-color: green;"></div>
	<div class="m-5">
		<h1>Aplikasi UAS Pemrograman Web</h1>
		<h3>Laporan Jadwal Kuliah (<?= date("d/M, Y", strtotime(date('Y-m-d'))) ?>)</h4>

		<table class="table table-bordered mt-5">
			<thead>
			    <tr>
			        <th>No.</th>
			        <th>Waktu Kuliah</th>
			        <th>Tempat Kuliah</th>
			        <th>Matakuliah</th>
			    </tr>
			</thead>
			<tbody>
			    <?php $no = 1; 
			    	$SQLTampilDataJadwal = mysqli_query($koneksi, "SELECT * FROM jadwal_kuliah, dosen, mata_kuliah WHERE jadwal_kuliah.id_dosen = dosen.id_dosen AND jadwal_kuliah.id_matakuliah = mata_kuliah.id_matakuliah AND tanggal_entri BETWEEN '".$_POST['inputan_tgl_mulai']."' AND '".$_POST['inputan_tgl_selesai']."' ORDER BY id_jadwalkuliah DESC");
			    	while($data_jadwal = mysqli_fetch_array($SQLTampilDataJadwal)) { ?>
			    <tr style="font-size: smaller;">
			        <td><?= $no++ ?></td>
			        <td><?= $data_jadwal['hari_kuliah'].', <br>'.$data_jadwal['jam_kuliah'] ?></td>
			        <td>
			        	<?= $data_jadwal['tempat_kuliah'].'<br><b>Dosen : </b>'.$data_jadwal['nama_dosen'] ?>
			        	<hr style="margin : 0;">
			        	Tgl. Entri (<?= date("d/M/Y", strtotime($data_jadwal['tanggal_entri'])) ?>)
			        </td>
			        <td><?= $data_jadwal['mata_kuliah'] ?></td>
			    </tr>
			    <?php } ?>
			</tbody>
		</table>
	</div>

	<div style="height: 20px; width: 100%; background-color: black; position: absolute; bottom: 0;"></div>
</body>
</html>
<script type="text/javascript">
	window.print();
	window.onfocus = function(){ window.close(); }
</script>