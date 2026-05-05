<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Activity Logs | Inventory MS</title>
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
        .dashboard {
            margin-bottom: 3px;
            font-weight: bold;
        }
        .dashboard-sub {
            color: gray;
            font-size: 14px;
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
            transition: all 0.3s ease; 
        }
        .logout-btn:hover { 
            transform: translateY(-2px); 
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
        }
        .notification-bell:hover { transform: scale(1.05); }
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
        .btn-edit-damage {
            background: #fd7e14;
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
        .btn-edit-damage {
            background: #fd7e14;
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
        .logs-container {
            margin: 20px 50px;
            background: white;
            border-radius: 20px;
            padding: 1.5rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        }

        .logs-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }

        /* Search Container with Autocomplete */
        .search-container {
            position: relative;
            flex: 1;
            max-width: 400px;
        }
        .search-wrapper {
            display: flex;
            align-items: center;
            gap: 10px;
            width: 100%;
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

        /* Filter Container */
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
        .filter-dropdown:focus {
            border-color: rgb(44, 110, 98);
            box-shadow: 0 0 0 3px rgba(44, 110, 98, 0.1);
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

        .record-count {
            background: #2c6e62;
            color: white;
            padding: 8px 16px;
            border-radius: 25px;
            font-size: 13px;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .table-wrapper { 
            overflow-x: auto; 
            max-height: 500px; 
            overflow-y: auto; 
            border-radius: 12px;
        }
        .table-wrapper::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        .table-wrapper::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }
        .table-wrapper::-webkit-scrollbar-thumb {
            background: #2c6e62;
            border-radius: 10px;
        }
        .table-wrapper::-webkit-scrollbar-thumb:hover {
            background: #1a4a42;
        }
        .table-wrapper {
            scrollbar-width: thin;
            scrollbar-color: #2c6e62 #f1f1f1;
        }

        .log-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.9rem;
            min-width: 900px;
        }
        .log-table th, .log-table td {
            padding: 14px 12px;
            text-align: left;
            border-bottom: 1px solid #e2e8f0;
        }
        .log-table th {
            background: linear-gradient(180deg, rgb(15, 43, 61) 0%, rgb(25, 110, 114) 100%);
            color: white;
            font-weight: 600;
            position: sticky;
            top: 0;
            z-index: 10;
        }
        .log-table tr:hover {
            background: linear-gradient(180deg, rgb(49, 83, 104) 0%, rgba(47, 229, 239, 0.426) 100%);
            color: white;
        }
        .options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
            margin: 20px 50px;
            flex-wrap: wrap;
        }
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
        
        .badge-create { 
            background: #28a745; 
            color: white; 
            padding: 4px 12px; 
            border-radius: 20px; 
            font-size: 12px; 
            font-weight: 600; 
            display: inline-block; 
        }
        .badge-update { 
            background: #ffc107; 
            color: #212529; 
            padding: 4px 12px; 
            border-radius: 20px; 
            font-size: 12px; 
            font-weight: 600; 
            display: inline-block; 
        }
        .badge-delete { 
            background: #dc3545; 
            color: white; 
            padding: 4px 12px; 
            border-radius: 20px; 
            font-size: 12px; 
            font-weight: 600; 
            display: inline-block; 
        }
        .badge-login { 
            background: #17a2b8; 
            color: white; 
            padding: 4px 12px; 
            border-radius: 20px; 
            font-size: 12px; 
            font-weight: 600; 
            display: inline-block; 
        }
        .badge-logout { 
            background: #6c757d; 
            color: white; 
            padding: 4px 12px; 
            border-radius: 20px; 
            font-size: 12px; 
            font-weight: 600; 
            display: inline-block; 
        }
        .badge-report { 
            background: #fd7e14; 
            color: white; 
            padding: 4px 12px; 
            border-radius: 20px; 
            font-size: 12px; 
            font-weight: 600; 
            display: inline-block; 
        }
        .badge-payment { 
            background: #20c997; 
            color: white; 
            padding: 4px 12px; 
            border-radius: 20px; 
            font-size: 12px; 
            font-weight: 600; 
            display: inline-block; 
        }
        .badge-complete { 
            background: #28a745; 
            color: white; 
            padding: 4px 12px; 
            border-radius: 20px; 
            font-size: 12px; 
            font-weight: 600; 
            display: inline-block; 
        }
        .badge-register { 
            background: #6f42c1; 
            color: white; 
            padding: 4px 12px; 
            border-radius: 20px; 
            font-size: 12px; 
            font-weight: 600; 
            display: inline-block; 
        }
        .badge-receive { 
            background: #0000ba; 
            color: white; 
            padding: 4px 12px; 
            border-radius: 20px; 
            font-size: 12px; 
            font-weight: 600; 
            display: inline-block; 
        }
        .badge-cancel { 
            background: #dc3545; 
            color: white; 
            padding: 4px 12px; 
            border-radius: 20px; 
            font-size: 12px; 
            font-weight: 600; 
            display: inline-block; 
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
        .custom-pagination a,
        .custom-pagination span {
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
        @media (max-width: 640px) {
            .custom-pagination { 
                gap: 4px; 
            }
            .custom-pagination a, .custom-pagination span { 
                min-width: 28px; 
                height: 28px; 
                font-size: 12px; 
            }
        }

        .no-results {
            text-align: center;
            padding: 40px;
            color: #9ca3af;
        }

        /* Responsive Design */
        @media (max-width: 1200px) {
            .logs-container { 
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
            .brand { 
                justify-content: center; 
            }
            .nav-menu button { 
                justify-content: center; 
                padding: 10px; 
            }
            .page-title { 
                margin-left: 20px; 
            }
            .page-title h1 { 
                font-size: 1.3rem; 
            }
        }
        @media (max-width: 860px) {
            .logs-container { 
                margin: 20px; 
            }
            .logs-options { 
                flex-direction: column; 
                align-items: stretch; 
            }
            .search-container { 
                max-width: 100%; 
            }
            .filter-container { 
                justify-content: space-between; 
            }
            .filter-dropdown { 
                flex: 1; 
            }
            .clear-btn { 
                width: 100%; 
                justify-content: center; 
            }
            .log-table th, .log-table td { 
                font-size: 12px; 
                padding: 8px; 
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
            .page-title p { 
                font-size: 11px; 
            }
        }
        @media (max-width: 480px) {
            .logs-container { 
                margin: 15px; 
                padding: 0.8rem; 
            }
            .log-table th, .log-table td { 
                font-size: 10px; 
                padding: 6px; 
            }
            .badge-create, .badge-update, .badge-delete, .badge-login, .badge-logout, .badge-report { 
                font-size: 9px; 
                padding: 2px 6px; 
            }
            .pagination a, .pagination span { 
                padding: 5px 8px; 
                font-size: 11px; 
            }
            .filter-container { 
                flex-direction: column; 
            }
            .filter-dropdown { 
                width: 100%; 
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
            .user-menu-container a { 
                padding-inline-start: 10px; 
                padding-inline-end: 10px; 
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
                <div class="nav-item active">
                    <button>
                        <i class="fa-solid fa-file-lines"></i>
                        <span>Log</span>
                    </button>
                </div>
            </form>
            <form action="{{ route('admin.stock.reports') }}" method="GET">
                <div class="nav-item">
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
                <h1>Activity Logs</h1>
                <p>Track all system activities and user actions</p>
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
                        <i class="fa-solid fa-right-from-bracket"></i>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </div>

        <div class="options">
            <div class="search-container">
                <div class="search-wrapper">
                    <input type="text" id="searchLog" class="search-input" placeholder="Search by user, description, or IP address..." autocomplete="off" value="{{ request('search') }}">
                    <button class="search-btn" onclick="applyFilters()">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
                <div id="autocompleteDropdown" class="autocomplete-dropdown"></div>
            </div>
            <div class="filter-container">
                <select id="moduleFilter" class="filter-dropdown">
                    <option value="all" {{ request('module') == 'all' || !request('module') ? 'selected' : '' }}>All Modules</option>
                    <option value="product" {{ request('module') == 'product' ? 'selected' : '' }}>Products</option>
                    <option value="category" {{ request('module') == 'category' ? 'selected' : '' }}>Categories</option>
                    <option value="supplier" {{ request('module') == 'supplier' ? 'selected' : '' }}>Suppliers</option>
                    <option value="sale" {{ request('module') == 'sale' ? 'selected' : '' }}>Sales</option>
                    <option value="purchase" {{ request('module') == 'purchase' ? 'selected' : '' }}>Purchases</option>
                    <option value="user" {{ request('module') == 'user' ? 'selected' : '' }}>Users</option>
                    <option value="stock" {{ request('module') == 'stock' ? 'selected' : '' }}>Stock Reports</option>
                    <option value="auth" {{ request('module') == 'auth' ? 'selected' : '' }}>Authentication</option>
                    <option value="batch_order" {{ request('module') == 'batch_order' ? 'selected' : '' }}>Batch Orders</option>
                </select>
                <select id="actionFilter" class="filter-dropdown">
                    <option value="all" {{ request('action') == 'all' || !request('action') ? 'selected' : '' }}>All Actions</option>
                    <option value="create" {{ request('action') == 'create' ? 'selected' : '' }}>Create</option>
                    <option value="update" {{ request('action') == 'update' ? 'selected' : '' }}>Update</option>
                    <option value="delete" {{ request('action') == 'delete' ? 'selected' : '' }}>Delete</option>
                    <option value="login" {{ request('action') == 'login' ? 'selected' : '' }}>Login</option>
                    <option value="logout" {{ request('action') == 'logout' ? 'selected' : '' }}>Logout</option>
                    <option value="register" {{ request('action') == 'register' ? 'selected' : '' }}>Register</option>
                    <option value="report" {{ request('action') == 'report' ? 'selected' : '' }}>Report</option>
                    <option value="payment" {{ request('action') == 'payment' ? 'selected' : '' }}>Payment</option>
                    <option value="complete" {{ request('action') == 'complete' ? 'selected' : '' }}>Complete</option>
                    <option value="cancel" {{ request('action') == 'cancel' ? 'selected' : '' }}>Cancel</option>
                    <option value="receive" {{ request('action') == 'receive' ? 'selected' : '' }}>Receive</option>
                </select>
                <div class="recordcount">
                    <span class="count">Total Record: </span>
                    <strong>{{ $logs->total() }}</strong>
                </div>
                <button class="clear-btn" onclick="clearFilters()">Clear Filters</button>
            </div>
        </div>
            
        <div class="logs-container">
            <div class="table-wrapper">
                <table class="log-table">
                    <thead>
                        <tr>
                            <th>Date & Time</th>
                            <th>User</th>
                            <th>Action</th>
                            <th>Module</th>
                            <th>Description</th>
                        </tr>
                    </thead>
                    <tbody id="logsTableBody">
                        @forelse($logs as $log)
                        <tr>
                            <td>{{ $log->created_at->format('M j, Y g:i A') }}</td>
                            <td>{{ $log->user_name }}</td>
                            <td><span class="badge-{{ $log->action }}">{{ ucfirst($log->action) }}</span></td>
                            <td>{{ ucfirst($log->module) }}</td>
                            <td>{{ $log->description }}</td>
                        </tr>
                        @empty
                            <tr>
                                <td colspan="5" style="text-align: center; padding: 40px;">
                                    <i class="fas fa-history" style="font-size: 48px; color: #ccc;"></i>
                                    <p>No activity logs found</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="pagination-container" id="customPagination"></div>
            <input type="hidden" id="currentPage" value="{{ $logs->currentPage() }}">
            <input type="hidden" id="lastPage" value="{{ $logs->lastPage() }}">
        </div>
    </div>

    <div id="logData" style="display: none;" data-logs='@json($logs ?? [])'></div>
    <div id="suggestionData" style="display:none;" data-suggestions='@json(array_unique(array_merge(\App\Models\Product::pluck("product_name")->toArray(), \App\Models\StockReport::distinct()->pluck("user_name")->toArray())))'></div>

    <script>
    //AUTOCOMPLETE DATA 
    const logDataElement = document.getElementById('logData');
    let allLogs = [];
    
    if (logDataElement) {
        try {
            const logsJson = logDataElement.getAttribute('data-logs');
            allLogs = JSON.parse(logsJson);
        } catch(e) { allLogs = []; }
    }
    
    let searchSuggestions = [];
    if (allLogs && allLogs.length > 0) {
        const usersSet = new Set(), descSet = new Set(), ipSet = new Set();
        if (allLogs.data) {
            allLogs.data.forEach(log => {
                if (log.user_name) usersSet.add(log.user_name);
                if (log.description) descSet.add(log.description.length > 50 ? log.description.substring(0,50)+'...' : log.description);
                if (log.ip_address) ipSet.add(log.ip_address);
            });
        }
        searchSuggestions = [...usersSet, ...descSet, ...ipSet];
    }
    if (searchSuggestions.length === 0) {
        searchSuggestions = ['Admin User', 'Jamaica', 'Eric Dave', 'Product created', 'Sale recorded', '127.0.0.1'];
    }
    
    function escapeHtml(text) {
        if (!text) return '';
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
    
    // TOAST MESSAGE 
    function showToast(message, bgColor) {
        var existing = document.querySelector('.toast-message');
        if (existing) existing.remove();
        var toast = document.createElement('div');
        toast.className = 'toast-message';
        toast.style.background = bgColor || '#28a745';
        toast.innerHTML = '<i class="fas fa-info-circle"></i> ' + message;
        document.body.appendChild(toast);
        setTimeout(function() { if (toast.parentElement) toast.remove(); }, 3000);
    }
    
    // AUTOCOMPLETE FUNCTIONALITY 
    const searchInput = document.getElementById('searchLog');
    const autocompleteDropdown = document.getElementById('autocompleteDropdown');
    let searchTimeout;
    
    function showSuggestions() {
        if (!searchInput) return;
        const query = searchInput.value.trim().toLowerCase();
        if (query.length === 0) { if (autocompleteDropdown) autocompleteDropdown.classList.remove('show'); return; }
        const matches = [];
        for (let i = 0; i < searchSuggestions.length; i++) {
            const suggestion = searchSuggestions[i];
            if (!suggestion) continue;
            if (suggestion.toLowerCase().includes(query)) matches.push(suggestion);
            if (matches.length >= 10) break;
        }
        if (matches.length > 0 && autocompleteDropdown) {
            let html = '';
            for (let i = 0; i < matches.length; i++) {
                const s = matches[i];
                const escapedSuggestion = s.replace(/'/g, "\\'");
                const regex = new RegExp('(' + query.replace(/[.*+?^${}()|[\]\\]/g, '\\$&') + ')', 'gi');
                const highlighted = s.replace(regex, '<strong>$1</strong>');
                html += `<div class="autocomplete-item" onclick="selectSuggestion('${escapedSuggestion}')">${highlighted}</div>`;
            }
            autocompleteDropdown.innerHTML = html;
            autocompleteDropdown.classList.add('show');
        } else if (autocompleteDropdown) {
            autocompleteDropdown.innerHTML = '<div class="no-results">No suggestions found</div>';
            autocompleteDropdown.classList.add('show');
        }
    }
    
    function selectSuggestion(suggestion) {
        if (searchInput) searchInput.value = suggestion;
        if (autocompleteDropdown) autocompleteDropdown.classList.remove('show');
        applyFilters();
    }
    
    if (searchInput) {
        searchInput.addEventListener('input', function() { clearTimeout(searchTimeout); searchTimeout = setTimeout(showSuggestions, 300); });
        document.addEventListener('click', function(e) {
            if (autocompleteDropdown && searchInput && !searchInput.contains(e.target) && !autocompleteDropdown.contains(e.target)) {
                autocompleteDropdown.classList.remove('show');
            }
        });
    }
    
    // APPLY FILTERS
    function applyFilters() {
        const searchTerm = document.getElementById('searchLog').value;
        const moduleValue = document.getElementById('moduleFilter').value;
        const actionValue = document.getElementById('actionFilter').value;
        let url = new URL(window.location.href);
        if (searchTerm) url.searchParams.set('search', searchTerm);
        else url.searchParams.delete('search');
        if (moduleValue && moduleValue !== 'all') url.searchParams.set('module', moduleValue);
        else url.searchParams.delete('module');
        if (actionValue && actionValue !== 'all') url.searchParams.set('action', actionValue);
        else url.searchParams.delete('action');
        url.searchParams.delete('page');
        window.location.href = url.toString();
    }
    
    function clearFilters() {
        window.location.href = window.location.pathname;
    }
    
    document.addEventListener('DOMContentLoaded', function() {
        const moduleFilter = document.getElementById('moduleFilter');
        const actionFilter = document.getElementById('actionFilter');
        if (moduleFilter) moduleFilter.addEventListener('change', applyFilters);
        if (actionFilter) actionFilter.addEventListener('change', applyFilters);
    });
    
    // NOTIFICATION DROPDOWN FUNCTIONS
    function fetchNotifications() {
        fetch('/admin/stock-reports/notifications', {
            method: 'GET',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(function(response) { return response.json(); })
        .then(function(data) {
            if (data.success) {
                updateNotificationBell(data.unread_count);
                renderNotificationDropdown(data.notifications);
            }
        })
        .catch(function(error) { console.error('Error:', error); });
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
            const isSystemAlert = notif.user_name === 'System (Auto Alert)';
            const isOutOfStock = notif.current_stock === 0;
            const stockColor = isOutOfStock ? '#dc3545' : (notif.current_stock <= notif.min_stock_level ? '#fd7e14' : '#28a745');
            
            let actionButton = '';
            if (isDamage) {
                if (notif.is_resolved) {
                    actionButton = '<span class="resolved-badge" style="background: #28a745; color: white; padding: 4px 10px; border-radius: 15px; font-size: 11px;"><i class="fas fa-check-circle"></i> Resolved</span>';
                } else {
                    const damageQty = notif.damage_quantity || 1;
                    actionButton = '<button class="btn-edit-damage" onclick="editProductAndReduceStock(' + notif.product_id + ', \'' + escapeHtml(notif.product_name).replace(/'/g, "\\'") + '\', ' + damageQty + ', ' + notif.id + ')"><i class="fas fa-edit"></i> Edit & Reduce (' + damageQty + ' units)</button>';
                }
            } else {
                actionButton = '<button class="btn-order" onclick="createPurchaseOrder(' + notif.product_id + ', \'' + escapeHtml(notif.product_name).replace(/'/g, "\\'") + '\', ' + notif.id + ')"><i class="fas fa-shopping-cart"></i> ' + (isSystemAlert ? 'Restock Now' : 'Create PO') + '</button>';
            }
            
            html += `
                    <div class="notification-item unread" data-id="${notif.id}">
                        <div class="notification-title">
                            <strong>${escapeHtml(notif.product_name)}</strong>
                            <span class="notification-time">${notif.time_ago}</span>
                        </div>
                        <div class="notification-message">
                            <strong>Reported by: </strong>${escapeHtml(notif.user_name)}<br>
                            <strong>Current Stock: </strong>${notif.current_stock} units (Min: ${notif.min_stock_level})<br>
                            <small>${escapeHtml(notif.message.substring(0, 100))}${notif.message.length > 100 ? '...' : ''}</small>
                        </div>
                        <div class="notification-buttons">
                            ${actionButton}
                            <button class="btn-read" onclick="markAsRead(${notif.id})"><i class="fas fa-check"></i> Mark Read</button>
                        </div>
                    </div>
                `;
        }
        list.innerHTML = html;
    }
    
    function markAsRead(reportId) {
        fetch('{{ route("admin.stock.report.read") }}', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: JSON.stringify({ report_id: reportId })
        })
        .then(function(response) { return response.json(); })
        .then(function(data) {
            if (data.success) {
                var item = document.querySelector('.notification-item[data-id="' + reportId + '"]');
                if (item) {
                    item.style.opacity = '0';
                    item.style.transition = 'opacity 0.3s ease';
                    setTimeout(function() {
                        item.remove();
                        var list = document.getElementById('notificationList');
                        if (list && list.querySelectorAll('.notification-item').length === 0) {
                            list.innerHTML = '<div class="no-notifications"><i class="fas fa-check-circle" style="font-size:32px;margin-bottom:10px;display:block;"></i><p>No pending stock reports</p></div>';
                        }
                    }, 300);
                }
                fetchNotifications();
            } else {
                alert('Failed to mark as read: ' + (data.message || 'Unknown error'));
            }
        })
        .catch(function(error) { console.error('Error:', error); });
    }
    
    function createPurchaseOrder(productId, productName, reportId) {
        if (confirm('Create purchase order for "' + productName + '"?')) {
            sessionStorage.setItem('prefill_product_id', productId);
            sessionStorage.setItem('prefill_product_name', productName);
            sessionStorage.setItem('prefill_report_id', reportId);
            sessionStorage.setItem('prefill_from_stock_report', 'true');
            window.location.href = '/admin/purchases?open_modal=1&product_id=' + productId + '&product_name=' + encodeURIComponent(productName) + '&report_id=' + reportId;
        }
    }
    
    function editProductAndReduceStock(productId, productName, damageQuantity, reportId) {
        if (confirm('Product: ' + productName + '\nDamaged Quantity: ' + damageQuantity + ' units\n\nClick OK to edit product and reduce stock by ' + damageQuantity + ' units.')) {
            window.location.href = '/admin/products?edit_damage=1&product_id=' + productId + '&damage_qty=' + damageQuantity + '&report_id=' + reportId;
        }
    }
    
    //NOTIFICATION BELL TOGGLE 
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
    
    //CUSTOM PAGINATION
    function renderPagination() {
        const currentPage = parseInt(document.getElementById('currentPage').value);
        const lastPage = parseInt(document.getElementById('lastPage').value);
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
    
    window.clearFilters = clearFilters;
    window.applyFilters = applyFilters;
    window.markAsRead = markAsRead;
    window.createPurchaseOrder = createPurchaseOrder;
    window.editProductAndReduceStock = editProductAndReduceStock;
    window.selectSuggestion = selectSuggestion;
    
    document.addEventListener('DOMContentLoaded', function() {
        renderPagination();
        fetchNotifications();
        setInterval(fetchNotifications, 10000);
    });
</script>
</body>
</html>