@extends('layouts.admin')

@section('title', 'Jadwal Obat')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <div class="page-header-content">
        <h1>📅 Jadwal Minum Obat</h1>
        <p>Kelola jadwal pengobatan pasien</p>
    </div>
    <div class="page-header-actions">
        <a href="{{ route('admin.schedules.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Buat Jadwal Baru
        </a>
    </div>
</div>

<!-- Filter -->
<div class="card" style="padding: 20px;">
    <form action="{{ route('admin.schedules.index') }}" method="GET" style="display: flex; gap: 16px; align-items: flex-end; flex-wrap: wrap;">
        <div class="form-group" style="margin-bottom: 0; min-width: 250px;">
            <label class="form-label">Filter Pasien</label>
            <select name="patient_id" class="form-select">
                <option value="">Semua Pasien</option>
                @foreach($patients as $patient)
                    <option value="{{ $patient->id }}" {{ request('patient_id') == $patient->id ? 'selected' : '' }}>
                        {{ $patient->name }} ({{ $patient->medical_record_number }})
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group" style="margin-bottom: 0;">
            <label class="form-label">Status</label>
            <select name="status" class="form-select">
                <option value="">Semua</option>
                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                <option value="expired" {{ request('status') == 'expired' ? 'selected' : '' }}>Selesai</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-filter"></i> Filter
        </button>
        <a href="{{ route('admin.schedules.index') }}" class="btn btn-secondary">
            <i class="fas fa-undo"></i> Reset
        </a>
    </form>
</div>

<!-- Schedules Table -->
<div class="card">
    <div class="card-header">
        <h2 class="card-title">Daftar Jadwal</h2>
        <span class="text-muted">Total: {{ $schedules->total() }} jadwal</span>
    </div>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Pasien</th>
                    <th>Obat</th>
                    <th>Dosis & Frekuensi</th>
                    <th>Waktu</th>
                    <th>Periode</th>
                    <th>Sisa Hari</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($schedules as $schedule)
                <tr>
                    <td>
                        <strong>{{ $schedule->user->name }}</strong>
                        <br><small class="text-muted">{{ $schedule->user->medical_record_number }}</small>
                    </td>
                    <td>
                        <strong>{{ $schedule->medicine->name }}</strong>
                        <br><small class="text-muted">{{ $schedule->medicine->strength }}</small>
                    </td>
                    <td>{{ $schedule->dosage }} • {{ $schedule->frequency_per_day }}x sehari</td>
                    <td>{{ $schedule->formatted_time_slots }}</td>
                    <td>{{ $schedule->period }}</td>
                    <td>
                        @if($schedule->is_currently_active)
                            @if($schedule->days_remaining <= 3)
                                <span class="badge badge-warning">{{ $schedule->days_remaining }} hari</span>
                            @else
                                <span class="badge badge-info">{{ $schedule->days_remaining }} hari</span>
                            @endif
                        @else
                            <span class="badge badge-danger">Selesai</span>
                        @endif
                    </td>
                    <td>
                        @if($schedule->is_active && $schedule->is_currently_active)
                            <span class="badge badge-success">Aktif</span>
                        @elseif(!$schedule->is_active)
                            <span class="badge badge-danger">Nonaktif</span>
                        @else
                            <span class="badge badge-warning">Selesai</span>
                        @endif
                    </td>
                    <td>
                        <div style="display: flex; gap: 8px;">
                            <a href="{{ route('admin.schedules.show', $schedule) }}" class="btn btn-outline btn-sm" title="Detail">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.schedules.edit', $schedule) }}" class="btn btn-outline btn-sm" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center text-muted" style="padding: 60px;">
                        <i class="fas fa-calendar" style="font-size: 48px; opacity: 0.3; margin-bottom: 16px;"></i>
                        <p>Tidak ada jadwal ditemukan.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($schedules->hasPages())
    <div style="padding: 20px; border-top: 1px solid var(--border-light);">
        {{ $schedules->withQueryString()->links() }}
    </div>
    @endif
</div>
@endsection
