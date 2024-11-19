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
    <form action="{{ url('/event/' . $event->event_id . '/update_ajax') }}" method="POST" id="form-edit">
        @csrf
        @method('PUT')
        <div id="modal-master" class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Data Event</h5>
                    <button type="button" class="close" data-dismiss="modal" arialabel="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body" style="overflow-y: auto; max-height:600px; scrollbar-width: thin;">
                    <div class="form-group">
                        <label>Nama Event</label>
                        <input value=" {{ $event->event_name }}" type="text" name="event_name" id="event_name"
                            class="form-control" required>
                        <small id="error-event_name" class="error-text form-text text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label>Kode Event</label>
                        <input value="{{ $event->event_code }}" type="text" name="event_code" id="event_code"
                            class="form-control" required>
                        <small id="error-event_code" class="error-text form-text text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label>Jenis Event</label>
                        <select name="jenis_event_id" id="jenis_event_id" class="form-control" required>
                            @foreach ($jenisEvent as $l)
                            <option {{ $l->jenis_event_id == $event->kategori_id ? 'selected' : '' }}
                                value="{{ $l->jenis_event_id }}">{{ $l->jenis_event_name }}</option>
                            @endforeach
                        </select>
                        <small id="error-jenis_event_id" class="error-text form-text text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label>Tanggal Mulai</label>
                        <input value="{{ $event->start_date }}" type="date" name="start_date" id="start_date" class="form-control" required>
                        <small id="error-start_date" class="error-text form-text text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label>Tanggal Selesai</label>
                        <input value="{{ $event->end_date }}" type="date" name="end_date" id="end_date" class="form-control" required>
                        <small id="error-end_date" class="error-text form-text text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label>Deskripsi Event</label>
                        <textarea name="event_description" id="event_description" class="form-control" placeholder="Deskripsi event"
                        rows="3">{{ $event->event_description }}</textarea>
                        <small id="error-event_description" class="error-text form-text text-danger"></small>
                    </div>
                    <div id="dynamic-fields">
                        @foreach ($eventParticipant as $participant)
                        <div class="form-row align-items-center mb-2 dynamic-field">
                            <div class="form-group col-md-5">
                                <label>Jabatan</label>
                                <select name="jabatan_id[]" class="form-control" required>
                                    <option value="">Pilih Jabatan</option>
                                    @foreach ($jabatan as $j)
                                    <option value="{{ $j->jabatan_id }}" 
                                        {{ $j->jabatan_id == $participant->jabatan_id ? 'selected' : '' }}>
                                        {{ $j->jabatan_name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-5">
                                <label>Partisipan</label>
                                <select name="user_id[]" class="form-control" required>
                                    <option value="">Pilih Dosen</option>
                                    @foreach ($user as $dosen)
                                    <option value="{{ $dosen->user_id }}" 
                                        {{ $dosen->user_id == $participant->user_id ? 'selected' : '' }}>
                                        {{ $dosen->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-1 d-flex align-items-center justify-content-center mt-3">
                                <button type="button" class="btn btn-secondary btn-sm" onclick="addField()">
                                    <i class="fa fa-plus"></i>
                                </button>
                            </div>
                            <div class="form-group col-md-1 d-flex align-items-center justify-content-center mt-3">
                                <button type="button" class="btn btn-danger btn-sm remove-field">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </div>
                        </div>
                        @endforeach
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
        // Fungsi menambahkan field baru
    function addField() {
        const newField = `
        <div class="form-row align-items-center mb-2 dynamic-field">
            <div class="form-group col-md-5">
                <select name="jabatan_id[]" class="form-control" required>
                    <option value="">Pilih Jabatan</option>
                    @foreach ($jabatan as $j)
                        <option value="{{ $j->jabatan_id }}">{{ $j->jabatan_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-md-5">
                <select name="user_id[]" class="form-control" required>
                    <option value="">Pilih Dosen</option>
                    @foreach ($user as $dosen)
                        <option value="{{ $dosen->user_id }}">{{ $dosen->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-md-1 d-flex align-items-center justify-content-center mt-1">
                <button type="button" class="btn btn-secondary btn-sm" onclick="addField()"><i class="fa fa-plus"></i></button>
            </div>
            <div class="form-group col-md-1 d-flex align-items-center justify-content-center mt-1">
                <button type="button" class="btn btn-danger btn-sm remove-field"><i class="fa fa-trash"></i></button>
            </div>
        </div>
    `;
        $('#dynamic-fields').append(newField);
    }

    // Fungsi untuk menghapus field
    $(document).on('click', '.remove-field', function() {
        $(this).closest('.dynamic-field').remove();
    });

    $(document).ready(function() {
        $("#form-tambah").validate({
            rules: {
                event_name: {
                    required: true,
                    minlength: 3,
                    maxlength: 100
                },
                event_code: {
                    required: true,
                    minlength: 3,
                    maxlength: 10
                },
                event_description: {
                    required: true,
                },
                start_date: {
                    required: true,
                    date: true
                },
                end_date: {
                    required: true,
                    date: true
                },
                jenis_event_id: {
                    required: true,
                    number: true
                },
                "user_id[]": {
                    required: true,
                    number: true
                }, 
                "jabatan_id[]": {
                    required: true,
                    number: true
                }
            },
            submitHandler: function(form) {
                $.ajax({
                    url: form.action,
                    type: form.method,
                    data: $(form).serialize(),
                    success: function(response) {
                        if (response.status) {
                            $('#myModal').modal('hide');
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
