<?php if($tindakan){ ?>
    <div class="row">
        <div class="col-12">
            <h5><?=$tindakan['nama_tindakan']?></h5>
        </div>
        <div class="col-12">
            <form id="form_edit_data_tindakan">
            <table class="table table-hover">
                <thead>
                    <th>Nama Tindakan</th>
                    <th>Hasil</th>
                    <th>Nilai Normal</th>
                    <th>Satuan</th>
                    <th>Keterangan</th>
                </thead>
                <tbody>
                    <?php foreach($rincian_tindakan as $rt){
                        $style_rincian_tindakan = "padding-left: ".$rt['padding-left']."px;";
                        if(isset($rt['id_m_jns_tindakan'])){
                            if($rt['id_m_jns_tindakan'] == 0){
                                $style_rincian_tindakan .= "font-size: 18px; text-transform: uppercase;";
                            }
                            $style_rincian_tindakan .= "font-weight: bold;";
                        } 
                    ?>
                    <tr>
                        <input type="hidden" name="id_t_tindakan[]"  value="<?=$rt['id']?>" />
                        <td style="<?=$style_rincian_tindakan?>"><?=$rt['nama_tindakan']?></td>
                        <td><?=isset($rt['hasil']) ? $rt['hasil'] : ''?></td>
                        <td>
                            <?php if($rt['nilai_normal']){ ?>
                                <input class="form-control form-control-sm" value="<?=$rt['nilai_normal'];?>" name="nilai_normal_<?=$rt['id']?>" />
                            <?php } ?>
                        </td>
                        <td>
                            <?php if($rt['nilai_normal']){ ?>
                                <input class="form-control form-control-sm" value="<?=$rt['satuan'];?>" name="satuan_<?=$rt['id']?>" />
                            <?php } ?>
                        </td>
                        <td>
                            <?php if($rt['nilai_normal']){ ?>
                                <input class="form-control form-control-sm" value="<?=$rt['keterangan'];?>" name="keterangan_<?=$rt['id']?>" />
                            <?php } ?>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
            <button style="position: fixed; bottom: 0; right: 0;" type="submit" class="btn btn-block btn-navy"><i class="fa fa-save"></i> SIMPAN</button>
            </form>
        </div>
    </div>
    <script>
        $('#form_edit_data_tindakan').on('submit', function(e){
            e.preventDefault()
            $.ajax({
                url:"<?=base_url("pelayanan/C_Pelayanan/editDataTindakan")?>"+"/"+'<?=$tindakan['id_t_pendaftaran']?>',
                method:"post",
                data: $(this).serialize(),
                success:function(data){
                    $('#edit_data_tindakan_modal').modal('hide')
                    $('body').removeClass('modal-open');
                    $('.modal-backdrop').remove();
                    LoadViewInputTindakan('<?=$tindakan['id_t_pendaftaran']?>')
                } , error: function(e){
                    errortoast('Terjadi Kesalahan')
                }
            })
        })
    </script>
<?php } else { ?>
<?php } ?>