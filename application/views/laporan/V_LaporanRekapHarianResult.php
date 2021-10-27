<style>
    .text-bigger{
        font-size: 18px;
        font-weight: bold;
    }
</style>
<div class="card card-default">
    <div class="card-header">
        <div class="row">
            <div class="col-12 text-center">
                <h5 class="card-title-search-resukt-laporan-custom"><strong>REKAPITULASI HARIAN</strong></h5>
            </div>
            <div class="col-6 text-right"><h6>Range Tanggal :</h6></div>
            <div class="col-6 text-left"><h6 class="text-bigger"><?=$parameter['range_tanggal']?></h6></div>
            <div class="col-6 text-right"><h6>Total Pendaftaran :</h6></div>
            <div class="col-6 text-left"><h6 class="text-bigger"><?=formatCurrencyWithoutRp($jumlah_pendaftaran)?></h6></div>
            <div class="col-6 text-right"><h6>Total Pelunasan :</h6></div>
            <div class="col-6 text-left"><h6 class="text-bigger"><?=formatCurrency($total_pembayaran)?></h6></div>
            <div class="col-6 text-right"><h6>Total Uang Muka :</h6></div>
            <div class="col-6 text-left"><h6 class="text-bigger"><?=formatCurrency($total_uang_muka)?></h6></div>
            <div class="col-6 text-right"><h6>Total Sisa Bayar :</h6></div>
            <div class="col-6 text-left"><h6 class="text-bigger"><?=formatCurrency($total_belum_bayar)?></h6></div>
            <div class="col-6 text-right"><h6>Total Penerimaan :</h6></div>
            <div class="col-6 text-left"><h6 class="text-bigger"><?=formatCurrency($total_penerimaan)?></h6></div>
            <div class="col-12 text-center">
                <?php if($result){ ?>
                    <form action="<?=base_url('laporan/C_Laporan/saveLaporanRekapHarian')?>" target="_blank">
                        <button type="submit" class="btn btn-sm btn-success"><b><i class="fa fa-download"></i> Save as Excel</b></button>
                        <button type="button" class="btn btn-sm btn-navy" onclick="cetakLaporan()"><b><i class="fa fa-print"></i> Cetak Laporan</b></button>
                    </form>
                <?php } ?>
            </div>
        </div>
    </div>
    <div class="card-body">
        <?php if($result){ ?>
            <table class="table table-sm table-hover table-striped datatable">
                <thead>
                    <tr>
                        <th class="text-center" rowspan=2>NO</th>
                        <th class="text-center" rowspan=2>NO. PENDAFTARAN</th>
                        <th class="text-center" rowspan=2>NAMA PASIEN</th>
                        <th class="text-center" rowspan=1 colspan=2>PEMBAYARAN</th>
                        <th class="text-center" rowspan=2>BELUM BAYAR</th>
                    </tr>
                    <tr>
                        <th class="text-center" rowspan=1>UANG MUKA</th>
                        <th class="text-center" rowspan=1>PELUNASAN</th>
                    </tr>
                </thead>
                <tbody>
                <?php $no = 1; $total_uang_muka = 0; $total_jumlah_bayar = 0; $total_belum_bayar = 0; $total_penerimaan = 0;
                foreach($result as $rs){
                    $belum_bayar = $rs['total_tagihan'] - ($rs['uang_muka'] + $rs['jumlah_bayar']);
                    if($rs['id_m_status_tagihan'] == 2){
                        $belum_bayar = 0;
                    }
                    $total_belum_bayar += $belum_bayar;
                    $total_jumlah_bayar += $rs['jumlah_bayar'];
                    $total_uang_muka += $rs['uang_muka'];
                ?>
                    <tr>
                        <td class="text-center"><?=$no++;?></td>
                        <td class="text-center"><?=$rs['nomor_pendaftaran']?></td>
                        <td class="text-left"><?=$rs['nama_pasien']?></td>
                        <td class="text-center"><?=formatCurrency($rs['uang_muka'])?></td>
                        <td class="text-center"><?=formatCurrency($rs['jumlah_bayar'])?></td>
                        <td class="text-center"><?=formatCurrency($belum_bayar)?></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
            <script>
                $(function(){
                    $('.datatable').DataTable({
                        responsive: false
                    });
                })
                function cetakLaporan() {
                    $("#print_div").load('<?= base_url('laporan/C_Laporan/printLaporanRekapHarian')?>',
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
            </script>
        <?php } else { ?>
            <h6 class="text-center">Data Tidak Ditemukan</h6>
        <?php } ?>
    </div>
</div>