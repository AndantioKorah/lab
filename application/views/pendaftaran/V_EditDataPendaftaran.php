<?php if($pendaftaran){ ?>
<script src="<?=base_url('assets/js/bootstrap-datetimepicker.js')?>"></script>
<div class="row p-3">
    <div class="col-md-12">
        <h6>No. Lab: <strong><?=$pendaftaran['nomor_pendaftaran']?></strong></h6>
    </div>
    <div class="col-md-12">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a style="color: #001f3f" data-toggle="tab" class="nav-link active" href="#edit_tab"><span class="text_tab">Edit</span></a>
            </li>
            <li class="nav-item">
                <a style="color: #001f3f" data-toggle="tab" class="nav-link" href="#delete_tab"><span class="text_tab">Hapus</span></a>
            </li>
        </ul>
        <div class="tab-content mt-2">
            <div id="edit_tab" class="tab-pane active">
                <form id="form_edit_data_pendaftaran">
                    <input style="display: none;" id="id_t_pendaftaran" name="id_t_pendaftaran" value="<?=$pendaftaran['id_t_pendaftaran']?>" />
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-12">
                                    <label>Dokter Pengirim</label>
                                    <select class="form-control form-control-sm select2_this select2-navy" data-dropdown-css-class="select2-navy" id="dokter_pengirim" name="dokter_pengirim">
                                        <option <?=$pendaftaran['id_m_dokter_pengirim'] == 0 ? 'selected' : ''?> value="0">Atas Permintaan Sendiri</option>
                                        <?php foreach($dokter as $d){ ?>
                                            <option <?=$pendaftaran['id_m_dokter_pengirim'] == $d['id'] ? 'selected' : ''?> 
                                            value="<?=$d['id'].';'.$d['nama_dokter'].';'.$d['alamat'].';'.$d['nomor_telepon']?>"><?=$d['nama_dokter']?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <?php
                                $display = 'none';
                                if($pendaftaran['id_m_dokter_pengirim']){
                                    $display = 'block';
                                }
                            ?>
                            <div class="row" id="data_dokter_pengirim" style="display: <?=$display?>;">
                                <div class="col-md-12">
                                    <label>Alamat</label>
                                    <input class="form-control form-control-sm" value="<?=$pendaftaran['alamat_dokter_pengirim']?>" id="alamat_dokter_pengirim" name="alamat_dokter_pengirim" />
                                </div>
                                <div class="col-md-12">
                                    <label>No. Telepon</label>
                                    <input class="form-control form-control-sm" value="<?=$pendaftaran['nomor_telepon_dokter_pengirim']?>" id="nomor_telepon_dokter_pengirim" name="nomor_telepon_dokter_pengirim" />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-12">
                                    <label>Tanggal Pendaftaran</label>
                                    <input value="<?=$pendaftaran['tanggal_pendaftaran']?>" readonly class="form-control form-control-sm" id="tanggal_pendaftaran"
                                    name="tanggal_pendaftaran" />
                                </div>
                                <div class="col-md-12">
                                    <label>Cara Bayar</label>
                                    <select class="form-control form-control-sm select2_this select2-navy" data-dropdown-css-class="select2-navy" name="cara_bayar">
                                        <?php foreach($cara_bayar_detail as $cbd){ ?>
                                            <option <?=$cbd['id'] == $pendaftaran['id_m_cara_bayar_detail'] ? 'selected' : ''?> value="<?=$cbd['id'].';'.$cbd['nama_cara_bayar_detail']?>"><?=$cbd['nama_cara_bayar_detail']?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-md-12">
                                    <label>Dokter Penanggung Jawab</label>
                                    <select class="form-control form-control-sm select2_this select2-navy" data-dropdown-css-class="select2-navy" name="dpjp">
                                        <?php foreach($dokter as $d){ ?>
                                            <option <?=$pendaftaran['id_m_dpjp'] == $d['id'] ? 'selected' : ''?> value="<?=$d['id'].';'.$d['nama_dokter']?>"><?=$d['nama_dokter']?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3 text-right">
                        <div class="col-12"><hr></div>
                        <?php if($tagihan['id_m_status_tagihan'] == 1){ ?>
                        <div class="col-md-6"></div>
                        <div class="col-md-6">
                            <button id="button_submit_edit_pendaftaran" type="submit" class="btn btn-navy btn-sm"><i class="fa fa-save"></i> Simpan</button>
                            <button disabled id="button_loading" style="display:none;" class="btn btn-navy btn-sm"><i class="fa fa-spin fa-spinner"></i> Menyimpan Pendaftaran</button>
                        </div>
                        <?php } ?>
                    </div>
                </form>
            </div>
            <div id="delete_tab" class="tab-pane">
                <form id="form_delete_pendaftaran">
                    <div class="row">
                        <?php if($tagihan['id_m_status_tagihan'] == 1){ ?>
                            <div class="col-md-12">
                                <label>Ketik "<i><b>hapus</b></i>" sebagai konfirmasi untuk menghapus pendaftaran ini</label>
                                <input autocomplete="off" class="form-control form-control-sm" id="confirmation" />
                            </div>
                            <div class="col-md-12 mt-2 text-right">
                                <button class="btn btn-sm btn-danger" type="submit" disabled id="btn_delete_pendaftaran"><i class="fa fa-trash"></i> Hapus</button>
                            </div>
                        <?php } ?>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $(function(){
        $('.select2_this').select2()

        $('#tanggal_pendaftaran').datetimepicker({
            format: 'yyyy-mm-dd hh:ii:ss',
            autoclose: true,
            todayHighlight: true,
            todayBtn: true,
            endDate: new Date()
        })
    })

    $('#confirmation').on('input', function(){
        if($(this).val() == 'hapus'){
            $('#btn_delete_pendaftaran').prop('disabled', false)
        } else {
            $('#btn_delete_pendaftaran').prop('disabled', true)
        }
    })

    $('#form_delete_pendaftaran').on('submit', function(e){
        e.preventDefault()
        if(confirm('Apakah Anda yakin ingin menghapus pendaftaran ini?')){
            $.ajax({
                url: '<?=base_url("pendaftaran/C_Pendaftaran/deletePendaftaranLab")?>'+'/'+'<?=$pendaftaran['id_t_pendaftaran']?>',
                method: 'post',
                data: $(this).serialize(),
                success: function(datares){
                    let res = JSON.parse(datares)
                    if(res.code == 0){
                        successtoast('Data Berhasil Dihapus')
                        window.location=""
                    } else {
                        errortoast(res.message)
                    }
                }, error: function(e){
                    errortoast('Terjadi Kesalahan')
                }
            })
        }
    })

    $('#form_edit_data_pendaftaran').on('submit', function(e){
        e.preventDefault()
        $('#button_submit_edit_pendaftaran').show()
        $('#button_submit_pendaftaran').hide()
        $.ajax({
            url: '<?=base_url("pendaftaran/C_Pendaftaran/editPendaftaranLab")?>',
            method: 'post',
            data: $(this).serialize(),
            success: function(datares){
                let res = JSON.parse(datares)
                if(res.code == 0){
                    successtoast('Data Berhasil Disimpan')
                    <?php if($callback != '0') { ?>
                        $('#edit_data_pendaftaran').modal('hide')
                        <?php if($callback == 'loadDetailPendaftaran'){ ?>
                                <?=$callback.'('.$pendaftaran[$key_callback].', 1)'?>
                        <?php } else { ?>
                                <?=$callback.'('.$pendaftaran[$key_callback].')'?>
                        <?php } ?>
                    <?php } else { ?>
                        window.location=""
                    <?php } ?>
                } else {
                    errortoast(res.message)
                }
            }, error: function(e){
                errortoast('Terjadi Kesalahan')
            }
        })
        $('#button_submit_edit_pendaftaran').show()
        $('#button_submit_pendaftaran').hide()
    })

    $('#dokter_pengirim').on('change', function(){
        if($(this).val() != '0'){
            let data_dokter = $(this).val().split(';')
            $('#data_dokter_pengirim').show()
            $('#alamat_dokter_pengirim').val(data_dokter[2])
            $('#nomor_telepon_dokter_pengirim').val(data_dokter[3])
        } else {
            $('#data_dokter_pengirim').hide()
            $('#alamat_dokter_pengirim').val('')
            $('#nomor_telepon_dokter_pengirim').val('')
        }
    })
</script>
<?php } else { ?>
<div class="col-12 text-center">
    <h6><i class="fa fa-exclamation"></i> Data Tidak Ditemukan</h6>
</div>
<?php } ?>