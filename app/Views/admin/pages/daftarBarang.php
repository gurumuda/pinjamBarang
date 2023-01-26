<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-lg-2 d-grid gap-2">
            <!-- Button trigger modal -->
            <button type="button" class="btn bg-gradient-primary" data-bs-toggle="modal" data-bs-target="#modalTambahBarang">
                Tambah Data
            </button>
        </div>
        <div class="col-lg-2 d-grid gap-2">
            <a class="btn bg-gradient-success" href="">Download</a>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="modalTambahBarang" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title font-weight-normal" id="exampleModalLabel">Tambah data barang</h5>
                        <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="input-group input-group-outline mb-4">
                            <label class="form-label">Kode Barang</label>
                            <input type="text" name="kodeBarang" id="kodeBarang" class="form-control">
                        </div>
                        <div class="input-group input-group-outline mb-4">
                            <label class="form-label">Nama Barang</label>
                            <input type="text" name="namaBarang" id="namaBarang" class="form-control">
                        </div>
                        <div class="input-group input-group-outline mb-4">
                            <select name="jenisBarang" id="jenisBarang" class="form-control">
                                <option value="">-- Pilih Jenis Barang --</option>
                                <option value="1">Elektronik</option>
                                <option value="2">Cair</option>
                            </select>
                        </div>
                        <div class="input-group input-group-outline mb-4">
                            <label class="form-label">Jumlah Barang</label>
                            <input type="number" name="stokBarang" id="stokBarang" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="button" id="tombolTambahBarang" class="btn bg-gradient-primary">Tambah Data</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">Tabel Daftar Barang</h6>
                    </div>
                </div>
                <div class="card-body px-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th style="width: 2%;" class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7">No</th>
                                    <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7 ps-2">Kode Barang</th>
                                    <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7 ps-2">Nama Barang</th>
                                    <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7 ps-2">Stok</th>
                                    <th class="text-uppercase text-secondary text-sm opacity-7 ps-2">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($barang as $brg) : ?>
                                    <tr>
                                        <td class="ps-4 text-xs">
                                            <?= $nomor++; ?>
                                        </td>
                                        <td class="text-xs"><?= $brg->kodeBarang; ?></td>
                                        <td class="text-xs"><?= $brg->namaBarang; ?></td>
                                        <td class="text-xs"><?= $brg->stokBarang; ?></td>
                                        <td class="text-xs">
                                            <button class="badge badge-sm bg-gradient-warning tombolUbahBarang" data-id="<?= $brg->id; ?>">Ubah</button>
                                            <button class="badge badge-sm bg-gradient-danger tombolHapus" data-id="<?= $brg->id; ?>" data-nama="<?= $brg->namaBarang; ?>">Hapus</button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    <?= $pager->links('dataBarang', 'my_pagination') ?>

                </div>


            </div>


        </div>
    </div>


</div>


<div class="modal fade" id="modalUbahBarang" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-normal" id="exampleModalLabel">Ubah data barang</h5>
                <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?= form_open('admin/ubahDataBarang'); ?>
            <div class="modal-body">
                <input type="hidden" name="idUbahBarang" id="idUbahBarang" style="display: none;">
                <div class="input-group input-group-outline mb-4">
                    <div class="col-sm-4">
                        <label>Kode Barang</label>
                    </div>
                    <input type="text" name="ubahKodeBarang" id="ubahKodeBarang" class="form-control" required>
                </div>
                <div class="input-group input-group-outline mb-4">
                    <div class="col-sm-4">
                        <label>Nama Barang</label>
                    </div>
                    <input type="text" name="ubahNamaBarang" id="ubahNamaBarang" class="form-control" required>
                </div>
                <div class="input-group input-group-outline mb-4">
                    <div class="col-sm-4">
                        <label for="">Jenis Barang</label>
                    </div>
                    <select name="ubahJenisBarang" id="ubahJenisBarang" class="form-control" required>
                        <option value="">-- Pilih Jenis Barang --</option>
                        <option value="1">Elektronik</option>
                        <option value="2">Cair</option>
                    </select>
                </div>
                <div class="input-group input-group-outline mb-4">
                    <div class="col-sm-4">
                        <label>Jumlah Barang</label>
                    </div>
                    <input type="number" name="ubahStokBarang" id="ubahStokBarang" class="form-control" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="submit" id="tombolUbahBarang" class="btn bg-gradient-primary">Ubah Data</button>
            </div>
            <?= form_close(); ?>
        </div>
    </div>
</div>

<?= $this->endSection() ?>