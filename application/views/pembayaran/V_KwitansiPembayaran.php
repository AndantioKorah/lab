<html>
    <head>
        <style>
            @page{
                /* size: A4; */
                /* margin-top: 150px; */
            }
            .body_kwitansi_pembayaran{
                font-family: Verdana !important;
                /* width: 100%; */
            }
            .title_kwitansi{
                text-decoration: underline;
                font-weight: bold;
            }
            .title_nomor_pembayaran{
                
            }
            .table_content_kwitansi{
                /* border: 1px solid black; */
                margin-top: 30px;
                width: 100%;
                font-size: 12px; 
            }
            .parameter_content{
                font-weight: bold;
                font-size: 14px;
            }
            .table_content_kwitansi td{
                vertical-align: top;
            }
            .footer_kwitansi{
                font-size: 14px;
            }
        </style>
    </head>
    <body class="body_kwitansi_pembayaran">
            <?php
                $diskon = formatCurrency($pembayaran['diskon_nominal']);
                if($pembayaran['diskon_presentase'] && $pembayaran['diskon_presentase'] > 0){
                    $diskon = '('.$pembayaran['diskon_presentase'].'%) '.$diskon;
                }
            ?>
            <center>
                <span class="title_kwitansi">KWITANSI PEMBAYARAN</span><br>
                <span class="title_nomor_pembayaran"><?=$pembayaran['nomor_pembayaran']?></span>
                <table class="table_content_kwitansi">
                    <tr>
                        <td style="width: 35%; vertical-align: top;">TELAH TERIMA UANG DARI</td>
                        <td style="width: 5%;">:</td>
                        <td class="parameter_content" style="width: 60%;"><?=$pembayaran['nama_pembayar']?></td>
                    </tr>
                    <tr>
                        <td>PADA TANGGAL</td>
                        <td>:</td>
                        <td class="parameter_content"><?=formatDate($pembayaran['tanggal_pembayaran'])?></td>
                    </tr>
                    <tr>
                        <td>UNTUK PEMBAYARAN</td>
                        <td>:</td>
                        <td class="parameter_content">TAGIHAN LAB PATRA</td>
                    </tr>
                    <tr>
                        <td>TOTAL TAGIHAN</td>
                        <td>:</td>
                        <td class="parameter_content"><?=formatCurrency($tagihan['total_tagihan'])?></td>
                    </tr>
                    <tr>
                        <td>DISKON</td>
                        <td>:</td>
                        <td class="parameter_content"><?=$diskon?></td>
                    </tr>
                    <tr>
                        <td>JUMLAH PEMBAYARAN</td>
                        <td>:</td>
                        <td class="parameter_content"><?=formatCurrency($pembayaran['jumlah_pembayaran'])?></td>
                    </tr>
                    <tr>
                        <td>TERBILANG</td>
                        <td>:</td>
                        <td class="parameter_content"><?=terbilang($pembayaran['jumlah_pembayaran'])?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td style="text-align: center; vertical-align: bottom; height: 80px;">
                            <span class="footer_kwitansi">Manado, <?=date('d/m/Y')?></span><br><br><br><br><br>
                            <span class="footer_kwitansi"><u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u></span>
                        </td>
                    </td>
                </table>
            </center>
    </body>
</html>