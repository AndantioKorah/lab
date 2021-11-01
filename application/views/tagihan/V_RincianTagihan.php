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
                <!-- <th class="text-center" style="width: 5%;">NO</th> -->
                <th>TAGIHAN</th>
                <th class="text-left">BIAYA</th>
                <th class="text-center">TANGGAL INPUT</th>
            </thead>
            <tbody class="tbody_rincian_tagihan">
                <?php if($rincian_tagihan){ foreach($rincian_tagihan as $rt){ 
                    $nama_tindakan = isset($rt['nama_tindakan']) ? $rt['nama_tindakan'] : $rt['nama_tagihan'];
                    $biaya = isset($rt['biaya']) && $rt['biaya'] ? formatCurrency($rt['biaya']) : '';
                    $tanggal_input = isset($rt['id_t_tagihan']) ? formatDate($rt['created_date']) : '';

                    $style = 'padding-left: '.$rt['padding-left'].'px;';
                    if(isset($rt['nama_tindakan']) && $rt['id_m_jns_tindakan'] == 0){
                        $nama_tindakan = strtoupper($nama_tindakan);
                        $style .= 'font-size: 20px; font-weight: bold;';
                    } else {
                        $style .= 'font-weight: bold;';
                    }
                    ?>
                    <tr>
                        <!-- <td style="width: 5%;" class="text-center"><b style=""></b></td> -->
                        <td style="<?=$style?>"><?=$nama_tindakan?></td>
                        <td class="text-left"><strong><?=$biaya?></strong></td>
                        <td class="text-center"><strong><?=$tanggal_input?></strong></td>
                    </tr>
                <?php } ?> 
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