<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelDaftarBarang;

class Admin extends BaseController
{
    public function index()
    {
        if (!(session()->get('email'))) {
            return redirect()->to('login');
        }

        return view('admin/pages/dashboard');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('login');
    }

    public function daftarBarang()
    {
        if (!(session()->get('email'))) {
            return redirect()->to('login');
        }

        $dataBarang = new ModelDaftarBarang();
        $data['barang'] = $dataBarang->findAll();

        return view('admin/pages/daftarBarang', $data);
    }

    public function tambahBarang()
    {
        $kodeBarang = $this->request->getVar('kodeBarang');
        $namaBarang = $this->request->getVar('namaBarang');
        $jenisBarang = $this->request->getVar('jenisBarang');
        $stokBarang = $this->request->getVar('stokBarang');

        $dataBarang = new ModelDaftarBarang();

        if ($dataBarang->where('kodeBarang', $kodeBarang)->first()) {
            # code...
            echo "2";
            return false;
        }

        $data = [
            'kodeBarang' => $kodeBarang,
            'namaBarang' => $namaBarang,
            'jenisBarang' => $jenisBarang,
            'stokBarang' => $stokBarang,
        ];

        $simpan = $dataBarang->save($data);

        if ($simpan) {
            echo "1";
        } else {
            echo "0";
        }
    }

    public function hapusBarang()
    {
        $id = $this->request->getVar("id");
        $dataBarang = new ModelDaftarBarang();
        $dataBarang->delete($id);
    }
}
