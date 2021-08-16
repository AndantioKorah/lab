<div class="col-12 mt-2">
        <form id="form_input_tindakan">
        <input  class="col-12" type='hidden'  id='id_m_status_tagihan' value=<?php echo $id_tagihan['0']->id_m_status_tagihan;?>>
        <input  class="col-12" type='hidden'  id='id_tagihan' value=<?php echo $id_tagihan['0']->id;?>>
        <input  class="col-12" type='hidden'  id='id_pendaftaran' value=<?php echo $id_pendaftaran;?>>
        <input  class="col-12" type='hidden'  id='jenis_kelamin' value=<?php echo $pasien[0]->jenis_kelamin;?>>
        <input  class="col-12" type='hidden'  id='tanggal_lahir' value=<?php echo $pasien[0]->tanggal_lahir;?>>
        
        <?php if($id_tagihan['0']->id_m_status_tagihan == 1){ ?>
            <select class='col-12' id="cari_tindakan" type='text' placeholder="Cari Tindakan...">Cari Tindakan...</select>
             <button id="button_submit_input_tindakan " type="submit" class="btn btn-navy btn-sm col-12 mt-2 button_submit_input_tindakan"> Simpan </button>
        <?php }?>

    
    </form>
    <button
        <?php if($id_tagihan[0]->id_m_status_tagihan == 3) echo "style='display:none'" ;?>
        onclick="cetakHasil()" class="btn btn-sm btn-navy mt-2" ><i class="fa fa-print"></i> Cetak Hasil</button> 
       
        <div id="tabel_tindakan_pasien" class="row p-2 mt-4" style="border-radius: 10px; border: 1px solid #001f3f;   background-color: #white;font-color: #000000;">
                <div class="col-12" style="border-bottom: 1px solid #001f3f;">
                    <span style="font-size: 15px; font-weight: bold;">TINDAKAN PASIEN</span>
                </div>
                <div class="col-12 mt-2">
                          
  <form method="post" id="form_hasil">        
  <table class="table table-sm table-hover" border="0">
            <thead class="thead_rincian_tindakan">
                <th style="width: 5%;" class="text-center" >No</th>
                <th style="width: 25%;" >Tindakan</th>
                <th  style="width: 15%;"  class="text-left">Hasil</th>
                <th  style="width: 15%;"  class="text-left">Nilai Normal</th>
                <th  style="width: 10%;"  class="text-left">Satuan</th>
                <th  style="width: 25%;"  class="text-left">Keterangan</th>
                <th style="width: 5%;"  class="text-left"></th>
               
            </thead>
            <tbody class="tbody_rincian_tindakan" id="daftar_tindakan">
                <?php if(isset($rincian_tindakan)){ 
                    $no=1; 
                  
                    foreach($rincian_tindakan as $rt){ 
                    ?>
                    <tr style="cursor: pointer;">
                        <td class="text-center"><b style="font-size: 18px;"><?=$no;?></b></td>
                        <td ><b style="font-size: 18px;"><?=$rt['nm_jns_tindakan']?></b></td>
                        <td  class="text-center"></td>
                        <td  class="text-center"></td>
                        <td  class="text-center"></td>
                        <td  class="text-center"></td>
                        <td  class="text-center"></td>
                      <!-- tes -->
                      <?php 
                      
                        if(isset($rt['tindakan'])){  
                            $nmr=1;
                            $styleTagihan = null;
                            if($id_tagihan['0']->id_m_status_tagihan == 2) $styleTagihan="style='display:none;'"; else $styleTagihan="style=''";  
                            foreach($rt['tindakan'] as $dt){   
                            // $list_id = array(7,8,31); if (in_array($dt['id_m_nm_tindakan'], $list_id)) { $style="style='display:none;'"; } else {$style="style=''";}
                            if ($dt['nilai_normal'] == null || $dt['nilai_normal'] == "" ) { $style="style='display:none;'"; } else {$style="style=''";}  
                          ;?>
                        <tr  style="cursor: pointer;">
                            <td  class="text-center"> <?=$no.'.'.$nmr;?> </td>
                            <td ><b><?=$dt['nama_tindakan']?></b></td>
                            <td >
                            <input <?=$style;?> name="hasil[]"   autocomplete="off" class="col-12 hsl" type='text' value="<?php if($dt['hasil'] == null) echo ""; else echo $dt['hasil'];?>">
                            <input type="hidden" name="id_t_tindakan[]"  value="<?=$dt['id']?>" />
                            </td>
                            <td ><input <?=$style;?> name="nilai_normal[]" class="col-12" type='text' value="<?=$dt['nilai_normal']?>" ></td>
                            <td ><input <?=$style;?> name="satuan[]" class="col-12" type='text' value="<?=$dt['satuan']?>" readonly></td>
                            <td ><input <?=$style;?> name="keterangan[]" class="col-12" type='text' value="<?=$dt['keterangan']?>" ></td>
                            <td >
                            <input <?= $styleTagihan;?> type="button" title="Hapus Tindakan"  class="btn btn-danger btn-sm tombol_hapus_tindakan" data-idtindakan="<?=$dt['id']?>"  value="Hapus"></td>  
                        </td> 
                        </tr>
                    
                        <?php  if(isset($dt['detail_tindakan'])){ foreach($dt['detail_tindakan'] as $d) { ?>
                        <tr>
                            <td ></td>
                            <td ><?=$d['nama_tindakan']?></td>
                            <td> <input name="hasil[]"   autocomplete="off" class="col-12 hsl" type='text'value="<?php if($d['hasil'] == null) echo ""; else echo $d['hasil'];?>" ></td>
                              <input type="hidden" name="id_t_tindakan[]"  value="<?=$d['id']?>" />
                            </td>
                            <td><input name="nilai_normal[]" class="col-12" type='text' value="<?=$d['nilai_normal']?>" ></td>
                            <td><input name="satuan[]" class="col-12" type='text' value="<?=$d['satuan']?>" readonly></td>
                            <td ><input name="keterangan[]" class="col-12" type='text' value="<?=$d['keterangan']?>" ></td>
                            <td></td>
                        </tr>
                        <?php } } $nmr++; } } ?>
                        <!-- tes -->
                      
                    </tr>
                    <?php $no++; ?> 
                    <script>
                    function cetakHasil() {
                        $("#print_div").load('<?= base_url('pelayanan/C_Pelayanan/cetakHasil/'.$id_pendaftaran)?>',
                            function () {
                                printSpace('print_div');
                            });
                    }

                    function printSpace(elementId) {
                        var isi = document.getElementById(elementId).innerHTML;
                        window.frames["print_frame"].document.title = document.title;
                        window.frames["print_frame"].document.body.innerHTML = isi;
                        window.frames["print_frame"].window.focus();
                        window.frames["print_frame"].window.print();
                    }
                </script>
                <?php } } else { ?>
                    <tr>
                        <td colspan="4">BELUM ADA DATA</td>
                    </tr>
                <?php   } ?>
            </tbody>
        </table> 
        <?php if($rincian_tindakan){ ?>
            <button 
            <?php if($id_tagihan[0]->id_m_status_tagihan == 3) echo "style='display:none'" ;?> 
            class="btn btn-navy btn-sm col-12 mt-2 simpan"> Simpan Hasil </button>        
        <?php } ?>
       </form>
       </div>


<script>

$(function(){
    // tampilTindakan()
    })
    $('.data_table_this').DataTable({
                    responsive: false
     });



     var base_url = "<?=base_url()?>";

$('#form_input_tindakan').on('submit', function(e){
        e.preventDefault() 

        var id_pendaftaran = $('#id_pendaftaran').val();
        var id_tagihan = $('#id_tagihan').val();
        var tindakan = $('#cari_tindakan').val();
        var tanggal_lahir = $('#tanggal_lahir').val();
        var jenis_kelamin = $('#jenis_kelamin').val();
        
        if(tindakan == "" || tindakan == null){
            errortoast('  Tindakan Belum dipilih')
            $('#button_submit_input_tindakan').show('fast')
            return false
        }  
        // $('#button_loading').show()
        // $('#button_submit_input_tindakan').hide('fast')   
        $('.button_submit_input_tindakan').html('Loading <i class="fas fa-spinner fa-spin"></i>');
    
            // tindakan = tindakan.tlist_idtring();
            //  $('#daftar_tindakan').html('');
            //  $('#daftar_tindakan').append(divLoaderNavy)
				$.ajax({
					url:"<?=base_url("pelayanan/C_Pelayanan/insertTindakan")?>",
					method:"post",
					data:{id_pendaftaran:id_pendaftaran,tindakan:tindakan,id_tagihan:id_tagihan,tanggal_lahir:tanggal_lahir,jenis_kelamin:jenis_kelamin},
					success:function(data){
                        let res = JSON.parse(data)
                        if(res.code == 1){
                         errortoast(res.message)
                        } 
                        LoadViewInputTindakanAfterSubmit(id_pendaftaran)
                        // tampilTindakan()
						// $('#result').html(data);
					} , error: function(e){
                errortoast('Terjadi Kesalahan')
            }
		})
        $('#button_submit_input_tindakan').show('fast')
    })



function searchTable() {
   
    var input;
    var saring;
    var status; 
    var tbody; 
    var tr; 
    var td;
    var i; 
    var j;
    input = document.getElementById("input");
    saring = input.value.toUpperCase();
    tbody = document.getElementsByTagName("tbody")[0];;
    tr = tbody.getElementsByTagName("tr");
    for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td");
        for (j = 0; j < td.length; j++) {
            if (td[j].innerHTML.toUpperCase().indexOf(saring) > -1) {
                status = true;
            }
        }
        if (status) {
            tr[i].style.display = "";
            status = false;
        } else {
            tr[i].style.display = "none";
        }
    }
}


function tampilTindakan()
    {            
        var id_pendaftaran = $('#id_pendaftaran').val();
        var id_m_status_tagihan = $('#id_m_status_tagihan').val();
       
        $.ajax({
            url:"<?=base_url("pelayanan/C_Pelayanan/getTindakanPasien")?>",
            data : {id_pendaftaran : id_pendaftaran },
            method : 'post',
            dataType : 'json',
            success : function (data){ 
                                                
                $('#daftar_tindakan').html('');
                
                let no = 1;    
                if (data != 0){                    
                    $.each(data, function (i, item){
                //   console.log()
                        if(id_m_status_tagihan == 2){
                            style="style='display:none;'";
                        } else {
                            style="";
                        }

                        $('#loader').hide()
                        $('#daftar_tindakan').append(
                            '<tr>'+
                                '<td>'+no+'</td>'+
                                '<td>'+data[i].nama_tindakan+'</td>'+
                                '<td><button '+style+'  title="Hapus Tindakan"  class="btn btn-danger btn-sm tombol_hapus_tindakan" data-idtindakan="'+data[i].id+'"><i class="fa fa-trash fa-sm"></i></button></td>'+
                            '</tr>'
                        );
                        no++;
                    });                      
                } else {
                    $('#daftar_tindakan').append('<tr><td colspan="6">Belum Ada Tindakan</td></tr>');
                }         
            },
            error : function (err){
                console.log(err);
            }

        })        
    }

    $('#daftar_tindakan').on('click','.tombol_hapus_tindakan',function(){
        var base_url = 'http://localhost/lab/';
        var id_pendaftaran = $('#id_pendaftaran').val();
         if(confirm('Apakah anda yakin?')){ 
            $(this).html('<i class="fas fa-spinner fa-spin"></i>')
            let idtindakan = $(this).data('idtindakan');
            $.post(
                base_url+"pelayanan/C_Pelayanan/delTindakanPasien", 
                { 
                    idtindakan : idtindakan, id_pendaftaran:id_pendaftaran
                }
            )
            .done(function(data) { 
                LoadViewInputTindakanAfterSubmit(id_pendaftaran)                               
            })
            .fail(function(err){
                $(this).html('<i class="fas fa-trash"></i>')
                customAlert(err.status);
            });
            $(this).cllist_idest("tr").fadeOut();    
        }
    });

    $("#cari_tindakan").select2({
        placeholder: "Cari Tindakan",
        tokenSeparators: [',', ' '],
        minimumInputLength: 2,
        minimumResultsForSearch: 10,
        ajax: {
            url: '<?=base_url("pelayanan/C_Pelayanan/select2Tindakan")?>',
            dataType: "json",
            type: "POST",
            data: function (params) {

                var queryParameters = {
                    search_param: params.term
                }
                return queryParameters;
            },
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            text: item.nm_tindakan,
                            id: item.id_tindakan
                        }
                    })
                };
            }
        }
    });




  $('#form_hasil').on('submit', function(event){
	$('.simpan').html('Loading <i class="fas fa-spinner fa-spin"></i>');
	event.preventDefault();
	var id_pendaftaran = $('#id_pendaftaran').val();
    var count_data = 0;
  $('.hsl').each(function(){
   count_data = count_data + 1;
  });
  console.log(count_data)
  if(count_data > 0)
  {
   var form_data = $(this).serialize();
   $.ajax({
	url:  base_url + "pelayanan/C_Pelayanan/createHasil",
    // url:"insert.php",
    method:"post",
	data:form_data,
	
    success:function(data)
    {
			// $('.simpan').html('Simpan');
            LoadViewInputTindakan(id_pendaftaran)
    	// $('#action_alert').html('<h4>Berhasil</h4>')
    }
   })
  }
  else
  {
   $('#action_alert').html('<p>Please Add atleast one data</p>');
   $('#action_alert').dialog('open');
  }
 });

 function LoadViewInputTindakanAfterSubmit(id = 0, callback = 0){
        setHeader('tindakan')
        $('[data-tooltip="tooltip_detail_pendaftaran_left"]').tooltip('hide')
        // loadDetailPendaftaran(id)
        $('#content_div_transaksi').html('')
        $('#content_div_transaksi').append(divLoaderNavy)
        $('#content_div_transaksi').load('<?=base_url("pelayanan/C_Pelayanan/loadViewInputTindakan")?>'+'/'+id, function(){
            $('#loader').hide()
        })
  }

</script>