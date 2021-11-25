<style>
    .format_str{
        mso-number-format:\@;
        border: 1px solid black;
        padding: 5px;
    }
</style>
<?php if($result){ 
    $filename = 'Laporan Fee Dokter '.date('dmYhis').'.xls';
    header("Content-type: application/vnd-ms-excel");
    header("Content-Disposition: attachment; filename=$filename"); 
?>
    <div class="row">
        <center><strong>LAPORAN FEE DOKTER</strong></center>
        <center>Range Tanggal: <?=$parameter['range_tanggal']?></center>
    </div>
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
<?php } ?>