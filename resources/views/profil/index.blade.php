@extends('layouts.template')
@section('content')
<div class="container-fluid">
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="row">
        <div class="col-md-3">
            <!-- Profile Image -->
            <div class="card card-primary card-outline text-center">
                <div class="card-body box-profile">
                    <img src="{{ auth()->user()->avatar ? asset('storage/avatars/' . auth()->user()->avatar) : asset('default-avatar.jpeg') }}"
                        class="rounded-circle img-fluid mb-3" style="width: 150px; height: 150px;" alt="Avatar">
                    <h3 class="profile-username">{{ auth()->user()->nama }}</h3>
                    <p class="text-muted">{{ auth()->user()->level->level_nama }}</p>
                    <form action="{{ url('/profil/update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="file" name="avatar" id="avatar" class="form-control mb-2" required>
                        <button type="submit" class="btn btn-primary btn-block">Ganti Foto Profil</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-9">
            <div class="card card-primary card-outline">
                <div class="card-header p-2">
                    <ul class="nav nav-pills">
                        <li class="nav-item"><a class="nav-link active" href="#editdatadiri" data-toggle="tab">Edit Data Profile</a></li>
                        <li class="nav-item"><a class="nav-link" href="#editpw" data-toggle="tab">Edit Password</a></li>
                    </ul>
                </div>
                
                <div class="card-body">
                    <div class="tab-content">
                        <div class="active tab-pane" id="editdatadiri">
                            <form action="{{ url('/profil/update_data_diri') }}" method="POST">
                                @csrf
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Username</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" value="43527********" disabled>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">NIDN</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" value="43527********" disabled>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Email</label>
                                    <div class="col-sm-9">
                                        <input type="email" class="form-control" value="jason.price@gmail.com" disabled>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">No Telp</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="no_hp" class="form-control" value="081336292772">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-9 offset-sm-3">
                                        <button type="submit" class="btn btn-primary btn-block">Update Profile</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="tab-pane" id="editpw">
                            <form action="{{ url('/profil/update_password') }}" method="POST" class="form-horizontal">
                                @csrf
                                <div class="form-group row">
                                    <label for="oldPassword" class="col-sm-3 col-form-label">Password Lama</label>
                                    <div class="col-sm-9">
                                        <input type="password" name="old_password" class="form-control" id="oldPassword" placeholder="Masukkan password lama" required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="newPassword" class="col-sm-3 col-form-label">Password Baru</label>
                                    <div class="col-sm-9">
                                        <input type="password" name="new_password" class="form-control" id="newPassword" placeholder="Masukkan password baru" required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="confirmPassword" class="col-sm-3 col-form-label">Ulangi Password Baru</label>
                                    <div class="col-sm-9">
                                        <input type="password" name="confirm_password" class="form-control" id="confirmPassword" placeholder="Ulangi password baru" required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-9 offset-sm-3">
                                        <button type="submit" class="btn btn-primary btn-block">Update Password</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
