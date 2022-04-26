<style>
    .span_label{
        color: black;
        font-weight: bold;
        font-size: 14px;
    }
</style>
<?php if($tagihan){ ?>
    <input style="display: none;" id="total_tagihan_header" value="<?=formatCurrencyWithoutRp($tagihan['total_tagihan'])?>" />
    <input style="display: none;" id="sisa_tagihan_header" value="<?=formatCurrencyWithoutRp($sisa_harus_bayar)?>" />
    <div class="col text-center">
        <span class="span_label">Total Tagihan:</span><br>
        <h2><?=formatCurrency($tagihan['total_tagihan'])?></h2>
        <?php
            if($tagihan['flag_diskon'] == 1){
                $diskon_tagihan = formatCurrency($tagihan['diskon_nominal']);
                if($tagihan['diskon_presentase'] && $tagihan['diskon_presentase'] > 0){
                    $diskon_tagihan = '('.$tagihan['diskon_presentase'].'%) '.$diskon_tagihan;
                }
            ?>
            <h6>Diskon : <?=$diskon_tagihan?></h6>
            <button id="btn_delete_diskon_tagihan" onclick="deleteDiskonTagihan('<?=$tagihan['id']?>')" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i> Hapus Diskon</button>
            <button style="display: none;" disabled id="btn_loading_delete_diskon_tagihan" class="btn btn-sm btn-danger"><i class="fa fa-spin fa-spinner"></i> Menghapus...</button>
            <?php
            }
        ?>
    </div>
    <div class="col text-center">
        <span class="span_label">Total Pembayaran:</span><br>
        <?php if($pembayaran){
            $diskon = null;
            if($pembayaran['diskon_nominal'] && $pembayaran['diskon_nominal'] > 0){
                $diskon = formatCurrency($pembayaran['diskon_nominal']);
                if($pembayaran['diskon_presentase'] && $pembayaran['diskon_presentase'] > 0){
                    $diskon = '('.$pembayaran['diskon_presentase'].'%) '.$diskon;
                }
            }
        ?>
            <h2><?=formatCurrency($pembayaran['jumlah_pembayaran'])?></h2>
            <?php if($diskon){ ?>
                <h6>Diskon : <?=$diskon?></h6>
            <?php } ?>
        <?php } else { ?>
            <h2><?=formatCurrency(0)?></h2>
        <?php } ?>
    </div>
    <div class="col text-center">
        <span class="span_label">Total Uang Muka:</span><br>
        <?php if($uang_muka){ ?>
            <h2><?=formatCurrency($uang_muka['jumlah_pembayaran'])?></h2>
        <?php } else { ?>
            <h2><?=formatCurrency(0)?></h2>
        <?php } ?>
    </div>
    <div class="col text-center">
        <span class="span_label">Sisa Harus Bayar:</span><br>
        <h2><?=formatCurrency($sisa_harus_bayar)?></h2>
    </div>
    <script>
        function deleteDiskonTagihan(id){
            if(confirm('Apakah Anda yakin?')){
                $('#btn_loading_delete_diskon_tagihan').show()
                $('#btn_delete_diskon_tagihan').hide()
                $.ajax({
                    url: '<?=base_url("tagihan/C_Tagihan/deleteDiskonTagihan")?>'+'/'+id,
                    method: 'post',
                    data: null,
                    success: function(res){
                        let rs = JSON.parse(res)
                        if(rs.code == 0){
                            loadTagihanHeader('<?=$tagihan['id_t_pendaftaran']?>')
                            $('#diskon_tagihan_nav').show()
                            loadPembayaran('<?=$tagihan['id_t_pendaftaran']?>')
                        } else {
                            errortoast(rs.message)
                            $('#btn_loading_delete_diskon_tagihan').hide()
                            $('#btn_delete_diskon_tagihan').show()
                        }
                    }, error: function(){
                        errortoast('Terjadi Kesalahan')
                        $('#btn_loading_delete_diskon_tagihan').hide()
                        $('#btn_delete_diskon_tagihan').show()
                    }
                })
            }
        }
    </script>
<?php } else { ?>
    <div class="row">
        <div class="col-12 text-center">
            <h6><i class="fa fa-exclamation"></i> TAGIHAN TIDAK DITEMUKAN</h6>
        </div>
    </div>
<?php } ?>