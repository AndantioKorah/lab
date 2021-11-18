<html>
    <head>
        <style>
            .thead_rincian_tindakan_cetakan{
                font-weight: bold;
                text-align: center;
                font-size: 20px;
                border-left: 1px solid black;
                border-right: 1px solid black;
                border-bottom: 1px solid black;
                border-top: 2px solid black;
                height: 30px;
                font-family: Verdana;
            }
            .content_rincian_tagihan{
                width: 100%;
                border: 1px solid black;
                border-collapse: collapse;
                font-family: Verdana;
                /* margin-top: 10px; */
            }
            .td_jns_tindakan{
               border-left: 1px solid black;
               padding: 3px;
               font-style: italic;
               font-family: Verdana;
            }
            .td_tindakan{
               border-left: 1px solid black;
               padding-top: 3px;
               padding-bottom: 3px;
               padding-right: 3px;
               /* padding-left: 20px; */
               font-family: Verdana;
            }
            .td_detail_tindakan{
               border-left: 1px solid black;
               padding-top: 3px;
               padding-bottom: 3px;
               padding-right: 3px;
               /* padding-left: 40px; */
               font-family: Verdana;
            }
            .td_detail_tindakan_detail{
                vertical-align: top;
                text-align: center;
                border-left: 1px solid black;
                border-right: 1px solid black;
                font-size: 18px;
                font-family: Verdana;
            }
            .div_pemeriksa{
                width: 100%;
            }
            .span_pemeriksa_cetak_tindakan{
                font-size: 20px;
            }
        </style>
    </head>
    <?php 
    $nama = str_replace(",","",$pendaftaran['nama_pasien']); 
    $filename = 'Rincian Tindakan '.$nama.' '.formatDateNamaBulan(date('Y-m-d H:i:s')).'.xls';
    header("Content-type: application/vnd-ms-excel");
    header("Content-Disposition: attachment; filename=$filename"); 
?> 
    <body style="font-family: <?=FONT_CETAKAN?> !important; ">
        <?php for($i = 1; $i <= $page_count; $i++){ ?>
            <div class="">
                <?php
                    $data['pendaftaran'] = $pendaftaran;    
                    $data['page_number'] = $i;    
                    $data['page_count'] = $page_count;  
                    $this->load->view('cetakan/V_HeaderCetakan', $data);  
                ?>
                <table class="content_rincian_tagihan" >
                    <thead>
                        <tr>
                            <th class="thead_rincian_tindakan_cetakan">JENIS PEMERIKSAAN</th>
                            <th class="thead_rincian_tindakan_cetakan">HASIL</th>
                            <th class="thead_rincian_tindakan_cetakan">NILAI NORMAL</th>
                            <th class="thead_rincian_tindakan_cetakan">SATUAN</th>
                            <th class="thead_rincian_tindakan_cetakan">CATATAN</th>
                        </tr>
                    </thead>
                    <tbody >
                        <?php $j = 0; foreach($rincian_tindakan[$i] as $rt){
                            // dd(count($rincian_tindakan[$i]));
                            $rt['padding-left'] = intval($rt['padding-left']) + 10;
                            $style_rincian_tindakan = "padding-left: ".$rt['padding-left']."px;";
                            if(isset($rt['id_m_jns_tindakan'])){
                                if($rt['id_m_jns_tindakan'] == 0){
                                    $style_rincian_tindakan .= "font-size: 18px; text-transform: uppercase;";
                                }
                                $style_rincian_tindakan .= "font-weight: normal;";
                            } 

                            $hasil = isset($rt['hasil']) ? $rt['hasil'] : '';
                            $nilai_normal = isset($rt['nilai_normal']) ? $rt['nilai_normal'] : '';
                            $satuan = isset($rt['satuan']) ? $rt['satuan'] : '';
                            $catatan = isset($rt['keterangan']) ? $rt['keterangan'] : '';
                            $class_tr = '';
                            $class_tr_detail = '';
                            if($hasil != ''){
                                $hasil = formatTextHasil($rt['hasil'], $rt['nilai_normal']);
                            }
                            if($nilai_normal == "-"){
                                $nilai_normal = "";
                            } 

                        ?>
                            <tr>
                                <td style="width: 35%; font-size: 16px; <?=$style_rincian_tindakan?>"><?=$rt['nama_tindakan']?></td>
                                <td style="width: 20%; font-size: 16px;" class="td_detail_tindakan_detail" style="text-align:center"><?=$hasil?></td>
                                <td style="width: 20%; font-size: 16px;" class="td_detail_tindakan_detail" style="text-align:center"><?=$nilai_normal?></td>
                                <td style="width: 10%; font-size: 16px;" class="td_detail_tindakan_detail" style="text-align:center"><?=$satuan?></td>
                                <td style="width: 15%; font-size: 16px; padding-left: 5px;"><?=$catatan?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        <?php } ?>
        <table style="width: 100%; margin-top: 20px;">
            <tr>
                <td style="width: 20%;"></td>
                <td style="width: 20%;"></td>
                <td style="width: 20%;"></td>
                <td style="width: 20%;"></td>
                <td style="width: 20%; text-align: center;">
                    <span class="span_pemeriksa_cetak_tindakan">Lab. Klinik PATRA</span><br>
                    <span class="span_pemeriksa_cetak_tindakan">Pemeriksa:</span>
                </td>
            </tr>
        </table>
    </body>
</html>