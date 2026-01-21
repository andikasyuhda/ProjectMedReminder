@extends('layouts.admin')

@section('title', 'Kirim Email ke Pasien')

@section('content')
<div class="page-header">
    <div class="page-header-content">
        <h1>📧 Kirim Email ke Pasien</h1>
        <p>Kirim email khusus langsung ke pasien</p>
    </div>
    <div class="page-header-actions">
        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Kembali</a>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success">
        <i class="fas fa-check-circle"></i>
        <div>{{ session('success') }}</div>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger">
        <i class="fas fa-exclamation-circle"></i>
        <div>{{ session('error') }}</div>
    </div>
@endif

<div class="card">
    <form action="{{ route('admin.emails.send') }}" method="POST" id="emailForm">
        @csrf

        <div class="alert alert-info">
            <i class="fas fa-info-circle"></i>
            <div>
                <strong>Informasi:</strong> Email akan dikirim menggunakan Resend API dengan template modern yang sama dengan pengingat obat.
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">Pilih Pasien <span class="text-danger">*</span></label>
            <select name="patient_id" id="patientSelect" class="form-select" required>
                <option value="">-- Pilih Pasien --</option>
                @foreach($patients as $patient)
                    <option
                        value="{{ $patient->id }}"
                        data-email="{{ $patient->email }}"
                        {{ $selectedPatient && $selectedPatient->id == $patient->id ? 'selected' : '' }}
                    >
                        {{ $patient->name }} ({{ $patient->medical_record_number }})
                    </option>
                @endforeach
            </select>
            @error('patient_id')
                <span class="text-danger" style="font-size: 13px;">{{ $message }}</span>
            @enderror
        </div>

        <div class="alert" id="patientEmailInfo" style="display: none; background: linear-gradient(135deg, #EFF6FF, #DBEAFE); border: 2px solid #3B82F6; border-radius: 12px;">
            <i class="fas fa-envelope"></i>
            <div>
                <strong>Email akan dikirim ke:</strong> <span id="patientEmailDisplay"></span>
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">Subjek Email <span class="text-danger">*</span></label>
            <input
                type="text"
                name="subject"
                class="form-input"
                value="{{ old('subject') }}"
                placeholder="Contoh: Informasi Penting Terkait Pengobatan Anda"
                required
                maxlength="255"
            >
            @error('subject')
                <span class="text-danger" style="font-size: 13px;">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label">Pesan Email <span class="text-danger">*</span></label>
            <textarea
                name="message"
                class="form-textarea"
                rows="10"
                required
                placeholder="Tulis pesan Anda di sini...&#10;&#10;Pesan akan ditampilkan dengan format yang rapi di email."
                style="font-family: inherit; font-size: 14px; line-height: 1.6;"
            >{{ old('message') }}</textarea>
            <small style="color: #8B7373; font-size: 13px; margin-top: 8px; display: block;">
                <i class="fas fa-lightbulb"></i> Tip: Tulis pesan dengan jelas dan sopan. Gunakan baris baru untuk memisahkan paragraf.
            </small>
            @error('message')
                <span class="text-danger" style="font-size: 13px;">{{ $message }}</span>
            @enderror
        </div>

        <!-- Preview Card -->
        <div class="divider" style="margin: 32px 0;"></div>

        <div style="background: linear-gradient(135deg, #F5E6E6, #FDF5F5); border-radius: 16px; border: 2px solid #E8D5D5; padding: 24px; margin-bottom: 24px;">
            <h3 style="margin: 0 0 16px 0; font-size: 16px; font-weight: 700; color: #7B0000;">
                <i class="fas fa-eye"></i> Preview Email
            </h3>
            <div style="background: white; border-radius: 12px; padding: 20px; border: 1px solid #E8D5D5;">
                <div style="font-size: 14px; color: #5C4545; margin-bottom: 12px;">
                    <strong>Kepada:</strong> <span id="previewTo">-</span>
                </div>
                <div style="font-size: 14px; color: #5C4545; margin-bottom: 12px;">
                    <strong>Subjek:</strong> <span id="previewSubject">-</span>
                </div>
                <div style="font-size: 14px; color: #5C4545; padding-top: 12px; border-top: 1px solid #E8D5D5;">
                    <strong>Isi Pesan:</strong>
                    <div id="previewMessage" style="margin-top: 8px; white-space: pre-wrap; color: #3D0000;">-</div>
                </div>
            </div>
        </div>

        <div style="display: flex; gap: 12px;">
            <button type="submit" class="btn btn-primary" id="sendButton">
                <i class="fas fa-paper-plane"></i> Kirim Email
            </button>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
                <i class="fas fa-times"></i> Batal
            </a>
        </div>
    </form>
</div>

@push('scripts')
<script>
    const patientSelect = document.getElementById('patientSelect');
    const patientEmailInfo = document.getElementById('patientEmailInfo');
    const patientEmailDisplay = document.getElementById('patientEmailDisplay');
    const subjectInput = document.querySelector('input[name="subject"]');
    const messageInput = document.querySelector('textarea[name="message"]');
    const previewTo = document.getElementById('previewTo');
    const previewSubject = document.getElementById('previewSubject');
    const previewMessage = document.getElementById('previewMessage');
    const sendButton = document.getElementById('sendButton');

    // Update email display when patient is selected
    patientSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const email = selectedOption.getAttribute('data-email');

        if (email) {
            patientEmailDisplay.textContent = email;
            patientEmailInfo.style.display = 'flex';
            previewTo.textContent = selectedOption.text + ' (' + email + ')';
        } else {
            patientEmailInfo.style.display = 'none';
            previewTo.textContent = '-';
        }

        updatePreview();
    });

    // Update preview when subject changes
    subjectInput.addEventListener('input', updatePreview);

    // Update preview when message changes
    messageInput.addEventListener('input', updatePreview);

    function updatePreview() {
        const subject = subjectInput.value.trim();
        const message = messageInput.value.trim();

        previewSubject.textContent = subject || '-';
        previewMessage.textContent = message || '-';
    }

    // Form submission with loading state
    document.getElementById('emailForm').addEventListener('submit', function(e) {
        sendButton.disabled = true;
        sendButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Mengirim...';
    });

    // Initialize preview if patient is pre-selected
    if (patientSelect.value) {
        patientSelect.dispatchEvent(new Event('change'));
    }
</script>
@endpush
@endsection
