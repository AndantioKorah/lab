<html>
    <head>
        <style>
            @page{
                /* size: A4; */
                /* margin-top: 150px; */
            }
            .body_kwitansi_pembayaran span{
                font-family: Verdana !important;
                /* width: 100%; */
            }
            .title_kwitansi{
                font-family: Verdana !important;
                text-decoration: underline;
                font-weight: bold;
            }
            .title_nomor_pembayaran{
                font-family: Verdana !important;
            }
            .table_content_kwitansi{
                font-family: Verdana !important;
                /* border: 1px solid black; */
                width: 100%;
                /* font-size: 12px;  */
            }
            .parameter_content{
                font-family: Verdana !important;
                font-weight: bold;
                font-size: 14px;
            }
            .table_content_kwitansi td{
                font-family: Verdana !important;
                vertical-align: top;
            }
            .footer_kwitansi{
                font-family: Verdana !important;
                font-size: 14px;
            }
        </style>
    </head>
    <body class="body_kwitansi_pembayaran">
            <?php
                $dokter_pengirim = $pendaftaran['nama_dokter_pengirim'];
                if($dokter_pengirim == null){
                    $dokter_pengirim = "Atas Permintaan Sendiri";
                } 

                foreach($rincian_tagihan as $tindakan){ 
                    $detail_tindakan[] = $tindakan['nm_jns_tindakan'];
                }

                $untuk_pembayaran  =json_encode($detail_tindakan);
                $untuk_pembayaran = str_replace( array( '\'', '"' , ';', '[', ']' ), ' ', $untuk_pembayaran);
               
              
                $diskon = formatCurrency($pembayaran['diskon_nominal']);
                if($pembayaran['diskon_presentase'] && $pembayaran['diskon_presentase'] > 0){
                    $diskon = '('.$pembayaran['diskon_presentase'].'%) '.$diskon;
                }
            ?>
            <center>
        <table style="width:100%" border="0">
        <td style="width:62%"><span>Lab. Klinik PATRA<span><br><span style="font-size:14px;">Kompleks Wanea Plaza<span><br>
        <span style="font-size:14px;">JL. Sam Ratulangi Blok A No.3<span><br>
        <span style="font-size:14px;">Telp./Fax (0431)863113,Manado<span><br>
        </td>
        <td valign="top"align=><span>KWITANSI</span><br>
        <span style="font-size:14px;">Nomor Lab : <?=$pembayaran['nomor_pembayaran']?> </span></td>

        </table>
         
        <table style="width:100%; padding-top:30px;" border="0" class="table_content_kwitansi">
            <tr>
                <td style="width:25%;">Terima dari </td>
                <td  style="width:2%;">:</td>
                <td><?=$pembayaran['nama_pembayar']?></td>
            </tr>
            <tr>
            <td>Uang sejumlah</td>
            <td>:</td>
            <td><i><?=strtoupper(terbilang($pembayaran['jumlah_pembayaran']))?></i></td>   
            </tr>
            <tr>
            <td>Untuk pembayaran</td>
            <td>:</td>
            <td><?=$untuk_pembayaran;?></td>
            </tr>
            <tr>
            <td>Nama Pasien</td>
            <td>:</td>
            <td><?=$pembayaran['nama_pembayar']?></td>
            </tr>
            <tr>
            <td>Nama Dokter</td>
            <td>:</td>
            <td><?=$dokter_pengirim?></td>
            </tr>
        </table>
    
     <table style="width:100%;" border="0">
                    
                    <tr>
                        <td></td>
                        <td style="width:40%;"></td>
                        <td style="text-align: center; vertical-align: bottom;">
                        <br><br><br>
                            <span class="footer_kwitansi">Manado,  <?= $date = date('d/m/Y'); ?></span><br><br><br><br><br>
                            <span class="footer_kwitansi"><u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u></span>
                        </td>
                    </td>
                </table>

               
            </center>
            <table border="1">
                    <td style="padding: 15px; font-size: 18px; font-family: Verdana;">Jumlah : <?=formatCurrency($pembayaran['jumlah_pembayaran'])?></td>
                </table>
    </body>
</html>