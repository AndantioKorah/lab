<style>
    @page{
        page: A4;
    }
    .text-center{
        text-align: center;
        mso-number-format:\@;
        font-family: 'Verdana';
    }
    .text-bigger{
        font-size: 16px;
        font-weight: bold;
        font-family: 'Verdana';
    }
    .card-title-search-result-rekap-harian{
        font-weight: bold;
        font-size: 18px;
        font-family: 'Verdana';
    }
    .label-text-bigger{
        font-weight: bold;
        font-size: 14px;
        font-family: 'Verdana';
    }
    .format_str{
        padding: 5px;
        border: 1px solid black;
        font-size: 14px;
        mso-number-format:\@;
    }
</style>
<?php if($result){ 
    $filename = 'Rekap Harian '.formatDateNamaBulan(date('Y-m-d H:i:s')).'.xls';
    header("Content-type: application/vnd-ms-excel");
    header("Content-Disposition: attachment; filename=$filename"); 
?>
<table style="width: 100%;">
    <thead>
        
    </thead>
    <tbody>
        <tr>
            <td>
                <?php if($result){ ?>
                    <table class="table" style="width:100%; border: 1px solid black; border-collapse: collapse;">
                        <thead>
                            <tr>
                                <th class="format_str" rowspan=2>NO</th>
                                <th class="format_str" rowspan=2>NO. PENDAFTARAN</th>
                                <th class="format_str" rowspan=2>NAMA PASIEN</th>
                                <th class="format_str" rowspan=1 colspan=2>PEMBAYARAN</th>
                                <th class="format_str" rowspan=2>BELUM BAYAR</th>
                            </tr>
                            <tr>
                                <th class="format_str" rowspan=1>UANG MUKA</th>
                                <th class="format_str" rowspan=1>PELUNASAN</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php $no = 1;
                        foreach($result as $rs){
                            $belum_bayar = $rs['total_tagihan'] - ($rs['uang_muka'] + $rs['jumlah_bayar']);
                            if($rs['id_m_status_tagihan'] == 2){
                                $belum_bayar = 0;
                            }
                        ?>
                            <tr>
                                <td class="format_str" style="text-align: center;"><?=$no++;?></td>
                                <td class="format_str" style="text-align: center;"><?=$rs['nomor_pendaftaran']?></td>
                                <td class="format_str"><?=$rs['nama_pasien']?></td>
                                <td class="format_str" style="text-align: center;"><?=formatCurrency($rs['uang_muka'])?></td>
                                <td class="format_str" style="text-align: center;"><?=formatCurrency($rs['jumlah_bayar'])?></td>
                                <td class="format_str" style="text-align: center;"><?=formatCurrency($belum_bayar)?></td>
                            </tr>
                          
                            
                        <?php } ?>
                        <tr>
                                                <td colspan="6">
            <div class="row">
                <div class="col-12 text-center">
                <div class="text-center" style="margin-top: 10px;">
                <span class="card-title-search-result-rekap-harian"><strong>REKAPITULASI HARIAN</strong></span>
                  
                </div>
                    
                </div>
                <div class="text-center" style="margin-top: 10px;">
                    <span class="label-text-bigger">Tanggal</span>
                    <span class="text-bigger">: <?=$parameter['range_tanggal']?>
                </div>
                <div class="text-center" style="margin-top: 10px;">
                    <span class="label-text-bigger">Total Pendaftaran</span>
                    <span class="text-bigger">: <?=formatCurrencyWithoutRp($jumlah_pendaftaran)?>
                </div>
                <div class="text-center" style="margin-top: 10px;">
                    <span class="label-text-bigger">Total Pelunasan</span>
                    <span class="text-bigger">: <?=formatCurrency($total_pembayaran)?>
                </div>
                <div class="text-center" style="margin-top: 10px;">
                    <span class="label-text-bigger">Total Uang Muka</span>
                    <span class="text-bigger">: <?=formatCurrency($total_uang_muka)?>
                </div>
                <div class="text-center" style="margin-top: 10px;">
                    <span class="label-text-bigger">Total Belum Bayar</span>
                    <span class="text-bigger">: <?=formatCurrency($total_belum_bayar)?>
                </div>
                <div class="text-center" style="margin-top: 10px; margin-bottom: 10px;">
                    <span class="label-text-bigger">Total Penerimaan</span>
                    <span class="text-bigger">: <?=formatCurrency($total_penerimaan)?>
                </div>
            </div>
        </td>
                            </tr>
                        </tbody>
                    </table>
                <?php } else { ?>
                    <h6 class="text-center">Data Tidak Ditemukan</h6>
                <?php } ?>
            </td>
        </tr>
    </tbody>
</table>
<?php } ?>