@extends('layouts.master')

@section('content')
    <main class="app-main">
        <!--begin::App Content Header-->
        <div class="app-content-header">
            <!--begin::Container-->
            <div class="container-fluid">
                <!--begin::Row-->
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="mb-0">Profil Pengguna</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Profil</li>
                        </ol>
                    </div>
                </div>
                <!--end::Row-->
            </div>
            <!--end::Container-->
        </div>
        <!--end::App Content Header-->
        <!--begin::App Content-->
        <div class="app-content">
            <!--begin::Container-->
            <div class="container-fluid">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="row">
                    <div class="col-md-12">
                        <!--begin::Edit Profile Card-->
                        <div class="card">
                            <div class="card-header">
                                <div class="card-title">Edit Profil</div>
                            </div>
                            <div class="card-body">
                                @if($errors->any())
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <ul class="mb-0">
                                            @foreach($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                @endif

                                <form action="{{ route('profile.update') }}" method="POST" class="form-horizontal">
                                    @csrf
                                    @method('PUT')

                                    <div class="mb-4">
                                        <label for="name" class="form-label required">Nama</label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                               id="name" name="name" value="{{ old('name', $user->name) }}" required>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-4">
                                        <label for="email" class="form-label required">Email</label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                               id="email" name="email" value="{{ old('email', $user->email) }}" required>
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-4">
                                        <label for="role" class="form-label">Role</label>
                                        <input type="text" class="form-control" value="{{ $user->role }}" disabled readonly>
                                    </div>

                                    <div class="d-flex justify-content-end gap-2">
                                        <a href="{{ route('home') }}" class="btn btn-secondary">
                                            <i class="bi bi-arrow-left"></i> Kembali
                                        </a>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="bi bi-save"></i> Simpan Perubahan
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!--end::Edit Profile Card-->
                    </div>
                </div>

                @if($user->role === 'mentor')
                <!--begin::Mentor Courses-->
                <div class="row mt-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="card-title">Kursus Yang Saya Ajarkan</div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Nama Kursus</th>
                                                <th>Deskripsi</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($user->courses as $course)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $course->name }}</td>
                                                <td>{{ $course->description }}</td>
                                                <td>
                                                    @if($course->status === 'active')
                                                        <span class="badge bg-success">Aktif</span>
                                                    @else
                                                        <span class="badge bg-danger">Tidak Aktif</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="4" class="text-center">Tidak ada kursus yang diajarkan</td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end::Mentor Courses-->
                @endif

                @if($user->role === 'mentee')
                <!--begin::Mentee Courses-->
                <div class="row mt-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="card-title">Kursus Yang Saya Ikuti</div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Nama Kursus</th>
                                                <th>Mentor</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($user->bookings as $booking)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $booking->course->name }}</td>
                                                <td>{{ $booking->course->mentor->name }}</td>
                                                <td>
                                                    @if($booking->status === 'active')
                                                        <span class="badge bg-success">Aktif</span>
                                                    @else
                                                        <span class="badge bg-danger">Tidak Aktif</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="4" class="text-center">Tidak ada kursus yang diikuti</td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end::Mentee Courses-->
                @endif
            </div>
            <!--end::Container-->
        </div>
        <!--end::App Content-->
    </main>
@endsection

@push('css')
<style>
    .required:after {
        content: " *";
        color: red;
    }
</style>
@endpush
