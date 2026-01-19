@extends('layouts.admin')

@section('title', 'Edit Pasien')

@section('content')
<div class="page-header">
    <div class="page-header-content">
        <h1>✏️ Edit Data Pasien</h1>
        <p>{{ $patient->medical_record_number }} - {{ $patient->name }}</p>
    </div>
    <div class="page-header-actions">
        <a href="{{ route('admin.patients.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<div class="card">
    <form action="{{ route('admin.patients.update', $patient) }}" method="POST">
        @csrf
        @method('PUT')
        
        <h3 class="card-title" style="margin-bottom: 24px;"><i class="fas fa-user"></i> Informasi Pribadi</h3>
        
        <div class="form-grid">
            <div class="form-group">
                <label class="form-label">No. Rekam Medis</label>
                <input type="text" class="form-input" value="{{ $patient->medical_record_number }}" readonly style="background: var(--bg);">
            </div>
            
            <div class="form-group">
                <label class="form-label">Status</label>
                <select name="is_active" class="form-select">
                    <option value="1" {{ $patient->is_active ? 'selected' : '' }}>Aktif</option>
                    <option value="0" {{ !$patient->is_active ? 'selected' : '' }}>Nonaktif</option>
                </select>
            </div>
            
            <div class="form-group">
                <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-input" value="{{ old('name', $patient->name) }}" required>
                @error('name')<span class="form-error">{{ $message }}</span>@enderror
            </div>
            
            <div class="form-group">
                <label class="form-label">Email <span class="text-danger">*</span></label>
                <input type="email" name="email" class="form-input" value="{{ old('email', $patient->email) }}" required>
                @error('email')<span class="form-error">{{ $message }}</span>@enderror
            </div>
            
            <div class="form-group">
                <label class="form-label">No. Telepon</label>
                <input type="tel" name="phone" class="form-input" value="{{ old('phone', $patient->phone) }}">
            </div>
            
            <div class="form-group">
                <label class="form-label">Tanggal Lahir</label>
                <input type="date" name="birth_date" class="form-input" value="{{ old('birth_date', $patient->birth_date?->format('Y-m-d')) }}">
            </div>
            
            <div class="form-group">
                <label class="form-label">Jenis Kelamin</label>
                <select name="gender" class="form-select">
                    <option value="">Pilih</option>
                    <option value="male" {{ old('gender', $patient->gender) == 'male' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="female" {{ old('gender', $patient->gender) == 'female' ? 'selected' : '' }}>Perempuan</option>
                </select>
            </div>
            
            <div class="form-group">
                <label class="form-label">Target Tekanan Darah</label>
                <input type="text" name="blood_pressure_target" class="form-input" value="{{ old('blood_pressure_target', $patient->blood_pressure_target) }}">
            </div>
        </div>
        
        <div class="form-group">
            <label class="form-label">Alamat</label>
            <textarea name="address" class="form-textarea" rows="3">{{ old('address', $patient->address) }}</textarea>
        </div>
        
        <div style="display: flex; gap: 12px; margin-top: 24px;">
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan Perubahan</button>
            <a href="{{ route('admin.patients.index') }}" class="btn btn-secondary"><i class="fas fa-times"></i> Batal</a>
        </div>
    </form>
</div>
@endsection
