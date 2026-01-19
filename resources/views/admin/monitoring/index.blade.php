@extends('layouts.admin')

@section('title', 'Monitoring Kepatuhan')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <div class="page-header-content">
        <h1>📊 Monitoring Kepatuhan Real-Time</h1>
        <p>Pantau kepatuhan minum obat pasien</p>
    </div>
    <div class="page-header-actions">
        <form action="{{ route('admin.monitoring.index') }}" method="GET" style="display: flex; gap: 12px;">
            <input type="date" name="date" class="form-input" value="{{ $date->format('Y-m-d') }}" style="width: auto;">
            <button type="submit" class="btn btn-primary btn-sm">
                <i class="fas fa-search"></i> Lihat
            </button>
        </form>
    </div>
</div>

<!-- Date Info -->
<div class="alert alert-info">
    <i class="fas fa-calendar-day"></i>
    <div>
        <strong>Monitoring untuk:</strong> {{ $date->translatedFormat('l, d F Y') }}
        @if($date->isToday())
            <span class="badge badge-success" style="margin-left: 8px;">Hari Ini</span>
        @endif
    </div>
</div>

<!-- Patients Compliance Table -->
<div class="card">
    <div class="card-header">
        <h2 class="card-title">Kepatuhan Per Pasien</h2>
        <span class="text-muted">{{ $patients->count() }} pasien memiliki jadwal</span>
    </div>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Nama Pasien</th>
                    <th>Email</th>
                    <th>Total Jadwal</th>
                    <th>Sudah Diminum</th>
                    <th>Menunggu</th>
                    <th>Terlewat</th>
                    <th>Persentase</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($patients as $patient)
                <tr>
                    <td>
                        <div style="display: flex; align-items: center; gap: 12px;">
                            <div style="width: 36px; height: 36px; background: linear-gradient(135deg, var(--primary-light), var(--accent)); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: 700;">
                                {{ strtoupper(substr($patient->name, 0, 1)) }}
                            </div>
                            <div>
                                <strong>{{ $patient->name }}</strong>
                                <br><small class="text-muted">{{ $patient->medical_record_number }}</small>
                            </div>
                        </div>
                    </td>
                    <td>{{ $patient->email }}</td>
                    <td>{{ $patient->day_total }} jadwal</td>
                    <td>
                        @if($patient->day_completed > 0)
                            <span class="text-success font-bold">{{ $patient->day_completed }} ✓</span>
                        @else
                            <span class="text-muted">0</span>
                        @endif
                    </td>
                    <td>
                        @if($patient->day_pending > 0)
                            <span class="text-warning font-bold">{{ $patient->day_pending }}</span>
                        @else
                            <span class="text-muted">0</span>
                        @endif
                    </td>
                    <td>
                        @if($patient->day_missed > 0)
                            <span class="text-danger font-bold">{{ $patient->day_missed }} ✗</span>
                        @else
                            <span class="text-muted">0</span>
                        @endif
                    </td>
                    <td>
                        <strong class="{{ $patient->day_compliance >= 80 ? 'text-success' : ($patient->day_compliance >= 50 ? 'text-warning' : 'text-danger') }}">
                            {{ $patient->day_compliance }}%
                        </strong>
                    </td>
                    <td>
                        @if($patient->day_pending > 0 && $date->isToday())
                            <span class="badge badge-info">Berjalan</span>
                        @elseif($patient->day_compliance >= 80)
                            <span class="badge badge-success">Patuh</span>
                        @elseif($patient->day_compliance >= 50)
                            <span class="badge badge-warning">Monitoring</span>
                        @else
                            <span class="badge badge-danger">Perlu Perhatian</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.monitoring.show', $patient) }}" class="btn btn-outline btn-sm">
                            <i class="fas fa-eye"></i> Detail
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center text-muted" style="padding: 60px;">
                        <i class="fas fa-calendar-check" style="font-size: 48px; opacity: 0.3; margin-bottom: 16px;"></i>
                        <p>Tidak ada pasien dengan jadwal pada tanggal ini.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
