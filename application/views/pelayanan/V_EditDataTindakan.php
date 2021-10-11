<?php if($tindakan){ ?>
    <div class="row">
        <div class="col-12">
            <h5><?=$tindakan['nama_tindakan']?></h5>
        </div>
        <div class="col-12">
            <form id="form_edit_data_tindakan">
            <table class="table table-hover">
                <thead>
                    <th>No</th>
                    <th>Nama Tindakan</th>
                    <th>Hasil</th>
                    <th>Nilai Normal</th>
                    <th>Satuan</th>
                    <th>Keterangan</th>
                </thead>
                <tbody>
                    <tr>
                        <input name="id_t_tindakan[]" value="<?=$tindakan['id']?>" type="hidden">
                        <td colspan=2><strong><?=$tindakan['nama_tindakan'];?></strong></td>
                        <td><?=$tindakan['hasil'];?></td>
                        <td>
                            <?php if($tindakan['nilai_normal']){ ?>
                                <input class="form-control form-control-sm" value="<?=$tindakan['nilai_normal'];?>" name="nilai_normal[]" />
                            <?php } ?>
                        </td>
                        <td>
                            <?php if($tindakan['nilai_normal']){ ?>
                                <input class="form-control form-control-sm" value="<?=$tindakan['satuan'];?>" name="satuan[]" />
                            <?php } ?>
                        </td>
                        <td>
                            <?php if($tindakan['nilai_normal']){ ?>
                                <input class="form-control form-control-sm" value="<?=$tindakan['keterangan'];?>" name="keterangan[]" />
                            <?php } ?>
                        </td>
                    </tr>
                    <?php if($detail_tindakan){ $no = 1; foreach($detail_tindakan as $dt){ ?>
                        <tr>
                            <input name="id_t_tindakan[]" value="<?=$dt['id']?>" type="hidden">
                            <td><?=$no++;?></td>
                            <td><?=$dt['nama_tindakan'];?></td>
                            <td><?=$dt['hasil'];?></td>
                            <td><input class="form-control form-control-sm" value="<?=$dt['nilai_normal'];?>" name="nilai_normal[]" /></td>
                            <td><input class="form-control form-control-sm" value="<?=$dt['satuan'];?>" name="satuan[]" /></td>
                            <td><input class="form-control form-control-sm" value="<?=$dt['keterangan'];?>" name="keterangan[]" /></td>
                        </tr>
                    <?php } } ?>
                </tbody>
            </table>
            <button type="submit" class="btn btn-block btn-navy"><i class="fa fa-save"></i> SIMPAN</button>
            </form>
        </div>
    </div>
    <script>
        $('#form_edit_data_tindakan').on('submit', function(e){
            e.preventDefault()
            $.ajax({
                url:"<?=base_url("pelayanan/C_Pelayanan/editDataTindakan")?>",
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