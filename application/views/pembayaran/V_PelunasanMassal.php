<div class="row" id="div_menu">
    <div class="col">
        <div class="card card-default" style="height: 170px;">
            <div class="card-header">
                <div class="row">
                    <div class="col-6" style="top: 50%;">
                        <h3 class="card-title"><strong>PELUNASAN MASSAL</strong></h3>
                    </div>
                    <div class="col-6 text-right">
                        <button href="#modalHistoryPelunasanMassal" data-toggle="modal" class="btn btn-sm btn-navy" onclick="openModalHistory()">
                        <i class="fa fa-clock"></i> History</button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form id="formSearchMenuListPendaftaran">
                    <div class="row">
                        <div class="col-6">
                            <label>Range Tanggal</label>
                            <input class="form-control form-control-sm datepicker" autocomplete="off" name="range_tanggal" id="range_tanggal"/>
                        </div>
                        <div class="col-6">
                            <label>Cara Bayar</label>
                            <select class="form-control form-control-sm select2_cara_bayar select2-navy" style="width: 100%" id="cara_bayar" data-dropdown-css-class="select2-navy" name="cara_bayar">
                                <?php foreach($cara_bayar as $cb){ ?>
                                    <option value="<?=$cb['id']?>"><?=$cb['nama_cara_bayar_detail']?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div id="div_count" style="display: none;" class="col">
        <div class="card card-default" style="height: 170px;">
            <div class="card-header">
                <div class="row">
                    <div class="col-12" style="top: 50%;">
                        <h3 class="card-title"><strong>Total Hitungan</strong></h3>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-4">
                        <label>Jumlah Pendaftaran:</label>
                        <h4 id="jumlah_pendaftaran_pm">0</h4>
                    </div>
                    <div class="col-4">
                        <label>Total Tagihan:</label>
                        <h4 id="total_tagihan_pm">0</h4>
                    </div>
                    <div class="col-4">
                        <br>
                        <button id="btn_submit_pm" onclick="submitPelunasanMassal()" type="button" class="btn btn-sm btn-navy text-center">Submit Pelunasan</button>
                        <button id="btn_loading_pm" style="display: none;" disabled type="button" class="btn btn-sm btn-navy text-center"><i class="fa fa-spin fa-spinner"></i> Loading...</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12" id="div_list_pendaftaran">
        <div class="card card-default">
            <div class="card-body">
                <div class="row">
                    <div class="col-12" id="divListPendaftaran">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalHistoryPelunasanMassal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div id="modal-dialog" class="modal-dialog modal-xl">
      <div class="modal-content">
          <div class="modal-header">
              <h6 class="modal-title">History Pelunasan Massal</h6>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div id="modalHistoryPelunasanMassalContent">
          </div>
      </div>
  </div>
</div>

<script>
    let id_m_pasien = 0;
    let total_tagihan = parseInt(0)
    let jumlah_pendaftaran = parseInt(0)
    $(function(){
        $('.datepicker').daterangepicker({
            locale: {
                format: 'DD/MM/YYYY'
            }
        })
        $('.select2_cara_bayar').select2()
 
        // submitFormSearchMenuListPendaftaran()
    }) 

    function openModalHistory(){
        $('#modalHistoryPelunasanMassalContent').html('')
        $('#modalHistoryPelunasanMassalContent').append(divLoaderNavy)
        $('#modalHistoryPelunasanMassalContent').load('<?=base_url("pembayaran/C_Pembayaran/loadHistoryPelunasanMassal")?>', function(){
            $('#loader').hide()
        })
    }

    $('#cara_bayar').on('change', function(){
        submitFormSearchMenuListPendaftaran()
    })

    $('#range_tanggal').on('change', function(){
        submitFormSearchMenuListPendaftaran()
    })

    function submitPelunasanMassal(){
        $('#pelunasanMassalForm').submit()
    }

    function loadListPendaftaranPasien(){
        $('#label_card_header').html('LIST PENDAFTARAN')
        $('#btn_list_pendaftaran').hide()

        $('#div_detail_pendaftaran').html('')
        $('#div_detail_pendaftaran').hide()

        $('#div_menu').show()
        $('#div_detail').hide()

        submitFormSearchMenuListPendaftaran()
    }

    function submitFormSearchMenuListPendaftaran(){
        $('#formSearchMenuListPendaftaran').submit()
    }

    $('#formSearchMenuListPendaftaran').on('submit', function(e){
        e.preventDefault()
        $('#divListPendaftaran').html('')
        $('#divListPendaftaran').append(divLoaderNavy)
        $.ajax({
            url: '<?=base_url("pembayaran/C_Pembayaran/searchPendaftaranPelunasanMassal")?>',
            method: 'post',
            data: $(this).serialize(),
            success: function(data){
                $('#div_count').hide()
                $('#divListPendaftaran').html('')
                $('#divListPendaftaran').append(data)
            }, error: function(err){
                console.log(err)
                errortoast('Terjadi Kesalahan')
            }
        })
    })
</script>