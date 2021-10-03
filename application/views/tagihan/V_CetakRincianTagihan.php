<html>
    <head>
        <style>
            .rt_content_cetakan{
                font-size: 12px;
                vertical-align: top;
                font-family: Verdana;
            }

            .th_cetakan_rincian_tagihan{
                font-size: 12px;
                font-weight: normal;
                border-top: 1px solid black;
                border-bottom: 1px solid black;
                padding: 3px;
                font-family: Verdana;
            }

            .td_jns_tindakan{
                padding: 3px;
                font-size: 12px;
                border-right: 1px solid black;
            }

            .td_tagihan{
                padding: 3px;
                font-size: 12px;
                border-right: 1px solid black;
                padding-left: 15px;
            }

            .table_perincian{
                font-size: 12px;
            }

            .td_tagihan_biaya{
                font-family: Verdana;
                padding: 3px;
                font-size: 12px;
                padding-right: 20px;
                border-right: 1px solid black;
            }

            .set_font{
                font-family: Verdana;
            }

            .td_perincian{
                font-size: 12px;
            }

            .text_footer{
                font-size: 10px;
                font-family: Verdana;
            }
        </style>
    </head>
    <body style="font-family: <?=FONT_CETAKAN?>">
    <table style="width:100%" border="0">
        <td style="width:62%"><span class="set_font">Lab. Klinik PATRA</span><br><span class="set_font" style="font-size:14px;">Kompleks Wanea Plaza</span><br>
        <span class="set_font" style="font-size:14px;">JL. Sam Ratulangi Blok A No.3</span><br>
        <span class="set_font" style="font-size:14px;">Telp./Fax (0431)863113,Manado</span><br>
        </td>
        <td valign="top"align=><span class="set_font">NOTA PENGAMBILAN HASIL</span><br>
        <span class="set_font" style="font-size:14px;">Nomor : </span></td>
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
                        <td class="rt_content_cetakan" style="width: 75%;"><?=countDiffDateLengkap($pendaftaran['tanggal_lahir'], date('Y-m-d'), ['tahun'])?></td>
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
            <?php $i = 0; foreach($rincian_tagihan as $rt){
                $tagihan = '';
                $biaya = null;
                $class_tr = '';
                if(isset($rt['nm_jns_tindakan'])){
                    $tagihan = strtoupper($rt['nm_jns_tindakan']);
                    $class_tr = 'td_jns_tindakan set_font';
                } else if(isset($rt['nama_tagihan'])){
                    $tagihan = $rt['nama_tagihan'];
                    $biaya = formatCurrencyWithoutRp($rt['biaya']);
                    $class_tr = 'td_tagihan set_font';
                }
            ?>
                <tr>
                    <td style="width: 35%; vertical-align: top;" class="<?=$class_tr?>"><?=$tagihan?></td>
                    <td style="width: 15%; vertical-align: top; text-align: right;" class="td_tagihan_biaya"><?=$biaya?></td>
                    <?php if($i == 0){ ?>
                        <td style="width: 50%;" rowspan=<?=count($rincian_tagihan)?>>
                            <table class="table_perincian" style="width: 80%; margin-left: 10px;">
                                <tr>
                                    <td class="set_font td_perincian" style="width: 30%">Total Biaya</td>
                                    <td class="set_font td_perincian" style="width: 5%">:</td>
                                    <td class="set_font td_perincian" style="width: 15%">Rp.</td>
                                    <td class="set_font td_perincian" style="width: 50%; text-align: right"><?=formatCurrencyWithoutRp($data_tagihan['total_tagihan'])?></td>
                                </tr>
                                <?php
                                    $jumlah_pembayaran = 0;
                                    $cara_bayar = '-';
                                    if($pembayaran){
                                        $jumlah_pembayaran = $pembayaran['jumlah_pembayaran'];
                                        $cara_bayar = strtoupper($pembayaran['cara_pembayaran']);
                                    }
                                    if($uang_muka){
                                        $jumlah_pembayaran += $jumlah_pembayaran;
                                    }
                                ?>
                                <tr>
                                    <td class="set_font td_perincian" style="width: 40%">Jumlah Bayar</td>
                                    <td class="set_font td_perincian" style="width: 5%">:</td>
                                    <td class="set_font td_perincian" style="width: 5%">Rp.</td>
                                    <td class="set_font td_perincian" style="width: 50%; text-align: right"><?=formatCurrencyWithoutRp($jumlah_pembayaran)?></td>
                                </tr>
                                <tr>
                                    <td class="set_font td_perincian" style="width: 40%"></td>
                                    <td class="set_font td_perincian" style="width: 5%"></td>
                                    <td class="set_font td_perincian" colspan=2 style="width: 55%; border-bottom-style: dashed;"></td>
                                </tr>
                                <tr>
                                    <td class="set_font td_perincian" style="width: 40%">Sisa</td>
                                    <td class="set_font td_perincian" style="width: 5%">:</td>
                                    <td class="set_font td_perincian" style="width: 5%">Rp.</td>
                                    <td class="set_font td_perincian" style="width: 50%; text-align: right"><?=formatCurrencyWithoutRp($sisa_harus_bayar)?></td>
                                </tr>
                                <tr style="line-height: 4;">
                                    <td class="set_font td_perincian" style="width: 40%;">Pembayaran</td>
                                    <td class="set_font td_perincian" style="width: 5%">:</td>
                                    <td class="set_font td_perincian" colspan=2 style="width: 55%;"><?=$cara_bayar?></td>
                                </tr>
                                <tr>
                                    <td class="set_font td_perincian" colspan=4 style="width: 100%; text-align: center;">Pembayaran ini sah apabila dibubuhi tanda tangan dan stempel kasir</td>
                                </tr>
                            </table>
                        </td>
                    <?php } ?>
                </tr>
            <?php $i++; } ?>
        </tbody>
    </table>
    <center>
        <span class="text_footer">
            HARAP DIBAWA SAAT MENGAMBIL HASIL <br>
            TERIMA KASIH
        </span>
    </center>
    </body>
</html>