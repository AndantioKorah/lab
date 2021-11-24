<style>
    @page{
        size: A4;
        margin-top: 150px;
    }

    .format_str{
        mso-number-format:\@;
        font-size: 12px;
        font-family: Verdana;
        font-weight: normal;
        padding: 3px;
        border: 1px solid black;
    }

    .title_print_laporan{
        font-size: 16px;
        font-family: Verdana;
    }

    .title_print_laporan_parameter{
        margin-top: 5px;
        font-size: 14px;
        font-family: Verdana;
        margin-bottom: 10px;
    }
</style>
<?php if($result){ ?>
    <table style="width: 100%;">
        <thead>
            <th>
                <center class="title_print_laporan">LAPORAN FEE DOKTER</center>
                <center class="title_print_laporan_parameter">Range Tanggal: <?=$parameter['range_tanggal']?></center>
            </th>
        </thead>
        <tbody>
            <tr>
                <td>
                    <table class="table" style="width: 100%; border-collapse: collapse; border: 1px solid black;">
                        <thead>
                            <th class="format_str text-center">NO</th>
                            <th class="format_str text-center">NAMA PASIEN</th>
                            <th class="format_str text-center">NO. LAB</th>
                            <th class="format_str text-center">TGL. PENDAFTARAN</th>
                            <th class="format_str text-center">TOT. TAGIHAN</th>
                            <th class="format_str text-center">%</th>
                            <th class="format_str text-center">FEE</th>
                        </thead>
                        <tbody>
                            <?php $no = 1; foreach($result as $rs){ ?>
                                <tr>
                                    <td class="format_str" style="text-align: center; font-weight: bold;"><?=$no?></td>
                                    <td colspan=3 class="format_str" style="text-align: left; font-weight: bold;"><?=$rs['nama_dokter']?></td>
                                    <td class="format_str" style="text-align: right; font-weight: bold;;"><?=formatCurrencyWithoutRp($rs['total_tagihan'])?><a style="display: none; color: white">.</a></td>
                                    <td class="format_str" style="text-align: center; font-weight: bold;"><?=$rs['fee']?>%<a style="display: none; color: white">.</a></td>
                                    <td class="format_str" style="text-align: right; font-weight: bold;"><?=formatCurrencyWithoutRp($rs['total_tagihan'] * $rs['fee'] / 100)?><a style="display: none; color: white">.</a></td>
                                </tr>
                                <?php $no_list_pasien = 1; foreach($rs['list_pasien'] as $lp){ ?>
                                    <tr>
                                        <td class="format_str" style="text-align: center;"><?=$no.'.'.$no_list_pasien?></td>
                                        <td class="format_str" style="text-align: left;"><?=$lp['nama_pasien']?></td>
                                        <td class="format_str" style="text-align: center;"><?=$lp['nomor_pendaftaran']?></td>
                                        <td class="format_str" style="text-align: center;"><?=formatDate($lp['tanggal_pendaftaran'])?></td>
                                        <td class="format_str" style="text-align: right;"><?=formatCurrencyWithoutRp($lp['total_tagihan'])?></td>
                                        <td class="format_str" style="text-align: center;"><?=$rs['fee']?>%<a style="display: none; color: white">.</a></td>
                                        <td class="format_str" style="text-align: right;"><?=formatCurrencyWithoutRp($lp['total_tagihan'] * $rs['fee'] / 100)?><a style="display: none; color: white">.</a></td>
                                    </tr>
                                <?php $no_list_pasien++; } ?>
                            <?php $no++; } ?>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
<?php } ?>