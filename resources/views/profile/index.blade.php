@extends('layouts.template')
@section('content')
<div class="container-fluid">
    <!-- Static success or error messages -->
    <!-- <div class="alert alert-success">Profile berhasil diperbarui!</div>
    <div class="alert alert-danger">Terjadi kesalahan. Coba lagi nanti.</div> -->

    <div class="row">
        <div class="col-md-3">
            <!-- Profile Image -->
            <div class="card card-primary card-outline text-center">
                <div class="card-body box-profile">
                    <!-- Static profile picture -->
                    <img src="{{ asset('default-avatar.jpeg') }}" class="rounded-circle img-fluid mb-3" style="width: 150px; height: 150px;" alt="Avatar" id="avatarPreview">
                    
                    <!-- Static user data -->
                    <h3 class="profile-username">Nama Pengguna</h3>
                    <p class="text-muted">Level Pengguna</p>

                    <!-- Form for uploading new avatar -->
                    <form action="{{ url('/profile/update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="file" name="avatar" id="avatar" class="form-control mb-2" onchange="previewAvatar()" required>
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
                        <!-- Edit Profile Data Form -->
                        <div class="active tab-pane" id="editdatadiri">
                            <form action="{{ url('/profile/update_data_diri') }}" method="POST">
                                @csrf
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Username</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" value="StaticUsername" readonly>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">NIDN</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" value="StaticNIDN" readonly>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Email</label>
                                    <div class="col-sm-9">
                                        <input type="email" class="form-control" value="static.email@example.com" readonly>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">No Telp</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="no_hp" class="form-control" value="08123456789" required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-9 offset-sm-3">
                                        <button type="submit" class="btn btn-primary btn-block">Update Profile</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <!-- Edit Password Form -->
                        <div class="tab-pane" id="editpw">
                            <form action="{{ url('/profile/update_password') }}" method="POST" class="form-horizontal">
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

<script>
    function previewAvatar() {
        const avatar = document.getElementById("avatar").files[0];
        if (avatar) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById("avatarPreview").src = e.target.result;
            };
            reader.readAsDataURL(avatar);
        }
    }
</script>
@endsection