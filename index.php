<!-- membuat koneksi database -->
<?php
    $koneksi = mysqli_connect('localhost','root','','penjualan_pwuas2024') or die('koneksi gagal');  
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Aplikasi CRUD (Penjualan)</title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <!-- Komponen FontAwesome -->
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
  <!-- memasukkan/import Google Font ke halaman web-->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Sofia">
</head>
<body>

<!-- nama aplikasi -->
<center class="m-3"><h1 style="font-family: 'Sofia', sans-serif; color: green; font-weight: bold;"><i class="fa fa-clone"></i> Aplikasi CRUD (Penjualan)</h1></center>

<!-- menu tab aplikasi -->
<div class="container mt-5">
  <ul class="nav nav-tabs">
    <li class="nav-item">
      <a class="nav-link <?php echo ($_SESSION['active_tab'] == 'beranda' || !isset($_SESSION['active_tab'])) ? 'active' : ''; ?>" data-toggle="tab" href="#beranda">Penjualan</a>
    </li>
    <li class="nav-item">
      <a class="nav-link <?php echo ($_SESSION['active_tab'] == 'produk') ? 'active' : ''; ?>" data-toggle="tab" href="#produk">Kelola produk</a>
    </li>
    <li class="nav-item">
      <a class="nav-link <?php echo ($_SESSION['active_tab'] == 'customer') ? 'active' : ''; ?>" data-toggle="tab" href="#customer">Kelola Customer</a>
    </li>
    <li class="nav-item">
      <a class="nav-link <?php echo ($_SESSION['active_tab'] == 'menu_cetak') ? 'active' : ''; ?>" data-toggle="tab" href="#menu_cetak">Laporan</a>
    </li>
  </ul>

  <!-- konten menu tab aplikasi -->
  <div class="tab-content mt-2">
    <!-- area halaman beranda -->
    <div id="beranda" class="container tab-pane <?php echo ($_SESSION['active_tab'] == 'beranda' || !isset($_SESSION['active_tab'])) ? 'active' : ''; ?>">
      <h3>penjualan</h3>
      <div class="row">
        <!-- konten form entri penjualan -->
        <div class="col-5">
            <div class="card">
                <div class="card-header bg-secondary text-white"><b>Form Entri (penjualan)</b></div>
                <div class="card-body">
                    <?php 
                        //perintah untuk menampilkan data ke form entri saat melakukan ubah data
                        if(@$_GET['aksi'] == 'ubah_penjualan') { 
                            $SQLTampilDataUbahpenjualan = mysqli_query($koneksi, "SELECT * FROM penjualan where idpenjualan = '".$_GET['vid_penjualan']."' "); 
                            $data_ubah_penjualan = mysqli_fetch_array($SQLTampilDataUbahpenjualan);
                        }
                    ?>
                    <form method="post" enctype="multipart/form-data" action="">

                        <input class="form-control" type="hidden" name="inputan_id_penjualan" value="<?= @$_GET['vid_penjualan'] ?>">
                        
                        <div class="row mb-2">
                            <label class="col-4">Nama Customer</label>
                            <div class="col-8">
                                <select class="form-control" name="inputan_nama_customer" required>
                                    <?php if(!empty(@$data_ubah_penjualan['idcustomer'])) { ?>
                                    <option value="<?= @$data_ubah_penjualan['idcustomer'] ?>"><?= @$data_ubah_penjualan['nama_customer'] ?></option>
                                    <?php } ?>
                                    
                                    <option value=""> -- Silahkan Pilih --</option>
                                    <?php $SQLTampilDatacustomer = mysqli_query($koneksi, "SELECT * FROM customer ORDER BY idcustomer DESC");
                                        while($data_customer = mysqli_fetch_array($SQLTampilDatacustomer)) { ?>
                                    <option value="<?= $data_customer['idcustomer'] ?>"><?= $data_customer['nama_customer'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <label class="col-4">Nama Produk</label>
                            <div class="col-8">
                                <select class="form-control" name="inputan_nama_produk" required>
                                    <?php if(!empty(@$data_ubah_penjualan['idproduk'])) { ?>
                                    <option value="<?= @$data_ubah_penjualan['idproduk'] ?>"><?= @$data_ubah_penjualan['nama_produk'] ?></option>
                                    <?php } ?>
                                    
                                    <option value=""> -- Silahkan Pilih --</option>
                                    <?php $SQLTampilDatacustomer = mysqli_query($koneksi, "SELECT * FROM produk ORDER BY idproduk DESC");
                                        while($data_customer = mysqli_fetch_array($SQLTampilDatacustomer)) { ?>
                                    <option value="<?= $data_customer['idproduk'] ?>"><?= $data_customer['nama_produk'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <label class="col-4">Tangal Entri</label>
                            <div class="col-8">
                                <input class="form-control" type="date" name="inputan_tanggal_penjualan" required value="<?= @$data_ubah_penjualan['tanggal_penjualan'] ?>">
                            </div>
                        </div>
                        <div class="row mb-2">
                            <label class="col-4">harga</label>
                            <div class="col-8">
                                <input class="form-control" type="text" name="inputan_harga" required value="<?= @$data_ubah_jadwal['harga'] ?>">
                            </div>
                        </div>
                        <div class="row mb-2">
                            <label class="col-4">Total Pesanan</label>
                            <div class="col-8">
                                <input class="form-control" type="text" name="inputan_total_pesanan" required value="<?= @$data_ubah_jadwal['total_pesanan'] ?>">
                            </div>
                        </div>
                        <div class="row mb-2">
                            <label class="col-4">Total harga</label>
                            <div class="col-8">
                                <input class="form-control" type="text" name="inputan_total_harga" required value="<?= @$data_ubah_jadwal['total_harga'] ?>">
                            </div>
                        </div>
                        <div class="row mb-2">
                            <label class="col-4">Catatan</label>
                            <div class="col-8">
                                <input class="form-control" type="text" name="inputan_catatan_penjualan" required value="<?= @$data_ubah_jadwal['catatan'] ?>">
                            </div>
                            
                        </div>

                        <!-- Button atau tombol -->
                        <button name="tombol_simpan_penjualan" class="btn btn-success btn-block btn-lg"> <i class="fa fa-save"></i> Simpan</button>
                        <a href="index.php" class="btn btn-danger btn-block"><i class="fa fa-refresh fa-spin"></i> Muat Ulang</a>

                    </form>    
                </div>
            </div>
        </div>
        
        <!-- konten form data penjualan -->
        <div class="col-7">
            <div class="card">
                <div class="card-header bg-secondary text-white"><b>Tabel Data (penjualan)</b></div>
                <div class="card-body">
                    <table class="table table-bordered" id="tabel_data">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>nama Customer</th>
                                <th>Nama Produk</th>
                                <th>Tanggal</th>
                                <th>harga</th>
                                <th>total pesanan</th>
                                <th>total harga</th>
                                <th>catatan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; 
                                $SQLTampilDatapenjualan = mysqli_query($koneksi, "SELECT penjualan.*, customer.nama_customer, produk.nama_produk 
                                FROM penjualan
                                JOIN customer ON penjualan.idcustomer = customer.idcustomer
                                JOIN produk ON penjualan.idproduk = produk.idproduk
                                ORDER BY penjualan.idpenjualan DESC;");
                                while($data_penjualan = mysqli_fetch_array($SQLTampilDatapenjualan)) { ?>
                            <tr style="font-size: smaller;">
                                <td><?= $no++ ?></td>
                                <td><?= $data_penjualan['nama_customer'] ?></td>
                                <td><?= $data_penjualan['nama_produk'] ?></td>
                                <td><?= $data_penjualan['tanggal_penjualan'] ?></td>
                                <td><?= $data_penjualan['harga'] ?></td>
                                <td><?= $data_penjualan['total_pesanan'] ?></td>
                                <td><?= $data_penjualan['total_harga'] ?></td>
                                <td><?= $data_penjualan['catatan'] ?></td>
                                <td>
                                    <a style="margin: 2px;" href="index.php?aksi=ubah_penjualan&vid_penjualan=<?= $data_penjualan['idpenjualan'] ?>" class="btn btn-success btn-sm"><i class="fa fa-edit"></i></a>
                                    <a style="margin: 2px;" onclick="return confirm('Yakin hapus ?')" href="index.php?aksi=hapus_penjualan&vid_penjualan=<?= $data_penjualan['idpenjualan'] ?>" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
      </div>
    </div>
    <!-- area halaman menu produk -->
    <div id="produk" class="container tab-pane <?php echo ($_SESSION['active_tab'] == 'produk') ? 'active' : ''; ?>">
      <h3>PRODUK</h3>
      <p>Ini adalah menu untuk mengelola data PRODUK</p>
      <div class="row">
        <!-- konten form entri produk -->
        <div class="col-5">
            <div class="card">
                <div class="card-header bg-secondary text-white"><b>Form Entri (produk)</b></div>
                <div class="card-body">
                    <?php 
                        //perintah untuk menampilkan data ke form entri saat melakukan ubah data
                        if(@$_GET['aksi'] == 'ubah_produk') { 
                            $SQLTampilDataUbahproduk = mysqli_query($koneksi, "SELECT * FROM produk where idproduk = '".$_GET['vid_produk']."' "); 
                            $data_ubah_produk = mysqli_fetch_array($SQLTampilDataUbahproduk);
                        }
                    ?>
                    <form method="post" enctype="multipart/form-data" action="">

                        <input class="form-control" type="hidden" name="inputan_id_produk" value="<?= @$_GET['vid_produk'] ?>">
                        
                        <div class="row mb-2">
                            <label class="col-4">Nama produk</label>
                            <div class="col-8">
                                <input class="form-control" type="text" name="inputan_nama_produk" required value="<?= @$data_ubah_produk['nama_produk'] ?>">
                            </div>
                        </div>

                        <!-- Button atau tombol -->
                        <button name="tombol_simpan_produk" class="btn btn-success btn-block btn-lg"> <i class="fa fa-save"></i> Simpan</button>
                        <a href="index.php" class="btn btn-danger btn-block"><i class="fa fa-refresh fa-spin"></i> Muat Ulang</a>

                    </form>    
                </div>
            </div>
        </div>
        
        <!-- konten form data produk -->
        <div class="col-7">
            <div class="card">
                <div class="card-header bg-secondary text-white"><b>Tabel Data (produk)</b></div>
                <div class="card-body">
                    <table class="table table-bordered" id="tabel_data">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nama produk</th>
                                <th>Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; 
                                $SQLTampilDataproduk = mysqli_query($koneksi, "SELECT * FROM produk ORDER BY idproduk DESC");
                                while($data_produk = mysqli_fetch_array($SQLTampilDataproduk)) { ?>
                            <tr style="font-size: smaller;">
                                <td><?= $no++ ?></td>
                                <td><?= $data_produk['nama_produk'] ?></td>
                                <td>
                                    <a style="margin: 2px;" href="index.php?aksi=ubah_produk&vid_produk=<?= $data_produk['idproduk'] ?>" class="btn btn-success btn-sm"><i class="fa fa-edit"></i></a>
                                    <a style="margin: 2px;" onclick="return confirm('Yakin hapus ?')" href="index.php?aksi=hapus_produk&vid_produk=<?= $data_produk['idproduk'] ?>" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
      </div>
    </div>

    <!-- area halaman menu Customer -->
    <div id="customer" class="container tab-pane <?php echo ($_SESSION['active_tab'] == 'customer') ? 'active' : ''; ?>">
      <h3>CUSTOMER</h3>
      <p>Ini adalah menu untuk mengelola data CUSTOMER</p>
      <div class="row">
        <!-- konten form entri customer -->
        <div class="col-5">
            <div class="card">
                <div class="card-header bg-secondary text-white"><b>Form Entri (customer)</b></div>
                <div class="card-body">
                    <?php 
                        //perintah untuk menampilkan data ke form entri saat melakukan ubah data
                        if(@$_GET['aksi'] == 'ubah_customer') { 
                            $SQLTampilDataUbahcustomer = mysqli_query($koneksi, "SELECT * FROM customer where idcustomer = '".$_GET['vid_customer']."' "); 
                            $data_ubah_customer = mysqli_fetch_array($SQLTampilDataUbahcustomer);
                        }
                    ?>
                    <form method="post" enctype="multipart/form-data" action="">

                        <input class="form-control" type="hidden" name="inputan_id_customer" value="<?= @$_GET['vid_customer'] ?>">                    
                        
                        <?php if(empty($_GET['vid_customer'])){ ?> 
                            <center><i class="fa fa-user fa-5x mb-4"></i></center>
                        <?php } else { ?> 
                            <center><img src="<?= 'unggahan_foto/'.$data_ubah_customer['foto_customer'] ?>" class="mb-4" height="100%" width="100px" style="border: 2.5px solid grey;"></center>
                        <?php } ?>
                        

                        <div class="row mb-2">
                            <label class="col-4">Nama</label>
                            <div class="col-8">
                                <input class="form-control" type="text" name="inputan_nama_customer" required value="<?= @$data_ubah_customer['nama_customer'] ?>">
                            </div>
                        </div>

                        <div class="row mb-2">
                            <label class="col-4">Jenis Kelamin</label>
                            <div class="col-8">
                                <select class="form-control" name="inputan_jenis_kelamin_customer" required>
                                    <?php if(!empty(@$data_ubah_customer['jenis_kelaminr'])) { ?>
                                    <option value="<?= @$data_ubah_customer['jenis_kelamin'] ?>"><?= @$data_ubah_customer['jenis_kelamin'] ?></option>
                                    <?php } ?>
                                    <option value=""> -- Silahkan Pilih --</option>
                                    <option value="laki-laki">Laki - Laki</option>
                                    <option value="perempuan">Perempuan</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-2">
                            <label class="col-4">Alamat</label>
                            <div class="col-8">
                                <textarea class="form-control" name="inputan_alamat_customer" required><?= @$data_ubah_customer['alamat_customer'] ?></textarea>
                            </div>
                        </div>

                        <div class="row mb-2">
                            <label class="col-4">Foto customer</label>
                            <div class="col-8">
                                <input class="form-control" type="file" name="inputan_foto_customer">
                                <input class="form-control" type="hidden" name="nama_foto_tersimpan" value="<?= @$data_ubah_customer['foto_customer'] ?>">
                            </div>
                        </div>

                        <!-- Button atau tombol -->
                        <button name="tombol_simpan_customer" class="btn btn-success btn-block btn-lg"> <i class="fa fa-save"></i> Simpan</button>
                        <a href="index.php" class="btn btn-danger btn-block"><i class="fa fa-refresh fa-spin"></i> Muat Ulang</a>

                    </form>    
                </div>
            </div>
        </div>
        
        <!-- konten form data customer -->
        <div class="col-7">
            <div class="card">
                <div class="card-header bg-secondary text-white"><b>Tabel Data (customer)</b></div>
                <div class="card-body">
                    <table class="table table-bordered" id="tabel_data">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nama Customer</th>
                                <th>Jenis Kelamin</th>
                                <th>Alamat Customer</th>
                                <th>Foto customer</th>
                                <th>Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; 
                                $SQLTampilDatacustomer = mysqli_query($koneksi, "SELECT * FROM customer ORDER BY idcustomer DESC");
                                while($data_customer = mysqli_fetch_array($SQLTampilDatacustomer)) { ?>
                            <tr style="font-size: smaller;">
                                <td><?= $no++ ?></td>
                                <td><?= $data_customer['nama_customer'] ?></td>
                                <td><?= $data_customer['jenis_kelamin'] ?></td>
                                <td><?= $data_customer['alamat_customer'] ?></td>
                                <td>
                                    <img src="<?= 'unggahan_foto/'.$data_customer['foto_customer'] ?>" height="100%" width="50px" style="border: 2.5px solid grey;">
                                </td>
                                <td>
                                    <a style="margin: 2px;" href="index.php?aksi=ubah_customer&vid_customer=<?= $data_customer['idcustomer'] ?>" class="btn btn-success btn-sm"><i class="fa fa-edit"></i></a>
                                    <a style="margin: 2px;" onclick="return confirm('Yakin hapus ?')" href="index.php?aksi=hapus_customer&vid_customer=<?= $data_customer['idcustomer'] ?>&vfoto_customer=<?= $data_customer['foto_customer'] ?>" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
      </div>
    </div>

    <!-- area halaman menu master data 2 -->
    <div id="menu_cetak" class="container tab-pane <?php echo ($_SESSION['active_tab'] == 'menu_cetak') ? 'active' : ''; ?>">
      <h3>Halaman Laporan</h3>
      <p>Ini adalah halaman untuk mencetak laporan Penjualan.</p>
      <div class="row">
        <!-- konten form data customer -->
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-secondary text-white"><b>Pilihan Laporan</b></div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Nama Laporan</th>
                                <th></th>
                                <th>Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <form action="hal-cetak-laporan-jadwalkuliah.php" method="post" target="new">
                            <tr style="font-size: smaller;">
                                <td>1</td>
                                <td>Laporan Jadwal penjualan</td>
                                <td>
                                    <small><b>Tgl. Mulai</b></small>
                                    <input class="form-control" type="date" name="inputan_tgl_mulai" required>
                                    <small><b>Tgl. Selesai</b></small>
                                    <input class="form-control" type="date" name="inputan_tgl_selesai" required>
                                </td>
                                <td valign="middle">
                                    <button name="tombol_cetak" class="btn btn-success btn-block btn-lg"> <i class="fa fa-print"></i> Cetak</button>
                                </td>
                            </tr>
                            </form>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
      </div>
    </div>

  </div>
</div>

<!-- jQuery and Bootstrap JS -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<!-- fungsi Javascript / JS untuk menu tab-->
<script>
  $(document).ready(function(){
    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
      var target = $(e.target).attr("href") // activated tab
      sessionStorage.setItem('active_tab', target);
    });

    var activeTab = sessionStorage.getItem('active_tab');
    if(activeTab){
      $('.nav-tabs a[href="' + activeTab + '"]').tab('show');
    }
  });
</script>

<!-- area footer aplikasi-->
<footer class="mt-2 text-center text-muted">
  <div class="container">
    <hr style="border: dashed 2px;">
    <p style="margin: 0">&copy; <?= date('Y') ?> Pemrograman Web. SI - UMK.</p>
    <p>Designed with <i class="fa fa-heart"></i> by Zainur Romadhon</p>
  </div>
</footer>

</body>
</html>



<!-- membuat perintah eksekusi CRUD -->
<?php 
//========================================================================================= produk
//perintah simpan / tambah data
if(isset($_POST['tombol_simpan_produk']) and @$_GET['aksi'] == ''){
    //melakukan proses simpan data baru
    $query_simpan = mysqli_query($koneksi, "INSERT INTO produk (nama_produk) VALUES (
        '".$_POST['inputan_nama_produk']."'
    ) ");

    echo "<script>alert('Operasi berhasil')</script>";
    echo "<meta http-equiv='refresh' content='0; url=index.php'> ";
}

//perintah simpan ubah data
if(isset($_POST['tombol_simpan_produk']) and @$_GET['aksi'] == 'ubah_produk'){
    //melakukan proses simpan ubah data
    $query_simpan_ubah = mysqli_query($koneksi, "UPDATE produk SET 
        nama_produk = '".$_POST['inputan_nama_produk']."'
        WHERE idproduk = '".$_GET['vid_produk']."'
        ");

    echo "<script>alert('Operasi ubah data berhasil')</script>";
    echo "<meta http-equiv='refresh' content='0; url=index.php'> ";
}

//perintah hapus
if(@$_GET['aksi'] == 'hapus_produk'){
    //melakukan proses hapus data
    $query_hapus = mysqli_query($koneksi, "DELETE FROM produk where idproduk = '".$_GET['vid_produk']."' ");

    echo "<script>alert('Hapus berhasil')</script>";
    echo "<meta http-equiv='refresh' content='0; url=index.php'> ";
}
//========================================================================================= penjualan
//perintah simpan / tambah data
if(isset($_POST['tombol_simpan_penjualan']) and @$_GET['aksi'] == ''){
    //melakukan proses simpan data baru
    $query_simpan = mysqli_query($koneksi, "INSERT INTO penjualan (idcustomer,idproduk,tanggal_penjualan,harga,total_pesanan,total_harga,catatan) VALUES (
        '".$_POST['inputan_nama_customer']."',
        '".$_POST['inputan_nama_produk']."',
        '".$_POST['inputan_tanggal_penjualan']."',
        '".$_POST['inputan_harga']."',
        '".$_POST['inputan_total_pesanan']."',
        '".$_POST['inputan_total_harga']."',
        '".$_POST['inputan_catatan_penjualan']."'
    ) ");

    echo "<script>alert('Operasi berhasil')</script>";
    echo "<meta http-equiv='refresh' content='0; url=index.php'> ";
}

//perintah simpan ubah data
if(isset($_POST['tombol_simpan_penjualan']) and @$_GET['aksi'] == 'ubah_pejualan'){
    //melakukan proses simpan ubah data
    $totalharga = $_POST['inputan_harga'] * $_POST['inputan_total_pesanan'];
    $query_simpan_ubah = mysqli_query($koneksi, "UPDATE penjualan SET 
        nama_customer = '".$_POST['inputan_nama_customer']."',
        nama_produk = '".$_POST['inputan_nama_produk']."',
        tanggal_penjualan = '".$_POST['inputan_tanggal_penjualan']."',
        harga = '".$_POST['inputan_harga']."',
        total_pesanan = '".$_POST['inputan_total_pesanan']."',
        total_harga = '".$_POST['inputan_total_harga']."',
        catatan= '".$_POST['inputan_catatan_penjualan']."',
        WHERE idpenjualan = '".$_GET['vid_penjualan']."'
        ");

        // total harga = harga * total pesanan
        
    echo "<script>alert('Operasi ubah data berhasil')</script>";
    echo "<meta http-equiv='refresh' content='0; url=index.php'> ";
}

//perintah hapus
if(@$_GET['aksi'] == 'hapus_penjualan'){
    //melakukan proses hapus data
    $query_hapus = mysqli_query($koneksi, "DELETE FROM penjualan where idpenjualan = '".$_GET['vid_penjualan']."' ");

    echo "<script>alert('Hapus berhasil')</script>";
    echo "<meta http-equiv='refresh' content='0; url=index.php'> ";
}


//========================================================================================= customer
//perintah simpan / tambah data
if(isset($_POST['tombol_simpan_customer']) and @$_GET['aksi'] == ''){
    //periksa apakah file diunggah tanpa kesalahan
    if(isset($_FILES["inputan_foto_customer"]) && $_FILES["inputan_foto_customer"]["error"] == 0){
        $batas_ekstensi_file = array("jpg", "jpeg", "png");
        $file_pilihan = pathinfo($_FILES["inputan_foto_customer"]["name"], PATHINFO_EXTENSION);

        //periksa ekstensi file yang di izinkan upload
        if(in_array($file_pilihan, $batas_ekstensi_file)){
            //menentukan tempat menyimpan file
            $folder_simpan = "unggahan_foto/";

            //me-rename file supaya tidak ada nama file yang sama
            $nama_file_baru = uniqid().'.'.$file_pilihan;
            $target_file = $folder_simpan.$nama_file_baru;

            //memindahkan file yang diunggah ke lokasi yang ditentukan & melakukan proses simpan data baru
            if(move_uploaded_file($_FILES["inputan_foto_customer"]["tmp_name"], $target_file)){
                $query_simpan = mysqli_query($koneksi, "INSERT INTO customer (nama_customer, jenis_kelamin, alamat_customer, foto_customer) VALUES (
                    '".$_POST['inputan_nama_customer']."',
                    '".$_POST['inputan_jenis_kelamin_customer']."',
                    '".$_POST['inputan_alamat_customer']."',
                    '$nama_file_baru'
                    ) ");

                echo "<script>alert('Operasi berhasil.')</script>";
                echo "<meta http-equiv='refresh' content='0; url=index.php'> ";

            } else {
                echo "<script>alert('Maaf, terjadi kesalahan saat mengunggah file.')</script>";
            }
        } else {
            echo "<script>alert('Maaf, hanya file JPG, JPEG, dan PNG yang diperbolehkan.')</script>";
        }
    } else {
        //melakukan proses simpan data baru
        $query_simpan = mysqli_query($koneksi, "INSERT INTO customer (nama_customer, jenis_kelamin, alamat_customer, foto_customer) VALUES (
            '".$_POST['inputan_nama_customer']."',
            '".$_POST['inputan_jenis_kelamin_customer']."',
            '".$_POST['inputan_alamat_customer']."',
            ''
        ) ");
        
        echo "<script>alert('Operasi berhasil')</script>";
        echo "<meta http-equiv='refresh' content='0; url=index.php'> ";
    }

}

//perintah simpan ubah data
if(isset($_POST['tombol_simpan_customer']) and @$_GET['aksi'] == 'ubah_customer'){
    //periksa apakah file diunggah tanpa kesalahan
    if(isset($_FILES["inputan_foto_customer"]) && $_FILES["inputan_foto_customer"]["error"] == 0){
        $batas_ekstensi_file = array("jpg", "jpeg", "png");
        $file_pilihan = pathinfo($_FILES["inputan_foto_customer"]["name"], PATHINFO_EXTENSION);

        //periksa ekstensi file yang di izinkan upload
        if(in_array($file_pilihan, $batas_ekstensi_file)){
            //menentukan tempat menyimpan file
            $folder_simpan = "unggahan_foto/";

            //me-rename file supaya tidak ada nama file yang sama
            $nama_file_baru = uniqid().'.'.$file_pilihan;
            $target_file = $folder_simpan.$nama_file_baru;

            //memindahkan file yang diunggah ke lokasi yang ditentukan & melakukan proses simpan data baru
            if(move_uploaded_file($_FILES["inputan_foto_customer"]["tmp_name"], $target_file)){
                //menghapus file/gambar yang tersimpan di direktori/folder
                unlink('unggahan_foto/'.$_POST['nama_foto_tersimpan']);
                //melakukan proses simpan ubah data
                $query_simpan_ubah = mysqli_query($koneksi, "UPDATE customer SET 
                    nama_customer = '".$_POST['inputan_nama_customer']."',
                    jenis_kelamin = '".$_POST['inputan_jenis_kelamin_customer']."',
                    alamat_customer = '".$_POST['inputan_alamat_customer']."',
                    foto_customer = '$nama_file_baru'
                    WHERE idcustomer = '".$_GET['vid_customer']."'
                    ");

                echo "<script>alert('Operasi berhasil.')</script>";
                echo "<meta http-equiv='refresh' content='0; url=index.php'> ";

            } else {
                echo "<script>alert('Maaf, terjadi kesalahan saat mengunggah file.')</script>";
            }
        } else {
            echo "<script>alert('Maaf, hanya file JPG, JPEG, dan PNG yang diperbolehkan.')</script>";
        }
    } else {
        //melakukan proses simpan ubah data
        $query_simpan_ubah = mysqli_query($koneksi, "UPDATE customer SET 
            nama_customer = '".$_POST['inputan_nama_customer']."',
            jenis_kelamin = '".$_POST['inputan_jenis_kelamin_customer']."',
            alamat_customer = '".$_POST['inputan_alamat_customer']."',
            foto_customer = '".$_POST['nama_foto_tersimpan']."'
            WHERE idcustomer = '".$_GET['vid_customer']."'
        ");
        
        echo "<script>alert('Operasi berhasil')</script>";
        echo "<meta http-equiv='refresh' content='0; url=index.php'> ";
    }
}

//perintah hapus
if(@$_GET['aksi'] == 'hapus_customer'){
    //melakukan proses hapus data
    $query_hapus = mysqli_query($koneksi, "DELETE FROM customer where idcustomer = '".$_GET['vid_customer']."' ");
    //menghapus file/gambar yang tersimpan di direktori/folder
    unlink('unggahan_foto/'.$_GET['vfoto_customer']);

    echo "<script>alert('Hapus berhasil')</script>";
    echo "<meta http-equiv='refresh' content='0; url=index.php'> ";
}


?>

<!--

NIM     : silahkan isi .............
Nama    : silahkan isi .............
Kelas   : silahkan isi .............

=========================================
Program Studi Sistem Informasi UMK # 2024
=========================================

-->