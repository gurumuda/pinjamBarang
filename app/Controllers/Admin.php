<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelDaftarBarang;
use App\Models\ModelDataPinjamBarang;
use App\Models\ModelDaftarPesanan;
use App\Models\ModelAmbilBarang;
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
        $idP = $this->request->getVar('idp');
        $dataPesanan = new ModelDaftarPesanan();

        $jenis = $dataPesanan
            ->select('*, daftarPesanan.id as idP')
            ->join('pengguna', 'pengguna.id = daftarPesanan.idPemesan')
            ->join('dataBarang', 'dataBarang.id = daftarPesanan.idBarang')
            ->where('daftarPesanan.id', $idP)
            ->first();

        echo json_encode($jenis);
    }

    public function getDataPjBr()
    {
        if (!(session()->get('email') && \session()->get('level') == 'adm')) {
            return redirect()->to('login');
        }

        $kodeBarang = $this->request->getVar('kodeBarang');

        $dataBarang = new ModelDaftarBarang();
        $data = $dataBarang->where('kodeBarang', $kodeBarang)->where('jenisBarang', '1')->first();

        if ($data) {
            echo (json_encode($data));
        } else {
            echo (json_encode('0'));
        }
    }

    public function getDataAmBr()
    {
        if (!(session()->get('email') && \session()->get('level') == 'adm')) {
            return redirect()->to('login');
        }

        $kodeBarang = $this->request->getVar('kodeBarang');

        $dataBarang = new ModelDaftarBarang();
        $data = $dataBarang->where('kodeBarang', $kodeBarang)->where('jenisBarang', '2')->first();

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

        $idBarang = $this->request->getVar('pjIdBarang');
        $kodeBarang = $this->request->getVar('pjKodeBarang');
        $namaPeminjam = $this->request->getVar('namaPeminjam');
        $jumlahBarang = $this->request->getVar('jumlahBarang');
        $waktu = $this->request->getVar('waktu');
        $keperluan = $this->request->getVar('keperluan');
        $idDataPinjaman = $this->request->getVar('pjIdPinjaman');

        $tanggalPinjam = (explode(' ', $waktu))[0];
        $waktuPinjam = (explode(' ', $waktu))[1];

        $dataPinjamBarang = new ModelDataPinjamBarang();

        $data = [
            'idBarang' => $idBarang,
            'kodeBarang' => $kodeBarang,
            'namaPeminjam' => $namaPeminjam,
            'jumlahBarang' => $jumlahBarang,
            'jumlahKembali' => 0,
            'tanggalPinjam' => $tanggalPinjam,
            'waktuPinjam' => $waktuPinjam,
            'keperluan' => $keperluan,
        ];
        $simpan = $dataPinjamBarang->save($data);
        if ($simpan) {
            $dataBarang = new ModelDaftarBarang();
            $upd = $dataBarang->where('id', $idBarang)->first();
            $data2 = [
                'id' => $upd->id,
                'stokBarang' => $upd->stokBarang - $jumlahBarang,
            ];

            session()->setFlashdata('tipe', 'success');
            session()->setFlashdata('pesan', 'Data berhasil disimpan');
            $dataBarang->save($data2);

            if ($idDataPinjaman != '') {
                $dataPesanan = new ModelDaftarPesanan();
                $data3 = ['id' => $idDataPinjaman, 'status' => '1'];
                $dataPesanan->save($data3);
            }
        }

        return redirect()->to('admin');
    }

    public function prosesAmbilBarang()
    {
        if (!(session()->get('email') && \session()->get('level') == 'adm')) {
            return redirect()->to('login');
        }

        $idBarang = $this->request->getVar('amIdBarang');
        $kodeBarang = $this->request->getVar('amKodeBarang');
        $namaPengambil = $this->request->getVar('namaPengambil');
        $jumlahBarang = $this->request->getVar('amJumlahBarang');
        $waktu = $this->request->getVar('waktu');
        $keperluan = $this->request->getVar('amKeperluan');
        $idDataPinjaman = $this->request->getVar('amIdAmbil');

        $tanggalAmbil = (explode(' ', $waktu))[0];
        $waktuAmbil = (explode(' ', $waktu))[1];

        $dataAmbilBarang = new ModelAmbilBarang();

        $data = [
            'idBarang' => $idBarang,
            'kodeBarang' => $kodeBarang,
            'namaPengambil' => $namaPengambil,
            'jumlahBarang' => $jumlahBarang,
            'tanggalAmbil' => $tanggalAmbil,
            'waktuAmbil' => $waktuAmbil,
            'keperluan' => $keperluan,
        ];
        $simpan = $dataAmbilBarang->save($data);

        if ($simpan) {
            $dataBarang = new ModelDaftarBarang();
            $upd = $dataBarang->where('id', $idBarang)->first();
            $data2 = [
                'id' => $upd->id,
                'stokBarang' => $upd->stokBarang - $jumlahBarang,
            ];

            session()->setFlashdata('tipe', 'success');
            session()->setFlashdata('pesan', 'Data berhasil disimpan');
            $dataBarang->save($data2);

            if ($idDataPinjaman != '') {
                $dataPesanan = new ModelDaftarPesanan();
                $data3 = ['id' => $idDataPinjaman, 'status' => '1'];
                $dataPesanan->save($data3);
            }
        }

        return redirect()->to('admin');
    }

    public function getPeminjam()
    {
        $kodeBarang = $this->request->getVar('kodeBarang');
        $dataPinjamBarang = new ModelDataPinjamBarang();

        $data = $dataPinjamBarang
            ->where(['kodeBarang' => $kodeBarang, 'status' => '0'])
            ->findAll();
        $res = '<option value="">-- Peminjam --</option>';
        foreach ($data as $key) {
            $res .= '<option value="' . $key->namaPeminjam . '">' . $key->namaPeminjam . '</option>';
        }

        echo json_encode($res);
    }

    public function barangDipinjam()
    {
        $kodeBarang = $this->request->getVar('kodeBarang');
        $namaPeminjam = $this->request->getVar('namaPeminjam');

        $dataPinjamBarang = new ModelDataPinjamBarang();
        $data = $dataPinjamBarang
            ->select('*, dataPinjamBarang.id as idP, dataBarang.id as idB')
            ->where(['dataPinjamBarang.kodeBarang' => $kodeBarang, 'namaPeminjam' => $namaPeminjam, 'status' => '0'])
            ->join('dataBarang', 'dataBarang.kodeBarang = dataPinjamBarang.kodeBarang')
            ->first();

        echo json_encode($data);
    }

    public function prosesKembaliBarangModal()
    {
        $kbIdBarang = $this->request->getVar('kbIdBarang');
        $kbIdPinjaman = $this->request->getVar('kbIdPinjaman');
        $kbKodeBarang = $this->request->getVar('kbKodeBarang');
        $kbNamaPeminjam = $this->request->getVar('kbNamaPeminjam');
        $kbNamaBarang = $this->request->getVar('kbNamaBarang');
        $namaKembali = $this->request->getVar('namaKembali');
        $jumlahBarangKembali = $this->request->getVar('jumlahBarangKembali');
        $waktu = $this->request->getVar('waktu');

        $tanggalKembali = (explode(' ', $waktu))[0];
        $waktuKembali = (explode(' ', $waktu))[1];

        $dataBarang = new ModelDaftarBarang();
        $dataBarangDipinjam = $dataBarang->where('id', $kbIdBarang)->first();
        $dataPinjam = new ModelDataPinjamBarang();

        $dataPinjaman = $dataPinjam->where('id', $kbIdPinjaman)->first();

        if ($dataPinjaman->jumlahBarang == $jumlahBarangKembali or (($dataPinjaman->jumlahKembali + $jumlahBarangKembali) == $dataPinjaman->jumlahBarang)) {
            $status = '1';
        } elseif ($dataPinjaman->jumlahBarang > $jumlahBarangKembali) {
            $status = '0';
        } else {
            session()->setFlashdata('tipe', 'error');
            session()->setFlashdata('pesan', 'Data tidak disimpan, jumlah barang dikembalikan lebih banyak dari yang dipinjam');
            return redirect()->back();
        }

        $data = [
            'id' => $kbIdPinjaman,
            'namaKembali' => $namaKembali,
            'tanggalKembali' => $tanggalKembali,
            'waktuKembali' => $waktuKembali,
            'jumlahKembali' => $dataPinjaman->jumlahKembali + $jumlahBarangKembali,
            'status' => $status,
        ];

        $simpan = $dataPinjam->save($data);

        if ($simpan) {
            $data2 = [
                'id' => $kbIdBarang,
                'stokBarang' => $dataBarangDipinjam->stokBarang + $jumlahBarangKembali
            ];
            $dataBarang->save($data2);
        }
        session()->setFlashdata('tipe', 'success');
        session()->setFlashdata('pesan', 'Data berhasil disimpan');
        return redirect()->back();
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
                'jmlDimiliki' => $adaKode->jmlDimiliki + $stokBarang,
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
                'jmlDimiliki' => $stokBarang,
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

    public function hapusSemua()
    {
        $id = $this->request->getVar('hapus');

        $dataBarang = new ModelDaftarBarang();
        $dataPinjamBarang = new ModelDataPinjamBarang();

        foreach ($id as $idHapus) {
            $dataBarang->delete($idHapus);
        }
        session()->setFlashdata('tipe', 'success');
        session()->setFlashdata('pesan', 'Data berhasil dihapus');
        return redirect()->back();
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

    public function getDataBarangByKode()
    {
        $kodeBarang = $this->request->getVar('kodeBarang');

        $dataBarang = new ModelDaftarBarang();

        $barang = $dataBarang
            ->where('kodeBarang', $kodeBarang)
            ->first();

        if ($barang) {
            # code...
            echo json_encode($barang);
        } else {
            echo "0";
        }
    }

    public function ubahDataBarang()
    {
        $id = $this->request->getVar('idUbahBarang');
        $kodeBarang = $this->request->getVar('ubahKodeBarang');
        $namaBarang = $this->request->getVar('ubahNamaBarang');
        $jenisBarang = $this->request->getVar('ubahJenisBarang');
        $stokBarang = $this->request->getVar('ubahStokBarang');
        $jmlDimiliki = $this->request->getVar('ubahJmlDimiliki');
        $satuan = $this->request->getVar('ubahSatuan');

        $data = [
            'id' => $id,
            'kodeBarang' => $kodeBarang,
            'namaBarang' => $namaBarang,
            'jenisBarang' => $jenisBarang,
            'stokBarang' => $stokBarang,
            'jmlDimiliki' => $jmlDimiliki,
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

    public function daftarBarangDipinjam()
    {
        $dataPinjam = new ModelDataPinjamBarang();
        $data['pinjam'] = $dataPinjam
            ->select('*, datapinjambarang.id as idP')
            ->join('dataBarang', 'dataBarang.id = dataPinjamBarang.idBarang')
            ->orderBy('status', 'ASC')
            ->orderBy('dataPinjamBarang.id', 'DESC')
            ->findAll();
        return \view('admin/pages/daftarBarangDipinjam', $data);
    }

    public function getDataBarangKembalikan()
    {
        $idP = $this->request->getVar('idP');

        $dataPinjam = new ModelDataPinjamBarang();
        $data = $dataPinjam->join('dataBarang', 'dataBarang.id = dataPinjamBarang.idBarang')->where('dataPinjamBarang.id', $idP)->first();

        echo json_encode($data);
    }

    public function daftarBarangDiambil()
    {
        $dataAmbil = new ModelAmbilBarang();
        $data['ambil'] = $dataAmbil
            ->join('dataBarang', 'dataBarang.id = dataAmbilBarang.idBarang')
            ->orderBy('dataAmbilBarang.id', 'DESC')
            ->findAll();
        return \view('admin/pages/daftarBarangDiambil', $data);
    }
}
