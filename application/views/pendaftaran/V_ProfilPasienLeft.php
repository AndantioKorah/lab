
<?php                           
    if($pasien){            
    $tempat_lahir = $pasien['tempat_lahir'] ? $pasien['tempat_lahir'] : '-';
    $tanggal_lahir = $pasien['tanggal_lahir'] ? formatDateOnly($pasien['tanggal_lahir']) : '-';
    $jenis_identitas = $pasien['jenis_identitas'] ? $pasien['jenis_identitas'] : '-';
    $nomor_identitas = $pasien['nomor_identitas'] ? $pasien['nomor_identitas'] : '-';
    $golongan_darah = $pasien['golongan_darah'] ? $pasien['golongan_darah'] : '-';
    $alamat = $pasien['alamat'] ? $pasien['alamat'] : '-';
    $nama_pekerjaan = $pasien['nama_pekerjaan'] ? $pasien['nama_pekerjaan'] : '-';
    $kewarganegaraan = $pasien['kewarganegaraan'] ? $pasien['kewarganegaraan'] : '-';
    $nomor_telepon = $pasien['nomor_telepon'] ? $pasien['nomor_telepon'] : '-';
    $umur = countDiffDateLengkap($pasien['tanggal_lahir'], date('Y-m-d H:i:s'), ['tahun']);
?>
<style>
    #div_detail_pendaftaran{
        border-top: 1px solid rgba(0, 0, 0, .125);
        background-color: white;
        border-bottom-right-radius: 5px;
        border-bottom-left-radius: 5px;
    }

    .span_data_pasien_left{
        font-size: 14px;
        font-weight: bold;
    }

    .card_body_profile_pasien_left{
        padding: 3px !important;
    }
</style>
<div class="card card-default">
    <div class="card-header text-center">
        <span id="span_nama_pasien" style="font-size: 20px; font-weight: bold;"><?=$pasien['nama_pasien']?></span>
    </div>
    <div class="card-body" class="card_body_profile_pasien_left">
        <div class="row" style="margin-top: -10px;">
            <div class="col-12 text-center">
                <span style="font-weight: bold; font-size: 15px;">NORM: <?=$pasien['norm']?></span>
            </div>
            <div class="col-1 text-center">
                <span class="span_data_pasien_left">
                <i class="<?=$pasien['jenis_kelamin'] == 1 ? 'fa fa-mars' : 'fa fa-venus'?>"></i></span>
            </div>
            <div class="col-11">
                <span class="span_data_pasien_left"><?=$pasien['jenis_kelamin'] == 1 ? 'LAKI-LAKI' : 'PEREMPUAN'?></span>
            </div>
            <div class="col-1 text-center">
                <span class="span_data_pasien_left">
                <i class="fa fa-birthday-cake"></i></span>
            </div>
            <div class="col-11">
                <span class="span_data_pasien_left"><?=$tempat_lahir.', '.$tanggal_lahir.' ('.strtoupper($umur).' )'?></span>
            </div>
            <div class="col-1 text-center">
                <span class="span_data_pasien_left">
                <i class="fa fa-id-card"></i></span>
            </div>
            <div class="col-11">
                <span class="span_data_pasien_left"><?='('.$jenis_identitas.') '.$nomor_identitas?></span>
            </div>
            <div class="col-1 text-center">
                <span class="span_data_pasien_left">
                <i class="fa fa-burn"></i></span>
            </div>
            <div class="col-11">
                <span class="span_data_pasien_left"><?=$golongan_darah?></span>
            </div>
            <div class="col-1 text-center">
                <span class="span_data_pasien_left">
                <i class="fa fa-briefcase"></i></span>
            </div>
            <div class="col-11">
                <span class="span_data_pasien_left"><?=$nama_pekerjaan?></span>
            </div>
            <div class="col-1 text-center">
                <span class="span_data_pasien_left">
                <i class="fa fa-flag"></i></span>
            </div>
            <div class="col-11">
                <span class="span_data_pasien_left"><?=$kewarganegaraan?></span>
            </div>
            <div class="col-1 text-center">
                <span class="span_data_pasien_left">
                <i class="fa fa-phone"></i></span>
            </div>
            <div class="col-11">
                <span class="span_data_pasien_left"><?=$nomor_telepon?></span>
            </div>
            <div class="col-1 text-center">
                <span class="span_data_pasien_left">
                <i class="fa fa-map-marked-alt"></i></span>
            </div>
            <div class="col-11">
                <span class="span_data_pasien_left"><?=$alamat?></span>
            </div>
        </div>
        <div class="col-12 text-center p-2">
            <?php if($this->general_library->isButtonAllowed('btn_edit_data_pasien_profile_left')){ ?>
                <button href="#edit_data_pasien" data-toggle="modal" data-tooltip="tooltip_profile_pasien" data-placement="top" title="Edit Data Pasien" onclick="editPasien()" 
                class="btn btn-sm btn-outline-navy"><i class="fa fa-user-edit"></i></button>
            <?php } ?>

            <?php if($this->general_library->isButtonAllowed('btn_edit_data_pasien_profile_left')){ ?>
                <button id="btn_pendaftaran_baru" class="btn btn-sm btn-outline-navy" data-tooltip="tooltip_profile_pasien" data-placement="top" title="Pendaftaran Baru">
                <i class="fa fa-plus-square"></i></button>
            <?php } ?>
        </div>
    </div>
    <div class="card-footer" id="div_detail_pendaftaran" style="display: none;">
        
    </div>
</div>
<script>
    $(function(){
        $('[data-tooltip="tooltip_profile_pasien"]').tooltip();

        $('[data-tooltip="tooltip_profile_pasien"]').on('click', function() {
            $(this).tooltip('hide')
        });
    })

    function editPasien(){
        openModalEditPasien('<?=$pasien['norm']?>', 'loadProfilPasien')
    }

    $('#btn_pendaftaran_baru').on('click', function(){
        $.ajax({
            url: '<?=base_url("pendaftaran/C_Pendaftaran/fillIdPasienPendaftaran").'/'.$pasien['id']?>',
            method: 'post',
            success: function(datares){
                window.location="<?=base_url('pendaftaran')?>"
            }, error: function(e){
                errortoast('Terjadi Kesalahan')
            }
        })
    })
</script>
<?php } else { ?>
    <script>
        errortoast('Data Pasien tidak ditemukan')
    </script>
<?php } ?>