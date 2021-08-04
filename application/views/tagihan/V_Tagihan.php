<style>
    .nav-tabs .nav-item.show .nav-link, .nav-tabs .nav-link.active{
        color: white !important;
        background-color: #001f3f !important;
        border-color: #001f3f #001f3f #fff;
        font-weight: bold !important;
    }

    .nav-tabs .nav-item.show .nav-link, .nav-tabs .nav-link{
        color: #001f3f !important;
        background-color: #fff !important;
        border-color: #dde2e6 #dde2e6 #dde2e6;
        font-weight: bold !important;
    }
</style>
<script src="<?=base_url('assets/js/bootstrap-datetimepicker.js')?>"></script>
<div class="row" id="div_tagihan_header">
</div>
<div class="row">
    <div class="col-12"><hr></div>
    <div class="col-12">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a data-toggle="tab" class="nav-link active" onclick="loadRincianTagihan('<?=$id_pendaftaran?>')" href="#rincian_tagihan_tab"><span class="text_tab">Rincian Tagihan</span></a>
            </li>
            <li class="nav-item">
                <a data-toggle="tab" class="nav-link" onclick="loadPembayaran('<?=$id_pendaftaran?>')" href="#pembayaran_tab"><span class="text_tab">Pembayaran</span></a>
            </li>
            <li class="nav-item">
                <a data-toggle="tab" class="nav-link" onclick="loadUangMuka('<?=$id_pendaftaran?>')" href="#uang_muka_tab"><span class="text_tab">Uang Muka</span></a>
            </li>
        </ul>
        <div class="tab-content">
            <div id="rincian_tagihan_tab" class="tab-pane active">
                
            </div>
            <div id="pembayaran_tab" class="tab-pane">
            </div>
            <div id="uang_muka_tab" class="tab-pane">
            </div>
        </div>
    </div>
</div>
<script>
    $(function(){
        loadTagihanHeader('<?=$id_pendaftaran?>')
        loadRincianTagihan('<?=$id_pendaftaran?>')
    })

    function loadTagihanHeader(id){
        $('#div_tagihan_header').html('')
        $('#div_tagihan_header').append(divLoaderNavy)
        $('#div_tagihan_header').load('<?=base_url("tagihan/C_Tagihan/loadTagihanHeader")?>'+'/'+id, function(){
            $('#loader').hide()
        })
    }

    function loadRincianTagihan(id){
        $('#rincian_tagihan_tab').html('')
        $('#rincian_tagihan_tab').append(divLoaderNavy)
        $('#rincian_tagihan_tab').load('<?=base_url("tagihan/C_Tagihan/loadRincianTagihan")?>'+'/'+id, function(){
            $('#loader').hide()
        })
    }

    function loadPembayaran(id){
        $('#pembayaran_tab').html('')
        $('#pembayaran_tab').append(divLoaderNavy)
        $('#pembayaran_tab').load('<?=base_url("pembayaran/C_Pembayaran/loadPembayaran")?>'+'/'+id, function(){
            $('#loader').hide()
        })
    }

    function loadUangMuka(id){
        $('#uang_muka_tab').html('')
        $('#uang_muka_tab').append(divLoaderNavy)
        $('#uang_muka_tab').load('<?=base_url("pembayaran/C_Pembayaran/loadUangMuka")?>'+'/'+id, function(){
            $('#loader').hide()
        })
    }
</script>
