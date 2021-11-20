<style>
    .format_str{
        mso-number-format:\@;
        border: 1px solid black;
        padding: 5px;
    }
</style>
<?php if($result){ 
    $filename = 'Laporan Pendaftaran per Pasien '.date('dmYhis').'.xls';
    header("Content-type: application/vnd-ms-excel");
    header("Content-Disposition: attachment; filename=$filename"); 
?>
    <div class="row">
        <center><strong>LAPORAN PENDAFTARAN PER PASIEN</strong></center>
        <center>Range Tanggal: <?=$parameter['range_tanggal']?></center>
    </div>
    <table class="table" style="width: 100%; border: 1px solid black;">
        <thead>
            <th class="format_str text-center">NO</th>
            <th class="format_str text-center">NAMA PASIEN</th>
            <th class="format_str text-center">TGL. PENDAFTARAN</th>
            <th class="format_str text-center">NO. PENDAFTARAN</th>
            <th class="format_str text-center">DOKTER PENGIRIM</th>
            <th class="format_str text-center">TOTAL TAGIHAN</th>
            <th class="format_str text-center">STATUS TAGIHAN</th>
        </thead>
        <tbody>
        <?php $no = 1; foreach($result as $rs){ ?>
            <tr>
                <td class="format_str" style="text-align: center;"><?=$no++;?></td>
                <td class="format_str" style="text-align: left;"><?=$rs['nama_pasien']?></td>
                <td class="format_str" style="text-align: center;"><?=formatDate($rs['tanggal_pendaftaran'])?></td>
                <td class="format_str" style="text-align: center;"><?=strval($rs['nomor_pendaftaran'])?></td>
                <td class="format_str" style="text-align: left;"><?=$rs['nama_dokter_pengirim']?></td>
                <td class="format_str" style="text-align: left;"><?=formatCurrency($rs['total_tagihan'])?></td>
                <td class="format_str" style="text-align: center;"><?=$rs['flag_active'] == 0 ? 'Dihapus' : $rs['status_tagihan']?></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
<?php } ?>