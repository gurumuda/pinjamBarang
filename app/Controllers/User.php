<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelPengguna;
use App\Models\ModelDaftarBarang;
use App\Models\ModelDaftarPesanan;

class User extends BaseController
{
    protected $helpers = ['form'];
    public function __construct()
    {
        $this->dataPengguna = new ModelPengguna();
        $this->dataBarang = new ModelDaftarBarang();
        $this->dataPesanan = new ModelDaftarPesanan();
    }

    public function index()
    {
        if (!(session()->get('email') && \session()->get('level') == 'usr')) {
            return redirect()->to('login');
        }

        $data['user'] = $this->dataPengguna->where('email', session()->get('email'))->first();
        $data['barang'] = $this->dataBarang->findAll();
        $data['barangStok'] = $this->dataBarang->where('stokBarang >', 0)->findAll();
        return view('user/pages/dashboard', $data);
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('login');
    }

    public function prosesInden()
    {
        $idBarang = $this->request->getVar('pjIdBarang');
        $jumlahBarang = $this->request->getVar('jumlahBarang');
        $waktu = $this->request->getVar('waktu');
        $keperluan = $this->request->getVar('keperluan');

        $tanggalPakai = (explode(' ', $waktu))[0];
        $waktuPakai = (explode(' ', $waktu))[1];

        $data = [
            'idBarang' => $idBarang,
            'idPemesan' => $this->dataPengguna->where('email', session()->get('email'))->first()->id,
            'jumlahBarang' => $jumlahBarang,
            'tanggalPakai' => $tanggalPakai,
            'waktuPakai' => $waktuPakai,
            'status' => '0',
            'keperluan' => $keperluan
        ];

        $this->dataPesanan->save($data);
        session()->setFlashdata('tipe', 'success');
        session()->setFlashdata('pesan', 'Pesanan berhasil dikirim');
        return redirect()->to('/user/index');
    }
}
