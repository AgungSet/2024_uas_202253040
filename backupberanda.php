<div id="beranda" class="container tab-pane <?php echo ($_SESSION['active_tab'] == 'beranda' || !isset($_SESSION['active_tab'])) ? 'active' : ''; ?>">
      <h3>Beranda</h3>
      <p>Halaman beranda aplikasi penjualan.</p>
      <div class="row">
        <!-- konten form entri jadwal kuliah -->
        <div class="col-5">
            <div class="card">
                <div class="card-header bg-secondary text-white"><b>Form Entri (Jadwal Kuliah)</b></div>
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
                        <div class="row mb-2">
                            <label class="col-4">Tangal Entri</label>
                            <div class="col-8">
                                <input class="form-control" type="date" name="inputan_tanggal_entri" required value="<?= @$data_ubah_jadwal['tanggal_entri'] ?>">
                            </div>
                        </div>

                        <div class="row mb-2">
                            <label class="col-4">Hari Kuliah</label>
                            <div class="col-8">
                                <select class="form-control" name="inputan_hari_kuliah" required>
                                    <?php if(!empty(@$_GET['vid_jadwalkuliah'])) { ?>
                                    <option value="<?= @$data_ubah_jadwal['hari_kuliah'] ?>"><?= @$data_ubah_jadwal['hari_kuliah'] ?></option>
                                    <?php } ?>
                                    <option value=""> -- Silahkan Pilih --</option>
                                    <option value="Senin">Senin</option>
                                    <option value="Selasa">Selasa</option>
                                    <option value="Rabu">Rabu</option>
                                    <option value="Kamis">Kamis</option>
                                    <option value="Jumat">Jumat</option>
                                    <option value="Sabtu">Sabtu</option>
                                    <option value="Minggu">Minggu</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <label class="col-4">Jam Kuliah</label>
                            <div class="col-8">
                                <small><i>mulai</i></small>
                                <input class="form-control" type="time" name="inputan_jam_mulai" required value="<?= substr(@$data_ubah_jadwal['jam_kuliah'], 0, 5)  ?>">
                                <small><i>selesai</i></small>
                                <input class="form-control" type="time" name="inputan_jam_selesai" required value="<?= substr(@$data_ubah_jadwal['jam_kuliah'], -5, 5) ?>">
                            </div>
                        </div>

                        <div class="row mb-2">
                            <label class="col-4">Tempat Kuliah</label>
                            <div class="col-8">
                                <textarea class="form-control" name="inputan_tempat_kuliah" required><?= @$data_ubah_jadwal['tempat_kuliah'] ?></textarea>
                            </div>
                        </div>

                        <div class="row mb-2">
                            <label class="col-4">Dosen Pengampu</label>
                            <div class="col-8">
                                <select class="form-control" name="inputan_pilih_dosen" required>
                                    <?php if(!empty(@$data_ubah_jadwal['id_dosen'])) { ?>
                                    <option value="<?= @$data_ubah_jadwal['id_dosen'] ?>"><?= @$data_ubah_jadwal['nidn_dosen'].' - '.$data_ubah_jadwal['nama_dosen'] ?></option>
                                    <?php } ?>
                                    
                                    <option value=""> -- Silahkan Pilih --</option>
                                    <?php $SQLTampilDataDosen = mysqli_query($koneksi, "SELECT * FROM dosen ORDER BY id_dosen DESC");
                                        while($data_dosen = mysqli_fetch_array($SQLTampilDataDosen)) { ?>
                                    <option value="<?= $data_dosen['id_dosen'] ?>"><?= $data_dosen['nidn_dosen'].' - '.$data_dosen['nama_dosen'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-2">
                            <label class="col-4">Nama Matakuliah</label>
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
                <div class="card-header bg-secondary text-white"><b>Tabel Data (Jadwal Kuliah)</b></div>
                <div class="card-body">
                    <input class="form-control mb-2" type="text" id="pencarian_data" onkeyup="pencarianData()" placeholder="Pencarian (Mata Kuliah) ..">
                    <table class="table table-bordered" id="tabel_data">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Waktu Kuliah</th>
                                <th>Tempat Kuliah</th>
                                <th>Matakuliah</th>
                                <th>Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; 
                                $SQLTampilDataJadwal = mysqli_query($koneksi, "SELECT * FROM jadwal_kuliah, dosen, mata_kuliah where jadwal_kuliah.id_dosen = dosen.id_dosen and jadwal_kuliah.id_matakuliah = mata_kuliah.id_matakuliah ORDER BY id_jadwalkuliah DESC");
                                while($data_jadwal = mysqli_fetch_array($SQLTampilDataJadwal)) { ?>
                            <tr style="font-size: smaller;">
                                <td><?= $no++ ?></td>
                                <td><?= $data_jadwal['hari_kuliah'].', <br>'.$data_jadwal['jam_kuliah'] ?></td>
                                <td>
                                    <?= $data_jadwal['tempat_kuliah'].'<br><b>Dosen : </b>'.$data_jadwal['nama_dosen'] ?>
                                    <hr style="margin : 0">
                                    Tgl. Entri (<?= date("d/M/Y", strtotime($data_jadwal['tanggal_entri'])) ?>)
                                </td>
                                <td><?= $data_jadwal['mata_kuliah'] ?></td>
                                <td>
                                    <a style="margin: 2px;" href="hal-aplikasi-crud.php?aksi=ubah_jadwal&vid_jadwalkuliah=<?= $data_jadwal['id_jadwalkuliah'] ?>" class="btn btn-success btn-sm"><i class="fa fa-edit"></i></a>
                                    <a style="margin: 2px;" onclick="return confirm('Yakin hapus ?')" href="hal-aplikasi-crud.php?aksi=hapus_jadwal&vid_jadwalkuliah=<?= $data_jadwal['id_jadwalkuliah'] ?>" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>
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