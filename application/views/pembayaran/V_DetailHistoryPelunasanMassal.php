<div class="row">
    <div class="col-3 mb-3">
        <button onclick="searchHistoryPelunasan()" class="btn btn-sm btn-navy"><i class="fa fa-arrow-left"></i> Kembali</button>
    </div>
    <div class="col-3 text-center">
        Jumlah Tagihan:<br>
        <h5><?=count($result)?></h5>
    </div>
    <div class="col-3 text-center">
        Total Tagihan:<br>
        <h5 id="total_tagihan_history"></h5>
    </div>
    <div class="col-3 mb-3 text-right">
        <button onclick="deleteHistoryPelunasanMassal('<?=$id?>')" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i> Hapus</button>
    </div>
    <div class="col-12">
        <?php if($result){ ?>
            <table class="table">
                <thead>
                    <th class="text-center">No</th>
                    <th>Nama Pasien</th>
                    <th>No. LAB</th>
                    <th>Tanggal Pendaftaran</th>
                    <th>Total Tagihan</th>
                </thead>
                <?php $total_tagihan = 0; $no=1; foreach($result as $rs){ 
                    $total_tagihan += $rs['total_tagihan'];
                ?>
                    <tr>
                        <td class="text-center"><?=$no++;?></td>
                        <td><?=$rs['nama_pasien']?></td>
                        <td><?=$rs['nomor_pendaftaran']?></td>
                        <td><?=formatDate($rs['tanggal_pendaftaran'])?></td>
                        <td><?=formatCurrency($rs['total_tagihan'])?></td>
                    </tr>
                <?php } ?>
            </table>
        <?php } ?>
    </div>
</div>
<script>
    $(function(){
        $('#total_tagihan_history').html(rupiahkan('<?=$total_tagihan?>'))
    })

    function rupiahkan(angka){
        var reverse = angka.toString().split('').reverse().join(''),
        ribuan = reverse.match(/\d{1,3}/g);
        ribuan = ribuan.join('.').split('').reverse().join('');
        return "Rp "+ribuan;
    }
</script>