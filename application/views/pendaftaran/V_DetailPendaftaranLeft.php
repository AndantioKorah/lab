<style>
    .label_pendaftaran{
        font-size: 14px;
        /* font-size: 11px; */
        font-weight: bold;
    }

    .label_pendaftaran_data{
        font-size: 13px; 
        font-weight: bold;
    }

    .span_status_tagihan{
        padding: 3px;
        border-radius: 3px;
        font-size: 14px;
        font-weight: bold;
        color: white;
    }

    /* .tooltip { pointer-events: none; } */
</style>
<?php if($pendaftaran){ 
?>
    <div class="row">
        <div class="col-12 text-center mb-2">
            <span style="font-size: 17px; font-weight: bold;">DATA PENDAFTARAN</span>
        </div>
        <div class="col-4"><span class="label_pendaftaran">No. Lab</span></div>
        <div class="col-1">:</div>
        <div class="col-7">
            <span class="label_pendaftaran_data"><?=$pendaftaran['nomor_pendaftaran']?></span>
        </div>
        <div class="col-4 mt-1"><span class="label_pendaftaran">Tgl. Pendaftaran</span></div>
        <div class="col-1 mt-1">:</div>
        <div class="col-7 mt-1">
            <span class="label_pendaftaran_data"><?=formatDate($pendaftaran['tanggal_pendaftaran'])?></span>
        </div>
        <div class="col-4 mt-1"><span class="label_pendaftaran">Cara Bayar</span></div>
        <div class="col-1 mt-1">:</div>
        <div class="col-7 mt-1">
            <span class="label_pendaftaran_data"><?=$pendaftaran['nama_cara_bayar_detail']?></span>
        </div>
        <div class="col-4"><span class="label_pendaftaran">DPJP</span></div>
        <div class="col-1">:</div>
        <div class="col-7">
            <span class="label_pendaftaran_data"><?=$pendaftaran['nama_dokter_dpjp']?></span>
        </div>
        <?php
            $dokter_pengirim = $pendaftaran['nama_dokter_pengirim'];
            if(!$pendaftaran['id_m_dokter_pengirim']){
                $dokter_pengirim = 'Atas Permintaan Sendiri';
            }
        ?>
        <div class="col-4"><span class="label_pendaftaran">Dokter Pengirim</span></div>
        <div class="col-1">:</div>
        <div class="col-7">
            <span class="label_pendaftaran_data"><?=$dokter_pengirim?></span>
        </div>
        <div class="col-4"><span class="label_pendaftaran">No. HP</span></div>
        <div class="col-1">:</div>
        <div class="col-7">
            <span class="label_pendaftaran_data"><?=$pendaftaran['nomor_telepon_dokter_pengirim']?></span>
        </div>
        <div class="col-4"><span class="label_pendaftaran">Alamat</span></div>
        <div class="col-1">:</div>
        <div class="col-7">
            <span class="label_pendaftaran_data"><?=$pendaftaran['alamat_dokter_pengirim']?></span>
        </div>
        <div class="col-4 mt-1"><span class="label_pendaftaran">Status Tagihan</span></div>
        <div class="col-1 mt-1">:</div>
        <div class="col-7 mt-1">
            <?php
                $bg_color = '#ce0000';
                if($pendaftaran['id_m_status_tagihan'] == 2){
                    $bg_color = '#001f3f';
                }
            ?>
            <span class="span_status_tagihan" style="background-color: <?=$bg_color?>"><?=strtoupper($pendaftaran['status_tagihan'])?></span>
        </div>
        <div class="col-12 text-center mt-3">
        <?php if($this->general_library->isButtonAllowed('btn_edit_pendaftaran_list_pendaftaran')){ ?>
            <button href="#edit_data_pendaftaran" title="Edit Pendaftaran" data-toggle="modal"
            class="btn btn-sm btn-outline-navy"
            onclick="openModalEditPendaftaran('<?=$pendaftaran['id']?>', 'loadDetailPendaftaran', 'id_t_pendaftaran')">
            <i class="fa fa-edit"></i></button>
        <?php } ?>
        <?php if($this->general_library->isButtonAllowed('btn_tagihan_list_pendaftaran')){ ?>
            <button class="btn btn-sm btn-outline-navy" title="Tagihan" onclick="openTagihan('<?=$pendaftaran['id']?>', '<?=$pendaftaran['id_m_pasien']?>')">
            <i class="fa fa-cash-register"></i></button>
        <?php } ?>
        <?php if($this->general_library->isButtonAllowed('btn_tindakan_list_pendaftaran')){ ?>
            <button class="btn btn-sm btn-outline-navy" title="Input Tindakan" onclick="LoadViewInputTindakan('<?=$pendaftaran['id']?>', '0', '<?=$pendaftaran['id_m_pasien']?>')">
            <i class="fa fa-user-md"></i></button>
        <?php } ?>
        </div>
    </div>
    <script>
        $(function(){
            $('[data-tooltip="tooltip_detail_pendaftaran_left"]').tooltip();

            $('[data-tooltip="tooltip_detail_pendaftaran_left"]').on('click', function() {
                $(this).tooltip('hide')
            });
        })
    </script>
<?php } ?>