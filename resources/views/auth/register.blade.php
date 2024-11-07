<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>User Registration</title>
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- iCheck Bootstrap -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
    <!-- Theme Style -->
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
            font-family: 'Poppins', sans-serif; /* Font Poppins yang elegan */
        }

        .login-box {
            width: 500px; /* Membesarkan ukuran box */
            background-color: rgba(255, 255, 255, 0.9); /* Overlay putih transparan */
            padding: 40px; /* Padding lebih besar */
            border-radius: 15px; /* Membuat sudut kotak lebih halus */
            box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2); /* Efek bayangan */
        }

        .login-box .card {
            border: none;
        }

        .login-box .card-header {
            background-color: #66B9BF; /* Warna teal lebih lembut untuk mengurangi kontras */
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
            color: #ffffff; /* Warna teks tetap putih agar kontras dengan latar belakang */
            font-family: 'Poppins', sans-serif; /* Menggunakan font Poppins */
            font-weight: 700; /* Berat font yang tebal */
            /* text-transform: uppercase; Mengubah teks menjadi huruf kapital */
            font-size: 28px; /* Ukuran font yang cukup besar agar lebih jelas */
            letter-spacing: 1px;
            padding: 10px; /* Menambahkan padding agar teks terlihat lebih rapi */
            text-align: center; /* Memastikan teks berada di tengah */
        }


        .login-box .card-body {
            font-size: 16px;
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
            color: #07889B; /* Warna Teal untuk ikon */
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
                <p class="login-box-msg">Register a New User</p>
                <form method="POST" action="{{ url('register') }}" id="registration-form">
                    @csrf
                    <div class="input-group mb-3">
                        <select class="form-control" id="user_level" name="level_id" required>
                            <option value="">- Select Level -</option>
                            @foreach ($level as $levelItem)
                                <option value="{{ $levelItem->level_id }}">{{ $levelItem->level_nama }}</option>
                            @endforeach
                        </select>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-layer-group"></span>
                            </div>
                        </div>
                    </div>
                        @error('level_id')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    
                    <div class="input-group mb-3">
                        <input type="text" id="user_name" name="username" class="form-control" placeholder="Username" value="{{ old('username') }}" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                    </div>
                        @error('username')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    
                    <div class="input-group mb-3">
                        <input type="text" id="full_name" name="nama" class="form-control" placeholder="Full Name" value="{{ old('nama') }}" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-id-card"></span>
                            </div>
                        </div>
                    </div>
                        @error('nama')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    
                    <div class="input-group mb-3">
                        <input type="password" id="user_password" name="password" class="form-control" placeholder="Password" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                        @error('password')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    
                    <div class="row">
                        <div class="col-8">
                            <div class="icheck-primary">
                                <input type="checkbox" id="termsAgree" name="terms" value="agree">
                                <label for="termsAgree">
                                    I agree to the <a href="#">terms and conditions</a>
                                </label>
                            </div>
                        </div>
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block">Register</button>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-12 text-center">
                            <p>Already have an account? <a href="{{ url('login') }}">Log In</a></p>
                        </div>
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
    <!-- jQuery Validation -->
    <script src="{{ asset('adminlte/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/jquery-validation/additional-methods.min.js') }}"></script>
    <!-- SweetAlert2 -->
    <script src="{{ asset('adminlte/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('adminlte/dist/js/adminlte.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $("#registration-form").validate({
                rules: {
                    level_id: {
                        required: true,
                    },
                    username: {
                        required: true,
                        minlength: 4,
                        maxlength: 20
                    },
                    password: {
                        required: true,
                        minlength: 5,
                    }
                },
                submitHandler: function(form) {
                    $.ajax({
                        url: form.action,
                        type: form.method,
                        data: $(form).serialize(),
                        success: function(response) {
                            if (response.status) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success',
                                    text: response.message,
                                }).then(function() {
                                    window.location = response.redirect;
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error Occurred',
                                    text: response.message
                                });
                            }
                        }
                    });
                    return false;
                }
            });
        });
    </script>
</body>
</html>