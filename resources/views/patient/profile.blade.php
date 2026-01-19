@extends('layouts.patient')

@section('title', 'Profil Saya')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <div class="page-header-content">
        <h1>👤 Profil Saya</h1>
        <p>Informasi data diri Anda</p>
    </div>
</div>

<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px;">
    <!-- Personal Info -->
    <div class="card">
        <h3 class="card-title" style="margin-bottom: 24px;"><i class="fas fa-user"></i> Informasi Pribadi</h3>
        
        <form action="{{ route('patient.profile.update') }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="form-group">
                <label class="form-label">No. Rekam Medis</label>
                <input type="text" class="form-input" value="{{ $user->medical_record_number }}" readonly style="background: var(--bg);">
            </div>
            
            <div class="form-group">
                <label class="form-label">Email</label>
                <input type="email" class="form-input" value="{{ $user->email }}" readonly style="background: var(--bg);">
            </div>
            
            <div class="form-group">
                <label class="form-label">Nama Lengkap</label>
                <input type="text" name="name" class="form-input" value="{{ old('name', $user->name) }}" required>
                @error('name')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="form-group">
                <label class="form-label">No. Telepon</label>
                <input type="tel" name="phone" class="form-input" value="{{ old('phone', $user->phone) }}" placeholder="08xxxxxxxxxx">
                @error('phone')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="form-group">
                <label class="form-label">Alamat</label>
                <textarea name="address" class="form-textarea" rows="3" placeholder="Alamat lengkap">{{ old('address', $user->address) }}</textarea>
                @error('address')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>
            
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Simpan Perubahan
            </button>
        </form>
    </div>
    
    <!-- Password & Info -->
    <div>
        <!-- Change Password -->
        <div class="card">
            <h3 class="card-title" style="margin-bottom: 24px;"><i class="fas fa-lock"></i> Ubah Password</h3>
            
            <form action="{{ route('patient.profile.password') }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="form-group">
                    <label class="form-label">Password Saat Ini</label>
                    <input type="password" name="current_password" class="form-input" required>
                    @error('current_password')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label class="form-label">Password Baru</label>
                    <input type="password" name="password" class="form-input" required>
                    @error('password')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label class="form-label">Konfirmasi Password Baru</label>
                    <input type="password" name="password_confirmation" class="form-input" required>
                </div>
                
                <button type="submit" class="btn btn-secondary">
                    <i class="fas fa-key"></i> Ubah Password
                </button>
            </form>
        </div>
        
        <!-- Medical Info -->
        <div class="card">
            <h3 class="card-title" style="margin-bottom: 24px;"><i class="fas fa-heartbeat"></i> Informasi Medis</h3>
            
            <div style="display: grid; gap: 16px;">
                <div style="display: flex; justify-content: space-between; padding: 12px; background: var(--bg); border-radius: var(--radius);">
                    <span class="text-muted">Tanggal Lahir</span>
                    <strong>{{ $user->birth_date ? $user->birth_date->format('d M Y') : '-' }}</strong>
                </div>
                <div style="display: flex; justify-content: space-between; padding: 12px; background: var(--bg); border-radius: var(--radius);">
                    <span class="text-muted">Usia</span>
                    <strong>{{ $user->age ? $user->age . ' tahun' : '-' }}</strong>
                </div>
                <div style="display: flex; justify-content: space-between; padding: 12px; background: var(--bg); border-radius: var(--radius);">
                    <span class="text-muted">Jenis Kelamin</span>
                    <strong>{{ $user->gender == 'male' ? 'Laki-laki' : ($user->gender == 'female' ? 'Perempuan' : '-') }}</strong>
                </div>
                <div style="display: flex; justify-content: space-between; padding: 12px; background: var(--bg); border-radius: var(--radius);">
                    <span class="text-muted">Target Tekanan Darah</span>
                    <strong class="text-primary">{{ $user->blood_pressure_target ?? '-' }} mmHg</strong>
                </div>
            </div>
            
            <div class="alert alert-info" style="margin-top: 20px;">
                <i class="fas fa-info-circle"></i>
                <span>Informasi medis hanya dapat diubah oleh tenaga kesehatan.</span>
            </div>
        </div>
    </div>
</div>
@endsection
