@extends('layouts.admin')

@section('title', 'Detail Obat')

@section('content')
<div class="page-header">
    <div class="page-header-content">
        <h1>💊 {{ $medicine->name }} {{ $medicine->strength }}</h1>
        <p>{{ $medicine->code }} • {{ $medicine->category }}</p>
    </div>
    <div class="page-header-actions">
        <a href="{{ route('admin.medicines.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Kembali</a>
        <a href="{{ route('admin.medicines.edit', $medicine) }}" class="btn btn-outline"><i class="fas fa-edit"></i> Edit</a>
    </div>
</div>

<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px;">
    <div class="card">
        <h3 class="card-title"><i class="fas fa-info-circle"></i> Informasi Obat</h3>
        <div style="margin-top: 20px; display: grid; gap: 12px;">
            <div style="padding: 12px; background: var(--bg); border-radius: var(--radius);"><span class="text-muted">Nama Generik:</span><br><strong>{{ $medicine->generic_name ?? '-' }}</strong></div>
            <div style="padding: 12px; background: var(--bg); border-radius: var(--radius);"><span class="text-muted">Bentuk Sediaan:</span><br><strong>{{ $medicine->dosage_form }}</strong></div>
            <div style="padding: 12px; background: var(--bg); border-radius: var(--radius);"><span class="text-muted">Kekuatan:</span><br><strong>{{ $medicine->strength }}</strong></div>
            <div style="padding: 12px; background: var(--bg); border-radius: var(--radius);"><span class="text-muted">Kategori:</span><br><span class="badge badge-primary">{{ $medicine->category }}</span></div>
            <div style="padding: 12px; background: var(--bg); border-radius: var(--radius);"><span class="text-muted">Status:</span><br><span class="badge {{ $medicine->is_active ? 'badge-success' : 'badge-danger' }}">{{ $medicine->is_active ? 'Aktif' : 'Nonaktif' }}</span></div>
        </div>
    </div>
    
    <div class="card">
        <h3 class="card-title"><i class="fas fa-file-medical"></i> Detail Medis</h3>
        <div style="margin-top: 20px;">
            <div style="margin-bottom: 16px;"><strong>Deskripsi:</strong><p class="text-muted" style="margin-top: 4px;">{{ $medicine->description ?? '-' }}</p></div>
            <div style="margin-bottom: 16px;"><strong>Petunjuk Penggunaan:</strong><p class="text-muted" style="margin-top: 4px;">{{ $medicine->instructions ?? '-' }}</p></div>
            <div style="margin-bottom: 16px;"><strong>Efek Samping:</strong><p class="text-warning" style="margin-top: 4px;">{{ $medicine->side_effects ?? '-' }}</p></div>
            <div><strong>Kontraindikasi:</strong><p class="text-danger" style="margin-top: 4px;">{{ $medicine->contraindications ?? '-' }}</p></div>
        </div>
    </div>
</div>

@if($medicine->schedules->count() > 0)
<div class="card">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-users"></i> Pasien yang Menggunakan</h3>
    </div>
    <div class="table-container">
        <table>
            <thead><tr><th>Pasien</th><th>Dosis</th><th>Frekuensi</th><th>Periode</th><th>Aksi</th></tr></thead>
            <tbody>
                @foreach($medicine->schedules as $schedule)
                <tr>
                    <td><strong>{{ $schedule->user->name }}</strong><br><small>{{ $schedule->user->medical_record_number }}</small></td>
                    <td>{{ $schedule->dosage }}</td>
                    <td>{{ $schedule->frequency_per_day }}x sehari</td>
                    <td>{{ $schedule->period }}</td>
                    <td><a href="{{ route('admin.schedules.show', $schedule) }}" class="btn btn-outline btn-sm"><i class="fas fa-eye"></i></a></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif
@endsection
