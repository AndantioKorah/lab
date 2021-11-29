<div class="row p-3">
    <form id="formPilihBulan">
        <div class="col-6">
            <label>Bulan</label>
            <select class="form-control form-control-sm select2_pilih_bulan select2-navy" style="width: 100%" id="pilih_bulan" data-dropdown-css-class="select2-navy">
                <option value="1" <?=date('m') == 1 ? 'selected': ''?>>Januari</option>
                <option value="2" <?=date('m') == 2 ? 'selected': ''?>>Februari</option>
                <option value="3" <?=date('m') == 3 ? 'selected': ''?>>Maret</option>
                <option value="4" <?=date('m') == 4 ? 'selected': ''?>>April</option>
                <option value="5" <?=date('m') == 5 ? 'selected': ''?>>Mei</option>
                <option value="6" <?=date('m') == 6 ? 'selected': ''?>>Juni</option>
                <option value="7" <?=date('m') == 7 ? 'selected': ''?>>Juli</option>
                <option value="8" <?=date('m') == 8 ? 'selected': ''?>>Agustus</option>
                <option value="9" <?=date('m') == 9 ? 'selected': ''?>>September</option>
                <option value="10" <?=date('m') == 10 ? 'selected': ''?>>Oktober</option>
                <option value="11" <?=date('m') == 11 ? 'selected': ''?>>November</option>
                <option value="12" <?=date('m') == 12 ? 'selected': ''?>>Desember</option>
            </select>
        </div>
        <div class="col-6">
            <label>Tahun</label>
            <select class="form-control form-control-sm select2_pilih_bulan select2-navy" style="width: 100%" id="pilih_tahun" data-dropdown-css-class="select2-navy">
                <option value="2020" <?=date('Y') == 2020 ? 'selected': ''?>>Januari</option>
                <option value="2021" <?=date('Y') == 2021 ? 'selected': ''?>>Februari</option>
                <option value="2022" <?=date('Y') == 2022 ? 'selected': ''?>>Maret</option>
                <option value="2023" <?=date('Y') == 2023 ? 'selected': ''?>>April</option>
                <option value="2024" <?=date('Y') == 2024 ? 'selected': ''?>>Mei</option>
                <option value="2025" <?=date('Y') == 2025 ? 'selected': ''?>>Juni</option>
                <option value="2026" <?=date('Y') == 2026 ? 'selected': ''?>>Juli</option>
                <option value="2027" <?=date('Y') == 2027 ? 'selected': ''?>>Agustus</option>
                <option value="2028" <?=date('Y') == 2028 ? 'selected': ''?>>September</option>
                <option value="2029" <?=date('Y') == 2029 ? 'selected': ''?>>Oktober</option>
                <option value="2030" <?=date('Y') == 2030 ? 'selected': ''?>>November</option>
            </select>
        </div>
    </form>
    <div id="div_result" class="col-12 mt-3">
    
    </div>
</div>
<script>
    $(function(){
        searchHistoryPelunasan()
    })

    $('.select2_pilih_bulan').select2()

    $('#pilih_bulan').on('change', function(){
        searchHistoryPelunasan()
    })

    $('#pilih_tahun').on('change', function(){
        searchHistoryPelunasan()
    })

    function searchHistoryPelunasan(){
        $('#div_result').html('')
        $('#div_result').append(divLoaderNavy)
        $('#div_result').load("<?=base_url('pembayaran/C_Pembayaran/loadHistoryPelunasanMassalItem')?>"+'/'+$('#pilih_bulan').val()+'/'+$('#pilih_tahun').val(), function(){
            $('#loader').hide()
        })
    }
</script>