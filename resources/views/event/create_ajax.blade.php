<form action="{{ url('/event/') }}" method="POST" id="form-tambah">
    @csrf
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Event</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Nama Event -->
                <div class="form-group">
                    <label>Nama Event</label>
                    <input type="text" name="nama_event" id="nama_event" class="form-control" placeholder="Isi nama event" required>
                </div>

                <!-- Kode Event -->
                <div class="form-group">
                    <label>Kode Event</label>
                    <input type="text" name="kode_event" id="kode_event" class="form-control" placeholder="Isi kode event" required>
                </div>

                <!-- Jenis Event -->
                <div class="form-group">
                    <label>Jenis Event</label>
                    <select name="jenis_event" id="jenis_event" class="form-control" required>
                        <option value="">Pilih Jenis Event</option>
                        <!-- Options dapat diisi sesuai kebutuhan -->
                    </select>
                </div>

                <!-- Tanggal Mulai dan Tanggal Selesai -->
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label>Tanggal Mulai</label>
                        <input type="date" name="tanggal_mulai" id="tanggal_mulai" class="form-control" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Tanggal Selesai</label>
                        <input type="date" name="tanggal_selesai" id="tanggal_selesai" class="form-control" required>
                    </div>
                </div>

                <!-- Deskripsi Event -->
                <div class="form-group">
                    <label>Deskripsi Event</label>
                    <textarea name="deskripsi_event" id="deskripsi_event" class="form-control" placeholder="Deskripsi event" rows="3"></textarea>
                </div>

                <!-- Jabatan dan Partisipan (Dapat Ditambah) -->
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label>Jabatan</label>
                        <select name="jabatan[]" class="form-control" required>
                            <option value="">Pilih Jabatan</option>
                            <!-- Options dapat diisi sesuai kebutuhan -->
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Partisipan</label>
                        <select name="partisipan[]" class="form-control" required>
                            <option value="">Pilih Partisipan</option>
                            <!-- Options dapat diisi sesuai kebutuhan -->
                        </select>
                    </div>
                </div>
                <!-- Tambah baris Jabatan dan Partisipan -->
                <div id="dynamic-fields"></div>
                <button type="button" class="btn btn-secondary btn-sm" onclick="addField()">Tambah Jabatan & Partisipan</button>
            </div>

            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-warning">Batal</button>
                <button type="submit" class="btn btn-primary">Tambah</button>
            </div>
        </div>
    </div>
</form>

<script>
    function addField() {
        const newField = `
            <div class="form-row mt-2">
                <div class="form-group col-md-6">
                    <select name="jabatan[]" class="form-control" required>
                        <option value="">Pilih Jabatan</option>
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <select name="partisipan[]" class="form-control" required>
                        <option value="">Pilih Partisipan</option>
                    </select>
                </div>
            </div>
        `;
        $('#dynamic-fields').append(newField);
    }
</script>
