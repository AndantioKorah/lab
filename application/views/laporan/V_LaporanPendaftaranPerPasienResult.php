<div class="card card-default">
    <div class="card-header text-center">
        <h5 class="card-title-search-resukt-laporan-custom"><strong>LAPORAN PENDAFTARAN PER PASIEN</strong></h5>
        <h6 class="card-title-search-resukt-laporan-custom">Range Tanggal: <?=$parameter['range_tanggal']?></h6>
        <?php if($result){ ?>
        <form action="<?=base_url('laporan/C_Laporan/saveResultLaporanPendaftaranPerPasien')?>" target="_blank">
            <button type="submit" class="btn btn-sm btn-success"><b><i class="fa fa-download"></i> Save as Excel</b></button>
            <button type="button" class="btn btn-sm btn-navy" onclick="cetakLaporan()"><b><i class="fa fa-print"></i> Cetak Laporan</b></button>
        </form>
        <?php } ?>
    </div>
    <div class="card-body">
        <?php if($result){ ?>
            <table class="table table-sm table-hover table-striped datatable">
                <thead>
                    <th class="text-center">NO</th>
                    <th class="text-center">NAMA PASIEN</th>
                    <th class="text-center">TGL. PENDAFTARAN</th>
                    <th class="text-center">NO. PENDAFTARAN</th>
                    <th class="text-center">TOTAL TAGIHAN</th>
                    <th class="text-center">STATUS TAGIHAN</th>
                </thead>
                <tbody>
                <?php $no = 1; foreach($result as $rs){ ?>
                    <tr>
                        <td class="text-center"><?=$no++;?></td>
                        <td class="text-center"><?=$rs['nama_pasien']?></td>
                        <td class="text-center"><?=formatDate($rs['tanggal_pendaftaran'])?></td>
                        <td class="text-center"><?=$rs['nomor_pendaftaran']?></td>
                        <td class="text-center"><?=formatCurrency($rs['total_tagihan'])?></td>
                        <td class="text-center"><?=$rs['status_tagihan']?></td>
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
                    $("#print_div").load('<?= base_url('laporan/C_Laporan/printResultLaporanPendaftaranPerPasien')?>',
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