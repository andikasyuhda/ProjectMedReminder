@extends('layouts.admin')

@section('title', 'Detail Monitoring - ' . $patient->name)

@section('content')
<!-- Page Header -->
<div class="page-header">
    <div class="page-header-content">
        <h1>📊 Detail Monitoring: {{ $patient->name }}</h1>
        <p>{{ $patient->medical_record_number }} • {{ $patient->email }}</p>
    </div>
    <div class="page-header-actions">
        <a href="{{ route('admin.monitoring.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
        <a href="{{ route('admin.patients.show', $patient) }}" class="btn btn-outline">
            <i class="fas fa-user"></i> Profil Pasien
        </a>
    </div>
</div>

<!-- Overall Stats -->
<div class="stats-grid" style="grid-template-columns: repeat(3, 1fr);">
    <div class="stat-card">
        <div class="stat-label">TOTAL JADWAL</div>
        <div class="stat-value">{{ $overallTotal }}</div>
        <div class="stat-trend">{{ $startDate->format('d M') }} - {{ $endDate->format('d M Y') }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">SUDAH DIMINUM</div>
        <div class="stat-value">{{ $overallCompleted }}</div>
        <div class="stat-trend up">Selesai</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">TINGKAT KEPATUHAN</div>
        <div class="stat-value">{{ $overallCompliance }}%</div>
        <div class="stat-trend {{ $overallCompliance >= 80 ? 'up' : 'down' }}">
            {{ $overallCompliance >= 80 ? 'Patuh' : ($overallCompliance >= 50 ? 'Perlu Ditingkatkan' : 'Perlu Perhatian') }}
        </div>
    </div>
</div>

<!-- Daily Breakdown -->
<div class="card">
    <div class="card-header">
        <h2 class="card-title">Rincian Harian</h2>
    </div>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Total</th>
                    <th>Diminum</th>
                    <th>Terlewat</th>
                    <th>Kepatuhan</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($dailyData as $day)
                <tr>
                    <td>
                        <strong>{{ $day['date']->translatedFormat('l, d M Y') }}</strong>
                        @if($day['date']->isToday())
                            <span class="badge badge-info" style="margin-left: 8px;">Hari Ini</span>
                        @endif
                    </td>
                    <td>{{ $day['total'] }}</td>
                    <td class="text-success font-bold">{{ $day['completed'] }}</td>
                    <td class="text-danger font-bold">{{ $day['missed'] }}</td>
                    <td>
                        <strong class="{{ $day['compliance'] >= 80 ? 'text-success' : ($day['compliance'] >= 50 ? 'text-warning' : 'text-danger') }}">
                            {{ $day['compliance'] }}%
                        </strong>
                    </td>
                    <td>
                        @if($day['compliance'] == 100)
                            <span class="badge badge-success">Sempurna</span>
                        @elseif($day['compliance'] >= 80)
                            <span class="badge badge-success">Baik</span>
                        @elseif($day['compliance'] >= 50)
                            <span class="badge badge-warning">Perlu Perhatian</span>
                        @else
                            <span class="badge badge-danger">Kurang</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
