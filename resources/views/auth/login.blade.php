<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Pengguna</title>
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.min.css') }}">
    <style>
         body {
            background-image: url('{{ asset('background2.jpg') }}'); /* URL gambar background */
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            font-family: 'Poppins', sans-serif; /* Menggunakan font Poppins */
        }

        .login-box {
            width: 500px; /* Membesarkan ukuran box */
            background-color: rgba(255, 255, 255, 0.9); /* Overlay putih transparan */
            padding: 40px; /* Padding lebih besar */
            border-radius: 15px; /* Membuat sudut kotak lebih halus */
            box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2); /* Efek bayangan */
        }

        .login-box .card {
            border: none; /* Menghilangkan border dari card */
            box-shadow: none; /* Menghilangkan bayangan default */
            background: transparent; /* Menghilangkan latar belakang jika diperlukan */
        }

        .login-box .card-header {
            background-color: #66B9BF; /* Warna teal lebih lembut */
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
            color: #ffffff; /* Warna teks putih agar kontras */
            font-weight: 700; /* Berat font yang tebal */
            /* text-transform: uppercase; */
            font-size: 28px; /* Ukuran font yang cukup besar */
            letter-spacing: 1px;
            padding: 10px;
            text-align: center;
            border-bottom: none; /* Menghilangkan garis bawah default */
            margin-top: -10px; /* Menggeser header untuk menutup elemen di belakang */
            margin-bottom: -10px;
        }

        .login-box .card-body {
            padding: 20px; /* Mengurangi padding jika terlalu besar */
        }


        .login-box .card-header a {
            text-decoration: none; /* Menghapus garis bawah link */
            outline: none; /* Menghapus outline default */
            color: #ffffff; /* Warna teks putih agar lebih kontras */
        }

        .login-box .card-header a:focus {
            outline: none; /* Menghapus outline saat elemen dalam keadaan fokus */
        }

        .btn-primary {
            background-color: #07889B; /* Warna Teal */
            border-color: #07889B;
            color: white;
            transition: background-color 0.3s ease;
            font-weight: 600;
            border-radius: 25px; /* Membuat tombol lebih bulat */
        }

        .btn-primary:hover {
            background-color: #066A7F; /* Warna Teal lebih gelap saat hover */
            border-color: #066A7F;
        }

        .input-group .form-control {
            border-radius: 25px; /* Membulatkan tepi input field */
            padding-left: 20px;
            font-size: 16px;
        }

        .input-group-text {
            border-radius: 25px; /* Membuat ikon lebih halus */
            background-color: #f7f7f7;
            color: #07889B; /* Warna teal untuk ikon */
        }

        .icheck-primary input {
            background-color: #07889B;
        }

        .login-box a {
            color: #07889B; /* Menyelaraskan warna link dengan tema */
        }

        .login-box a:hover {
            color: #066A7F; /* Efek hover pada link */
        }

        .login-box p {
            font-size: 16px;
            margin-top: 20px;
        }
    </style>
</head>
<body class="hold-transition login-page">
    <div class="login-box">
        <!-- /.login-logo -->
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <a href="{{ url('/') }}" class="h1"><b>Happy</b>Market</a>
            </div>
            <div class="card-body">
                <p class="login-box-msg">Login untuk masuk ke Sistem</p>
                <form action="{{ url('login') }}" method="POST" id="form-login">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="text" id="username" name="username" class="form-control" placeholder="Username">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                        <small id="error-username" class="error-text text-danger"></small>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" id="password" name="password" class="form-control" placeholder="Password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                        <small id="error-password" class="error-text text-danger"></small>
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <div class="icheck-primary">
                                <input type="checkbox" id="remember">
                                <label for="remember">Remember Me</label>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                        </div>
                        <!-- /.col -->
                        <br><br><br>
                        <p>Dont have an account? <a href="{{ url('/register') }}">Register</a></p>

                    </div>
                </form>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.login-box -->

    <!-- jQuery -->
    <script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- jquery-validation -->
    <script src="{{ asset('adminlte/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/jquery-validation/additional-methods.min.js') }}"></script>
    <!-- SweetAlert2 -->
    <script src="{{ asset('adminlte/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('adminlte/dist/js/adminlte.min.js') }}"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).ready(function() {
            $("#form-login").validate({
                rules: {
                    username: { required: true, minlength: 4, maxlength: 20 },
                    password: { required: true, minlength: 5, maxlength: 20 }
                },
                submitHandler: function(form) { // ketika valid, maka bagian yg akan dijalankan
                    $.ajax({
                        url: form.action,
                        type: form.method,
                        data: $(form).serialize(),
                        success: function(response) {
                            if (response.status) { // jika sukses
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: response.message,
                                }).then(function() {
                                    window.location = response.redirect;
                                });
                            } else { // jika error
                                $('.error-text').text('');
                                $.each(response.msgField, function(prefix, val) {
                                    $('#error-' + prefix).text(val[0]);
                                });
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Terjadi Kesalahan',
                                    text: response.message
                                });
                            }
                        }
                    });
                    return false;
                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.input-group').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                }
            });
        });
    </script>
</body>
</html>
