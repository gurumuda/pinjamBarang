<?= $this->extend('user/layout') ?>

<?= $this->section('content') ?>

<div class="container-fluid py-4">
    <div class="row">

        <div class="col-xl-4 col-sm-4 mb-xl-0 mb-4">
            <div class="card text-center">
                <div class="card-header p-3 pt-2 mb-1">
                    <div class="bg-gradient-primary shadow-primary text-center border-radius-xl mt-n4 p-3">
                        <i class="text-white" style="margin-top: 0; display:inline-block">Buat Pesanan</i>
                    </div>

                </div>
                <hr class="dark horizontal my-0">
                <div class="card-footer p-3">
                    <button class="btn bg-warning text-white" data-bs-toggle="modal" data-bs-target="#modalPinjamBarangModal"><i class="material-icons opacity-10 text-white">input</i> Pinjam / Ambil</button>
                </div>
            </div>
        </div>
    </div>

    <style>
        #mySelect2 {
            width: 307px;
        }

        @media only screen and (max-width: 540px) {
            #mySelect2 {
                width: 265px;
            }
        }
    </style>

    <div class="modal fade" id="modalPinjamBarangModal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-normal" id="exampleModalLabel">Pesan Barang</h5>
                    <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <?= form_open('/user/prosesInden'); ?>
                <div class="modal-body">
                    <div class="row mb-2">
                        <div class="input-group input-group-outline" id="aa">
                            <label for="" class="col-4">Nama Barang</label>
                            <select class="form-control" id="mySelect2" name="pjIdBarang">
                                <option value="">Pilih nama barang</option>
                                <?php foreach ($barangStok as $bara) : ?>
                                    <option value="<?= $bara->id; ?>"><?= $bara->namaBarang; ?></option>
                                <?php endforeach; ?>
                            </select>

                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="input-group input-group-outline">
                            <label for="" class="col-4">Jumlah Barang</label>
                            <input type="number" name="jumlahBarang" id="jumlahBarang" class="form-control" placeholder="Masukkan jumlah barang">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="input-group input-group-outline">
                            <label for="" class="col-4">Waktu Ambil</label>
                            <input type="text" name="waktu" id="filter-date" class="form-control" placeholder="Tanggal dan waktu pinjam">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="input-group input-group-outline">
                            <label for="" class="col-4">Keperluan</label>
                            <textarea name="keperluan" id="keperluan" class="form-control" rows="3" placeholder="Masukkan keperluan (Contoh: Pembelajaran, Ekstrakurikuler, Rapat, Dll)"></textarea>
                        </div>
                    </div>
                </div>
                <small class="ms-3 text-info">Pastikan mengecek stok barang sebelum melakukan pesanan</small>
                <div class="modal-footer">
                    <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" id="tombolSimpanPinjamBarang" class="btn bg-gradient-primary">Simpan</button>
                </div>
                <?= form_close(); ?>
            </div>
        </div>
    </div>


    <div class="row mb-4 mt-5">
        <div class="col-lg-12 col-md-12 mb-md-0 mb-4">
            <div class="card">
                <div class="card-header p-3 pt-2 mb-1">
                    <div class="bg-gradient-info shadow-info text-center border-radius-xl mt-n4 p-3">
                        <i class="text-white" style="margin-top: 0; display:inline-block">Daftar Barang</i>
                    </div>

                </div>
                <div class="card-body px-0 pb-2">
                    <div class="table-responsive p-3">
                        <table class="table align-items-center" id="example">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">No</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nama Barang</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Stok</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Satuan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                foreach ($barang as $brg) : ?>
                                    <tr>
                                        <td class="align-middle text-center text-sm">
                                            <?= $no++; ?>
                                        </td>
                                        <td class="align-middle text-sm">
                                            <?= $brg->namaBarang; ?>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            <?= $brg->stokBarang; ?>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            <?= $brg->satuan; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<?= $this->endSection() ?>