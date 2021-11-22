<?php if($history){ ?>
    <table class="table table-hover table-striped">
        <thead>
            <th class="text-center">No</th>
            <th>Tanggal</th>
            <th>Nomor Pembayaran</th>
            <th>Cara Bayar</th>
            <th class="text-center">Jumlah Tagihan</th>
            <th>Total Tagihan</th>
            <th>Pilihan</th>
        </thead>
        <?php $no=1; foreach($history as $i){ ?>
            <tr>
                <td class="text-center"><?=$no++;?></td>
                <td><?=formatDate($i['created_date'])?></td>
                <td><?=$i['nomor_pembayaran']?></td>
                <td><?=$i['nama_cara_bayar_detail']?></td>
                <td class="text-center"><?=count(json_decode($i['list_id_t_pendaftaran']))?></td>
                <td><?=formatCurrency($i['total_tagihan'])?></td>
                <td>
                    <button onclick="detailHistoryPelunasanMassal('<?=$i['id']?>')" class="btn btn-sm btn-navy"><i class="fa fa-edit"></i> Detail</button>
                    <button onclick="deleteHistoryPelunasanMassal('<?=$i['id']?>')" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i> Hapus</button>
                </td>
            </tr>
        <?php } ?>
    </table>
    <script>
        function detailHistoryPelunasanMassal(id){
            $('#div_result').html('')
            $('#div_result').append(divLoaderNavy)
            $('#div_result').load("<?=base_url('pembayaran/C_Pembayaran/detailHistoryPelunasanMassal')?>"+'/'+id, function(){
                $('#loader').hide()
            })
        }

        function deleteHistoryPelunasanMassal(id){
            if(confirm('Apakah Anda yakin ingin menghapus data?')){
                $.ajax({
                url: "<?=base_url('pembayaran/C_Pembayaran/deleteHistoryPelunasanMassal')?>"+'/'+id,
                method: "post",
                data: null,
                success: function(data){
                    let rs = JSON.parse(data)
                    if(rs.code != 0){
                        errortoast(rs.message)
                    } else {
                        successtoast('Berhasil Dihapus')
                        searchHistoryPelunasan()
                        submitFormSearchMenuListPendaftaran()
                    }
                }, error: function(e){
                    errortoast('Terjadi Kesalahan')
                }
            })
            }
        }
    </script>
<?php } else { ?>
    <div class="col-12 text-center">
        <h6>DATA TIDAK DITEMUKAN <i class="fa fa-exclamation"></i></h6>
    </div>
<?php } ?>