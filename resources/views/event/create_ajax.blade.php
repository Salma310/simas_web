<form action="{{ url('/event/ajax') }}" method="POST" id="form-tambah">
    @csrf
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="border-radius:15px;">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Event</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="overflow-y: auto; max-height:600px; scrollbar-width: thin;">
                <!-- Nama Event -->
                <div class="form-group">
                    <label>Nama Event</label>
                    <input type="text" name="event_name" id="event_name" class="form-control"
                        placeholder="Isi nama event" required>
                </div>

                <!-- Kode Event -->
                <div class="form-group">
                    <label>Kode Event</label>
                    <input type="text" name="event_code" id="event_code" class="form-control"
                        placeholder="Isi kode event" required>
                </div>

                <!-- Jenis Event -->
                <div class="form-group">
                    <label>Jenis Event</label>
                    <select name="jenis_event_id" id="jenis_event_id" class="form-control rounded" required>
                        <option value="">- Pilih Level -</option>
                        @foreach ($jenisEvent as $item)
                            <option value="{{ $item->jenis_event_id }}">{{ $item->jenis_event_name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Tanggal Mulai dan Tanggal Selesai -->
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label>Tanggal Mulai</label>
                        <input type="date" name="start_date" id="start_date" class="form-control" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Tanggal Selesai</label>
                        <input type="date" name="end_date" id="end_date" class="form-control" required>
                    </div>
                </div>

                <!-- Deskripsi Event -->
                <div class="form-group">
                    <label>Deskripsi Event</label>
                    <textarea name="event_description" id="event_description" class="form-control" placeholder="Deskripsi event"
                        rows="3"></textarea>
                </div>

                <!-- Jabatan dan Partisipan -->
                <div id="dynamic-fields">
                    <div class="form-row align-items-center mb-2 dynamic-field">
                        <div class="form-group col-md-5">
                            <label>Jabatan</label>
                            <select name="jabatan_id[]" class="form-control" required>
                                <option value="">Pilih Jabatan</option>
                                @foreach ($jabatan as $j)
                                    <option value="{{ $j->jabatan_id }}">{{ $j->jabatan_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-5">
                            <label>Partisipan</label>
                            <select name="user_id[]" class="form-control" required>
                                <option value="">Pilih Dosen</option>
                                @foreach ($user as $dosen)
                                    <option value="{{ $dosen->user_id }}">{{ $dosen->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-1 d-flex align-items-center justify-content-center mt-4">
                            <button type="button" class="btn btn-secondary btn-sm" onclick="addField()"><i
                                    class="fa fa-plus"></i></button>
                        </div>
                        <div class="form-group col-md-1 d-flex align-items-center justify-content-center mt-4">
                            <button type="button" class="btn btn-danger btn-sm remove-field"><i
                                    class="fa fa-trash"></i></button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-warning">Batal</button>
                <button type="submit" class="btn btn-primary">Tambah</button>
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
