<style>
    .lbl_data_pasien{
        font-weight: bold;
        font-size: 15px;
    }

    .nav-tabs .nav-item.show .nav-link, .nav-tabs .nav-link.active{
        color: white !important;
        background-color: #001f3f !important;
        border-color: #001f3f #001f3f #fff;
        font-weight: bold !important;
        height: 38px;
    }

    .nav-tabs .nav-item.show .nav-link, .nav-tabs .nav-link{
        color: #001f3f !important;
        background-color: #fff !important;
        border-color: #dde2e6 #dde2e6 #dde2e6;
        font-weight: bold !important;
        height: 38px;
    }
</style>

<div class="row">
    <div class="col-md-4">
        <div class="card card-default">
            <div class="card-header" style="height: 50px;">
                <div class="row">
                    <div class="col-md-6">
                        <h3 class="card-title"><strong>PILIH PASIEN</strong></h3>
                    </div>
                    <div class="col-md-6 text-right">
                        <button href="#pasien_baru_modal" id="btn_pasien_baru" data-toggle="modal" data-backdrop="static" data-keyboard="false" 
                        class="btn btn-sm btn-success"><i class="fa fa-user-plus"></i> Pasien Baru</button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <label>Cari Pasien (No. RM/No. Identitas/Nama/Tgl. Lahir)</label>
                <select class="form-control form-control-sm select2-navy" data-dropdown-css-class="select2-navy" id="search_pasien"></select>
                <div class="row" id="loader_data_pasien" style="display: none;">
                    <div class="col-12 text-center">
                        <i class="fa fa-3x fa-spin fa-spinner"></i>
                    </div>
                </div>
                <div class="row" id="data_pasien" style="display: none;">
                    <div class="col-md-12"><hr></div>
                    <div class="col-md-8"></div>
                    <div class="col-md-4 text-right">
                        <button href="#edit_data_pasien" data-toggle="modal" onclick="editPasien()" data-backdrop="static" data-keyboard="false"
                        class="btn btn-navy btn-sm"><i class="fa fa-edit"></i> EDIT DATA PASIEN</button>
                    </div>
                    <div class="col-md-3">
                        <p>No. RM</p>
                    </div>
                    <div class="col-md-1">
                        <p>:</p>
                    </div>
                    <div class="col-md-7">
                        <p class="lbl_data_pasien" id="lbl_norm"></p>
                    </div>
                    <div class="col-md-3">
                        <p>Nama Pasien</p>
                    </div>
                    <div class="col-md-1">
                        <p>:</p>
                    </div>
                    <div class="col-md-7">
                        <p class="lbl_data_pasien" id="lbl_nama_pasien"></p>
                    </div>
                    <div class="col-md-3">
                        <p>No. Identitas</p>
                    </div>
                    <div class="col-md-1">
                        <p>:</p>
                    </div>
                    <div class="col-md-7">
                        <p class="lbl_data_pasien" id="lbl_no_identitas"></p>
                    </div>
                    <div class="col-md-3">
                        <p>Jenis Kelamin</p>
                    </div>
                    <div class="col-md-1">
                        <p>:</p>
                    </div>
                    <div class="col-md-7">
                        <p class="lbl_data_pasien" id="lbl_jenis_kelamin"></p>
                    </div>
                    <div class="col-md-3">
                        <p>Gol. Darah</p>
                    </div>
                    <div class="col-md-1">
                        <p>:</p>
                    </div>
                    <div class="col-md-7">
                        <p class="lbl_data_pasien" id="lbl_goldar"></p>
                    </div>
                    <div class="col-md-3">
                        <p>Tempat Lahir</p>
                    </div>
                    <div class="col-md-1">
                        <p>:</p>
                    </div>
                    <div class="col-md-7">
                        <p class="lbl_data_pasien" id="lbl_tempat_lahir"></p>
                    </div>
                    <div class="col-md-3">
                        <p>Tanggal Lahir</p>
                    </div>
                    <div class="col-md-1">
                        <p>:</p>
                    </div>
                    <div class="col-md-7">
                        <p class="lbl_data_pasien" id="lbl_tanggal_lahir"></p>
                    </div>
                    <div class="col-md-3">
                        <p>Umur</p>
                    </div>
                    <div class="col-md-1">
                        <p>:</p>
                    </div>
                    <div class="col-md-7">
                        <p class="lbl_data_pasien" id="lbl_umur"></p>
                    </div>
                    <div class="col-md-3">
                        <p>Alamat</p>
                    </div>
                    <div class="col-md-1">
                        <p>:</p>
                    </div>
                    <div class="col-md-7">
                        <p class="lbl_data_pasien" id="lbl_alamat"></p>
                    </div>
                    <div class="col-md-3">
                        <p>No. Telepon</p>
                    </div>
                    <div class="col-md-1">
                        <p>:</p>
                    </div>
                    <div class="col-md-7">
                        <p class="lbl_data_pasien" id="lbl_no_telepon"></p>
                    </div>
                    <div class="col-md-3">
                        <p>Pekerjaan</p>
                    </div>
                    <div class="col-md-1">
                        <p>:</p>
                    </div>
                    <div class="col-md-7">
                        <p class="lbl_data_pasien" id="lbl_pekerjaan"></p>
                    </div>
                    <div class="col-md-3">
                        <p>Kewarganegaraan</p>
                    </div>
                    <div class="col-md-1">
                        <p>:</p>
                    </div>
                    <div class="col-md-7">
                        <p class="lbl_data_pasien" id="lbl_kewarganegaraan"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <form id="form_pendaftaran_lab">
            <div class="card card-default">
                <div class="card-header" style="height: 50px;">
                    <ul class="nav nav-tabs card-header-tabs">
                        <li class="nav-item">
                            <a style="border-left: 1px solid #dde2e6;" data-toggle="tab" class="nav-link active" href="#data_pendaftaran_tab"><span class="text_tab">DATA PENDAFTARAN</span></a>
                        </li>
                        <li class="nav-item">
                            <a data-toggle="tab" class="nav-link" href="#data_tindakan_tab"><span class="text_tab">DATA TINDAKAN</span></a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <input type="hidden" name="session_id" id="session_id" value="<?= $this->session->userdata('session_id')?>">
                    <input style="display: none;" name="norm" id="norm_pasien" />
                    <input style="display: none;" id="tanggal_lahir" />
                    <input style="display: none;" id="jenis_kelamin" />
                    <div class="tab-content">
                        <div id="data_pendaftaran_tab" class="tab-pane active">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label>Dokter Pengirim</label>
                                            <select class="form-control form-control-sm select2-navy" data-dropdown-css-class="select2-navy" id="dokter_pengirim" name="dokter_pengirim">
                                                <option value="0" selected>Atas Permintaan Sendiri</option>
                                                <!-- <?php foreach($dokter as $d){ ?>
                                                    <option value="<?=$d['id'].';'.$d['nama_dokter'].';'.$d['alamat'].';'.$d['nomor_telepon']?>"><?=$d['nama_dokter']?></option>
                                                <?php } ?> -->
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row" id="data_dokter_pengirim" style="display: none;">
                                        <div class="col-md-12">
                                            <label>Alamat</label>
                                            <input class="form-control form-control-sm" id="alamat_dokter_pengirim" name="alamat_dokter_pengirim" />
                                        </div>
                                        <div class="col-md-12">
                                            <label>No. Telepon</label>
                                            <input class="form-control form-control-sm" id="nomor_telepon_dokter_pengirim" name="nomor_telepon_dokter_pengirim" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label>Tanggal Pendaftaran</label>
                                            <input readonly class="form-control form-control-sm datetimepickermaxtodaythis realdatetimethis" name="tanggal_pendaftaran" />
                                        </div>
                                        <div class="col-md-12">
                                            <label>Cara Bayar</label>
                                            <select class="form-control form-control-sm select2_this select2-navy" data-dropdown-css-class="select2-navy" name="cara_bayar">
                                                <?php foreach($cara_bayar_detail as $cbd){ ?>
                                                    <option <?=$cbd['id'] == 1 ? 'selected' : ''?> value="<?=$cbd['id'].';'.$cbd['nama_cara_bayar_detail']?>"><?=$cbd['nama_cara_bayar_detail']?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="col-md-12">
                                            <label>Dokter Penanggung Jawab</label>
                                            <select class="form-control form-control-sm select2_this select2-navy" data-dropdown-css-class="select2-navy" name="dpjp">
                                                <?php foreach($dokter as $d){ ?>
                                                    <option <?=$d['id'] == 1 ? 'selected' : ''?> value="<?=$d['id'].';'.$d['nama_dokter']?>"><?=$d['nama_dokter']?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="data_tindakan_tab" class="tab-pane">
                            <div class="row">
                                <div class="col-12">
                                    <select class="form-control" style="width: 100%;" id="cari_tindakan" type='text' placeholder="Cari Tindakan...">Cari Tindakan...</select>
                                    <input id="button_submit_input_tindakan" type="button" class="btn btn-navy btn-block mt-2" onclick="createTindakanPendaftaran()" value="Simpan">
                                </div>
                                <div class="col-12 mt-3">
                                    <div id="content_div_tindakan">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-md-6"></div>
                        <div class="col-md-6">
                            <button id="button_submit_pendaftaran" type="submit" accesskey="b" class="btn btn-navy btn-block"><u>B</u>uat Pendaftaran</button>
                            <button disabled id="button_loading" style="display:none;" class="btn btn-navy btn-block"><i class="fa fa-spin fa-spinner"></i> Membuat Pendaftaran</button>
                        </div>
                    </div>                                
                </div>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="pasien_baru_modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div id="modal-dialog" class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Data Pasien Baru</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="pasien_baru_modal_content">
            </div>
        </div>
    </div>
</div>

<script>
    $(function(){
        var session_id = $('#session_id').val();
        LoadViewTindakan(session_id)
        <?php if($id_m_pasien){ ?>
            fillDataPasien('<?=$id_m_pasien?>')
        <?php } ?>
    })
    

    function editPasien(){
        openModalEditPasien($('#lbl_norm').html(), 'fillDataPasien')
    }

    function emptyDataPasien(){
        $('#lbl_nama_pasien').html('')
        $('#lbl_no_identitas').html('')
        $('#lbl_norm').html('')
        $('#lbl_jenis_kelamin').html('')
        $('#lbl_goldar').html('')
        $('#lbl_tempat_lahir').html('')
        $('#lbl_tanggal_lahir').html('')
        $('#lbl_alamat').html('')
        $('#lbl_no_telepon').html('')
        $('#lbl_pekerjaan').html('')
        $('#lbl_kewarganegaraan').html('')
    }

    $('#form_pendaftaran_lab').on('submit', function(e){
        e.preventDefault()
        // $('#content_div_tindakan').hide()
        // $('#button_loading').show()
        // $('#button_submit_pendaftaran').hide()
        if($('#norm_pasien').val() == ''){
            errortoast('Belum ada pasien yang dipilih untuk pendaftaran')
            $('#content_div_tindakan').show()
            $('#button_loading').hide()
            $('#button_submit_pendaftaran').show()
            return false
        }
     

        if($('#cari_tindakan').val() == null){
            errortoast('Belum ada Tindakan yang dipilih')
            $('#content_div_tindakan').show()
            $('#button_loading').hide()
            $('#button_submit_pendaftaran').show()
            return false
        }

        $.ajax({
            url: '<?=base_url("pendaftaran/C_Pendaftaran/pendaftaranLab")?>',
            method: 'post',
            data: $(this).serialize(),
            success: function(datares){
                let obj = JSON.parse(datares)
                if(obj.code == 0){
                    successtoast('Pendaftaran Berhasil Dibuat')
                    window.location=""
                } else {
                    errortoast(obj.message)               
                }
            }, error: function(e){
                errortoast('Terjadi Kesalahan')
            }
        })
    })

    $("#dokter_pengirim").select2({
        tokenSeparators: [',', ' '],
        minimumInputLength: 2,
        minimumResultsForSearch: 10,
        ajax: {
            url: '<?=base_url("pendaftaran/C_Pendaftaran/searchDokter")?>',
            dataType: "json",
            type: "POST",
            data: function (params) {

                var queryParameters = {
                    search_param: params.term
                }
                return queryParameters;
            },
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            text: item.nama_dokter,
                            id: item.custom_value
                        }
                    })
                };
            }
        }
    });

    // $('#dokter_pengirim').on('change', function(){
    //     if($(this).val() != '0'){
    //         let data_dokter = $(this).val().split(';')
    //         $('#data_dokter_pengirim').show()
    //         $('#alamat_dokter_pengirim').val(data_dokter[2])
    //         $('#nomor_telepon_dokter_pengirim').val(data_dokter[3])
    //     } else {
    //         $('#data_dokter_pengirim').hide()
    //         $('#alamat_dokter_pengirim').val('')
    //         $('#nomor_telepon_dokter_pengirim').val('')
    //     }
    // })

    $("#search_pasien").select2({
        tokenSeparators: [',', ' '],
        minimumInputLength: 2,
        minimumResultsForSearch: 10,
        ajax: {
            url: '<?=base_url("pendaftaran/C_Pendaftaran/searchPasienForPendaftaran")?>',
            dataType: "json",
            type: "POST",
            data: function (params) {

                var queryParameters = {
                    search_param: params.term
                }
                return queryParameters;
            },
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            text: item.custom_text,
                            id: item.id
                        }
                    })
                };
            }
        }
    });

    $("#search_pasien").on('change', function(){
        emptyDataPasien()
        fillDataPasien($(this).val())
    })

    function fillDataPasien(id_pasien){
        $('#loader_data_pasien').show()
        $('#data_pasien').hide()
        $('#norm_pasien').val('')
        $.ajax({
            url: '<?=base_url("pendaftaran/C_Pendaftaran/getDataPasienById")?>'+'/'+id_pasien,
            method: 'post',
            data: $(this).serialize(),
            success: function(datares){
                let obj = JSON.parse(datares)
                console.log(obj)
                let jenis_kelamin = 'Laki-laki'
                if(obj.jenis_kelamin == 2){
                    jenis_kelamin = 'Perempuan'
                }
                let tanggal_lahir = obj.tanggal_lahir.split('-')
                let jenis_identitas = obj.jenis_identitas == '0' ? 'TIDAK ADA' : obj.jenis_identitas
                let no_identitas = obj.jenis_identitas == '0' ? '' : obj.nomor_identitas
                $('#norm_pasien').val(obj.norm)
                $('#jenis_kelamin').val(obj.jenis_kelamin)
                $('#tanggal_lahir').val(obj.tanggal_lahir)
                $('#loader_data_pasien').hide()
                $('#data_pasien').show()
                $('#lbl_nama_pasien').html(obj.nama_pasien)
                $('#lbl_no_identitas').html('('+jenis_identitas+') '+no_identitas)
                $('#lbl_norm').html(obj.norm)
                $('#lbl_jenis_kelamin').html(jenis_kelamin)
                $('#lbl_goldar').html(obj.golongan_darah ? obj.golongan_darah : '-')
                $('#lbl_tempat_lahir').html(obj.tempat_lahir ? obj.tempat_lahir : '-')
                $('#lbl_tanggal_lahir').html(tanggal_lahir[2]+'-'+tanggal_lahir[1]+'-'+tanggal_lahir[0])
                $('#lbl_umur').html(obj.umur)
                $('#lbl_alamat').html(obj.alamat)
                $('#lbl_no_telepon').html(obj.nomor_telepon ? obj.nomor_telepon : '-')
                $('#lbl_pekerjaan').html(obj.nama_pekerjaan ? obj.nama_pekerjaan : '-')
                $('#lbl_kewarganegaraan').html(obj.kewarganegaraan)
            }, error: function(e){
                errortoast('Terjadi Kesalahan')
            }
        })
    }

    $('#btn_pasien_baru').on('click', function(){
        reloadFormPasienBaru()
    })

    function reloadFormPasienBaru(){
        $('#pasien_baru_modal_content').html('')
        $('#pasien_baru_modal_content').append(divLoaderNavy)
        $('#pasien_baru_modal_content').load('<?=base_url("pendaftaran/C_Pendaftaran/loadFormPasienBaru")?>', function(){
            $('#loader').hide()
        })
    }

    
    $("#cari_tindakan").select2({
        placeholder: "Cari Tindakan",
        tokenSeparators: [',', ' '],
        minimumInputLength: 2,
        minimumResultsForSearch: 10,
        ajax: {
            url: '<?=base_url("pelayanan/C_Pelayanan/select2Tindakan")?>',
            dataType: "json",
            type: "POST",
            data: function (params) {

                var queryParameters = {
                    search_param: params.term
                }
                return queryParameters;
            },
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            text: item.nm_tindakan,
                            id: item.id_tindakan
                        }
                    })
                };
            }
        }
    });

    function LoadViewTindakan(id = 0, callback = 0){
        $('#content_div_tindakan').html('')
        $('#content_div_tindakan').append(divLoaderNavy)
        $('#content_div_tindakan').load('<?=base_url("pendaftaran/C_Pendaftaran/loadTindakanPendaftaran")?>'+'/'+id, function(){
            $('#loader').hide()
        })
  }


    function createTindakanPendaftaran(){
        var tindakan = $('#cari_tindakan').val();
        var tanggal_lahir = $('#tanggal_lahir').val();
        var jenis_kelamin = $('#jenis_kelamin').val();
        var session_id = $('#session_id').val();
        
        if(tindakan == "" || tindakan == null){
            errortoast('Tindakan Belum dipilih')
            $('#button_submit_input_tindakan').show('fast')
            return false
        }
        if($('#norm_pasien').val() == ''){
            errortoast('Belum ada pasien yang dipilih untuk pendaftaran')
            $('#content_div_tindakan').show()
            $('#button_loading').hide()
            $('#button_submit_pendaftaran').show()
            return false
        }  

				$.ajax({
					url:"<?=base_url("pendaftaran/C_Pendaftaran/insertTindakanPendaftaran")?>",
					method:"post",
					data:{session_id:session_id,tindakan:tindakan,tanggal_lahir:tanggal_lahir,jenis_kelamin:jenis_kelamin},
					success:function(data){
                        let res = JSON.parse(data)
                        if(res.code == 1){
                         errortoast(res.message)
                        } 
                          LoadViewTindakan(session_id)

					} , error: function(e){
                errortoast('Terjadi Kesalahan')
            }
		})
      
    }



</script>