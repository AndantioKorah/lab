<div class="card card-default">
    <div class="card-header"  style="display: block;">
        <h3 class="card-title">TAMBAH CARA BAYAR</h3>
    </div>
    <div class="card-body" style="display: block;">
        <form id="form_tambah_role">
            <div class="row">
                <div class="col-4">
                    <div class="form-group">
                        <label class="bmd-label-floating">Cara Bayar</label>
                        <select class="form-control select2 select2-navy" style="width: 100%" id="id_m_cara_bayar" data-dropdown-css-class="select2-navy" name="id_m_cara_bayar">
                            <?php foreach($cara_bayar as $c){ ?>
                                <option <?=$c['id'] == 2 ? "selected" : ""?> value="<?=$c['id']?>"><?=$c['nama_cara_bayar']?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <div class="col-4">
                    <div class="form-group">
                        <label class="bmd-label-floating">Nama Cara Bayar Detail</label>
                        <input class="form-control" autocomplete="off" name="nama_cara_bayar_detail" id="nama_cara_bayar_detail"/>
                    </div>
                </div>

                <div class="col-2 mt-2">
                    <div class="form-group">
                        <br>
                        <button class="btn btn-block btn-navy" type="submit"><i class="fa fa-save"></i> SIMPAN</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="card card-default">
    <div class="card-header">
        <h3 class="card-title">LIST CARA BAYAR DETAIL</h3>
    </div>
    <div class="card-body">
        <div id="list_cara_bayar_detail" class="row">
        </div>
    </div>
</div>

<script>
    $(function(){
        $('.select2').select2()
        loadCaraBayarDetail()
    })

    function loadCaraBayarDetail(){
        $('#list_cara_bayar_detail').html('')
        $('#list_cara_bayar_detail').append(divLoaderNavy)
        $('#list_cara_bayar_detail').load('<?=base_url("master/C_Master/loadCaraBayarDetail")?>', function(){
            $('#loader').hide()
        })
    }

    $('#form_tambah_role').on('submit', function(e){
        e.preventDefault();
        $.ajax({
            url: '<?=base_url("master/C_Master/createMasterCaraBayarDetail")?>',
            method: 'post',
            data: $(this).serialize(),
            success: function(){
                loadCaraBayarDetail()
                $('#nama_cara_bayar_detail').val('')
            }, error: function(e){
                errortoast('Terjadi Kesalahan')
            }
        })
    })

</script>