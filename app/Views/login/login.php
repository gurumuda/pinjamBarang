<!DOCTYPE html>
<html lang="en">

<head>
    <title>Login | Aplikasi Inventaris Barang</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--===============================================================================================-->
    <link rel="icon" type="image/png" href="favicon.ico" />
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="/template/login/vendor/bootstrap/css/bootstrap.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="/template/login/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="/template/login/fonts/iconic/css/material-design-iconic-font.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="/template/login/vendor/animate/animate.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="/template/login/vendor/css-hamburgers/hamburgers.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="/template/login/vendor/animsition/css/animsition.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="/template/login/vendor/select2/select2.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="/template/login/vendor/daterangepicker/daterangepicker.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="/template/login/css/util.css">
    <link rel="stylesheet" type="text/css" href="/template/login/css/main.css">
    <!--===============================================================================================-->
</head>

<body>

    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100">
                <?= form_open('login/proses', 'class="login100-form validate-form"'); ?>

                <span class="login100-form-title p-b-26">
                    Selamat Datang
                </span>
                <!-- <span class="login100-form-title p-b-48">
                        <i class="zmdi zmdi-font"></i>
                    </span> -->
                <br>
                <div class="wrap-input100 validate-input" data-validate="Masukkan email valid">
                    <input class="input100" type="text" name="email" id="email" autofocus>
                    <span id="labelEmail" class="focus-input100" data-placeholder="Email"></span>
                </div>

                <div class="wrap-input100 validate-input" data-validate="Masukkan kata sandi">
                    <span class="btn-show-pass">
                        <i class="zmdi zmdi-eye"></i>
                    </span>
                    <input class="input100" type="password" name="pass">
                    <span class="focus-input100" data-placeholder="Password"></span>
                </div>

                <div class="container-login100-form-btn">
                    <div class="wrap-login100-form-btn">
                        <div class="login100-form-bgbtn"></div>
                        <button class="login100-form-btn">
                            Login
                        </button>
                    </div>
                </div>

                <!-- <div class="text-center p-t-115">
                        <span class="txt1">
                            Don’t have an account?
                        </span>

                        <a class="txt2" href="#">
                            Sign Up
                        </a>
                    </div> -->
                <?= form_close(); ?>
                </form>
            </div>
        </div>
    </div>


    <div id="dropDownSelect1"></div>

    <!--===============================================================================================-->
    <script src="/template/login/js/jquery-3.6.3.js"></script>
    <!--===============================================================================================-->
    <script src="/template/login/vendor/animsition/js/animsition.min.js"></script>
    <!--===============================================================================================-->
    <script src="/template/login/vendor/bootstrap/js/popper.js"></script>
    <script src="/template/login/vendor/bootstrap/js/bootstrap.min.js"></script>
    <!--===============================================================================================-->
    <script src="/template/login/vendor/select2/select2.min.js"></script>
    <!--===============================================================================================-->
    <script src="/template/login/vendor/daterangepicker/moment.min.js"></script>
    <script src="/template/login/vendor/daterangepicker/daterangepicker.js"></script>
    <!--===============================================================================================-->
    <script src="/template/login/vendor/countdowntime/countdowntime.js"></script>
    <!--===============================================================================================-->
    <script src="/template/login/js/main.js"></script>


    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <?php if (session()->getFlashdata('pesan')) : ?>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '<?= session()->getFlashdata("pesan"); ?>'

            })
        </script>
    <?php endif; ?>
</body>

</html>