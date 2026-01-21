@extends('layouts.patient')

@section('title', 'Dashboard Pasien')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <div class="page-header-content">
        <h1>Selamat Datang, {{ $user->name }} 👋</h1>
        <p><i class="fas fa-calendar-alt"></i> {{ now()->translatedFormat('l, d F Y') }} • {{ $user->medical_record_number }}</p>
    </div>
    <div class="page-header-actions">
        <span class="badge badge-success">
            <i class="fas fa-bell"></i> Email Reminder Aktif
        </span>
    </div>
</div>

<!-- Stats Grid -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-label">JADWAL HARI INI</div>
        <div class="stat-value">{{ $todayCompleted }}/{{ $todayTotal }}</div>
        <div class="stat-trend {{ $todayTotal > 0 ? 'up' : '' }}">
            @if($todayTotal > 0)
                {{ round(($todayCompleted / $todayTotal) * 100) }}% selesai
            @else
                Tidak ada jadwal
            @endif
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-label">KEPATUHAN MINGGU INI</div>
        <div class="stat-value">{{ $weeklyCompliance }}%</div>
        <div class="stat-trend up">
            <i class="fas fa-arrow-up"></i> dari minggu lalu
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-label">TERLEWAT HARI INI</div>
        <div class="stat-value">{{ $todayMissed }}</div>
        <div class="stat-trend {{ $todayMissed > 0 ? 'down' : 'up' }}">
            {{ $todayMissed > 0 ? 'Perlu perhatian' : 'Bagus!' }}
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-label">STREAK BERTURUT</div>
        <div class="stat-value">{{ $streak }}</div>
        <div class="stat-trend">
            Hari berturut 🔥
        </div>
    </div>
</div>

<!-- Info Alert -->
<div class="alert alert-info">
    <i class="fas fa-envelope"></i>
    <div>
        <strong>Pengingat Email Otomatis:</strong> Anda akan menerima email pengingat 30 menit sebelum waktu minum obat di <strong>{{ $user->email }}</strong>
    </div>
</div>

<!-- Today's Schedule -->
<div class="card">
    <div class="card-header">
        <h2 class="card-title">
            <i class="fas fa-clipboard-list"></i> Jadwal Minum Obat Hari Ini
        </h2>
        <a href="{{ route('patient.history') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-history"></i> Lihat Riwayat
        </a>
    </div>
    
    @if($todayLogs->count() > 0)
        <div class="schedule-timeline">
            @foreach($todayLogs as $log)
                @php
                    $statusClass = match($log->status) {
                        'completed' => 'completed',
                        'missed' => 'missed',
                        default => $log->is_current ? 'active' : ''
                    };
                @endphp
                <div class="schedule-item {{ $statusClass }}">
                    <div class="schedule-time">{{ \Carbon\Carbon::parse($log->scheduled_time)->format('H:i') }}</div>
                    <div class="schedule-info">
                        <h3>{{ $log->schedule->medicine->name }} {{ $log->schedule->medicine->strength }}</h3>
                        <div class="schedule-detail">
                            <i class="fas fa-pills"></i>
                            <strong>{{ $log->schedule->dosage }}</strong> • {{ $log->schedule->instruction }}
                        </div>
                        @if($log->schedule->notes)
                            <div class="schedule-detail text-warning">
                                <i class="fas fa-exclamation-triangle"></i>
                                <strong>{{ $log->schedule->notes }}</strong>
                            </div>
                        @endif
                        @if($log->status === 'completed')
                            <div class="schedule-detail text-success">
                                <i class="fas fa-check-circle"></i>
                                <strong>✓ Sudah diminum pukul {{ $log->taken_at->format('H:i') }} WIB</strong>
                            </div>
                        @elseif($log->status === 'missed')
                            <div class="schedule-detail text-danger">
                                <i class="fas fa-times-circle"></i>
                                <strong>✗ Jadwal terlewat</strong>
                            </div>
                        @elseif($log->is_current)
                            <div class="schedule-detail text-primary">
                                <i class="fas fa-clock"></i>
                                <strong>⏰ Saatnya minum obat sekarang!</strong>
                            </div>
                        @endif
                    </div>
                    <div class="schedule-action">
                        @if($log->status === 'completed')
                            <span class="badge badge-success"><i class="fas fa-check"></i> Selesai</span>
                        @elseif($log->status === 'missed')
                            <span class="badge badge-danger"><i class="fas fa-times"></i> Terlewat</span>
                        @elseif($log->status === 'pending')
                            @if($log->is_overdue)
                                <span class="badge badge-warning"><i class="fas fa-exclamation"></i> Terlambat</span>
                            @else
                                <form id="form-{{ $log->id }}" action="{{ route('patient.compliance.taken', $log) }}" method="POST">
                                    @csrf
                                    <button type="button" class="btn btn-primary btn-sm" onclick="confirmMedicineTaken({{ $log->id }}, '{{ $log->schedule->medicine->name }}')">
                                        <i class="fas fa-check-circle"></i>
                                        Tandai Sudah Diminum
                                    </button>
                                </form>
                            @endif
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center" style="padding: 60px 20px; color: var(--text-light);">
            <i class="fas fa-calendar-check" style="font-size: 48px; margin-bottom: 16px; opacity: 0.5;"></i>
            <p style="font-size: 16px;">Tidak ada jadwal minum obat untuk hari ini.</p>
            <p style="font-size: 14px;">Hubungi tenaga kesehatan Anda untuk membuat jadwal.</p>
        </div>
    @endif
</div>

<!-- Active Medications Info -->
@if($activeSchedules->count() > 0)
<div class="card">
    <div class="card-header">
        <h2 class="card-title">
            <i class="fas fa-pills"></i> Obat Aktif Anda
        </h2>
    </div>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Nama Obat</th>
                    <th>Dosis</th>
                    <th>Frekuensi</th>
                    <th>Waktu</th>
                    <th>Periode</th>
                    <th>Sisa Hari</th>
                </tr>
            </thead>
            <tbody>
                @foreach($activeSchedules as $schedule)
                <tr>
                    <td>
                        <strong>{{ $schedule->medicine->name }}</strong><br>
                        <small class="text-muted">{{ $schedule->medicine->strength }} - {{ $schedule->medicine->dosage_form }}</small>
                    </td>
                    <td>{{ $schedule->dosage }}</td>
                    <td>{{ $schedule->frequency_per_day }}x sehari</td>
                    <td>{{ $schedule->formatted_time_slots }}</td>
                    <td>{{ $schedule->period }}</td>
                    <td>
                        @if($schedule->days_remaining <= 3)
                            <span class="badge badge-warning">{{ $schedule->days_remaining }} hari</span>
                        @else
                            <span class="badge badge-info">{{ $schedule->days_remaining }} hari</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif
@endsection

@push('scripts')
<script>
function confirmMedicineTaken(logId, medicineName) {
    Modal.confirm(
        'Konfirmasi Minum Obat',
        `Apakah Anda sudah meminum <strong>${medicineName}</strong>?<br><br>Tindakan ini akan mencatat bahwa Anda telah meminum obat sesuai jadwal.`,
        () => {
            const form = document.getElementById('form-' + logId);
            const button = form.querySelector('button');
            showLoading(button);
            form.submit();
        }
    );
}
</script>
@endpush
