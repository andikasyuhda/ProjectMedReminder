@extends('layouts.admin')

@section('title', 'Edit Jadwal')

@section('content')
<div class="page-header">
    <div class="page-header-content">
        <h1>✏️ Edit Jadwal Obat</h1>
        <p>{{ $schedule->user->name }} - {{ $schedule->medicine->name }}</p>
    </div>
    <div class="page-header-actions">
        <a href="{{ route('admin.schedules.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Kembali</a>
    </div>
</div>

<div class="card">
    <form action="{{ route('admin.schedules.update', $schedule) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="alert alert-info">
            <i class="fas fa-info-circle"></i>
            <div><strong>Pasien:</strong> {{ $schedule->user->name }} ({{ $schedule->user->medical_record_number }})<br>
            <strong>Obat:</strong> {{ $schedule->medicine->name }} {{ $schedule->medicine->strength }}</div>
        </div>
        
        <div class="form-grid">
            <div class="form-group">
                <label class="form-label">Status</label>
                <select name="is_active" class="form-select">
                    <option value="1" {{ $schedule->is_active ? 'selected' : '' }}>Aktif</option>
                    <option value="0" {{ !$schedule->is_active ? 'selected' : '' }}>Nonaktif</option>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Dosis <span class="text-danger">*</span></label>
                <input type="text" name="dosage" class="form-input" value="{{ old('dosage', $schedule->dosage) }}" required>
            </div>
            <div class="form-group">
                <label class="form-label">Frekuensi Per Hari <span class="text-danger">*</span></label>
                <select name="frequency_per_day" class="form-select" id="frequency" required>
                    @for($i = 1; $i <= 4; $i++)
                        <option value="{{ $i }}" {{ old('frequency_per_day', $schedule->frequency_per_day) == $i ? 'selected' : '' }}>{{ $i }}x sehari</option>
                    @endfor
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Tanggal Selesai <span class="text-danger">*</span></label>
                <input type="date" name="end_date" class="form-input" value="{{ old('end_date', $schedule->end_date->format('Y-m-d')) }}" required>
            </div>
        </div>
        
        <div class="form-group">
            <label class="form-label">Waktu Minum Obat <span class="text-danger">*</span></label>
            <div id="time-slots" style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 12px;">
                @foreach($schedule->time_slots as $time)
                    <input type="time" name="time_slots[]" class="form-input" value="{{ $time }}" required>
                @endforeach
            </div>
        </div>
        
        <div class="form-group">
            <label class="form-label">Aturan Pakai <span class="text-danger">*</span></label>
            <select name="instruction" class="form-select" required>
                @foreach(['Sesudah makan', 'Sebelum makan', 'Bersama makanan', 'Sebelum tidur', 'Pagi hari'] as $instr)
                    <option value="{{ $instr }}" {{ old('instruction', $schedule->instruction) == $instr ? 'selected' : '' }}>{{ $instr }}</option>
                @endforeach
            </select>
        </div>
        
        <div class="form-group">
            <label class="form-label">Catatan Khusus</label>
            <textarea name="notes" class="form-textarea" rows="3">{{ old('notes', $schedule->notes) }}</textarea>
        </div>

        <div class="divider" style="margin: 32px 0;"></div>

        <!-- Email Reminder Toggle -->
        <div class="form-group">
            <label style="display: flex; align-items: center; gap: 12px; cursor: pointer; padding: 20px; background: linear-gradient(135deg, #EFF6FF, #DBEAFE); border-radius: 12px; border: 2px solid #3B82F6;">
                <input type="checkbox" name="send_email_reminder" value="1" {{ $schedule->send_email_reminder ? 'checked' : '' }} style="width: 20px; height: 20px; accent-color: #3B82F6; cursor: pointer;">
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

        <div class="alert alert-warning">
            <i class="fas fa-exclamation-triangle"></i>
            <div>
                <strong>Perhatian:</strong> Jika Anda mengubah waktu atau catatan, email notifikasi akan otomatis dikirim ke <strong>{{ $schedule->user->email }}</strong>
            </div>
        </div>

        <div style="display: flex; gap: 12px; margin-top: 24px;">
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan Perubahan</button>
            <a href="{{ route('admin.schedules.index') }}" class="btn btn-secondary"><i class="fas fa-times"></i> Batal</a>
        </div>
    </form>
</div>
@endsection
