<!-- membuat koneksi database -->
<?php
    $koneksi = mysqli_connect('localhost','root','','2024_uas_202253040') or die('koneksi gagal');  
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
<center class="m-3"><h1 style="font-family: 'Sofia', sans-serif; color: red; font-weight: bold;"><i class="fa fa-clone"></i> Aplikasi CRUD (Penjualan)</h1></center>

<!-- menu tab aplikasi -->
<div class="container mt-5">
  <ul class="nav nav-tabs">
    <li class="nav-item">
      <a class="nav-link <?php echo ($_SESSION['active_tab'] == 'beranda' || !isset($_SESSION['active_tab'])) ? 'active' : ''; ?>" data-toggle="tab" href="#beranda">Beranda</a>
    </li>
    <li class="nav-item">
      <a class="nav-link <?php echo ($_SESSION['active_tab'] == 'menu1') ? 'active' : ''; ?>" data-toggle="tab" href="#menu1">Kelola Produk</a>
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
    <div id="beranda" class="container tab-pane <?php echo ($_SESSION['active_tab'] == 'beranda' || !isset($_SESSION['active_tab'])) ? 'active' : ''; ?>">
      <h3>Beranda</h3>
      <p>Halaman beranda aplikasi CRUD.</p>
      <div class="row">
        <!-- konten form entri penjualan -->
        <div class="col-5">
            <div class="card">
                <div class="card-header bg-secondary text-white"><b>Form Entri (penjualan)</b></div>
                <div class="card-body">
                    <?php 
                        //perintah untuk menampilkan data ke form entri saat melakukan ubah data
                        if(@$_GET['aksi'] == 'ubah_jadwal') { 
                            $SQLTampilDataUbahJadwal = mysqli_query($koneksi, "SELECT * FROM jadwal_kuliah, dosen, mata_kuliah where jadwal_kuliah.id_dosen = dosen.id_dosen and jadwal_kuliah.id_matakuliah = mata_kuliah.id_matakuliah and id_jadwalkuliah = '".$_GET['vid_jadwalkuliah']."' "); 
                            $data_ubah_jadwal = mysqli_fetch_array($SQLTampilDataUbahJadwal);
                        }
                    ?>
                    <form method="post" enctype="multipart/form-data" action="">

                        <input class="form-control" type="hidden" name="inputan_id_jadwalkuliah" value="<?= @$_GET['vid_dosen'] ?>">                    
                        

                
                    <?php
                        date_default_timezone_set("Asia/jakarta");
                    ?>
                    <p>Jam Pembelian &emsp; &emsp; <b><span id="jam" style="font-size:24"></span></b></p>
                    <script type="text/javascript">
                        window.onload = function() { jam(); }
                    
                        function jam() {
                            var e = document.getElementById('jam'),
                            d = new Date(), h, m;
                            h = d.getHours();
                            m = set(d.getMinutes());
                    
                            e.innerHTML = h +':'+ m ;
                    
                            setTimeout('jam()', 1000);
                        }
                    
                        function set(e) {
                            e = e < 10 ? '0'+ e : e;
                            return e;
                        }
                    </script>
               
                        
                        <div class="row mb-2">
                            <label class="col-4">Nama Customer</label>
                            <div class="col-8">
                                <select class="form-control" name="inputan_pilih_customer" required>
                                    <?php if(!empty(@$data_ubah_jadwal['id'])) { ?>
                                    <option value="<?= @$data_ubah_jadwal['id'] ?>"><?= @$data_ubah_jadwal['nama'] ?></option>
                                    <?php } ?>
                                    
                                    <option value=""> -- Silahkan Pilih --</option>
                                    <?php $SQLTampilDatacustomer = mysqli_query($koneksi, "SELECT * FROM customer ORDER BY id DESC");
                                        while($data_customer = mysqli_fetch_array($SQLTampilDataDosen)) { ?>
                                    <option value="<?= $data_customer['id'] ?>"><?= $data_customer['nama'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-2">
                            <label class="col-4">Nama Produk</label>
                            <div class="col-8">
                                <select class="form-control" name="inputan_pilih_matkul" required>
                                    <?php if(!empty(@$data_ubah_jadwal['id_matakuliah'])) { ?>
                                    <option value="<?= @$data_ubah_jadwal['id_matakuliah'] ?>"><?= @$data_ubah_jadwal['mata_kuliah']?></option>
                                    <?php } ?>
                                    
                                    <option value=""> -- Silahkan Pilih --</option>
                                    <?php $SQLTampilDataMatkul = mysqli_query($koneksi, "SELECT * FROM mata_kuliah ORDER BY id_matakuliah DESC");
                                        while($data_matakuliah = mysqli_fetch_array($SQLTampilDataMatkul)) { ?>
                                    <option value="<?= $data_matakuliah['id_matakuliah'] ?>"><?= $data_matakuliah['mata_kuliah'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <label class="col-4">Harga</label>
                            <div class="col-8">
                                <input class="form-control" type="number" name="inputan_harga" required<?= @$data_ubah_jadwal['Harga'] ?>>
                            </div>
                            <label class="col-4">Total Pesanan</label>
                            <div class="col-8">
                                <input class="form-control" type="number" name="inputan_totalpesanan" required<?= @$data_ubah_jadwal['totalpesanan'] ?>>
                            </div>
                            <label class="col-4">Total Harga</label>
                            <div class="col-8">
                                <input class="form-control" type="number" name="inputan_totalharga" required<?= @$data_ubah_jadwal['totalharga'] ?>>
                            </div>
                            <label class="col-4">Catatan</label>
                            <div class="col-8">
                                <textarea class="form-control" name="inputan_catatan" required><?= @$data_ubah_jadwal['tempat_kuliah'] ?></textarea>
                            </div>

                        <!-- Button atau tombol -->

                        <button name="tombol_simpan_jadwal" class="btn btn-success btn-block btn-lg"> <i class="fa fa-save"></i> Simpan</button>
                        <a href="" class="btn btn-danger btn-block"><i class="fa fa-refresh fa-spin"></i> Muat Ulang</a>

                    </form>    
                </div>
            </div>
        </div>

        <!-- konten form data jadwal kuliah -->
        <div class="col-7">
            <div class="card">
                <div class="card-header bg-secondary text-white"><b>Tabel Data (penjualan)</b></div>
                <div class="card-body">
                    <input class="form-control mb-2" type="text" id="pencarian_data" onkeyup="pencarianData()" placeholder="Pencarian (Mata Kuliah) ..">
                    <table class="table table-bordered" id="tabel_data">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nama Customer</th>
                                <th>Nama Produk</th>
                                <th>Harga</th>
                                <th>Total Pesanan</th>
                                <th>Total Harga</th>
                                <th>Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; 
                                $SQLTampilDataJadwal = mysqli_query($koneksi, "SELECT penjualan.*, customer.nama as namacustomer FROM penjualan JOIN customer ON penjualan.idcustomer = customer.id_customer ORDER BY id DESC");
                                while($data_jadwal = mysqli_fetch_array($SQLTampilDataJadwal)) { ?>
                            <tr style="font-size: smaller;">
                                <td><?= $no++ ?></td>
                             
                                <td><?= $data_jadwal['namacustomer']?></td>
                                <td><?= $data_jadwal['namaproduk']?></td>
                                <td><?= $data_jadwal['harga']?></td>
                                <td><?= $data_jadwal['totalpesanan']?></td>
                                <td><?= $data_jadwal['totalharga']?></td>
                                <td>
                                    <a style="margin: 2px;" href="hal-aplikasi-crud.php?aksi=ubah_penjualan&vid=<?= $data_jadwal['id'] ?>" class="btn btn-success btn-sm"><i class="fa fa-edit"></i></a>
                                    <a style="margin: 2px;" onclick="return confirm('Yakin hapus ?')" href="hal-aplikasi-crud.php?aksi=hapus_penjualan&vid=<?= $data_jadwal['id'] ?>" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>
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
      <p>Ini adalah menu untuk mengelola data Produk.</p>
      <div class="row">
        <!-- konten form entri matakuliah -->
        <div class="col-5">
            <div class="card">
                <div class="card-header bg-secondary text-white"><b>Form Entri (Produk)</b></div>
                <div class="card-body">
                    <?php 
                        //perintah untuk menampilkan data ke form entri saat melakukan ubah data
                        if(@$_GET['aksi'] == 'ubah_matakuliah') { 
                            $SQLTampilDataUbahMatakuliah = mysqli_query($koneksi, "SELECT * FROM mata_kuliah where id_matakuliah = '".$_GET['vid_matakuliah']."' "); 
                            $data_ubah_matakuliah = mysqli_fetch_array($SQLTampilDataUbahMatakuliah);
                        }
                    ?>
                    <form method="post" enctype="multipart/form-data" action="">

                        <input class="form-control" type="hidden" name="inputan_id_matakuliah" value="<?= @$_GET['vid_matakuliah'] ?>">
                        
                        <div class="row mb-2">
                            <label class="col-4">Nama Produk</label>
                            <div class="col-8">
                                <input class="form-control" type="text" name="inputan_mata_kuliah" required value="<?= @$data_ubah_matakuliah['mata_kuliah'] ?>">
                            </div>
                        </div>

                        <!-- Button atau tombol -->
                        <button name="tombol_simpan_matakuliah" class="btn btn-success btn-block btn-lg"> <i class="fa fa-save"></i> Simpan</button>
                        <a href="hal-aplikasi-crud.php" class="btn btn-danger btn-block"><i class="fa fa-refresh fa-spin"></i> Muat Ulang</a>

                    </form>    
                </div>
            </div>
        </div>
        
        <!-- konten form data matakuliah -->
        <div class="col-7">
            <div class="card">
                <div class="card-header bg-secondary text-white"><b>Tabel Data (Produk)</b></div>
                <div class="card-body">
                    <table class="table table-bordered" id="tabel_data">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nama Produk</th>
                                <th>Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; 
                                $SQLTampilDatamatakuliah = mysqli_query($koneksi, "SELECT * FROM mata_kuliah ORDER BY id_matakuliah DESC");
                                while($data_matakuliah = mysqli_fetch_array($SQLTampilDatamatakuliah)) { ?>
                            <tr style="font-size: smaller;">
                                <td><?= $no++ ?></td>
                                <td><?= $data_matakuliah['mata_kuliah'] ?></td>
                                <td>
                                    <a style="margin: 2px;" href="hal-aplikasi-crud.php?aksi=ubah_matakuliah&vid_matakuliah=<?= $data_matakuliah['id_matakuliah'] ?>" class="btn btn-success btn-sm"><i class="fa fa-edit"></i></a>
                                    <a style="margin: 2px;" onclick="return confirm('Yakin hapus ?')" href="hal-aplikasi-crud.php?aksi=hapus_matakuliah&vid_matakuliah=<?= $data_matakuliah['id_matakuliah'] ?>" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>
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
                <div class="card-header bg-secondary text-white"><b>Form Entri (Customer)</b></div>
                <div class="card-body">
                    <?php 
                        //perintah untuk menampilkan data ke form entri saat melakukan ubah data
                        if(@$_GET['aksi'] == 'ubah_dosen') { 
                            $SQLTampilDataUbahDosen = mysqli_query($koneksi, "SELECT * FROM dosen where id_dosen = '".$_GET['vid_dosen']."' "); 
                            $data_ubah_dosen = mysqli_fetch_array($SQLTampilDataUbahDosen);
                        }
                    ?>
                    <form method="post" enctype="multipart/form-data" action="">

                        <input class="form-control" type="hidden" name="inputan_id_dosen" value="<?= @$_GET['vid_dosen'] ?>">                    
                        
                        <?php if(empty($_GET['vid_dosen'])){ ?> 
                            <center><i class="fa fa-user fa-5x mb-4"></i></center>
                        <?php } else { ?> 
                            <center><img src="<?= 'unggahan_foto/'.$data_ubah_dosen['foto_dosen'] ?>" class="mb-4" height="100%" width="100px" style="border: 2.5px solid grey;"></center>
                        <?php } ?>
                        
                        <div class="row mb-2">
                            <label class="col-4">id</label>
                            <div class="col-8">
                                <input class="form-control" type="number" name="inputan_nidn_dosen" required value="<?= @$data_ubah_dosen['nidn_dosen'] ?>">
                            </div>
                        </div>
                        <div class="row mb-2">
                            <label class="col-4">Nama</label>
                            <div class="col-8">
                                <input class="form-control" type="text" name="inputan_nama_dosen" required value="<?= @$data_ubah_dosen['nama_dosen'] ?>">
                            </div>
                        </div>

                        <div class="row mb-2">
                            <label class="col-4">Jenis Kelamin</label>
                            <div class="col-8">
                                <select class="form-control" name="inputan_jk_dosen" required>
                                    <?php if(!empty(@$data_ubah_dosen['jk_dosen'])) { ?>
                                    <option value="<?= @$data_ubah_dosen['jk_dosen'] ?>"><?= @$data_ubah_dosen['jk_dosen'] ?></option>
                                    <?php } ?>
                                    <option value=""> -- Silahkan Pilih --</option>
                                    <option value="Pria">Pria</option>
                                    <option value="Wanita">Wanita</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-2">
                            <label class="col-4">Alamat</label>
                            <div class="col-8">
                                <textarea class="form-control" name="inputan_alamat_dosen" required><?= @$data_ubah_dosen['alamat_dosen'] ?></textarea>
                            </div>
                        </div>

                        <div class="row mb-2">
                            <label class="col-4">Foto Dosen</label>
                            <div class="col-8">
                                <input class="form-control" type="file" name="inputan_foto_dosen">
                                <input class="form-control" type="hidden" name="nama_foto_tersimpan" value="<?= @$data_ubah_dosen['foto_dosen'] ?>">
                            </div>
                        </div>

                        <!-- Button atau tombol -->
                        <button name="tombol_simpan_dosen" class="btn btn-success btn-block btn-lg"> <i class="fa fa-save"></i> Simpan</button>
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
                                $SQLTampilDataDosen = mysqli_query($koneksi, "SELECT * FROM dosen ORDER BY id_dosen DESC");
                                while($data_dosen = mysqli_fetch_array($SQLTampilDataDosen)) { ?>
                            <tr style="font-size: smaller;">
                                <td><?= $no++ ?></td>
                                <td><?= $data_dosen['nidn_dosen'].' <br> '.$data_dosen['nama_dosen'] ?></td>
                                <td><?= $data_dosen['jk_dosen'].', alamat : '.$data_dosen['alamat_dosen'] ?></td>
                                <td>
                                    <img src="<?= 'unggahan_foto/'.$data_dosen['foto_dosen'] ?>" height="100%" width="50px" style="border: 2.5px solid grey;">
                                </td>
                                <td>
                                    <a style="margin: 2px;" href="hal-aplikasi-crud.php?aksi=ubah_dosen&vid_dosen=<?= $data_dosen['id_dosen'] ?>" class="btn btn-success btn-sm"><i class="fa fa-edit"></i></a>
                                    <a style="margin: 2px;" onclick="return confirm('Yakin hapus ?')" href="hal-aplikasi-crud.php?aksi=hapus_dosen&vid_dosen=<?= $data_dosen['id_dosen'] ?>&vfoto_dosen=<?= $data_dosen['foto_dosen'] ?>" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>
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
        <!-- konten form data dosen -->
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


//========================================================================================= DOSEN
//perintah simpan / tambah data
if(isset($_POST['tombol_simpan_dosen']) and @$_GET['aksi'] == ''){
    //periksa apakah file diunggah tanpa kesalahan
    if(isset($_FILES["inputan_foto_dosen"]) && $_FILES["inputan_foto_dosen"]["error"] == 0){
        $batas_ekstensi_file = array("jpg", "jpeg", "png");
        $file_pilihan = pathinfo($_FILES["inputan_foto_dosen"]["name"], PATHINFO_EXTENSION);

        //periksa ekstensi file yang di izinkan upload
        if(in_array($file_pilihan, $batas_ekstensi_file)){
            //menentukan tempat menyimpan file
            $folder_simpan = "unggahan_foto/";

            //me-rename file supaya tidak ada nama file yang sama
            $nama_file_baru = uniqid().'.'.$file_pilihan;
            $target_file = $folder_simpan.$nama_file_baru;

            //memindahkan file yang diunggah ke lokasi yang ditentukan & melakukan proses simpan data baru
            if(move_uploaded_file($_FILES["inputan_foto_dosen"]["tmp_name"], $target_file)){
                $query_simpan = mysqli_query($koneksi, "INSERT INTO dosen (id_dosen, nidn_dosen, nama_dosen, jk_dosen, alamat_dosen, foto_dosen) VALUES (
                    '',
                    '".$_POST['inputan_nidn_dosen']."',
                    '".$_POST['inputan_nama_dosen']."',
                    '".$_POST['inputan_jk_dosen']."',
                    '".$_POST['inputan_alamat_dosen']."',
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
        $query_simpan = mysqli_query($koneksi, "INSERT INTO dosen (id_dosen, nidn_dosen, nama_dosen, jk_dosen, alamat_dosen, foto_dosen) VALUES (
            '',
            '".$_POST['inputan_nidn_dosen']."',
            '".$_POST['inputan_nama_dosen']."',
            '".$_POST['inputan_jk_dosen']."',
            '".$_POST['inputan_alamat_dosen']."',
            ''
        ) ");
        
        echo "<script>alert('Operasi berhasil')</script>";
        echo "<meta http-equiv='refresh' content='0; url=hal-aplikasi-crud.php'> ";
    }

}

//perintah simpan ubah data
if(isset($_POST['tombol_simpan_dosen']) and @$_GET['aksi'] == 'ubah_dosen'){
    //periksa apakah file diunggah tanpa kesalahan
    if(isset($_FILES["inputan_foto_dosen"]) && $_FILES["inputan_foto_dosen"]["error"] == 0){
        $batas_ekstensi_file = array("jpg", "jpeg", "png");
        $file_pilihan = pathinfo($_FILES["inputan_foto_dosen"]["name"], PATHINFO_EXTENSION);

        //periksa ekstensi file yang di izinkan upload
        if(in_array($file_pilihan, $batas_ekstensi_file)){
            //menentukan tempat menyimpan file
            $folder_simpan = "unggahan_foto/";

            //me-rename file supaya tidak ada nama file yang sama
            $nama_file_baru = uniqid().'.'.$file_pilihan;
            $target_file = $folder_simpan.$nama_file_baru;

            //memindahkan file yang diunggah ke lokasi yang ditentukan & melakukan proses simpan data baru
            if(move_uploaded_file($_FILES["inputan_foto_dosen"]["tmp_name"], $target_file)){
                //menghapus file/gambar yang tersimpan di direktori/folder
                unlink('unggahan_foto/'.$_POST['nama_foto_tersimpan']);
                //melakukan proses simpan ubah data
                $query_simpan_ubah = mysqli_query($koneksi, "UPDATE dosen SET 
                    nidn_dosen = '".$_POST['inputan_nidn_dosen']."',
                    nama_dosen = '".$_POST['inputan_nama_dosen']."',
                    jk_dosen = '".$_POST['inputan_jk_dosen']."',
                    alamat_dosen = '".$_POST['inputan_alamat_dosen']."',
                    foto_dosen = '$nama_file_baru'
                    WHERE id_dosen = '".$_GET['vid_dosen']."'
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
        $query_simpan_ubah = mysqli_query($koneksi, "UPDATE dosen SET 
            nidn_dosen = '".$_POST['inputan_nidn_dosen']."',
            nama_dosen = '".$_POST['inputan_nama_dosen']."',
            jk_dosen = '".$_POST['inputan_jk_dosen']."',
            alamat_dosen = '".$_POST['inputan_alamat_dosen']."',
            foto_dosen = '".$_POST['nama_foto_tersimpan']."'
            WHERE id_dosen = '".$_GET['vid_dosen']."'
        ");
        
        echo "<script>alert('Operasi berhasil')</script>";
        echo "<meta http-equiv='refresh' content='0; url=hal-aplikasi-crud.php'> ";
    }
}

//perintah hapus
if(@$_GET['aksi'] == 'hapus_dosen'){
    //melakukan proses hapus data
    $query_hapus = mysqli_query($koneksi, "DELETE FROM dosen where id_dosen = '".$_GET['vid_dosen']."' ");
    //menghapus file/gambar yang tersimpan di direktori/folder
    unlink('unggahan_foto/'.$_GET['vfoto_dosen']);

    echo "<script>alert('Hapus berhasil')</script>";
    echo "<meta http-equiv='refresh' content='0; url=hal-aplikasi-crud.php'> ";
}


//========================================================================================= JADWAL KULIAH
//perintah simpan / tambah data
if(isset($_POST['tombol_simpan_jadwal']) and @$_GET['aksi'] == ''){
    //melakukan proses simpan data baru
    
    $query_simpan = mysqli_query($koneksi, "INSERT INTO penjualan (id, tanggal, namaproduk, harga, totalpesanan, totalharga, idcustomer, catatan) VALUES (
        '',
        '".$_POST['inputan_tanggal']."',
        '".$_POST['inputan_pilih_produk']."',
        '".$_POST['inputan_harga']."',
        '".$_POST['inputan_totalpesanan']."',
        '".$_POST['inputan_totalharga']."',
        '".$_POST['inputan_pilih_customer']."',
        '".$_POST['inputan_catatan']."'
       
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