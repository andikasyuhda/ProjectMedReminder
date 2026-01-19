@extends('layouts.admin')

@section('title', 'Tambah Obat Baru')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <div class="page-header-content">
        <h1>➕ Tambah Obat Baru</h1>
        <p>Tambahkan obat ke database sistem</p>
    </div>
    <div class="page-header-actions">
        <a href="{{ route('admin.medicines.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<div class="card">
    <form action="{{ route('admin.medicines.store') }}" method="POST">
        @csrf
        
        <h3 class="card-title" style="margin-bottom: 24px;"><i class="fas fa-pills"></i> Informasi Obat</h3>
        
        <div class="form-grid">
            <div class="form-group">
                <label class="form-label">Nama Obat <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-input" value="{{ old('name') }}" placeholder="Contoh: Amlodipine" required>
                @error('name')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="form-group">
                <label class="form-label">Nama Generik</label>
                <input type="text" name="generic_name" class="form-input" value="{{ old('generic_name') }}" placeholder="Contoh: Amlodipine Besylate">
                @error('generic_name')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="form-group">
                <label class="form-label">Bentuk Sediaan <span class="text-danger">*</span></label>
                <select name="dosage_form" class="form-select" required>
                    <option value="">Pilih</option>
                    @foreach($dosageForms as $form)
                        <option value="{{ $form }}" {{ old('dosage_form') == $form ? 'selected' : '' }}>{{ $form }}</option>
                    @endforeach
                </select>
                @error('dosage_form')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="form-group">
                <label class="form-label">Kekuatan <span class="text-danger">*</span></label>
                <input type="text" name="strength" class="form-input" value="{{ old('strength') }}" placeholder="Contoh: 5mg" required>
                @error('strength')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="form-group" style="grid-column: span 2;">
                <label class="form-label">Kategori <span class="text-danger">*</span></label>
                <select name="category" class="form-select" required>
                    <option value="">Pilih Kategori</option>
                    @foreach($categories as $category)
                        <option value="{{ $category }}" {{ old('category') == $category ? 'selected' : '' }}>{{ $category }}</option>
                    @endforeach
                </select>
                @error('category')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>
        </div>
        
        <div class="form-group">
            <label class="form-label">Deskripsi</label>
            <textarea name="description" class="form-textarea" rows="3" placeholder="Deskripsi obat dan kegunaannya">{{ old('description') }}</textarea>
            @error('description')
                <span class="form-error">{{ $message }}</span>
            @enderror
        </div>
        
        <div class="form-group">
            <label class="form-label">Efek Samping</label>
            <textarea name="side_effects" class="form-textarea" rows="3" placeholder="Efek samping yang mungkin terjadi">{{ old('side_effects') }}</textarea>
            @error('side_effects')
                <span class="form-error">{{ $message }}</span>
            @enderror
        </div>
        
        <div class="form-group">
            <label class="form-label">Kontraindikasi</label>
            <textarea name="contraindications" class="form-textarea" rows="3" placeholder="Kondisi yang tidak boleh menggunakan obat ini">{{ old('contraindications') }}</textarea>
            @error('contraindications')
                <span class="form-error">{{ $message }}</span>
            @enderror
        </div>
        
        <div class="form-group">
            <label class="form-label">Petunjuk Penggunaan</label>
            <textarea name="instructions" class="form-textarea" rows="3" placeholder="Petunjuk penggunaan obat">{{ old('instructions') }}</textarea>
            @error('instructions')
                <span class="form-error">{{ $message }}</span>
            @enderror
        </div>
        
        <div class="alert alert-info">
            <i class="fas fa-info-circle"></i>
            <div>
                <strong>Catatan:</strong> Kode obat akan digenerate otomatis oleh sistem (format: OBT-XXX).
            </div>
        </div>
        
        <div style="display: flex; gap: 12px; margin-top: 24px;">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Simpan Obat
            </button>
            <a href="{{ route('admin.medicines.index') }}" class="btn btn-secondary">
                <i class="fas fa-times"></i> Batal
            </a>
        </div>
    </form>
</div>
@endsection
