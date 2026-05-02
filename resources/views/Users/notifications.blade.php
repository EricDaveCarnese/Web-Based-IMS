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
        .page-title p {
            font-size: 14px;
            color: #6c757d;
            margin-top: 5px;
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
            transition: all 0.3s ease; 
        }
        .logout-btn:hover { 
            transform: translateY(-2px); 
        }

        /* Search and Options Section */
        .options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
            margin: 20px 50px;
            flex-wrap: wrap;
        }
        .search-container {
            position: relative;
            flex: 1;
            max-width: 400px;
        }
        .search-wrapper {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .search-input {
            flex: 1;
            padding: 12px 16px;
            border: 1px solid #e2e8f0;
            border-radius: 25px;
            font-size: 14px;
            outline: none;
            transition: all 0.3s ease;
        }
        .search-input:focus {
            border-color: rgb(44, 110, 98);
            box-shadow: 0 0 0 3px rgba(44, 110, 98, 0.1);
        }
        .search-btn {
            background: linear-gradient(180deg, rgb(15, 43, 61) 0%, rgb(25, 110, 114) 100%);
            border: none;
            color: white;
            width: 44px;
            height: 44px;
            border-radius: 50%;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .search-btn:hover {
            transform: scale(1.05);
        }
        .autocomplete-dropdown {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: white;
            border: 1px solid #ddd;
            border-radius: 10px;
            max-height: 300px;
            overflow-y: auto;
            z-index: 1000;
            display: none;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            margin-top: 5px;
        }
        .autocomplete-dropdown.show {
            display: block;
        }
        .autocomplete-item {
            padding: 12px 16px;
            cursor: pointer;
            border-bottom: 1px solid #eee;
            transition: background 0.2s;
        }
        .autocomplete-item:hover {
            background: #f0f2f5;
        }
        .autocomplete-item strong {
            color: rgb(44, 110, 98);
        }
        .no-results {
            padding: 12px 16px;
            text-align: center;
            color: #999;
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
            cursor: pointer;
            min-width: 140px;
            transition: all 0.3s ease;
        }
        .clear-btn {
            background: linear-gradient(180deg, rgb(15, 43, 61) 0%, rgb(25, 110, 114) 100%);
            border: none;
            color: white;
            font-weight: 600;
            font-size: 14px;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 25px;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
        }
        .clear-btn:hover {
            transform: scale(1.03);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }
        .right {
            display: flex;
            align-items: center;
            gap: 15px;
            flex-wrap: wrap;
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
            min-width: 800px;
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
        .report-table tr:hover{
            background: linear-gradient(180deg, rgb(49, 83, 104) 0%, rgba(47, 229, 239, 0.426) 100%);
            color: white;
        }
        .report-table tr:hover .acknowledged-text{
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
        .po-pending {
            background: #ffc107;
            color: white;
        }
        .po-completed {
            background: #28a745;
            color: white;
        }
        .po-none {
            background: #6c757d;
            color: white;
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
            min-width: 110px;
            justify-content: center;
            transition: all 0.3s ease;
        }
        .btn-mark-read:hover {
            background: #5a6268;
            transform: translateY(-1px);
        }
        .po-pending,
        .po-completed,
        .po-none {
            min-width: 130px;
            justify-content: center;
            text-align: center;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            white-space: nowrap;
        }
        .acknowledged-text {
            color: #28a745;
            font-size: 12px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }
        .report-table td {
            vertical-align: middle;
        }

        /* Alert Messages */
        .alert-success {
            position: relative;
            background-color: #d4edda;
            color: #155724;
            padding: 12px 50px 12px 20px;
            border-radius: 8px;
            margin: 10px 50px;
            border-left: 4px solid #28a745;
        }
        .alert-error {
            position: relative;
            background-color: #f8d7da;
            color: #721c24;
            padding: 12px 50px 12px 20px;
            border-radius: 8px;
            margin: 10px 50px;
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
            text-decoration: none;
            font-size: 14px; 
            border-radius: 4px; 
        }
        .custom-pagination a { 
            color: #4a5568; 
            cursor: pointer; 
        }
        .custom-pagination a:hover { 
            background: #2c6e62; 
            color: white; 
        }
        .custom-pagination .page-active { 
            background: #2c6e62; 
            color: white; 
        }

        /* Responsive */
        @media (max-width: 1000px) {
            .sidebar { width: 90px; padding: 1rem 0.5rem; }
            .brand h2, .nav-menu button span { display: none; }
            .main-content { margin-left: 90px; }
            .page-title { margin-left: 20px; }
        }
        @media (max-width: 860px) {
            .options, .notifications-container { margin: 20px; }
            .options { flex-direction: column; align-items: stretch; }
            .search-container { max-width: 100%; }
            .right { justify-content: space-between; }
            .report-table th, .report-table td { padding: 10px 8px; font-size: 0.8rem; }
        }
        @media (max-width: 480px) {
            .filter-dropdown { width: 100%; }
            .right { flex-direction: column; align-items: stretch; }
            .report-table th, .report-table td { font-size: 0.7rem; padding: 8px 6px; }
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
                    <button><i class="fa-solid fa-chart-column"></i><span>Dashboard</span></button>
                </div>
            </form>
            <form action="{{ route('user.products') }}" method="GET">
                <div class="nav-item">
                    <button><i class="fas fa-cubes"></i><span>Products</span></button>
                </div>
            </form>
            <form action="{{ route('user.sales') }}" method="GET">
                <div class="nav-item">
                    <button><i class="fas fa-chart-line"></i><span>Sales</span></button>
                </div>
            </form>
            <form action="{{ route('user.purchases') }}" method="GET">
                <div class="nav-item">
                    <button><i class="fas fa-shopping-cart"></i><span>Purchases</span></button>
                </div>
            </form>
            <form action="{{ route('user.notifications') }}" method="GET">
                <div class="nav-item active">
                    <button><i class="fa-solid fa-bell"></i><span>Notifications</span></button>
                </div>
            </form>
        </div>
    </div>

    <div class="main-content">
        <div class="topheader">
            <div class="page-title">
                <h1>Notifications</h1>
                <p>Stay updated on stock reports and purchase orders</p>
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
                        <div class="notification-header"><i class="fas fa-bell"></i> Notifications</div>
                        <div class="notification-list" id="userNotificationList"><div class="loading-notifications">Loading...</div></div>
                        <div class="notification-footer"><a href="{{ route('user.notifications') }}">View All Notifications</a></div>
                    </div>
                </div>
                <div class="user-menu-container">
                    <a href="#"><i class="fa-solid fa-user"></i><strong>{{ Auth::user()->fullname }}</strong></a>
                </div>
                <form action="{{ route('logout')}}" method="POST">
                    @csrf
                    <button type="submit" class="logout-btn"><i class="fa-solid fa-right-from-bracket"></i>Logout</button>
                </form>
            </div>
        </div>

        @if(session('success'))
            <div class="alert-success">{{ session('success') }}<button type="button" class="close-btn" onclick="this.parentElement.style.display='none'">&times;</button></div>
        @endif
        @if(session('error'))
            <div class="alert-error">{{ session('error') }}<button type="button" class="close-btn" onclick="this.parentElement.style.display='none'">&times;</button></div>
        @endif

        <div class="options">
            <div class="search-container">
                <div class="search-wrapper">
                    <input type="text" id="searchInput" class="search-input" placeholder="Search by product name..." autocomplete="off" value="{{ request('search') }}">
                    <button class="search-btn" id="searchBtn"><i class="fas fa-search"></i></button>
                </div>
                <div id="autocompleteDropdown" class="autocomplete-dropdown"></div>
            </div>
            <div class="right">
                <div class="filter-container">
                    <select id="statusFilter" class="filter-dropdown">
                        <option value="all" {{ request('status') == 'all' || !request('status') ? 'selected' : '' }}>All Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Unread</option>
                        <option value="read" {{ request('status') == 'read' ? 'selected' : '' }}>Read</option>
                    </select>
                </div>
                <div class="recordcount"><span class="count">Total: </span><strong>{{ $notifications->total() }}</strong></div>
                <button class="clear-btn" id="clearFiltersBtn">Clear Filters</button>
            </div>
        </div>

        @php
            $suggestionProducts = \App\Models\StockReport::where('user_id', Auth::id())
                ->where('notify_users', true)
                ->distinct()
                ->pluck('product_name')
                ->toArray();
        @endphp
        <div id="suggestionData" style="display:none;" data-suggestions='@json($suggestionProducts)'></div>

        <div class="notifications-container">
            <div class="table-container">
                <table class="report-table">
                    <thead>
                        <tr>
                            <th>Date & Time</th>
                            <th>Product</th>
                            <th>Stock Info</th>
                            <th>Admin Action</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($notifications as $notification)
                            @php
                                $purchaseOrder = null;
                                $poStatus = null;
                                if($notification->purchase_id) {
                                    $purchaseOrder = \App\Models\Purchase::find($notification->purchase_id);
                                    if($purchaseOrder) $poStatus = $purchaseOrder->status;
                                }
                                $isDamageResolved = str_contains($notification->message, 'DAMAGE RESOLVED');
                            @endphp
                            <tr @if($notification->status == 'pending') style="background-color: #f5f5f5;" @endif>
                                <td>{{ $notification->created_at->format('M j, Y g:i A') }}</td>
                                <td><strong>{{ $notification->product_name }}</strong></td>
                                <td>
                                    @php
                                        $isDamageNotif  = str_contains($notification->message, 'DAMAGE');
                                        $isGoodNews     = str_contains($notification->message, 'GOOD NEWS');
                                        $isLowStock     = !$isDamageNotif && !$isGoodNews;
                                    @endphp

                                    @if($isDamageNotif)
                                        <div style="margin-bottom:6px;">
                                            <span style="background:#fd7e14; color:white; padding:3px 10px;
                                                        border-radius:12px; font-size:10px; font-weight:600;
                                                        display:inline-flex; align-items:center; gap:4px;">
                                                Damage Report
                                            </span>
                                        </div>
                                    @elseif($isGoodNews)
                                        <div style="margin-bottom:6px;">
                                            <span style="background:#28a745; color:white; padding:3px 10px;
                                                        border-radius:12px; font-size:10px; font-weight:600;
                                                        display:inline-flex; align-items:center; gap:4px;">
                                                Restock Update
                                            </span>
                                        </div>
                                    @else
                                        <div style="margin-bottom:6px;">
                                            <span style="background:#dc3545; color:white; padding:3px 10px;
                                                        border-radius:12px; font-size:10px; font-weight:600;
                                                        display:inline-flex; align-items:center; gap:4px;">
                                                Low Stock Alert
                                            </span>
                                        </div>
                                    @endif

                                    <div style="font-size:12px; line-height:1.8;">
                                        <span><strong>Current: </strong></span>
                                        <strong style="color: '{{ $notification->current_stock == 0 ? '#dc3545' : ($notification->current_stock <= $notification->min_stock_level ? '#fd7e14' : '#28a745') }}';">
                                            <strong>{{ $notification->current_stock }}</strong> units
                                        </strong>
                                        &nbsp;/&nbsp;
                                        <span><strong>Min: </strong></span>
                                        <strong>
                                            <Strong>{{ $notification->min_stock_level }}</Strong> units
                                        </strong>
                                    </div>

                                    @if($isDamageNotif)
                                        @php
                                            $dmgQty = 1;
                                            if (preg_match('/(\d+)\s+damaged/i', $notification->message, $m)) $dmgQty = (int)$m[1];
                                            elseif (preg_match('/Quantity affected:\s*(\d+)/i', $notification->message, $m)) $dmgQty = (int)$m[1];
                                        @endphp
                                        <div style="font-size:11px; color:#fd7e14; margin-top:4px;
                                                    display:flex; align-items:center; gap:4px;">
                                            Damage reported - {{ $dmgQty }} unit(s)
                                        </div>
                                    @elseif($isLowStock && $notification->current_stock == 0)
                                        <div style="font-size:11px; color:#dc3545; margin-top:4px;
                                                    display:flex; align-items:center; gap:4px;"> Out of stock
                                        </div>
                                    @elseif($isLowStock)
                                        @php
                                            $deficit = $notification->min_stock_level - $notification->current_stock;
                                        @endphp
                                        <div style="font-size:11px; color:#856404; margin-top:4px;
                                                    display:flex; align-items:center; gap:4px;">
                                            {{ $deficit }} unit(s) below minimum
                                        </div>
                                    @endif
                                </td>
                                <td>
                                @php
                                    $isDamageMsg = str_contains($notification->message, 'DAMAGE');
                                    $isLowStockMsg = str_contains($notification->message, 'GOOD NEWS') 
                                                || str_contains($notification->message, 'Purchase Order');
                                @endphp

                                @if($isDamageResolved)
                                    <span class="po-completed" style="background-color: rgb(0, 157, 47); color:white;">
                                        <i class="fas fa-check-circle"></i> Damage Resolved
                                    </span>

                                @elseif($poStatus == 'completed')
                                    <span class="po-completed">
                                        <i class="fas fa-check-double"></i> PO Completed
                                    </span>

                                @elseif($poStatus == 'pending')
                                    <span class="po-pending">
                                        <i class="fas fa-clock"></i> PO Pending
                                    </span>

                                @elseif($poStatus)
                                    <span class="po-pending">
                                        <i class="fas fa-shopping-cart"></i> PO Created
                                    </span>

                                @elseif($isDamageMsg && !$isDamageResolved)
                                    <span style="background:#fff3cd; color:#856404; padding:6px 12px;
                                                border-radius:20px; font-size:12px; font-weight:600;
                                                display:inline-flex; align-items:center; gap:6px;
                                                min-width:130px; justify-content:center; white-space:nowrap;">
                                        <i class="fas fa-hourglass-half"></i> Awaiting Review
                                    </span>

                                @else
                                    {{-- Low stock / PO not yet created --}}
                                    <span style="background:#f5c21c; color:#857f04; padding:6px 12px;
                                                border-radius:20px; font-size:12px; font-weight:600;
                                                display:inline-flex; align-items:center; gap:6px;
                                                min-width:130px; justify-content:center; white-space:nowrap;">
                                        <i class="fas fa-hourglass-half"></i> Pending Action
                                    </span>
                                @endif
                            </td>
                                <td>
                                    @if($notification->status == 'pending')
                                        <button class="btn-mark-read" onclick="markAsRead('{{ $notification->id }}')"><i class="fas fa-check"></i> Mark Read</button>
                                    @else
                                        <span class="acknowledged-text"><i class="fas fa-check-double"></i> Acknowledged</span>
                                    @endif
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
            <div class="pagination-container" id="customPagination"></div>
            <input type="hidden" id="currentPage" value="{{ $notifications->currentPage() }}">
            <input type="hidden" id="lastPage" value="{{ $notifications->lastPage() }}">
        </div>
    </div>

    <script>
        // Apply filters (search + status)
        function applyFilters() {
            const searchTerm = document.getElementById('searchInput').value.trim();
            const statusValue = document.getElementById('statusFilter').value;
            let url = '{{ route("user.notifications") }}';
            let params = [];
            if (searchTerm) params.push('search=' + encodeURIComponent(searchTerm));
            if (statusValue !== 'all') params.push('status=' + encodeURIComponent(statusValue));
            if (params.length) window.location.href = url + '?' + params.join('&');
            else window.location.href = url;
        }

        // Clear all filters
        function clearFilters() {
            window.location.href = '{{ route("user.notifications") }}';
        }

        // Mark notification as read
        function markAsRead(notificationId) {
            if (confirm('Mark this notification as read?')) {
                fetch('{{ route("user.notification.mark-read") }}', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                    body: JSON.stringify({ notification_id: notificationId })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert('Failed to mark as read');
                    }
                })
                .catch(error => { console.error('Error:', error); alert('An error occurred'); });
            }
        }

        // Autocomplete functionality
        const suggestionEl = document.getElementById('suggestionData');
        let searchSuggestions = [];
        if (suggestionEl) {
            try {
                searchSuggestions = JSON.parse(suggestionEl.getAttribute('data-suggestions')) || [];
            } catch(e) {
                searchSuggestions = [];
            }
        }

        const searchInput = document.getElementById('searchInput');
        const autocompleteDropdown = document.getElementById('autocompleteDropdown');
        let searchTimeout;

        function showSuggestions() {
            if (!searchInput) return;
            const query = searchInput.value.trim().toLowerCase();
            
            if (query.length === 0) {
                if (autocompleteDropdown) autocompleteDropdown.classList.remove('show');
                return;
            }
            
            let matches = [];
            if (searchSuggestions && searchSuggestions.length > 0) {
                for (let i = 0; i < searchSuggestions.length; i++) {
                    const suggestion = searchSuggestions[i];
                    if (!suggestion) continue;
                    const suggestionLower = String(suggestion).toLowerCase();
                    if (suggestionLower.includes(query)) {
                        matches.push(suggestion);
                    }
                    if (matches.length >= 10) break;
                }
            }
            
            if (matches.length > 0 && autocompleteDropdown) {
                let html = '';
                for (let i = 0; i < matches.length; i++) {
                    const match = matches[i];
                    const highlightedMatch = String(match).replace(new RegExp('(' + query.replace(/[.*+?^${}()|[\]\\]/g, '\\$&') + ')', 'gi'), '<strong>$1</strong>');
                    const escapedMatch = String(match).replace(/'/g, "\\'");
                    html += `<div class="autocomplete-item" onclick="selectSuggestion('${escapedMatch}')"><div>${highlightedMatch}</div></div>`;
                }
                autocompleteDropdown.innerHTML = html;
                autocompleteDropdown.classList.add('show');
            } else if (autocompleteDropdown) {
                autocompleteDropdown.innerHTML = `<div class="no-results">No products found matching "${query}"</div>`;
                autocompleteDropdown.classList.add('show');
            }
        }

        function selectSuggestion(suggestion) {
            if (searchInput) searchInput.value = suggestion;
            if (autocompleteDropdown) autocompleteDropdown.classList.remove('show');
            applyFilters();
        }

        // Event listeners
        document.getElementById('searchBtn')?.addEventListener('click', applyFilters);
        document.getElementById('clearFiltersBtn')?.addEventListener('click', clearFilters);
        document.getElementById('statusFilter')?.addEventListener('change', applyFilters);
        
        if (searchInput) {
            searchInput.addEventListener('input', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(showSuggestions, 300);
            });
            searchInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    if (autocompleteDropdown) autocompleteDropdown.classList.remove('show');
                    applyFilters();
                }
            });
        }
        
        document.addEventListener('click', function(e) {
            if (autocompleteDropdown && searchInput && !searchInput.contains(e.target) && !autocompleteDropdown.contains(e.target)) {
                autocompleteDropdown.classList.remove('show');
            }
        });

        // Notification bell functions
        function fetchUserNotifications() {
            fetch('/user/notifications/bell', {
                method: 'GET',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    updateUserNotificationBell(data.unread_count);
                    renderNotificationDropdown(data.notifications);
                }
            })
            .catch(error => console.error('Notification error:', error));
        }

        function updateUserNotificationBell(count) {
            const badge = document.getElementById('userNotificationBadge');
            if (!badge) return;
            if (count > 0) {
                badge.textContent = count;
                badge.style.display = 'flex';
            } else {
                badge.style.display = 'none';
            }
        }

        function escapeHtml(text) {
            if (!text) return '';
            const div = document.createElement('div');
            div.textContent = String(text);
            return div.innerHTML;
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

        var resolvedBadge = isDamageResolved
            ? '<span class="resolved-badge"><i class="fas fa-check-circle"></i> Admin Resolved</span>'
            : '';

        var actionButton = notif.status === 'pending'
            ? resolvedBadge + '<button class="btn-read-notif" onclick="markUserNotificationAsRead('
                + notif.id + ')"><i class="fas fa-check"></i> Mark Read</button>'
            : '<span style="color:#28a745;font-size:12px;">'
                + '<i class="fas fa-check-double"></i> Read</span>';

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
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'X-Requested-With': 'XMLHttpRequest' },
                body: JSON.stringify({ notification_id: notificationId })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const item = document.querySelector(`.notification-item[data-id="${notificationId}"]`);
                    if (item) item.remove();
                    fetchUserNotifications();
                } else {
                    alert('Failed to mark as read');
                }
            })
            .catch(error => console.error('Error:', error));
        }

        // Pagination
        function renderPagination() {
            const currentPage = parseInt(document.getElementById('currentPage')?.value || 1);
            const lastPage = parseInt(document.getElementById('lastPage')?.value || 1);
            const paginationContainer = document.getElementById('customPagination');
            if (!paginationContainer || lastPage <= 1) return;
            
            let html = '<div class="custom-pagination">';
            if (currentPage > 1) html += `<a href="#" class="page-link" data-page="${currentPage - 1}">&lt;</a>`;
            else html += `<span class="page-disabled">&lt;</span>`;
            
            let startPage = Math.max(1, currentPage - 2);
            let endPage = Math.min(lastPage, currentPage + 2);
            if (currentPage <= 3) endPage = Math.min(lastPage, 5);
            if (currentPage >= lastPage - 2) startPage = Math.max(1, lastPage - 4);
            
            if (startPage > 1) {
                html += `<a href="#" class="page-link" data-page="1">1</a>`;
                if (startPage > 2) html += `<span class="page-dots">...</span>`;
            }
            for (let i = startPage; i <= endPage; i++) {
                if (i === currentPage) html += `<span class="page-active">${i}</span>`;
                else html += `<a href="#" class="page-link" data-page="${i}">${i}</a>`;
            }
            if (endPage < lastPage) {
                if (endPage < lastPage - 1) html += `<span class="page-dots">...</span>`;
                html += `<a href="#" class="page-link" data-page="${lastPage}">${lastPage}</a>`;
            }
            if (currentPage < lastPage) html += `<a href="#" class="page-link" data-page="${currentPage + 1}">&gt;</a>`;
            else html += `<span class="page-disabled">&gt;</span>`;
            html += '</div>';
            paginationContainer.innerHTML = html;
            
            document.querySelectorAll('.page-link').forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    const page = this.getAttribute('data-page');
                    if (page) {
                        const urlParams = new URLSearchParams(window.location.search);
                        urlParams.set('page', page);
                        window.location.href = window.location.pathname + '?' + urlParams.toString();
                    }
                });
            });
        }

        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            renderPagination();
            fetchUserNotifications();
            setInterval(fetchUserNotifications, 30000);
        });

        // Bell toggle
        const userBell = document.getElementById('userNotificationBell');
        const userDropdown = document.getElementById('userNotificationDropdown');
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
    </script>
</body>
</html>