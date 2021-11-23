<style>
    .span_status_tagihan{
        padding: 3px;
        border-radius: 3px;
        font-size: 14px;
        font-weight: bold;
        color: white;
    }

    .pelunasan_item{
        /* cursor: pointer; */
        border-bottom: 1px solid #001f3f;
        transition: .1s;
    }

    .pelunasan_item:hover{
        background-color: #e8e8e8;
    }
</style>

<div class="row">
    <?php if(!$list_pendaftaran){ ?>
        <div class="col-12 text-center">
            <h5>DATA PENDAFTARAN TIDAK DITEMUKAN <i class="fa fa-exclamation"></i></h5>
        </div>
    <?php } else { ?>
        <div class="col-12">
            <div class="row" style="border-bottom: 1px solid #001f3f;">
                <div style="width:5%;" class="text-center">Pilih</div>
                <div style="width:5%;" class="text-center">No</div>
                <div style="width:20%;" class="text-left">Nama Pasien</div>
                <div style="width:10%;" class="text-center">Nomor LAB</div>
                <div style="width:15%;" class="text-center">Tgl. Pendaftaran</div>
                <div style="width:15%;" class="text-center">Cara Bayar</div>
                <div style="width:15%;" class="text-center">Total Tagihan</div>
                <div style="width:15%;" class="text-center">Status Tagihan</div>
            </div>
            <form id="pelunasanMassalForm">
            <?php $no=1; $total_tagihan = 0; $jumlah_pendaftaran = 0; foreach($list_pendaftaran as $l){
            $bg_color = '#ce0000';
            $status_tagihan = $l['status_tagihan'];
            if($l['id_m_status_tagihan'] == 2){
                $bg_color = '#001f3f';
            } 
            
            if($l['flag_active'] == 0){
                $bg_color = '#999292';
                $status_tagihan = 'DIHAPUS';
            }
            ?>
                <div class="row pt-2 pb-2 pelunasan_item">
                    <div style="width:5%; cursor: pointer;" class="text-center">
                        <?php if($l['id_m_status_tagihan'] == 1 && $l['flag_active'] == 1){
                            $total_tagihan += $l['total_tagihan'];
                            $jumlah_pendaftaran++;
                        ?>
                            <input class="form-check-input" onclick="countTotalPelunasan('<?=$l['total_tagihan']?>', '<?=$l['id']?>')"
                            style="width:25px; height: 25px; margin-top: -3px;" name="id_pelunasan_massal[]" 
                            type="checkbox" value="<?=$l['id']?>" id="checkbox_<?=$l['id']?>" checked>
                        <?php } ?>
                    </div>
                    <div style="width:5%;" class="text-center"><strong><?=$no++;?></strong></div>
                    <div style="width:20%;" class="text-left"><strong><?=$l['nama_pasien']?></strong></div>
                    <div style="width:10%;" class="text-center"><strong><?=$l['nomor_pendaftaran']?></strong></div>
                    <div style="width:15%;" class="text-center"><strong><?=formatDate($l['tanggal_pendaftaran'])?></strong></div>
                    <div style="width:15%;" class="text-center"><strong><?=strtoupper($l['nama_cara_bayar_detail'])?></strong></div>
                    <div style="width:15%;" class="text-center"><strong><?=formatCurrency($l['total_tagihan'])?></strong></div>
                    <div style="width:15%;" class="text-center"><strong class="span_status_tagihan" style="background-color: <?=$bg_color?>"><?=strtoupper($status_tagihan)?></strong></div>
                </div>
            <?php } ?>
            </form>
        </div>
        <script>
            total_tagihan = parseInt('<?=$total_tagihan?>')
            jumlah_pendaftaran = parseInt('<?=$jumlah_pendaftaran?>')

            $(function(){
                $('#div_count').show()
                $('#total_tagihan_pm').html(rupiahkan(total_tagihan))
                $('#jumlah_pendaftaran_pm').html(jumlah_pendaftaran)
            })

            // function checkOrUncheck(tagihan, id){
            //     if($('#checkbox_'+id).prop("checked")){
            //         $('#checkbox_'+id).prop("checked", false)
            //     } else {
            //         $('#checkbox_'+id).prop("checked", true)
            //     }
            //     countTotalPelunasan(tagihan, id)
            // }

            $('#pelunasanMassalForm').on('submit', function(e){
                e.preventDefault()
                $('#btn_submit_pm').hide()
                $('#btn_loading_pm').show()
                $.ajax({
                    url: "<?=base_url('pembayaran/C_Pembayaran/submitPelunasanMassal')?>",
                    method: "post",
                    data: $(this).serialize(),
                    success: function(data){
                        let rs = JSON.parse(data)
                        if(rs.code != 0){
                            errortoast(rs.message)
                        } else {
                            successtoast('Pelunasan Berhasil')
                            submitFormSearchMenuListPendaftaran()
                        }
                        $('#btn_submit_pm').show()
                        $('#btn_loading_pm').hide()
                    }, error: function(e){
                        errortoast('Terjadi Kesalahan')
                    }
                })
            })

            function countTotalPelunasan(tagihan, id){
                if($('#checkbox_'+id).prop("checked")){
                    total_tagihan += parseInt(tagihan)
                    jumlah_pendaftaran += 1;
                } else {
                    total_tagihan -= parseInt(tagihan)
                    jumlah_pendaftaran -= 1;
                }
                $('#total_tagihan_pm').html(rupiahkan(total_tagihan))
                $('#jumlah_pendaftaran_pm').html(jumlah_pendaftaran)
            }

            function rupiahkan(angka){
                var reverse = angka.toString().split('').reverse().join(''),
                ribuan = reverse.match(/\d{1,3}/g);
                ribuan = ribuan.join('.').split('').reverse().join('');
                return "Rp "+ribuan;
            }
        </script>
    <?php } ?>     
</div>
