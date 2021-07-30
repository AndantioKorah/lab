<div class="card card-default">
    <div class="card-header"  style="display: block;">
        <h3 class="card-title">TAMBAH TINDAKAN</h3>
    </div>
    <div class="card-body" style="display: block;">
        <form id="form_tambah_role">
            <div class="row">
                <div class="col-4">
                    <div class="form-group">
                        <label class="bmd-label-floating">Jenis Pemeriksaan</label>
                        <Select class="form-control select2_this select2-navy" autocomplete="off" name="id_m_jns_tindakan" id="id_m_jns_tindakan" required>
                        <option value="">---Pilih Jenis Pemeriksaan---</option>                    
                            <?php foreach($get_category as $row) { ?>
                                <option value="<?php echo $row->id;?>"><?php echo $row->nm_jns_tindakan;?></option>
                            <?php } ?>

                        </Select>
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-group">
                        <label class="bmd-label-floating">Nama Tindakan</label>
                        <input class="form-control" autocomplete="off" name="nama_tindakan" id="nama_tindakan" required/>
                    </div>
                </div>

                <div class="col-4">
                    <div class="form-group">
                        <label class="bmd-label-floating">Tarif</label>
                        <input type="number" class="form-control" autocomplete="off" name="biaya" id="biaya" required/>
                    </div>
                </div>

                <div class="col-4">
                    <div class="form-group">
                        <label class="bmd-label-floating">Nilai Normal</label>
                        <input type="number" class="form-control" autocomplete="off" name="biaya" id="biaya"/>
                    </div>
                </div>

                <div class="col-4">
                    <div class="form-group">
                        <label class="bmd-label-floating">Satuan</label>
                        <input type="number" class="form-control" autocomplete="off" name="biaya" id="biaya"/>
                    </div>
                </div>
                
                
                </div>
                    <div class="col-8"></div>
                <div class="col-8 text-right mt-2">
                    <button class="btn btn-sm btn-navy" type="submit"><i class="fa fa-save"></i> SIMPAN</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="card card-default">
    <div class="card-header">
        <h3 class="card-title">LIST Tindakan</h3>
    </div>
    <div class="card-body">
        <div id="list_role" class="row">
        </div>
    </div>
</div>

<div class="modal fade" id="edit_master_tindakan" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div id="modal-dialog" class="modal-dialog modal-xl">
      <div class="modal-content">
          <div class="modal-header">
              <h6 class="modal-title">EDIT MASTER TINDAKAN</h6>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div id="edit_master_tindakan_content">
          </div>
      </div>
  </div>
</div>

<script>
    $(function(){
        loadMasterTindakan()
    })

    function loadMasterTindakan(){
        $('#list_role').html('')
        $('#list_role').append(divLoaderNavy)
        $('#list_role').load('<?=base_url("master/C_Master/loadMasterTindakan")?>', function(){
            $('#loader').hide()
        })
    }

    $('#form_tambah_role').on('submit', function(e){
        e.preventDefault();
        $.ajax({
            url: '<?=base_url("master/C_Master/createMasterTindakan")?>',
            method: 'post',
            data: $(this).serialize(),
            success: function(){
                loadJenisPemeriksaan()
                $('#role_name').val('')
                $('#nama').val('')
                $('#keterangan').val('')
            }, error: function(e){
                errortoast('Terjadi Kesalahan')
            }
        })
    })

    function openModalEdiMasterTindakan(id = 0){
    $('#edit_master_tindakan_content').html('')
    $('#edit_master_tindakan_content').append(divLoaderNavy)
    $('#edit_master_tindakan_content').load('<?=base_url("master/C_Master/editMasterTindakan")?>'+'/'+id, function(){
      $('#loader').hide()
    })
  }

</script>