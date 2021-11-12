<?php
$route['users'] = 'user/C_User/users';
$route['user/setting'] = 'user/C_User/userSetting';
$route['roles'] = 'user/C_User/roles';
$route['menu'] = 'user/C_User/menu';
$route['pelayanan'] = 'pelayanan/C_Pelayanan/inputTindakan';
$route['pendaftaran'] = 'pendaftaran/C_Pendaftaran/pendaftaran';
$route['pasien/(:any)'] = 'pendaftaran/C_Pendaftaran/dataPasien/$1';
$route['pemeriksaan'] = 'master/C_Master/jenisPemeriksaan';
$route['tindakan'] = 'master/C_Master/tindakan';
$route['dokter'] = 'master/C_Master/masterDokter';
$route['master/carabayar'] = 'master/C_Master/masterCaraBayar';
$route['maintenance/database/backup'] = 'maintenance/C_Maintenance/indexBackupDatabase';
$route['preview/file/(:any)'] = 'maintenance/C_Maintenance/previewFile/$1';
$route['tindakan/nilai-normal'] = 'master/C_Master/nilaiNormal';
$route['pendaftaran/list'] = 'pendaftaran/C_Pendaftaran/menuListPendaftaran';