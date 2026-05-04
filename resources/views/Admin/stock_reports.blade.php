<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Stock Reports | Inventory MS</title>
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
        @keyframes 
            slideDown { 
                from { 
                    opacity: 0; 
                    transform: translateY(-10px); 
                } to { 
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
            max-height: 350px; 
            overflow-y: auto; 
        }
        .notification-item { 
            padding: 12px 15px; 
            border-bottom: 1px solid #e2e8f0; 
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
        }
        .notification-message { 
            font-size: 12px; 
            color: #6c757d; 
            margin-bottom: 8px; 
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
        .btn-order { 
            background: #28a745;
            color: white; 
            padding: 4px 10px; 
            border-radius: 15px; 
            font-size: 11px; 
            cursor: pointer; 
            border: none; 
        }
        .btn-read { 
            background: #6c757d; 
            color: white; 
            padding: 4px 10px; 
            border-radius: 15px; 
            font-size: 11px; 
            cursor: pointer; 
            border: none; 
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
        .no-notifications { 
            padding: 30px; 
            text-align: center; 
            color: #9ca3af; 
        }
        
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
        }
        .search-btn:hover {
            background: rgb(22, 155, 128);
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
        
        .filter-dropdown { 
            padding: 10px 16px; 
            border: 1px solid #e2e8f0; 
            border-radius: 25px; 
            font-size: 13px; 
            background: white; 
            cursor: pointer; 
            min-width: 140px; 
        }
        .clear-btn {
            background: linear-gradient(180deg, rgb(15, 43, 61) 0%, rgb(25, 110, 114) 100%);
            border: none;
            color: white;
            font-weight: 600;
            font-size: 16px;
            padding: 10px 24px;
            cursor: pointer;
            border-radius: 25px;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: all 0.3s ease;
        }
        .clear-btn:hover {
            transform: scale(1.03);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }
        .right { display: flex; align-items: center; gap: 15px; }
        .recordcount{
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
        .count{
            font-weight: 600;
            color: white;
        }
        .reports-container { 
            margin: 20px 50px; 
            background: white; 
            border-radius: 20px; 
            padding: 1.5rem; 
        }
        .table-container { 
            max-height: 600px; 
            overflow-y: auto; 
            overflow-x: auto; 
            border-radius: 12px; 
        }
        .report-table {
            width: 100%; 
            border-collapse: collapse; 
            font-size: 0.9rem; 
            min-width: 1000px; 
        }
        .report-table th, .report-table td { 
            padding: 14px 12px; 
            text-align: left; 
            border-bottom: 1px solid #e2e8f0; 
        }
        .report-table th { 
            background: linear-gradient(180deg, rgb(15, 43, 61) 0%, rgb(25, 110, 114) 100%); 
            color: white; 
            position: sticky; 
            top: 0; 
        }
        .report-table tr:hover {
            background: linear-gradient(180deg, rgb(49, 83, 104) 0%, rgba(47, 229, 239, 0.426) 100%);
            color: white;
        }
        /* Scrollable Table Wrapper */
        .table-container {
            max-height: 450px;
            overflow-y: auto;
            overflow-x: auto;
            border-radius: 12px;
            scrollbar-width: thin;
            scrollbar-color: #2c6e62 #f1f1f1;
        }
        .table-container::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        .table-container::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }
        .table-container::-webkit-scrollbar-thumb {
            background: #2c6e62;
            border-radius: 10px;
        }
        
        .status-pending { 
            background: #fff3cd; 
            color: #856404; 
            padding: 6px 12px; 
            border-radius: 20px; 
            font-size: 12px; 
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
            display: inline-flex; 
            align-items: center; 
            gap: 6px; 
        }
        .status-resolved { 
            background: #28a745; 
            color: white; 
            padding: 6px 12px; 
            border-radius: 20px; 
            font-size: 12px; 
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
            display: inline-flex; 
            align-items: center; 
            gap: 6px; 
        }
        
        .action-buttons { 
            display: flex; 
            gap: 8px; 
            flex-wrap: wrap; 
        }
        .btn-edit-product { 
            background: #fd7e14; 
            color: white; 
            border: none; 
            padding: 6px 12px; 
            border-radius: 20px; 
            cursor: pointer; 
            font-size: 12px; 
            display: inline-flex; 
            align-items: center; 
            gap: 6px; 
        }
        .btn-edit-product:hover { 
            background: #e86c00; 
            transform: translateY(-1px); 
        }
        .btn-mark-read { 
            background: #6c757d; 
            color: white; 
            border: none; 
            padding: 6px 12px; 
            border-radius: 20px; 
            cursor: pointer; 
            font-size: 12px; 
        }
        .btn-mark-read:hover { 
            background: #5a6268; 
        }
        .btn-create-po { 
            background: #28a745; 
            color: white; 
            border: none; 
            padding: 6px 12px; 
            border-radius: 20px; 
            cursor: pointer; 
            font-size: 12px; 
            display: inline-flex; 
            align-items: center; 
            gap: 6px; 
        }
        .btn-create-po:hover { 
            background: #218838; 
            transform: translateY(-1px); 
        }
        .resolved-text { 
            color: #28a745; 
            font-size: 12px; 
            font-weight: 600; 
            display: inline-flex; 
            align-items: center; 
            gap: 5px; 
            background: #d4edda; 
            padding: 6px 12px; 
            border-radius: 20px; 
        }
        .ordered-text { 
            color: #28a745; 
            font-size: 12px; 
            font-weight: 600;
            display: inline-flex; 
            align-items: center; 
            gap: 5px; 
            background: #d4edda; 
            padding: 6px 12px; 
            border-radius: 20px; 
        }
        
        .reporter-info { 
            display: flex; 
            flex-direction: column; 
            gap: 5px; 
        }
        .reporter-name { 
            font-size: 14px; 
            font-weight: 500; 
        }
        .reporter-badge { 
            display: inline-flex; 
            align-items: center; 
            gap: 5px; 
            padding: 3px 8px; 
            border-radius: 12px; 
            font-size: 10px; 
            font-weight: 600; 
            width: fit-content; 
        }
        .reporter-badge.damage { 
            background: #fd7e14; 
            color: white; 
        }
        .reporter-badge.auto { 
            background: #17a2b8; 
            color: white; 
        }
        .damage-note { 
            margin-top: 5px; 
            font-size: 11px; 
            color: #fd7e14; 
            display: flex; 
            align-items: center; 
            gap: 5px; 
        }
        
        .alert-success { 
            background: #d4edda; 
            color: #155724; 
            padding: 12px 50px; 
            margin: 10px 50px; 
            border-radius: 8px; 
            position: relative; 
        }
        .alert-error { 
            background: #f8d7da; 
            color: #721c24; 
            padding: 12px 40px; 
            margin: 10px 50px; 
            border-radius: 8px; 
            position: relative; 
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
        /* Custom Pagination */
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
        .custom-pagination .page-disabled { 
            color: #cbd5e0; 
            cursor: default; }
        .custom-pagination .page-dots {
            color: #a0aec0; 
            cursor: default; 
        }
        .page-active { 
            background: #2c6e62; 
            color: white; 
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
        }
        @media (max-width: 860px) { 
            .options { 
                flex-direction: column; 
            } 
            .search-container { 
                max-width: 100%; 
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
            <form action="{{ route('admin.dashboard')}}" method="GET">
                <div class="nav-item">
                    <button>
                        <i class="fa-solid fa-chart-column"></i>
                        <span>Dashboard</span>
                    </button>
                </div>
            </form>
            <form action="{{ route('admin.products') }}" method="GET">
                <div class="nav-item">
                    <button>
                        <i class="fas fa-cubes"></i>
                        <span>Products</span>
                    </button>
                </div>
            </form>
            <form action="{{ route('admin.categories') }}" method="GET">
                <div class="nav-item">
                    <button>
                        <i class="fa-solid fa-folder-open"></i>
                        <span>Categories</span>
                    </button>
                </div>
            </form>
            <form action="{{ route('admin.suppliers') }}" method="GET">
                <div class="nav-item">
                    <button>
                        <i class="fa-solid fa-warehouse"></i>
                        <span>Suppliers</span>
                    </button>
                </div>
            </form>
            <form action="{{ route('admin.sales') }}" method="GET">
                <div class="nav-item">
                    <button>
                        <i class="fas fa-chart-line"></i>
                        <span>Sales</span>
                    </button>
                </div>
            </form>
            <form action="{{ route('admin.purchases') }}" method="GET">
                <div class="nav-item">
                    <button>
                        <i class="fas fa-shopping-cart"></i>
                        <span>Purchases</span>
                    </button>
                </div>
            </form>
            <form action="{{ route('admin.reports') }}" method="GET">
                <div class="nav-item">
                    <button>
                        <i class="fas fa-file-alt"></i>
                        <span>Reports</span>
                    </button>
                </div>
            </form>
            <form action="{{ route('admin.users') }}" method="GET">
                <div class="nav-item">
                    <button>
                        <i class="fa-solid fa-users"></i>
                        <span>Users</span>
                    </button>
                </div>
            </form>
            <form action="{{ route('admin.logs') }}" method="GET">
                <div class="nav-item">
                    <button>
                        <i class="fa-solid fa-file-lines"></i>
                        <span>Log</span>
                    </button>
                </div>
            </form>
            <form action="{{ route('admin.stock.reports') }}" method="GET">
                <div class="nav-item active">
                    <button>
                        <i class="fa-solid fa-triangle-exclamation"></i>
                        <span>Stock Reports</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="main-content">
        <div class="topheader">
            <div class="page-title">
                <h1>Stock Reports</h1>
                <p>Manage low stock and damage reports from users</p>
            </div>
            <div class="user-menu">
                @php 
                    $pendingStockReportsCount = \App\Models\StockReport::where('status', 'pending')
                    ->where('notify_users', false)
                    ->count(); 
                @endphp
                <div class="notification-area">
                    <button class="notification-bell" id="notificationBell">
                        <i class="fas fa-bell"></i>
                        @if($pendingStockReportsCount > 0)
                            <span class="notification-badge">{{ $pendingStockReportsCount }}</span>
                        @endif
                    </button>
                    <div class="notification-dropdown" id="notificationDropdown">
                        <div class="notification-header">
                            <i class="fas fa-exclamation-triangle"></i> Stock Alerts
                        </div>
                        <div class="notification-list" id="notificationList">
                            <div class="loading-notifications">Loading...</div>
                        </div>
                        <div class="notification-footer">
                            <a href="{{ route('admin.stock.reports') }}">View All Reports</a>
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
                    <button type="submit" class="logout-btn">
                        <i class="fa-solid fa-right-from-bracket"></i>Logout
                    </button>
                </form>
            </div>
        </div>

        @if(session('success'))
            <div class="alert-success">{{ session('success') }}
                <button class="close-btn" onclick="this.parentElement.style.display='none'">&times;</button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert-error">{{ session('error') }}
                <button class="close-btn" onclick="this.parentElement.style.display='none'">&times;</button>
            </div>
        @endif

        <div class="options">
            <div class="search-container">
                <div class="search-wrapper">
                    <input type="text" id="searchReport" class="search-input" placeholder="Search by product or user..." autocomplete="off" value="{{ request('search') }}">
                    <button class="search-btn" id="searchBtn">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
                <div id="autocompleteDropdown" class="autocomplete-dropdown"></div>
            </div>
            <div class="right">
                <div class="filter-container">
                    <select id="statusFilter" class="filter-dropdown">
                        <option value="all" {{ request('status') == 'all' || !request('status') ? 'selected' : '' }}>All Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="read" {{ request('status') == 'read' ? 'selected' : '' }}>Read</option>
                        <option value="ordered" {{ request('status') == 'ordered' ? 'selected' : '' }}>Ordered</option>
                        <option value="resolved" {{ request('status') == 'resolved' ? 'selected' : '' }}>Resolved</option>
                    </select>
                </div>
                <div class="recordcount">
                    <span class="count">Total Record: </span>
                    <strong>{{ $reports->total() }}</strong>
                </div>
                <button class="clear-btn" id="clearFiltersBtn">Clear Filters</button>
            </div>
        </div>

        <div class="reports-container">
            <div class="table-container">
                <table class="report-table">
                    <thead>
                        <tr>
                            <th>Date & Time</th>
                            <th>Reported By</th>
                            <th>Product & Stock Info</th>
                            <th>Report Status</th>
                            <th>PO Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($reports as $report)
                            @php
                                $isDamageReport = str_contains($report->message, 'DAMAGE REPORT');
                                // ANY report that is NOT a damage report should be shown as Auto Alert (System)
                                $isLowStockReport = !$isDamageReport;
                                $displayReporter = $report->user_name;
                                $reporterIcon = '';
                                $reporterBadge = '';
                                $purchaseOrder = $report->purchase_id ? \App\Models\Purchase::find($report->purchase_id) : null;
                                
                                if ($isDamageReport) {
                                    $reporterIcon = '<i class="fas fa-user-circle"></i> ';
                                    $reporterBadge = '<span class="reporter-badge damage">
                                        <i class="fas fa-exclamation-triangle"></i> Damage Report</span>';
                                } else {
                                    // All non-damage reports (low stock, auto alerts, user reports) show as System Auto Alert
                                    $reporterIcon = ' ';
                                    $reporterBadge = '<span class="reporter-badge auto">
                                        <i class="fas fa-bell"></i> Auto Alert</span>';
                                    $displayReporter = 'System (Auto Alert)';
                                }
                            @endphp
                            <tr @if($report->status == 'pending' && !$isDamageReport)style="background-color: #f5f5f5;" @endif>
                                <td>{{ $report->created_at->format('M j, Y g:i A') }}</span>
                                <td>
                                    <div class="reporter-info">
                                        <div class="reporter-name">{!! $reporterIcon !!} 
                                            <strong>{{ $displayReporter }}</strong>
                                        </div>
                                        <div>{!! $reporterBadge !!}</div>
                                    </div>
                                </span>
                                <td>
                                    <strong>{{ $report->product_name }}</strong><br>
                                    @php
                                        $liveProduct = \App\Models\Product::find($report->product_id);
                                        $liveStock = $liveProduct ? $liveProduct->quantity : $report->current_stock;
                                        $liveMinStock = $liveProduct ? $liveProduct->min_stock_level : $report->min_stock_level;
                                    @endphp
                                    Current stock: <strong>{{ $liveStock }}</strong> units
                                    @if($isDamageReport)
                                        <div class="damage-note"> Damage reported - @php
                                        $damageQty = 1;
                                        if (preg_match('/(\d+)\s+damaged/i', $report->message, $matches)) {
                                            $damageQty = (int)$matches[1];
                                        } elseif (preg_match('/Quantity affected:\s*(\d+)/i', $report->message, $matches)) {
                                            $damageQty = (int)$matches[1];
                                        }
                                    @endphp
                                    {{ $damageQty }} unit(s)</div>
                                    @endif
                                </td>
                                <td>
                                    @if($report->status == 'pending')
                                        <span class="status-pending"><i class="fas fa-clock"></i> Pending</span>
                                    @elseif($report->status == 'read')
                                        <span class="status-read"><i class="fas fa-eye"></i> Read</span>
                                    @elseif($report->status == 'ordered')
                                        <span class="status-ordered"><i class="fas fa-check-circle"></i> Ordered</span>
                                    @elseif($report->status == 'resolved')
                                        <span class="status-resolved"><i class="fas fa-check-circle"></i> Resolved</span>
                                    @else
                                        <span class="status-read"><i class="fas fa-eye"></i> {{ ucfirst($report->status) }}</span>
                                    @endif
                                </span>
                                <td>
                                    @if($purchaseOrder)
                                        @if($purchaseOrder->status == 'completed')
                                            <span class="ordered-text"><i class="fas fa-check-circle"></i> Completed</span>
                                        @elseif($purchaseOrder->status == 'pending')
                                            <span class="status-pending"><i class="fas fa-clock"></i> PO Pending</span>
                                        @elseif($purchaseOrder->status == 'canceled')
                                            <span class="status-read"><i class="fas fa-times-circle"></i> Canceled</span>
                                        @endif
                                    @else
                                        <span class="status-read"
                                        style="background: #949594;
                                                color: white;
                                                padding: 6px 12px;
                                                border-radius: 20px;
                                                font-size: 12px; 
                                                display: inline-flex; 
                                                align-items: center;
                                                gap: 6px;">
                                        <i class="fas fa-minus-circle"></i> No PO</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        @if($isDamageReport)
                                            @if($report->status == 'resolved')
                                                <span class="resolved-text"><i class="fas fa-check-circle"></i> Resolved</span>
                                            @else
                                                <button class="btn-edit-product" onclick="handleDamageReport('{{ $report->product_id }}', '{{ addslashes($report->product_name) }}', '{{ addslashes($report->message) }}', '{{ $report->id }}')">
                                                    <i class="fas fa-edit"></i> Edit & Reduce Stock
                                                </button>
                                                @if($report->status == 'pending')
                                                    <button class="btn-mark-read" onclick="markAsRead('{{ $report->id }}')">
                                                        <i class="fas fa-check"></i> Mark Read
                                                    </button>
                                                @endif
                                            @endif
                                        @else
                                            @if($report->status == 'resolved')
                                                <span class="resolved-text"><i class="fas fa-check-circle"></i> Resolved</span>
                                            @elseif($report->status == 'ordered')
                                                <span class="ordered-text"><i class="fas fa-check-double"></i> Order Placed</span>
                                            @else
                                                <button class="btn-create-po" onclick="createPurchaseOrder('{{ $report->product_id }}', '{{ addslashes($report->product_name) }}', '{{ $report->id }}')">
                                                    <i class="fas fa-shopping-cart"></i> Create PO
                                                </button>
                                            @endif
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" style="text-align:center; padding:40px;">
                                    <i class="fa-solid fa-bell-slash" style="font-size: 48px; color: #ccc;"></i>
                                    <span> stock reports found</span>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="pagination-container" id="customPagination"></div>
                <input type="hidden" id="currentPage" value="{{ $reports->currentPage() }}">
                <input type="hidden" id="lastPage" value="{{ $reports->lastPage() }}">
        </div>
    </div>
    <div id="suggestionData" style="display:none;" data-suggestions='@json(array_unique(array_merge(\App\Models\Product::pluck("product_name")->toArray(), \App\Models\StockReport::distinct()->pluck("user_name")->toArray())))'></div>

    <script>
        //SEARCH AND FILTER
        function applyFilters() {
            const searchTerm = document.getElementById('searchReport').value.trim();
            const statusValue = document.getElementById('statusFilter').value;
            let url = '/admin/stock-reports';
            let params = [];
            if (searchTerm) params.push('search=' + encodeURIComponent(searchTerm));
            if (statusValue !== 'all') params.push('status=' + encodeURIComponent(statusValue));
            if (params.length) window.location.href = url + '?' + params.join('&');
            else window.location.href = url;
        }
        
        function clearFilters() {
            window.location.href = '/admin/stock-reports';
        }
        
        document.getElementById('searchBtn')?.addEventListener('click', applyFilters);
        document.getElementById('clearFiltersBtn')?.addEventListener('click', clearFilters);
        document.getElementById('statusFilter')?.addEventListener('change', applyFilters);
        document.getElementById('searchReport')?.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') applyFilters();
        });
        
        //MARK AS READ
        function markAsRead(reportId) {
            fetch('{{ route("admin.stock.report.read") }}', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                body: JSON.stringify({ report_id: reportId })
            })
            .then(function(response) { return response.json(); })
            .then(function(data) {
                if (data.success) {
                    // Update the table row visually without page reload
                    var row = document.querySelector('button[onclick*="markAsRead(\'' + reportId + '\')"]');
                    if (row) {
                        var tr = row.closest('tr');
                        if (tr) {
                            // Replace status badge
                            var statusTd = tr.querySelectorAll('td')[3];
                            if (statusTd) {
                                statusTd.innerHTML = '<span class="status-read"><i class="fas fa-eye"></i> Read</span>';
                            }
                            // Remove the Mark Read button
                            row.remove();
                        }
                    }
                    // Also refresh bell count
                    fetchNotifications();
                } else {
                    alert('Failed to mark as read: ' + (data.message || 'Unknown error'));
                }
            })
            .catch(function(error) { console.error('Error:', error); });
        }
        
        //CREATE PURCHASE ORDER
        function createPurchaseOrder(productId, productName, reportId) {
            if (confirm(`Create purchase order for "${productName}"?`)) {
                sessionStorage.setItem('prefill_product_id', productId);
                sessionStorage.setItem('prefill_product_name', productName);
                sessionStorage.setItem('prefill_report_id', reportId);
                sessionStorage.setItem('prefill_from_stock_report', 'true');
                window.location.href = '/admin/purchases?open_modal=1&product_id=' + productId + '&product_name=' + encodeURIComponent(productName) + '&report_id=' + reportId;
            }
        }
        
        //HANDLE DAMAGE REPORT
        function handleDamageReport(productId, productName, message, reportId) {
            let damageQuantity = 1;
            const quantityMatch = message.match(/Quantity affected:\s*(\d+)/i);
            if (quantityMatch) {
                damageQuantity = parseInt(quantityMatch[1]);
            }
            
            if (confirm(`Product: ${productName}\nDamaged Quantity: ${damageQuantity} units\n\nProceed to edit product and reduce stock?`)) {
                sessionStorage.setItem('damage_mode', 'true');
                sessionStorage.setItem('damage_product_id', productId);
                sessionStorage.setItem('damage_quantity', damageQuantity);
                sessionStorage.setItem('damage_report_id', reportId);
                window.location.href = '/admin/products?damage_mode=1&product_id=' + productId + '&damage_qty=' + damageQuantity + '&report_id=' + reportId;
            }
        }
        
        //AUTOCOMPLETE SUGGESTIONS FUNCTIONALITY
        const suggestionEl = document.getElementById('suggestionData');
        let searchSuggestions = [];
        if (suggestionEl) {
            try {
                searchSuggestions = JSON.parse(suggestionEl.getAttribute('data-suggestions')) || [];
            } catch(e) {
                searchSuggestions = [];
            }
        }
        
        const searchInput = document.getElementById('searchReport');
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
                    html += `<div class="autocomplete-item" onclick="selectSuggestion('${escapedMatch}')">
                                <div>${highlightedMatch}</div>
                            </div>`;
                }
                autocompleteDropdown.innerHTML = html;
                autocompleteDropdown.classList.add('show');
            } else if (autocompleteDropdown) {
                autocompleteDropdown.innerHTML = `<div class="no-results">No results found matching "${query}"</div>`;
                autocompleteDropdown.classList.add('show');
            }
        }
        
        function selectSuggestion(suggestion) {
            if (searchInput) searchInput.value = suggestion;
            if (autocompleteDropdown) autocompleteDropdown.classList.remove('show');
            applyFilters();
        }
        
        // Add event listeners for autocomplete
        if (searchInput) {
            searchInput.addEventListener('input', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(showSuggestions, 300);
            });
            
            // Close dropdown when clicking outside
            document.addEventListener('click', function(e) {
                if (autocompleteDropdown && searchInput && !searchInput.contains(e.target) && !autocompleteDropdown.contains(e.target)) {
                    autocompleteDropdown.classList.remove('show');
                }
            });
            
            // Handle Enter key
            searchInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    if (autocompleteDropdown) autocompleteDropdown.classList.remove('show');
                    applyFilters();
                }
            });
        }
        
        //NOTIFICATION DROPDOWN
        function fetchNotifications() {
            fetch('/admin/stock-reports/notifications', {
                method: 'GET',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    updateNotificationBell(data.unread_count);
                    renderNotificationDropdown(data.notifications);
                }
            })
            .catch(error => console.error('Error:', error));
        }
        
        function updateNotificationBell(count) {
            const badge = document.querySelector('.notification-badge');
            if (badge) {
                if (count > 0) {
                    badge.textContent = count;
                    badge.style.display = 'flex';
                } else {
                    badge.style.display = 'none';
                }
            }
        }
        
        function escapeHtml(text) {
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }
        
        function renderNotificationDropdown(notifications) {
            const list = document.getElementById('notificationList');
            if (!list) return;
            if (!notifications || notifications.length === 0) {
                list.innerHTML = '<div class="no-notifications"><i class="fas fa-check-circle" style="font-size: 32px; margin-bottom: 10px;"></i><p>No pending stock reports</p></div>';
                return;
            }
            let html = '';
            for (let i = 0; i < notifications.length; i++) {
                const notif = notifications[i];
                const isDamage = notif.message && notif.message.includes('DAMAGE REPORT');
                
                let damageQty = 1;
                if (isDamage) {
                    const qtyMatch = notif.message.match(/Quantity affected:\s*(\d+)/i);
                    if (qtyMatch) damageQty = parseInt(qtyMatch[1]);
                }
                
                html += `
                    <div class="notification-item unread" data-id="${notif.id}">
                        <div class="notification-title">
                            <strong>${escapeHtml(notif.product_name)}</strong>
                            <span class="notification-time">${notif.time_ago}</span>
                        </div>
                        <div class="notification-message">
                            Reported by: ${escapeHtml(notif.user_name)}<br>
                            Current Stock: ${notif.current_stock} units (Min: ${notif.min_stock_level})<br>
                            <small>${escapeHtml(notif.message.substring(0, 100))}${notif.message.length > 100 ? '...' : ''}</small>
                        </div>
                        <div class="notification-buttons">
                            ${isDamage ? 
                                `<button class="btn-edit-product" onclick="handleDamageReport(${notif.product_id}, '${escapeHtml(notif.product_name).replace(/'/g, "\\'")}', '${escapeHtml(notif.message).replace(/'/g, "\\'")}', ${notif.id})"><i class="fas fa-edit"></i> Edit & Reduce</button>` : 
                                `<button class="btn-create-po" onclick="createPurchaseOrder(${notif.product_id}, '${escapeHtml(notif.product_name).replace(/'/g, "\\'")}', ${notif.id})"><i class="fas fa-shopping-cart"></i> Create PO</button>`
                            }
                            <button class="btn-read" onclick="markAsRead(${notif.id})"><i class="fas fa-check"></i> Mark Read</button>
                        </div>
                    </div>
                `;
            }
            list.innerHTML = html;
        }
        // ==================== CUSTOM PAGINATION ====================
    function renderPagination() {
        var currentPage = parseInt(document.getElementById('currentPage').value);
        var lastPage = parseInt(document.getElementById('lastPage').value);
        var paginationContainer = document.getElementById('customPagination');
        if (!paginationContainer || lastPage <= 1) return;
        var html = '<div class="custom-pagination">';
        if (currentPage > 1) html += '<a href="#" class="page-link" data-page="' + (currentPage - 1) + '">&lt;</a>';
        else html += '<span class="page-disabled">&lt;</span>';
        var startPage = Math.max(1, currentPage - 2);
        var endPage = Math.min(lastPage, currentPage + 2);
        if (currentPage <= 3) endPage = Math.min(lastPage, 5);
        if (currentPage >= lastPage - 2) startPage = Math.max(1, lastPage - 4);
        if (startPage > 1) {
            html += '<a href="#" class="page-link" data-page="1">1</a>';
            if (startPage > 2) html += '<span class="page-dots">...</span>';
        }
        for (var i = startPage; i <= endPage; i++) {
            if (i === currentPage) html += '<span class="page-active">' + i + '</span>';
            else html += '<a href="#" class="page-link" data-page="' + i + '">' + i + '</a>';
        }
        if (endPage < lastPage) {
            if (endPage < lastPage - 1) html += '<span class="page-dots">...</span>';
            html += '<a href="#" class="page-link" data-page="' + lastPage + '">' + lastPage + '</a>';
        }
        if (currentPage < lastPage) html += '<a href="#" class="page-link" data-page="' + (currentPage + 1) + '">&gt;</a>';
        else html += '<span class="page-disabled">&gt;</span>';
        html += '</div>';
        paginationContainer.innerHTML = html;
        document.querySelectorAll('.page-link').forEach(function(link) {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                var page = this.getAttribute('data-page');
                if (page) {
                    var urlParams = new URLSearchParams(window.location.search);
                    urlParams.set('page', page);
                    window.location.href = window.location.pathname + '?' + urlParams.toString();
                }
            });
        });
    }
        
        // Notification bell toggle
        const bell = document.getElementById('notificationBell');
        const dropdown = document.getElementById('notificationDropdown');
        if (bell) {
            bell.addEventListener('click', function(e) { 
                e.stopPropagation(); 
                dropdown.classList.toggle('show'); 
                if (dropdown.classList.contains('show')) fetchNotifications();
            });
        }
        document.addEventListener('click', function() { if (dropdown) dropdown.classList.remove('show'); });
        
        document.addEventListener('DOMContentLoaded', function() {
        renderPagination();
        fetchNotifications();
        setInterval(fetchNotifications, 30000);
    });
    </script>
</body>
</html>