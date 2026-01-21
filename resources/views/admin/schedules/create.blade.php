@extends('layouts.admin')

@section('title', 'Buat Jadwal Baru')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <div class="page-header-content">
        <h1>➕ Buat Jadwal Obat Baru</h1>
        <p>Atur jadwal minum obat untuk pasien</p>
    </div>
    <div class="page-header-actions">
        <a href="{{ route('admin.schedules.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<div class="card">
    <form action="{{ route('admin.schedules.store') }}" method="POST">
        @csrf
        
        <h3 class="card-title" style="margin-bottom: 24px;"><i class="fas fa-calendar-alt"></i> Detail Jadwal</h3>
        
        <div class="form-grid">
            <div class="form-group">
                <label class="form-label">Pilih Pasien <span class="text-danger">*</span></label>
                <select name="user_id" class="form-select" required>
                    <option value="">Pilih Pasien</option>
                    @foreach($patients as $patient)
                        <option value="{{ $patient->id }}" {{ (old('user_id') ?? $selectedPatient?->id) == $patient->id ? 'selected' : '' }}>
                            {{ $patient->name }} - {{ $patient->medical_record_number }}
                        </option>
                    @endforeach
                </select>
                @error('user_id')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="form-group">
                <label class="form-label">Pilih Obat <span class="text-danger">*</span></label>
                <select name="medicine_id" class="form-select" required>
                    <option value="">Pilih Obat</option>
                    @foreach($medicines as $medicine)
                        <option value="{{ $medicine->id }}" {{ old('medicine_id') == $medicine->id ? 'selected' : '' }}>
                            {{ $medicine->name }} {{ $medicine->strength }} - {{ $medicine->dosage_form }}
                        </option>
                    @endforeach
                </select>
                @error('medicine_id')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="form-group">
                <label class="form-label">Dosis <span class="text-danger">*</span></label>
                <input type="text" name="dosage" class="form-input" value="{{ old('dosage') }}" placeholder="Contoh: 1 tablet" required>
                @error('dosage')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="form-group">
                <label class="form-label">Frekuensi Per Hari <span class="text-danger">*</span></label>
                <select name="frequency_per_day" class="form-select" id="frequency" required>
                    <option value="">Pilih</option>
                    <option value="1" {{ old('frequency_per_day') == 1 ? 'selected' : '' }}>1x sehari</option>
                    <option value="2" {{ old('frequency_per_day') == 2 ? 'selected' : '' }}>2x sehari</option>
                    <option value="3" {{ old('frequency_per_day') == 3 ? 'selected' : '' }}>3x sehari</option>
                    <option value="4" {{ old('frequency_per_day') == 4 ? 'selected' : '' }}>4x sehari</option>
                </select>
                @error('frequency_per_day')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>
        </div>
        
        <div class="form-group">
            <label class="form-label">Waktu Minum Obat <span class="text-danger">*</span></label>
            <div id="time-slots" style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 12px;">
                <input type="time" name="time_slots[]" class="form-input" value="{{ old('time_slots.0', '07:00') }}" required>
            </div>
            <small class="text-muted" style="margin-top: 8px; display: block;">Waktu akan disesuaikan dengan frekuensi yang dipilih</small>
            @error('time_slots')
                <span class="form-error">{{ $message }}</span>
            @enderror
        </div>
        
        <div class="form-group">
            <label class="form-label">Aturan Pakai <span class="text-danger">*</span></label>
            <select name="instruction" class="form-select" required>
                <option value="">Pilih</option>
                <option value="Sesudah makan" {{ old('instruction') == 'Sesudah makan' ? 'selected' : '' }}>Sesudah makan</option>
                <option value="Sebelum makan" {{ old('instruction') == 'Sebelum makan' ? 'selected' : '' }}>Sebelum makan</option>
                <option value="Bersama makanan" {{ old('instruction') == 'Bersama makanan' ? 'selected' : '' }}>Bersama makanan</option>
                <option value="Sebelum tidur" {{ old('instruction') == 'Sebelum tidur' ? 'selected' : '' }}>Sebelum tidur</option>
                <option value="Pagi hari" {{ old('instruction') == 'Pagi hari' ? 'selected' : '' }}>Pagi hari</option>
            </select>
            @error('instruction')
                <span class="form-error">{{ $message }}</span>
            @enderror
        </div>
        
        <div class="form-grid">
            <div class="form-group">
                <label class="form-label">Tanggal Mulai <span class="text-danger">*</span></label>
                <input type="date" name="start_date" class="form-input" value="{{ old('start_date', date('Y-m-d')) }}" required>
                @error('start_date')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="form-group">
                <label class="form-label">Tanggal Selesai <span class="text-danger">*</span></label>
                <input type="date" name="end_date" class="form-input" value="{{ old('end_date') }}" required>
                @error('end_date')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>
        </div>
        
        <div class="form-group">
            <label class="form-label">Catatan Khusus</label>
            <textarea name="notes" class="form-textarea" rows="3" placeholder="Contoh: Antibiotik - harus diminum sampai habis">{{ old('notes') }}</textarea>
            @error('notes')
                <span class="form-error">{{ $message }}</span>
            @enderror
        </div>

        <div class="divider" style="margin: 32px 0;"></div>

        <!-- Email Reminder Toggle -->
        <div class="form-group">
            <label style="display: flex; align-items: center; gap: 12px; cursor: pointer; padding: 20px; background: linear-gradient(135deg, #EFF6FF, #DBEAFE); border-radius: 12px; border: 2px solid #3B82F6;">
                <input type="checkbox" name="send_email_reminder" value="1" checked style="width: 20px; height: 20px; accent-color: #3B82F6; cursor: pointer;">
                <div style="flex: 1;">
                    <div style="font-size: 15px; font-weight: 700; color: #1E40AF; margin-bottom: 4px;">
                        <i class="fas fa-envelope"></i> Kirim Email Pengingat Otomatis
                    </div>
                    <div style="font-size: 13px; color: #1E3A8A;">
                        Pasien akan menerima email pengingat 30 menit sebelum setiap waktu minum obat via Resend
                    </div>
                </div>
            </label>
        </div>

        <div class="alert alert-info">
            <i class="fas fa-info-circle"></i>
            <div>
                <strong>Info:</strong> Email akan dikirim ke <strong>{{ $selectedPatient ? $selectedPatient->email : 'email pasien' }}</strong>. Pastikan email pasien sudah benar.
            </div>
        </div>
        
        <div style="display: flex; gap: 12px; margin-top: 24px;">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Simpan Jadwal
            </button>
            <a href="{{ route('admin.schedules.index') }}" class="btn btn-secondary">
                <i class="fas fa-times"></i> Batal
            </a>
        </div>
    </form>
</div>

@push('scripts')
<script>
document.getElementById('frequency').addEventListener('change', function() {
    const frequency = parseInt(this.value);
    const container = document.getElementById('time-slots');
    
    const defaultTimes = {
        1: ['07:00'],
        2: ['07:00', '19:00'],
        3: ['07:00', '13:00', '19:00'],
        4: ['07:00', '12:00', '17:00', '22:00']
    };
    
    container.innerHTML = '';
    
    if (frequency && defaultTimes[frequency]) {
        defaultTimes[frequency].forEach((time, index) => {
            const input = document.createElement('input');
            input.type = 'time';
            input.name = 'time_slots[]';
            input.className = 'form-input';
            input.value = time;
            input.required = true;
            container.appendChild(input);
        });
    } else {
        const input = document.createElement('input');
        input.type = 'time';
        input.name = 'time_slots[]';
        input.className = 'form-input';
        input.value = '07:00';
        input.required = true;
        container.appendChild(input);
    }
});
</script>
@endpush
@endsection
