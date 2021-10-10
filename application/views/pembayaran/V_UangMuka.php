<style>
    .label_pembayaran{
        color: #001f3f;
        padding: 5px;
        background-color: white;
        border: 1px solid #001f3f !important;
        border-radius: 5px;
        font-weight: bold;
        font-size: 13px;
    }

    .form_uang_muka_custom{
        font-size: 18px;
        font-weight: bold;
    }
</style>
<?php if(!$uangmuka){ ?>
    <form id="form_uang_muka">
        <div class="row mt-3">
            <div class="col-6 border-right">
                <div class="row">
                    <input style="display: none;" name="id_t_pendaftaran" value="<?=$id_t_pendaftaran?>" />
                    <div class="col-4"><label class="label_pembayaran">Tanggal Pembayaran</span></div>
                    <div class="col-8"><input readonly id="tanggal_pembayaran" class="form-control form-control-sm realdatetimethis" name="tanggal_pembayaran" /></div>
                </div>
                <div class="row">
                    <div class="col-4"><label class="label_pembayaran">Nama Pembayar</span></div>
                    <div class="col-8"><input autocomplete="off" id="nama_pembayar_uang_muka" class="form_uang_muka_custom form-control form-control-sm" name="nama_pembayar" /></div>
                </div>
                <div class="row">
                    <div class="col-4"><label class="label_pembayaran">Cara Bayar</span></div>
                    <div class="col-8">
                        <select class="form-control form-control-sm select2_pembayaran select2-navy" style="width: 100%" id="cara_bayar" data-dropdown-css-class="select2-navy" name="cara_pembayaran">
                            <option value="tunai">Tunai</option>
                            <option value="card">Kartu Debit/Credit</option>
                            <option value="transfer">Transfer</option>
                        </select>
                    </div>
                </div>
                <div class="row div_non_tunai" style="display: none;">
                    <div class="col-4"><label class="label_pembayaran">Nama Bank</span></div>
                    <div class="col-8">
                        <select class="form-control form-control-sm select2_pembayaran select2-navy" style="width: 100%" id="bank" data-dropdown-css-class="select2-navy" name="bank">
                            <?php foreach($list_bank as $b){ ?>
                                <option value="<?=$b['id'].';'.$b['nama_bank']?>"><?=$b['nama_bank']?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="row div_non_tunai" style="display: none;">
                    <div class="col-4"><label class="label_pembayaran">Nomor Referensi</span></div>
                    <div class="col-8"><input autocomplete="off" class="form_uang_muka_custom form-control form-control-sm" name="nomor_referensi" /></div>
                </div>
            </div>
            <div class="col-6">
                <div class="row">
                    <div class="col-4"><label class="label_pembayaran">Jumlah Pembayaran</span></div>
                    <div class="col-8">
                        <input autocomplete="off" id="jumlah_pembayaran"
                        class="form_uang_muka_custom form-control form-control-sm format_currency_this" name="jumlah_pembayaran" />
                    </div>
                </div>
                <div class="row">
                    <?php if($tagihan['id_m_status_tagihan'] == 1){ ?>
                    <div class="col-4"></div>
                    <div class="col-8">
                        <button id="button_loading_pembayaran" style="display: none;" type="button" disabled class="btn btn-block btn-navy"><i class="fa fa-spin fa-spinner"></i> BAYAR</button>
                        <button id="button_submit_bayar" type="submit" class="btn btn-block btn-navy"><i class="fa fa-money-bill"></i> BAYAR</button>
                    </div>
                    <?php } else { ?>
                        <div class="col-12 text-left">
                            <!-- <h6>TAGIHAN SUDAH LUNAS <i class="fa fa-exclamation"></i></h6> -->
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </form>
    <script>
        $(function(){
            diskon_nominal_counter = 1

            $('.select2_pembayaran').select2()

            $('.format_currency_this').on('keypress', function(event){
                if(event.charCode >= 48 && event.charCode <= 57){
                    return true;
                } else {
                    return false;
                }
            })

            function formatRupiah(angka, prefix = "Rp ") {
                var number_string = angka.replace(/[^,\d]/g, "").toString(),
                    split = number_string.split(","),
                    sisa = split[0].length % 3,
                    rupiah = split[0].substr(0, sisa),
                    ribuan = split[0].substr(sisa).match(/\d{3}/gi);

                // tambahkan titik jika yang di input sudah menjadi angka ribuan
                if (ribuan) {
                    separator = sisa ? "." : "";
                    rupiah += separator + ribuan.join(".");
                }

                rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
                return prefix == undefined ? rupiah : rupiah ? rupiah : "";
            }

            $('.format_currency_this').on('keyup', function(){
                $(this).val(formatRupiah($(this).val()))
            })

            $('#nama_pembayar_uang_muka').val($('#span_nama_pasien').html())

            $('#tanggal_pembayaran').datetimepicker({
                format: 'yyyy-mm-dd hh:mm:ss',
                autoclose: true,
                todayHighlight: true,
                todayBtn: true,
                endDate: new Date()
            })

            $('#tanggal_pembayaran').on('changeDate', function (ev) {
                $(this).removeClass('realdatetimethis')
            });

            $('#tanggal_pembayaran').on('click', function (ev) {
                $(this).addClass('realdatetimethis')
            });
        })
        
        $('#cara_bayar').on('change', function(){
            if($(this).val() != 'tunai'){
                $('.div_non_tunai').show()
            } else {
                $('.div_non_tunai').hide()
            }
        })

        $('#form_uang_muka').on('submit', function(e){
            e.preventDefault()
            $('#button_loading_pembayaran').show()
            $('#button_submit_bayar').hide()
            $.ajax({
                url: '<?=base_url("pembayaran/C_Pembayaran/createUangMuka")?>',
                method: 'post',
                data: $(this).serialize(),
                success: function(res){
                    let rs = JSON.parse(res)
                    if(rs.code == 0){
                        successtoast('Pembayaran Berhasil')
                        loadTagihanHeader('<?=$id_t_pendaftaran?>')
                        loadUangMuka('<?=$id_t_pendaftaran?>')
                        loadDetailPendaftaran('<?=$id_t_pendaftaran?>')
                    } else {
                        errortoast(rs.message)
                        $('#button_loading_pembayaran').hide()
                        $('#button_submit_bayar').show()
                    }
                }, error: function(){
                    errortoast('Terjadi Kesalahan')
                    $('#button_loading_pembayaran').hide()
                    $('#button_submit_bayar').show()
                }
            })
        })
    </script>
<?php } else { ?>
    <div class="row mt-3">
        <div class="col-12 text-left">
            <button class="btn btn-sm btn-navy" onclick="cetakKwitansiUangMuka()"><i class="fa fa-print"></i> Cetak Kwitansi Uang Muka</button>
            <hr>
        </div>
        <div class="col-6 border-right">
            <div class="row">
                <div class="col-4"><label class="label_pembayaran">Nomor Pembayaran</span></div>
                <div class="col-8"><input readonly class="form-control form-control-sm form_uang_muka_custom" value="<?=strtoupper($uangmuka['nomor_pembayaran'])?>" /></div>
            </div>
            <div class="row">
                <div class="col-4"><label class="label_pembayaran">Tanggal Pembayaran</span></div>
                <div class="col-8"><input readonly class="form-control form-control-sm form_uang_muka_custom" value="<?=formatDate($uangmuka['tanggal_pembayaran'])?>" /></div>
            </div>
            <div class="row">
                <div class="col-4"><label class="label_pembayaran">Nama Pembayar</span></div>
                <div class="col-8"><input readonly class="form-control form-control-sm form_uang_muka_custom" value="<?=strtoupper($uangmuka['nama_pembayar'])?>" /></div>
            </div>
            <div class="row">
                <div class="col-4"><label class="label_pembayaran">Cara Bayar</span></div>
                <div class="col-8"><input readonly class="form-control form-control-sm form_uang_muka_custom" value="<?=strtoupper($uangmuka['cara_pembayaran'])?>" /></div>
            </div>
            <?php if($uangmuka['cara_pembayaran'] != 'tunai'){ ?>
            <div class="row">
                <div class="col-4"><label class="label_pembayaran">Nama Bank</span></div>
                <div class="col-8"><input readonly class="form-control form-control-sm form_uang_muka_custom" value="<?=strtoupper($uangmuka['nama_bank'])?>" /></div>
            </div>
            <div class="row">
                <div class="col-4"><label class="label_pembayaran">Nomor Referensi</span></div>
                <div class="col-8"><input readonly class="form-control form-control-sm form_uang_muka_custom" value="<?=strtoupper($uangmuka['nomor_referensi'])?>" /></div>
            </div>
            <?php } ?>
        </div>
        <div class="col-6">
            <form id="form_hapus_uang_muka">
                <div class="row">
                    <div class="col-4"><label class="label_pembayaran">Jumlah Pembayaran</span></div>
                    <div class="col-8"><input readonly class="form-control form-control-sm form_uang_muka_custom" value="<?=formatCurrency($uangmuka['jumlah_pembayaran'])?>" /></div>
                </div>
                <div class="row">
                    <?php if($tagihan['id_m_status_tagihan'] == 1){ ?>
                    <div class="col-12">
                        <label>Ketik <i>"hapus uang muka"</i> sebagai konfirmasi untuk menghapus pembayaran ini</label>
                    </div>
                    <div class="col-12 text-right">
                        <input autocomplete="off" class="form-control form-control-sm form_uang_muka_custom" id="confirmation_hapus_uang_muka" />
                        <button id="btn_hapus_uang_muka" type="submit" disabled class="btn btn-danger btn-sm mt-2"><i class="fa fa-trash"></i> Hapus Pembayaran</button>
                    </div>
                    <?php } ?>
                </div>
            </form>
        </div>
    </div>
    <script>

        function cetakKwitansiUangMuka() {
            $("#print_div").load('<?= base_url('pembayaran/C_Pembayaran/cetakKwitansiUangMuka/'.$id_t_pendaftaran)?>',
                function () {
                    printSpace('print_div');
                });
        }

        $('#confirmation_hapus_uang_muka').on('input', function(){
            if($(this).val() == 'hapus uang muka'){
                $('#btn_hapus_uang_muka').prop('disabled', false)
            } else {
                $('#btn_hapus_uang_muka').prop('disabled', true)
            }
        })
        
        $('#form_hapus_uang_muka').on('submit', function(e){
            e.preventDefault()
            if(confirm('Apakah Anda yakin ingin menghapus Uang Muka?')){
                $.ajax({
                    url: '<?=base_url("pembayaran/C_Pembayaran/deleteUangMuka")?>'+'/'+<?=$id_t_pendaftaran?>,
                    method: 'post',
                    data: null,
                    success: function(res){
                        let rs = JSON.parse(res)
                        if(rs.code == 0){
                            successtoast('Pembayaran Berhasil Dihapus')
                            loadTagihanHeader('<?=$id_t_pendaftaran?>')
                            loadUangMuka('<?=$id_t_pendaftaran?>')
                            loadDetailPendaftaran('<?=$id_t_pendaftaran?>')
                        } else {
                            errortoast(rs.message)
                        }
                    }, error: function(){
                        errortoast('Terjadi Kesalahan')
                    }
                })
            }
        })
    </script>
<?php } ?>