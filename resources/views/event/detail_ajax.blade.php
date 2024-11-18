@empty($event)
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
                    Data yang anda cari tidak ditemukan
                </div>
                <a href="{{ url('/event') }}" class="btn btn-warning">Kembali</a>
            </div>
        </div>
    </div>
@else
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detail Data Event</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-sm table-bordered table-striped">
                    <tr>
                        <th class="text-right col-3">Nama Event :</th>
                        <td class="col-9">{{ $event->event_name }}</td>
                    </tr>
                    <tr>
                        <th class="text-right col-3">Kode Event :</th>
                        <td class="col-9">{{ $event->event_code }}</td>
                    </tr>
                    <tr>
                        <th class="text-right col-3">Jenis Event :</th>
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
                    <tr>
                        <th class="text-right col-3">Deskripsi Event :</th>
                        <td class="col-9">{{ $event->event_description }}</td>
                    </tr>
                </table>
            
                <!-- Tabel untuk Jabatan dan Partisipan -->
                <h5 class="mt-4">Daftar Partisipan dan Jabatan</h5>
                <table class="table table-responsive-sm table-bordered table-striped">
                    <thead>
                        <tr>
                            <th class="text-center">Partisipan</th>
                            <th class="text-center">Jabatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($eventParticipant as $participant)
                        <tr>
                            <td>{{ $participant->user->name }}</td>
                            <td>{{ $participant->position->jabatan_name }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <h5 class="mt-4">List Agenda</h5>
                <table class="table table-sm table-bordered table-striped">
                    <thead>
                        <tr>
                            <th class="text-center">Agenda</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($agenda as $a)
                        <tr>
                            <td>{{ $a->nama_agenda }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
@endempty