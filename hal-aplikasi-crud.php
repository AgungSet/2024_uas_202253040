<!-- membuat koneksi database -->
<?php
    $koneksi = mysqli_connect('localhost','root','','penjualan_uaspw') or die('koneksi gagal');  
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Aplikasi CRUD (penjualan)</title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <!-- Komponen FontAwesome -->
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
  <!-- memasukkan/import Google Font ke halaman web-->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Sofia">
</head>
<body>

<!-- nama aplikasi -->
<center class="m-3"><h1 style="font-family: 'Sofia', sans-serif; color: green; font-weight: bold;"><i class="fa fa-clone"></i> Aplikasi CRUD (penjualan)</h1></center>

<!-- menu tab aplikasi -->
<div class="container mt-5">
  <ul class="nav nav-tabs">
        <!-- <li class="nav-item">
        <a class="nav-link <?php echo ($_SESSION['active_tab'] == 'beranda' || !isset($_SESSION['active_tab'])) ? 'active' : ''; ?>" data-toggle="tab" href="#beranda">Beranda</a>
        </li> -->
    <li class="nav-item">
      <a class="nav-link <?php echo ($_SESSION['active_tab'] == 'menu1') ? 'active' : ''; ?>" data-toggle="tab" href="#menu1">Kelola produk</a>
    </li>
    <li class="nav-item">
      <a class="nav-link <?php echo ($_SESSION['active_tab'] == 'menu2') ? 'active' : ''; ?>" data-toggle="tab" href="#menu2">Kelola Customer</a>
    </li>
    <li class="nav-item">
      <a class="nav-link <?php echo ($_SESSION['active_tab'] == 'menu_cetak') ? 'active' : ''; ?>" data-toggle="tab" href="#menu_cetak">Laporan</a>
    </li>
  </ul>

  <!-- konten menu tab aplikasi -->
  <div class="tab-content mt-2">
    <!-- area halaman beranda -->


    <!-- fungsi pencarian untuk tabel data jadwal kuliah dengan Javascript / JS -->
    <script>
        function pencarianData() {
          var input, filter, table, tr, td, i, txtValue;
          input = document.getElementById("pencarian_data");
          filter = input.value.toUpperCase();
          table = document.getElementById("tabel_data");
          tr = table.getElementsByTagName("tr");

          for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[3]; // Adjust index based on the column you want to search
            if (td) {
              txtValue = td.textContent || td.innerText;
              if (txtValue.toUpperCase().indexOf(filter) > -1) {
                tr[i].style.display = "";
              } else {
                tr[i].style.display = "none";
              }
            }
          }
        }
    </script>

    <!-- area halaman menu master data 1 -->
    <div id="menu1" class="container tab-pane <?php echo ($_SESSION['active_tab'] == 'menu1') ? 'active' : ''; ?>">
      <h3>Menu Master Data 1</h3>
      <p>Ini adalah menu untuk mengelola data produk.</p>
      <div class="row">
        <!-- konten form entri produk -->
        <div class="col-5">
            <div class="card">
                <div class="card-header bg-secondary text-white"><b>Form Entri (produk)</b></div>
                <div class="card-body">
                    <?php 
                        //perintah untuk menampilkan data ke form entri saat melakukan ubah data
                        if(@$_GET['aksi'] == 'ubah_produk') { 
                            $SQLTampilDataUbahproduk = mysqli_query($koneksi, "SELECT * FROM produk where idproduk = '".$_GET['vidproduk']."' "); 
                            $data_ubah_produk = mysqli_fetch_array($SQLTampilDataUbahproduk);
                        }
                    ?>
                    <form method="post" enctype="multipart/form-data" action="">

                        <input class="form-control" type="hidden" name="inputan_id_produk" value="<?= @$_GET['vidproduk'] ?>">
                        
                        <div class="row mb-2">
                            <label class="col-4">Nama produk</label>
                            <div class="col-8">
                                <input class="form-control" type="text" name="inputan_produk" required value="<?= @$data_ubah_produk['produk'] ?>">
                            </div>
                        </div>

                        <!-- Button atau tombol -->
                        <button name="tombol_simpan_produk" class="btn btn-success btn-block btn-lg"> <i class="fa fa-save"></i> Simpan</button>
                        <a href="hal-aplikasi-crud.php" class="btn btn-danger btn-block"><i class="fa fa-refresh fa-spin"></i> Muat Ulang</a>

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
                                $SQLTampilDataproduk = mysqli_query($koneksi, "SELECT * FROM produk ORDER BY id_produk DESC");
                                while($data_produk = mysqli_fetch_array($SQLTampilDataproduk)) { ?>
                            <tr style="font-size: smaller;">
                                <td><?= $no++ ?></td>
                                <td><?= $data_matakuliah['produk'] ?></td>
                                <td>
                                    <a style="margin: 2px;" href="hal-aplikasi-crud.php?aksi=ubah_produk&vidproduk=<?= $data_produk['idproduk'] ?>" class="btn btn-success btn-sm"><i class="fa fa-edit"></i></a>
                                    <a style="margin: 2px;" onclick="return confirm('Yakin hapus ?')" href="hal-aplikasi-crud.php?aksi=hapus_produk&vidproduk=<?= $data_produk['idproduk'] ?>" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>
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
    <div id="menu2" class="container tab-pane <?php echo ($_SESSION['active_tab'] == 'menu2') ? 'active' : ''; ?>">
      <h3>Menu Master Data 2</h3>
      <p>Ini adalah menu untuk mengelola data Customer.</p>
      <div class="row">
        <!-- konten form entri customer -->
        <div class="col-5">
            <div class="card">
                <div class="card-header bg-secondary text-white"><b>Form Entri (customer)</b></div>
                <div class="card-body">
                    <?php 
                        //perintah untuk menampilkan data ke form entri saat melakukan ubah data
                        if(@$_GET['aksi'] == 'ubah_customer') { 
                            $SQLTampilDataUbahDosen = mysqli_query($koneksi, "SELECT * FROM customer where idcustomer = '".$_GET['vidcustomer']."' "); 
                            $data_ubah_customer = mysqli_fetch_array($SQLTampilDataUbahcustomer);
                        }
                    ?>
                    <form method="post" enctype="multipart/form-data" action="">

                        <input class="form-control" type="hidden" name="inputan_idcustomer" value="<?= @$_GET['vidcustomer'] ?>">                    
                        
                        <?php if(empty($_GET['vidcustomer'])){ ?> 
                            <center><i class="fa fa-user fa-5x mb-4"></i></center>
                        <?php } else { ?> 
                            <center><img src="<?= 'unggahan_foto/'.$data_ubah_dosen['foto_customer'] ?>" class="mb-4" height="100%" width="100px" style="border: 2.5px solid grey;"></center>
                        <?php } ?>
                        
                        <div class="row mb-2">
                            <label class="col-4">Nama</label>
                            <div class="col-8">
                                <input class="form-control" type="text" name="inputan_nama_customer" required value="<?= @$data_ubah_dosen['namacustomer'] ?>">
                            </div>
                        </div>
                        <div class="row mb-2">
                            <label class="col-4">Informasi</label>
                            <div class="col-8">
                                <textarea class="form-control" name="inputan_info_customer" required><?= @$data_ubah_customer['info_customer'] ?></textarea>
                            </div>
                        </div>

                        <div class="row mb-2">
                            <label class="col-4">Jenis Kelamin</label>
                            <div class="col-8">
                                <select class="form-control" name="inputan_jk_customer" required>
                                    <?php if(!empty(@$data_ubah_customer['jk_customer'])) { ?>
                                    <option value="<?= @$data_ubah_customer['jk_customer'] ?>"><?= @$data_ubah_customer['jk_customer'] ?></option>
                                    <?php } ?>
                                    <option value=""> -- Silahkan Pilih --</option>
                                    <option value="laki-laki">laki - laki</option>
                                    <option value="perempuan">perempuan</option>
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
                            <label class="col-4">Foto Customer</label>
                            <div class="col-8">
                                <input class="form-control" type="file" name="inputan_foto_customer">
                                <input class="form-control" type="hidden" name="nama_foto_tersimpan" value="<?= @$data_ubah_customer['foto_customer'] ?>">
                            </div>
                        </div>

                        <!-- Button atau tombol -->
                        <button name="tombol_simpan_customer" class="btn btn-success btn-block btn-lg"> <i class="fa fa-save"></i> Simpan</button>
                        <a href="hal-aplikasi-crud.php" class="btn btn-danger btn-block"><i class="fa fa-refresh fa-spin"></i> Muat Ulang</a>

                    </form>    
                </div>
            </div>
        </div>
        
        <!-- konten form data dosen -->
        <div class="col-7">
            <div class="card">
                <div class="card-header bg-secondary text-white"><b>Tabel Data (customer)</b></div>
                <div class="card-body">
                    <table class="table table-bordered" id="tabel_data">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>id / Nama customer</th>
                                <th>Informasi customer</th>
                                <th>Foto customer</th>
                                <th>Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; 
                                $SQLTampilDatacustomerustomer = mysqli_query($koneksi, "SELECT * FROM customer ORDER BY idcustomer DESC");
                                while($data_ubah_customer = mysqli_fetch_array($SQLTampilDatacustomer)) { ?>
                            <tr style="font-size: smaller;">
                                <td><?= $no++ ?></td>
                                
                                <td>
                                    <a style="margin: 2px;" href="hal-aplikasi-crud.php?aksi=ubah_customer&vid_customer=<?= $data_dosen['id_customer'] ?>" class="btn btn-success btn-sm"><i class="fa fa-edit"></i></a>
                                    <a style="margin: 2px;" onclick="return confirm('Yakin hapus ?')" href="hal-aplikasi-crud.php?aksi=hapus_customer&vid_customer=<?= $data_dosen['id_customer'] ?>&vfoto_customer=<?= $data_customer['foto_customer'] ?>" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>
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
      <p>Ini adalah halaman untuk mencetak laporan penjualan.</p>
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
                                <td>Laporan penjualan</td>
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
//========================================================================================= MATAKULIAH
//perintah simpan / tambah data
if(isset($_POST['tombol_simpan_matakuliah']) and @$_GET['aksi'] == ''){
    //melakukan proses simpan data baru
    $query_simpan = mysqli_query($koneksi, "INSERT INTO mata_kuliah (id_matakuliah, mata_kuliah) VALUES (
        '',
        '".$_POST['inputan_mata_kuliah']."'
    ) ");

    echo "<script>alert('Operasi berhasil')</script>";
    echo "<meta http-equiv='refresh' content='0; url=hal-aplikasi-crud.php'> ";
}

//perintah simpan ubah data
if(isset($_POST['tombol_simpan_matakuliah']) and @$_GET['aksi'] == 'ubah_matakuliah'){
    //melakukan proses simpan ubah data
    $query_simpan_ubah = mysqli_query($koneksi, "UPDATE mata_kuliah SET 
        mata_kuliah = '".$_POST['inputan_mata_kuliah']."'
        WHERE id_matakuliah = '".$_GET['vid_matakuliah']."'
        ");

    echo "<script>alert('Operasi ubah data berhasil')</script>";
    echo "<meta http-equiv='refresh' content='0; url=hal-aplikasi-crud.php'> ";
}

//perintah hapus
if(@$_GET['aksi'] == 'hapus_matakuliah'){
    //melakukan proses hapus data
    $query_hapus = mysqli_query($koneksi, "DELETE FROM mata_kuliah where id_matakuliah = '".$_GET['vid_matakuliah']."' ");

    echo "<script>alert('Hapus berhasil')</script>";
    echo "<meta http-equiv='refresh' content='0; url=hal-aplikasi-crud.php'> ";
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
                $query_simpan = mysqli_query($koneksi, "INSERT INTO customer (id_customer, info_cutomer, namacustomer, jk_customer, alamat_customer, foto_customer) VALUES (
                    '',
                    '".$_POST['inputan_info_customer']."',
                    '".$_POST['inputan_nama_customer']."',
                    '".$_POST['inputan_jk_customer']."',
                    '".$_POST['inputan_alamat_alamat']."',
                    '$nama_file_baru'
                    ) ");

                echo "<script>alert('Operasi berhasil.')</script>";
                echo "<meta http-equiv='refresh' content='0; url=hal-aplikasi-crud.php'> ";

            } else {
                echo "<script>alert('Maaf, terjadi kesalahan saat mengunggah file.')</script>";
            }
        } else {
            echo "<script>alert('Maaf, hanya file JPG, JPEG, dan PNG yang diperbolehkan.')</script>";
        }
    } else {
        //melakukan proses simpan data baru
        $query_simpan = mysqli_query($koneksi, "INSERT INTO customer (id_customer, info_cutomer, namacustomer, jk_customer, alamat_customer, foto_customer) VALUES (
            '',
            '".$_POST['inputan_info_customer']."',
            '".$_POST['inputan_nama_customer']."',
            '".$_POST['inputan_jk_customer']."',
            '".$_POST['inputan_alamat_alamat']."',
            '$nama_file_baru'
            ) ");
        
        echo "<script>alert('Operasi berhasil')</script>";
        echo "<meta http-equiv='refresh' content='0; url=hal-aplikasi-crud.php'> ";
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
                    info_customer = '".$_POST['inputan_info_customer']."',
                    namacustomer = '".$_POST['inputan_nama_customer']."',
                    jk_customer = '".$_POST['inputan_jk_customer']."',
                    alamat_customer = '".$_POST['inputan_alamat_customer']."',
                    foto_customer = '$nama_file_baru'
                    WHERE idcustomer = '".$_GET['vid_customer']."'
                    ");

                echo "<script>alert('Operasi berhasil.')</script>";
                echo "<meta http-equiv='refresh' content='0; url=hal-aplikasi-crud.php'> ";

            } else {
                echo "<script>alert('Maaf, terjadi kesalahan saat mengunggah file.')</script>";
            }
        } else {
            echo "<script>alert('Maaf, hanya file JPG, JPEG, dan PNG yang diperbolehkan.')</script>";
        }
    } else {
        //melakukan proses simpan ubah data
        $query_simpan_ubah = mysqli_query($koneksi, "UPDATE customer SET 
            info_customer = '".$_POST['inputan_nidn_customer']."',
            namacustomer= '".$_POST['inputan_nama_customer']."',
            jk_customer = '".$_POST['inputan_jk_customer']."',
            alamat_customer = '".$_POST['inputan_alamat_customer']."',
            foto_customer = '".$_POST['nama_foto_tersimpan']."'
            WHERE idcustomer = '".$_GET['vid_customer']."'
        ");
        
        echo "<script>alert('Operasi berhasil')</script>";
        echo "<meta http-equiv='refresh' content='0; url=hal-aplikasi-crud.php'> ";
    }
}

//perintah hapus
if(@$_GET['aksi'] == 'hapus_customer'){
    //melakukan proses hapus data
    $query_hapus = mysqli_query($koneksi, "DELETE FROM customerwhere idcustomer = '".$_GET['vid_customer']."' ");
    //menghapus file/gambar yang tersimpan di direktori/folder
    unlink('unggahan_foto/'.$_GET['vfoto_customer']);

    echo "<script>alert('Hapus berhasil')</script>";
    echo "<meta http-equiv='refresh' content='0; url=hal-aplikasi-crud.php'> ";
}


//========================================================================================= JADWAL KULIAH
//perintah simpan / tambah data
if(isset($_POST['tombol_simpan_jadwal']) and @$_GET['aksi'] == ''){
    //melakukan proses simpan data baru
    $jam_mulai_selesai_kuliah = $_POST['inputan_jam_mulai'].' sampai '.$_POST['inputan_jam_selesai'];
    
    $query_simpan = mysqli_query($koneksi, "INSERT INTO jadwal_kuliah (id_jadwalkuliah, tanggal_entri, hari_kuliah, jam_kuliah, tempat_kuliah, id_matakuliah, id_dosen) VALUES (
        '',
        '".$_POST['inputan_tanggal_entri']."',
        '".$_POST['inputan_hari_kuliah']."',
        '$jam_mulai_selesai_kuliah',
        '".$_POST['inputan_tempat_kuliah']."',
        '".$_POST['inputan_pilih_matkul']."',
        '".$_POST['inputan_pilih_dosen']."'
    ) ");

    echo "<script>alert('Operasi berhasil')</script>";
    echo "<meta http-equiv='refresh' content='0; url=hal-aplikasi-crud.php'> ";
}

//perintah simpan ubah data
if(isset($_POST['tombol_simpan_jadwal']) and @$_GET['aksi'] == 'ubah_jadwal'){
    //melakukan proses simpan ubah data
    $jam_mulai_selesai_kuliah = $_POST['inputan_jam_mulai'].' sampai '.$_POST['inputan_jam_selesai'];

    $query_simpan_ubah = mysqli_query($koneksi, "UPDATE jadwal_kuliah SET 
        tanggal_entri = '".$_POST['inputan_tanggal_entri']."',
        hari_kuliah = '".$_POST['inputan_hari_kuliah']."',
        jam_kuliah = '$jam_mulai_selesai_kuliah',
        tempat_kuliah = '".$_POST['inputan_tempat_kuliah']."',
        id_matakuliah = '".$_POST['inputan_pilih_matkul']."',
        id_dosen = '".$_POST['inputan_pilih_dosen']."'
        WHERE id_jadwalkuliah = '".$_GET['vid_jadwalkuliah']."'
    ");

    echo "<script>alert('Operasi ubah data berhasil')</script>";
    echo "<meta http-equiv='refresh' content='0; url=hal-aplikasi-crud.php'> ";
}

//perintah hapus
if(@$_GET['aksi'] == 'hapus_jadwal'){
    //melakukan proses hapus data
    $query_hapus = mysqli_query($koneksi, "DELETE FROM jadwal_kuliah where id_jadwalkuliah = '".$_GET['vid_jadwalkuliah']."' ");

    echo "<script>alert('Hapus berhasil')</script>";
    echo "<meta http-equiv='refresh' content='0; url=hal-aplikasi-crud.php'> ";
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