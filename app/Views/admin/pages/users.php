<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>
<div class="container-fluid py-4">

    <div class="row">
        <div class="col-12">
            <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modalTambahPengguna">Tambah User</button>
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">Tabel Pengguna</h6>
                    </div>
                </div>
                <div class="card-body px-0 pb-2">
                    <div class="table-responsive p-0 m-4">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7 ps-2">No</th>
                                    <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7 ps-2">Nama </th>
                                    <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7 ps-2">Email Login</th>
                                    <th class="text-uppercase text-secondary text-sm opacity-7 ps-2">Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                              <?php $no = 1; foreach ($users as $user) :?>
                                <tr>
                                    <td width="10px"><?= $no++;?></td>
                                    <td><?= $user->nama;?></td>
                                    <td><?= $user->email;?></td>
                                    <td>
                                        <span type="button" data-id="<?= $user->id;?>" class="badge bg-warning tombolUbahUser">Ubah</span>
                                        <span type="button" data-id="<?= $user->id;?>" class="badge bg-danger tombolHapusUser">Hapus</span>
                                    </td>
                                </tr>
                              <?php endforeach;?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>


        </div>
    </div>



</div>


<div class="modal fade" id="modalTambahPengguna" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-normal" id="exampleModalLabel">Tambah data pengguna</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
               
                <div class="modal-body">
                    <div class="row mb-2">
                        <div class="input-group input-group-outline">
                            <label for="" class="col-4">Email Login</label>
                            <input type="email" name="emailUser" id="emailUser" required class="form-control" placeholder="Masukkan Email Login User" >
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="input-group input-group-outline">
                            <label for="" class="col-4">Nama Pengguna</label>
                            <input type="text"  name="namaUser" id="namaUser" required class="form-control" placeholder="Masukkan nama user" >
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="input-group input-group-outline">
                            <label for="" class="col-4">Password Login</label>
                            <input type="text"  name="passwordUser" id="passwordUser" class="form-control" placeholder="Password Login">
                        </div>
                    </div>
                   
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn bg-gradient-warning" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" id="tombolSimpanUser" class="btn bg-gradient-success">Simpan</button>
                </div>
             
            </div>
        </div>
    </div>


<?= $this->endSection() ?>