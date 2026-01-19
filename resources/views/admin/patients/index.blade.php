@extends('layouts.admin')

@section('title', 'Data Pasien')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <div class="page-header-content">
        <h1>👥 Manajemen Data Pasien</h1>
        <p>Kelola informasi pasien dan kontak</p>
    </div>
    <div class="page-header-actions">
        <a href="{{ route('admin.patients.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Pasien Baru
        </a>
    </div>
</div>

<!-- Search & Filter -->
<div class="card" style="padding: 20px;">
    <form action="{{ route('admin.patients.index') }}" method="GET" style="display: flex; gap: 16px; align-items: flex-end; flex-wrap: wrap;">
        <div class="form-group" style="margin-bottom: 0; flex: 1; min-width: 250px;">
            <label class="form-label">Cari Pasien</label>
            <input type="text" name="search" class="form-input" placeholder="Nama, email, atau no. RM..." value="{{ request('search') }}">
        </div>
        <div class="form-group" style="margin-bottom: 0;">
            <label class="form-label">Status</label>
            <select name="status" class="form-select" style="min-width: 150px;">
                <option value="">Semua</option>
                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Nonaktif</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-search"></i> Cari
        </button>
        <a href="{{ route('admin.patients.index') }}" class="btn btn-secondary">
            <i class="fas fa-undo"></i> Reset
        </a>
    </form>
</div>

<!-- Patients Table -->
<div class="card">
    <div class="card-header">
        <h2 class="card-title">Daftar Pasien</h2>
        <span class="text-muted">Total: {{ $patients->total() }} pasien</span>
    </div>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>No. RM</th>
                    <th>Nama Pasien</th>
                    <th>Email</th>
                    <th>Telepon</th>
                    <th>Jadwal Aktif</th>
                    <th>Kepatuhan</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($patients as $patient)
                <tr>
                    <td><strong>{{ $patient->medical_record_number }}</strong></td>
                    <td>
                        <div style="display: flex; align-items: center; gap: 12px;">
                            <div style="width: 36px; height: 36px; background: linear-gradient(135deg, var(--primary-light), var(--accent)); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: 700;">
                                {{ strtoupper(substr($patient->name, 0, 1)) }}
                            </div>
                            <div>
                                <strong>{{ $patient->name }}</strong>
                                @if($patient->age)
                                    <br><small class="text-muted">{{ $patient->age }} tahun</small>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td>{{ $patient->email }}</td>
                    <td>{{ $patient->phone ?? '-' }}</td>
                    <td>{{ $patient->active_schedules_count }} jadwal</td>
                    <td>
                        @php $compliance = $patient->compliance_rate; @endphp
                        <span class="badge {{ $compliance >= 80 ? 'badge-success' : ($compliance >= 50 ? 'badge-warning' : 'badge-danger') }}">
                            {{ $compliance }}%
                        </span>
                    </td>
                    <td>
                        @if($patient->is_active)
                            <span class="badge badge-success">Aktif</span>
                        @else
                            <span class="badge badge-danger">Nonaktif</span>
                        @endif
                    </td>
                    <td>
                        <div style="display: flex; gap: 8px;">
                            <a href="{{ route('admin.patients.show', $patient) }}" class="btn btn-outline btn-sm" title="Detail">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.patients.edit', $patient) }}" class="btn btn-outline btn-sm" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="{{ route('admin.schedules.create', ['patient_id' => $patient->id]) }}" class="btn btn-primary btn-sm" title="Buat Jadwal">
                                <i class="fas fa-calendar-plus"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center text-muted" style="padding: 60px;">
                        <i class="fas fa-users" style="font-size: 48px; opacity: 0.3; margin-bottom: 16px;"></i>
                        <p>Tidak ada data pasien ditemukan.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($patients->hasPages())
    <div style="padding: 20px; border-top: 1px solid var(--border-light);">
        {{ $patients->withQueryString()->links() }}
    </div>
    @endif
</div>
@endsection
