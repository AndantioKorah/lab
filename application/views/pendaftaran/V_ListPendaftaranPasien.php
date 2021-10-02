<style>
    .item_pendaftaran{
        cursor: pointer;
        border-bottom: 1px solid #001f3f;
        transition: .2s;
    }

    .item_pendaftaran:hover{
        cursor: pointer;
        background-color: #e8e8e8;
        color: black;
    }

    .span_status_tagihan{
        padding: 3px;
        border-radius: 3px;
        font-size: 14px;
        font-weight: bold;
        color: white;
    }
</style>
<?php if($list_pendaftaran){ ?>
    <div class="col-12">
        <div class="row" style="border-bottom: 1px solid #001f3f;">
            <div class="col-1 text-center">No</div>
            <div class="col-3 text-center">Nomor Pendaftaran</div>
            <div class="col-3 text-center">Tanggal Pendaftaran</div>
            <div class="col-2 text-center">Cara Bayar</div>
            <div class="col-3 text-center">Status Tagihan</div>
        </div>
        <?php $no = 1; foreach($list_pendaftaran as $l){
             $bg_color = '#ce0000';
             if($l['id_m_status_tagihan'] == 2){
                 $bg_color = '#001f3f';
             }
             ?>
            <div data-id_pendaftaran="<?=$l['id_t_pendaftaran']?>" class="item_pendaftaran row pt-2 pb-2" id="div_item_pendaftaran_<?=$l['id_t_pendaftaran']?>">
                <div class="col-1 text-center"><strong><?=$no++;?></strong></div>
                <div class="col-3 text-center"><strong><?=$l['nomor_pendaftaran']?></strong></div>
                <div class="col-3 text-center"><strong><?=formatDate($l['tanggal_pendaftaran'])?></strong></div>
                <div class="col-2 text-center"><strong><?=strtoupper($l['nama_cara_bayar_detail'])?></strong></div>
                <div class="col-3 text-center"><strong class="span_status_tagihan" style="background-color: <?=$bg_color?>"><?=$l['status_tagihan']?></strong></div>
                <div class="col-12 mt-2 text-center div_button" id="div_button_<?=$l['id_t_pendaftaran']?>" style="display: none;">

                <?php if($this->general_library->isButtonAllowed('btn_edit_pendaftaran_list_pendaftaran')){ ?>
                    <button href="#edit_data_pendaftaran" data-toggle="modal" class="btn btn-sm btn-navy"
                    onclick="openModalEditPendaftaran('<?=$l['id_t_pendaftaran']?>', 'loadListPendaftaranPasien')"><i class="fa fa-edit"></i> Edit Pendaftaran</button>
                <?php } ?>
                <?php if($this->general_library->isButtonAllowed('btn_tagihan_list_pendaftaran')){ ?>
                    <button class="btn btn-sm btn-navy" onclick="openTagihan('<?=$l['id_t_pendaftaran']?>')">
                    <i class="fa fa-cash-register"></i> Tagihan</button>
                <?php } ?>
                <?php if($this->general_library->isButtonAllowed('btn_tindakan_list_pendaftaran')){ ?>
                    <button class="btn btn-sm btn-navy" onclick="LoadViewInputTindakan('<?=$l['id_t_pendaftaran']?>')">
                    <i class="fa fa-user-md"></i> Input Tindakan</button>
                <?php } ?>

                </div>
            </div>
        <?php } ?>
    </div>
<?php } else { ?>
    <div class="col-12 text-center">
        <h5><i class="fa fa-exclamation"></i> PASIEN BELUM MELAKUKAN PENDAFTARAN</h5>
    </div>
<?php } ?>  
<script>
    $(document).mouseup(function(e) 
    {
        var container = $(".item_pendaftaran");

        // if the target of the click isn't the container nor a descendant of the container
        if (!container.is(e.target) && container.has(e.target).length === 0) 
        {
          $('.div_button').hide()
        } else {
          $('.div_button').show()
        }
    });

    $('.item_pendaftaran').on('click', function(){
        $('.div_button').hide()
        $('#div_button_'+$(this).data('id_pendaftaran')).show()
    })
</script>