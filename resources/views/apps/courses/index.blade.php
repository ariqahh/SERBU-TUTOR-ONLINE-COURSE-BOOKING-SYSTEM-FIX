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
                        <h3 class="mb-0">Daftar Kursus</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Kursus</li>
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
                <!--begin::Card-->
                <div class="card">
                    <!--begin::Card Header-->
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h3 class="card-title">Daftar Kursus</h3>
                            <div>
                                <a href="{{ route('courses.create') }}" class="btn btn-primary">
                                    <i class="bi bi-plus-circle"></i> Tambah Kursus
                                </a>
                            </div>
                        </div>
                        <!--begin::Search Form-->
                        <div class="card-tools mt-4">
                            <form action="{{ route('courses.index') }}" method="GET">
                                <div class="input-group">
                                    <input type="text" name="search" class="form-control" placeholder="Cari kursus atau mentor..." value="{{ request('search') }}">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-default">
                                            <i class="bi bi-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!--end::Search Form-->
                    </div>
                    <!--end::Card Header-->
                    <!--begin::Card Body-->
                    <div class="card-body">
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

                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th rowspan="2" class="align-middle">#</th>
                                        <th rowspan="2" class="align-middle">Gambar</th>
                                        <th rowspan="2" class="align-middle">Nama Kursus</th>
                                        <th rowspan="2" class="align-middle">Mentor</th>
                                        <th rowspan="2" class="align-middle">Harga</th>
                                        <th rowspan="2" class="align-middle">Status</th>
                                        <th colspan="3" class="text-center">Jumlah Booking</th>
                                        <th rowspan="2" class="align-middle">Aksi</th>
                                    </tr>
                                    <tr>
                                        <th class="text-center">
                                            <span class="badge bg-warning">Pending</span>
                                        </th>
                                        <th class="text-center">
                                            <span class="badge bg-success">Disetujui</span>
                                        </th>
                                        <th class="text-center">
                                            <span class="badge bg-danger">Ditolak</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($courses as $course)
                                        <tr>
                                            <td>{{ $loop->iteration + $courses->firstItem() - 1 }}</td>
                                            <td>
                                                @if($course->image)
                                                    <img src="{{ Storage::url($course->image) }}" 
                                                         alt="{{ $course->name }}" 
                                                         class="img-thumbnail"
                                                         style="max-width: 50px;">
                                                @else
                                                    <span class="badge bg-secondary">No Image</span>
                                                @endif
                                            </td>
                                            <td>{{ $course->name }}</td>
                                            <td>{{ $course->mentor->name }}</td>
                                            <td>Rp {{ number_format($course->price, 0, ',', '.') }}</td>
                                            <td>
                                                @if($course->status === 'active')
                                                    <span class="badge bg-success">Aktif</span>
                                                @else
                                                    <span class="badge bg-danger">Tidak Aktif</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                {{ $course->bookings->where('status', 'pending')->count() }}
                                            </td>
                                            <td class="text-center">
                                                {{ $course->bookings->where('status', 'approved')->count() }}
                                            </td>
                                            <td class="text-center">
                                                {{ $course->bookings->where('status', 'rejected')->count() }}
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('courses.show', $course) }}" 
                                                       class="btn btn-info btn-sm" 
                                                       title="Detail">
                                                        <i class="bi bi-eye"></i>
                                                    </a>
                                                    <a href="{{ route('courses.edit', $course) }}" 
                                                       class="btn btn-warning btn-sm" 
                                                       title="Edit">
                                                        <i class="bi bi-pencil"></i>
                                                    </a>
                                                    <form action="{{ route('courses.destroy', $course) }}" 
                                                          method="POST" 
                                                          class="d-inline"
                                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus kursus ini?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" 
                                                                class="btn btn-danger btn-sm" 
                                                                title="Hapus">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="10" class="text-center">Tidak ada data kursus</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-4">
                            {{ $courses->withQueryString()->links() }}
                        </div>
                    </div>
                    <!--end::Card Body-->
                </div>
                <!--end::Card-->
            </div>
            <!--end::Container-->
        </div>
        <!--end::App Content-->
    </main>
@endsection

@push('css')
<style>
    .card-tools .input-group {
        width: 250px;
    }

    /* Table Styles */
    .table thead th {
        vertical-align: middle;
        text-align: center;
        border-bottom: 2px solid #dee2e6;
    }

    .table thead tr:first-child th {
        border-top: none;
    }

    .table thead tr:last-child th {
        border-bottom: 2px solid #dee2e6;
    }

    .table tbody td {
        vertical-align: middle;
    }

    /* Badge in header */
    .table thead .badge {
        font-size: 0.75rem;
        padding: 0.35em 0.65em;
    }
</style>
@endpush
