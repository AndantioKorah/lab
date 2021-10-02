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
       
            <?php
         
                $dokter_pengirim = $pendaftaran['nama_dokter_pengirim'];
                if($dokter_pengirim == null){
                    $dokter_pengirim = "Atas Permintaan Sendiri";
                }

               
                $diskon = formatCurrency($pembayaran['diskon_nominal']);
                if($pembayaran['diskon_presentase'] && $pembayaran['diskon_presentase'] > 0){
                    $diskon = '('.$pembayaran['diskon_presentase'].'%) '.$diskon;
                }
            ?>
            <center>
        <table style="width:100%" border="1">
        <td  style="width:50%"><span>Lab. Klinik PATRA<span><br><span style="font-size:10px;">Kompleks Wanea Plaza<span><br>
        <span style="font-size:10px;">JL. Sam Ratulangi Blok A No.3<span><br>
        <span style="font-size:10px;">Telp./Fax (0431)863113,Manado<span><br>
        </td>
        <td><span>KWITANSI</span><br>
        <span style="font-size:10px;">Nomor Pendaftaran : <?=$pembayaran['nomor_pembayaran']?> </span></td>

        </table>
         
        <table style="width:100%; padding-top:30px;" border="1">
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
            <td></td>
            <td></td>
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
                        <td class="parameter_content"><?=strtoupper(terbilang($pembayaran['jumlah_pembayaran']))?></td>
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