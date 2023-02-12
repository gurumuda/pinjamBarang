<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>

<style>
    label {
        color: black;
    }
</style>

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
                    <button class="btn bg-success text-white" data-bs-toggle="modal" data-bs-target="#modalKembaliBarangModal"><i class="material-icons opacity-10 text-white">input</i> Kembali</button>
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
                    <button class="btn bg-danger text-white" data-bs-toggle="modal" data-bs-target="#modalAmbilBarang"><i class="material-icons opacity-10 text-white">input</i> Ambil Barang Habis Pakai</button>

                </div>
            </div>
        </div>

    </div>


    <div class="modal fade" id="modalPinjamBarangModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content" style="background-color: rgb(255, 255, 0);">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-normal" id="exampleModalLabel">Pinjam Barang</h5>
                    <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <?= form_open('/admin/prosesPinjamBarangModal', ["onSubmit" => 'return cekProsesPinjamBarang()']); ?>
                <input type="hidden" name="pjIdBarang" id="pjIdBarang" style="display: none;">
                <input type="hidden" name="pjIdPinjaman" id="pjIdPinjaman" style="display: none;">
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
                            <label for="" class="col-4">Satuan</label>
                            <input type="text" readonly name="pjSatuan" id="pjSatuan" class="form-control" placeholder="Auto Load">
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
                            <input type="text" name="waktu" id="filter-date-2" autocomplete="off" class="form-control" placeholder="Tanggal dan waktu pinjam">
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
                            <input type="text" name="kbKodeBarang" id="kbKodeBarang" class="form-control" placeholder="Masukkan Kode Barang">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="input-group input-group-outline">
                            <label for="" class="col-4">Nama Peminjam</label>
                            <select name="kbNamaPeminjam" id="kbNamaPeminjam" class="form-control">
                                <option value="">-- Masukkan kode barang --</option>
                            </select>
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
                            <input type="text" name="waktu" id="filter-date"  autocomplete="off" class="form-control" placeholder="Tanggal dan waktu kembali">
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

    <div class="modal fade" id="modalAmbilBarang" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content" style="background-color: rgb(255, 100, 0);">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-normal" id="exampleModalLabel">Ambil Barang Habis Pakai</h5>
                    <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <?= form_open('/admin/prosesAmbilBarang', ["onSubmit" => 'return cekProsesAmbilBarang()']); ?>
                <input type="hidden" name="amIdBarang" id="amIdBarang" style="display: none;">
                <input type="hidden" name="amIdAmbil" id="amIdAmbil" style="display: none;">
                <div class="modal-body">
                    <div class="row mb-2">
                        <div class="input-group input-group-outline">
                            <label for="" class="col-4">Kode Barang</label>
                            <input type="text" name="amKodeBarang" id="amKodeBarang" class="form-control" placeholder="Masukkan Kode Barang">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="input-group input-group-outline">
                            <label for="" class="col-4">Nama Barang</label>
                            <input type="text" readonly name="amNamaBarang" id="amNamaBarang" class="form-control" placeholder="Auto Load">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="input-group input-group-outline">
                            <label for="" class="col-4">Stok Barang</label>
                            <input type="text" readonly name="amStokBarang" id="amStokBarang" class="form-control" placeholder="Auto Load">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="input-group input-group-outline">
                            <label for="" class="col-4">Satuan</label>
                            <input type="text" readonly name="amSatuan" id="amSatuan" class="form-control" placeholder="Auto Load">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="input-group input-group-outline">
                            <label for="" class="col-4">Nama Pengambil</label>
                            <input type="text" name="namaPengambil" id="namaPengambil" class="form-control" placeholder="Masukkan nama yang mengambil barang">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="input-group input-group-outline">
                            <label for="" class="col-4">Jumlah Barang</label>
                            <input type="number" name="amJumlahBarang" id="amJumlahBarang" class="form-control" placeholder="Masukkan jumlah barang yang diambil">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="input-group input-group-outline">
                            <label for="" class="col-4">Waktu Ambil</label>
                            <input type="text" name="waktu" id="filter-date-3"  autocomplete="off" class="form-control" placeholder="Tanggal dan waktu ambil">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="input-group input-group-outline">
                            <label for="" class="col-4">Keperluan</label>
                            <textarea name="amKeperluan" id="amKeperluan" class="form-control" rows="3" placeholder="Masukkan keperluan (Contoh: Pembelajaran, Ekstrakurikuler, Rapat, Dll)"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" id="tombolSimpanAmbilBarang" class="btn bg-gradient-success">Simpan</button>
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

                                                <span data-idp="<?= $ps->idP; ?>" type="button" class="badge bg-danger tbmProsesPesanan">Proses Pesanan</span>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <tr>
                                        <td colspan="9" class="text-center text-secondary font-weight-bolder opacity-7">
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
        <!-- <div class="col-lg-4 col-md-6 mt-2">
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
        </div> -->
    </div>

</div>

<?= $this->endSection() ?>