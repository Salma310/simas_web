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

    .btn-warning {
        background-color: #ffc107;
        border-color: #ffc107;
        transition: background-color 0.3s ease;
    }

    .btn-warning:hover {
        background-color: #e0a800;
    }

    .alert {
        border-radius: 8px;
    }
</style>

@empty($agenda)
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Kesalahan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    <h5><i class="icon fas fa-ban"></i> Kesalahan!!!</h5>
                    Data agenda yang anda cari tidak ditemukan
                </div>
                <button type="button" class="btn btn-warning" data-dismiss="modal">Kembali</button>
            </div>
        </div>
    </div>
@else
    <form action="{{ route('agenda.delete', ['id' => $agenda->event_id, 'id_agenda' => $agenda->agenda_id]) }}" method="POST" id="form-delete-agenda">
        @csrf
        @method('DELETE')
        <div id="modal-master" class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Hapus Data Agenda</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-warning">
                        <h5><i class="icon fas fa-exclamation-triangle"></i> Konfirmasi !!!</h5>
                        Apakah Anda yakin ingin menghapus agenda ini?
                    </div>
                    <table class="table table-sm table-bordered table-striped">
                        <tr>
                            <th class="text-right col-3">Nama Agenda:</th>
                            <td class="col-9">{{ $agenda->nama_agenda }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Tanggal Mulai:</th>
                            <td class="col-9">{{ \Carbon\Carbon::parse($agenda->start_date)->format('d-m-Y') }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Deadline:</th>
                            <td class="col-9">{{ \Carbon\Carbon::parse($agenda->end_date)->format('d-m-Y') }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Tempat:</th>
                            <td class="col-9">{{ $agenda->tempat }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Status:</th>
                            <td class="col-9">{{ $agenda->status }}</td>
                        </tr>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Ya, Hapus</button>
                </div>
            </div>
        </div>
    </form>

    <script>
        $(document).ready(function() {
            $("#form-delete-agenda").validate({
                submitHandler: function(form) {
                    $.ajax({
                        url: form.action,
                        type: form.method,
                        data: $(form).serialize(),
                        success: function(response) {
                            if (response.status) {
                                $('#agendaModal').modal('hide');
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: response.message
                                });
                                agendaTable.ajax.reload();
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Terjadi Kesalahan',
                                    text: response.message
                                });
                            }
                        },
                        error: function(xhr) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: xhr.responseJSON.message || 'Terjadi kesalahan pada server'
                            });
                        }
                    });
                    return false;
                }
            });
        });
    </script>
@endempty
