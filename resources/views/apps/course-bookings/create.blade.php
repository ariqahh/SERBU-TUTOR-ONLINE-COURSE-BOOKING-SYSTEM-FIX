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
                        <h3 class="mb-0">Pesan Kursus</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('course-bookings.index') }}">Pemesanan Kursus</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Pesan</li>
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
                        <div class="card-title">Form Pemesanan Kursus</div>
                    </div>
                    <!--end::Card Header-->
                    <!--begin::Card Body-->
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

                        <form action="{{ route('course-bookings.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <!--begin::Course Selection-->
                                    <div class="mb-4">
                                        <label for="course_id" class="form-label required">Pilih Kursus</label>
                                        <select class="form-select @error('course_id') is-invalid @enderror" 
                                                id="course_id" 
                                                name="course_id" 
                                                required>
                                            <option value="">Pilih Kursus</option>
                                            @foreach($courses as $course)
                                                <option value="{{ $course->id }}" 
                                                        {{ old('course_id') == $course->id ? 'selected' : '' }}
                                                        data-price="{{ $course->price }}"
                                                        data-start-date="{{ $course->start_date }}"
                                                        data-end-date="{{ $course->end_date }}"
                                                        data-quota="{{ $course->quota }}"
                                                        data-mentor="{{ $course->mentor->name }}">
                                                    {{ $course->name }} - Rp. {{ number_format($course->price, 0, ',', '.') }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('course_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!--begin::Course Details-->
                                    <div id="course-details" class="card mb-4" style="display: none;">
                                        <div class="card-body">
                                            <h5 class="card-title mb-3">Detail Kursus</h5>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <p class="mb-2">
                                                        <strong>Harga:</strong> 
                                                        <span id="course-price">-</span>
                                                    </p>
                                                    <p class="mb-2">
                                                        <strong>Mentor:</strong> 
                                                        <span id="course-mentor">-</span>
                                                    </p>
                                                </div>
                                                <div class="col-md-6">
                                                    <p class="mb-2">
                                                        <strong>Tanggal Mulai:</strong> 
                                                        <span id="course-start-date">-</span>
                                                    </p>
                                                    <p class="mb-2">
                                                        <strong>Tanggal Selesai:</strong> 
                                                        <span id="course-end-date">-</span>
                                                    </p>
                                                    <p class="mb-2">
                                                        <strong>Sisa Kuota:</strong> 
                                                        <span id="course-quota">-</span>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end::Course Details-->

                                    <!--begin::Payment Proof-->
                                    <div class="mb-4">
                                        <label for="payment_proof" class="form-label required">Bukti Pembayaran</label>
                                        <div class="input-group">
                                            <input type="file" 
                                                   class="form-control @error('payment_proof') is-invalid @enderror" 
                                                   id="payment_proof" 
                                                   name="payment_proof"
                                                   accept="image/*"
                                                   onchange="previewImage(this)"
                                                   required>
                                        </div>
                                        <small class="text-muted">Format: jpeg, png, jpg, gif, svg. Maksimal 2MB.</small>
                                        @error('payment_proof')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <div class="mt-2">
                                            <img id="image-preview" src="#" alt="Preview" style="max-width: 100%; display: none;">
                                        </div>
                                    </div>
                                    <!--end::Payment Proof-->
                                </div>
                            </div>

                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('course-bookings.index') }}" class="btn btn-secondary">
                                    <i class="bi bi-arrow-left"></i> Kembali
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-cart"></i> Pesan Kursus
                                </button>
                            </div>
                        </form>
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
    .required:after {
        content: " *";
        color: red;
    }
</style>
@endpush

@push('scripts')
<script>
    function previewImage(input) {
        const preview = document.getElementById('image-preview');
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            }
            reader.readAsDataURL(input.files[0]);
        } else {
            preview.src = '#';
            preview.style.display = 'none';
        }
    }

    document.getElementById('course_id').addEventListener('change', function() {
        const courseDetails = document.getElementById('course-details');
        const selectedOption = this.options[this.selectedIndex];

        if (this.value) {
            // Format currency
            const price = new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR'
            }).format(selectedOption.dataset.price);

            // Format dates
            const startDate = new Date(selectedOption.dataset.startDate).toLocaleDateString('id-ID', {
                day: 'numeric',
                month: 'long',
                year: 'numeric'
            });
            const endDate = new Date(selectedOption.dataset.endDate).toLocaleDateString('id-ID', {
                day: 'numeric',
                month: 'long',
                year: 'numeric'
            });

            // Update course details
            document.getElementById('course-price').textContent = price;
            document.getElementById('course-mentor').textContent = selectedOption.dataset.mentor;
            document.getElementById('course-start-date').textContent = startDate;
            document.getElementById('course-end-date').textContent = endDate;
            document.getElementById('course-quota').textContent = selectedOption.dataset.quota;

            courseDetails.style.display = 'block';
        } else {
            courseDetails.style.display = 'none';
        }
    });
</script>
@endpush
