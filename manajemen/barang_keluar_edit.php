<?php include 'header.php'; ?>

<div class="content-wrapper">

  <section class="content-header">
    <h1>
      Edit Barang Keluar
      <small>Data Barang Keluar</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Dashboard</li>
    </ol>
  </section>

  <section class="content">
    <div class="row">
      <section class="col-lg-6">       
        <div class="box box-info">

          <div class="box-header">
            <h3 class="box-title">Edit Barang Keluar</h3>
            <a href="barang_keluar.php" class="btn btn-info btn-sm pull-right"><i class="fa fa-reply"></i> &nbsp Kembali</a> 
          </div>
          <div class="box-body">
            <form action="barang_keluar_update.php" method="post">
              <?php 
              $id = $_GET['id'];              
              $data = mysqli_query($koneksi, "select * from barang_keluar where bk_id='$id'");
              while($d = mysqli_fetch_array($data)){
                ?>
                
                <div class="form-group">
                  <label>Barang</label>
                  <input type="hidden" name="id" value="<?php echo $d['bk_id'] ?>">
                  <select class="form-control" name="barang" required="required">
                    <option value=""> - Pilih Barang - </option>
                    <?php 
                    $barang = mysqli_query($koneksi,"SELECT * from barang");
                    while($b=mysqli_fetch_array($barang)){
                      ?>
                      <option <?php if($d['bk_id_barang'] == $b['barang_id']){echo "selected='selected'";} ?> value="<?php echo $b['barang_id']; ?>"><?php echo $b['barang_nama']; ?></option>
                      <?php 
                    }
                    ?>
                  </select>
                </div>

                <div class="form-group">
                  <label>Tanggal Keluar</label>
                  <input type="text" class="form-control datepicker2" autocomplete="off" name="tanggal" required="required" placeholder="Masukkan Tanggal Keluar .." value="<?php echo $d['bk_tgl_keluar'] ?>">
                </div>

                <div class="form-group">
                  <label>Jumlah</label>
                  <input type="number" class="form-control" name="jumlah" required="required" placeholder="Masukkan Jumlah .." value="<?php echo $d['bk_jumlah_keluar'] ?>">
                </div>

                <div class="form-group">
                  <label>Lokasi Asal (Supplier)</label>
                  <select class="form-control" name="lokasi_asal" required="required">
                    <option value=""> - Pilih Supplier - </option>
                    <?php 
                    $suplier = mysqli_query($koneksi,"SELECT * from suplier ORDER BY suplier_nama ASC");
                    while($s=mysqli_fetch_array($suplier)){
                      ?>
                      <option <?php if(isset($d['bk_lokasi_asal']) && $d['bk_lokasi_asal'] == $s['suplier_nama']){ echo "selected='selected'"; } ?> value="<?php echo $s['suplier_nama']; ?>"><?php echo $s['suplier_nama']; ?></option>
                      <?php 
                    }
                    ?>
                  </select>
                </div>

                <div class="form-group">
                  <label>Lokasi Tujuan</label>
                  <select class="form-control" name="lokasi_tujuan" required="required">
                    <option value=""> - Pilih Gudang Tujuan - </option>
                    <?php 
                    $gudang = mysqli_query($koneksi,"SELECT * from gudang ORDER BY nama_gudang ASC");
                    while($g=mysqli_fetch_array($gudang)){
                      ?>
                      <option <?php if(isset($d['bk_lokasi_tujuan']) && $d['bk_lokasi_tujuan'] == $g['nama_gudang']){ echo "selected='selected'"; } ?> value="<?php echo $g['nama_gudang']; ?>"><?php echo $g['nama_gudang']; ?></option>
                      <?php 
                    }
                    ?>
                  </select>
                </div>

                <div class="form-group">
                  <label>Keterangan</label>
                  <input type="text" class="form-control" name="keterangan" placeholder="Masukkan Keterangan .." value="<?php echo isset($d['bk_keterangan']) ? $d['bk_keterangan'] : '' ?>">
                </div>

                <div class="form-group">
                  <a href="barang_keluar.php" class="btn btn-sm btn-danger">Batal</a>
                  <input type="submit" class="btn btn-sm btn-primary" value="Simpan">
                </div>
                <?php 
              }
              ?>
            </form>
          </div>

        </div>
      </section>
    </div>
  </section>

</div>
<?php include 'footer.php'; ?>
