@extends('layouts.admin')

@section('title', 'Edit Obat')

@section('content')
<div class="page-header">
    <div class="page-header-content">
        <h1>✏️ Edit Data Obat</h1>
        <p>{{ $medicine->code }} - {{ $medicine->name }}</p>
    </div>
    <div class="page-header-actions">
        <a href="{{ route('admin.medicines.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Kembali</a>
    </div>
</div>

<div class="card">
    <form action="{{ route('admin.medicines.update', $medicine) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="form-grid">
            <div class="form-group">
                <label class="form-label">Kode Obat</label>
                <input type="text" class="form-input" value="{{ $medicine->code }}" readonly style="background: var(--bg);">
            </div>
            <div class="form-group">
                <label class="form-label">Status</label>
                <select name="is_active" class="form-select">
                    <option value="1" {{ $medicine->is_active ? 'selected' : '' }}>Aktif</option>
                    <option value="0" {{ !$medicine->is_active ? 'selected' : '' }}>Nonaktif</option>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Nama Obat <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-input" value="{{ old('name', $medicine->name) }}" required>
            </div>
            <div class="form-group">
                <label class="form-label">Nama Generik</label>
                <input type="text" name="generic_name" class="form-input" value="{{ old('generic_name', $medicine->generic_name) }}">
            </div>
            <div class="form-group">
                <label class="form-label">Bentuk Sediaan <span class="text-danger">*</span></label>
                <select name="dosage_form" class="form-select" required>
                    @foreach($dosageForms as $form)
                        <option value="{{ $form }}" {{ old('dosage_form', $medicine->dosage_form) == $form ? 'selected' : '' }}>{{ $form }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Kekuatan <span class="text-danger">*</span></label>
                <input type="text" name="strength" class="form-input" value="{{ old('strength', $medicine->strength) }}" required>
            </div>
            <div class="form-group" style="grid-column: span 2;">
                <label class="form-label">Kategori <span class="text-danger">*</span></label>
                <select name="category" class="form-select" required>
                    @foreach($categories as $category)
                        <option value="{{ $category }}" {{ old('category', $medicine->category) == $category ? 'selected' : '' }}>{{ $category }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        
        <div class="form-group"><label class="form-label">Deskripsi</label><textarea name="description" class="form-textarea" rows="3">{{ old('description', $medicine->description) }}</textarea></div>
        <div class="form-group"><label class="form-label">Efek Samping</label><textarea name="side_effects" class="form-textarea" rows="3">{{ old('side_effects', $medicine->side_effects) }}</textarea></div>
        <div class="form-group"><label class="form-label">Kontraindikasi</label><textarea name="contraindications" class="form-textarea" rows="3">{{ old('contraindications', $medicine->contraindications) }}</textarea></div>
        <div class="form-group"><label class="form-label">Petunjuk Penggunaan</label><textarea name="instructions" class="form-textarea" rows="3">{{ old('instructions', $medicine->instructions) }}</textarea></div>
        
        <div style="display: flex; gap: 12px; margin-top: 24px;">
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan Perubahan</button>
            <a href="{{ route('admin.medicines.index') }}" class="btn btn-secondary"><i class="fas fa-times"></i> Batal</a>
        </div>
    </form>
</div>
@endsection
