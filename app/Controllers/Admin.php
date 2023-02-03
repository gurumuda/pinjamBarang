<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelDaftarBarang;
use App\Models\ModelDataPinjamBarang;
use App\Models\ModelDaftarPesanan;
use Picqer;



class Admin extends BaseController
{
    protected $helpers = ['my_helper', 'form'];

    public function index()
    {
        if (!(session()->get('email') && \session()->get('level') == 'adm')) {
            return redirect()->to('login');
        }

        $dataPesanan = new ModelDaftarPesanan();
        $dataBarang = new ModelDaftarBarang();

        $data['pesanan'] = $dataPesanan
            ->select('*, dataBarang.id as idB, daftarPesanan.id as idP, daftarPesanan.keperluan as kepPesanan')
            ->join('dataBarang', 'dataBarang.id = daftarPesanan.idBarang', 'LEFT')
            ->join('pengguna', 'pengguna.id = daftarPesanan.idPemesan', 'LEFT')
            ->where('status', '0')
            ->orderBy('idP', 'DESC')
            ->findAll();

        return view('admin/pages/dashboard', $data);
    }

    public function ubahStatusPesanan()
    {
        # code...
        $id = $this->request->getVar('id');
        $dataPesanan = new ModelDaftarPesanan();
        $data = ['id' => $id, 'status' => '1'];
        $dataPesanan->save($data);
    }

    public function getJenisBarang()
    {
        $idP = $this->request->getVar('idP');
        $dataPesanan = new ModelDaftarPesanan();

        $jenisBarang = $dataPesanan
            ->join('dataBarang', 'dataBarang.id = daftarPesanan.idBarang', 'LEFT')
            ->where('daftarPesanan.id', $idP)
            ->first()->jenisBarang;


        echo $jenisBarang;
    }

    public function getDataPjBr()
    {
        if (!(session()->get('email') && \session()->get('level') == 'adm')) {
            return redirect()->to('login');
        }

        $kodeBarang = $this->request->getVar('kodeBarang');

        $dataBarang = new ModelDaftarBarang();
        $data = $dataBarang->where('kodeBarang', $kodeBarang)->first();

        if ($data) {
            echo (json_encode($data));
        } else {
            echo (json_encode('0'));
        }
    }

    public function prosesPinjamBarangModal()
    {
        if (!(session()->get('email') && \session()->get('level') == 'adm')) {
            return redirect()->to('login');
        }

        $kodeBarang = $this->request->getVar('pjKodeBarang');
        $namaPeminjam = $this->request->getVar('namaPeminjam');
        $jumlahBarang = $this->request->getVar('jumlahBarang');
        $waktu = $this->request->getVar('waktu');
        $keperluan = $this->request->getVar('keperluan');

        $tanggalPinjam = (explode(' ', $waktu))[0];
        $waktuPinjam = (explode(' ', $waktu))[1];

        $dataPinjamBarang = new ModelDataPinjamBarang();

        $data = [
            'kodeBarang' => $kodeBarang,
            'namaPeminjam' => $namaPeminjam,
            'jumlahBarang' => $jumlahBarang,
            'tanggalPinjam' => $tanggalPinjam,
            'waktuPinjam' => $waktuPinjam,
            'keperluan' => $keperluan,
        ];
        $simpan = $dataPinjamBarang->save($data);
        if ($simpan) {
            $dataBarang = new ModelDaftarBarang();
            $upd = $dataBarang->where('kodeBarang', $kodeBarang)->first();
            $data2 = [
                'id' => $upd->id,
                'stokBarang' => $upd->stokBarang - $jumlahBarang,
            ];

            session()->setFlashdata('tipe', 'success');
            session()->setFlashdata('pesan', 'Data berhasil disimpan');
            $dataBarang->save($data2);
        }

        return redirect()->to('admin');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('login');
    }


    public function daftarBarang()
    {
        if (!(session()->get('email') && \session()->get('level') == 'adm')) {
            return redirect()->to('login');
        }

        $search = $this->request->getPost('search');

        $dataBarang = new ModelDaftarBarang();

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
            'nomor' => nomor($this->request->getVar('page_dataBarang'), 6)
        ];

        return view('admin/pages/daftarBarang', $data);
    }

    public function tambahBarang()
    {
        $kodeBarang = $this->request->getVar('kodeBarang');
        $namaBarang = $this->request->getVar('namaBarang');
        $jenisBarang = $this->request->getVar('jenisBarang');
        $stokBarang = $this->request->getVar('stokBarang');
        $satuan = $this->request->getVar('satuan');

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
                'satuan' => $satuan
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
        $satuan = $this->request->getVar('ubahSatuan');

        $data = [
            'id' => $id,
            'kodeBarang' => $kodeBarang,
            'namaBarang' => $namaBarang,
            'jenisBarang' => $jenisBarang,
            'stokBarang' => $stokBarang,
            'satuan' => $satuan,
        ];

        $dataBarang = new ModelDaftarBarang();

        $dataBarang->save($data);
        session()->setFlashdata('tipe', 'success');
        session()->setFlashdata('pesan', 'Data berhasil diubah');
        return redirect()->to('admin/daftarBarang');
    }

    public function generateBarcode()
    {
        helper('text');
        helper('filesystem');
        $id = $this->request->getVar('id');
        $dataBarang = new ModelDaftarBarang();
        $barang = $dataBarang
            ->where('id', $id)
            ->first();

        $file = file_exists('./barcode/' . $barang->fileBarcode);

        $fileBarcode = random_string('alpha', 20);

        $generator = new Picqer\Barcode\BarcodeGeneratorPNG();


        if (!$file || $barang->fileBarcode == '') {

            $prosesGenerate = write_file('./barcode/' . $fileBarcode . '.png', $generator->getBarcode($barang->kodeBarang, $generator::TYPE_CODE_128, 3, 50));

            $data = [
                'id' => $id,
                'fileBarcode' => $fileBarcode . '.png'
            ];

            $dataBarang->save($data);
        }
        $barang2 = $dataBarang
            ->where('id', $id)
            ->first();
        echo json_encode($barang2);
    }

    public function printBarcode()
    {
        $id = $this->request->getVar('idBarcode');
        $data['jumlah'] = $jumlah = $this->request->getVar('jumlah');
        if ($jumlah == '' || $jumlah <= 0) {
            $jumlah = 1;
        }
        $data['jumlah'] = $jumlah;

        $dataBarang = new ModelDaftarBarang();
        $data['barang'] = $dataBarang->where('id', $id)->first();
        return view('admin/pages/printBarcode', $data);
    }
}
