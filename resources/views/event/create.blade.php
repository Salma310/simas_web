@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title font-weight-bold">{{ $page->title }}</h3>
            <div class="card-tools"></div>
        </div>
        <div class="card-body">
            <form action="{{ url('event') }}" method="post" class="form-horizontal">
                @csrf
                <div class="form-group row">
                    <label class="col-2 control-label col-form-label">Jenis Event</label>
                    <div class="col-9">
                        <select name="level_id" id="level_id" class="form-control rounded" required>
                            <option value="">- Pilih Level -</option>
                            @foreach ($jenisEvent as $item)
                                <option value="{{ $item->jenis_event_id }}">{{ $item->jenis_event_name }}</option>
                            @endforeach
                        </select>
                        @error('jenis_event_id')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-2 control-label col-form-label">Nama Event</label>
                    <div class="col-9">
                        <input type="text" class="form-control" id="event_name" name="event_name"
                            value="{{ old('event_name') }}" required>
                        @error('event_name')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-2 control-label col-form-label">Kode Event</label>
                    <div class="col-9">
                        <input type="text" class="form-control" id="event_code" name="event_code"
                            value="{{ old('event_code') }}" required>
                        @error('event_code')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row ">
                    <label class="col-2 control-label col-form-label">Tanggal Mulai</label>
                    <div class="col-4">
                        <input type="datetime-local" class="form-control" id="start_date" name="start_date" required>
                        @error('start_date')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-2 control-label col-form-label">Tanggal Selesai</label>
                    <div class="col-4">
                        <input type="datetime-local" class="form-control" id="end_date" name="end_date" required>
                        @error('end_date')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-2 control-label col-form-label">Deskripsi Event</label>
                    <div class="col-10">
                        <textarea name="event_description" id="event_description" cols="100" rows="10" class="rounded-full"></textarea>
                        @error('event_description')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                
                <!-- Partisipan dan Jabatan -->
                <div class="form-group row">
                    <label class="col-2 control-label col-form-label">Partisipan</label>
                    <div class="col-10" id="participant-fields">
                        <div class="form-row mb-2">
                            <div class="col-5">
                                <select name="jabatan[]" class="form-control" required>
                                    <option value="">Pilih Jabatan</option>
                                    @foreach ($jabatan as $j)
                                        <option value="{{ $j->jabatan_id }}">{{ $j->jabatan_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-5">
                                <select name="dosen[]" class="form-control" required>
                                    <option value="">Pilih Dosen</option>
                                    @foreach ($user as $dosen)
                                        <option value="{{ $dosen->user_id }}">{{ $dosen->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-2">
                                <button type="button" class="btn btn-success btn-sm" onclick="addParticipantField()">Tambah</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-10 control-label col-form-label"></label>
                    <div class="col-2">
                        <a href="{{ url('event') }}" class="btn btn-sm btn-default ml-1">Kembali</a>
                        <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    function addParticipantField() {
        const fieldHTML = `
            <div class="form-row mb-2">
                <div class="col-5">
                    <select name="jabatan[]" class="form-control" required>
                        <option value="">Pilih Jabatan</option>
                        @foreach ($jabatan as $j)
                            <option value="{{ $j->jabatan_id }}">{{ $j->jabatan_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-5">
                    <select name="dosen[]" class="form-control" required>
                        <option value="">Pilih Dosen</option>
                        @foreach ($user as $dosen)
                            <option value="{{ $dosen->user_id }}">{{ $dosen->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-2">
                    <button type="button" class="btn btn-danger btn-sm" onclick="removeParticipantField(this)">Hapus</button>
                </div>
            </div>
        `;
        $('#participant-fields').append(fieldHTML);
    }

    function removeParticipantField(element) {
        $(element).closest('.form-row').remove();
    }
</script>
@endpush

