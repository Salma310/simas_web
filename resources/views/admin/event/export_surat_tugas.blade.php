<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Surat Tugas {{ $event->event_name }}</title>
    <style>
        body {
            font-family: "Times New Roman", Times, serif;
            margin: 6px 20px 5px 20px;
            line-height: 15px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td,
        th {
            padding: 4px 3px;
        }

        th {
            text-align: left;
        }

        .d-block {
            display: block;
        }

        img.image {
            width: auto;
            height: 80px;
            max-width: 150px;
            max-height: 150px;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .p-1 {
            padding: 5px 1px 5px 1px;
        }

        .font-10 {
            font-size: 10pt;
        }

        .font-11 {
            font-size: 11pt;
        }

        .font-12 {
            font-size: 12pt;
        }

        .font-13 {
            font-size: 15pt;
        }

        .border-bottom-header {
            border-bottom: 3px solid;
        }

        .border-all,
        .border-all th,
        .border-all td {
            border: 1px solid;
        }
    </style>
</head>

<body>
    <table class="border-bottom-header">
        <tr>
            <td width="15%" class="text-center"><img src="{{ asset('adminlte/dist/img/logo-polinema.png') }}"
                    width="110" height="110"></td>
            <td width="85%">
                <span class="text-center d-block font-13" style="margin-bottom: 5px;">KEMENTERIAN
                    PENDIDIKAN, KEBUDAYAAN,</span>
                <span class="text-center d-block font-13" style="margin-bottom:5px;">RISET, DAN TEKNOLOGI</span>
                <span class="text-center d-block font-13 mb-1" style="font-weight: 600;">POLITEKNIK NEGERI
                    MALANG</span>
                <span class="text-center d-block font-11">Jl. Soekarno-Hatta No. 9, Jatimulyo, Lowokwaru, Malang
                    65141</span>
                <span class="text-center d-block font-11">Telepon (0341) 404424 Pes. 101-
                    105, 0341-404420, Fax. (0341) 404420</span>
                <span class="text-center d-block font-11">http://www.polinema.ac.id</span>
            </td>
        </tr>
    </table>

    <h2 class="text-center" style="margin-top: 35px;margin-bottom:0px;">SURAT TUGAS</h2>
    <p class="text-center" style="margin-top: 10px;">Nomor : 20888/PL.2/{{ $event->event_code }}/2024</p>

    <p style="margin-top: 55px;">Ketua Jurusan Teknologi Informasi memberikan tugas kepada:</p>
    <table class="border-all">
        <thead>
            <tr>
                <th class="text-center">No</th>
                <th class="text-center">Nama</th>
                <th class="text-center">Jabatan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($eventParticipant as $participant)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>{{ $participant->user->name }}</td>
                    <td class="text-center">{{ $participant->position->jabatan_name }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <p style="line-height: 1.8">Untuk bertugas sebagai panitia dalam acara {{ $event->event_name }} yang dilaksanakan di
        Auditorium Gedung Sipil Lantai 8 pada tanggal
        {{ \Carbon\Carbon::parse($event->start_date)->locale('id')->translatedFormat('d F Y') }} hingga
        {{ \Carbon\Carbon::parse($event->end_date)->locale('id')->translatedFormat('d F Y') }}.</p>
    <p style="line-height: 1.8">Biaya dari kegiatan ini dibebankan pada anggaran Jurusan Teknologi Informasi Politeknik
        Negeri Malang. Setiap progres yang ada harap dilaporkan kepada Ketua Jurusan Teknologi Informasi. Demikian untuk
        dilaksanakan sebaik-baiknya.</p>

    <div style="float: right;margin-top:25px;">
        <p>Malang, {{ \Carbon\Carbon::now()->locale('id')->translatedFormat('d F Y') }}</p>
        <p style="line-height: 0.3;">Ketua Jurusan,</p>
        <p style="line-height: 0.3;margin-bottom:85px;">Jurusan Teknologi Informasi,</p>
        <p>Dr. Eng. Rosa Andrie Asmara, S.T., M.T.</p>
        <p style="line-height:0.3;">NIP. 198010102005011001</p>
    </div>

    <div style="font-size: 13px;clear:both;">
        <p style="font-weight: 600;">Tembusan:</p>
        <ol>
            <li>Ketua Jurusan Teknologi Informasi</li>
            <li>Ketua Program Studi</li>
            <li>Tim Perencana Kegiatan</li>
            <li>Ksb. Kepegawaian</li>
            <li>Ka. Urusan Perbendaharaan</li>
            <li>Ybs</li>
        </ol>
    </div>
</body>
</html>