<html>
    <head>
        <style>
            @media print{
                .pagebreak{
                    page-break-after: always;
                }

                body{
                    height: 13.57cm;
                    width: 21.00cm;
                }
            }

            .pagebreak{
                /* height: 50%; */
            }

            .rt_content_cetakan{
                font-size: 12px;
                vertical-align: top;
                font-family: Verdana;
                /* line-height: 8pt; */
            }

            .th_cetakan_rincian_tagihan{
                font-size: 12px;
                font-weight: normal;
                border-top: 1px solid black;
                border-bottom: 1px solid black;
                padding: 3px;
                font-family: Verdana;
                /* line-height: 8pt; */
            }

            .td_jns_tindakan{
                /* line-height: 10pt; */
                padding: 3px;
                font-size: 12px;
                border-right: 1px solid black;
            }

            .td_tagihan{
                /* line-height: 10pt; */
                padding: 3px;
                font-size: 12px;
                border-right: 1px solid black;
                /* padding-left: 15px; */
            }

            .table_perincian{
                font-family: Verdana;
            }

            .td_tagihan_biaya{
                /* line-height: 10pt; */
                font-family: Verdana;
                padding: 3px;
                font-size: 12px;
                padding-right: 20px;
                padding-left: 20px;
                border-right: 1px solid black;
            }

            .set_font{
                font-family: Verdana;
                font-size: 10px !important;
                line-height: 5pt !important;
            }

            .set_font_header{
                font-family: Verdana;
            }

            .set_font_perincian{
                font-family: Verdana;
                
                /* line-height: 7pt; */
            }

            set_font_perincian_footer{
                font-family: Verdana;
                /* line-height: 7pt; */
            }

            .td_perincian{
                vertical-align: top;
                font-size: 12px;
            }

            .text_footer{
                font-size: 8px;
                font-family: Verdana;
            }

            .smaller_font{
                font-size: 9px !important;
                /* line-height: 2pt !important; */
            }

            .first_row{
                padding-top: 5px;
            }

            .last_row{
                padding-bottom: 5px;
            }

            .not_first_page{
                padding-top: 10px;
            }
        </style>
    </head>
    <body style="font-family: <?=FONT_CETAKAN?>">
        <?php for($p = 1; $p <= $page_count; $p++){
        $isPageEven = 0;
        $isNotFirstPage = $p != 1 ? 1 : 0 ;
        if(fmod($p, 2) == 0){
            $isPageEven = 1;
        }
        ?>
        <div class="pagebreak <?=$isPageEven ? 'page_even' : 'page_odd' ?> <?=$isNotFirstPage ? 'not_first_page' : '' ?>">
            <table style="width:100%" border="0">
                <td style="width:62%"><span class="set_font_header">Lab. Klinik PATRA</span><br><span class="set_font_header" style="font-size:14px;">Kompleks Wanea Plaza</span><br>
                <span class="set_font_header" style="font-size:14px;">JL. Sam Ratulangi Blok A No.3</span><br>
                <span class="set_font_header" style="font-size:14px;">Telp./Fax (0431)863113,Manado</span><br>
                </td>
                <td valign="top"align=><span class="set_font_header">NOTA PENGAMBILAN HASIL</span><br>
                <span class="set_font_header" style="font-size:14px;">Nomor : </span></td>
            </table>
            <table style="width: 100%; margin-top: 20px;">
                <tr>
                    <td style="width: 33%;">
                        <table style="width: 100%;">
                            <tr>
                                <td class="rt_content_cetakan" style="width: 20%;">Nama</td>
                                <td class="rt_content_cetakan" style="width: 5%;">:</td>
                                <td class="rt_content_cetakan" style="width: 75%;"><?=$pendaftaran['nama_pasien']?></td>
                            </tr>
                            <tr>
                                <td class="rt_content_cetakan" style="width: 20%;">Alamat</td>
                                <td class="rt_content_cetakan" style="width: 5%;">:</td>
                                <td class="rt_content_cetakan" style="width: 75%;"><?=$pendaftaran['alamat']?></td>
                            </tr>
                            <tr>
                                <td class="rt_content_cetakan" style="width: 20%;">Halaman</td>
                                <td class="rt_content_cetakan" style="width: 5%;">:</td>
                                <td class="rt_content_cetakan" style="width: 75%;"><?=$p." / ".$page_count?></td>
                            </tr>
                        </table>
                    </td>
                    <td style="width: 25%;">
                        <table style="width: 100%;">
                            <tr>
                                <td class="rt_content_cetakan" style="width: 20%;">No. Lab</td>
                                <td class="rt_content_cetakan" style="width: 5%;">:</td>
                                <td class="rt_content_cetakan" style="width: 75%;"><?=$pendaftaran['nomor_pendaftaran']?></td>
                            </tr>
                            <tr>
                                <td class="rt_content_cetakan" style="width: 20%;">Umur</td>
                                <td class="rt_content_cetakan" style="width: 5%;">:</td>
                                <td class="rt_content_cetakan" style="width: 75%;"><?=countDiffDateLengkap($pendaftaran['tanggal_lahir'], $pendaftaran['tanggal_pendaftaran'], ['tahun'])?></td>
                            </tr>
                            <tr>
                                <td class="rt_content_cetakan" style="width: 20%;">Kelamin</td>
                                <td class="rt_content_cetakan" style="width: 5%;">:</td>
                                <td class="rt_content_cetakan" style="width: 75%;"><?=$pendaftaran['jenis_kelamin'] == 1 ? 'Laki-laki' : 'Perempuan';?></td>
                            </tr>
                        </table>
                    </td>
                    <?php
                        $dokter_pengirim = $pendaftaran['nama_dokter_pengirim'];
                        if(!$pendaftaran['id_m_dokter_pengirim']){
                            $dokter_pengirim = 'Atas Permintaan Sendiri';
                        }
                    ?>
                    <td style="width: 42%;">
                        <table style="width: 100%;">
                            <tr>
                                <td class="rt_content_cetakan" style="width: 40%;">Dokter</td>
                                <td class="rt_content_cetakan" style="width: 5%;">:</td>
                                <td class="rt_content_cetakan" style="width: 55%;"><?=$dokter_pengirim?></td>
                            </tr>
                            <tr>
                                <td class="rt_content_cetakan" style="width: 40%;">No. Rek. Med.</td>
                                <td class="rt_content_cetakan" style="width: 5%;">:</td>
                                <td class="rt_content_cetakan" style="width: 55%;"><?=$pendaftaran['norm']?></td>
                            </tr>
                            <tr>
                                <td class="rt_content_cetakan" style="width: 40%;">Tgl. Periksa</td>
                                <td class="rt_content_cetakan" style="width: 5%;">:</td>
                                <td class="rt_content_cetakan" style="width: 55%;"><?=formatDateNamaBulan($pendaftaran['tanggal_pendaftaran'])?></td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            <table style="width: 100%; border-collapse: collapse; border-bottom: 1px solid black; margin-bottom: 15px;" border=0>
                <thead>
                    <th class="th_cetakan_rincian_tagihan" style="border-right: 1px solid black;">KETERANGAN</th>
                    <th class="th_cetakan_rincian_tagihan" style="border-right: 1px solid black;">BIAYA</th>
                    <th class="th_cetakan_rincian_tagihan" style="border-left: 1px solid black;">PERINCIAN</th>
                </thead>
                <tbody>
                    <?php $i = 0; if($rincian_tagihan[$p]) { foreach($rincian_tagihan[$p] as $rt){
                        $nama_tindakan = isset($rt['nama_tindakan']) ? $rt['nama_tindakan'] : $rt['nama_tagihan'];
                        $biaya = '';

                        $class_tr = '';
                        $smaller_font = 'set_font';
                        $class_row = '';
                        if($i == 0){
                            $class_row = 'first_row';
                        } else if($i == (count($rincian_tagihan[$p])-1)){
                            $class_row = 'last_row';
                        }
                        
                        if(isset($rt['nama_tindakan'])){
                            $nama_tindakan = strtoupper($rt['nama_tindakan']);
                            $class_tr = 'td_jns_tindakan set_font';
                        } else if(isset($rt['nama_tagihan'])){
                            $nama_tindakan = $rt['nama_tagihan'];
                            $biaya = formatCurrencyWithoutRp($rt['biaya']);
                            $class_tr = 'td_tagihan set_font';
                        }

                        if($nama_tindakan != '.'){
                            $biaya = isset($rt['biaya']) && $rt['biaya'] ? formatCurrencyWithoutRp($rt['biaya']) : '';
                        } else {
                            $nama_tindakan = "&nbsp;";
                        }
                    ?>
                        <tr>
                            <td style="width: 35%; vertical-align: top; padding-left: <?=$rt['padding-left'].'px'?>;" class="<?=$class_tr.' '.$class_row?>"><?=$nama_tindakan?></td>
                            <td style="width: 10%; vertical-align: top; text-align: right;" class="td_tagihan_biaya <?=$smaller_font?>"><?=$biaya?></td>
                            <?php if($i == 0 && $p == $page_count){ ?>
                                <td style="width: 55%;" rowspan=<?=count($rincian_tagihan[$p])?>>
                                    <table class="table_perincian" style="width: 100%; padding-left: 30px; padding-right: 30px;">
                                        <tr>
                                            <td class="set_font_perincian td_perincian" style="width: 30%">Total Biaya</td>
                                            <td class="set_font_perincian td_perincian" style="width: 5%">:</td>
                                            <td class="set_font_perincian td_perincian" style="width: 15%">Rp.</td>
                                            <td class="set_font_perincian td_perincian" style="width: 50%; text-align: right"><?=formatCurrencyWithoutRp($data_tagihan['total_tagihan'])?></td>
                                        </tr>
                                        <?php
                                            $jumlah_pembayaran = 0;
                                            $jumlah_pembayaran_uang_muka = 0;
                                            $cara_bayar = '-';
                                            if($pembayaran){
                                                $jumlah_pembayaran = $pembayaran['jumlah_pembayaran'];
                                                $cara_bayar = strtoupper($pembayaran['cara_pembayaran']);
                                            }
                                            if($uang_muka){
                                                $jumlah_pembayaran_uang_muka += $uang_muka['jumlah_pembayaran'];
                                                $cara_bayar =  $cara_bayar .' / '.strtoupper($uang_muka['cara_pembayaran']);
                                            }
                                        ?>
                                        <tr>
                                            <td class="set_font_perincian td_perincian" style="width: 40%">Pelunasan</td>
                                            <td class="set_font_perincian td_perincian" style="width: 5%">:</td>
                                            <td class="set_font_perincian td_perincian" style="width: 5%">Rp.</td>
                                            <td class="set_font_perincian td_perincian" style="width: 50%; text-align: right"><?=formatCurrencyWithoutRp($jumlah_pembayaran)?></td>
                                        </tr>
                                        <tr>
                                            <td class="set_font_perincian td_perincian" style="width: 40%">Uang Muka</td>
                                            <td class="set_font_perincian td_perincian" style="width: 5%">:</td>
                                            <td class="set_font_perincian td_perincian" style="width: 5%">Rp.</td>
                                            <td class="set_font_perincian td_perincian" style="width: 50%; text-align: right"><?=formatCurrencyWithoutRp($jumlah_pembayaran_uang_muka)?></td>
                                        </tr>
                                        <tr>
                                            <td class="set_font_perincian td_perincian" style="width: 40%"></td>
                                            <td class="set_font_perincian td_perincian" style="width: 5%"></td>
                                            <td class="set_font_perincian td_perincian" colspan=2 style="width: 55%; border-bottom-style: dashed;"></td>
                                        </tr>
                                        <tr>
                                            <td class="set_font_perincian td_perincian" style="width: 40%">Sisa</td>
                                            <td class="set_font_perincian td_perincian" style="width: 5%">:</td>
                                            <td class="set_font_perincian td_perincian" style="width: 5%">Rp.</td>
                                            <td class="set_font_perincian td_perincian" style="width: 50%; text-align: right"><?=formatCurrencyWithoutRp($sisa_harus_bayar)?></td>
                                        </tr>
                                        <tr>
                                            <td class="set_font_perincian td_perincian" style="width: 40%;">Pembayaran</td>
                                            <td class="set_font_perincian td_perincian" style="width: 5%">:</td>
                                            <td class="set_font_perincian td_perincian" colspan=2 style="width: 55%;"><?=$cara_bayar?></td>
                                        </tr>
                                        <tr>
                                            <td class="set_font_perincian_footer td_perincian" colspan=4 style="width: 100%; text-align: center;">Pembayaran ini sah apabila dibubuhi tanda tangan dan stempel kasir</td>
                                        </tr>
                                    </table>
                                </td>
                            <?php } else { ?>
                                <td>
                                </td>
                            <?php } ?>
                        </tr>
                    <?php $i++; } } ?>
                </tbody>
            </table>
            <center>
                <span class="text_footer">
                    HARAP DIBAWA SAAT MENGAMBIL HASIL <br>
                    TERIMA KASIH
                </span>
            </center>
        </div>
        <?php } ?>
    </body>
</html>