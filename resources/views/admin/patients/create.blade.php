@extends('layouts.admin')

@section('title', 'Tambah Pasien Baru')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <div class="page-header-content">
        <h1>➕ Tambah Pasien Baru</h1>
        <p>Daftarkan pasien baru ke dalam sistem</p>
    </div>
    <div class="page-header-actions">
        <a href="{{ route('admin.patients.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<div class="card">
    <form action="{{ route('admin.patients.store') }}" method="POST">
        @csrf
        
        <h3 class="card-title" style="margin-bottom: 24px;"><i class="fas fa-user"></i> Informasi Pribadi</h3>
        
        <div class="form-grid">
            <div class="form-group">
                <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-input" value="{{ old('name') }}" placeholder="Masukkan nama lengkap" required>
                @error('name')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="form-group">
                <label class="form-label">Email <span class="text-danger">*</span></label>
                <input type="email" name="email" class="form-input" value="{{ old('email') }}" placeholder="contoh@email.com" required>
                @error('email')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="form-group">
                <label class="form-label">Password <span class="text-danger">*</span></label>
                <input type="password" name="password" class="form-input" placeholder="Min. 8 karakter" required>
                @error('password')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="form-group">
                <label class="form-label">No. Telepon</label>
                <input type="tel" name="phone" class="form-input" value="{{ old('phone') }}" placeholder="08xxxxxxxxxx">
                @error('phone')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="form-group">
                <label class="form-label">Tanggal Lahir</label>
                <input type="date" name="birth_date" class="form-input" value="{{ old('birth_date') }}">
                @error('birth_date')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="form-group">
                <label class="form-label">Jenis Kelamin</label>
                <select name="gender" class="form-select">
                    <option value="">Pilih</option>
                    <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Perempuan</option>
                </select>
                @error('gender')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>
        </div>
        
        <div class="form-group">
            <label class="form-label">Alamat</label>
            <textarea name="address" class="form-textarea" rows="3" placeholder="Alamat lengkap pasien">{{ old('address') }}</textarea>
            @error('address')
                <span class="form-error">{{ $message }}</span>
            @enderror
        </div>
        
        <hr style="margin: 32px 0; border: none; border-top: 2px solid var(--bg);">
        
        <h3 class="card-title" style="margin-bottom: 24px;"><i class="fas fa-heartbeat"></i> Informasi Medis</h3>
        
        <div class="form-grid">
            <div class="form-group">
                <label class="form-label">Target Tekanan Darah</label>
                <input type="text" name="blood_pressure_target" class="form-input" value="{{ old('blood_pressure_target') }}" placeholder="Contoh: 130/85">
                @error('blood_pressure_target')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>
        </div>
        
        <div class="alert alert-info">
            <i class="fas fa-info-circle"></i>
            <div>
                <strong>Catatan:</strong> No. Rekam Medis akan digenerate otomatis oleh sistem. Pasien dapat login menggunakan email dan password yang didaftarkan.
            </div>
        </div>
        
        <div style="display: flex; gap: 12px; margin-top: 24px;">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Simpan Pasien
            </button>
            <a href="{{ route('admin.patients.index') }}" class="btn btn-secondary">
                <i class="fas fa-times"></i> Batal
            </a>
        </div>
    </form>
</div>
@endsection
