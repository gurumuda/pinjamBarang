<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelDaftarBarang;
use App\Models\ModelKategori;


class Admin extends BaseController
{
    protected $helpers = ['my_helper', 'form'];

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

        $search = $this->request->getPost('search');

        $dataBarang = new ModelDaftarBarang();
        $dataKategori = new ModelKategori();

        if ($search) { //jika ada pencarian barang
            $barang = $dataBarang
                ->like('namaBarang', $search)
                ->paginate(null, 'dataBarang');
        } else {
            $barang = $dataBarang
                ->paginate(6, 'dataBarang');
        }

        $data = [
            'barang' => $barang,
            'pager' => $dataBarang->pager,
            'nomor' => nomor($this->request->getVar('page_dataBarang'), 6),
            'kategori' => $dataKategori->findAll()
        ];

        return view('admin/pages/daftarBarang', $data);
    }

    public function tambahKategori()
    {
        $namaKategory = $this->request->getVar('namaKategory');

        $dataKategori = new ModelKategori();

        $data = ['kategori' => $namaKategory];

        $dataKategori->save($data);

        echo '1';
    }

    public function tambahBarang()
    {
        $kodeBarang = $this->request->getVar('kodeBarang');
        $namaBarang = $this->request->getVar('namaBarang');
        $jenisBarang = $this->request->getVar('jenisBarang');
        $stokBarang = $this->request->getVar('stokBarang');

        $dataBarang = new ModelDaftarBarang();

        $adaKode = $dataBarang
            ->where('kodeBarang', $kodeBarang)
            ->first();
        if ($adaKode) {
            # code...
            $data = [
                'id' => $adaKode->id,
                'stokBarang' => $adaKode->stokBarang + $stokBarang,
            ];

            $simpan = $dataBarang->save($data);
            echo "2";
            return false;
        } else {
            # code...
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
