<style>
    @page{
        size: A4;
        margin-top: 150px;
    }
    @media print {
        .pagebreak{ 
            page-break-before: always;
        }
        .set_font{
            font-family: "Lucida Console", "Verdana", monospace;
            font-size: 18px !important;
        }
        .set_font_custom{
            font-family: Verdana;
            font-size: 14px !important;
        }
    }
    .header_cetakan_dokter{
        width: 50%;
        vertical-align: top;
    }
    .header_cetakan_pasien{
        width: 50%;
        vertical-align: top;
    }
    .header_penanggung_jawab{
        width: 100%;
        margin-left: 50%;
        margin-bottom: 5px;
        font-style: italic;
        text-decoration: underline;
        font-weight: bold;
        text-align: left;
    }
    .header_content{
        text-align: left;
        font-weight: bold;
        font-style: italic;
    }
    .header_label{
        vertical-align: top;
    }
    .div_header_element{
        width: 100%;
    }
    .header_element_label{
        vertical-align: top !important;
        float: left !important;
        width: 25% !important;
    }
    .header_element_colon{
        vertical-align: top !important;
        float: left !important;
        width: 3% !important;
    }
    .header_element_value{
        vertical-align: top !important;
        float: right !important;
        width: 70% !important;
    }
</style>
<div style="width: 100%;" class="table_header">
    <div class="header_penanggung_jawab set_font_custom">
        <?php
            $dokter_pengirim = $pendaftaran['nama_dokter_pengirim'];
            if(!$pendaftaran['id_m_dokter_pengirim']){
                $dokter_pengirim = 'Atas Permintaan Sendiri';
            }
        ?>
        <span>Penanggung Jawab Laboratorium : <?=$pendaftaran['nama_dokter_dpjp']?></span>
    </div>
    <table style="width: 100%;">
        <thead>
            <th class="header_cetakan_dokter">
                <table style="width: 100%;">
                    <tr>
                        <td><span class="set_font_custom header_content">Dokter</span></td>
                    </tr>
                    <tr>
                        <td class="set_font header_element_label">Nama</td>
                        <td class="set_font header_element_colon">:</td>
                        <td class="set_font header_element_value"><?=strtoupper($dokter_pengirim)?></td>
                    </tr>
                    <tr>
                        <td class="set_font header_element_label">Alamat</td>
                        <td class="set_font header_element_colon">:</td>
                        <td class="set_font header_element_value"><?=strtoupper($pendaftaran['alamat_dokter_pengirim'])?></td>
                    </tr>
                    <tr>
                        <td class="set_font header_element_label">No. Telp</td>
                        <td class="set_font header_element_colon">:</td>
                        <td class="set_font header_element_value"><?=strtoupper($pendaftaran['nomor_telepon_dokter_pengirim'])?></td>
                    </tr>
                    <tr>
                        <td class="set_font header_element_label">Tanggal</td>
                        <td class="set_font header_element_colon">:</td>
                        <td class="set_font header_element_value"><?=strtoupper(formatDateNamaBulan($pendaftaran['tanggal_pendaftaran']))?></td>
                    </tr>
                    <tr>
                        <td class="set_font header_element_label">Halaman</td>
                        <td class="set_font header_element_colon">:</td>
                        <td class="set_font header_element_value"><?=$page_number.' / '.$page_count?></td>
                    </tr>
                </table>
            </th>
            <th class="set_font header_cetakan_pasien">
                <table style="width: 100%;">
                    <tr>
                        <td><span class="set_font_custom header_content">Pasien</span></td>
                    </tr>
                    <tr>
                        <td class="set_font header_element_label">Nama</td>
                        <td class="set_font header_element_colon">:</td>
                        <td class="set_font header_element_value"><?=$pendaftaran['nama_pasien']?></td>
                    </tr>
                    <tr>
                        <td class="set_font header_element_label">Alamat</td>
                        <td class="set_font header_element_colon">:</td>
                        <td class="set_font header_element_value"><?=$pendaftaran['alamat']?></td>
                    </tr>
                    <tr>
                        <td class="set_font header_element_label">No. Telp</td>
                        <td class="set_font header_element_colon">:</td>
                        <td class="set_font header_element_value"><?=$pendaftaran['nomor_telepon']?></td>
                    </tr>
                    <tr>
                        <?php
                            $umur = countDiffDateLengkap($pendaftaran['tanggal_lahir'], date('Y-m-d'), ['tahun']);
                            $jenis_kelamin = $pendaftaran['jenis_kelamin'] == 1 ? 'Laki-laki' : 'Perempuan';
                        ?>
                        <td class="set_font header_element_label">Umur/Kel.</td>
                        <td class="set_font header_element_colon">:</td>
                        <td class="set_font header_element_value"><?=strtoupper($umur.' / '.$jenis_kelamin)?></td>
                    </tr>
                    <tr>
                        <td class="set_font header_element_label">No. Lab</td>
                        <td class="set_font header_element_colon">:</td>
                        <td class="set_font header_element_value"><?=$pendaftaran['nomor_pendaftaran']?></span></td>
                    </tr>
                </table>
            </th>
        </thead>
    </table>
</div>