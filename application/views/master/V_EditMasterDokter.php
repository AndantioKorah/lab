<?php if($dokter){ ?>
    <form id="form_edit_master_tindakan">
        <input style="display: none;" id="id_dokter" name="id_dokter" value="<?=$dokter['id_dokter']?>" />
        <div class="row p-3">
            <div class="col-md-12">
             
            </div>
            <div class="col-md-9"></div>
            <div class="col-md-4">
                <label>Nama Dokter</label>
                <input required autocomplete="off" id="nama_dokter"  class="form-control form-control-sm" name="nama_dokter" value="<?=$dokter['nama_dokter']?>" />
            </div>

            <div class="col-md-4">
                <label>Nomor Telepon</label>
                <input autocomplete="off" type="number" id="nomor_telepon"  class="form-control form-control-sm" name="nomor_telepon" value="<?=$dokter['nomor_telepon']?>" />
            </div>

            <div class="col-md-4">
                <label>Alamat</label>
                <input autocomplete="off" id="alamat"  class="form-control form-control-sm" name="alamat" value="<?=$dokter['alamat']?>" />
            </div>

            <div class="col-md-4">
                <label>Fee</label>
                <input required autocomplete="off" id="fee"  class="form-control form-control-sm" name="fee" value="<?=$dokter['fee']?>" />
            </div>

            <div class="col-md-12"><hr></div>
            <div class="col-md-12 text-right">
                <button type="submit" id="btn_simpan_edit" accesskey="s" class="btn btn-block btn-navy"><i class="fa fa-save"></i> <u>S</u>IMPAN</button>
            </div>
        </div>
    </form>
    <script>
        $(function(){
            $('.select2_this').select2()

            $("#tanggal_lahir").inputmask("99-99-9999", {
                placeholder: "hh-bb-tttt"
            });
        })

        $('#form_edit_master_tindakan').on('submit', function(e){
            e.preventDefault()
            $.ajax({
                url: '<?=base_url("master/C_Master/editMasterDokter")?>',
                method: 'post',
                data: $(this).serialize(),
                success: function(datares){
                   let res = JSON.parse(datares)
                   if(res.code == 0){
                        successtoast('Data Berhasil Disimpan')
            
                            $('#edit_master_dokter').modal('hide')
                            loadMasterDokter()
                   } else {
                       errortoast(res.message)
                   }
                }, error: function(e){
                    errortoast('Terjadi Kesalahan')
                }
            })
        })
    </script>
<?php } else { ?>
    <div class="col-12 text-center">
        <h6><i class="fa fa-exclamation"></i> Data tidak ditemukan</h6>
    </div>
<?php } ?>    