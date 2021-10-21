<html>
<head>
<style>
    @page{
        size: A4;
        margin-top: 150px;
    }
    .header_cetakan{
        width: 50%;
        font-weight: normal;
        text-align: left;
    }
    .header_penanggung_jawab{
        font-style: italic;
        text-decoration: underline;
        font-weight: bold;
        font-size: 10px;
        text-align: left;
    }
    .header_content{
        text-align: left;
        font-size: 12px;
    }
    .header_label{
        vertical-align: top;
        font-size: 12px;
    }
    
</style>
</head>
<body id="body_cetakan">
<table style="width: 100%; font-family: <?=FONT_CETAKAN?>" class="table_header">
    <thead>
        <th class="header_cetakan">
            <?php
                $dokter_pengirim = $pendaftaran['nama_dokter_pengirim'];
                if(!$pendaftaran['id_m_dokter_pengirim']){
                    $dokter_pengirim = 'Atas Permintaan Sendiri';
                }
            ?>
            <table>
                <tr style="height: 30px;">
                    <td colspan="3">
                    </td>
                </tr>
                <tr>
                    <td colspan="3">
                        <span class="header_content"><i><b>Dokter</b></i></span>
                    </td>
                </tr>
                <tr>
                    <td style="width: 35%;" class="header_label">Nama</td>
                    <td style="width: 5%;" class="header_label">:</td>
                    <td style="width: 60%;" class="header_content"><?=strtoupper($dokter_pengirim)?></td>
                </tr>
                <tr>
                    <td style="width: 35%;" class="header_label">Alamat</td>
                    <td style="width: 5%;" class="header_label">:</td>
                    <td style="width: 60%;" class="header_content"><?=strtoupper($pendaftaran['alamat_dokter_pengirim'])?></td>
                </tr>
                <tr>
                    <td style="width: 35%;" class="header_label">No. Telp</td>
                    <td style="width: 5%;" class="header_label">:</td>
                    <td style="width: 60%;" class="header_content"><?=strtoupper($pendaftaran['nomor_telepon_dokter_pengirim'])?></td>
                </tr>
                <tr>
                    <td style="width: 35%;" class="header_label">Tanggal</td>
                    <td style="width: 5%;" class="header_label">:</td>
                    <td style="width: 60%;" class="header_content"><?=strtoupper(formatDateNamaBulan($pendaftaran['tanggal_pendaftaran']))?></td>
                </tr>
                <tr>
                    <td style="width: 35%;" class="header_label">Halaman</td>
                    <td style="width: 5%;" class="header_label">:</td>
                    <td style="width: 60%;" class="header_content"><span class="page_number"></span></td>
                </tr>
            </table>
        </th>        
        <th class="header_cetakan">
            <table>
                <tr style="height: 30px;">
                    <td colspan="3">
                        <span class="header_penanggung_jawab" style="margin-left: -50px;">Penanggung Jawab Laboratorium : <?=$pendaftaran['nama_dokter_dpjp']?></span>
                    </td>
                </tr>
                <tr>
                    <td colspan="3">
                        <span class="header_content"><i><b>Pasien</b></i></span>
                    </td>
                </tr>
                <tr>
                    <td style="width: 35%;" class="header_label">Nama</td>
                    <td style="width: 5%;" class="header_label">:</td>
                    <td style="width: 60%;" class="header_content"><?=$pendaftaran['nama_pasien']?></td>
                </tr>
                <tr>
                    <td style="width: 35%;" class="header_label">Alamat</td>
                    <td style="width: 5%;" class="header_label">:</td>
                    <td style="width: 60%;" class="header_content"><?=$pendaftaran['alamat']?></td>
                </tr>
                <tr>
                    <td style="width: 35%;" class="header_label">No. Telp</td>
                    <td style="width: 5%;" class="header_label">:</td>
                    <td style="width: 60%;" class="header_content"><?=$pendaftaran['nomor_telepon']?></td>
                </tr>
                <tr>
                    <td style="width: 35%;" class="header_label">Umur/Kel.</td>
                    <td style="width: 5%;" class="header_label">:</td>
                    <?php
                        $umur = countDiffDateLengkap($pendaftaran['tanggal_lahir'], date('Y-m-d'), ['tahun']);
                        $jenis_kelamin = $pendaftaran['jenis_kelamin'] == 1 ? 'Laki-laki' : 'Perempuan';
                    ?>
                    <td style="width: 60%;" class="header_content"><?=strtoupper($umur.' / '.$jenis_kelamin)?></td>
                </tr>
                <tr>
                    <td style="width: 35%;" class="header_label">No. Lab</td>
                    <td style="width: 5%;" class="header_label">:</td>
                    <td style="width: 60%;" class="header_content"><?=$pendaftaran['nomor_pendaftaran']?></td>
                </tr>
            </table>
        </th>
    </thead>
    <tbody>
        <tr>
            <td colspan=2>
                <?php
                    // $data['rincian_tagihan'] = $rincian_tagihan;
                    $this->load->view($page, $data);
                ?>
            </td>
        </tr>
    </tbody>
</table>
</body>
</html>
<span id="content"></span>
<script>
    
</script>