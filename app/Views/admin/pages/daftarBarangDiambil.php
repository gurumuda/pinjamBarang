<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>
<div class="container-fluid py-4">

    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">Tabel Daftar Pengambilan Barang Habis Pakai</h6>
                    </div>
                </div>
                <div class="card-body px-0 pb-2">
                    <div class="p-0 ms-4 m-2">
                        <a href="/admin/dwnBrgDiambil" class="btn bg-gradient-info">Unduh Semua Data</a>
                    </div>
                    <div class="table-responsive p-0 m-4">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7 ps-2">No</th>
                                    <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7 ps-2">Kode Barang</th>
                                    <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7 ps-2">Nama Barang</th>
                                    <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7 ps-2">Nama Pengambil</th>
                                    <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7 ps-2">Jml Ambil</th>
                                    <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7 ps-2">Tanggal Ambil</th>
                                    <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7 ps-2">Waktu Ambil</th>
                                    <th class="text-uppercase text-secondary text-sm opacity-7 ps-2">Keperluan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($ambil as $brg) : ?>
                                    <tr>
                                        <td class="text-xs"><?= $nomor++; ?></td>
                                        <td class="text-xs"><?= $brg->kodeBarang; ?></td>
                                        <td class="text-xs"><?= $brg->namaBarang; ?></td>
                                        <td class="text-xs"><?= $brg->namaPengambil; ?></td>
                                        <td class="text-xs"><?= $brg->jumlahBarang; ?></td>
                                        <td class="text-xs"><?= $brg->tanggalAmbil; ?></td>
                                        <td class="text-xs"><?= $brg->waktuAmbil; ?></td>
                                        <td class="text-xs"><?= $brg->keperluan; ?></td>

                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card-footer">
                    <?= $pager->links('dataAmbilBarang', 'my_pagination') ?>
                </div>

            </div>


        </div>
    </div>



</div>


<?= $this->endSection() ?>