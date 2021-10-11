<style>
    .tbody_rincian_tagihan {
        display:block;
        max-height:350px;
        overflow:auto;
    }
    .thead_rincian_tagihan, .tbody_rincian_tagihan tr {
        display:table;
        width:100%;
        table-layout:fixed;
    }
    .thead_rincian_tagihan {
        width: calc( 100% - 1em )
    }
</style>
<div class="row">
    <div class="col-12 mt-3 mb-3 text-left">
        <?php if($rincian_tagihan){ ?>
            <button class="btn btn-sm btn-navy" onclick="cetakRincianTagihan()"><i class="fa fa-print"></i> Cetak Rincian Tagihan</button>
        <?php } ?>
    </div>
    <div class="col-12">
        <table class="table table-sm table-hover">
            <thead class="thead_rincian_tagihan">
                <th class="text-center" style="width: 5%;">NO</th>
                <th style="width: 50%;">TAGIHAN</th>
                <th style="width: 15%;" class="text-left">BIAYA</th>
                <th style="width: 30%;" class="text-center">TANGGAL INPUT</th>
            </thead>
            <tbody class="tbody_rincian_tagihan">
                <?php if($rincian_tagihan){ $no=1; $no_detail_tindakan = 1; foreach($rincian_tagihan as $rt){ 
                    ?>
                    <tr style="cursor: pointer;">
                        <td style="width: 5%;" class="text-center"><b style=""><?=$no;?></b></td>
                        <td style="width: 50%;"><b style=""><?=strtoupper($rt['nm_jns_tindakan'])?></b></td>
                        <td style="width: 15%;" class="text-left"></td>
                        <td style="width: 30%;" class="text-center"></td>
                        <?php
                        if($rt['detail_tagihan']){
                            usort($rt['detail_tagihan'], function($a, $b) {
                                $ad = new DateTime($a['created_date']);
                                $bd = new DateTime($b['created_date']);
                                if ($ad == $bd) {
                                    return 0;
                                }
                                return $ad > $bd ? -1 : 1;
                            });
                        $no_detail_tagihan = 1;
                        foreach($rt['detail_tagihan'] as $dt){ ?>
                        <tr style="cursor: pointer;" onclick="openTrDetailTindakan('<?=$dt['id']?>')">
                            <td style="width: 5%;" class="text-center"><b><?=$no.'.'.$no_detail_tagihan;?></b></td>
                            <td style="width: 50%;"><b><?=$dt['nama_tagihan']?></b></td>
                            <td style="width: 15%;" class="text-left"><b><?=formatCurrency($dt['biaya'])?></b></td>
                            <td style="width: 30%;" class="text-center"><b><?=formatDate($dt['created_date'])?></b></td>
                        </tr>
                        <?php if($dt['detail_tindakan']){foreach($dt['detail_tindakan'] as $d) { ?>
                        <tr class="tr_detail_tindakan_<?=$dt['id']?>" style="display: none;">
                            <td style="width: 5%;"></td>
                            <td colspan=3 style="width: 95%;"><?=$d?></td>
                        </tr>
                        <?php $no_detail_tindakan++; } } $no_detail_tagihan++; } } ?>
                        <tr>
                            <td style="width: 5%;"></td>
                            <td style="width: 50%;" class="text-right"><b style="font-size: 18px;">TOTAL <?=$rt['nm_jns_tindakan']?> :</b></td>
                            <td style="width: 15%;" class="text-left"><b style="font-size: 18px;"><?=formatCurrency($rt['total_biaya'])?></b></td>
                            <td style="width: 30%;" class="text-center"></td>
                        </tr>
                    </tr>
                <?php $no++; } ?> 
                <script>
                    function cetakRincianTagihan() {
                        $("#print_div").load('<?= base_url('tagihan/C_Tagihan/cetakRincianTagihan/'.$id_pendaftaran)?>',
                            function () {
                                printSpace('print_div');
                            });
                    }

                    function printSpace(elementId) {
                        var isi = document.getElementById(elementId).innerHTML;
                        window.frames["print_frame"].document.title = document.title;
                        window.frames["print_frame"].document.body.innerHTML = isi;
                        window.frames["print_frame"].window.focus();
                        window.frames["print_frame"].window.print();
                    }

                    function openTrDetailTindakan(id){
                        $('.tr_detail_tindakan_'+id).toggle()
                    }
                </script>
                <?php } else { ?>
                    <tr>
                        <td colspan="4">BELUM ADA DATA</td>
                    </tr>
                <?php } ?>
            </tbody>
        </table> 
    </div>
</div>