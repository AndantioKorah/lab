<style>
    @page{
        page: A4;
        margin-top: 150px;
    }

    .text-center{
        text-align: center;
        mso-number-format:\@;
        font-family: 'Verdana';
    }
    .text-right{
        text-align: right;
        mso-number-format:\@;
        font-family: 'Verdana';
    }
    .text-left{
        text-align: left;
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
    .th-table-rekap-harian{
        padding: 5px;
        border: 1px solid black;
        font-size: 14px;
    }
    .td-table-rekap-harian{
        padding: 5px;
        border: 1px solid black;
        font-size: 14px;
        vertical-align: top;
    }
</style>
<table style="width: 100%;">
    <thead>
        <th>
            <div class="row" >
                <div class="col-12 text-center">
                    <span class="card-title-search-result-rekap-harian"><strong>REKAPITULASI HARIAN</strong></span>
                </div>
                <div class="text-center" style="margin-top: 10px;">
                    <span class="label-text-bigger">Tanggal</span>
                    <span class="text-bigger">: <?=$parameter['range_tanggal']?>
                </div>
                <div class="text-center" style="margin-top: 10px;display:none">
                    <span class="label-text-bigger">Total Pendaftaran</span>
                    <span class="text-bigger">: <?=formatCurrencyWithoutRp($jumlah_pendaftaran)?>
                </div>
                <div class="text-center" style="margin-top: 10px;display:none">
                    <span class="label-text-bigger">Total Pelunasan</span>
                    <span class="text-bigger">: <?=formatCurrency($total_pembayaran)?>
                </div>
                <div class="text-center" style="margin-top: 10px;display:none">
                    <span class="label-text-bigger">Total Uang Muka</span>
                    <span class="text-bigger">: <?=formatCurrency($total_uang_muka)?>
                </div>
                <div class="text-center" style="margin-top: 10px;display:none">
                    <span class="label-text-bigger">Total Belum Bayar</span>
                    <span class="text-bigger">: <?=formatCurrency($total_belum_bayar)?>
                </div>
                <div class="text-center" style="margin-top: 10px; margin-bottom: 10px;display:none">
                    <span class="label-text-bigger">Total Penerimaan</span>
                    <span class="text-bigger">: <?=formatCurrency($total_penerimaan)?>
                </div>
            </div>
        </th>
    </thead>
    <tbody>
        <tr>
            <td>
                <?php if($result){ ?>
                    <table class="table" style="width:100%; border: 1px solid black; border-collapse: collapse;">
                        <thead>
                            <tr>
                                <th class="text-center th-table-rekap-harian" rowspan=2>NO</th>
                                <th class="text-center th-table-rekap-harian" rowspan=2>NO. PENDAFTARAN</th>
                                <th class="text-center th-table-rekap-harian" rowspan=2>NAMA PASIEN</th>
                                <th class="text-center th-table-rekap-harian" rowspan=1 colspan=2>PEMBAYARAN</th>
                                <th class="text-center th-table-rekap-harian" rowspan=2>BELUM BAYAR</th>
                            </tr>
                            <tr>
                                <th class="text-center th-table-rekap-harian" rowspan=1>UANG MUKA</th>
                                <th class="text-center th-table-rekap-harian" rowspan=1>PELUNASAN</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php $no = 1;
                        foreach($result as $rs){
                            $belum_bayar = $rs['total_tagihan'] - ($rs['uang_muka'] + $rs['jumlah_bayar']);
                        ?>
                            <tr>
                                <td class="text-center td-table-rekap-harian"><?=$no++;?></td>
                                <td class="text-center td-table-rekap-harian"><?=$rs['nomor_pendaftaran']?></td>
                                <td class="text-left td-table-rekap-harian"><?=$rs['nama_pasien']?></td>
                                <td class="text-center td-table-rekap-harian"><?=formatCurrency($rs['uang_muka'])?></td>
                                <td class="text-center td-table-rekap-harian"><?=formatCurrency($rs['jumlah_bayar'])?></td>
                                <td class="text-center td-table-rekap-harian"><?=formatCurrency($belum_bayar)?></td>
                                <td>
                            </tr>
                           
                        <?php } ?>
                        <tr>
                            <td class="text-right td-table-rekap-harian" colspan="3">TOTAL</td>
                            <td class="text-center td-table-rekap-harian"><?=formatCurrency($total_uang_muka)?></td>
                            <td class="text-center td-table-rekap-harian"><?=formatCurrency($total_pembayaran)?></td>
                            <td class="text-center td-table-rekap-harian"><?=formatCurrency($total_belum_bayar)?></td>
                            </tr>
                            <?php $penerimaan_tunai = $total_uang_muka + $total_pembayaran;?>
                            <tr>
                            <td class="text-left td-table-rekap-harian" colspan="3">Penerimaan Tunai</td>
                            <td class="text-center td-table-rekap-harian"><?=formatCurrency($penerimaan_tunai)?></td>
                            <td class="text-center td-table-rekap-harian"></td>
                            <td class="text-center td-table-rekap-harian"></td>
                            </tr>
                            <tr>
                            <td class="text-left td-table-rekap-harian" colspan="3">Jumlah Piutang</td>
                            <td class="text-center td-table-rekap-harian"></td>
                            <td class="text-center td-table-rekap-harian"></td>
                            <td class="text-center td-table-rekap-harian"><?=formatCurrency($total_belum_bayar)?></td>
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