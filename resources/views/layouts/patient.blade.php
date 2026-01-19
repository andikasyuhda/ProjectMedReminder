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
                    <p>Portal Pasien</p>
                </div>
            </div>
        </div>
        
        <nav class="sidebar-nav">
            <div class="nav-section">
                <div class="nav-section-title">Menu Utama</div>
                <a href="{{ route('patient.dashboard') }}" class="nav-item {{ request()->routeIs('patient.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-home"></i>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('patient.history') }}" class="nav-item {{ request()->routeIs('patient.history') ? 'active' : '' }}">
                    <i class="fas fa-history"></i>
                    <span>Riwayat Kepatuhan</span>
                </a>
            </div>
            
            <div class="nav-section">
                <div class="nav-section-title">Akun</div>
                <a href="{{ route('patient.profile') }}" class="nav-item {{ request()->routeIs('patient.profile') ? 'active' : '' }}">
                    <i class="fas fa-user"></i>
                    <span>Profil Saya</span>
                </a>
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
                <div class="user-role">{{ auth()->user()->medical_record_number ?? 'Pasien' }}</div>
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
