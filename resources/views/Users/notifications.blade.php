<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Notifications | Inventory MS</title>
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'%3E%3Crect width='100' height='100' fill='%232c6e62' rx='20'/%3E%3Crect x='25' y='30' width='50' height='40' fill='white' rx='5'/%3E%3Crect x='35' y='40' width='30' height='20' fill='%232c6e62' rx='3'/%3E%3C/svg%3E">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"/>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        body {
            background-color: #f8fafc;
        }
        .title {
            font-weight: bold;
            font-size: 25px;
        }
        .sidebar {
            width: 280px;
            height: 100vh;
            background: linear-gradient(180deg, rgb(15, 43, 61) 0%, rgb(10, 30, 44) 100%);
            color: rgba(233, 241, 247);
            display: flex;
            flex-direction: column;
            padding: 2rem 1.5rem;
            box-shadow: 5px 0 25px rgba(0, 0, 0, 0.05);
            position: fixed;
            z-index: 100;
        }
        .brand {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 15px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.15);
            padding-bottom: 1.5rem;
        }
        .brand-icon {
            background: linear-gradient(180deg, rgb(15, 43, 61) 0%, rgb(25, 110, 114) 100%);
            width: 45px;
            height: 45px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 25px;
            box-shadow: 0 8px 14px rgba(0, 0, 0, 0.2);
        }
        .nav-menu {
            display: flex;
            flex-direction: column;
            gap: 15px;
            padding: 5px;
        }
        .nav-menu button {
            display: flex;
            align-items: center;
            background-color: transparent;
            gap: 15px;
            font-size: 18px;
            margin: 0;
            padding: 10px 25px;
            width: 100%;
            border-radius: 15px;
            border: none;
            cursor: pointer;
            color: rgba(189, 189, 189, 0.6);
            transition: all 0.3s ease;
        }
        .nav-item:hover:not(.active) {
            background-color: rgba(60, 130, 110, 0.35);
            color: white;
            height: 40px;
            border-left: 3px solid #ffd700;
            border-radius: 15px;
        }
        .nav-item.active button {
            background: linear-gradient(180deg, rgb(15, 43, 61) 0%, rgb(25, 110, 114) 100%);
            color: white;
            border-left: 3px solid #ffd700;
            border-radius: 15px;
            height: 40px;
        }
        .nav-item {
            height: 40px;
            flex-direction: column;
            align-items: center;
            transition: all 0.3s ease;
        }
        .main-content {
            background: linear-gradient(45deg, rgb(44, 110, 98) 20%, #144243 50%, rgba(60, 130, 110, 0.35) 100%);
            flex: 1;
            overflow-y: auto;
            margin-left: 280px;
            min-height: 100vh;
        }
        .topheader {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 5px;
            background-color: rgb(255, 255, 255);
            border-bottom: 1px solid rgb(210, 210, 210);
            flex-wrap: wrap;
            gap: 15px;
        }
        .page-title {
            margin-left: 30px;
            color: rgb(44, 110, 98);
        }
        
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
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            transition: all 0.3s ease;
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
            width: 380px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            display: none;
            z-index: 1000;
            max-height: 500px;
            overflow: hidden;
        }
        .notification-dropdown.show {
            display: block;
            animation: slideDown 0.3s ease;
        }
        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .notification-header {
            background: linear-gradient(135deg, rgb(15, 43, 61) 0%, rgb(25, 110, 114) 100%);
            color: white;
            padding: 12px 15px;
            font-weight: 600;
        }
        .notification-list {
            max-height: 350px;
            overflow-y: auto;
        }
        .notification-item {
            padding: 12px 15px;
            border-bottom: 1px solid #e2e8f0;
            transition: background 0.2s;
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
            font-size: 14px;
        }
        .notification-message {
            font-size: 12px;
            color: #6c757d;
            margin-bottom: 8px;
            line-height: 1.4;
        }
        .notification-time {
            font-size: 10px;
            color: #9ca3af;
        }
        .notification-buttons {
            display: flex;
            gap: 8px;
            margin-top: 8px;
        }
        .notification-buttons button {
            padding: 4px 10px;
            border-radius: 15px;
            font-size: 11px;
            cursor: pointer;
            border: none;
            transition: all 0.2s;
        }
        .btn-read-notif {
            background: #6c757d;
            color: white;
        }
        .btn-read-notif:hover {
            background: #5a6268;
        }
        .resolved-badge {
            background: #28a745;
            color: white;
            padding: 4px 10px;
            border-radius: 15px;
            font-size: 11px;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }
        .notification-footer {
            padding: 10px 15px;
            text-align: center;
            border-top: 1px solid #e2e8f0;
            background: #f8fafc;
        }
        .notification-footer a {
            color: #2c6e62;
            text-decoration: none;
            font-size: 12px;
        }
        .notification-footer a:hover {
            text-decoration: underline;
        }
        .no-notifications {
            padding: 30px;
            text-align: center;
            color: #9ca3af;
        }
        .user-menu-container a {
            background: linear-gradient(180deg, rgb(15, 43, 61) 0%, rgb(25, 110, 114) 100%);
            height: 35px;
            padding-inline-start: 15px;
            padding-inline-end: 15px;
            width: auto;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 20px;
            text-decoration: none;
            gap: 5px;
            color: white;
        }
        .user-menu {
            display: flex;
            align-items: center;
            gap: 20px;
            color: white;
            margin-right: 25px;
            flex-wrap: wrap;
        }
        .logout-container {
            height: 35px;
            width: 110px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 20px;
            cursor: pointer;
            transition: transform 0.3s ease;
        }
        .logout-btn {
            background: linear-gradient(180deg, rgb(15, 43, 61) 0%, rgb(25, 110, 114) 100%);
            border: none;
            cursor: pointer;
            color: white;
            padding: 10px 22px;
            border-radius: 30px;
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 14px;
            font-weight: 600;
        }
        .logout-container:hover {
            transform: translateY(3px);
            box-shadow: 0 -4px 5px rgba(0, 0, 0, 0.1);
        }

        /* Options Section */
        .options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
            margin: 20px 50px;
            flex-wrap: wrap;
        }
        .filter-container {
            display: flex;
            gap: 12px;
            align-items: center;
            flex-wrap: wrap;
        }
        .filter-dropdown {
            padding: 10px 16px;
            border: 1px solid #e2e8f0;
            border-radius: 25px;
            font-size: 13px;
            background: white;
            color: #333;
            cursor: pointer;
            outline: none;
            min-width: 140px;
            transition: all 0.3s ease;
        }
        .recordcount {
            color: rgb(71, 241, 4);
            padding: 11px 18px;
            border-radius: 25px;
            font-size: 14px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            white-space: nowrap;
            background: linear-gradient(180deg, rgb(15, 43, 61) 0%, rgb(25, 110, 114) 100%);   
        }
        .count {
            font-weight: 600;
            color: white;
        }

        /* Notifications Container */
        .notifications-container {
            margin: 20px 50px;
            background: white;
            border-radius: 20px;
            padding: 1.5rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        }

        /* Table Styles */
        .table-container {
            max-height: 500px;
            overflow-y: auto;
            overflow-x: auto;
            border-radius: 12px;
        }
        .table-container::-webkit-scrollbar { width: 8px; height: 8px; }
        .table-container::-webkit-scrollbar-track { background: #f1f1f1; border-radius: 10px; }
        .table-container::-webkit-scrollbar-thumb { background: #2c6e62; border-radius: 10px; }
        .table-container::-webkit-scrollbar-thumb:hover { background: #1a4a42; }
        .table-container {
            scrollbar-width: thin;
            scrollbar-color: #2c6e62 #f1f1f1;
        }

        .report-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.9rem;
            min-width: 900px;
        }
        .report-table th, .report-table td {
            padding: 14px 12px;
            text-align: left;
            border-bottom: 1px solid #e2e8f0;
        }
        .report-table th {
            background: linear-gradient(180deg, rgb(15, 43, 61) 0%, rgb(25, 110, 114) 100%);
            color: white;
            font-weight: 600;
            position: sticky;
            top: 0;
            z-index: 10;
        }
        .report-table tr:hover {
            background: linear-gradient(180deg, rgb(49, 83, 104) 0%, rgba(47, 229, 239, 0.426) 100%);
            color: white;
        }

        /* Status Badges */
        .status-pending {
            background: #ffc107;
            color: #212529;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .status-read {
            background: #17a2b8;
            color: white;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .status-ordered {
            background: #28a745;
            color: white;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        
        /* PO Status Badges */
        .po-pending {
            background: #ffc107;
            color: #856404;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }
        .po-completed {
            background: #28a745;
            color: white;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }
        .po-none {
            background: #6c757d;
            color: white;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        /* Action Buttons */
        .action-buttons {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }
        .btn-mark-read {
            background: #6c757d;
            color: white;
            border: none;
            padding: 6px 12px;
            border-radius: 20px;
            cursor: pointer;
            font-size: 12px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all 0.3s ease;
        }
        .btn-mark-read:hover {
            background: #5a6268;
            transform: translateY(-1px);
        }
        .ordered-text {
            color: rgb(17, 180, 17);
            font-size: 14px;
            font-weight: 600;
        }

        /* Alert Messages */
        .alert-success {
            position: relative;
            background-color: #d4edda;
            color: #155724;
            padding: 12px 50px 12px 50px;
            border-radius: 8px;
            margin: 10px 50px 10px 50px;
            border-left: 4px solid #28a745;
        }
        .alert-error {
            position: relative;
            background-color: #f8d7da;
            color: #721c24;
            padding: 12px 40px 12px 20px;
            border-radius: 8px;
            margin: 10px 50px 10px 50px;
            border-left: 4px solid #dc3545;
        }
        .close-btn {
            position: absolute;
            top: 50%;
            right: 15px;
            transform: translateY(-50%);
            background: none;
            border: none;
            font-size: 20px;
            cursor: pointer;
        }

        /* Pagination */
        .custom-pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 8px;
            margin-top: 20px;
            flex-wrap: wrap;
        }
        .custom-pagination a, .custom-pagination span {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 32px;
            height: 32px;
            padding: 0 4px;
            text-decoration: none;
            font-size: 14px;
            border-radius: 4px;
        }
        .custom-pagination a {
            color: #4a5568;
            background: transparent;
            transition: all 0.2s;
        }
        .custom-pagination a:hover {
            background: #2c6e62;
            color: white;
        }
        .custom-pagination .page-active {
            background: #2c6e62;
            color: white;
        }
        .custom-pagination .page-disabled {
            color: #cbd5e0;
            cursor: default;
        }
        .custom-pagination .page-dots {
            color: #a0aec0;
            cursor: default;
        }

        /* Responsive */
        @media (max-width: 1200px) {
            .notifications-container, .options { 
                margin: 20px 30px; 
            }
            .alert-success, .alert-error { 
                margin: 20px 30px; 
            }
        }
        @media (max-width: 1000px) {
            .sidebar { 
                width: 90px; 
                padding: 1rem 0.5rem; 
            }
            .brand h2, .nav-menu button span { 
                display: none; 
            }
            .main-content { 
                margin-left: 90px; 
            }
            .page-title { 
                margin-left: 20px; 
            }
            .page-title h1 { 
                font-size: 1.3rem; 
            }
        }
        @media (max-width: 860px) {
            .notifications-container, .options { 
                margin: 20px; 
                padding: 1rem; 
            }
            .options { 
                flex-direction: column; 
                align-items: stretch; 
            }
            .filter-container { 
                justify-content: space-between; 
            }
            .filter-dropdown { 
                flex: 1; 
            }
            .table-container { 
                max-height: 400px; 
            }
            .topheader { 
                padding: 15px; 
            }
            .page-title { 
                margin-left: 15px; 
            }
            .user-menu { 
                margin-right: 15px; 
            }
            .report-table th, .report-table td { 
                padding: 10px 8px; 
                font-size: 0.8rem; 
            }
        }
        @media (max-width: 768px) {
            .sidebar { 
                width: 70px; 
                padding: 1rem 0.3rem; 
            }
            .main-content { 
                margin-left: 70px; 
            }
            .brand-icon { 
                width: 35px; 
                height: 35px; 
                font-size: 18px; 
            }
            .nav-menu button { 
                font-size: 14px; 
                padding: 8px; 
            }
            .page-title h1 { 
                font-size: 1.2rem; 
            }
        }
        @media (max-width: 480px) {
            .notifications-container, .options { 
                margin: 15px; 
                padding: 0.8rem; 
            }
            .alert-success, .alert-error { 
                margin: 15px; 
                padding: 10px 35px 10px 15px; 
                font-size: 13px; 
            }
            .filter-container { 
                flex-direction: column; 
            }
            .filter-dropdown { 
                width: 100%; 
            }
            .report-table th, .report-table td { 
                font-size: 0.7rem; 
                padding: 8px 6px; 
            }
            .status-pending, .status-read, .status-ordered, .po-pending, .po-completed, .po-none { 
                font-size: 9px; 
                padding: 2px 6px; 
            }
            .btn-mark-read { 
                padding: 4px 10px; 
                font-size: 10px; 
            }
            .custom-pagination a, .custom-pagination span { 
                min-width: 28px; 
                height: 28px; 
                font-size: 12px; 
            }
            .topheader { 
                padding: 10px; 
            }
            .user-menu { 
                gap: 10px;
             }
            .logout-btn { 
                padding: 8px 16px; 
                font-size: 12px; 
            }
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="brand">
            <div class="brand-icon">
                <i class="fa-solid fa-box"></i>
            </div>
            <div><h2 class="title">Inventory MS</h2></div>
        </div>
        <div class="nav-menu">
            <form action="{{ route('user.dashboard')}}" method="GET">
                <div class="nav-item">
                    <button>
                        <i class="fa-solid fa-chart-column"></i>
                        <span>Dashboard</span>
                    </button>
                </div>
            </form>
            <form action="{{ route('user.products') }}" method="GET">
                <div class="nav-item">
                    <button>
                        <i class="fas fa-cubes"></i>
                        <span>Products</span>
                    </button>
                </div>
            </form>
            <form action="{{ route('user.sales') }}" method="GET">
                <div class="nav-item">
                    <button><i class="fas fa-chart-line"></i>
                        <span>Sales</span>
                    </button>
                </div>
            </form>
            <form action="{{ route('user.purchases') }}" method="GET">
                <div class="nav-item">
                    <button><i class="fas fa-shopping-cart"></i>
                        <span>Purchases</span>
                    </button>
                </div>
            </form>
            <form action="{{ route('user.notifications') }}" method="GET">
                <div class="nav-item active">
                    <button><i class="fa-solid fa-bell"></i>
                        <span>Notifications</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="main-content">
        <div class="topheader">
            <div class="page-title">
                <h1 class="dashboard">Notifications</h1>
                <p class="dashboard-sub">Stay updated on stock reports and purchase orders</p>
            </div>
            <div class="user-menu">
                @php
                    $userPendingCount = \App\Models\StockReport::where('user_id', Auth::id())
                        ->where('status', 'pending')
                        ->where('notify_users', true)
                        ->count();
                @endphp
                <div class="notification-area">
                    <button class="notification-bell" id="userNotificationBell">
                        <i class="fas fa-bell"></i>
                        @if($userPendingCount > 0)
                            <span class="notification-badge" id="userNotificationBadge">{{ $userPendingCount }}</span>
                        @else
                            <span class="notification-badge" id="userNotificationBadge" style="display: none;">0</span>
                        @endif
                    </button>
                    
                    <div class="notification-dropdown" id="userNotificationDropdown">
                        <div class="notification-header">
                            <i class="fas fa-bell"></i> Notifications
                        </div>
                        <div class="notification-list" id="userNotificationList">
                            <div class="loading-notifications">Loading...</div>
                        </div>
                        <div class="notification-footer">
                            <a href="{{ route('user.notifications') }}">View All Notifications</a>
                        </div>
                    </div>
                </div>
                <div class="user-menu-container">
                    <a href="#">
                        <i class="fa-solid fa-user"></i>
                        <strong>{{ Auth::user()->fullname }}</strong>
                    </a>
                </div>
                <form action="{{ route('logout')}}" method="POST">
                    @csrf
                    <div class="logout-container">
                        <button type="submit" class="logout-btn">
                            <i class="fa-solid fa-right-from-bracket"></i>
                            <span>Logout</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        @if(session('success'))
            <div class="alert-success">
                {{ session('success') }}
                <button type="button" class="close-btn" onclick="this.parentElement.style.display='none'">&times;</button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert-error">
                {{ session('error') }}
                <button type="button" class="close-btn" onclick="this.parentElement.style.display='none'">&times;</button>
            </div>
        @endif

        <div class="options">
            <div class="filter-container">
                <select id="statusFilter" class="filter-dropdown">
                    <option value="all" {{ request('status') == 'all' || !request('status') ? 'selected' : '' }}>All Status</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Unread</option>
                    <option value="read" {{ request('status') == 'read' ? 'selected' : '' }}>Read</option>
                    <option value="ordered" {{ request('status') == 'ordered' ? 'selected' : '' }}>Acknowledged</option>
                </select>
            </div>
            <div class="recordcount">
                <span class="count">Total: </span>
                <strong>{{ $notifications->total() }}</strong>
            </div>
        </div>

        <div class="notifications-container">
            <div class="table-container">
                <table class="report-table">
                    <thead>
                        <tr>
                            <th>Date & Time</th>
                            <th>Product</th>
                            <th>Stock Info</th>
                            <th>PO Status</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($notifications as $notification)
                            @php
                                // Get PO status if purchase_id exists
                                $purchaseOrder = null;
                                $poStatus = null;
                                if($notification->purchase_id) {
                                    $purchaseOrder = \App\Models\Purchase::find($notification->purchase_id);
                                    if($purchaseOrder) {
                                        $poStatus = $purchaseOrder->status;
                                    }
                                }
                            @endphp
                            <tr @if($notification->status == 'pending') style="background-color: #f5f5f5;" @endif>
                                <td style="font-size: 12px;">{{ $notification->created_at->format('M j, Y g:i A') }}</td>
                                <td>
                                    <span style="font-size: 14px; font-weight: 500;">{{ $notification->product_name }}</span>
                                </td>
                                <td>
                                    <span class="report-text">
                                        Current stock: 
                                        <span style="font-weight: 500; color: red;">{{ $notification->current_stock }} units.</span>
                                        Minimum required: 
                                        <span style="font-weight: 500; color: rgb(248, 139, 6);">{{ $notification->min_stock_level }} units.</span>
                                    </span>
                                </td>
                                <td>
                                    @if($poStatus)
                                        @if($poStatus == 'completed')
                                            <span class="po-completed"><i class="fas fa-check-circle"></i> PO Completed</span>
                                        @elseif($poStatus == 'pending')
                                            <span class="po-pending"><i class="fas fa-clock"></i> PO Pending</span>
                                        @else
                                            <span class="po-pending"><i class="fas fa-shopping-cart"></i> PO Ordered</span>
                                        @endif
                                    @else
                                        <span class="po-none"><i class="fas fa-minus-circle"></i> No PO Yet</span>
                                    @endif
                                </td>
                                <td>
                                    @if($notification->status == 'pending')
                                        <span class="status-pending"><i class="fas fa-clock"></i> Unread</span>
                                    @elseif($notification->status == 'read')
                                        <span class="status-read"><i class="fas fa-eye"></i> Read</span>
                                    @else
                                        <span class="status-ordered"><i class="fas fa-check-circle"></i> Acknowledged</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        @if($notification->status == 'pending')
                                            <button class="btn-mark-read" onclick="markAsRead('{{ $notification->id }}')">
                                                <i class="fas fa-check"></i> Mark Read
                                            </button>
                                        @else
                                            <span class="ordered-text"><i class="fas fa-check-double"></i> Acknowledged</span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" style="text-align: center; padding: 40px;">
                                    <i class="fas fa-bell-slash" style="font-size: 48px; color: #ccc;"></i>
                                    <p style="margin-top: 10px;">No notifications found</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="custom-pagination">
                {{ $notifications->appends(request()->only(['status']))->links() }}
            </div>
        </div>
    </div>

    <script>
        // ==================== MARK AS READ ====================
        function markAsRead(notificationId) {
            if (confirm('Mark this notification as read?')) {
                fetch('{{ route("user.notification.mark-read") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ notification_id: notificationId })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const toast = document.createElement('div');
                        toast.className = 'toast-notification';
                        toast.innerHTML = '<i class="fas fa-check-circle"></i> Notification marked as read!';
                        document.body.appendChild(toast);
                        setTimeout(() => toast.remove(), 2000);
                        setTimeout(() => location.reload(), 1000);
                    } else {
                        alert('Failed to mark as read');
                    }
                })
                .catch(error => { console.error('Error:', error); alert('An error occurred'); });
            }
        }

        function markAsReadFromDropdown(notificationId) {
            fetch('{{ route("user.notification.mark-read") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ notification_id: notificationId })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const item = document.querySelector(`.notification-item[data-id="${notificationId}"]`);
                    if (item) item.remove();
                    const badge = document.querySelector('.notification-badge');
                    if (badge) {
                        let count = parseInt(badge.textContent) - 1;
                        if (count > 0) badge.textContent = count;
                        else badge.remove();
                    }
                    location.reload();
                } else {
                    alert('Failed to mark as read');
                }
            })
            .catch(error => { console.error('Error:', error); alert('An error occurred'); });
        }

        // ==================== STATUS FILTER ====================
        const statusFilter = document.getElementById('statusFilter');
        if (statusFilter) {
            statusFilter.addEventListener('change', function() {
                const url = new URL(window.location.href);
                if (this.value !== 'all') {
                    url.searchParams.set('status', this.value);
                } else {
                    url.searchParams.delete('status');
                }
                url.searchParams.set('page', '1');
                window.location.href = url.toString();
            });
        }

       // ==================== UNIFIED USER NOTIFICATION FUNCTIONS ====================
function fetchUserNotifications() {
    fetch('/user/notifications/bell', {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(function(response) { return response.json(); })
    .then(function(data) {
        if (data.success) {
            updateUserNotificationBell(data.unread_count);
            renderNotificationDropdown(data.notifications);
        }
    })
    .catch(function(error) { console.error('Notification error:', error); });
}

function updateUserNotificationBell(count) {
    var badge = document.getElementById('userNotificationBadge');
    if (!badge) return;
    if (count > 0) {
        badge.textContent = count;
        badge.style.display = 'flex';
    } else {
        badge.style.display = 'none';
    }
}

function renderNotificationDropdown(notifications) {
    var list = document.getElementById('userNotificationList');
    if (!list) return;

    if (!notifications || notifications.length === 0) {
        list.innerHTML = '<div class="no-notifications">'
            + '<i class="fas fa-check-circle" style="font-size:32px;margin-bottom:10px;display:block;"></i>'
            + '<p>No new notifications</p></div>';
        return;
    }

    var html = '';
    for (var i = 0; i < notifications.length; i++) {
        var notif = notifications[i];
        var isDamageResolved = notif.is_resolved
            || (notif.message && notif.message.includes('DAMAGE RESOLVED'));

        // Resolved badge (shown alongside mark read for damage resolved items)
        var resolvedBadge = isDamageResolved
            ? '<span class="resolved-badge"><i class="fas fa-check-circle"></i> Admin Resolved</span>'
            : '';

        // Action button — always show Mark Read for pending, show Read label otherwise
        var actionButton = notif.status === 'pending'
            ? resolvedBadge + '<button class="btn-read-notif" onclick="markUserNotificationAsRead('
                + notif.id + ')"><i class="fas fa-check"></i> Mark Read</button>'
            : '<span style="color:#28a745;font-size:12px;">'
                + '<i class="fas fa-check-double"></i> Read</span>';

        // PO status badge
        var poHtml = '';
        if (notif.po_status === 'completed') {
            poHtml = '<span style="background:#28a745;color:white;padding:2px 10px;border-radius:15px;font-size:10px;">'
                + '<i class="fas fa-check-circle"></i> PO Completed</span>';
        } else if (notif.po_status === 'pending') {
            poHtml = '<span style="background:#ffc107;color:#212529;padding:2px 10px;border-radius:15px;font-size:10px;">'
                + '<i class="fas fa-clock"></i> PO Pending</span>';
        } else if (notif.po_status) {
            poHtml = '<span style="background:#17a2b8;color:white;padding:2px 10px;border-radius:15px;font-size:10px;">'
                + '<i class="fas fa-shopping-cart"></i> PO Created</span>';
        } else {
            poHtml = '<span style="background:#6c757d;color:white;padding:2px 10px;border-radius:15px;font-size:10px;">'
                + '<i class="fas fa-minus-circle"></i> No PO Yet</span>';
        }

        var shortMessage = notif.message && notif.message.length > 120
            ? notif.message.substring(0, 120) + '...'
            : (notif.message || '');

        html += '<div class="notification-item unread" data-id="' + notif.id + '">'
            + '<div class="notification-title">'
            +   '<strong>' + escapeHtml(notif.product_name) + '</strong>'
            +   '<span class="notification-time">' + notif.time_ago + '</span>'
            + '</div>'
            + '<div class="notification-message">'
            +   '<div>' + escapeHtml(shortMessage) + '</div>'
            +   '<div style="margin-top:6px;">'
            +     '<strong>Stock:</strong> ' + notif.current_stock + ' / ' + notif.min_stock_level + ' min'
            +     ' | <strong>PO:</strong> ' + poHtml
            +   '</div>'
            + '</div>'
            + '<div class="notification-buttons">' + actionButton + '</div>'
            + '</div>';
    }

    list.innerHTML = html;
}

function markUserNotificationAsRead(notificationId) {
    fetch('{{ route("user.notification.mark-read") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify({ notification_id: notificationId })
    })
    .then(function(response) { return response.json(); })
    .then(function(data) {
        if (data.success) {
            var item = document.querySelector('.notification-item[data-id="' + notificationId + '"]');
            if (item) {
                item.style.opacity = '0';
                item.style.transition = 'opacity 0.3s ease';
                setTimeout(function() {
                    item.remove();
                    var list = document.getElementById('userNotificationList');
                    if (list && list.querySelectorAll('.notification-item').length === 0) {
                        list.innerHTML = '<div class="no-notifications">'
                            + '<i class="fas fa-check-circle" style="font-size:32px;margin-bottom:10px;display:block;"></i>'
                            + '<p>No new notifications</p></div>';
                    }
                }, 300);
            }
            fetchUserNotifications();
        } else {
            alert('Failed to mark as read');
        }
    })
    .catch(function(error) { console.error('Error:', error); });
}

function escapeHtml(text) {
    if (!text) return '';
    var div = document.createElement('div');
    div.textContent = String(text);
    return div.innerHTML;
}

// Bell toggle
var userBell     = document.getElementById('userNotificationBell');
var userDropdown = document.getElementById('userNotificationDropdown');
if (userBell) {
    userBell.addEventListener('click', function(e) {
        e.stopPropagation();
        userDropdown.classList.toggle('show');
        if (userDropdown.classList.contains('show')) fetchUserNotifications();
    });
}
document.addEventListener('click', function(e) {
    if (userDropdown && !userDropdown.contains(e.target) && userBell && !userBell.contains(e.target)) {
        userDropdown.classList.remove('show');
    }
});

fetchUserNotifications();
// Auto-refresh every 30 seconds (dashboard only needs this, harmless on others)
setInterval(fetchUserNotifications, 30000);
    </script>
</body>
</html>