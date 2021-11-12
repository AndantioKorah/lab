<html>
    <head>
        <style>
            @page{
                /* size: A4; */
                /* margin-top: 150px; */
                height: 13.97cm;
                width: 21.00cm;
            }
            .body_kwitansi_pembayaran{
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
                margin-top: 30px;
                width: 100%;
                font-size: 12px; 
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
           
            <center>
            <?php 
               foreach($rincian_tagihan as $tindakan){ 
                $detail_tindakan[] = $tindakan['nm_jns_tindakan'];
            }

            $untuk_pembayaran  =json_encode($detail_tindakan);
            $untuk_pembayaran = str_replace( array( '\'', '"' , ';', '[', ']' ), ' ', $untuk_pembayaran);
           
          
            ?>
               
                <table class="table_content_kwitansi" border="0">
                <tr>
                <td style="width:40%"><span>Lab. Klinik PATRA<span><br><span style="font-size:14px;">Kompleks Wanea Plaza<span><br>
        <span style="font-size:14px;">JL. Sam Ratulangi Blok A No.3<span><br>
        <span style="font-size:14px;">Telp./Fax (0431)863113,Manado<span><br>
        </td>
        <td></td>
        <td valign="top"> 
     
        <span>KWITANSI UANG MUKA</span><br>
        <span style="font-size:14px;">Nomor Pembayaran : <?=$uang_muka['nomor_pembayaran']?></span>
       
        </td>
                </tr>
                <tr height="30px">
                <td ></td>
                <td></td>
                <td></td>
                </tr>
                    <tr>
                        <td style="width: 35%; vertical-align: top;">TELAH TERIMA UANG DARI</td>
                        <td style="width: 5%;">:</td>
                        <td class="parameter_content" style="width: 60%;"><?=$uang_muka['nama_pembayar']?></td>
                    </tr>
                    <tr>
                        <td>UANG SEJUMLAH</td>
                        <td>:</td>
                        <td class="parameter_content"><?=strtoupper(terbilang($uang_muka['jumlah_pembayaran']))?></td>
                    </tr>
                    <tr>
                        <td>UNTUK PEMBAYARAN</td>
                        <td>:</td>
                        <td class="parameter_content"><?= $untuk_pembayaran;?></td>
                    </tr>
                    <tr>
                        <td>TOTAL TAGIHAN</td>
                        <td>:</td>
                        <td class="parameter_content"><?=formatCurrency($tagihan['total_tagihan'])?></td>
                    </tr>
  
                    <tr>
                        <td></td>
                        <td></td>
                        <td style="text-align: center; vertical-align: bottom;">
                        <br><br><br>
                            <span class="footer_kwitansi">Manado, <?=date('d/m/Y')?></span><br><br><br><br><br>
                            <span class="footer_kwitansi"><u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u></span>
                        </td>
                    </td>
                </table>
            </center>
            <table border="1">
                    <td style="padding: 15px; font-size: 18px; font-family: Verdana;">Jumlah : <?=formatCurrency($uang_muka['jumlah_pembayaran'])?></td>
            </table>
    </body>
</html>