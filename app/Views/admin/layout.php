<!--
=========================================================
* Material Dashboard 2 - v3.0.4
=========================================================

* Product Page: https://www.creative-tim.com/product/material-dashboard
* Copyright 2022 Creative Tim (https://www.creative-tim.com)
* Licensed under MIT (https://www.creative-tim.com/license)
* Coded by Creative Tim

=========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
-->


<?php
$uri = service('uri');; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="/template/admin/assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="/template/admin/assets/img/favicon.png">
    <title>
        Halaman Administrator
    </title>
    <!--     Fonts and icons     -->
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />
    <!-- Nucleo Icons -->
    <link href="/template/admin/assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="/template/admin/assets/css/nucleo-svg.css" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
    <!-- CSS Files -->
    <link id="pagestyle" href="/template/admin/assets/css/material-dashboard.css?v=3.0.4" rel="stylesheet" />
    <link rel="stylesheet" href="/template/myscript/datetimepicker-master/jquery.datetimepicker.css" />
</head>

<body class="g-sidenav-show  bg-gray-200">
    <aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3   bg-gradient-dark" id="sidenav-main">
        <div class="sidenav-header">
            <i class="fas fa-times p-3 cursor-pointer text-white opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
            <a class="navbar-brand m-0" href=" https://demos.creative-tim.com/material-dashboard/pages/dashboard " target="_blank">
                <img src="/template/admin/assets/img/logo-ct.png" class="navbar-brand-img h-100" alt="main_logo">
                <span class="ms-1 font-weight-bold text-white">Halaman Administrator</span>
            </a>
        </div>
        <hr class="horizontal light mt-0 mb-2">
        <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link text-white <?= ($uri->getSegment(2) == '') ? 'active' : ''; ?>" href="/admin">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">dashboard</i>
                        </div>
                        <span class="nav-link-text ms-1">Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white <?= ($uri->getSegment(2) == 'daftarBarang') ? 'active' : ''; ?>" href="/admin/daftarBarang">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">table_view</i>
                        </div>
                        <span class="nav-link-text ms-1">Daftar Barang</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white <?= ($uri->getSegment(2) == 'daftarBarangDipinjam') ? 'active' : ''; ?>" href="/admin/daftarBarangDipinjam">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">shopping_cart_checkout</i>
                        </div>
                        <span class="nav-link-text ms-1">Barang Dipinjam</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white <?= ($uri->getSegment(2) == 'daftarBarangDiambil') ? 'active' : ''; ?>" href="/admin/daftarBarangDiambil">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">sync_disabled</i>
                        </div>
                        <span class="nav-link-text ms-1">Barang Diambil</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white " href="/admin/logout">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">logout</i>
                        </div>
                        <span class="nav-link-text ms-1">Keluar Aplikasi</span>
                    </a>
                </li>
            </ul>
        </div>

    </aside>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" data-scroll="true">
            <div class="container-fluid py-1 px-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                        <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Pages</a></li>

                    </ol>
                    <h6 class="font-weight-bolder mb-0"><?= halaman($uri->getSegment(2)) ;?></h6>
                </nav>
                <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">


                    <div class="ms-md-auto pe-md-3 d-flex align-items-center">
                        <?php if ($uri->getSegment(2) == 'daftarBarang') : ?>
                            <?= form_open(''); ?>
                            <div class="input-group input-group-outline">
                                <label class="form-label">Pencarian...</label>
                                <input type="text" name="search" id="search" class="form-control">
                            </div>
                            <?= form_close(); ?>
                        <?php endif; ?>
                    </div>


                    <ul class="navbar-nav  justify-content-end">


                        <li class="nav-item dropdown pe-2 d-flex align-items-center">
                            <a href="javascript:;" class="nav-link text-body p-0" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa fa-bell cursor-pointer"></i>
                            </a>
                            <ul class="dropdown-menu  dropdown-menu-end  px-2 py-3 me-sm-n4" aria-labelledby="dropdownMenuButton">
                                <li class="mb-0">
                                    <a class="dropdown-item border-radius-md" href="javascript:;">
                                        <div class="d-flex py-1">
                                            <div class="my-auto">
                                                <span class="fa fa-envelope me-3"></span>
                                                <!-- <img src="/template/admin/assets/img/team-2.jpg" class="avatar avatar-sm  me-3 "> -->
                                            </div>
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="text-sm font-weight-normal mb-1">
                                                    <span class="font-weight-bold">No new message</span>
                                                </h6>
                                                <!-- <p class="text-xs text-secondary mb-0">
                                                    <i class="fa fa-clock me-1"></i>
                                                    13 minutes ago
                                                </p> -->
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <!-- <li class="mb-2">
                                    <a class="dropdown-item border-radius-md" href="javascript:;">
                                        <div class="d-flex py-1">
                                            <div class="my-auto">
                                                <img src="/template/admin/assets/img/team-2.jpg" class="avatar avatar-sm  me-3 ">
                                            </div>
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="text-sm font-weight-normal mb-1">
                                                    <span class="font-weight-bold">New message</span> from Laur
                                                </h6>
                                                <p class="text-xs text-secondary mb-0">
                                                    <i class="fa fa-clock me-1"></i>
                                                    13 minutes ago
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </li> -->
                             
                            </ul>
                        </li>
                        <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
                            <a href="javascript:;" class="nav-link text-body p-0" id="iconNavbarSidenav">
                                <div class="sidenav-toggler-inner">
                                    <i class="sidenav-toggler-line"></i>
                                    <i class="sidenav-toggler-line"></i>
                                    <i class="sidenav-toggler-line"></i>
                                </div>
                            </a>
                        </li>

                    </ul>
                </div>
            </div>
        </nav>
        <!-- End Navbar -->

        <?= $this->renderSection('content') ?>


        <footer class="footer py-4  ">
            <div class="container-fluid">
                <div class="row align-items-center justify-content-lg-between">
                    <div class="col-lg-6 mb-lg-0 mb-4">
                        <div class="copyright text-center text-sm text-muted text-lg-start">
                            © <script>
                                document.write(new Date().getFullYear())
                            </script>,
                            made with <i class="fa fa-heart"></i> by
                            <a href="https://www.creative-tim.com" class="font-weight-bold" target="_blank">Creative Tim</a>
                            for a better web.
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <ul class="nav nav-footer justify-content-center justify-content-lg-end">
                            <li class="nav-item">
                                <a href="https://www.creative-tim.com" class="nav-link text-muted" target="_blank">Creative Tim</a>
                            </li>
                            <li class="nav-item">
                                <a href="https://www.creative-tim.com/presentation" class="nav-link text-muted" target="_blank">About Us</a>
                            </li>
                            <li class="nav-item">
                                <a href="https://www.creative-tim.com/blog" class="nav-link text-muted" target="_blank">Blog</a>
                            </li>
                            <li class="nav-item">
                                <a href="https://www.creative-tim.com/license" class="nav-link pe-0 text-muted" target="_blank">License</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </footer>
    </main>

    <div class="modal fade" id="setAdmin" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content bg-gradient-info">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-normal" id="exampleModalLabel">Pengaturan Akun Admin</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <?= form_open('/admin/updatePengguna'); ?>
                <div class="modal-body">
                    <div class="row mb-2">
                        <div class="input-group input-group-outline">
                            <label for="" class="col-4">Email Login</label>
                            <input type="email" name="email" id="email" required class="form-control" placeholder="Masukkan Email Login Admin" value="<?= $admin->email ;?>">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="input-group input-group-outline">
                            <label for="" class="col-4">Nama Administrator</label>
                            <input type="text"  name="nama" id="nama" required class="form-control" placeholder="Masukkan nama administrator" value="<?= $admin->nama ;?>">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="input-group input-group-outline">
                            <label for="" class="col-4">Password Login</label>
                            <input type="text"  name="password" id="password" class="form-control" placeholder="Password Login">
                        </div>
                    </div>
                   
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn bg-gradient-warning" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn bg-gradient-success">Simpan</button>
                </div>
                <?= form_close(); ?>
            </div>
        </div>
    </div>


    <div class="fixed-plugin">
        <a class="fixed-plugin-button text-white bg-warning position-fixed px-3 py-2">
            <i class="material-icons py-2">settings</i>
        </a>
        <div class="card shadow-lg" style="background-color: aqua;">
            <div class="card-header pb-0 pt-3" style="background-color: aqua;">
                <div class="float-start">
                    <h5 class="mt-3 mb-0">Pengaturan</h5>
                </div>
                <div class="float-end mt-4">
                    <button class="btn btn-link text-dark p-0 fixed-plugin-close-button">
                        <i class="material-icons">clear</i>
                    </button>
                </div>
                <!-- End Toggle Button -->
            </div>
            <hr class="horizontal dark my-1">
            <div class="card-body pt-sm-3 pt-0">
                <!-- Sidebar Backgrounds -->
                <div class="mb-0">
                <button class="btn bg-gradient-danger text-white" data-bs-toggle="modal" data-bs-target="#setAdmin"><i class="material-icons opacity-10 text-white">settings</i> Akun Admin</button>
                <a href="/admin/users" class="btn bg-gradient-primary text-white"><i class="material-icons opacity-10 text-white">people</i> Pengguna</a>
                </div>
                <hr class="horizontal dark my-sm-4">
                <div>
                    <h6 class="mb-0">Sidebar Colors</h6>
                </div>
                <a href="javascript:void(0)" class="switch-trigger background-color">
                    <div class="badge-colors my-2 text-start">
                        <span class="badge filter bg-gradient-primary active" data-color="primary" onclick="sidebarColor(this)"></span>
                        <span class="badge filter bg-gradient-dark" data-color="dark" onclick="sidebarColor(this)"></span>
                        <span class="badge filter bg-gradient-info" data-color="info" onclick="sidebarColor(this)"></span>
                        <span class="badge filter bg-gradient-success" data-color="success" onclick="sidebarColor(this)"></span>
                        <span class="badge filter bg-gradient-warning" data-color="warning" onclick="sidebarColor(this)"></span>
                        <span class="badge filter bg-gradient-danger" data-color="danger" onclick="sidebarColor(this)"></span>
                    </div>
                </a>
                <!-- Sidenav Type -->
               
                <hr class="horizontal dark my-sm-4">
                <h6 class="mt-3">Follow And Support Me</h6>
                <a class="btn bg-gradient-info w-45" target="_blank" href="https://www.youtube.com/channel/UCGHEa18bAd6jmmamIV4EmWQ">Youtube</a>
                <a class="btn bg-gradient-success w-45" target="_blank" href="https://github.com/gurumuda/pinjamBarang">GitHub</a>
                <div style="position:absolute; bottom: 10px">
                    
                    <h6 class="mt-3">Thank you Using this App!</h6>
                    <a href="https://t.me/yuwandianto" target="_blank" class="btn btn-dark btn-sm mb-0 me-2" target="_blank">
                        <i class="fab fa-telegram me-1" aria-hidden="true"></i> Telegram
                    </a>
                </div>
            </div>
        </div>
    </div>


    <div class="position-fixed top-1 end-1" style="z-index: 100000;">
        <div class="toast fade hide p-2 mt-2 bg-gradient-info" role="alert" aria-live="assertive" id="infoToast" aria-atomic="true" data-bs-delay="10000">
            <div class="toast-header bg-transparent border-0">
                <i class="material-icons text-white me-2">
                    notifications
                </i>
                <span class="me-auto text-white font-weight-bold">Info </span>
                <small class="text-white">1 second ago</small>
                <i class="fas fa-times text-md text-white ms-3 cursor-pointer" data-bs-dismiss="toast" aria-label="Close"></i>
            </div>
            <hr class="horizontal light m-0">
            <div class="toast-body text-white">
                <span id="pesanSukses"></span>
            </div>
        </div>
    </div>

    <!--   Core JS Files   -->
    <script src="/template/admin/assets/js/core/popper.min.js"></script>
    <script src="/template/admin/assets/js/core/bootstrap.min.js"></script>
    <script src="/template/admin/assets/js/plugins/perfect-scrollbar.min.js"></script>
    <script src="/template/admin/assets/js/plugins/smooth-scrollbar.min.js"></script>
    <script src="/template/admin/assets/js/plugins/chartjs.min.js"></script>

 
    <!-- Github buttons -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
    <!-- <script src="/template/admin/assets/js/material-dashboard.min.js?v=3.0.4"></script> -->
    <script src="/template/myscript/jquery-3.6.3.min.js"></script>
    <script src="/template/myscript/datetimepicker-master/jquery.datetimepicker.full.js"></script>
    <script src="/template/myscript/datetimepicker-master/jquery.datetimepicker.js"></script>
    <script src="/template/admin/assets/js/material-dashboard.js"></script>

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script src="/template/myscript/admin.js"></script>

    <?php if (session()->getFlashdata('pesan')) : ?>
        <script>
            Swal.fire({
                icon: '<?= session()->getFlashdata('tipe'); ?>',
                text: '<?= session()->getFlashdata('pesan'); ?>'
            })
        </script>
    <?php endif; ?>
    <script>
        /*jslint browser:true*/
        /*global jQuery, document*/

        jQuery(document).ready(function() {
            'use strict';

            jQuery('#filter-date, #filter-date-2, #filter-date-3, #search-from-date, #search-to-date').datetimepicker();
        });
    </script>

</body>

</html>