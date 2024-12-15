@extends('layouts.app') <!-- Pastikan layout sesuai struktur project Anda -->

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5>{{ $event->event_name }}</h5>
                </div>
                <div class="card-body">
                    <p><strong>Non-JTI</strong></p>
                    <p>{{ $event->event_description }}</p>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Pelaksanaan:</strong></p>
                            <p>{{ \Carbon\Carbon::parse($event->start_date)->format('d F Y') }} - {{ \Carbon\Carbon::parse($event->end_date)->format('d F Y') }}</p>
                        </div>
                        <div class="col-md-6 text-right">
                            <a href="{{ url('event/download-surat-tugas/'.$event->id) }}" class="btn btn-primary">
                                <i class="fas fa-download"></i> Surat Tugas
                            </a>
                        </div>
                    </div>
                    <hr>
                    <p><strong>Nama PIC:</strong></p>
                    <p>{{ $event->pic->name }}</p>
                </div>
                <div class="card-footer text-right">
                    <a href="{{ url('/myevent') }}" class="btn btn-secondary">Kembali</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
