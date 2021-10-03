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
               padding-left: 20px;
               font-family: Verdana;
            }
            .td_detail_tindakan{
               border-left: 1px solid black;
               padding-top: 3px;
               padding-bottom: 3px;
               padding-right: 3px;
               padding-left: 40px;
               font-family: Verdana;
            }
            .td_detail_tindakan_detail{
                vertical-align: top;
                text-align: center;
                border-left: 1px solid black;
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
    <body style="font-family: <?=FONT_CETAKAN?> !important; ">
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
                            <th class="thead_rincian_tindakan_cetakan">JENIS PEMERIKSAAN</th>
                            <th class="thead_rincian_tindakan_cetakan">HASIL</th>
                            <th class="thead_rincian_tindakan_cetakan">NILAI NORMAL</th>
                            <th class="thead_rincian_tindakan_cetakan">SATUAN</th>
                            <th class="thead_rincian_tindakan_cetakan">CATATAN</th>
                        </tr>
                    </thead>
                    <tbody >
                        <?php $j = 0; foreach($rincian_tindakan[$i] as $rt){
                            $jenis_pemeriksaan = '';
                            $hasil = null;
                            $nilai_normal = null;
                            $satuan = null;
                            $catatan = null;
                            $class_tr = '';
                            $class_tr_detail = '';
                            if(isset($rt['nm_jns_tindakan'])){
                                $jenis_pemeriksaan = strtoupper($rt['nm_jns_tindakan']);
                                $class_tr = 'td_jns_tindakan';
                            } else if(isset($rt['id_t_pendaftaran']) && $rt['parent_id_tindakan'] == '0'){
                                $jenis_pemeriksaan = $rt['nama_tindakan'];
                                $hasil = $rt['hasil'];
                                $class_tr = 'td_tindakan';
                                $nilai_normal = $rt['nilai_normal'];
                                $satuan = $rt['satuan'];
                                $catatan = $rt['keterangan'];
                            } else if(isset($rt['id_t_pendaftaran']) && $rt['parent_id_tindakan'] != '0'){
                                $jenis_pemeriksaan = $rt['nama_tindakan'];
                                $hasil = $rt['hasil'];
                                $nilai_normal = $rt['nilai_normal'];
                                $satuan = $rt['satuan'];
                                $catatan = $rt['keterangan'];
                                $class_tr = 'td_detail_tindakan';
                                $class_tr_detail = 'td_detail_tindakan_detail';
                                if($hasil != ''){
                                    $hasil = formatTextHasil($hasil, $nilai_normal);
                                }
                            }
                        ?>
                            <tr>
                                <td style="width: 45%; font-size: 20px;" class="<?=$class_tr?>"><?=$jenis_pemeriksaan?></td>
                                <td style="width: 10%; font-size: 20px;" class="td_detail_tindakan_detail" style="text-align:center"><?=$hasil?></td>
                                <td style="width: 15%; font-size: 20px;" class="td_detail_tindakan_detail" style="text-align:center"><?=$nilai_normal?></td>
                                <td style="width: 10%; font-size: 20px;" class="td_detail_tindakan_detail" style="text-align:center"><?=$satuan?></td>
                                <td style="width: 20%; font-size: 20px;" class="<?=$class_tr?>" style="text-align:center"><?=$catatan?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
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
            </div>
        <?php } ?>
    </body>
</html>