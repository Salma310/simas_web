<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <style>
        .modal-content {
            border-radius: 15px;
            padding: 20px;
            background-color: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 800px;
            margin: 50px auto;
        }

        .modal-header,
        .modal-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-header {
            border-bottom: 1px solid #dee2e6;
        }

        .modal-footer {
            border-top: 1px solid #dee2e6;
        }

        .progress-text {
            color: #f39c12;
            font-weight: bold;
        }

        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .btn-primary {
            background-color: #007bff;
            color: white;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .btn-secondary {
            background-color: #007bff;
            color: white;
        }

        .btn-secondary:hover {
            background-color: #0056b3;
        }

        .btn-close {
            background: none;
            border: none;
            font-size: 1.5rem;
            line-height: 1;
            color: #000;
            opacity: 0.5;
        }

        .btn-close:hover {
            color: #000;
            opacity: 0.75;
        }

        .picture {
            width: 50px;
            height: 50px;
            border-radius: 50%;
        }

        .member-info {
            text-align: center;
        }

        .header-section {
            margin-bottom: 20px;
        }

        .row {
            display: flex;
            flex-wrap: wrap;
            margin: 0 -15px;
        }

        .col-md-3,
        .col-md-9 {
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

        .btn-download-surat {
            position: relative;
            background: linear-gradient(135deg, #4CAF50, #45a049);
            color: white;
            border: none;
            border-radius: 25px;
            padding: 10px 20px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            overflow: hidden;
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            /* Tambahkan ellipsis jika teks melebihi lebar */
        }

        .btn-download-surat:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 8px rgba(0, 0, 0, 0.15);
            background: linear-gradient(135deg, #45a049, #4CAF50);
        }

        .btn-download-surat:active {
            transform: translateY(1px);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .btn-download-surat .btn-download-content {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .btn-download-surat i {
            font-size: 1.2em;
            transition: transform 0.2s ease;
        }

        .btn-download-surat:hover i {
            transform: scale(1.2) rotate(360deg);
        }

        .btn-download-surat::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: rgba(255, 255, 255, 0.1);
            transform: rotate(45deg);
            transition: all 0.3s ease;
            opacity: 0;
        }

        .btn-download-surat:hover::before {
            opacity: 1;
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }

            100% {
                transform: scale(1);
            }
        }

        .btn-download-surat.file-available {
            animation: pulse 1.5s infinite;
        }

        .btn-download-surat.no-file {
            background: linear-gradient(135deg, #f44336, #d32f2f);
            cursor: not-allowed;
        }
    </style>
    <title>Event Modal</title>
</head>

<body>
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="eventModalLabel" style="font-weight: bold;">{{ $event->event_name }}</h5>
                <button aria-label="Close" class="btn-close" data-dismiss="modal" type="button">&times;</button>
            </div>
            <div class="modal-body">
                <div class="d-flex justify-content-between align-items-start header-section">
                    <div>
                        <p class="text-muted">{{ $event->jenisEvent->jenis_event_name }}</p>
                        <p class="event-description">{{ $event->event_description }}</p>
                    </div>
                    <div class="text-end">
                        <p class="progress-text">Progress ({{ $event->event_id }}%)</p>
                        <button class="btn btn-download-surat"
                            onclick="downloadSuratTugas('{{ asset('storage/surat_tugas/' . $event->assign_letter) }}')">
                            <div class="btn-download-content">
                                <i class="fas fa-file-download"></i>
                                <span>Unduh Surat Tugas</span>
                            </div>
                        </button>
                    </div>
                </div>
                <hr />
                <div class="row">
                    <div class="col-md-3">
                        <p><strong>Pelaksanaan</strong></p>
                    </div>
                    <div class="col-md-9">
                        <p>{{ \Carbon\Carbon::parse($event->start_date)->format('d-m-Y') }} -
                            {{ \Carbon\Carbon::parse($event->end_date)->format('d-m-Y') }}</p>
                    </div>
                </div>
                <div class="row">
                    @php
                        $pic = $event->participants->firstWhere('position.jabatan_id', 1);
                        $pembina = $event->participants->firstWhere('position.jabatan_id', 2);
                        $sekretaris = $event->participants->firstWhere('position.jabatan_id', 3);
                        $anggota = $event->participants->where('position.jabatan_id', 4);
                    @endphp

                    @if ($pic)
                        <div class="col-md-3">
                            <p><strong>PIC</strong></p>
                            <div class="member-info">
                                <img alt="Profile picture of {{ $pic->user->name }}" class="avatar rounded-circle"
                                    height="50"
                                    src="{{ $pic->user->picture ? asset('storage/picture/' . $pic->user->picture) : asset('images/defaultUser.png') }}"
                                    width="50" />
                                <p>{{ $pic->user->name }}</p>
                            </div>
                        </div>
                    @endif

                    @if ($pembina)
                        <div class="col-md-3">
                            <p><strong>Pembina</strong></p>
                            <div class="member-info">
                                <img alt="Profile picture of {{ $pembina->user->name }}" class="avatar rounded-circle"
                                    height="50"
                                    src="{{ $pembina->user->picture ? asset('storage/picture/' . $pembina->user->picture) : asset('images/defaultUser.png') }}"
                                    width="50" />
                                <p>{{ $pembina->user->name }}</p>
                            </div>
                        </div>
                    @endif

                    @if ($sekretaris)
                        <div class="col-md-3">
                            <p><strong>Sekretaris</strong></p>
                            <div class="member-info">
                                <img alt="Profile picture of {{ $sekretaris->user->name }}"
                                    class="avatar rounded-circle" height="50"
                                    src="{{ $sekretaris->user->picture ? asset('storage/picture/' . $sekretaris->user->picture) : asset('images/defaultUser.png') }}"
                                    width="50" />
                                <p>{{ $sekretaris->user->name }}</p>
                            </div>
                        </div>
                    @endif
                    @if ($anggota->count() > 0)
                        <div class="col-md-3">
                            <p><strong>Anggota</strong></p>
                            <div class="member-info">
                                @foreach ($anggota as $member)
                                    <div class="d-flex align-items-center mb-2">
                                        <img alt="Profile picture of {{ $member->user->name }}"
                                            class="avatar mr-2 rounded-circle" height="40"
                                            src="{{ $member->user->picture ? asset('storage/picture/' . $member->user->picture) : asset('images/defaultUser.png') }}"
                                            width="40" />
                                        <p class="mb-0">{{ $member->user->name }}</p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-dismiss="modal" type="button">Tutup</button>
            </div>
        </div>
    </div>
    <script>
        function downloadSuratTugas(filePath) {
            const button = event.currentTarget;

            if (filePath) {
                // Tambahkan efek visual saat file tersedia
                button.classList.add('file-available');
                setTimeout(() => {
                    button.classList.remove('file-available');
                }, 1500);

                // Logika download
                const link = document.createElement('a');
                link.href = filePath;
                link.download = 'Surat_Tugas_{{ $event->event_name }}'.replace(/\s+/g, '_');
                link.target = '_blank';
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            } else {
                // Tambahkan efek visual saat file tidak tersedia
                button.classList.add('no-file');
                setTimeout(() => {
                    button.classList.remove('no-file');
                }, 1000);

                Swal.fire({
                    icon: 'warning',
                    title: 'Berkas Tidak Tersedia',
                    text: 'Maaf, surat tugas untuk event ini belum diunggah.',
                    confirmButtonText: 'Tutup'
                });
            }
        }
    </script>
</body>

</html>
