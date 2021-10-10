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
                <span class="title_kwitansi">KWITANSI UANG MUKA</span><br>
                <span class="title_nomor_pembayaran"><?=$uang_muka['nomor_pembayaran']?></span>
                <table class="table_content_kwitansi">
                    <tr>
                        <td style="width: 35%; vertical-align: top;">TELAH TERIMA UANG DARI</td>
                        <td style="width: 5%;">:</td>
                        <td class="parameter_content" style="width: 60%;"><?=$uang_muka['nama_pembayar']?></td>
                    </tr>
                    <tr>
                        <td>PADA TANGGAL</td>
                        <td>:</td>
                        <td class="parameter_content"><?=formatDate($uang_muka['tanggal_pembayaran'])?></td>
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
                        <td>JUMLAH PEMBAYARAN UANG MUKA</td>
                        <td>:</td>
                        <td class="parameter_content"><?=formatCurrency($uang_muka['jumlah_pembayaran'])?></td>
                    </tr>
                    <tr>
                        <td>TERBILANG</td>
                        <td>:</td>
                        <td class="parameter_content"><?=strtoupper(terbilang($uang_muka['jumlah_pembayaran']))?></td>
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
    </body>
</html>