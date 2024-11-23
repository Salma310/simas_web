<form action="{{ url('/role/store_ajax') }}" method="POST" id="form-tambah-role">
    @csrf
    <div id="modal-role" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data Role User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Nama Role</label>
                    <input value="" type="text" name="role_name" id="role_name" class="form-control" required>
                    <small id="error-role_name" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Kode Role</label>
                    <input value="" type="text" name="role_code" id="role_code" class="form-control" required>
                    <small id="error-role_code" class="error-text form-text text-danger"></small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-warning">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</form>

    <script>
        $(document).ready(function() {
            $("#form-tambah-role").validate({
                rules: {
                    role_name: {
                        required: true,
                        maxlength: 100
                    },
                    role_code: {
                        required: true,
                        minlength: 3,
                        maxlength: 10
                    },
                },
                submitHandler: function(form) {
                    $.ajax({
                        url: form.action,
                        type: form.method,
                        data: $(form).serialize(),
                        success: function(response) {
                            if (response.status) {
                                $('#roleModal').modal('hide');
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: response.message
                                });
                                dataRole.ajax.reload();
                            } else {
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
                    element.closest('.form-group').append(error);
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