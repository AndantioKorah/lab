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

    #diskon_label_pembayaran:hover {
        color: white;
        padding: 5px;
        background-color: #001f3f;
        /* border: 1px solid #001f3f !important; */
        border-radius: 5px;
        font-weight: bold;
        font-size: 13px;
    }

    .form_pembayaran_custom{
        font-size: 18px;
        font-weight: bold;
    }
</style>
<?php if(!$pembayaran){ ?>
    <form id="form_pembayaran">
        <div class="row mt-3">
            <div class="col-6 border-right">
                <div class="row">
                    <input style="display: none;" name="id_t_pendaftaran" value="<?=$id_t_pendaftaran?>" />
                    <div class="col-4"><label class="label_pembayaran">Tanggal Pembayaran</span></div>
                    <div class="col-8"><input readonly id="tanggal_pembayaran" class="form-control form-control-sm realdatetimethis" name="tanggal_pembayaran" /></div>
                </div>
                <div class="row">
                    <div class="col-4"><label class="label_pembayaran">Nama Pembayar</span></div>
                    <div class="col-8"><input autocomplete="off" id="nama_pembayar" class="form_pembayaran_custom form-control form-control-sm" name="nama_pembayar" /></div>
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
                    <div class="col-8"><input autocomplete="off" class="form_pembayaran_custom form-control form-control-sm" name="nomor_referensi" /></div>
                </div>
            </div>
            <div class="col-6">
                <div class="row">
                    <div class="col-4"><label class="label_pembayaran">Total Tagihan</span></div>
                    <div class="col-8"><input autocomplete="off" readonly id="total_tagihan_input" class="form_pembayaran_custom form-control form-control-sm"/></div>
                </div>
                <div class="row" id="div_row_diskon">
                    <div class="col-4"><label class="label_pembayaran" id="diskon_label_pembayaran" style="cursor: pointer;">Diskon (Rp)</span></div>
                    <div class="col-8">
                        <div class="row">
                            <div class="col-2" id="diskon_presentase_div" style="display: none;">
                                <input autocomplete="off" id="diskon_presentase" oninput="countTagihan()"
                                class="form_pembayaran_custom form-control form-control-sm format_currency_this" name="diskon_presentase" placeholder="0" />
                            </div>
                            <div class="col">
                                <input autocomplete="off" id="diskon_nominal" oninput="countTagihan()"
                                class="form_pembayaran_custom form-control form-control-sm format_currency_this" name="diskon_nominal" placeholder="0" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4"><label class="label_pembayaran">Jumlah Pembayaran</span></div>
                    <div class="col-8">
                        <input autocomplete="off" oninput="countKembalian()" id="jumlah_pembayaran"
                        class="form_pembayaran_custom form-control form-control-sm format_currency_this" name="jumlah_pembayaran" />
                    </div>
                </div>
                <div class="row">
                    <div class="col-4"><label class="label_pembayaran">Sisa Harus Bayar</span></div>
                    <div class="col-8"><input autocomplete="off" readonly id="sisa_harus_bayar_input" class="form_pembayaran_custom form-control form-control-sm"/></div>
                </div>
                <div class="row">
                    <div class="col-4"><label class="label_pembayaran">Kembalian</span></div>
                    <div class="col-8">
                        <input autocomplete="off" readonly id="kembalian"
                        class="form_pembayaran_custom form-control form-control-sm" name="kembalian" />
                    </div>
                </div>
                <div class="row">
                    <div class="col-4"></div>
                    <div class="col-8">
                        <button id="button_loading_pembayaran" style="display: none;" type="button" disabled class="btn btn-block btn-navy"><i class="fa fa-spin fa-spinner"></i> BAYAR</button>
                        <button id="button_submit_bayar" type="submit" class="btn btn-block btn-navy"><i class="fa fa-money-bill"></i> BAYAR</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <script>
        $(function(){
            diskon_nominal_counter = 1
            if($('#id_m_cara_bayar_hidden').val() == 2){
                // $('#jumlah_pembayaran').prop('readonly', true)
                // $('#div_row_diskon').hide()
            }

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

            $('#nama_pembayar').val($('#span_nama_pasien').html())

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

            resetInputValue()
        })

        function rupiahkan(angka){
            var reverse = angka.toString().split('').reverse().join(''),
            ribuan = reverse.match(/\d{1,3}/g);
            ribuan = ribuan.join('.').split('').reverse().join('');
            return ribuan;
        }

        function countTagihan(){
            let total_tagihan = $('#total_tagihan_input').val().split('.').join("")
            let sisa_harus_bayar = 0
            let diskon = 0
            if(diskon_nominal_counter == 1){
                diskon = $('#diskon_nominal').val().split('.').join("")
                sisa_harus_bayar = total_tagihan - diskon
            } else {
                diskon = $('#diskon_presentase').val().split('.').join("")
                diskon = (diskon * total_tagihan) / 100
                sisa_harus_bayar = total_tagihan - diskon
                $('#diskon_nominal').val(rupiahkan(diskon))
            }
            if(sisa_harus_bayar < 0 || parseInt(diskon) > parseInt(total_tagihan)){
                sisa_harus_bayar = 0
            }
            $('#kembalian').val(rupiahkan(0))
            $('#jumlah_pembayaran').val(rupiahkan(sisa_harus_bayar))
            $('#sisa_harus_bayar_input').val(rupiahkan(0))
        }

        function countKembalian(){
            let kembalian = 0
            let sisa_harus_bayar = 0
            let total_tagihan = $('#total_tagihan_input').val().split('.').join("")
            let jumlah_pembayaran = $('#jumlah_pembayaran').val().split('.').join("")
            
            if($('#id_m_cara_bayar_hidden').val() == 2){
                sisa_harus_bayar = 0
                kembalian = jumlah_pembayaran
            } else {
                diskon = $('#diskon_nominal').val().split('.').join("")
                if(diskon == ''){
                    diskon = 0
                }
                if(jumlah_pembayaran == ''){
                    jumlah_pembayaran = 0
                }

                kembalian = (parseInt(jumlah_pembayaran) + parseInt(diskon)) - parseInt(total_tagihan)
                if(parseInt(kembalian) < 0){
                    kembalian = 0
                }

                sisa_harus_bayar = parseInt(total_tagihan) - (parseInt(jumlah_pembayaran) + parseInt(diskon))
                if(parseInt(sisa_harus_bayar) < 0){
                    sisa_harus_bayar = 0
                }
            }

            $('#sisa_harus_bayar_input').val(rupiahkan(sisa_harus_bayar))
            $('#kembalian').val(rupiahkan(kembalian))
        }

        function resetInputValue(){
            $('#total_tagihan_input').val($('#total_tagihan_header').val())
            $('#jumlah_pembayaran').val($('#sisa_tagihan_header').val())
            $('#sisa_harus_bayar_input').val(0)
            $('#kembalian').val(0)
        }

        $('#diskon_label_pembayaran').on('click', function(){
            $('#diskon_nominal').val('')
            $('#diskon_presentase').val('')
            if(diskon_nominal_counter == 1){
                $('#diskon_presentase_div').show()
                $('#diskon_nominal').attr('readonly', true)
                $(this).html('Diskon (%)')
                diskon_nominal_counter = 0;
            } else {
                $('#diskon_presentase_div').hide()
                $('#diskon_nominal').attr('readonly', false)
                $(this).html('Diskon (Rp)')
                diskon_nominal_counter = 1;
            }
            resetInputValue()
        })
        
        $('#cara_bayar').on('change', function(){
            if($(this).val() != 'tunai'){
                $('.div_non_tunai').show()
            } else {
                $('.div_non_tunai').hide()
            }
        })

        $('#form_pembayaran').on('submit', function(e){
            e.preventDefault()
            let sisa_harus_bayar = $('#sisa_harus_bayar_input').val().split('.').join("")
            if(parseInt(sisa_harus_bayar) > 0){
                errortoast('Jumlah Pembayaran tidak melunasi Tagihan')
                return false
            }
            $('#button_loading_pembayaran').show()
            $('#button_submit_bayar').hide()
            $.ajax({
                url: '<?=base_url("pembayaran/C_Pembayaran/createPembayaran")?>',
                method: 'post',
                data: $(this).serialize(),
                success: function(res){
                    let rs = JSON.parse(res)
                    if(rs.code == 0){
                        successtoast('Pembayaran Berhasil')
                        loadTagihanHeader('<?=$id_t_pendaftaran?>')
                        loadPembayaran('<?=$id_t_pendaftaran?>')
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
            <button class="btn btn-sm btn-navy" onclick="cetakKwitansiPembayaran()"><i class="fa fa-print"></i> Cetak Kwitansi Pembayaran</button>
            <hr>
        </div>
        <div class="col-6 border-right">
            <div class="row">
                <div class="col-4"><label class="label_pembayaran">Nomor Pembayaran</span></div>
                <div class="col-8"><input readonly class="form-control form-control-sm form_pembayaran_custom" value="<?=strtoupper($pembayaran['nomor_pembayaran'])?>" /></div>
            </div>
            <div class="row">
                <div class="col-4"><label class="label_pembayaran">Tanggal Pembayaran</span></div>
                <div class="col-8"><input readonly class="form-control form-control-sm form_pembayaran_custom" value="<?=formatDate($pembayaran['tanggal_pembayaran'])?>" /></div>
            </div>
            <div class="row">
                <div class="col-4"><label class="label_pembayaran">Nama Pembayar</span></div>
                <div class="col-8"><input readonly class="form-control form-control-sm form_pembayaran_custom" value="<?=strtoupper($pembayaran['nama_pembayar'])?>" /></div>
            </div>
            <div class="row">
                <div class="col-4"><label class="label_pembayaran">Cara Bayar</span></div>
                <div class="col-8"><input readonly class="form-control form-control-sm form_pembayaran_custom" value="<?=strtoupper($pembayaran['cara_pembayaran'])?>" /></div>
            </div>
            <?php if($pembayaran['cara_pembayaran'] != 'tunai'){ ?>
            <div class="row">
                <div class="col-4"><label class="label_pembayaran">Nama Bank</span></div>
                <div class="col-8"><input readonly class="form-control form-control-sm form_pembayaran_custom" value="<?=strtoupper($pembayaran['nama_bank'])?>" /></div>
            </div>
            <div class="row">
                <div class="col-4"><label class="label_pembayaran">Nomor Referensi</span></div>
                <div class="col-8"><input readonly class="form-control form-control-sm form_pembayaran_custom" value="<?=strtoupper($pembayaran['nomor_referensi'])?>" /></div>
            </div>
            <?php } ?>
        </div>
        <div class="col-6">
            <form id="form_hapus_pembayaran">
                <div class="row">
                    <div class="col-4"><label class="label_pembayaran">Diskon</span></div>
                    <?php
                        $diskon = formatCurrency($pembayaran['diskon_nominal']);
                        if($pembayaran['diskon_presentase'] && $pembayaran['diskon_presentase'] > 0){
                            $diskon = '('.$pembayaran['diskon_presentase'].'%) '.$diskon;
                        }
                    ?>
                    <div class="col-8"><input readonly class="form-control form-control-sm form_pembayaran_custom" value="<?=$diskon?>" /></div>
                </div>
                <div class="row">
                    <div class="col-4"><label class="label_pembayaran">Jumlah Pembayaran</span></div>
                    <div class="col-8"><input readonly class="form-control form-control-sm form_pembayaran_custom" value="<?=formatCurrency($pembayaran['jumlah_pembayaran'])?>" /></div>
                </div>
                <div class="row">
                    <div class="col-4"><label class="label_pembayaran">Kembalian</span></div>
                    <div class="col-8"><input readonly class="form-control form-control-sm form_pembayaran_custom" value="<?=formatCurrency($pembayaran['kembalian'])?>" /></div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <label>Ketik <i>"hapus pembayaran"</i> sebagai konfirmasi untuk menghapus pembayaran ini</label>
                    </div>
                    <div class="col-12 text-right">
                        <input autocomplete="off" class="form-control form-control-sm form_pembayaran_custom" id="confirmation_hapus_pembayaran" />
                        <button id="btn_hapus_pembayaran" disabled class="btn btn-danger btn-sm mt-2"><i class="fa fa-trash"></i> Hapus Pembayaran</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script>
        function cetakKwitansiPembayaran() {
            $("#print_div").load('<?= base_url('pembayaran/C_Pembayaran/cetakKwitansiPembayaran/'.$pembayaran['id_t_pendaftaran'])?>',
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

        $('#confirmation_hapus_pembayaran').on('input', function(){
            if($(this).val() == 'hapus pembayaran'){
                $('#btn_hapus_pembayaran').prop('disabled', false)
            } else {
                $('#btn_hapus_pembayaran').prop('disabled', true)
            }
        })

        $('#form_hapus_pembayaran').on('submit', function(e){
            e.preventDefault()
            if(confirm('Apakah Anda yakin ingin menghapus Pembayaran?')){
                $.ajax({
                    url: '<?=base_url("pembayaran/C_Pembayaran/deletePembayaran")?>'+'/'+<?=$id_t_pendaftaran?>,
                    method: 'post',
                    data: null,
                    success: function(res){
                        let rs = JSON.parse(res)
                        if(rs.code == 0){
                            successtoast('Pembayaran Berhasil Dihapus')
                            loadTagihanHeader('<?=$id_t_pendaftaran?>')
                            loadPembayaran('<?=$id_t_pendaftaran?>')
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