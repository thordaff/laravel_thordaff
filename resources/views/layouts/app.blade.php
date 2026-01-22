<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Hospital Management') }}</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
        
        @vite(['resources/sass/app.scss', 'resources/js/app.js'])
        
        <!-- jQuery CDN as fallback -->
        <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
        
        <style>
            .navbar {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                box-shadow: 0 2px 20px rgba(0,0,0,0.1);
                padding: 1rem 0;
            }
            
            .navbar .navbar-brand {
                font-weight: 700;
                font-size: 1.5rem;
                letter-spacing: -0.5px;
                transition: transform 0.3s ease;
            }
            
            .navbar .navbar-brand:hover {
                transform: scale(1.05);
            }
            
            .navbar .navbar-brand i {
                margin-right: 8px;
                font-size: 1.8rem;
            }
            
            .navbar .nav-link {
                font-weight: 500;
                padding: 0.5rem 1rem !important;
                margin: 0 0.25rem;
                border-radius: 8px;
                transition: all 0.3s ease;
                position: relative;
            }
            
            .navbar .nav-link:hover {
                background: rgba(255,255,255,0.2);
                transform: translateY(-2px);
            }
            
            .navbar .nav-link.active {
                background: rgba(255,255,255,0.25);
            }
            
            .navbar .nav-link i {
                margin-right: 6px;
            }
            
            .user-avatar {
                width: 35px;
                height: 35px;
                border-radius: 50%;
                background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
                display: inline-flex;
                align-items: center;
                justify-content: center;
                font-weight: 600;
                margin-right: 8px;
                border: 2px solid rgba(255,255,255,0.5);
            }
            
            .navbar .dropdown-toggle::after {
                vertical-align: middle;
            }
            
            .navbar .dropdown-menu {
                border: none;
                box-shadow: 0 10px 30px rgba(0,0,0,0.15);
                border-radius: 12px;
                margin-top: 0.5rem;
                overflow: hidden;
            }
            
            .navbar .dropdown-item {
                padding: 0.75rem 1.5rem;
                transition: all 0.3s ease;
                font-weight: 500;
            }
            
            .navbar .dropdown-item:hover {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                color: white;
                transform: translateX(5px);
            }
            
            .navbar .dropdown-item i {
                margin-right: 10px;
                width: 20px;
            }
            
            body {
                background: #f8f9fa;
                min-height: 100vh;
            }
            
            .bg-gradient {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            }
            
            .card {
                border-radius: 12px;
                overflow: hidden;
            }
            
            .btn-group .btn {
                margin: 0 2px;
            }
            
            .toast-container {
                position: fixed;
                top: 80px;
                right: 20px;
                z-index: 9999;
            }
            
            .toast {
                min-width: 300px;
                box-shadow: 0 10px 30px rgba(0,0,0,0.15);
                border-radius: 8px;
                overflow: hidden;
            }
            
            .toast .toast-body {
                padding: 1rem;
                border-radius: 8px;
                display: flex;
                align-items: center;
            }
            
            .toast-header {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                color: white;
                font-weight: 600;
            }
            
            .toast-header .btn-close {
                filter: brightness(0) invert(1);
            }
        </style>
    </head>
    <body>
        @auth
        <nav class="navbar navbar-expand-lg navbar-dark navbar">
            <div class="container">
                <a class="navbar-brand" href="{{ route('hospitals.index') }}">
                    <i class="bi bi-hospital"></i>Hospital Management
                </a>
                <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto ms-lg-4">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('hospitals.*') ? 'active' : '' }}" href="{{ route('hospitals.index') }}">
                                <i class="bi bi-building"></i>Rumah Sakit
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('patients.*') ? 'active' : '' }}" href="{{ route('patients.index') }}">
                                <i class="bi bi-person-heart"></i>Pasien
                            </a>
                        </li>
                    </ul>
                    <ul class="navbar-nav">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <span class="user-avatar">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </span>
                                <span class="d-none d-lg-inline">{{ Auth::user()->name }}</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a class="dropdown-item disabled" href="#">
                                        <i class="bi bi-person-circle"></i>
                                        {{ Auth::user()->username }}
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger">
                                            <i class="bi bi-box-arrow-right"></i>Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        @endauth

        <div class="toast-container">
            @if(session('success'))
            <div class="toast align-items-center border-0" role="alert" aria-live="assertive" aria-atomic="true" id="successToast">
                <div class="toast-body bg-success text-white rounded">
                    <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                </div>
            </div>
            @endif
            
            @if(session('error'))
            <div class="toast align-items-center border-0" role="alert" aria-live="assertive" aria-atomic="true" id="errorToast">
                <div class="toast-body bg-danger text-white rounded">
                    <i class="bi bi-x-circle-fill me-2"></i>{{ session('error') }}
                </div>
            </div>
            @endif
        </div>

        <main class="py-4">
            @yield('content')
        </main>

        <script>
            // Setup CSRF Token for AJAX
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        </script>

        @stack('scripts')
        
        <script>
            window.showToast = function(message, type = 'success') {
                const toastContainer = document.querySelector('.toast-container');
                if (!toastContainer) return;
                
                const icon = type === 'success' ? 'check-circle-fill' : 'x-circle-fill';
                const bgClass = type === 'success' ? 'bg-success' : 'bg-danger';
                
                const toastHtml = `
                    <div class="toast align-items-center border-0" role="alert" aria-live="assertive" aria-atomic="true">
                        <div class="toast-body ${bgClass} text-white rounded">
                            <i class="bi bi-${icon} me-2"></i>${message}
                        </div>
                    </div>
                `;
                
                toastContainer.insertAdjacentHTML('beforeend', toastHtml);
                
                const toastElement = toastContainer.lastElementChild;
                const toast = new bootstrap.Toast(toastElement, {
                    autohide: true,
                    delay: 5000
                });
                
                toast.show();
                
                toastElement.addEventListener('hidden.bs.toast', function() {
                    toastElement.remove();
                });
            };
            
            document.addEventListener('DOMContentLoaded', function() {
                const toastElList = [].slice.call(document.querySelectorAll('.toast'));
                const toastList = toastElList.map(function(toastEl) {
                    return new bootstrap.Toast(toastEl, {
                        autohide: true,
                        delay: 5000 
                    });
                });
                
                toastList.forEach(toast => toast.show());
            });
        </script>
    </body>
</html>