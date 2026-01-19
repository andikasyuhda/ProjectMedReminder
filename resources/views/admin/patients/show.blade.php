@extends('layouts.admin')

@section('title', 'Detail Pasien')

@section('content')
<div class="page-header">
    <div class="page-header-content">
        <h1>👤 {{ $patient->name }}</h1>
        <p>{{ $patient->medical_record_number }}</p>
    </div>
    <div class="page-header-actions">
        <a href="{{ route('admin.patients.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Kembali</a>
        <a href="{{ route('admin.patients.edit', $patient) }}" class="btn btn-outline"><i class="fas fa-edit"></i> Edit</a>
        <a href="{{ route('admin.schedules.create', ['patient_id' => $patient->id]) }}" class="btn btn-primary"><i class="fas fa-calendar-plus"></i> Buat Jadwal</a>
    </div>
</div>

<div style="display: grid; grid-template-columns: 1fr 2fr; gap: 24px;">
    <!-- Patient Info -->
    <div class="card">
        <h3 class="card-title"><i class="fas fa-user"></i> Informasi Pasien</h3>
        <div style="margin-top: 20px;">
            <div style="text-align: center; margin-bottom: 24px;">
                <div style="width: 80px; height: 80px; background: linear-gradient(135deg, var(--primary-light), var(--accent)); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 32px; font-weight: 700; margin: 0 auto;">
                    {{ strtoupper(substr($patient->name, 0, 1)) }}
                </div>
                <h3 style="margin-top: 12px;">{{ $patient->name }}</h3>
                <span class="badge {{ $patient->is_active ? 'badge-success' : 'badge-danger' }}">{{ $patient->is_active ? 'Aktif' : 'Nonaktif' }}</span>
            </div>
            
            <div style="display: grid; gap: 12px;">
                <div style="padding: 12px; background: var(--bg); border-radius: var(--radius);"><span class="text-muted">Email:</span><br><strong>{{ $patient->email }}</strong></div>
                <div style="padding: 12px; background: var(--bg); border-radius: var(--radius);"><span class="text-muted">Telepon:</span><br><strong>{{ $patient->phone ?? '-' }}</strong></div>
                <div style="padding: 12px; background: var(--bg); border-radius: var(--radius);"><span class="text-muted">Usia:</span><br><strong>{{ $patient->age ? $patient->age . ' tahun' : '-' }}</strong></div>
                <div style="padding: 12px; background: var(--bg); border-radius: var(--radius);"><span class="text-muted">Target TD:</span><br><strong class="text-primary">{{ $patient->blood_pressure_target ?? '-' }} mmHg</strong></div>
                <div style="padding: 12px; background: var(--bg); border-radius: var(--radius);"><span class="text-muted">Kepatuhan:</span><br><strong class="{{ $patient->compliance_rate >= 80 ? 'text-success' : 'text-warning' }}">{{ $patient->compliance_rate }}%</strong></div>
            </div>
        </div>
    </div>
    
    <!-- Active Schedules & Recent Logs -->
    <div>
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-pills"></i> Jadwal Aktif</h3>
            </div>
            @if($activeSchedules->count() > 0)
            <div class="table-container">
                <table>
                    <thead><tr><th>Obat</th><th>Dosis</th><th>Waktu</th><th>Sisa</th></tr></thead>
                    <tbody>
                        @foreach($activeSchedules as $schedule)
                        <tr>
                            <td><strong>{{ $schedule->medicine->name }}</strong><br><small>{{ $schedule->medicine->strength }}</small></td>
                            <td>{{ $schedule->dosage }}</td>
                            <td>{{ $schedule->formatted_time_slots }}</td>
                            <td><span class="badge badge-info">{{ $schedule->days_remaining }} hari</span></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <p class="text-center text-muted" style="padding: 40px;">Tidak ada jadwal aktif.</p>
            @endif
        </div>
        
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-history"></i> Riwayat 7 Hari Terakhir</h3>
                <a href="{{ route('admin.monitoring.show', $patient) }}" class="btn btn-outline btn-sm"><i class="fas fa-chart-line"></i> Detail</a>
            </div>
            @if($logs->count() > 0)
            <div class="table-container">
                <table>
                    <thead><tr><th>Tanggal</th><th>Waktu</th><th>Obat</th><th>Status</th></tr></thead>
                    <tbody>
                        @foreach($logs->take(10) as $log)
                        <tr>
                            <td>{{ $log->scheduled_date->format('d M') }}</td>
                            <td>{{ \Carbon\Carbon::parse($log->scheduled_time)->format('H:i') }}</td>
                            <td>{{ $log->schedule->medicine->name }}</td>
                            <td>
                                @if($log->status == 'completed')<span class="badge badge-success">✓ Diminum</span>
                                @elseif($log->status == 'missed')<span class="badge badge-danger">✗ Terlewat</span>
                                @else<span class="badge badge-warning">Menunggu</span>@endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <p class="text-center text-muted" style="padding: 40px;">Belum ada riwayat.</p>
            @endif
        </div>
    </div>
</div>
@endsection
