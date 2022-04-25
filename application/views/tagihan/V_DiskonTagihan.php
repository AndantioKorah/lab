<style>
    .label_diskon_tagihan{
        color: #001f3f;
        padding: 5px;
        background-color: white;
        border: 1px solid #001f3f !important;
        border-radius: 5px;
        font-weight: bold;
        font-size: 13px;
    }

    #diskon_label_diskon_tagihan:hover {
        color: white;
        padding: 5px;
        background-color: #001f3f;
        /* border: 1px solid #001f3f !important; */
        border-radius: 5px;
        font-weight: bold;
        font-size: 13px;
    }

    .form_pembayaran_custom_diskon_tagihan{
        font-size: 18px;
        font-weight: bold;
    }
</style>
<?php if($tagihan['flag_diskon'] == 1){ ?>

<?php } else { ?>
    <form id="form_diskon_tagihan">
        <div class="row mt-3" style="display: none;">
            <div class="col-3"><label class="label_diskon_tagihan">Total Tagihan</span></div>
            <div class="col-9"><input autocomplete="off" readonly id="total_tagihan_input_diskon_tagihan" class="form_pembayaran_custom_diskon_tagihan form-control form-control-sm"/></div>
        </div>
        <div class="row mt-3">
            <div class="col-3"><label class="label_diskon_tagihan">Total Tagihan Baru</span></div>
            <div class="col-9"><input autocomplete="off" readonly id="total_tagihan_baru" class="form_pembayaran_custom_diskon_tagihan form-control form-control-sm"/></div>
        </div>
        <div class="row">
            <div class="col-3">
                <label class="label_diskon_tagihan" id="diskon_label_diskon_tagihan" style="cursor: pointer;">Diskon (Rp)</span>
            </div>
            <div class="col-9">
                <div class="row">
                    <div class="col-2" id="diskon_tagihan_presentase_div" style="display: none;">
                        <input autocomplete="off" id="diskon_tagihan_presentase" oninput="countNewTagihan()"
                        class="form-control form-control-sm format_currency_this_diskon_tagihan" name="diskon_tagihan_presentase" placeholder="0" />
                    </div>
                    <div class="col">
                        <input autocomplete="off" id="diskon_tagihan_nominal" oninput="countNewTagihan()"
                        class="form-control form-control-sm format_currency_this_diskon_tagihan" name="diskon_tagihan_nominal" placeholder="0" />
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-9"></div>
            <div class="col-3 text-right">
                <button style="display: none;" disabled id="btn_loading_diskon_tagihan" class="btn btn-sm btn-navy"><i class="fa fa-spin fa-spinner"></i> Menyimpan....</button>
                <button type="submit" id="btn_save_diskon_tagihan" class="btn btn-sm btn-navy"><i class="fa fa-save"></i> Simpan</button>
            </div>
        </div>
    </form>
    <script>
        $(function(){
            diskon_tagihan_nominal_counter = 1
            resetValueDiskonTagihan()
        })

        $('#form_diskon_tagihan').on('submit', function(e){
            e.preventDefault()
            let total_tagihan = $('#total_tagihan_input_diskon_tagihan').val().split('.').join("")
            let diskon = $('#diskon_tagihan_nominal').val().split('.').join("")
            if(parseInt(diskon) > parseInt(total_tagihan)){
                errortoast('Jumlah Diskon tidak boleh melebihi Total Tagihan')
                return false
            } else if(diskon == 0 || diskon == '0' || diskon == null || diskon == 'null'){
                errortoast('Jumlah Diskon tidak boleh 0 atau kosong')
                return false
            }
            $('#btn_loading_diskon_tagihan').show()
            $('#btn_save_diskon_tagihan').hide()
            $.ajax({
                url: '<?=base_url("tagihan/C_Tagihan/createDiskonTagihan/".$tagihan['id'])?>',
                method: 'post',
                data: $(this).serialize(),
                success: function(res){
                    let rs = JSON.parse(res)
                    if(rs.code == 0){
                        loadTagihanHeader('<?=$tagihan['id_t_pendaftaran']?>')
                        $('#rincian_tagihan_navlink').click()
                        $('#diskon_tagihan_nav').hide()
                        // loadDiskonTagihan('<?=$tagihan['id_t_pendaftaran']?>')
                    } else {
                        errortoast(rs.message)
                        $('#btn_loading_diskon_tagihan').hide()
                        $('#btn_save_diskon_tagihan').show()
                    }
                }, error: function(){
                    errortoast('Terjadi Kesalahan')
                    $('#btn_loading_diskon_tagihan').hide()
                    $('#btn_save_diskon_tagihan').show()
                }
            })
        })

        function resetValueDiskonTagihan(){
            $('#total_tagihan_input_diskon_tagihan').val($('#total_tagihan_header').val())
            $('#total_tagihan_baru').val($('#total_tagihan_header').val())
        }

        function formatRupiahDiskonTagihan(angka, prefix = "Rp ") {
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

        $('.format_currency_this_diskon_tagihan').on('keyup', function(){
            $(this).val(formatRupiahDiskonTagihan($(this).val()))
        })

        function rupiahkan(angka){
            var reverse = angka.toString().split('').reverse().join(''),
            ribuan = reverse.match(/\d{1,3}/g);
            ribuan = ribuan.join('.').split('').reverse().join('');
            return ribuan;
        }

        function countNewTagihan(){
            let total_tagihan = $('#total_tagihan_input_diskon_tagihan').val().split('.').join("")
            let diskon = 0
            let sisa_harus_bayar_diskon_tagihan = 0
            if(diskon_tagihan_nominal_counter == 0){
                diskon = $('#diskon_tagihan_presentase').val().split('.').join("")
                diskon = (diskon * total_tagihan) / 100
                sisa_harus_bayar_diskon_tagihan = total_tagihan - diskon
                $('#diskon_tagihan_nominal').val(rupiahkan(diskon))
            } else {
                diskon = $('#diskon_tagihan_nominal').val().split('.').join("")
                sisa_harus_bayar_diskon_tagihan = total_tagihan - diskon
            }

            if(sisa_harus_bayar_diskon_tagihan < 0 || parseInt(diskon) > parseInt(total_tagihan)){
                sisa_harus_bayar_diskon_tagihan = 0
            }

            $('#total_tagihan_baru').val(rupiahkan(sisa_harus_bayar_diskon_tagihan))

            // console.log($('#diskon_tagihan_nominal').val())
            console.log(sisa_harus_bayar_diskon_tagihan)
            // if($('#diskon_tagihan_nominal').val() == '' || $('#diskon_tagihan_nominal').val() == null){
            //     $('#total_tagihan_input_diskon_tagihan').val(rupiahkan(total_tagihan))
            // }
        }

        $('#diskon_label_diskon_tagihan').on('click', function(){
            $('#diskon_tagihan_nominal').val('')
            $('#diskon_tagihan_presentase').val('')
            if(diskon_tagihan_nominal_counter == 1){
                $('#diskon_tagihan_presentase_div').show()
                $('#diskon_tagihan_nominal').attr('readonly', true)
                $(this).html('Diskon (%)')
                diskon_tagihan_nominal_counter = 0;
            } else {
                $('#diskon_tagihan_presentase_div').hide()
                $('#diskon_tagihan_nominal').attr('readonly', false)
                $(this).html('Diskon (Rp)')
                diskon_tagihan_nominal_counter = 1;
            }
            resetValueDiskonTagihan()
        })
    </script>
<?php } ?>