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


    <div class="row mb-4 mt-5">
        <div class="col-lg-12 col-md-12 mb-md-0 mb-4">
            <div class="card">
                <div class="card-header p-3 pt-2 mb-1">
                    <div class="bg-gradient-info shadow-info text-center border-radius-xl mt-n4 p-3">
                        <i class="text-white" style="margin-top: 0; display:inline-block">Daftar Barang</i>
                    </div>

                </div>
                <div class="card-body px-0 pb-2">
                    <div class="table-responsive">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nama Barang</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Nama Pemesan</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Jumlah</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Keperluan</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Waktu</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="d-flex px-2 py-1">
                                            <div>
                                                <img src="/template/admin/assets/img/small-logos/logo-xd.svg" class="avatar avatar-sm me-3" alt="xd">
                                            </div>
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">Material XD Version</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="avatar-group mt-2">
                                            <a href="javascript:;" class="avatar avatar-xs rounded-circle" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Ryan Tompson">
                                                <img src="/template/admin/assets/img/team-1.jpg" alt="team1">
                                            </a>
                                            <a href="javascript:;" class="avatar avatar-xs rounded-circle" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Romina Hadid">
                                                <img src="/template/admin/assets/img/team-2.jpg" alt="team2">
                                            </a>
                                            <a href="javascript:;" class="avatar avatar-xs rounded-circle" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Alexander Smith">
                                                <img src="/template/admin/assets/img/team-3.jpg" alt="team3">
                                            </a>
                                            <a href="javascript:;" class="avatar avatar-xs rounded-circle" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Jessica Doe">
                                                <img src="/template/admin/assets/img/team-4.jpg" alt="team4">
                                            </a>
                                        </div>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <span class="text-xs font-weight-bold"> $14,000 </span>
                                    </td>
                                    <td class="align-middle">
                                        <div class="progress-wrapper w-75 mx-auto">
                                            <div class="progress-info">
                                                <div class="progress-percentage">
                                                    <span class="text-xs font-weight-bold">60%</span>
                                                </div>
                                            </div>
                                            <div class="progress">
                                                <div class="progress-bar bg-gradient-info w-60" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="align-middle">
                                        <div class="progress-wrapper w-75 mx-auto">
                                            <div class="progress-info">
                                                <div class="progress-percentage">
                                                    <span class="text-xs font-weight-bold">60%</span>
                                                </div>
                                            </div>
                                            <div class="progress">
                                                <div class="progress-bar bg-gradient-info w-60" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<?= $this->endSection() ?>