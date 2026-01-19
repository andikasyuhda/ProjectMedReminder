@extends('layouts.admin')

@section('title', 'Detail Jadwal')

@section('content')
<div class="page-header">
    <div class="page-header-content">
        <h1>📋 Detail Jadwal Obat</h1>
        <p>{{ $schedule->user->name }} - {{ $schedule->medicine->name }}</p>
    </div>
    <div class="page-header-actions">
        <a href="{{ route('admin.schedules.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Kembali</a>
        <a href="{{ route('admin.schedules.edit', $schedule) }}" class="btn btn-outline"><i class="fas fa-edit"></i> Edit</a>
    </div>
</div>

<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px;">
    <div class="card">
        <h3 class="card-title"><i class="fas fa-user"></i> Informasi Pasien</h3>
        <div style="margin-top: 16px; display: grid; gap: 12px;">
            <div style="padding: 12px; background: var(--bg); border-radius: var(--radius);"><span class="text-muted">Nama:</span><br><strong>{{ $schedule->user->name }}</strong></div>
            <div style="padding: 12px; background: var(--bg); border-radius: var(--radius);"><span class="text-muted">No. RM:</span><br><strong>{{ $schedule->user->medical_record_number }}</strong></div>
            <div style="padding: 12px; background: var(--bg); border-radius: var(--radius);"><span class="text-muted">Email:</span><br><strong>{{ $schedule->user->email }}</strong></div>
        </div>
    </div>
    
    <div class="card">
        <h3 class="card-title"><i class="fas fa-pills"></i> Informasi Obat</h3>
        <div style="margin-top: 16px; display: grid; gap: 12px;">
            <div style="padding: 12px; background: var(--bg); border-radius: var(--radius);"><span class="text-muted">Nama Obat:</span><br><strong>{{ $schedule->medicine->full_name }}</strong></div>
            <div style="padding: 12px; background: var(--bg); border-radius: var(--radius);"><span class="text-muted">Dosis:</span><br><strong>{{ $schedule->dosage }}</strong></div>
            <div style="padding: 12px; background: var(--bg); border-radius: var(--radius);"><span class="text-muted">Aturan Pakai:</span><br><strong>{{ $schedule->instruction }}</strong></div>
        </div>
    </div>
</div>

<div class="card">
    <h3 class="card-title"><i class="fas fa-clock"></i> Detail Jadwal</h3>
    <div style="margin-top: 16px; display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px;">
        <div style="padding: 16px; background: var(--bg); border-radius: var(--radius); text-align: center;">
            <div class="text-muted" style="font-size: 12px;">Frekuensi</div>
            <div style="font-size: 24px; font-weight: 800; color: var(--primary);">{{ $schedule->frequency_per_day }}x</div>
            <div class="text-muted">per hari</div>
        </div>
        <div style="padding: 16px; background: var(--bg); border-radius: var(--radius); text-align: center;">
            <div class="text-muted" style="font-size: 12px;">Waktu</div>
            <div style="font-size: 18px; font-weight: 700;">{{ $schedule->formatted_time_slots }}</div>
        </div>
        <div style="padding: 16px; background: var(--bg); border-radius: var(--radius); text-align: center;">
            <div class="text-muted" style="font-size: 12px;">Periode</div>
            <div style="font-size: 16px; font-weight: 700;">{{ $schedule->period }}</div>
        </div>
        <div style="padding: 16px; background: var(--bg); border-radius: var(--radius); text-align: center;">
            <div class="text-muted" style="font-size: 12px;">Sisa</div>
            <div style="font-size: 24px; font-weight: 800; color: {{ $schedule->days_remaining <= 3 ? 'var(--warning)' : 'var(--success)' }};">{{ $schedule->days_remaining }}</div>
            <div class="text-muted">hari</div>
        </div>
    </div>
    @if($schedule->notes)
    <div class="alert alert-warning" style="margin-top: 20px;"><i class="fas fa-exclamation-triangle"></i><strong>Catatan:</strong> {{ $schedule->notes }}</div>
    @endif
</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-history"></i> Log Kepatuhan</h3>
    </div>
    <div class="table-container">
        <table>
            <thead><tr><th>Tanggal</th><th>Waktu</th><th>Status</th><th>Diminum</th><th>Catatan</th></tr></thead>
            <tbody>
                @forelse($complianceLogs as $log)
                <tr>
                    <td>{{ $log->scheduled_date->format('d M Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($log->scheduled_time)->format('H:i') }}</td>
                    <td>
                        @if($log->status == 'completed')<span class="badge badge-success">✓ Diminum</span>
                        @elseif($log->status == 'missed')<span class="badge badge-danger">✗ Terlewat</span>
                        @else<span class="badge badge-warning">Menunggu</span>@endif
                    </td>
                    <td>{{ $log->taken_at ? $log->taken_at->format('H:i') : '-' }}</td>
                    <td>{{ $log->notes ?? '-' }}</td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center text-muted" style="padding: 40px;">Belum ada log.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($complianceLogs->hasPages())
    <div style="padding: 16px; border-top: 1px solid var(--border-light);">{{ $complianceLogs->links() }}</div>
    @endif
</div>
@endsection
