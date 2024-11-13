<html>
<head>
    <style>
        body {
            background-color: #f8f9fa;
        }
        .modal-content {
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background-color: #ffffff;
        }
        .modal-header {
            border-bottom: none;
            background-color: #007bff;
            color: white;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .modal-title {
            margin: 0;
            font-size: 1.25rem;
        }
        .close {
            color: white;
            opacity: 0.8;
            font-size: 1.5rem;
            border: none;
            background: none;
        }
        .close:hover {
            color: white;
            opacity: 1;
        }
        .modal-body {
            padding: 20px;
        }
        .form-label {
            font-weight: bold;
            margin-bottom: 5px;
        }
        .form-control {
            border-radius: 5px;
            border: 1px solid #ced4da;
            padding: 10px;
            width: 100%;
            box-sizing: border-box;
        }
        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.25);
        }
        .error-text {
            font-size: 0.875rem;
            color: #dc3545;
            margin-top: 5px;
        }
        .modal-footer {
            border-top: none;
            padding: 15px 20px;
            display: flex;
            justify-content: flex-end;
        }
        .btn {
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .btn-yellow {
            background-color: #ffc107;
            color: black;
            margin-right: 10px;
        }
        .btn-yellow:hover {
            background-color: #e0a800;
        }
        .btn-blue {
            background-color: #007bff;
            color: white;
        }
        .btn-blue:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <!-- Modal -->
    <form action="{{ route('jenis.store') }}" method="POST" id="form-tambah">
        <div id="modal-master" class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="roleModalLabel">Tambah Data Jenis</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        &times;
                    </button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="jenis_event_code" class="form-label">Kode Jenis</label>
                        <input type="text" name="jenis_event_code" id="jenis_event_code" class="form-control" required>
                        <small id="error-jenis_event_code" class="error-text form-text text-danger"></small>
                    </div>
                    <div class="mb-3">
                        <label for="jenis_event_name" class="form-label">Nama Jenis</label>
                        <input type="text" name="jenis_event_name" id="jenis_event_name" class="form-control" required>
                        <small id="error-jenis_event_name" class="error-text form-text text-danger"></small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-yellow" data-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-blue" id="submit-btn">Tambah</button>
                </div>
            </div>
        </div>
    </form>
    <script>
        $(document).ready(function() {
            // Inisialisasi validasi pada form dengan ID "form-tambah"
            $("#form-tambah").validate({
                // Aturan validasi untuk setiap input
                rules: {
                    jenis_event_code: { required: true, minlength: 3, maxlength: 10 },
                    jenis_event_name: { required: true, minlength: 3, maxlength: 100 },
                },

                // Fungsi yang dijalankan ketika form berhasil lolos validasi
                submitHandler: function(form) {
                    // Mengirim data form ke server menggunakan AJAX
                    $.ajax({
                        url: form.action,               // URL tujuan pengiriman data
                        type: form.method,              // Metode pengiriman data (POST atau GET)
                        data: $(form).serialize(),      // Mengonversi data form ke format URL-encoded
                        success: function(response) {   // Fungsi callback ketika respons diterima
                            if (response.status) {      // Jika status respons berhasil
                                $('#jenisModal').modal('hide'); // Menutup modal form
                                Swal.fire({                 // Menampilkan pesan sukses
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: response.message
                                });
                                dataUser.ajax.reload();     // Memuat ulang tabel dataUser
                            } else {                        // Jika terdapat kesalahan
                                $('.error-text').text('');  // Mengosongkan pesan error sebelumnya
                                $.each(response.msgField, function(prefix, val) {
                                    $('#error-' + prefix).text(val[0]); // Menampilkan error pada input terkait
                                });
                                Swal.fire({                 // Menampilkan pesan kesalahan
                                    icon: 'error',
                                    title: 'Terjadi Kesalahan',
                                    text: response.message
                                });
                            }
                        }
                    });
                    return false; // Mencegah pengiriman form secara default
                },

                // Mengatur tampilan error pada elemen input
                errorElement: 'span', // Setiap pesan error ditempatkan dalam elemen <span>
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');       // Menambahkan kelas styling untuk error
                    element.closest('.form-group').append(error); // Menempatkan pesan error di elemen .form-group terdekat
                },

                // Menambahkan dan menghapus kelas "is-invalid" pada input yang divalidasi
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');        // Menambahkan kelas "is-invalid" pada input tidak valid
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');     // Menghapus kelas "is-invalid" pada input yang valid
                }
            });
        });
    </script>
</body>
</html>
