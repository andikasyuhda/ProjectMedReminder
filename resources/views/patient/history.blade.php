@extends('layouts.patient')

@section('title', 'Riwayat Kepatuhan')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <div class="page-header-content">
        <h1>📊 Riwayat Kepatuhan</h1>
        <p>Rekam jejak pengobatan Anda</p>
    </div>
    <div class="page-header-actions">
        <a href="{{ route('patient.dashboard') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<!-- Overall Stats -->
<div class="stats-grid" style="grid-template-columns: repeat(3, 1fr);">
    <div class="stat-card">
        <div class="stat-label">TOTAL JADWAL</div>
        <div class="stat-value">{{ $overallTotal }}</div>
        <div class="stat-trend">7 hari terakhir</div>
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
            {{ $overallCompliance >= 80 ? 'Sangat Baik' : ($overallCompliance >= 60 ? 'Perlu Ditingkatkan' : 'Perlu Perhatian') }}
        </div>
    </div>
</div>

<!-- Daily History -->
<div class="card">
    <div class="card-header">
        <h2 class="card-title">Statistik Harian</h2>
    </div>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Total Jadwal</th>
                    <th>Sudah Diminum</th>
                    <th>Terlewat</th>
                    <th>Persentase</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($dailySummaries as $day)
                <tr>
                    <td>
                        <strong>{{ $day['date']->translatedFormat('d M Y') }}</strong>
                        @if($day['date']->isToday())
                            <span class="badge badge-info" style="margin-left: 8px;">Hari Ini</span>
                        @endif
                    </td>
                    <td>{{ $day['total'] }} jadwal</td>
                    <td>
                        @if($day['completed'] > 0)
                            <span class="text-success">{{ $day['completed'] }} ✓</span>
                        @else
                            <span class="text-muted">0</span>
                        @endif
                    </td>
                    <td>
                        @if($day['missed'] > 0)
                            <span class="text-danger">{{ $day['missed'] }} ✗</span>
                        @else
                            <span class="text-muted">0</span>
                        @endif
                    </td>
                    <td>
                        <strong class="{{ $day['percentage'] >= 80 ? 'text-success' : ($day['percentage'] >= 50 ? 'text-warning' : 'text-danger') }}">
                            {{ $day['percentage'] }}%
                        </strong>
                    </td>
                    <td>
                        @if($day['pending'] > 0 && $day['date']->isToday())
                            <span class="badge badge-info">Berjalan</span>
                        @elseif($day['percentage'] == 100)
                            <span class="badge badge-success">Sempurna</span>
                        @elseif($day['percentage'] >= 80)
                            <span class="badge badge-success">Baik</span>
                        @elseif($day['percentage'] >= 50)
                            <span class="badge badge-warning">Perlu Perhatian</span>
                        @else
                            <span class="badge badge-danger">Kurang</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted" style="padding: 40px;">
                        Tidak ada data riwayat untuk periode ini.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Tips -->
<div class="card" style="background: linear-gradient(135deg, rgba(123, 0, 0, 0.05), rgba(123, 0, 0, 0.02)); border: 1px solid rgba(123, 0, 0, 0.1);">
    <h3 class="card-title" style="color: var(--primary);"><i class="fas fa-lightbulb"></i> Tips Meningkatkan Kepatuhan</h3>
    <ul style="margin-top: 16px; padding-left: 20px; color: var(--text-secondary);">
        <li style="margin-bottom: 8px;">Letakkan obat di tempat yang mudah terlihat dan dijangkau</li>
        <li style="margin-bottom: 8px;">Atur alarm di ponsel sebagai pengingat tambahan</li>
        <li style="margin-bottom: 8px;">Catat setiap kali minum obat untuk membangun kebiasaan</li>
        <li style="margin-bottom: 8px;">Jangan melewatkan dosis meskipun merasa sehat</li>
        <li>Konsultasikan dengan dokter jika mengalami efek samping</li>
    </ul>
</div>
@endsection
