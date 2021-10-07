<div class="modal-body">
    <form id="form_pasien_baru" action="#">
        <div class="row">
            <div class="col-md-4">
                <label>NAMA LENGKAP</label>
                <input require autocomplete="off" id="nama_pasien" style="text-transform:uppercase" class="form-control form-control-sm" name="nama_pasien" />
            </div>
            <div class="col-md-2">
                <label>JENIS KELAMIN</label>
                <select autocomplete="off" class="form-control form-control-sm select2_this select2-navy" data-dropdown-css-class="select2-navy" name="jenis_kelamin">
                    <option value="1">LAKI-LAKI</option>
                    <option value="2">PEREMPUAN</option>
                </select>
            </div>
            <div class="col-md-2">
                <label>TEMPAT LAHIR</label>
                <input autocomplete="off" style="text-transform:uppercase" class="form-control form-control-sm" name="tempat_lahir" />
            </div>
            <div class="col-md-2">
                <label>TANGGAL LAHIR</label>
                <input autocomplete="off" id="tanggal_lahir_pasien_baru" class="form-control form-control-sm" name="tanggal_lahir" />
            </div>
            <div class="col-md-2">
                <label>GOLONGAN DARAH</label>
                <select autocomplete="off" class="form-control form-control-sm select2_this select2-navy" data-dropdown-css-class="select2-navy" name="goldar">
                    <option value="0" selected>TIDAK TAHU</option>
                    <?php foreach($golongan_darah as $goldar){ ?>
                        <option value=<?=$goldar['id'].';'.strtoupper($goldar['golongan_darah'])?>><?=strtoupper($goldar['golongan_darah'])?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="col-md-12"><hr></div>
            <div class="col-md-8">
                <label>ALAMAT DOMISILI</label>
                <input autocomplete="off" style="text-transform:uppercase" class="form-control form-control-sm" name="alamat" />
            </div>
            <div class="col-md-4">
                <label>NOMOR TELEPON</label>
                <input autocomplete="off" style="text-transform:uppercase" class="form-control form-control-sm" name="nomor_telepon" />
            </div>
            <div class="col-md-3" style="display: none;">
                <label>PROVINSI</label>
                <select autocomplete="off" class="form-control form-control-sm select2_this select2-navy" data-dropdown-css-class="select2-navy" name="id_m_provinsi">
                    <?php foreach($provinsi as $prov){ ?>
                        <option <?=$prov['id'] == '71' ? 'selected' : ''?> value=<?=$prov['id']?>><?=strtoupper($prov['nama_provinsi'])?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="col-md-3" style="display: none;">
                <label>KABUPATEN/KOTA</label>
                <select autocomplete="off" class="form-control form-control-sm select2_this select2-navy" data-dropdown-css-class="select2-navy" name="id_m_provinsi">
                    <?php foreach($kota as $kt){ ?>
                        <option <?=$kt['id'] == '7171' ? 'selected' : ''?> value=<?=$kt['id']?>><?=strtoupper($kt['nama_kabupaten_kota'])?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="col-md-3" style="display: none;">
                <label>KECAMATAN</label>
                <select autocomplete="off" class="form-control form-control-sm select2_this select2-navy" data-dropdown-css-class="select2-navy" name="id_m_provinsi">
                    <?php foreach($kecamatan as $kec){ ?>
                        <option <?=$kec['id'] == '717106' ? 'selected' : ''?> value=<?=$kec['id']?>><?=strtoupper($kec['nama_kecamatan'])?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="col-md-3" style="display: none;">
                <label>KELURAHAN</label>
                <select autocomplete="off" class="form-control form-control-sm select2_this select2-navy" data-dropdown-css-class="select2-navy" name="id_m_provinsi">
                    <?php foreach($kelurahan as $kel){ ?>
                        <option <?=$kel['id'] == '7171061002' ? 'selected' : ''?> value=<?=$kel['id']?>><?=strtoupper($kel['nama_kelurahan'])?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="col-md-12"><hr></div>
            <div class="col-md-2">
                <label>JENIS IDENTITAS</label>
                <select autocomplete="off" class="form-control form-control-sm select2_this select2-navy" data-dropdown-css-class="select2-navy" name="jenis_identitas">
                    <option selected value="KTP">KTP</option>
                    <option value="PASSPORT">PASSPORT</option>
                    <option value="LAINNYA">LAINNYA</option>
                    <option value="0">TIDAK ADA</option>
                </select>
            </div>
            <div class="col-md-3">
                <label>NOMOR IDENTITAS</label>
                <input autocomplete="off" style="text-transform:uppercase" class="form-control form-control-sm" name="nomor_identitas" />
            </div>
            <div class="col-md-3">
                <label>KEWARGANEGARAN</label>
                <select autocomplete="off" class="form-control form-control-sm select2_this select2-navy" data-dropdown-css-class="select2-navy" name="warga_negara">
                    <?php foreach($negara as $n){ ?>
                        <option <?=$n['id'] == '360' ? 'selected' : ''?> value=<?=$n['id'].';'.strtoupper($n['nama_negara'])?>><?=strtoupper($n['nama_negara'])?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="col-md-4">
                <label>PEKERJAAN</label>
                <select autocomplete="off" class="form-control form-control-sm select2_this select2-navy" data-dropdown-css-class="select2-navy" name="id_m_pekerjaan">
                    <?php foreach($pekerjaan as $p){ ?>
                        <option value=<?=$p['id']?>><?=strtoupper($p['nama_pekerjaan'])?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="col-md-12"><hr></div>
            <div class="col-md-3">
                <button type="button" id="btn_simpan" accesskey="s" class="btn btn-block btn-navy"><i class="fa fa-save"></i> <u>S</u>IMPAN</button>
            </div>
            <div class="col-md-6"></div>
            <div class="col-md-3">
                <button type="button" id="btn_simpan_dan_lanjutkan" accesskey="l" class="btn btn-block btn-navy"><i class="fa fa-save"></i> SIMPAN DAN <u>L</u>ANJUTKAN</button>
            </div>
        </div>
    </form>
</div>
<script>
    $(function(){
        $('.select2_this').select2()

        $("#tanggal_lahir_pasien_baru").inputmask("99-99-9999", {
            placeholder: "hh-bb-tttt"
        });
    })

    $('#btn_simpan').on('click', function(){
        createPasien(0)
    })

    $('#btn_simpan_dan_lanjutkan').on('click', function(){
        createPasien(1)
    })

    function createPasien(flag_lanjutkan = 0){
        let data = $('#form_pasien_baru').serialize()
        let nama_pasien = $('#nama_pasien').val()
        if(nama_pasien == ''){
            errortoast('Nama Pasien tidak boleh kosong')
        }
        if(confirm('Apakah Anda yakin ingin menyimpan data?')){
            $.ajax({
                url: '<?=base_url("pendaftaran/C_Pendaftaran/createPasien")?>',
                method: 'post',
                data: data,
                success: function(datares){
                   let res = JSON.parse(datares)
                   if(res.code == 0){
                        reloadFormPasienBaru()
                        successtoast('Data Berhasil Disimpan')
                        if(flag_lanjutkan == 1){
                            fillDataPasien(res.data.id)
                            $('#pasien_baru_modal').modal('hide')
                        }
                   } else {
                       errortoast(res.message)
                   }
                }, error: function(e){
                    errortoast('Terjadi Kesalahan')
                }
            })
        }
    }

    $('#btn_simpan_dan_lanjutkan').on('click', function(){
        successtoast('Simpan dan lanjutkan')
    })
</script>