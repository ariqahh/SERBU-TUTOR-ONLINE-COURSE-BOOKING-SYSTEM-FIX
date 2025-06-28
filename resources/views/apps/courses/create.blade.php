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
                        <h3 class="mb-0">Tambah Kursus</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('courses.index') }}">Kursus</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Tambah</li>
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
                        <div class="card-title">Form Tambah Kursus</div>
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

                        <form action="{{ route('courses.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-8">
                                    <!--begin::Basic Info-->
                                    <div class="mb-4">
                                        <label for="name" class="form-label required">Nama Kursus</label>
                                        <input type="text" 
                                               class="form-control @error('name') is-invalid @enderror" 
                                               id="name" 
                                               name="name" 
                                               value="{{ old('name') }}"
                                               required>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-4">
                                        <label for="description" class="form-label required">Deskripsi</label>
                                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                                  id="description" 
                                                  name="description" 
                                                  rows="5" 
                                                  required>{{ old('description') }}</textarea>
                                        @error('description')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-4">
                                        <label for="mentor_id" class="form-label required">Mentor</label>
                                        <select class="form-select @error('mentor_id') is-invalid @enderror" 
                                                id="mentor_id" 
                                                name="mentor_id" 
                                                required>
                                            <option value="">Pilih Mentor</option>
                                            @foreach($mentors as $mentor)
                                                <option value="{{ $mentor->id }}" 
                                                        {{ old('mentor_id') == $mentor->id ? 'selected' : '' }}>
                                                    {{ $mentor->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('mentor_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-4">
                                        <label for="start_date" class="form-label required">Tanggal Mulai</label>
                                        <input type="date" 
                                               class="form-control @error('start_date') is-invalid @enderror" 
                                               id="start_date" 
                                               name="start_date"
                                               value="{{ old('start_date') }}"
                                               required>
                                        @error('start_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-4">
                                        <label for="end_date" class="form-label required">Tanggal Selesai</label>
                                        <input type="date" 
                                               class="form-control @error('end_date') is-invalid @enderror" 
                                               id="end_date" 
                                               name="end_date"
                                               value="{{ old('end_date') }}"
                                               required>
                                        @error('end_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-4">
                                        <label for="quota" class="form-label required">Kuota</label>
                                        <input type="number" 
                                               class="form-control @error('quota') is-invalid @enderror" 
                                               id="quota" 
                                               name="quota"
                                               value="{{ old('quota') }}"
                                               required>
                                        @error('quota')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <!--end::Basic Info-->
                                </div>

                                <div class="col-md-4">
                                    <!--begin::Media-->
                                    <div class="mb-4">
                                        <label for="image" class="form-label">Gambar Kursus</label>
                                        <div class="input-group">
                                            <input type="file" 
                                                   class="form-control @error('image') is-invalid @enderror" 
                                                   id="image" 
                                                   name="image"
                                                   accept="image/*"
                                                   onchange="previewImage(this)">
                                        </div>
                                        <small class="text-muted">Format: jpeg, png, jpg, gif, svg. Maksimal 2MB.</small>
                                        @error('image')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <div class="mt-2">
                                            <img id="image-preview" src="#" alt="Preview" style="max-width: 100%; display: none;">
                                        </div>
                                    </div>

                                    <div class="mb-4">
                                        <label for="price" class="form-label required">Harga (Rp)</label>
                                        <input type="number" 
                                               class="form-control @error('price') is-invalid @enderror" 
                                               id="price" 
                                               name="price" 
                                               value="{{ old('price', 0) }}"
                                               min="0"
                                               required>
                                        @error('price')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-4">
                                        <label for="status" class="form-label required">Status</label>
                                        <select class="form-select @error('status') is-invalid @enderror" 
                                                id="status" 
                                                name="status" 
                                                required>
                                            <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                                            <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Published</option>
                                        </select>
                                        @error('status')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <!--end::Media-->
                                </div>
                            </div>

                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('courses.index') }}" class="btn btn-secondary">
                                    <i class="bi bi-arrow-left"></i> Kembali
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-save"></i> Simpan
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
</script>
@endpush
