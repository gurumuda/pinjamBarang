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

        $data = [
            'barang' => $dataBarang->paginate(5, 'dataBarang'),
            'pager' => $dataBarang->pager,
        ];


        // $data['barang'] = $dataBarang->findAll();

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

    public function getDataBarang()
    {
        $id = $this->request->getVar('id');

        $dataBarang = new ModelDaftarBarang();

        $barang = $dataBarang
            ->where('id', $id)
            ->first();

        echo json_encode($barang);
    }

    public function ubahDataBarang()
    {
        $id = $this->request->getVar('idUbahBarang');
        $kodeBarang = $this->request->getVar('ubahKodeBarang');
        $namaBarang = $this->request->getVar('ubahNamaBarang');
        $jenisBarang = $this->request->getVar('ubahJenisBarang');
        $stokBarang = $this->request->getVar('ubahStokBarang');

        $data = [
            'id' => $id,
            'kodeBarang' => $kodeBarang,
            'namaBarang' => $namaBarang,
            'jenisBarang' => $jenisBarang,
            'stokBarang' => $stokBarang,
        ];

        $dataBarang = new ModelDaftarBarang();

        $dataBarang->save($data);
        session()->setFlashdata('tipe', 'success');
        session()->setFlashdata('pesan', 'Data berhasil diubah');
        return redirect()->to('admin/daftarBarang');
    }
}
