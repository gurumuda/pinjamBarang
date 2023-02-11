<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>
<div class="container-fluid py-4">

    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">Tabel Daftar Barang Dipinjam</h6>
                    </div>
                </div>
                <div class="card-body px-0 pb-2">
                    <div class="table-responsive p-0 m-4">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7 ps-2">Kode Barang</th>
                                    <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7 ps-2">Nama Barang</th>
                                    <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7 ps-2">Nama Peminjam</th>
                                    <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7 ps-2">Jml Pinjam</th>
                                    <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7 ps-2">Jml Kembali</th>
                                    <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7 ps-2">Tanggal Pinjam</th>
                                    <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7 ps-2">Waktu Pinjam</th>
                                    <th class="text-uppercase text-secondary text-sm opacity-7 ps-2">Keperluan</th>
                                    <th class="text-uppercase text-secondary text-sm opacity-7 ps-2">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($pinjam as $brg) : ?>
                                    <tr>
                                        <td class="text-xs"><?= $brg->kodeBarang; ?></td>
                                        <td class="text-xs"><?= $brg->namaBarang; ?></td>
                                        <td class="text-xs"><?= $brg->namaPeminjam; ?></td>
                                        <td class="text-xs"><?= $brg->jumlahBarang; ?></td>
                                        <td class="text-xs"><?= $brg->jumlahKembali; ?></td>
                                        <td class="text-xs"><?= $brg->tanggalPinjam; ?></td>
                                        <td class="text-xs"><?= $brg->waktuPinjam; ?></td>
                                        <td class="text-xs"><?= $brg->keperluan; ?></td>
                                        <td class="text-xs">
                                            <?= ($brg->status == '0') ? '<span type="button" data-id="'.$brg->idP.'" class="badge bg-danger tbProsesKembaliBrg">Proses</span>' : '' ?>
                                        <?= ($brg->status == '1') ? '<span class="badge bg-success">Kembali</span>' : '<span class="badge bg-warning">Belum Kembali</span>'; ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>


        </div>
    </div>

    <div class="modal fade " id="modalKembaliBarangModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered " role="document">
            <div class="modal-content" style="background-color: chartreuse;">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-normal" id="exampleModalLabel">Kembalikan Barang</h5>
                    <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <?= form_open('/admin/prosesKembaliBarangModal', ["onSubmit" => 'return cekProsesKembaliBarang()']); ?>
                <input type="hidden" name="kbIdBarang" id="kbIdBarang" style="display: none;">
                <input type="hidden" name="kbIdPinjaman" id="kbIdPinjaman" style="display: none;">
                <div class="modal-body">
                    <div class="row mb-2">
                        <div class="input-group input-group-outline">
                            <label for="" class="col-4">Kode Barang</label>
                            <input type="text" name="kbKodeBarang" readonly id="kbKodeBarang" class="form-control" placeholder="Masukkan Kode Barang">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="input-group input-group-outline">
                            <label for="" class="col-4">Nama Peminjam</label>
                            <input type="text" readonly name="kbNamaPeminjam" id="kbNamaPeminjam" class="form-control" placeholder="Auto Load">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="input-group input-group-outline">
                            <label for="" class="col-4">Nama Barang</label>
                            <input type="text" readonly name="kbNamaBarang" id="kbNamaBarang" class="form-control" placeholder="Auto Load">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="input-group input-group-outline">
                            <label for="" class="col-4">Jumlah Dipinjam</label>
                            <input type="text" readonly name="kbJumlahDipinjam" id="kbJumlahDipinjam" class="form-control" placeholder="Auto Load">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="input-group input-group-outline">
                            <label for="" class="col-4">Jumlah Barang Kembali</label>
                            <input type="number" name="jumlahBarangKembali" id="jumlahBarangKembali" class="form-control" placeholder="Masukkan jumlah barang yang kembali">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="input-group input-group-outline">
                            <label for="" class="col-4">Nama Mengembalikan</label>
                            <input type="text" name="namaKembali" id="namaKembali" class="form-control" placeholder="Masukkan nama yang mengembalikan">
                        </div>
                    </div>

                    <div class="row mb-2">
                        <div class="input-group input-group-outline">
                            <label for="" class="col-4">Waktu Kembali</label>
                            <input type="text" name="waktu" id="filter-date" class="form-control" placeholder="Tanggal dan waktu kembali">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" id="tombolSimpanKembaliBarang" class="btn bg-gradient-primary">Simpan</button>
                </div>
                <?= form_close(); ?>
            </div>
        </div>
    </div>

</div>


<?= $this->endSection() ?>