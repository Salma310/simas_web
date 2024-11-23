<style>
    .modal-content {
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
    }

    .modal-header {
        background-color: #dc3545;
        color: white;
        border-top-left-radius: 12px;
        border-top-right-radius: 12px;
    }

    .modal-title {
        font-weight: bold;
    }

    .modal-body {
        padding: 20px;
        background-color: #f9f9f9;
    }

    .btn-danger {
        background-color: #ffc107;
        border-color: #ffc107;
        transition: background-color 0.3s ease;
    }

    .btn-danger:hover {
        background-color: #e0a800;
    }

    .alert {
        border-radius: 8px;
    }
</style>
@empty($event)
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Kesalahan</h5>
                <button type="button" class="close" data-dismiss="modal" arialabel="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    <h5><i class="icon fas fa-ban"></i> Kesalahan!!!</h5>
                    Data yang anda cari tidak ditemukan
                </div>
                <a href="{{ url('/event') }}" class="btn btn-warning">Kembali</a>
            </div>
        </div>
    </div>
@else
    <form action="{{ url('/event/' . $event->event_id . '/delete_ajax') }}" method="POST" id="form-delete">
        @csrf
        @method('DELETE')
        <div id="modal-master" class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Hapus Data Event</h5>
                    <button type="button" class="close" data-dismiss="modal" arialabel="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-warning">
                        <h5><i class="icon fas fa-ban"></i> Konfirmasi !!!</h5>
                        Apakah Anda ingin menghapus data seperti di bawah ini?
                    </div>
                    <table class="table table-sm table-bordered table-striped">
                        <tr>
                            <th class="text-right col-3">Nama Event :</th>
                            <td class="col-9">{{ $event->event_name }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Kode Event:</th>
                            <td class="col-9">{{ $event->event_code }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Jenis Event:</th>
                            <td class="col-9">{{ $event->jenisEvent->jenis_event_name }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Tanggal Mulai :</th>
                            <td class="col-9">{{ $event->start_date }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Tanggal Selesai :</th>
                            <td class="col-9">{{ $event->end_date }}</td>
                        </tr>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-warning">Batal</button>
                    <button type="submit" class="btn btn-primary">Ya, Hapus</button>
                </div>
            </div>
        </div>
    </form>
    <script>
        $(document).ready(function() {
            $("#form-delete").validate({
                rules: {},
                submitHandler: function(form) {
                    $.ajax({
                        url: form.action,
                        type: form.method,
                        data: $(form).serialize(),
                        success: function(response) {
                            if (response.status) {
                                $('#eventModal').modal('hide');
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: response.message
                                });
                                dataEvent.ajax.reload();
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
@endempty
