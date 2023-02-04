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
                                    <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7 ps-2">Jumlah</th>
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
                                        <td class="text-xs"><?= $brg->tanggalPinjam; ?></td>
                                        <td class="text-xs"><?= $brg->waktuPinjam; ?></td>
                                        <td class="text-xs"><?= $brg->keperluan; ?></td>
                                        <td class="text-xs"><?= ($brg->status == '1') ? '<span class="badge bg-success">Kembali</span>' : '<span class="badge bg-warning">Belum Kembali</span>'; ?></td>
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