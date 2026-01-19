@extends('layouts.app')

@section('body')
<div class="app-container">
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-header">
            <div class="sidebar-logo">
                <div class="sidebar-logo-icon">
                    <i class="fas fa-heartbeat"></i>
                </div>
                <div class="sidebar-logo-text">
                    <h1>MedReminder</h1>
                    <p>Portal Admin</p>
                </div>
            </div>
        </div>
        
        <nav class="sidebar-nav">
            <div class="nav-section">
                <div class="nav-section-title">Dashboard</div>
                <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Overview</span>
                </a>
                <a href="{{ route('admin.monitoring.index') }}" class="nav-item {{ request()->routeIs('admin.monitoring.*') ? 'active' : '' }}">
                    <i class="fas fa-chart-line"></i>
                    <span>Monitoring</span>
                </a>
            </div>
            
            <div class="nav-section">
                <div class="nav-section-title">Manajemen</div>
                <a href="{{ route('admin.patients.index') }}" class="nav-item {{ request()->routeIs('admin.patients.*') ? 'active' : '' }}">
                    <i class="fas fa-users"></i>
                    <span>Data Pasien</span>
                </a>
                <a href="{{ route('admin.medicines.index') }}" class="nav-item {{ request()->routeIs('admin.medicines.*') ? 'active' : '' }}">
                    <i class="fas fa-pills"></i>
                    <span>Master Obat</span>
                </a>
                <a href="{{ route('admin.schedules.index') }}" class="nav-item {{ request()->routeIs('admin.schedules.*') ? 'active' : '' }}">
                    <i class="fas fa-calendar-alt"></i>
                    <span>Jadwal Obat</span>
                </a>
            </div>
            
            <div class="nav-section">
                <div class="nav-section-title">Akun</div>
                <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                    @csrf
                    <button type="submit" class="nav-item" style="width: 100%; border: none; background: none; cursor: pointer; text-align: left;">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Keluar</span>
                    </button>
                </form>
            </div>
        </nav>
        
        <!-- User Info -->
        <div class="user-menu">
            <div class="user-avatar">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
            <div class="user-info">
                <div class="user-name">{{ auth()->user()->name }}</div>
                <div class="user-role">Tenaga Kesehatan</div>
            </div>
        </div>
    </aside>
    
    <!-- Main Content -->
    <main class="main-content">
        @if(session('success'))
            <div class="alert alert-success alert-flash fade-in" style="transition: all 0.3s ease;">
                <i class="fas fa-check-circle"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif
        
        @if(session('error'))
            <div class="alert alert-danger alert-flash fade-in" style="transition: all 0.3s ease;">
                <i class="fas fa-exclamation-circle"></i>
                <span>{{ session('error') }}</span>
            </div>
        @endif
        
        @yield('content')
    </main>
</div>
@endsection
