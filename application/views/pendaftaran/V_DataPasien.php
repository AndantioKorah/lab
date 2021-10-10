
<div class="row">
    <div class="col-3 pl-4 pr-3" id="div_data_pasien"></div>
    <div class="col-9 pl-3">
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
    let id_m_pasien = '<?=$id_m_pasien?>'
    let diskon_nominal_counter;

    $(function(){
        loadProfilPasien()
        loadListPendaftaranPasien()
    })

    function loadProfilPasien(){
        $('#div_data_pasien').html('')
        $('#div_data_pasien').append(divLoaderNavy)
        $('#div_data_pasien').load('<?=base_url("pendaftaran/C_Pendaftaran/loadProfilPasien")?>'+'/'+id_m_pasien, function(){
            $('#loader').hide()
        })
    }

    function loadListPendaftaranPasien(){
        $('#label_card_header').html('LIST PENDAFTARAN')
        $('#btn_list_pendaftaran').hide()

        $('#div_detail_pendaftaran').html('')
        $('#div_detail_pendaftaran').hide()

        $('#content_div_transaksi').html('')
        $('#content_div_transaksi').append(divLoaderNavy)
        $('#content_div_transaksi').load('<?=base_url("pendaftaran/C_Pendaftaran/loadListPendaftaranPasien")?>'+'/'+id_m_pasien, function(){
            $('#loader').hide()
        })
    }
    
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

    function setHeader(title = ''){
        $('#btn_list_pendaftaran').show()
        $('#label_card_header').html(title.toUpperCase())
    }

    function openTagihan(id_t_pendaftaran, id_pasien = 0){
        setHeader('tagihan')
        $('[data-tooltip="tooltip_detail_pendaftaran_left"]').tooltip('hide')
        loadDetailPendaftaran(id_t_pendaftaran)
        $('#content_div_transaksi').html('')
        $('#content_div_transaksi').append(divLoaderNavy)
        $('#content_div_transaksi').load('<?=base_url("tagihan/C_Tagihan/loadTagihan")?>'+'/'+id_t_pendaftaran, function(){
            $('#loader').hide()
        })
    }

    function LoadViewInputTindakan(id = 0, callback = 0, id_pasien = 0){
        setHeader('tindakan')
        $('[data-tooltip="tooltip_detail_pendaftaran_left"]').tooltip('hide')
        loadDetailPendaftaran(id)
        $('#content_div_transaksi').html('')
        $('#content_div_transaksi').append(divLoaderNavy)
        $('#content_div_transaksi').load('<?=base_url("pelayanan/C_Pelayanan/loadViewInputTindakan")?>'+'/'+id, function(){
            $('#loader').hide()
        })
  }

</script>