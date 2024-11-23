@extends('layouts.template')

@section('content')
<html>
<head>
    <style>
        body {
            background-color: #f0f2f5;
        }
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            position: relative;
            background-color: #fff;
            text-decoration: none; /* Remove underline for links */
            color: inherit; /* Inherit text color */
        }
        .card:hover {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
            transform: scale(1.02);
            transition: 0.3s;
        }
        .card-body {
            padding: 20px;
        }
        .card-title {
            font-size: 1.25rem;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .card-text {
            color: #6c757d;
        }
        .status {
            color: #f0ad4e;
            font-weight: bold;
            position: absolute;
            top: 20px;
            right: 20px;
        }
        .icon-text {
            display: flex;
            align-items: center;
            font-size: 0.875rem;
            color: #6c757d;
        }
        .icon-text i {
            margin-right: 5px;
        }
        .label {
            font-size: 0.875rem;
            color: #6c757d;
            margin-right: 5px;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            @foreach($events as $event)
                <!-- Membungkus seluruh kartu dengan <a> -->
                <a href="javascript:void(0)" onclick="modalAction('{{ route('event.show', $event->event_id) }}')" class="col-md-4 mb-4" style="text-decoration: none;">
                    <div class="card" style="width: 20rem;">
                        <div class="card-body">
                            <div class="status">{{ $event->status }}</div>
                            <h5 class="card-title">{{ $event->event_name }}</h5>
                            @foreach ($jenisEvent as $j)
                                @if ($j->jenis_event_id == $event->jenis_event_id)
                                    <h6 class="card-text" style="font-size: 1.1rem; margin-bottom:20px">{{ $j->jenis_event_name }}</h6>
                                @endif
                            @endforeach
                            <p class="card-text">{{ $event->event_description }}</p>
                            <div class="d-flex justify-content-between">
                                <div class="icon-text">
                                    <div class="d-flex flex-column">
                                        <span class="label">Due date</span>
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-calendar-alt"></i>
                                            <span>{{ \Carbon\Carbon::parse($event->end_date)->format('F d, Y') }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="icon-text">
                                    <div class="d-flex flex-column">
                                        <span class="label">Participants</span>
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-users"></i>
                                            <span>{{ $event->participants_count }} </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
        <div class="modal fade show" id="eventModal" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="eventModalLabel" aria-hidden="true"></div>
    </div>
</body>
</html>
<script>
    function modalAction(url = ''){
        $('#eventModal').load(url,function(){
            $('#eventModal').modal('show');
        });
    }
</script>
@endsection
