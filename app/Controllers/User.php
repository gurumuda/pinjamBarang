<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelPengguna;
use App\Models\ModelDaftarBarang;

class User extends BaseController
{
    protected $helpers = ['form'];
    public function __construct()
    {
        $this->dataPengguna = new ModelPengguna();
        $this->dataBarang = new ModelDaftarBarang();
    }

    public function index()
    {
        if (!(session()->get('email') && \session()->get('level') == 'usr')) {
            return redirect()->to('login');
        }

        $data['user'] = $this->dataPengguna->where('email', session()->get('email'))->first();
        $data['barang'] = $this->dataBarang->findAll();
        return view('user/pages/dashboard', $data);
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('login');
    }

    public function prosesInden()
    {
        $pjIdBarang = $this->request->getVar('pjIdBarang');
        $jumlahBarang = $this->request->getVar('jumlahBarang');
        $waktu = $this->request->getVar('waktu');
        $keperluan = $this->request->getVar('keperluan');
    }
}
