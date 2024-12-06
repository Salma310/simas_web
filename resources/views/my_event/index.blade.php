@extends('layouts.template')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">


{{-- @extends('layouts.template') --}}
@section('content')
<div class="card card-outline card-primary">
    <section class="event-container p-4">
        <h1 class="event-title">Play IT</h1>
        <h2 class="event-type text-muted">Terprogram</h2>
        <p class="event-description mt-3">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam condimentum id nisi eu interdum. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Cras sit amet ante iaculis, pulvinar velit et, sodales nisl. Vestibulum mollis odio elit, a scelerisque nisi interdum a. Ut facilisis felis quam, sed ultricies justo ornare sed.
        </p>

        <hr class="divider my-4">

        <!-- Pelaksanaan -->
        <div class="event-details mb-4">
            <h6 class="font-weight-bold">Pelaksanaan</h6>
            <div class="date-range">
                <span class="date">23 July 2024</span>
                <span class="date-separator mx-2">-</span>
                <span class="date">30 July 2024</span>
            </div>
        </div>

        <!-- PIC and Members -->
        <div class="row">
            <!-- PIC Section -->
            <div class="col-md-4">
                <h6 class="font-weight-bold text-left">PIC</h6>
                <div class="member-card mt-3 text-left">
                    <img src="{{ asset('adminlte/dist/img/avatar2.png') }}" alt="Profile photo of PIC" class="member-avatar rounded-circle mb-2">
                    <span class="member-name">Jacob, S.T., M.T.</span>
                </div>
            </div>

            <!-- Members Section -->
            <div class="col-md-8">
                <h6 class="font-weight-bold text-left">Anggota</h6>
                <div class="row mt-3">
                    @for ($i = 0; $i < 6; $i++)
                    <div class="col-md-4 text-left">
                        <div class="member-card">
                            <img src="{{ asset('adminlte/dist/img/avatar5.png') }}" alt="Profile photo of Member" class="member-avatar rounded-circle mb-2">
                            <span class="member-name">Jacob, S.T., M.T.</span>
                        </div>
                    </div>
                    @endfor
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="action-buttons mt-4 d-flex justify-content-between">
            <a href="{{ url('event') }}" class="btn btn-secondary btn-sm">Kembali</a>
            <a href="{{ url('myevent/agenda') }}" class="btn btn-primary btn-sm">Atur Agenda</a>
        </div>
    </section>
</div>
@endsection
@push('css')
<style>
    .event-container {
        font-family: Arial, sans-serif;
    }
    .divider {
        border-top: 1px solid #ddd;
    }
    .members-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
        gap: 20px;
    }
    .member-card {
        display: flex;
        flex-direction: column;
        /* align-items: center; */
    }
    .member-avatar {
        width: 60px;
        height: 60px;
        object-fit: cover;
    }
    .action-buttons a {
        width: 120px;
        text-align: center;
    }
</style>
@endpush
@push('js')
@endpush
