<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login Page</title>
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"
    />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- @vite (['resources/css/login.css']) -->

<style>
    * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Poppins', sans-serif;
}

body {
    background-image: url('/photos/IMS\ background_picture.png');
    background-repeat: no-repeat;
    background-attachment: fixed;
    background-position: center;
    background-size: cover;
    backdrop-filter: blur(4px);

    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    margin: 0;
    padding: 1rem;
}

/* Main Container */
.login-container {
    position: relative;
    width: 800px;
    max-width: 95%;
    height: 550px;
    background-color: transparent;
    border-radius: 32px;
    box-shadow: 0 25px 50px 12px rgba(0, 0, 0, 0.35);
    overflow: hidden;
}

/* Content Wrapper */
.container-wrapper {
    position: relative;
    width: 100%;
    height: 100%;
    display: flex;
}

/* Left Panel - Welcome Message Area */
.welcome-panel {
    width: 50%;
    height: 100%;
    background: linear-gradient(135deg, #0f2b3d 0%, #0a1e2c 100%);
    color: white;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    text-align: center;
    padding: 2rem;
    transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    z-index: 2;
}

/* Right Panel - Form Area */
.form-panel {
    width: 50%;
    height: 100%;
    background-color: rgba(44, 110, 98);
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    padding: 2rem;
    transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    z-index: 2;
}

/* REGISTER MODE - Swap panels */
.login-container.register-mode .welcome-panel {
    transform: translateX(100%);
}

.login-container.register-mode .form-panel {
    transform: translateX(-100%);
}

/* Inner content containers with fade animation */
.welcome-content {
    max-width: 280px;
    margin: 0 auto;
    transition: all 0.3s ease;
}

.form-content {
    width: 100%;
    max-width: 320px;
    position: relative;
}

/* Form containers with smooth fade/transition */
.form-wrapper {
    width: 100%;
    transition: all 0.4s ease;
}

.login-form-wrapper {
    display: block;
    animation: fadeInUp 0.4s ease;
}

.register-form-wrapper {
    display: none;
    animation: fadeInUp 0.4s ease;
}

.login-container.register-mode .login-form-wrapper {
    display: none;
}

.login-container.register-mode .register-form-wrapper {
    display: block;
    animation: fadeInUp 0.4s ease;
}

/* Welcome content text transition */
.welcome-text-login,
.welcome-text-register {
    transition:
        opacity 0.3s ease,
        transform 0.3s ease;
}

.welcome-text-register {
    display: none;
}

.login-container.register-mode .welcome-text-login {
    display: none;
}

.login-container.register-mode .welcome-text-register {
    display: block;
    animation: fadeInUp 0.4s ease;
}

.welcome-text-login {
    display: block;
    animation: fadeInUp 0.4s ease;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes fadeOutDown {
    from {
        opacity: 1;
        transform: translateY(0);
    }
    to {
        opacity: 0;
        transform: translateY(-20px);
    }
}

/* Icon and Logo */
.welcome-icon {
    width: 80px;
    height: 80px;
    background: rgba(58, 143, 126, 0.2);
    border-radius: 24px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.5rem;
    font-size: 2.5rem;
    color: #3a8f7e;
    border: 2px solid rgba(58, 143, 126, 0.5);
}

.welcome-panel h2 {
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 1rem;
    letter-spacing: -0.5px;
}

.welcome-panel p {
    font-size: 0.9rem;
    line-height: 1.6;
    opacity: 0.85;
    margin-bottom: 2rem;
}

.switch-btn {
    background: linear-gradient(180deg, rgb(38, 76, 100) 0%, rgb(30, 157, 164) 100%);
    border: none;
    padding: 12px 32px;
    border-radius: 40px;
    color: white;
    font-weight: 700;
    font-size: 1rem;
    cursor: pointer;
    transition: all 0.3s ease;
    font-family: 'Poppins', sans-serif;
}

.switch-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(58, 143, 126, 0.3);
}

/* Form Styles */
.form-content h1 {
    font-size: 2rem;
    font-weight: 700;
    color: white;
    margin-bottom: 1.8rem;
    text-align: center;
}

.input-box{
    position: relative;
    margin-bottom: 1.5rem;
}
.input-box i{
    position: absolute;
    left: 18px;
    top: 50%;
    transform: translateY(-50%);
    color: #9bb4c2;
    font-size: 1rem;
}
.input-box input {
    width: 100%;
    padding: 14px 18px 14px 48px;
    border: 1.5px solid #e2e9f0;
    border-radius: 28px;
    font-size: 0.9rem;
    transition: all 0.2s;
    background: #ffffff;
    outline: none;
}
.input-box input:focus {
    border-color: #3a8f7e;
    box-shadow: 0 0 0 3px rgba(58, 143, 126, 0.1);
}
.input-box input::placeholder {
    color: #98a5ad;
    font-weight: 5;
}

.btn {
    width: 100%;
    background: linear-gradient(180deg, rgb(15, 43, 61) 0%, rgb(25, 110, 114) 100%);
    border: none;
    padding: 14px;
    border-radius: 40px;
    color: white;
    font-weight: 700;
    font-size: 1rem;
    cursor: pointer;
    transition: all 0.3s ease;
    font-family: 'Poppins', sans-serif;
}

.btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(15, 43, 61);
}
.role {
            margin-bottom: 20px;
            display: flex;
            justify-content: space-evenly;
            gap: 20px;
        }
        .role label {
            display: flex;
            flex-direction: row;
            color: white;
        }

/* Responsive Design */
@media (max-width: 768px) {
    .login-container {
        height: auto;
        min-height: 600px;
    }

    .container-wrapper {
        flex-direction: column;
    }

    .welcome-panel,
    .form-panel {
        width: 100%;
        min-height: 300px;
    }

    .login-container.register-mode .welcome-panel {
        transform: translateX(0);
        order: 2;
    }

    .login-container.register-mode .form-panel {
        transform: translateX(0);
        order: 1;
    }

    .welcome-content {
        max-width: 100%;
    }
}

</style>
</head>
<body>
    <div class="login-container" id="loginContainer">
        <div class="container-wrapper">
            <!-- LEFT PANEL - Welcome Message Area -->
            <div class="welcome-panel" id="welcomePanel">
                <div class="welcome-content">
                    <div class="welcome-icon">
                        <i class="fas fa-boxes"></i>
                    </div>
                    
                    <!-- Login Mode Welcome Text -->
                    <div class="welcome-text-login" id="welcomeLoginText">
                        <h2>Welcome Back!</h2>
                        <p>Sign in to access your inventory dashboard and manage your products efficiently.</p>
                    </div>
                    
                    <!-- Register Mode Welcome Text -->
                    <div class="welcome-text-register" id="welcomeRegisterText">
                        <h2>Join Us!</h2>
                        <p>Create your account to start managing inventory, track sales, and streamline your school operations.</p>
                    </div>
                    
                    <button class="switch-btn" id="switchBtn">Register Now</button>
                </div>
            </div>

            <!-- RIGHT PANEL - Form Area -->
            <div class="form-panel" id="formPanel">
                <div class="form-content">
                    <!-- LOGIN FORM -->
                    <div class="form-wrapper login-form-wrapper" id="loginFormWrapper">
                        <h1>Login</h1>
                        <form id="loginForm" method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="input-box">
                                <i class="fa-solid fa-user"></i>
                                <input type="text" name="email" placeholder="Email" required>
                            </div>
                            <div class="input-box">
                                <i class="fa-solid fa-lock"></i>
                                <input type="password" name="password" placeholder="Password" required>
                            </div>
                            <button type="submit" class="btn">Login</button>
                        </form>
                    </div>

                    <!-- REGISTER FORM -->
                    <div class="form-wrapper register-form-wrapper" id="registerFormWrapper">
                        <h1>Create Account</h1>
                        <form id="registerForm" method="POST" action="{{ route('register') }}">
                            @csrf
                            <div class="input-box">
                                <i class="fa-solid fa-user"></i>
                                <input type="text" name="fullname" placeholder="Full Name" required>
                            </div>
                            <div class="input-box">
                                <i class="fa-solid fa-envelope"></i>
                                <input type="email" name="email" placeholder="Email Address" required>
                            </div>
                            <div class="input-box">
                                <i class="fa-solid fa-lock"></i>
                                <input type="password" name="password" placeholder="Password" required>
                            </div>
                            <div class="input-box">
                                <i class="fa-solid fa-check-circle"></i>
                                <input type="password" name="password_confirmation" placeholder="Confirm Password" required>
                            </div>
                            <div class="role">
                                <label>
                                    <input type="radio" name="role" value="admin" required><i class="fa-solid fa-user-tie"></i>Admin
                                </label>
                                <label>
                                    <input type="radio" name="role" value="user" required><i class="fa-solid fa-user"></i>User
                                </label>
                            </div>
                            <button type="submit" class="btn">Register</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const container = document.getElementById('loginContainer');
        const switchBtn = document.getElementById('switchBtn');
        
        let isRegisterMode = false;
        
        function switchToRegister() {
            if (isRegisterMode) return;
            isRegisterMode = true;
            container.classList.add('register-mode');
            switchBtn.textContent = 'Back to Login';
        }
        
        function switchToLogin() {
            if (!isRegisterMode) return;
            isRegisterMode = false;
            container.classList.remove('register-mode');
            switchBtn.textContent = 'Register Now';
        }
        
        function toggleMode() {
            if (isRegisterMode) {
                switchToLogin();
            } else {
                switchToRegister();
            }
        }
        switchBtn.addEventListener('click', toggleMode);
        
        
        window.addEventListener('resize', function() {
            
        });
        
        
        const style = document.createElement('style');
        style.textContent = `
            .welcome-text-login,
            .welcome-text-register,
            .login-form-wrapper,
            .register-form-wrapper {
                transition: opacity 0.3s ease, transform 0.3s ease;
            }
            
            .welcome-panel,
            .form-panel {
                will-change: transform;
            }
            
            .login-container {
                transition: all 0.3s ease;
            }
        `;
        document.head.appendChild(style);
    </script>
</body>
</html>
<!-- ======================================================================================== -->
/* Notification Bell Styles */
        .notification-area {
            position: relative;
            display: inline-block;
            margin-right: 15px;
        }

        .notification-bell {
            background: linear-gradient(180deg, rgb(15, 43, 61) 0%, rgb(25, 110, 114) 100%);
            border: none;
            color: white;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            cursor: pointer;
            position: relative;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
        }

        .notification-bell:hover {
            transform: scale(1.05);
        }

        .notification-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background: #dc3545;
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            font-size: 11px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }

        .notification-dropdown {
            position: absolute;
            top: 50px;
            right: 0;
            width: 350px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            display: none;
            z-index: 1000;
            overflow: hidden;
        }

        .notification-dropdown.show {
            display: block;
            animation: slideDown 0.3s ease;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .notification-header {
            background: linear-gradient(135deg, rgb(15, 43, 61) 0%, rgb(25, 110, 114) 100%);
            color: white;
            padding: 12px 15px;
            font-weight: 600;
        }

        .notification-list {
            max-height: 400px;
            overflow-y: auto;
        }

        .notification-item {
            padding: 15px;
            border-bottom: 1px solid #e2e8f0;
            transition: background 0.2s;
            cursor: pointer;
        }

        .notification-item:hover {
            background: #f8fafc;
        }

        .notification-item.unread {
            background: #e8f5e9;
            border-left: 3px solid #28a745;
        }

        .notification-title {
            font-weight: 600;
            color: #1e3a38;
            margin-bottom: 5px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .notification-message {
            font-size: 13px;
            color: #6c757d;
            margin-bottom: 5px;
        }

        .notification-time {
            font-size: 11px;
            color: #9ca3af;
        }

        .notification-buttons {
            display: flex;
            gap: 10px;
            margin-top: 10px;
        }

        .notification-buttons button {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 11px;
            cursor: pointer;
            border: none;
            transition: all 0.2s;
        }




<!-- Notification Bell -->
                @php
                    $pendingStockReports = App\Models\StockReport::where('status', 'pending')->count();
                @endphp
                <div class="notification-area">
                    <button class="notification-bell" id="notificationBell">
                        <i class="fas fa-bell"></i>
                        @if($pendingStockReports > 0)
                            <span class="notification-badge">{{ $pendingStockReports }}</span>
                        @endif
                    </button>
                    
                    <div class="notification-dropdown" id="notificationDropdown">
                        <div class="notification-header">
                            <i class="fas fa-exclamation-triangle"></i> Stock Alerts
                        </div>
                        <div class="notification-list">
                            @php
                                $pendingStockReports = \App\Models\StockReport::where('status', 'pending')->count();
                                $recentStockReports = \App\Models\StockReport::where('status', 'pending')
                                    ->orderBy('created_at', 'desc')
                                    ->take(5)
                                    ->get();
                            @endphp
                            @forelse($recentStockReports as $report)
                                <div class="notification-item unread" data-report-id="{{ $report->id }}">
                                    <div class="notification-title">
                                        <strong>{{ $report->product_name }}</strong>
                                        <span class="notification-time">{{ $report->created_at->diffForHumans() }}</span>
                                    </div>
                                    <div class="notification-message">
                                        Reported by: <strong>{{ $report->user_name }}</strong><br>
                                        Current Stock: {{ $report->current_stock }} units (Min: {{ $report->min_stock_level }})
                                        @if($report->message)
                                            <br>Message: {{ $report->message }}
                                        @endif
                                    </div>
                                    <div class="notification-buttons">
                                        <button class="btn-order" onclick="createPurchaseOrder('{{ $report->id }}', '{{ $report->product_id }}', '{{ $report->product_name }}')">
                                            <i class="fas fa-shopping-cart"></i> Create PO
                                        </button>
                                        <button class="btn-read" onclick="markAsRead('{{ $report->id }}')">
                                            <i class="fas fa-check"></i> Mark Read
                                        </button>
                                    </div>
                                </div>
                            @empty
                                <div class="no-notifications">
                                    <i class="fas fa-check-circle" style="font-size: 32px; margin-bottom: 10px;"></i>
                                    <p>No pending stock reports</p>
                                </div>
                            @endforelse
                        </div>
                        <div class="notification-footer">
                            <a href="{{ route('admin.stock.reports') }}">View All Reports</a>
                        </div>
                    </div>
                </div>



                // Notification Dropdown Toggle
            const bell = document.getElementById('notificationBell');
            const dropdown = document.getElementById('notificationDropdown');
            
            if (bell) {
                bell.addEventListener('click', function(e) {
                    e.stopPropagation();
                    dropdown.classList.toggle('show');
                });
            }
            
            // Close dropdown when clicking outside
            document.addEventListener('click', function(e) {
                if (dropdown && !dropdown.contains(e.target) && bell && !bell.contains(e.target)) {
                    dropdown.classList.remove('show');
                }
            });
        });
        
        // Mark as Read function
        function markAsRead(reportId) {
            fetch('{{ route("admin.stock.report.read") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ report_id: reportId })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const item = document.querySelector(`.notification-item[data-report-id="${reportId}"]`);
                    if (item) {
                        item.classList.remove('unread');
                        item.style.opacity = '0.6';
                        
                        // Update badge count
                        const badge = document.querySelector('.notification-badge');
                        if (badge) {
                            let count = parseInt(badge.textContent) - 1;
                            if (count > 0) {
                                badge.textContent = count;
                            } else {
                                badge.remove();
                            }
                        }
                    }
                    location.reload();
                }
            });
        }
        
        // Create Purchase Order from notification
        function createPurchaseOrder(reportId, productId, productName) {
            if (confirm(`Create purchase order for "${productName}"?`)) {
                // First, mark the report as ordered
                fetch('{{ route("admin.stock.report.mark-ordered") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ report_id: reportId })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Redirect to purchases page with product pre-selected
                        window.location.href = `{{ route('admin.purchases') }}?product_id=${productId}&product_name=${encodeURIComponent(productName)}&report_id=${reportId}`;
                    } else {
                        alert('Failed to update report status');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    window.location.href = `{{ route('admin.purchases') }}?product_id=${productId}&product_name=${encodeURIComponent(productName)}`;
                });
            }
        }