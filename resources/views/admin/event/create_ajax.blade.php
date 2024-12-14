<style>
    .modal-content {
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
    }

    .modal-header {
        /* background-color: #28a745; */
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

    .form-control {
        border-radius: 8px;
        box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.1);
    }

    .form-group label {
        font-weight: bold;
    }

    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
        transition: background-color 0.3s ease;
    }

    .btn-primary:hover {
        background-color: #0056b3;
    }

    .error-text {
        font-size: 0.9rem;
        color: #dc3545;
    }
</style>
<form action="{{ url('/event/ajax') }}" method="POST" id="form-tambah">
    @csrf
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="border-radius:15px;">
            <div class="modal-header bg-primary">
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
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label>Kode Event</label>
                        <input type="text" name="event_code" id="event_code" class="form-control"
                            placeholder="Isi kode event" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Point</label>
                        <input type="number" name="point" id="point" class="form-control" placeholder="Isi point" required>
                    </div>
                </div>

                <!-- Jenis Event -->
                <div class="form-group">
                    <label>Jenis Event</label>
                    <select name="jenis_event_id" id="jenis_event_id" class="form-control rounded" required>
                        <option value="">- Pilih Jenis Event -</option>
                        @foreach ($jenisEvent as $item)
                            @if($item->jenis_event_id != 3)
                            <option value="{{ $item->jenis_event_id }}">{{ $item->jenis_event_name }}</option>
                            @endif
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
                    <div class="item-row">
                        <div class="form-row">
                            <div class="form-group col-md-5">
                                <label>Jabatan</label>
                                <select name="participant[0][jabatan_id]]" class="form-control barang-select" required>
                                    <option value="">Pilih Jabatan</option>
                                    @foreach($jabatan as $j)
                                        <option value="{{ $j->jabatan_id }}">
                                            {{ $j->jabatan_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-5">
                                <label>Partisipan</label>
                                <select name="participant[0][user_id]]" class="form-control barang-select" required>
                                    <option value="">Pilih Dosen</option>
                                    @foreach($user as $dosen)
                                        <option value="{{ $dosen->user_id }}">
                                            {{ $dosen->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-1 d-flex align-items-center justify-content-center mt-4">
                                <label>&nbsp;</label>
                                <button type="button" class="btn btn-danger btn-remove-item">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                            <div class="form-group col-md-1 d-flex align-items-center justify-content-center mt-4">
                                <button type="button" class="btn btn-primary btn-sm" id="btn-add-item">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
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
    $(document).ready(function() {
        // Function to add a new field dynamically
        function addNewField() {
            const newField = $('.item-row:first').clone();

            // Reset values of the new field
            newField.find('select').val('');
            newField.find('input').val('');

            // Update the name attributes of the new field
            newField.find('[name]').each(function() {
                const oldName = $(this).attr('name');
                const newIndex = $('.item-row').length;
                $(this).attr('name', oldName.replace('[0]', '[' + newIndex + ']'));
            });

            // Add remove button functionality
            newField.find('.btn-remove-item').on('click', function() {
                if ($('.item-row').length > 1) {
                    $(this).closest('.item-row').remove();
                }
            });

            // Append the new field to the container
            $('#dynamic-fields').append(newField);
        }

        // Event listener for the "Add" button
        $(document).on('click', '#btn-add-item', function() {
            addNewField();
        });

        // Event listener for remove buttons (using event delegation)
        $(document).on('click', '.btn-remove-item', function() {
            if ($('.item-row').length > 1) {
                $(this).closest('.item-row').remove();
            }
        });

        // Form validation and submission
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
                    date: true,
                    greaterThan: "#start_date"
                },
                jenis_event_id: {
                    required: true,
                    number: true
                },

                point: {
                    required: true,
                    number: true
                },

                "participant[][jabatan_id]": {
                    required: true
                },
                "participant[][user_id]": {
                    required: true
                }
            },
            messages: {
                end_date: {
                    greaterThan: "End date must be after start date"
                }
            },
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
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Kesalahan',
                            text: 'Terjadi kesalahan saat mengirim data'
                        });
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

        // Custom validation method to check date
        $.validator.addMethod("greaterThan",
            function(value, element, params) {
                return new Date(value) >= new Date($(params).val());
            }
        );
    });
    </script>
