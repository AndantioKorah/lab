<html>
    <head>
        <style>
            .thead_rincian_tagihan_cetakan{
                font-weight: bold;
                text-align: center;
                /* font-size: 12px; */
                border-left: 1px solid black;
                border-right: 1px solid black;
                border-bottom: 1px solid black;
                border-top: 2px solid black;
            }
            .content_rincian_tagihan{
                width: 100%;
                border: 1px solid black;
                border-collapse: collapse;
                /* margin-top: 10px; */
            }
            .td_jns_tindakan{
               border: 1px solid black;
               font-weight: bold;
               /* font-size: 12px; */
               padding: 3px;
            }
            .td_tagihan{
                border: 1px solid black; 
                border-left: 1px solid black;
                border-right: 1px solid black;
                font-weight: bold;
                /* font-size: 12px; */
                padding: 3px;
            }
       
  
        </style>
    </head>
    <body style="font-family: <?=FONT_CETAKAN?>;">
        <?php $pNo = 0; $chNo = 0; $halaman = 1; for($i = 1; $i <= $page_count; $i++){ ?>
            <div class="pagebreak">
                <?php
                    $data['pendaftaran'] = $pendaftaran;    
                    $data['page_number'] = $i;    
                    $data['page_count'] = $page_count;  
                    $this->load->view('cetakan/V_HeaderCetakan', $data);  
                ?>
                <table class="content_rincian_tagihan">
                    <thead>
                        <tr>
                            <th class="thead_rincian_tagihan_cetakan set_font">NO</th>
                            <th class="thead_rincian_tagihan_cetakan set_font">TAGIHAN</th>
                            <th class="thead_rincian_tagihan_cetakan set_font">BIAYA</th>
                            <th class="thead_rincian_tagihan_cetakan set_font">TANGGAL INPUT</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $j = 0; foreach($rincian_tagihan[$i] as $rt){
                            if(!isset($rt['nama_tindakan'])){
                            $tagihan = '';
                            $biaya = null;
                            $tanggal_input = null;
                            $row_num = '';
                            $class_tr = '';
                            if(isset($rt['nm_jns_tindakan'])){
                                $tagihan = strtoupper($rt['nm_jns_tindakan']);
                                $chNo = 0;
                                $pNo++;
                                $row_num = $pNo;
                                $class_tr = 'td_jns_tindakan set_font';
                            } else if(isset($rt['nama_tagihan'])){
                                $tagihan = $rt['nama_tagihan'];
                                $biaya = formatCurrency($rt['biaya']);
                                $tanggal_input = formatDate($rt['created_date']);
                                $chNo++;
                                $row_num = $pNo.'.'.$chNo;
                                $class_tr = 'td_tagihan set_font';
                            }
                        ?>
                            <tr>
                                <td class="<?=$class_tr?>" style="text-align:center; vertical-align: top;"><?=$row_num?></td>
                                <td class="<?=$class_tr?>"><?=$tagihan?></td>
                                <td class="<?=$class_tr?>" style="text-align:center; vertical-align: top;"><?=$biaya?></td>
                                <td class="<?=$class_tr?>" style="text-align:center; vertical-align: top;"><?=$tanggal_input?></td>
                            </tr>
                        <?php } } ?>
                    </tbody>
                </table>
            </div>
        <?php } ?>
    </body>
</html>
