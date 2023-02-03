<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>

<div class="container-fluid py-4">
    <div class="row">

        <div class="col-xl-6 col-sm-6 mb-xl-0 mb-4">
            <div class="card text-center">
                <div class="card-header p-3 pt-2 mb-1">
                    <div class="bg-gradient-primary shadow-primary text-center border-radius-xl mt-n4 p-3">
                        <i class="text-white" style="margin-top: 0; display:inline-block">Pinjam / Kembali Barang Modal</i>
                    </div>

                </div>
                <hr class="dark horizontal my-0">
                <div class="card-footer p-3">
                    <button class="btn bg-warning text-white" data-bs-toggle="modal" data-bs-target="#modalPinjamBarangModal"><i class="material-icons opacity-10 text-white">input</i> Pinjam</button>
                    <button class="btn bg-success text-white" data-bs-toggle="modal" data-bs-target="#modalPinjamBarangModal"><i class="material-icons opacity-10 text-white">input</i> Kembali</button>

                </div>
            </div>
        </div>
        <div class="col-xl-6 col-sm-6 mb-xl-0 mb-4">
            <div class="card text-center">
                <div class="card-header p-3 pt-2 mb-1">
                    <div class="bg-gradient-success shadow-success text-center border-radius-xl mt-n4 p-3">
                        <i class="text-white" style="margin-top: 0; display:inline-block">Ambil Barang</i>
                    </div>

                </div>
                <hr class="dark horizontal my-0">
                <div class="card-footer p-3">
                    <button class="btn bg-danger text-white"><i class="material-icons opacity-10 text-white">input</i> Ambil Barang Habis Pakai</button>

                </div>
            </div>
        </div>

    </div>


    <div class="modal fade" id="modalPinjamBarangModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-normal" id="exampleModalLabel">Pinjam Barang</h5>
                    <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <?= form_open('/admin/prosesPinjamBarangModal'); ?>
                <div class="modal-body">
                    <div class="row mb-2">
                        <div class="input-group input-group-outline">
                            <label for="" class="col-4">Kode Barang</label>
                            <input type="text" name="pjKodeBarang" id="pjKodeBarang" class="form-control" placeholder="Masukkan Kode Barang">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="input-group input-group-outline">
                            <label for="" class="col-4">Nama Barang</label>
                            <input type="text" readonly name="pjNamaBarang" id="pjNamaBarang" class="form-control" placeholder="Auto Load">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="input-group input-group-outline">
                            <label for="" class="col-4">Stok Barang</label>
                            <input type="text" readonly name="pjStokBarang" id="pjStokBarang" class="form-control" placeholder="Auto Load">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="input-group input-group-outline">
                            <label for="" class="col-4">Nama Peminjam</label>
                            <input type="text" name="namaPeminjam" id="namaPeminjam" class="form-control" placeholder="Masukkan nama peminjam">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="input-group input-group-outline">
                            <label for="" class="col-4">Jumlah Barang</label>
                            <input type="number" name="jumlahBarang" id="jumlahBarang" class="form-control" placeholder="Masukkan jumlah barang yang dipinjam">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="input-group input-group-outline">
                            <label for="" class="col-4">Waktu Pinjam</label>
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
                <div class="modal-footer">
                    <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" id="tombolSimpanPinjamBarang" class="btn bg-gradient-primary">Simpan</button>
                </div>
                <?= form_close(); ?>
            </div>
        </div>
    </div>


    <div class="row mb-4 mt-2">
        <div class="col-lg-12 col-md-12 mb-md-0 mb-4">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="row">
                        <div class="col-lg-6 col-7">
                            <h6>Daftar Permintaan Barang</h6>
                        </div>
                    </div>
                </div>
                <div class="card-body px-0 pb-2">
                    <div class="table-responsive mb-5 ms-2 me-4">
                        <table class="table align-items-center">
                            <thead>
                                <tr>
                                    <th class="text-center text-secondary font-weight-bolder opacity-7">No</th>
                                    <th class="text-secondary font-weight-bolder opacity-7 ps-2">KodeBarang</th>
                                    <th class="text-secondary font-weight-bolder opacity-7 ps-2">Nama Barang</th>
                                    <th class="text-secondary font-weight-bolder opacity-7 ps-2">Jenis Barang</th>
                                    <th class="text-secondary font-weight-bolder opacity-7 ps-2">Nama Pemesan</th>
                                    <th class="text-center text-secondary font-weight-bolder opacity-7">Jumlah</th>
                                    <th class="text-secondary font-weight-bolder opacity-7 ps-2">Keperluan</th>
                                    <th class="text-secondary font-weight-bolder opacity-7 ps-2">Waktu Pakai</th>
                                    <th class="text-secondary font-weight-bolder opacity-7 ps-2">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($pesanan) : ?>
                                    <?php $no = 1;
                                    foreach ($pesanan as $ps) : ?>
                                        <tr>
                                            <td class="text-center text-xs">
                                                <?= $no++; ?>
                                            </td>
                                            <td class="text-xs">
                                                <?= $ps->kodeBarang; ?>
                                            </td>
                                            <td class="text-xs">
                                                <?= $ps->namaBarang; ?>
                                            </td>
                                            <td class="text-xs">
                                                <?= ($ps->jenisBarang == '1') ? 'Barang Modal' : 'Habis Pakai'; ?>
                                            </td>
                                            <td class="text-xs">
                                                <?= $ps->nama; ?>
                                            </td>
                                            <td class="align-middle text-center text-xs">
                                                <?= $ps->jumlahBarang; ?>
                                            </td>
                                            <td class="align-middle text-xs">
                                                <?= $ps->kepPesanan; ?>
                                            </td>
                                            <td class="align-middle text-xs">
                                                <?= $ps->tanggalPakai . ' ' . $ps->waktuPakai; ?>
                                            </td>
                                            <td class="text-xs">
                                                <span type="button" class="badge bg-success tmbUbahStatusPesanan" data-id="<?= $ps->idP; ?>" data-nama="<?= $ps->namaBarang; ?>" data-pemesan="<?= $ps->nama; ?>">Sudah</span>

                                                <span data-idP="<?= $ps->idP; ?>" type="button" class="badge bg-danger tbmProsesPesanan">Proses Pesanan</span>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <tr>
                                        <td colspan="7" class="text-center text-secondary font-weight-bolder opacity-7">
                                            Tidak ada data pesanan
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 mt-2">
            <div class="card h-100">
                <div class="card-header pb-0">
                    <h6>Orders overview</h6>
                    <p class="text-sm">
                        <i class="fa fa-arrow-up text-success" aria-hidden="true"></i>
                        <span class="font-weight-bold">24%</span> pesanan
                    </p>
                </div>
                <div class="card-body p-3">
                    <div class="timeline timeline-one-side">
                        <div class="timeline-block mb-3">
                            <span class="timeline-step">
                                <i class="material-icons text-success text-gradient">notifications</i>
                            </span>
                            <div class="timeline-content">
                                <h6 class="text-dark text-sm font-weight-bold mb-0">$2400, Design changes</h6>
                                <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">22 DEC 7:20 PM</p>
                            </div>
                        </div>
                        <div class="timeline-block mb-3">
                            <span class="timeline-step">
                                <i class="material-icons text-danger text-gradient">code</i>
                            </span>
                            <div class="timeline-content">
                                <h6 class="text-dark text-sm font-weight-bold mb-0">New order #1832412</h6>
                                <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">21 DEC 11 PM</p>
                            </div>
                        </div>
                        <div class="timeline-block mb-3">
                            <span class="timeline-step">
                                <i class="material-icons text-info text-gradient">shopping_cart</i>
                            </span>
                            <div class="timeline-content">
                                <h6 class="text-dark text-sm font-weight-bold mb-0">Server payments for April</h6>
                                <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">21 DEC 9:34 PM</p>
                            </div>
                        </div>
                        <div class="timeline-block mb-3">
                            <span class="timeline-step">
                                <i class="material-icons text-warning text-gradient">credit_card</i>
                            </span>
                            <div class="timeline-content">
                                <h6 class="text-dark text-sm font-weight-bold mb-0">New card added for order #4395133</h6>
                                <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">20 DEC 2:20 AM</p>
                            </div>
                        </div>
                        <div class="timeline-block mb-3">
                            <span class="timeline-step">
                                <i class="material-icons text-primary text-gradient">key</i>
                            </span>
                            <div class="timeline-content">
                                <h6 class="text-dark text-sm font-weight-bold mb-0">Unlock packages for development</h6>
                                <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">18 DEC 4:54 AM</p>
                            </div>
                        </div>
                        <div class="timeline-block">
                            <span class="timeline-step">
                                <i class="material-icons text-dark text-gradient">payments</i>
                            </span>
                            <div class="timeline-content">
                                <h6 class="text-dark text-sm font-weight-bold mb-0">New order #9583120</h6>
                                <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">17 DEC</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<?= $this->endSection() ?>