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
                        <h3 class="mb-0">Detail Kursus</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('courses.index') }}">Kursus</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Detail</li>
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
                        <div class="card-title">{{ $course->name }}</div>
                    </div>
                    <!--end::Card Header-->
                    <!--begin::Card Body-->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                @if($course->image)
                                    <img src="{{ Storage::url($course->image) }}" alt="{{ $course->name }}" class="img-fluid rounded">
                                @else
                                    <img src="https://via.placeholder.com/400" alt="{{ $course->name }}" class="img-fluid rounded">
                                @endif
                            </div>
                            <div class="col-md-8">
                                <table class="table">
                                    <tr>
                                        <th style="width: 200px">Mentor</th>
                                        <td>{{ $course->mentor->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Deskripsi</th>
                                        <td>{{ $course->description }}</td>
                                    </tr>
                                    <tr>
                                        <th>Harga</th>
                                        <td>Rp {{ number_format($course->price, 0, ',', '.') }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!--end::Card Body-->
                </div>
                <!--end::Card-->

                <!--begin::Card-->
                <div class="card mt-4">
                    <!--begin::Card Header-->
                    <div class="card-header">
                        <div class="card-title">Daftar Booking</div>
                    </div>
                    <!--end::Card Header-->
                    <!--begin::Card Body-->
                    <div class="card-body">
                        @if($course->bookings->count() > 0)
                            <form action="{{ route('courses.batch-action', $course->id) }}" method="POST" id="batch-form">
                                @csrf
                                <div class="mb-4" id="batch-actions" style="display: none;">
                                    @php
                                        $pendingCount = $course->bookings->where('status', 'pending')->count();
                                        $approvedCount = $course->bookings->where('status', 'approved')->count();
                                        $availableQuota = $course->quota - $approvedCount;
                                    @endphp

                                    @if($availableQuota > 0)
                                        <button type="submit" 
                                                name="action" 
                                                value="approve" 
                                                class="btn btn-success"
                                                id="approve-btn"
                                                data-available-quota="{{ $availableQuota }}">
                                            <i class="bi bi-check-lg"></i> Approve Selected
                                            <span class="badge bg-white text-success ms-2">Sisa Kuota: {{ $availableQuota }}</span>
                                        </button>
                                    @endif
                                    <button type="submit" 
                                            name="action" 
                                            value="reject" 
                                            class="btn btn-danger"
                                            id="reject-btn">
                                        <i class="bi bi-x-lg"></i> Reject Selected
                                    </button>
                                </div>

                                @if($availableQuota <= 0)
                                    <div class="alert alert-warning mb-4">
                                        <i class="bi bi-exclamation-triangle"></i> Kuota kursus sudah penuh ({{ $course->quota }} peserta)
                                    </div>
                                @endif

                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th style="width: 50px">
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" id="check-all">
                                                    </div>
                                                </th>
                                                <th>Mentee</th>
                                                <th>Tanggal Booking</th>
                                                <th>Status</th>
                                                <th style="width: 150px">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($course->bookings as $booking)
                                                <tr>
                                                    <td>
                                                        @if($booking->status === 'pending')
                                                            <div class="form-check">
                                                                <input type="checkbox" class="form-check-input booking-checkbox" name="bookings[]" value="{{ $booking->id }}">
                                                            </div>
                                                        @endif
                                                    </td>
                                                    <td>{{ $booking->user->name }}</td>
                                                    <td>{{ $booking->created_at->format('d M Y H:i') }}</td>
                                                    <td>
                                                        @if($booking->status === 'pending')
                                                            <span class="badge bg-warning">Pending</span>
                                                        @elseif($booking->status === 'approved')
                                                            <span class="badge bg-success">Approved</span>
                                                        @else
                                                            <span class="badge bg-danger">Rejected</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($booking->status === 'pending')
                                                            <form action="{{ route('course-bookings.approve', $booking->id) }}" method="POST" class="d-inline">
                                                                @csrf
                                                                @method('PUT')
                                                                <button type="submit" class="btn btn-success btn-sm" title="Approve">
                                                                    <i class="bi bi-check-lg"></i>
                                                                </button>
                                                            </form>
                                                            <form action="{{ route('course-bookings.reject', $booking->id) }}" method="POST" class="d-inline">
                                                                @csrf
                                                                @method('PUT')
                                                                <button type="submit" class="btn btn-danger btn-sm" title="Reject">
                                                                    <i class="bi bi-x-lg"></i>
                                                                </button>
                                                            </form>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </form>
                        @else
                            <div class="alert alert-info mb-0">
                                <i class="bi bi-info-circle"></i> Belum ada booking untuk kursus ini.
                            </div>
                        @endif
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

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const checkAllCheckbox = document.getElementById('check-all');
        const batchActions = document.getElementById('batch-actions');
        const approveBtn = document.getElementById('approve-btn');
        const form = document.getElementById('batch-form');
        let selectedCount = 0;

        // Function to update button visibility
        function updateBatchActionsVisibility() {
            const checkedBoxes = document.querySelectorAll('.booking-checkbox:checked');
            selectedCount = checkedBoxes.length;
            
            if (selectedCount > 0) {
                batchActions.style.display = 'block';
                
                // If approve button exists, check quota
                if (approveBtn) {
                    const availableQuota = parseInt(approveBtn.dataset.availableQuota);
                    if (selectedCount > availableQuota) {
                        approveBtn.disabled = true;
                        approveBtn.title = 'Jumlah yang dipilih melebihi kuota yang tersedia';
                    } else {
                        approveBtn.disabled = false;
                        approveBtn.title = '';
                    }
                }
            } else {
                batchActions.style.display = 'none';
            }
        }

        // Add event listener to all checkboxes
        document.querySelectorAll('.booking-checkbox').forEach(checkbox => {
            checkbox.addEventListener('change', updateBatchActionsVisibility);
        });

        // Handle "Check All" functionality
        if (checkAllCheckbox) {
            checkAllCheckbox.addEventListener('change', function() {
                const bookingCheckboxes = document.querySelectorAll('.booking-checkbox');
                bookingCheckboxes.forEach(checkbox => {
                    checkbox.checked = this.checked;
                });
                updateBatchActionsVisibility();
            });
        }

        // Add form submit validation
        if (form) {
            form.addEventListener('submit', function(e) {
                if (selectedCount === 0) {
                    e.preventDefault();
                    alert('Silakan pilih booking yang akan diproses terlebih dahulu');
                    return false;
                }
                
                if (approveBtn && !approveBtn.disabled && e.submitter.value === 'approve') {
                    const availableQuota = parseInt(approveBtn.dataset.availableQuota);
                    if (selectedCount > availableQuota) {
                        e.preventDefault();
                        alert(`Jumlah yang dipilih (${selectedCount}) melebihi kuota yang tersedia (${availableQuota})`);
                        return false;
                    }
                }
            });
        }
    });
</script>
@endpush
