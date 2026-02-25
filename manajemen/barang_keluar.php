<?php include 'header.php'; ?>

<div class="content-wrapper">

  <section class="content-header">
    <h1>
      Barang Keluar
      <small>Data Barang Keluar</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Dashboard</li>
    </ol>
  </section>

  <section class="content">
    <div class="row">
      <section class="col-lg-12">

       <?php 
       if(isset($_GET['alert'])){
        if($_GET['alert'] == "lebih"){
          echo "<div class='alert alert-danger'><b>GAGAL!</b> Jumlah barang keluar terlalu besar atau melebihi stok barang yang ada.</div>";
        }
      }
      ?>


      <div class="box box-info">

        <div class="box-header">
          <h3 class="box-title">Barang Keluar</h3>

          <div class="pull-right" style="margin-right: 10px;">
            <input type="text" id="barcode_scan" class="form-control" placeholder="Scan barcode..." style="width: 200px; display: inline-block;">
            <button type="button" class="btn btn-success btn-sm" onclick="cariBarang()">
              <i class="fa fa-search"></i> Cari
            </button>
          </div>

          <button type="button" class="btn btn-info btn-sm pull-right" data-toggle="modal" data-target="#modal_suplier">
           <i class="fa fa-plus"></i> &nbsp Barang Keluar Baru
         </button>

         <!-- The Modal -->
         <div class="modal" id="modal_suplier">
          <div class="modal-dialog">
            <div class="modal-content">

              <!-- Modal Header -->
              <div class="modal-header">
                <h4 class="modal-title">Barang Keluar Baru</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>

              <!-- Modal body -->
              <div class="modal-body">
                <form action="barang_keluar_act.php" method="post">

                  <div id="barcode_info" class="alert alert-info" style="display: none;">
                    <button type="button" class="close" onclick="$('#barcode_info').hide()">&times;</button>
                    <p><strong>Barcode Terdeteksi:</strong> <span id="barcode_terdeteksi"></span></p>
                    <p><strong>Barang:</strong> <span id="barang_terpilih"></span></p>
                    <p><strong>Lokasi:</strong> <span id="lokasi_barang"></span></p>
                  </div>

                  <div class="form-group">
                    <label>Barang</label>
                    <select class="form-control" name="barang" id="barang_select" required="required" onchange="fillLokasi()">
                      <option value=""> - Pilih Barang - </option>
                      <?php 
                      $barang = mysqli_query($koneksi,"SELECT * from barang");
                      if($barang){
                        while($b=mysqli_fetch_array($barang)){
                          ?>
                          <option value="<?php echo $b['barang_id']; ?>" data-lokasi="<?php echo $b['barang_lokasi']; ?>"><?php echo $b['barang_nama']; ?></option>
                          <?php 
                        }
                      }
                      ?>
                    </select>
                  </div>

                  <div class="form-group">
                    <label>Tanggal Keluar</label>
                    <input type="text" class="form-control datepicker2" autocomplete="off" name="tanggal" required="required" placeholder="Masukkan Tanggal keluar ..">
                  </div>

                  <div class="form-group">
                    <label>Jumlah</label>
                    <input type="number" class="form-control" name="jumlah" required="required" placeholder="Masukkan Jumlah ..">
                  </div>

                  <div class="form-group">
                    <label>Lokasi Asal (Supplier)</label>
                    <select class="form-control" name="lokasi_asal" required="required">
                      <option value=""> - Pilih Supplier - </option>
                      <?php 
                      $suplier = mysqli_query($koneksi,"SELECT * from suplier ORDER BY suplier_nama ASC");
                      if($suplier){
                        while($s=mysqli_fetch_array($suplier)){
                          ?>
                          <option value="<?php echo $s['suplier_nama']; ?>"><?php echo $s['suplier_nama']; ?></option>
                          <?php 
                        }
                      }
                      ?>
                    </select>
                  </div>

                  <div class="form-group">
                    <label>Lokasi Tujuan</label>
                    <select class="form-control" name="lokasi_tujuan" id="lokasi_tujuan" required="required">
                      <option value=""> - Pilih Gudang Tujuan - </option>
                      <?php 
                      $gudang = mysqli_query($koneksi,"SELECT * from gudang ORDER BY nama_gudang ASC");
                      if($gudang && mysqli_num_rows($gudang) > 0){
                        while($g=mysqli_fetch_array($gudang)){
                          ?>
                          <option value="<?php echo $g['nama_gudang']; ?>"><?php echo $g['nama_gudang']; ?></option>
                          <?php 
                        }
                      }
                      ?>
                    </select>
                  </div>

                  <div class="form-group">
                    <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Batal</button>
                    <input type="submit" class="btn btn-sm btn-primary" value="Simpan">
                  </div>
                </form>
              </div>

            </div>
          </div>
        </div>

      </div>
      <div class="box-body">
        <div class="table-responsive">
          <table class="table table-bordered table-striped" id="table-datatable">
            <thead>
              <tr>
                <th width="1%">NO</th>
                <th>NAMA BARANG</th>
                <th>TANGGAL KELUAR</th>
                <th>JUMLAH</th>
                <th>LOKASI ASAL</th>
                <th>LOKASI TUJUAN</th>
                <th width="10%">OPSI</th>
              </tr>
            </thead>
            <tbody>
              <?php 
              $no=1;
              $data = mysqli_query($koneksi,"SELECT * FROM barang_keluar ORDER BY bk_id DESC");
              while($d = mysqli_fetch_array($data)){
                ?>
                <tr>
                  <td><?php echo $no++; ?></td>
                  <td><?php echo isset($d['bk_nama_barang']) ? $d['bk_nama_barang'] : '-'; ?></td>
                  <td><?php echo isset($d['bk_tgl_keluar']) ? $d['bk_tgl_keluar'] : '-'; ?></td>
                  <td><?php echo isset($d['bk_jumlah_keluar']) ? $d['bk_jumlah_keluar'] : '-'; ?></td>
                  <td><?php echo isset($d['bk_lokasi_asal']) ? $d['bk_lokasi_asal'] : (isset($d['bk_lokasi']) ? $d['bk_lokasi'] : '-'); ?></td>
                  <td><?php echo isset($d['bk_lokasi_tujuan']) ? $d['bk_lokasi_tujuan'] : (isset($d['bk_penerima']) ? $d['bk_penerima'] : '-'); ?></td>
                  <td>                        
                    <a class="btn btn-warning btn-sm" href="barang_keluar_edit.php?id=<?php echo $d['bk_id'] ?>"><i class="fa fa-cog"></i></a>
                    <a class="btn btn-danger btn-sm" href="barang_keluar_hapus.php?id=<?php echo $d['bk_id'] ?>"><i class="fa fa-trash"></i></a>
                  </td>
                </tr>
                <?php 
              }
              ?>
            </tbody>
          </table>
        </div>
      </div>

    </div>
  </section>
</div>
</section>

</div>

<script>
function fillLokasi() {
  var select = document.getElementById('barang_select');
  var selectedOption = select.options[select.selectedIndex];
  var lokasi = selectedOption.getAttribute('data-lokasi');
  
  var lokasiSelect = document.getElementById('lokasi_tujuan');
  if (lokasi) {
    for (var i = 0; i < lokasiSelect.options.length; i++) {
      if (lokasiSelect.options[i].value === lokasi) {
        lokasiSelect.selectedIndex = i;
        break;
      }
    }
  }
}

function cariBarang() {
    var kode = $('#barcode_scan').val();
    if(kode == '') {
        alert('Silakan scan atau masukkan kode barcode');
        return;
    }
    
    $.ajax({
        url: 'cari_barang.php?kode=' + encodeURIComponent(kode),
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            if(response.success) {
                $('#barcode_terdeteksi').text(kode);
                $('#barang_terpilih').text(response.data.barang_nama);
                $('#lokasi_barang').text(response.data.barang_lokasi);
                $('#barcode_info').show();
                $('#barang_select').val(response.data.barang_id);
                fillLokasi();
                $('#modal_suplier').modal('show');
            } else {
                alert(response.message);
            }
        },
        error: function() {
            alert('Terjadi kesalahan saat mencari barang');
        }
    });
}

$('#barcode_scan').keypress(function(e) {
    if(e.which == 13) {
        cariBarang();
    }
});
</script>

<?php include 'footer.php'; ?>
