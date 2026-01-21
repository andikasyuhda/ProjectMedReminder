<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'MedReminder') - Sistem Pengingat Minum Obat</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        :root {
            /* Dark Red/Maroon Color Palette */
            --primary: #7B0000;
            --primary-dark: #5C0000;
            --primary-light: #9B0000;
            --primary-lighter: #B71C1C;
            --secondary: #3D0000;
            --accent: #C62828;
            
            /* Neutral Colors */
            --bg: #FDF5F5;
            --bg-alt: #F5E6E6;
            --surface: #FFFFFF;
            --text: #1E1E1E;
            --text-secondary: #5C4545;
            --text-light: #8B7373;
            --border: #E8D5D5;
            --border-light: #F0E0E0;
            
            /* Status Colors */
            --success: #10B981;
            --success-light: #ECFDF5;
            --warning: #F59E0B;
            --warning-light: #FEF3C7;
            --danger: #EF4444;
            --danger-light: #FEE2E2;
            --info: #3B82F6;
            --info-light: #EFF6FF;
            
            /* Shadows */
            --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
            --shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);
            --shadow-md: 0 10px 15px -3px rgb(0 0 0 / 0.1);
            --shadow-lg: 0 25px 50px -12px rgb(0 0 0 / 0.25);
            
            /* Border Radius */
            --radius-sm: 6px;
            --radius: 10px;
            --radius-lg: 16px;
            --radius-xl: 24px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: var(--bg);
            color: var(--text);
            line-height: 1.6;
        }

        /* Animations */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes slideIn {
            from { opacity: 0; transform: translateX(-20px); }
            to { opacity: 1; transform: translateX(0); }
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }

        .fade-in {
            animation: fadeIn 0.4s ease-out forwards;
        }

        /* Layout */
        .app-container {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            width: 280px;
            background: linear-gradient(180deg, var(--secondary) 0%, var(--primary-dark) 100%);
            padding: 0;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
            z-index: 100;
        }

        .sidebar-header {
            padding: 28px 24px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .sidebar-logo {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .sidebar-logo-icon {
            width: 48px;
            height: 48px;
            background: linear-gradient(135deg, var(--primary-light), var(--accent));
            border-radius: var(--radius);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 24px;
        }

        .sidebar-logo-text h1 {
            color: white;
            font-size: 20px;
            font-weight: 800;
            letter-spacing: -0.5px;
        }

        .sidebar-logo-text p {
            color: rgba(255,255,255,0.7);
            font-size: 12px;
            font-weight: 500;
        }

        .sidebar-nav {
            padding: 20px 0;
        }

        .nav-section {
            margin-bottom: 24px;
        }

        .nav-section-title {
            color: rgba(255,255,255,0.4);
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 0 24px;
            margin-bottom: 8px;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 14px 24px;
            color: rgba(255,255,255,0.7);
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            border-left: 3px solid transparent;
            transition: all 0.2s ease;
        }

        .nav-item:hover {
            background: rgba(255,255,255,0.08);
            color: white;
        }

        .nav-item.active {
            background: rgba(255,255,255,0.12);
            color: white;
            border-left-color: var(--accent);
        }

        .nav-item i {
            font-size: 18px;
            width: 20px;
            text-align: center;
        }

        .nav-item .badge {
            margin-left: auto;
            background: var(--accent);
            color: white;
            font-size: 11px;
            padding: 2px 8px;
            border-radius: 10px;
            font-weight: 600;
        }

        /* Main Content */
        .main-content {
            flex: 1;
            margin-left: 280px;
            padding: 32px;
            min-height: 100vh;
        }

        /* Page Header */
        .page-header {
            background: var(--surface);
            padding: 24px 32px;
            border-radius: var(--radius-lg);
            margin-bottom: 28px;
            box-shadow: var(--shadow);
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-left: 4px solid var(--primary);
        }

        .page-header-content h1 {
            font-size: 26px;
            font-weight: 800;
            color: var(--text);
            margin-bottom: 4px;
        }

        .page-header-content p {
            color: var(--text-secondary);
            font-size: 14px;
        }

        .page-header-actions {
            display: flex;
            gap: 12px;
            align-items: center;
        }

        /* Cards */
        .card {
            background: var(--surface);
            border-radius: var(--radius-lg);
            padding: 28px;
            margin-bottom: 24px;
            box-shadow: var(--shadow);
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
            padding-bottom: 16px;
            border-bottom: 2px solid var(--bg);
        }

        .card-title {
            font-size: 18px;
            font-weight: 700;
            color: var(--text);
        }

        /* Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-bottom: 28px;
        }

        .stat-card {
            background: var(--surface);
            padding: 24px;
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow);
            border-left: 4px solid var(--primary);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        .stat-card:nth-child(2) { border-left-color: var(--success); }
        .stat-card:nth-child(3) { border-left-color: var(--warning); }
        .stat-card:nth-child(4) { border-left-color: var(--info); }

        .stat-label {
            font-size: 12px;
            color: var(--text-light);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
        }

        .stat-value {
            font-size: 36px;
            font-weight: 900;
            color: var(--text);
            line-height: 1;
        }

        .stat-trend {
            font-size: 13px;
            margin-top: 8px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .stat-trend.up { color: var(--success); }
        .stat-trend.down { color: var(--danger); }

        /* Buttons */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 12px 24px;
            border: none;
            border-radius: var(--radius);
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
            text-decoration: none;
        }

        .btn:hover {
            transform: translateY(-1px);
            box-shadow: var(--shadow-md);
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, var(--primary-light), var(--primary));
        }

        .btn-secondary {
            background: var(--bg);
            color: var(--text);
            border: 2px solid var(--border);
        }

        .btn-secondary:hover {
            background: var(--bg-alt);
            border-color: var(--primary);
        }

        .btn-success {
            background: linear-gradient(135deg, var(--success), #059669);
            color: white;
        }

        .btn-danger {
            background: linear-gradient(135deg, var(--danger), #DC2626);
            color: white;
        }

        .btn-outline {
            background: transparent;
            color: var(--primary);
            border: 2px solid var(--primary);
        }

        .btn-outline:hover {
            background: var(--primary);
            color: white;
        }

        .btn-sm {
            padding: 8px 16px;
            font-size: 13px;
        }

        .btn-lg {
            padding: 16px 32px;
            font-size: 16px;
        }

        /* Forms */
        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            font-weight: 600;
            margin-bottom: 8px;
            font-size: 14px;
            color: var(--text);
        }

        .form-input,
        .form-select,
        .form-textarea {
            width: 100%;
            padding: 14px 16px;
            border: 2px solid var(--border);
            border-radius: var(--radius);
            font-size: 14px;
            font-family: inherit;
            transition: all 0.2s ease;
            background: var(--surface);
        }

        .form-input:focus,
        .form-select:focus,
        .form-textarea:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(123, 0, 0, 0.1);
        }

        .form-input::placeholder {
            color: var(--text-light);
        }

        .form-textarea {
            min-height: 120px;
            resize: vertical;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        .form-error {
            color: var(--danger);
            font-size: 13px;
            margin-top: 4px;
        }

        /* Tables */
        .table-container {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            text-align: left;
            padding: 14px 16px;
            background: var(--bg);
            font-size: 12px;
            font-weight: 700;
            color: var(--text-secondary);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 2px solid var(--border);
        }

        td {
            padding: 16px;
            border-bottom: 1px solid var(--border-light);
            font-size: 14px;
        }

        tr:hover {
            background: var(--bg);
        }

        /* Badges */
        .badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .badge-success { background: var(--success-light); color: #059669; }
        .badge-warning { background: var(--warning-light); color: #92400E; }
        .badge-danger { background: var(--danger-light); color: #991B1B; }
        .badge-info { background: var(--info-light); color: #1E40AF; }
        .badge-primary { background: rgba(123, 0, 0, 0.1); color: var(--primary); }

        /* Alerts */
        .alert {
            padding: 16px 20px;
            border-radius: var(--radius);
            display: flex;
            align-items: flex-start;
            gap: 12px;
            margin-bottom: 20px;
        }

        .alert i {
            font-size: 18px;
            margin-top: 2px;
        }

        .alert-success {
            background: var(--success-light);
            border-left: 4px solid var(--success);
            color: #065F46;
        }

        .alert-warning {
            background: var(--warning-light);
            border-left: 4px solid var(--warning);
            color: #92400E;
        }

        .alert-danger {
            background: var(--danger-light);
            border-left: 4px solid var(--danger);
            color: #991B1B;
        }

        .alert-info {
            background: var(--info-light);
            border-left: 4px solid var(--info);
            color: #1E40AF;
        }

        /* User Menu */
        .user-menu {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 24px;
            border-top: 1px solid rgba(255,255,255,0.1);
            margin-top: auto;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, var(--primary-light), var(--accent));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 16px;
        }

        .user-info {
            flex: 1;
        }

        .user-name {
            color: white;
            font-size: 14px;
            font-weight: 600;
        }

        .user-role {
            color: rgba(255,255,255,0.6);
            font-size: 12px;
        }

        /* Schedule Timeline */
        .schedule-timeline {
            display: grid;
            gap: 16px;
        }

        .schedule-item {
            padding: 24px;
            border-radius: var(--radius-lg);
            border: 2px solid var(--border);
            display: grid;
            grid-template-columns: 120px 1fr auto;
            gap: 24px;
            align-items: center;
            transition: all 0.2s ease;
        }

        .schedule-item:hover {
            box-shadow: var(--shadow-md);
        }

        .schedule-item.completed {
            border-color: var(--success);
            background: var(--success-light);
        }

        .schedule-item.active {
            border-color: var(--primary);
            background: rgba(123, 0, 0, 0.05);
        }

        .schedule-item.missed {
            border-color: var(--danger);
            background: var(--danger-light);
        }

        .schedule-time {
            font-size: 28px;
            font-weight: 900;
            color: var(--primary);
            text-align: center;
        }

        .schedule-item.completed .schedule-time { color: var(--success); }
        .schedule-item.missed .schedule-time { color: var(--danger); }

        .schedule-info h3 {
            font-size: 17px;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .schedule-detail {
            display: flex;
            align-items: center;
            gap: 8px;
            color: var(--text-secondary);
            font-size: 14px;
            margin-bottom: 4px;
        }

        /* Responsive */
        @media (max-width: 1200px) {
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
            }

            .main-content {
                margin-left: 0;
                padding: 16px;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .form-grid {
                grid-template-columns: 1fr;
            }

            .schedule-item {
                grid-template-columns: 1fr;
                text-align: center;
            }
        }

        /* Utility Classes */
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .text-muted { color: var(--text-light); }
        .text-primary { color: var(--primary); }
        .text-success { color: var(--success); }
        .text-danger { color: var(--danger); }
        .text-warning { color: var(--warning); }
        .font-bold { font-weight: 700; }
        .mt-4 { margin-top: 16px; }
        .mb-4 { margin-bottom: 16px; }
        .hidden { display: none; }

        /* Toast Notifications */
        .toast-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            display: flex;
            flex-direction: column;
            gap: 12px;
            pointer-events: none;
        }

        .toast {
            background: white;
            border-radius: 12px;
            padding: 16px 20px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.15);
            display: flex;
            align-items: center;
            gap: 14px;
            min-width: 320px;
            max-width: 420px;
            pointer-events: all;
            animation: slideInRight 0.3s ease-out;
            border-left: 4px solid var(--primary);
        }

        @keyframes slideInRight {
            from { opacity: 0; transform: translateX(100px); }
            to { opacity: 1; transform: translateX(0); }
        }

        .toast.toast-success { border-left-color: var(--success); }
        .toast.toast-error { border-left-color: var(--danger); }
        .toast.toast-warning { border-left-color: var(--warning); }
        .toast.toast-info { border-left-color: var(--info); }

        .toast-icon {
            font-size: 24px;
            flex-shrink: 0;
        }

        .toast-success .toast-icon { color: var(--success); }
        .toast-error .toast-icon { color: var(--danger); }
        .toast-warning .toast-icon { color: var(--warning); }
        .toast-info .toast-icon { color: var(--info); }

        .toast-content {
            flex: 1;
        }

        .toast-title {
            font-size: 14px;
            font-weight: 700;
            color: var(--text);
            margin-bottom: 2px;
        }

        .toast-message {
            font-size: 13px;
            color: var(--text-secondary);
            line-height: 1.4;
        }

        .toast-close {
            background: none;
            border: none;
            color: var(--text-light);
            cursor: pointer;
            padding: 4px;
            font-size: 18px;
            flex-shrink: 0;
            transition: color 0.2s;
        }

        .toast-close:hover {
            color: var(--text);
        }

        /* Modal System */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.6);
            backdrop-filter: blur(4px);
            z-index: 9998;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            opacity: 0;
            animation: fadeIn 0.2s ease-out forwards;
        }

        .modal-box {
            background: white;
            border-radius: 20px;
            max-width: 480px;
            width: 100%;
            box-shadow: 0 25px 80px rgba(0,0,0,0.3);
            animation: scaleIn 0.3s ease-out;
        }

        @keyframes scaleIn {
            from { opacity: 0; transform: scale(0.9); }
            to { opacity: 1; transform: scale(1); }
        }

        .modal-header {
            padding: 28px 32px 20px;
            border-bottom: 2px solid var(--bg);
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .modal-icon {
            width: 56px;
            height: 56px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            flex-shrink: 0;
        }

        .modal-icon.success { background: var(--success-light); color: var(--success); }
        .modal-icon.error { background: var(--danger-light); color: var(--danger); }
        .modal-icon.warning { background: var(--warning-light); color: var(--warning); }
        .modal-icon.info { background: var(--info-light); color: var(--info); }

        .modal-header-text h3 {
            font-size: 20px;
            font-weight: 800;
            color: var(--text);
            margin-bottom: 4px;
        }

        .modal-header-text p {
            font-size: 14px;
            color: var(--text-secondary);
        }

        .modal-body {
            padding: 24px 32px;
        }

        .modal-footer {
            padding: 20px 32px 28px;
            display: flex;
            gap: 12px;
            justify-content: flex-end;
        }

        .modal-footer .btn {
            min-width: 100px;
        }

        /* Loading Spinner */
        .spinner {
            display: inline-block;
            width: 16px;
            height: 16px;
            border: 2px solid rgba(255,255,255,0.3);
            border-top-color: white;
            border-radius: 50%;
            animation: spin 0.6s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* Responsive Toast */
        @media (max-width: 768px) {
            .toast-container {
                left: 20px;
                right: 20px;
            }

            .toast {
                min-width: auto;
                max-width: none;
            }
        }
    </style>
    @stack('styles')
</head>
<body>
    <!-- Toast Container -->
    <div class="toast-container" id="toastContainer"></div>

    @yield('body')

    <script>
        // Toast Notification System
        const Toast = {
            container: null,

            init() {
                this.container = document.getElementById('toastContainer');
            },

            show(type, title, message, duration = 5000) {
                const toast = document.createElement('div');
                toast.className = `toast toast-${type}`;

                const icons = {
                    success: 'fa-check-circle',
                    error: 'fa-exclamation-circle',
                    warning: 'fa-exclamation-triangle',
                    info: 'fa-info-circle'
                };

                toast.innerHTML = `
                    <i class="fas ${icons[type]} toast-icon"></i>
                    <div class="toast-content">
                        <div class="toast-title">${title}</div>
                        <div class="toast-message">${message}</div>
                    </div>
                    <button class="toast-close" onclick="Toast.close(this)">
                        <i class="fas fa-times"></i>
                    </button>
                `;

                this.container.appendChild(toast);

                if (duration > 0) {
                    setTimeout(() => this.close(toast.querySelector('.toast-close')), duration);
                }

                return toast;
            },

            success(title, message, duration) {
                return this.show('success', title, message, duration);
            },

            error(title, message, duration) {
                return this.show('error', title, message, duration);
            },

            warning(title, message, duration) {
                return this.show('warning', title, message, duration);
            },

            info(title, message, duration) {
                return this.show('info', title, message, duration);
            },

            close(button) {
                const toast = button.closest('.toast');
                toast.style.opacity = '0';
                toast.style.transform = 'translateX(100px)';
                setTimeout(() => toast.remove(), 300);
            }
        };

        // Modal System
        const Modal = {
            show(options) {
                const {
                    type = 'info',
                    title = 'Confirmation',
                    message = '',
                    confirmText = 'Confirm',
                    cancelText = 'Cancel',
                    onConfirm = () => {},
                    onCancel = () => {}
                } = options;

                const icons = {
                    success: 'fa-check-circle',
                    error: 'fa-times-circle',
                    warning: 'fa-exclamation-triangle',
                    info: 'fa-info-circle'
                };

                const overlay = document.createElement('div');
                overlay.className = 'modal-overlay';
                overlay.innerHTML = `
                    <div class="modal-box">
                        <div class="modal-header">
                            <div class="modal-icon ${type}">
                                <i class="fas ${icons[type]}"></i>
                            </div>
                            <div class="modal-header-text">
                                <h3>${title}</h3>
                            </div>
                        </div>
                        <div class="modal-body">
                            <p style="font-size: 15px; color: var(--text-secondary); line-height: 1.6;">
                                ${message}
                            </p>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" onclick="Modal.close(this, false)">
                                ${cancelText}
                            </button>
                            <button class="btn btn-primary" onclick="Modal.close(this, true)">
                                ${confirmText}
                            </button>
                        </div>
                    </div>
                `;

                overlay._onConfirm = onConfirm;
                overlay._onCancel = onCancel;

                // Close on overlay click
                overlay.addEventListener('click', (e) => {
                    if (e.target === overlay) {
                        this.close(overlay, false);
                    }
                });

                document.body.appendChild(overlay);
                return overlay;
            },

            confirm(title, message, onConfirm, onCancel) {
                return this.show({
                    type: 'warning',
                    title,
                    message,
                    confirmText: 'Ya, Lanjutkan',
                    cancelText: 'Batal',
                    onConfirm,
                    onCancel
                });
            },

            close(element, confirmed) {
                const overlay = element.closest('.modal-overlay');
                if (!overlay) return;

                overlay.style.opacity = '0';
                setTimeout(() => {
                    if (confirmed && overlay._onConfirm) {
                        overlay._onConfirm();
                    } else if (!confirmed && overlay._onCancel) {
                        overlay._onCancel();
                    }
                    overlay.remove();
                }, 200);
            }
        };

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            Toast.init();

            // Auto-hide flash messages
            const alerts = document.querySelectorAll('.alert-flash');
            alerts.forEach(alert => {
                setTimeout(() => {
                    alert.style.opacity = '0';
                    alert.style.transform = 'translateY(-10px)';
                    setTimeout(() => alert.remove(), 300);
                }, 5000);
            });

            // Show toast for session messages
            @if(session('success'))
                Toast.success('Berhasil!', '{{ session('success') }}');
            @endif

            @if(session('error'))
                Toast.error('Gagal!', '{{ session('error') }}');
            @endif

            @if(session('warning'))
                Toast.warning('Perhatian!', '{{ session('warning') }}');
            @endif

            @if(session('info'))
                Toast.info('Informasi', '{{ session('info') }}');
            @endif
        });

        // Helper function for form submissions with confirmation
        function confirmAction(message, formId) {
            Modal.confirm(
                'Konfirmasi Tindakan',
                message,
                () => document.getElementById(formId).submit()
            );
            return false;
        }

        // Helper for AJAX actions
        function showLoading(button) {
            button.disabled = true;
            button.dataset.originalText = button.innerHTML;
            button.innerHTML = '<span class="spinner"></span> Memproses...';
        }

        function hideLoading(button) {
            button.disabled = false;
            button.innerHTML = button.dataset.originalText;
        }
    </script>
    @stack('scripts')
</body>
</html>
