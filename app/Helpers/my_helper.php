<?php

function nomor($currentPage, $perPage)
{
    if (is_null($currentPage)) {
        $nomor = 1;
    } else {
        $nomor = 1 + ($perPage * ($currentPage - 1));
    }
    return $nomor;
}

function halaman($halaman) {
    switch ($halaman) {
        case 'daftarBarang':
            echo 'Daftar Barang';
            break;
        case 'daftarBarangDipinjam':
            echo 'Daftar Barang Dipinjam';
            break;
        case 'daftarBarangDiambil':
            echo 'Daftar Barang Diambil';
            break;
        case 'users':
            echo 'Daftar Pengguna';
            break;
        default:
            echo 'Dashboard';
            break;
    }
}

function tglIndo($tanggal)
{
    $t = explode('-',$tanggal);
    $tahun = $t[0];
    $bulan = $t[1];
    $tgl = $t[2];

    return $tgl.' - '.$bulan.' - '.$tahun;
}
