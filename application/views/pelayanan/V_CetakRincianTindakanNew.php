<html>
    <head>
        <style>
            .thead_rincian_tindakan_cetakan{
                font-weight: bold;
                text-align: center;
                font-size: 16px;
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
                margin-top: 5px;
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
            .td_detail_tindakan_detail_hasil{
                vertical-align: top;
                text-align: right;
                border-left: 1px solid black;
                /* border-right: 1px solid black; */
                font-size: 18px;
                font-family: Verdana;
            }

            .td_detail_tindakan_detail_hasil_ket{
                vertical-align: top;
                text-align: left;
                /* border-left: 1px solid black; */
                border-right: 1px solid black;
                font-size: 18px;
                font-family: Verdana;
            }
            .div_pemeriksa{
                width: 100%;
            }
            .span_pemeriksa_cetak_tindakan{
                font-size: 18px;
            }
            .pagebreak{
                padding-top: 150px;
                padding-left: 50px;
                padding-right: 50px;
            }

            .footer_table_cetak_tindakan{
                padding-left: 50px;
                padding-right: 50px;
            }
        </style>
    </head>
    <body style="font-family: <?=FONT_CETAKAN?> !important; ">
        <?php $style_pj = ""; if($rincian_tindakan){ ?>
            <?php for($i = 1; $i <= $page_count; $i++){ ?>
                <div class="pagebreak">
                    <?php
                        $data['pendaftaran'] = $pendaftaran;    
                        $data['page_number'] = $i;    
                        $data['page_count'] = $page_count;  
                        $this->load->view('cetakan/V_HeaderCetakan', $data);  
                    ?>
                    <table class="content_rincian_tagihan" >
                        <thead>
                            <tr>
                                <th class="thead_rincian_tindakan_cetakan">JENIS PEMERIKSAAN </th>
                                <th class="thead_rincian_tindakan_cetakan" colspan=2>HASIL</th>
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
                                $hasil_ket = null;
                                $nilai_normal = isset($rt['nilai_normal']) ? $rt['nilai_normal'] : '';
                                $satuan = isset($rt['satuan']) ? $rt['satuan'] : '';
                                $catatan = isset($rt['keterangan']) ? $rt['keterangan'] : '';
                                $class_tr = '';
                                $class_tr_detail = '';
                                if($hasil != ''){
                                    $hasil_ket = formatTextHasilNew($rt['hasil'], $rt['nilai_normal'], $satuan,$rt['id_m_nm_tindakan']);
                                    if($hasil_ket != ''){
                                        $hasil = '<strong>'.$hasil.'</strong>';
                                    }
                                }
                                if($nilai_normal == "-"){
                                    $style_nilai_normal_kosong = "color: rgba(0, 0, 0, 0);";
                                } else {
                                    $style_nilai_normal_kosong = "";
                                }

                                if($rt['id_m_nm_tindakan'] == 987){
                                    $style_pj = "";
                                } else {
                                    $style_pj = "display:none";
                                }

                            ?>
                                <tr>
                                    <td style="width: 33%; font-size: 16px; <?=$style_rincian_tindakan?>"><?=$rt['nama_tindakan'].''?> </td>
                                    <td style="width: 14%; font-size: 16px;" class="td_detail_tindakan_detail_hasil" style="text-align:right"><?=$hasil?></td>
                                    <td style="width: 5%; font-size: 16px;" class="td_detail_tindakan_detail_hasil_ket" style="text-align:right"><?=$hasil_ket?></td>
                                    <td style="width: 20%; font-size: 16px; <?=$style_nilai_normal_kosong?>" class="td_detail_tindakan_detail" style="text-align:center"><?=$nilai_normal?></td>
                                    <td style="width: 10%; font-size: 16px;" class="td_detail_tindakan_detail" style="text-align:center"><?=$satuan?></td>
                                    <td style="width: 15%; font-size: 12px; padding-left: 5px;"><?=$catatan?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            <?php } ?>
        <?php } ?>
        <table class="footer_table_cetak_tindakan" style="width: 100%; margin-top: 20px;">
            <tr>
                <td style="width: 40%; text-align: center; vertical-align: top; <?=$style_pj;?>">
                    <span class="span_pemeriksa_cetak_tindakan">Penanggung-jawab </span><br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <span class="span_pemeriksa_cetak_tindakan"><?=$pendaftaran['nama_dokter_dpjp']?></span>
                </td>
                <td style="width: 20%;"></td>
                <td style="width: 40%; text-align: center; vertical-align: top;">
                    <span class="span_pemeriksa_cetak_tindakan">Lab. Klinik PATRA</span><br>
                    <span class="span_pemeriksa_cetak_tindakan">Pemeriksa:</span>
                </td>
            </tr>
        </table>
    </body>
</html>