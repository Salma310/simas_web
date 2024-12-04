@extends('layouts.template')
@section('content')
    <style>
        body {
            background-color: #f8f9fa;
            margin: 0;
            padding: 20px;
        }

        .header-section {
            margin-bottom: 20px;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            position: relative; /* Untuk penempatan progress text */
        }

        .header-title {
            font-weight: bold;
            font-size: 1.5em;
            margin-bottom: 10px;
        }

        .event-type {
            color: #6c757d;
            font-size: 1.1em;
            margin-bottom: 10px;
        }

        .event-description {
            margin-bottom: 10px;
            line-height: 1.5;
        }

        .progress-text {
            color: #f39c12;
            font-weight: bold;
            position: absolute; /* Pindahkan ke pojok kanan atas */
            top: 20px;
            right: 20px;
        }

        .points-text {
            color: #007bff;
            font-weight: normal;
            margin-top: 5px;
        }

        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
            transition: background-color 0.3s, transform 0.2s;
        }

        .btn-download-surat {
            background-color: #28a745;
            color: white;
            font-weight: bold;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        .btn-download-surat:hover {
            background-color: #218838;
            transform: scale(1.05);
        }

        .btn-back {
            background-color: #6c757d;
            color: white;
        }

        .btn-back:hover {
            background-color: #5a6268;
            transform: scale(1.05);
        }

        .btn-agenda {
            background-color: #007bff;
            color: white;
            float: right;
        }

        .btn-agenda:hover {
            background-color: #0056b3;
            transform: scale(1.05);
        }

        .picture {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            border: 2px solid #007bff;
            margin-bottom: 5px;
        }

        .member-info {
            text-align: center;
            margin-bottom: 15px;
        }

        .row {
            display: flex;
            flex-wrap: wrap;
            margin: 0 -15px;
        }

        .col-md-3, .col-md-9 {
            padding: 0 15px;
            box-sizing: border-box;
        }

        .col-md-3 {
            flex: 0 0 25%;
            max-width: 25%;
        }

        .col-md-9 {
            flex: 0 0 75%;
            max-width: 75%;
        }

        hr {
            border: 1px solid #dee2e6;
            margin: 20px 0;
        }
    </style>
    <div>
        <div class="header-section">
            <h5 class="header-title">{{ $event->event_name }}</h5>
            <p class="event-type">{{$event->jenisEvent->jenis_event_name}}</p>
            <p class="event-description">{{ $event->event_description }}</p>
            <p class="progress-text">Progress ({{ $event->event_id }}%)</p>
            <p class="points-text">Points: {{ $event->point }}</p> <!-- Mengambil poin dari database -->
            <button class="btn btn-download-surat" onclick="downloadSuratTugas('{{ $event->assign_letter }}')">
                Unduh Surat Tugas
            </button>
        </div>
        <hr/>
        <div class="row">
            <div class="col-md-3">
                <p><strong>Pelaksanaan</strong></p>
            </div>
            <div class="col-md-9">
                <p>{{ $event->start_date }} - {{ $event->end_date }}</p>
            </div>
        </div>
        <div class="row">
            @php
                $pic = $event->participants->firstWhere('position.jabatan_id', 1);
                $pembina = $event->participants->firstWhere('position.jabatan_id', 2);
                $sekretaris = $event->participants->firstWhere('position.jabatan_id', 3);
                $anggota = $event->participants->where('position.jabatan_id', 4);
            @endphp

            @if($pic)
                <div class="col-md-3">
                    <p><strong>PIC</strong></p>
                    <div class="member-info">
                        <img alt="Profile picture of {{ $pic->user->name }}" class="picture" src="{{ $pic->user->picture ? asset('storage/picture/' . $pic->user->picture) : asset('images/defaultUser.png') }}"/>
                        <p>{{ $pic->user->name }}</p>
                    </div>
                </div>
            @endif

            @if($pembina)
                <div class="col-md-3">
                    <p><strong>Pembina</strong></p>
                    <div class="member-info">
                        <img alt="Profile picture of {{ $pembina->user->name }}" class="picture" src="{{ $pembina->user->picture ? asset('storage/picture/' . $pembina->user->picture) : asset('images/defaultUser.png') }}"/>
                        <p>{{ $pembina->user->name }}</p>
                    </div>
                </div>
            @endif

            @if($sekretaris)
                <div class="col-md-3">
                    <p><strong>Sekretaris</strong></p>
                    <div class="member-info">
                        <img alt="Profile picture of {{ $sekretaris->user->name }}" class="picture" src="{{ $sekretaris->user->picture ? asset('storage/picture/' . $sekretaris->user->picture) : asset('images/defaultUser.png') }}"/>
                        <p>{{ $sekretaris->user->name }}</p>
                    </div>
                </div>
            @endif

            @if($anggota->count())
                <div class="col-md-3">
                    <p><strong>Anggota</strong></p>
                    @foreach($anggota as $member)
                        <div class="member-info">
                            <img alt="Profile picture of {{ $member->user->name }}" class="picture" src="{{ $member->user->picture ? asset('storage/picture/' . $member->user->picture) : asset('images/defaultUser.png') }}"/>
                            <p>{{ $member->user->name }}</p>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
        <hr/>
        <button class="btn btn-back" onclick="window.location.href='{{ url('/event_dosen') }}'">Kembali</button>
        <button class="btn btn-agenda" onclick="openAgenda(<?= $event->event_id ?>)">Agenda</button>
    </div>
    <script>
        function downloadSuratTugas(url) {
            window.open(url, '_blank');
        }

        function openAgenda(eventId) {
            // Logic to open the agenda page
            window.location.href = eventId+'/agenda';
        }
    </script>
@endsection
