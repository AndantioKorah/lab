<div class="row" id="div_menu">
    <div class="col-12">
        <div class="card card-default">
            <div class="card-header">
                <div class="row">
                    <div class="col-6" style="top: 50%;">
                        <h3 class="card-title"><strong>LIST PENDAFTARAN PASIEN</strong></h3>
                    </div>
                    <div class="col-6 text-right">
                        <button class="btn btn-sm btn-navy" onclick="submitFormSearchMenuListPendaftaran()"><i class="fa fa-sync"></i> Refresh Pendaftaran</button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <form id="formSearchMenuListPendaftaran">
                            <label>Tanggal</label>
                            <input class="form-control form-control-sm datepicker" autocomplete="off" name="range_tanggal" id="range_tanggal"/>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12" id="div_list_pendaftaran">
        <div class="card card-default">
            <div class="card-body">
                <div class="row">
                    <div class="col-12" id="divListPendaftaran">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row" style="display: none;" id="div_detail">
    <div class="col-3" id="div_data_pasien">
    </div>
    <div class="col-9">
        <div class="card card-default">
            <div class="card-header">
                <span id="label_card_header" style="font-size: 20px; font-weight: bold;">LIST PENDAFTARAN</span>
                <button onclick="loadListPendaftaranPasien()" id="btn_list_pendaftaran" style="display: none;" class="btn btn-sm btn-navy float-right"><i class="fa fa-list"></i> LIST PENDAFTARAN</button>
            </div>
            <div class="card-body" id="content_div_transaksi">
            </div>
        </div>
    </div>
</div>
<script>
    let id_m_pasien = 0;

    $(function(){
        $('.datepicker').daterangepicker({
            locale: {
                format: 'DD/MM/YYYY'
            }
        })
        submitFormSearchMenuListPendaftaran()
    }) 

    $('#range_tanggal').on('change', function(){
        submitFormSearchMenuListPendaftaran()
    })

    function loadListPendaftaranPasien(){
        $('#label_card_header').html('LIST PENDAFTARAN')
        $('#btn_list_pendaftaran').hide()

        $('#div_detail_pendaftaran').html('')
        $('#div_detail_pendaftaran').hide()

        $('#div_menu').show()
        $('#div_detail').hide()

        submitFormSearchMenuListPendaftaran()
    }

    function submitFormSearchMenuListPendaftaran(){
        $('#formSearchMenuListPendaftaran').submit()
    }

    $('#formSearchMenuListPendaftaran').on('submit', function(e){
        e.preventDefault()
        $('#divListPendaftaran').html('')
        $('#divListPendaftaran').append(divLoaderNavy)
        $.ajax({
            url: '<?=base_url("pendaftaran/C_Pendaftaran/searchMenuListPendaftaran")?>',
            method: 'post',
            data: $(this).serialize(),
            success: function(data){
                $('#divListPendaftaran').html('')
                $('#divListPendaftaran').append(data)
            }, error: function(err){
                console.log(err)
                errortoast('Terjadi Kesalahan')
            }
        })
    })

    function loadDetailPendaftaran(id_pendaftaran, is_refresh_tagihan = 0){
        $('#div_detail_pendaftaran').show()
        $('#div_detail_pendaftaran').html('')
        $('#div_detail_pendaftaran').append(divLoaderNavy)
        $('#div_detail_pendaftaran').load('<?=base_url("pendaftaran/C_Pendaftaran/loadDetailPendaftaran")?>'+'/'+id_pendaftaran, function(){
            $('#loader').hide()
        })
        if($('#label_card_header').html() == 'TAGIHAN' && is_refresh_tagihan == 1){
            openTagihan(id_pendaftaran)
        }
    }

    function loadProfilPasien(id_pendaftaran){
        $('#div_menu').hide()
        $('#div_detail').show()

        $('#div_data_pasien').html('')
        $('#div_data_pasien').append(divLoaderNavy)
        $('#div_data_pasien').load('<?=base_url("pendaftaran/C_Pendaftaran/loadProfilPasien")?>'+'/'+id_m_pasien, function(){
            $('#loader').hide()
            loadDetailPendaftaran(id_pendaftaran)
        })

    }

    function setHeader(title = ''){
        $('#btn_list_pendaftaran').show()
        $('#label_card_header').html(title.toUpperCase())
    }

    function openTagihan(id_t_pendaftaran = 0, id_pasien = 0, isLoadProfilePasien = 0){
        id_m_pasien = id_pasien
        if(isLoadProfilePasien == 1){
            loadProfilPasien(id_t_pendaftaran)
        }
        setHeader('tagihan')
        // loadDetailPendaftaran(id_t_pendaftaran)
        $('#content_div_transaksi').html('')
        $('#content_div_transaksi').append(divLoaderNavy)
        $('#content_div_transaksi').load('<?=base_url("tagihan/C_Tagihan/loadTagihan")?>'+'/'+id_t_pendaftaran, function(){
            $('#loader').hide()
        })
    }

    function LoadViewInputTindakan(id = 0, callback = 0, id_pasien = 0, isLoadProfilePasien = 0){
        id_m_pasien = id_pasien
        if(isLoadProfilePasien == 1){
            loadProfilPasien(id)
        }
        setHeader('tindakan')
        // loadDetailPendaftaran(id)
        $('#content_div_transaksi').html('')
        $('#content_div_transaksi').append(divLoaderNavy)
        $('#content_div_transaksi').load('<?=base_url("pelayanan/C_Pelayanan/loadViewInputTindakanNew")?>'+'/'+id, function(){
            $('#loader').hide()
        })
  }
</script>