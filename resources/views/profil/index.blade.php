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
            <div class="card card-primary card-outline">
                <div class="card-body box-profile">
                    <div class="text-center">
                        <img src="{{ auth()->user()->avatar ? asset('storage/avatars/' . auth()->user()->avatar) : asset('default-avatar.jpeg') }}"
                 class="rounded-circle img-fluid mb-3" style="width: 150px; height: 150px;" alt="Avatar">
                    </div>
                    <h3 class="profile-username text-center">{{ auth()->user()->nama }}</h3>
                    <p class="text-muted text-center">{{ auth()->user()->level->level_nama }}</p>
                    <ul class="list-group list-group-unbordered mb-3">
                        <form action="{{ url('/profil/update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                        <div class="form-group row">
                            <div class="col-sm-10">
                                <div class="input-group">
                                    <input type="file" name="avatar" id="avatar" class="form-control" required>
                                    <div class="input-group-append">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Ganti Foto Profil</button>
                        </form>
                        
                    </ul>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->
        <div class="col-md-9">
            <div class="card card-primary card-outline">
                <div class="card-header p-2">
                    <ul class="nav nav-pills">
                        <li class="nav-item"><a class="nav-link active" href="#editdatadiri" data-toggle="tab">Edit Data Diri</a></li>
                        <li class="nav-item"><a class="nav-link" href="#editpw" data-toggle="tab">Edit Password</a></li>
                    </ul>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="tab-content">
                        <div class="active tab-pane" id="editdatadiri">
                            <form action="{{ url('/profil/update_data_diri') }}" method="POST">
                                @csrf
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Username</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" value="{{ Auth::user()->username }}" disabled>
                                    </div>
                                </div>
                                
                                <div class="form-group row">
                                    <label for="nama" class="col-sm-2 col-form-label">Nama</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="nama" id="nama" class="form-control" value="{{ Auth::user()->nama }}" required>
                                        <small id="error-nama" class="error-text form-text text-danger"></small>
                                    </div>
                                </div>
                        
                                <div class="form-group row">
                                    <label for="ttl" class="col-sm-2 col-form-label">TTL</label>
                                    <div class="col-sm-5">
                                        <input type="text" name="tempat_lahir" id="tempat_lahir" class="form-control" value="{{ $profil->tempat_lahir ?? '' }}" placeholder="Tempat Lahir">
                                    </div>
                                    <div class="col-sm-5">
                                        <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-control" value="{{ $profil->tanggal_lahir ?? '' }}" placeholder="Tanggal Lahir">
                                    </div>
                                </div>
                        
                                {{-- <div class="form-group row">
                                    <label for="jenis_kelamin" class="col-sm-2 col-form-label">Jenis Kelamin</label>
                                    <div class="col-sm-10">
                                        <div class="form-check">
                                            <input type="radio" name="jenis_kelamin" id="jenis_kelamin_laki" class="form-check-input" value="L" {{ $profil->jenis_kelamin == 'L' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="jenis_kelamin_laki">Laki-laki</label>
                                        </div>
                                        <div class="form-check">
                                            <input type="radio" name="jenis_kelamin" id="jenis_kelamin_perempuan" class="form-check-input" value="P" {{ $profil->jenis_kelamin == 'P' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="jenis_kelamin_perempuan">Perempuan</label>
                                        </div>
                                    </div>
                                </div> --}}
                                {{-- <div class="form-group row">
                                    <label for="jenis_kelamin" class="col-sm-2 col-form-label">Jenis Kelamin</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="jenis_kelamin" id="jenis_kelamin" class="form-control" value="{{ $profil->jenis_kelamin ?? '' }}">
                                    </div>
                                </div> --}}
                                            
                                {{-- <div class="form-group row">
                                    <label for="jenis_kelamin" class="col-sm-2 col-form-label">Jenis Kelamin</label>
                                    <div class="col-sm-10">
                                        <select name="jenis_kelamin" id="jenis_kelamin" class="form-control">
                                            <option value="L" {{ (Auth::user()->profil->jenis_kelamin ?? '') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                            <option value="P" {{ (Auth::user()->profil->jenis_kelamin ?? '') == 'P' ? 'selected' : '' }}>Perempuan</option>
                                        </select>
                                    </div>
                                </div> --}}

                                <div class="form-group row">
                                    <label for="jenis_kelamin" class="col-sm-2 col-form-label">Jenis Kelamin</label>
                                    <div class="col-sm-10">
                                        <div class="form-check">
                                            <input type="radio" name="jenis_kelamin" id="jenis_kelamin_laki" class="form-check-input" value="L"
                                                   {{ isset($profil) && $profil->jenis_kelamin == 'L' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="jenis_kelamin_laki">Laki-laki</label>
                                        </div>
                                        <div class="form-check">
                                            <input type="radio" name="jenis_kelamin" id="jenis_kelamin_perempuan" class="form-check-input" value="P"
                                                   {{ isset($profil) && $profil->jenis_kelamin == 'P' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="jenis_kelamin_perempuan">Perempuan</label>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-group row">
                                    <label for="agama" class="col-sm-2 col-form-label">Agama</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="agama" id="agama" class="form-control" value="{{ $profil->agama ?? '' }}">
                                    </div>
                                </div>
                        
                                <div class="form-group row">
                                    <label for="no_hp" class="col-sm-2 col-form-label">No. HP</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="no_hp" id="no_hp" class="form-control" value="{{ $profil->no_hp ?? '' }}">
                                    </div>
                                </div>
                        
                                <div class="form-group row">
                                    <label for="alamat" class="col-sm-2 col-form-label">Alamat</label>
                                    <div class="col-sm-10">
                                        <textarea name="alamat" id="alamat" class="form-control">{{ $profil->alamat ?? '' }}</textarea>
                                    </div>
                                </div>
                        
                                <div class="form-group row">
                                    <div class="col-sm-10 offset-sm-2">
                                        <button type="submit" class="btn btn-primary">Update Profil</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        
                        <!-- /.tab-pane -->
                        <div class="tab-pane" id="editpw">
                            <form action="{{ url('/profil/update_password') }}" method="POST" class="form-horizontal">
                                @csrf
                                <div class="form-group row">
                                    <label for="oldPassword" class="col-sm-2 col-form-label">Password Lama</label>
                                    <div class="col-sm-10">
                                        <input type="password" name="old_password" class="form-control" id="oldPassword" placeholder="Masukkan password lama" required>
                                        @if($errors->has('old_password'))
                                            <small class="text-danger">{{ $errors->first('old_password') }}</small>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="newPassword" class="col-sm-2 col-form-label">Password Baru</label>
                                    <div class="col-sm-10">
                                        <input type="password" name="new_password" class="form-control" id="newPassword" placeholder="Masukkan password baru" required>
                                        @if($errors->has('new_password'))
                                            <small class="text-danger">{{ $errors->first('new_password') }}</small>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="confirmPassword" class="col-sm-2 col-form-label">Ulangi Password Baru</label>
                                    <div class="col-sm-10">
                                        <input type="password" name="confirm_password" class="form-control" id="confirmPassword" placeholder="Ulangi password baru" required>
                                        @if($errors->has('confirm_password'))
                                            <small class="text-danger">{{ $errors->first('confirm_password') }}</small>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="offset-sm-2 col-sm-10">
                                        <button type="submit" class="btn btn-primary">Update Password</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        
                        <!-- /.tab-pane -->
                    </div>
                    <!-- /.tab-content -->
                </div><!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</div><!-- /.container-fluid -->
@endsection
@section('scripts')
<!-- Add any page-specific scripts here -->
<script>
</script>
@endsection