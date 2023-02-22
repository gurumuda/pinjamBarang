<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelDaftarBarang;
use App\Models\ModelDataPinjamBarang;
use App\Models\ModelDaftarPesanan;
use App\Models\ModelAmbilBarang;
use App\Models\ModelPengguna;
use App\Models\ModelInstansi;
use Picqer;
use Mpdf\Mpdf;

class Admin extends BaseController
{
    protected $helpers = ['my_helper', 'form'];
    
    
    public function __construct()
    {
        $this->dataPengguna = new ModelPengguna();
        $this->dataInstansi = new ModelInstansi();
    }
    

    public function index()
    {
        if (!(session()->get('email') && \session()->get('level') == 'adm')) {
            return redirect()->to('login');
        }

        $dataPesanan = new ModelDaftarPesanan();
        $dataBarang = new ModelDaftarBarang();
        $data['admin'] = $this->dataPengguna->where('email', session()->get('email'))->first();
        $data['instansi'] = $this->dataInstansi->first();

        $data['users'] = $this->dataPengguna->orderBy('nama', 'ASC')->where('level', '1')->findAll();

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
        if (!(session()->get('email') && \session()->get('level') == 'adm')) {
            return redirect()->to('login');
        }

        $id = $this->request->getVar('id');
        $dataPesanan = new ModelDaftarPesanan();
        $data = ['id' => $id, 'status' => '1'];
        $dataPesanan->save($data);
    }

    public function getJenisBarang()
    {
        if (!(session()->get('email') && \session()->get('level') == 'adm')) {
            return redirect()->to('login');
        }

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
        $phone = $this->request->getVar('hpPeminjam');
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
            'phone' => $phone,
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
        if (!(session()->get('email') && \session()->get('level') == 'adm')) {
            return redirect()->to('login');
        }

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
        if (!(session()->get('email') && \session()->get('level') == 'adm')) {
            return redirect()->to('login');
        }

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
        if (!(session()->get('email') && \session()->get('level') == 'adm')) {
            return redirect()->to('login');
        }

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
        $data['admin'] = $this->dataPengguna->where('email', session()->get('email'))->first();
        $data['instansi'] = $this->dataInstansi->first();

        return view('admin/pages/daftarBarang', $data);
    }

    public function tambahBarang()
    {
        if (!(session()->get('email') && \session()->get('level') == 'adm')) {
            return redirect()->to('login');
        }

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
        if (!(session()->get('email') && \session()->get('level') == 'adm')) {
            return redirect()->to('login');
        }

        $id = $this->request->getVar("id");
        $dataBarang = new ModelDaftarBarang();
        $dataBarang->delete($id);
    }

    public function hapusSemua()
    {
        if (!(session()->get('email') && \session()->get('level') == 'adm')) {
            return redirect()->to('login');
        }

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
        if (!(session()->get('email') && \session()->get('level') == 'adm')) {
            return redirect()->to('login');
        }

        $id = $this->request->getVar('id');

        $dataBarang = new ModelDaftarBarang();

        $barang = $dataBarang
            ->where('id', $id)
            ->first();

        echo json_encode($barang);
    }

    public function getDataBarangByKode()
    {
        if (!(session()->get('email') && \session()->get('level') == 'adm')) {
            return redirect()->to('login');
        }

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
        if (!(session()->get('email') && \session()->get('level') == 'adm')) {
            return redirect()->to('login');
        }

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
        if (!(session()->get('email') && \session()->get('level') == 'adm')) {
            return redirect()->to('login');
        }

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
        if (!(session()->get('email') && \session()->get('level') == 'adm')) {
            return redirect()->to('login');
        }

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
        if (!(session()->get('email') && \session()->get('level') == 'adm')) {
            return redirect()->to('login');
        }
        $dataPinjam = new ModelDataPinjamBarang();
        $data['pinjam'] = $dataPinjam
            ->select('*, datapinjambarang.id as idP')
            ->join('dataBarang', 'dataBarang.id = dataPinjamBarang.idBarang')
            ->orderBy('status', 'ASC')
            ->orderBy('dataPinjamBarang.id', 'DESC')
            ->findAll();
        $data['admin'] = $this->dataPengguna->where('email', session()->get('email'))->first();
        $data['instansi'] = $this->dataInstansi->first();
        return \view('admin/pages/daftarBarangDipinjam', $data);
    }

    public function getDataBarangKembalikan()
    {
        if (!(session()->get('email') && \session()->get('level') == 'adm')) {
            return redirect()->to('login');
        }

        $idP = $this->request->getVar('idP');

        $dataPinjam = new ModelDataPinjamBarang();
        $data = $dataPinjam->select('*, dataPinjamBarang.id as idP')->join('dataBarang', 'dataBarang.id = dataPinjamBarang.idBarang')->where('dataPinjamBarang.id', $idP)->first();

        echo json_encode($data);
    }

    public function daftarBarangDiambil()
    {
        if (!(session()->get('email') && \session()->get('level') == 'adm')) {
            return redirect()->to('login');
        }
        $dataAmbil = new ModelAmbilBarang();
        $data['ambil'] = $dataAmbil
            ->join('dataBarang', 'dataBarang.id = dataAmbilBarang.idBarang')
            ->orderBy('dataAmbilBarang.id', 'DESC')
            ->findAll();
        $data['admin'] = $this->dataPengguna->where('email', session()->get('email'))->first();
        $data['instansi'] = $this->dataInstansi->first();
        return \view('admin/pages/daftarBarangDiambil', $data);
    }

    public function updatePengguna()
    {
        if (!(session()->get('email') && \session()->get('level') == 'adm')) {
            return redirect()->to('login');
        }

        $email = $this->request->getVar('email');
        $nama = $this->request->getVar('nama');
        $password = $this->request->getVar('password');

        $id = $this->dataPengguna->where('email', session()->get('email'))->first()->id;

        if ($password != '') {
            $data = [
                'id' => $id,
                'email' => $email,
                'nama' => $nama,
                'pass' => password_hash($password, PASSWORD_DEFAULT)
            ];
        } else {
            $data = [
                'id' => $id,
                'email' => $email,
                'nama' => $nama
            ];
        }

        $this->dataPengguna->save($data);
        return redirect()->to('admin/logout');
    }

    public function users()
    {
        if (!(session()->get('email') && \session()->get('level') == 'adm')) {
            return redirect()->to('login');
        }
        $data['admin'] = $this->dataPengguna->where('email', session()->get('email'))->first();
        $data['instansi'] = $this->dataInstansi->first();
        $data['users'] = $this->dataPengguna->where('level', '1')->findAll();

       return view('admin/pages/users', $data);
    }

    public function tambahUser()
    {
        if (!(session()->get('email') && \session()->get('level') == 'adm')) {
            return redirect()->to('login');
        }

        $email = $this->request->getVar('emailUser');
        $nama = $this->request->getVar('namaUser');
        $pass = $this->request->getVar('passwordUser');
        $phone = $this->request->getVar('noHP');

        $ada = $this->dataPengguna->where('email', $email)->first();

        if ($ada) {
            echo '2';
        } else {
            $data = [
                'email' => $email,
                'nama' => $nama,
                'phone' => $phone,
                'pass' => password_hash($pass, PASSWORD_DEFAULT)
            ];
    
            $simpan = $this->dataPengguna->save($data);

            echo "1";
        }
    
    }

    public function hapusUser()
    {
        if (!(session()->get('email') && \session()->get('level') == 'adm')) {
            return redirect()->to('login');
        }

        $id = $this->request->getVar('id');
        $this->dataPengguna->delete($id);
    }

    public function getDataUser()
    {
        if (!(session()->get('email') && \session()->get('level') == 'adm')) {
            return redirect()->to('login');
        }

        $id = $this->request->getVar('id');
        $data = $this->dataPengguna->where('id', $id)->first();
        echo json_encode($data);
    }

    public function prosesUbahUser()
    {
        if (!(session()->get('email') && \session()->get('level') == 'adm')) {
            return redirect()->to('login');
        }

        $id = $this->request->getVar('idUser');
        $email = $this->request->getVar('u_emailUser');
        $nama = $this->request->getVar('u_namaUser');
        $pass = $this->request->getVar('u_passwordUser');
        $phone = $this->request->getVar('u_nomorHP');


        if ($pass !='') {
            $data = [
                'id' => $id,
                'email' => $email,
                'nama' => $nama,
                'phone' => $phone,
                'pass' => password_hash($pass, PASSWORD_DEFAULT)
            ];
        } else {
            $data = [
                'id' => $id,
                'email' => $email,
                'phone' => $phone,
                'nama' => $nama
            ];
        }
        
        $simpan = $this->dataPengguna->save($data);
        if ($simpan) {
            session()->setFlashdata('tipe', 'success');
            session()->setFlashdata('pesan', 'Data berhasil disimpan');
        }
        return redirect()->back();

    }

    public function updateInstansi()
    {
        if (!(session()->get('email') && \session()->get('level') == 'adm')) {
            return redirect()->to('login');
        }

        $image = \Config\Services::image();

        $namaInstansi = $this->request->getVar('namaInstansi');
        $alamat = $this->request->getVar('alamat');
        $api = $this->request->getVar('api');
        $file = $this->request->getFile('logo');

        $validationRule = [
            'logo' => [
                'label' => 'Image File',
                'rules' => [
                    'uploaded[logo]',
                    'is_image[logo]',
                    'mime_in[logo,image/jpg,image/jpeg,image/gif,image/png]',
                ],
            ],
        ];
        if (! $this->validate($validationRule)) {
            $errors = ['errors' => $this->validator->getErrors()];
        }

        $newName = $file->getRandomName();
        $up = $file->move('logo/', $newName);
        
        if ($up) {
            $image->withFile('logo/'.$newName)
                ->resize(30, 30, true, 'height')
                ->save('logo/thumb/thumb_'.$newName);

            $data = [
                'id' => '1',
                'namaInstansi' => $namaInstansi,
                'alamat' => $alamat,
                'logo' => $newName,
                'api' => $api,
            ];
        } else {
            $data = [
                'id' => '1',
                'namaInstansi' => $namaInstansi,
                'alamat' => $alamat,
                'api' => $api,
            ];
        }
        
        $simpan = $this->dataInstansi->save($data);
        if ($simpan) {
            session()->setFlashdata('tipe', 'success');
            session()->setFlashdata('pesan', 'Data berhasil disimpan');
        }
        return redirect()->back();
    }

    public function tagihBarang()
    {
        if (!(session()->get('email') && \session()->get('level') == 'adm')) {
            return redirect()->to('login');
        }

        $id = $this->request->getVar('id');
        
        $api = $this->dataInstansi->first()->api;

        $dataPinjamBarang = new ModelDataPinjamBarang();
        $data = $dataPinjamBarang->where('dataPinjamBarang.id', $id)
        ->join('dataBarang', 'dataBarang.kodeBarang = dataPinjamBarang.kodeBarang', 'left')
        ->first();

        $pesan = 'Mohon segera melakukan pengembalian barang yang telah dipinjam berupa:
'.$data->namaBarang;

    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => $api,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => array(
            'message' => $pesan,
            'number' => $data->phone,
            'token' => 'TokenSaya'
        ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    echo $response;

    }

    public function getNomorHp()
    {
        if (!(session()->get('email') && \session()->get('level') == 'adm')) {
            return redirect()->to('login');
        }

        $nama = $this->request->getVar('nama');
        $data = $this->dataPengguna->where('nama', $nama)->first();
      
        if ($data) {
            echo json_encode($data);
        } else {
            echo '0';
        }
    }

    public function dwnBrgDipinjam()
    {
        if (!(session()->get('email') && \session()->get('level') == 'adm')) {
            return redirect()->to('login');
        }

        $pinjam = new ModelDataPinjamBarang();
        $data = $pinjam
            ->join('dataBarang', 'dataBarang.id = dataPinjamBarang.idBarang', 'LEFT')
            ->findAll();
        $no = 1;

        $print = '<style>
                    #customers {
                        font-family: Arial, Helvetica, sans-serif;
                        border-collapse: collapse;
                        width: 100%;
                    }
                    
                    #customers td, #customers th {
                        border: 1px solid #ddd;
                        padding: 8px;
                        vertical-align: top;
                    }
                    #customers th {
                        white-space: nowrap;
                    }
                    #customers tr:nth-child(even){background-color: #f2f2f2;}
                    
                    #customers tr:hover {background-color: #ddd;}
                    
                    #customers th {
                        padding-top: 12px;
                        padding-bottom: 12px;
                        text-align: left;
                        background-color: #04AA6D;
                        color: white;
                    }
                    .tengah {
                        text-align: center;
                    }
                    h3 {margin-bottom: 30px;}
                </style>';
                $print .= '<h3 class="tengah">Daftar Pemakaian Barang Modal</h3>';
        $print .= '<table id="customers">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Barang</th>
                            <th>Nama Peminjam</th>
                            <th>HP</th>
                            <th>Jumlah</th>
                            <th>Tanggal</th>
                            <th>Keperluan</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>';
        foreach ($data as $dt) {
            $print .= '<tr>';
            $print .= '<td>'.$no++.'</td>';
            $print .= '<td>'.$dt->namaBarang.'</td>';
            $print .= '<td>'.$dt->namaPeminjam.'</td>';
            $print .= '<td>'.$dt->phone.'</td>';
            $print .= '<td>'.$dt->jumlahBarang.'</td>';
            $print .= '<td>'.tglIndo($dt->tanggalPinjam).'</td>';
            $print .= '<td>'.$dt->keperluan.'</td>';
            $print .= '<td>'.(($dt->status == '1') ? 'Kembali' : 'Belum kembali').'</td>';
            $print .= '</tr>';     
                     
        }
        $print .= '</tbody></table>';
                        
        $mpdf = new Mpdf(['orientation' => 'L', 'format' => 'A4']);
        $mpdf->SetAuthor('GuruMuda');
        $mpdf->SetCreator('GuruMuda');
        $mpdf->SetWatermarkText('GuruMuda');
        $mpdf->showWatermarkText = true;
        $mpdf->watermarkTextAlpha = 0.1;
        $mpdf->WriteHTML($print);
        
        $a = $mpdf->Output('Daftar Pemakaian Barang Modal.pdf', 'D');
    }

    public function dwnBrg()
    {
        if (!(session()->get('email') && \session()->get('level') == 'adm')) {
            return redirect()->to('login');
        }

        $barang = new ModelDaftarBarang();
        $data = $barang
            ->orderBy('jenisBarang', 'DESC')
            ->orderBy('stokBarang', 'ASC')
            ->findAll();
        $no = 1;

        $print = '<style>
                    #customers {
                        font-family: Arial, Helvetica, sans-serif;
                        border-collapse: collapse;
                        width: 100%;
                    }
                    
                    #customers td, #customers th {
                        border: 1px solid #ddd;
                        padding: 8px;
                        vertical-align: top;
                    }
                    #customers th {
                        white-space: nowrap;
                    }
                    #customers tr:nth-child(even){background-color: #f2f2f2;}
                    
                    #customers tr:hover {background-color: #ddd;}
                    
                    #customers th {
                        padding-top: 12px;
                        padding-bottom: 12px;
                        text-align: left;
                        background-color: #04AA6D;
                        color: white;
                    }
                    .tengah {
                        text-align: center;
                    }
                    h3 {margin-bottom: 30px;}
                </style>';
                $print .= '<h3 class="tengah">Daftar Barang Modal dan Barang Habis Pakai <br> SMA Negeri 1 Jorong <br> Tahun 2023</h3>';
        $print .= '<table id="customers">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode Barang</th>
                            <th>Nama Barang</th>
                            <th>Jenis Barang</th>
                            <th>Stok</th>
                            <th>Terdata</th>
                            <th>Satuan</th>
                        </tr>
                    </thead>
                    <tbody>';
        foreach ($data as $dt) {
            $print .= '<tr>';
            $print .= '<td>'.$no++.'</td>';
            $print .= '<td>'.$dt->kodeBarang.'</td>';
            $print .= '<td>'.$dt->namaBarang.'</td>';
            $print .= '<td>'.(($dt->jenisBarang == 1) ? "Barang modal" : "Barang habis pakai").'</td>';
            $print .= '<td>'.$dt->stokBarang.'</td>';
            $print .= '<td>'.$dt->jmlDimiliki.'</td>';
            $print .= '<td>'.$dt->satuan.'</td>';
            $print .= '</tr>';     
                     
        }
        $print .= '</tbody></table>';
                        
        $mpdf = new Mpdf(['orientation' => 'L', 'format' => 'A4']);
        $mpdf->SetAuthor('GuruMuda');
        $mpdf->SetCreator('GuruMuda');
        $mpdf->SetWatermarkText('GuruMuda');
        $mpdf->showWatermarkText = true;
        $mpdf->watermarkTextAlpha = 0.1;
        $mpdf->WriteHTML($print);
        
        $a = $mpdf->Output('Daftar Pemakaian Barang Modal.pdf', 'D');
    }
}
