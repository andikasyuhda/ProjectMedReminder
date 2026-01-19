@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <div class="page-header-content">
        <h1>📊 Dashboard Monitoring</h1>
        <p>Overview kepatuhan pasien dan sistem</p>
    </div>
    <div class="page-header-actions">
        <a href="{{ route('admin.schedules.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Buat Jadwal Baru
        </a>
    </div>
</div>

<!-- Stats Grid -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-label">TOTAL PASIEN</div>
        <div class="stat-value">{{ $totalPatients }}</div>
        <div class="stat-trend up">
            <i class="fas fa-users"></i> Pasien aktif
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-label">JADWAL AKTIF</div>
        <div class="stat-value">{{ $activeSchedules }}</div>
        <div class="stat-trend">Sedang berjalan</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">PERLU PERHATIAN</div>
        <div class="stat-value">{{ $patientsNeedingAttention->count() }}</div>
        <div class="stat-trend down">Kepatuhan < 80%</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">KEPATUHAN HARI INI</div>
        <div class="stat-value">{{ $todayStats['total'] > 0 ? round(($todayStats['completed'] / $todayStats['total']) * 100) : 0 }}%</div>
        <div class="stat-trend">
            {{ $todayStats['completed'] }}/{{ $todayStats['total'] }} selesai
        </div>
    </div>
</div>

<!-- Patients Need Attention -->
@if($patientsNeedingAttention->count() > 0)
<div class="card">
    <div class="card-header">
        <h2 class="card-title">🚨 Pasien Perlu Perhatian (Kepatuhan < 80%)</h2>
        <a href="{{ route('admin.monitoring.index') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-chart-line"></i> Lihat Semua
        </a>
    </div>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>No. RM</th>
                    <th>Nama Pasien</th>
                    <th>Email</th>
                    <th>Kepatuhan Minggu Ini</th>
                    <th>Terlewat</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($patientsNeedingAttention as $patient)
                <tr>
                    <td><strong>{{ $patient->medical_record_number }}</strong></td>
                    <td>{{ $patient->name }}</td>
                    <td>{{ $patient->email }}</td>
                    <td>
                        <strong class="{{ $patient->weekly_compliance < 50 ? 'text-danger' : 'text-warning' }}">
                            {{ $patient->weekly_compliance }}%
                        </strong>
                    </td>
                    <td>{{ $patient->missed_count }} kali</td>
                    <td>
                        @if($patient->weekly_compliance < 50)
                            <span class="badge badge-danger">Perlu Perhatian</span>
                        @else
                            <span class="badge badge-warning">Monitoring</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.monitoring.show', $patient) }}" class="btn btn-outline btn-sm">
                            <i class="fas fa-eye"></i> Detail
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

<!-- Today's Stats and Email Status -->
<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px;">
    <!-- Today's Compliance -->
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">📋 Kepatuhan Hari Ini</h2>
        </div>
        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px;">
            <div style="text-align: center; padding: 20px; background: var(--success-light); border-radius: var(--radius); border-left: 4px solid var(--success);">
                <div style="font-size: 32px; font-weight: 900; color: var(--success);">{{ $todayStats['completed'] }}</div>
                <div style="font-size: 13px; color: var(--text-secondary);">Selesai</div>
            </div>
            <div style="text-align: center; padding: 20px; background: var(--info-light); border-radius: var(--radius); border-left: 4px solid var(--info);">
                <div style="font-size: 32px; font-weight: 900; color: var(--info);">{{ $todayStats['pending'] }}</div>
                <div style="font-size: 13px; color: var(--text-secondary);">Menunggu</div>
            </div>
            <div style="text-align: center; padding: 20px; background: var(--danger-light); border-radius: var(--radius); border-left: 4px solid var(--danger);">
                <div style="font-size: 32px; font-weight: 900; color: var(--danger);">{{ $todayStats['missed'] }}</div>
                <div style="font-size: 13px; color: var(--text-secondary);">Terlewat</div>
            </div>
        </div>
    </div>
    
    <!-- Email Status -->
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">📧 Status Email Hari Ini</h2>
        </div>
        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px;">
            <div style="text-align: center; padding: 20px; background: var(--success-light); border-radius: var(--radius); border-left: 4px solid var(--success);">
                <div style="font-size: 32px; font-weight: 900; color: var(--success);">{{ $emailStats['sent'] }}</div>
                <div style="font-size: 13px; color: var(--text-secondary);">Terkirim</div>
            </div>
            <div style="text-align: center; padding: 20px; background: var(--warning-light); border-radius: var(--radius); border-left: 4px solid var(--warning);">
                <div style="font-size: 32px; font-weight: 900; color: var(--warning);">{{ $emailStats['pending'] }}</div>
                <div style="font-size: 13px; color: var(--text-secondary);">Dalam Antrian</div>
            </div>
            <div style="text-align: center; padding: 20px; background: var(--danger-light); border-radius: var(--radius); border-left: 4px solid var(--danger);">
                <div style="font-size: 32px; font-weight: 900; color: var(--danger);">{{ $emailStats['failed'] }}</div>
                <div style="font-size: 13px; color: var(--text-secondary);">Gagal</div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="card">
    <div class="card-header">
        <h2 class="card-title">⚡ Aksi Cepat</h2>
    </div>
    <div style="display: flex; gap: 16px; flex-wrap: wrap;">
        <a href="{{ route('admin.patients.create') }}" class="btn btn-secondary">
            <i class="fas fa-user-plus"></i> Tambah Pasien Baru
        </a>
        <a href="{{ route('admin.medicines.create') }}" class="btn btn-secondary">
            <i class="fas fa-pills"></i> Tambah Obat Baru
        </a>
        <a href="{{ route('admin.schedules.create') }}" class="btn btn-secondary">
            <i class="fas fa-calendar-plus"></i> Buat Jadwal Baru
        </a>
        <a href="{{ route('admin.monitoring.index') }}" class="btn btn-secondary">
            <i class="fas fa-chart-line"></i> Monitoring Real-time
        </a>
    </div>
</div>
@endsection
