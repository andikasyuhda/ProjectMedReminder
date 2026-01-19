@extends('layouts.admin')

@section('title', 'Master Obat')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <div class="page-header-content">
        <h1>💊 Master Data Obat</h1>
        <p>Database obat untuk jadwal pasien</p>
    </div>
    <div class="page-header-actions">
        <a href="{{ route('admin.medicines.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Obat Baru
        </a>
    </div>
</div>

<!-- Search & Filter -->
<div class="card" style="padding: 20px;">
    <form action="{{ route('admin.medicines.index') }}" method="GET" style="display: flex; gap: 16px; align-items: flex-end; flex-wrap: wrap;">
        <div class="form-group" style="margin-bottom: 0; flex: 1; min-width: 250px;">
            <label class="form-label">Cari Obat</label>
            <input type="text" name="search" class="form-input" placeholder="Nama atau kode obat..." value="{{ request('search') }}">
        </div>
        <div class="form-group" style="margin-bottom: 0;">
            <label class="form-label">Kategori</label>
            <select name="category" class="form-select" style="min-width: 180px;">
                <option value="">Semua Kategori</option>
                @foreach($categories as $category)
                    <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>{{ $category }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-search"></i> Cari
        </button>
        <a href="{{ route('admin.medicines.index') }}" class="btn btn-secondary">
            <i class="fas fa-undo"></i> Reset
        </a>
    </form>
</div>

<!-- Medicines Table -->
<div class="card">
    <div class="card-header">
        <h2 class="card-title">Daftar Obat Hipertensi</h2>
        <span class="text-muted">Total: {{ $medicines->total() }} obat</span>
    </div>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Nama Obat</th>
                    <th>Bentuk Sediaan</th>
                    <th>Kekuatan</th>
                    <th>Kategori</th>
                    <th>Jadwal Aktif</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($medicines as $medicine)
                <tr>
                    <td><strong>{{ $medicine->code }}</strong></td>
                    <td>
                        <strong>{{ $medicine->name }}</strong>
                        @if($medicine->generic_name)
                            <br><small class="text-muted">{{ $medicine->generic_name }}</small>
                        @endif
                    </td>
                    <td>{{ $medicine->dosage_form }}</td>
                    <td>{{ $medicine->strength }}</td>
                    <td>
                        <span class="badge badge-{{ $medicine->category_color }}">{{ $medicine->category }}</span>
                    </td>
                    <td>{{ $medicine->active_schedules_count }} jadwal</td>
                    <td>
                        @if($medicine->is_active)
                            <span class="badge badge-success">Aktif</span>
                        @else
                            <span class="badge badge-danger">Nonaktif</span>
                        @endif
                    </td>
                    <td>
                        <div style="display: flex; gap: 8px;">
                            <a href="{{ route('admin.medicines.show', $medicine) }}" class="btn btn-outline btn-sm" title="Detail">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.medicines.edit', $medicine) }}" class="btn btn-outline btn-sm" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center text-muted" style="padding: 60px;">
                        <i class="fas fa-pills" style="font-size: 48px; opacity: 0.3; margin-bottom: 16px;"></i>
                        <p>Tidak ada data obat ditemukan.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($medicines->hasPages())
    <div style="padding: 20px; border-top: 1px solid var(--border-light);">
        {{ $medicines->withQueryString()->links() }}
    </div>
    @endif
</div>
@endsection
