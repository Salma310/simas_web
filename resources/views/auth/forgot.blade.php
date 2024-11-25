<!DOCTYPE html>
<html>
<head>
    <title>PORTAL SIMAS - Forgot Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="adminlte/plugins/fontawesome-free/css/all.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="adminlte/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="adminlte/dist/css/adminlte.min.css">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="adminlte/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
    <link rel="shortcut icon" href="adminlte/dist/img/logo-jti.png">
    <style>
        body {
            background-image: url('{{ asset('images/background.webp') }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            min-height: 100vh;
            font-family: 'Segoe UI', sans-serif;
        }

        .logo {
            position: absolute;
            top: 20px;
            left: 20px;
            z-index: 10;
            display: flex;
            flex-direction: column;
            /* Mengatur elemen secara vertikal */
            align-items: center;
            color: white;
            font-size: 1.2em;
            text-align: center;
        }

        .logo img {
            height: 60px;
            margin-bottom: 5px;
            /* Spasi antara gambar dan teks */
        }

        .logo-text {
            font-size: 1em;
            color: black;
            font-weight: bold;
        }

        .forgot-password-container {
            position: absolute;
            top: 50%;
            right: 10%;
            transform: translateY(-50%);
            width: 400px;
            padding: 30px;
            background: white;
            border-radius: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .form-title {
            color: #333;
            margin-bottom: 25px;
            font-weight: 600;
        }

        .form-control {
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 12px;
            margin-bottom: 15px;
        }

        .form-label {
            color: #666;
            margin-bottom: 8px;
            font-size: 0.9em;
        }

        .btn-confirm {
            background: #2196F3;
            color: white;
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 8px;
            font-weight: 500;
            margin-top: 10px;
        }

        .btn-confirm:hover {
            background: #1976D2;
            color: white;
        }

        .alert {
            border-radius: 8px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
<body>
    <div class="logo">
        <img src="{{ asset('images/jti.png') }}" alt="Logo">
        <div class="logo-text">PORTAL SIMAS</div>
    </div>

    <div class="forgot-password-container">
        <h1 class="form-title">Forgot Password</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" id="form-forgot" action="{{ route('password.reset') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label">Enter your email address</label>
                <input type="email" class="form-control" name="email" placeholder="Email address" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Enter your Password</label>
                <input type="password" class="form-control" name="password" placeholder="New password" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Enter your Confirm Password</label>
                <input type="password" class="form-control" name="password_confirmation" placeholder="Confirm new password" required>
            </div>

            <button type="submit" class="btn btn-confirm">Confirm</button>
            <div class="back-login text-center mt-3">
                <a href="{{ url('/login') }}" class=" text-decoration-none">Back to Login</a>
            </div>
        </form>
    </div>

    <!-- jQuery -->
    <script src="adminlte/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- jquery-validation -->
    <script src="adminlte/plugins/jquery-validation/jquery.validate.min.js"></script>
    <script src="adminlte/plugins/jquery-validation/additional-methods.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="adminlte/plugins/sweetalert2/sweetalert2.min.js"></script>
    <!-- AdminLTE App -->
    <script src="adminlte/dist/js/adminlte.min.js"></script>

    <script>
        $(document).ready(function() {
            $("#form-forgot").validate({
            rules: {
                email: {required: true, email: true},
                password: {required: true, minlength: 6, maxlength: 10},
                password_confirmation: {required: true, minlength: 6, maxlength: 10, equalTo: "#password"},
            },
            submitHandler: function(form) { // ketika valid, maka bagian yg akan dijalankan
                $.ajax({
                url: form.action,
                type: "POST",
                data: $(form).serialize(),
                success: function(response) {
                    if(response.status){ // jika sukses
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: response.message,
                    }).then(function() {
                        window.location = response.redirect;
                    });
                    }else{ // jika error
                    $('.error-text').text('');
                    $.each(response.msgField, function(prefix, val) {
                        $('#error-'+prefix).text(val[0]);
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
            errorPlacement: function (error, element) {
                error.addClass('invalid-feedback');
                element.closest('.input-group').append(error);
            },
            highlight: function (element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
            });
        });
    </script>
</body>
</html>