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
                        <h3 class="mb-0">Pemesanan Kursus</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Pemesanan Kursus</li>
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
                        <div class="card-title">Daftar Pemesanan Kursus</div>
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

                        <!--begin::Search Form-->
                        <form action="{{ route('course-bookings.index') }}" method="GET" class="mb-4">
                            <div class="row g-3">
                                <div class="col-md-3">
                                    <input type="text" 
                                           name="search" 
                                           class="form-control" 
                                           placeholder="Cari kursus..."
                                           value="{{ request('search') }}">
                                </div>
                                <div class="col-md-3">
                                    <select name="status" class="form-select">
                                        <option value="">Semua Status</option>
                                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Disetujui</option>
                                        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-search"></i> Cari
                                    </button>
                                    <a href="{{ route('course-bookings.index') }}" class="btn btn-secondary">
                                        <i class="bi bi-arrow-counterclockwise"></i> Reset
                                    </a>
                                </div>
                            </div>
                        </form>
                        <!--end::Search Form-->

                        <!--begin::Table-->
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kursus</th>
                                        <th>Peserta</th>
                                        <th>Status</th>
                                        <th>Bukti Pembayaran</th>
                                        <th>Tanggal Pemesanan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($bookings as $booking)
                                        <tr>
                                            <td>{{ $bookings->firstItem() + $loop->index }}</td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    @if($booking->course->image)
                                                        <img src="{{ asset('storage/' . $booking->course->image) }}" 
                                                             alt="{{ $booking->course->name }}" 
                                                             class="rounded me-2"
                                                             style="width: 50px; height: 50px; object-fit: cover;">
                                                    @endif
                                                    <div>
                                                        <div class="fw-bold">{{ $booking->course->name }}</div>
                                                        <small class="text-muted">
                                                            Mentor: {{ $booking->course->mentor->name }}
                                                        </small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>{{ $booking->user->name }}</td>
                                            <td>
                                                @switch($booking->status)
                                                    @case('pending')
                                                        <span class="badge bg-warning">Pending</span>
                                                        @break
                                                    @case('approved')
                                                        <span class="badge bg-success">Disetujui</span>
                                                        @break
                                                    @case('rejected')
                                                        <span class="badge bg-danger">Ditolak</span>
                                                        @break
                                                    @default
                                                        <span class="badge bg-secondary">{{ $booking->status }}</span>
                                                @endswitch
                                            </td>
                                            <td>
                                                @if($booking->payment_proof)
                                                    <a href="{{ asset('storage/' . $booking->payment_proof) }}" 
                                                       target="_blank"
                                                       class="btn btn-sm btn-info">
                                                        <i class="bi bi-eye"></i> Lihat Bukti
                                                    </a>
                                                @else
                                                    <span class="text-muted">Belum ada bukti</span>
                                                @endif
                                            </td>
                                            <td>{{ $booking->created_at->format('d/m/Y H:i') }}</td>
                                            <td>
                                                @if($booking->status === 'pending')
                                                    <form action="{{ route('course-bookings.approve', $booking->id) }}" 
                                                          method="POST" 
                                                          class="d-inline">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="submit" 
                                                                class="btn btn-sm btn-success"
                                                                onclick="return confirm('Apakah Anda yakin ingin menyetujui pemesanan ini?')">
                                                            <i class="bi bi-check-lg"></i> Setujui
                                                        </button>
                                                    </form>
                                                    <form action="{{ route('course-bookings.reject', $booking->id) }}" 
                                                          method="POST" 
                                                          class="d-inline">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="submit" 
                                                                class="btn btn-sm btn-danger"
                                                                onclick="return confirm('Apakah Anda yakin ingin menolak pemesanan ini?')">
                                                            <i class="bi bi-x-lg"></i> Tolak
                                                        </button>
                                                    </form>
                                                @endif
                                                <form action="{{ route('course-bookings.destroy', $booking->id) }}" 
                                                      method="POST" 
                                                      class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            class="btn btn-sm btn-danger"
                                                            onclick="return confirm('Apakah Anda yakin ingin menghapus pemesanan ini?')">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center">Tidak ada data pemesanan</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <!--end::Table-->

                        <!--begin::Pagination-->
                        <div class="d-flex justify-content-end mt-4">
                            {{ $bookings->links() }}
                        </div>
                        <!--end::Pagination-->
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
