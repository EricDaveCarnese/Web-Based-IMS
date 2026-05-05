<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Reports & Analytics | Inventory MS</title>
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'%3E%3Crect width='100' height='100' fill='%232c6e62' rx='20'/%3E%3Crect x='25' y='30' width='50' height='40' fill='white' rx='5'/%3E%3Crect x='35' y='40' width='30' height='20' fill='%232c6e62' rx='3'/%3E%3C/svg%3E">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"/>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
        .logout-btn{
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

        /* Alert Messages */
        .alert-success {
            background: #dcfce7;
            color: #15803d;
            padding: 12px 20px;
            margin: 10px 50px 10px 50px;
            border-radius: 12px;
            border-left: 4px solid #15803d;
        }
        .alert-error {
            background: #fee2e2;
            color: #dc2626;
            padding: 12px 20px;
            margin: 10px 50px 10px 50px;
            border-radius: 12px;
            border-left: 4px solid #dc2626;
        }

        /* Report Filter Bar */
        .report-filter-bar {
            background: white;
            border-radius: 24px;
            margin: 20px 50px;
            padding: 20px 28px;
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            align-items: flex-end;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }
        .filter-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }
        .filter-group label {
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            color: #2c6e62;
            letter-spacing: 0.5px;
        }
        .filter-group input, .filter-group select {
            padding: 10px 16px;
            border-radius: 30px;
            border: 1px solid #cfdfed;
            background: white;
            font-size: 0.85rem;
            min-width: 170px;
            outline: none;
        }
        .filter-group input:focus, .filter-group select:focus {
            border-color: #2c6e62;
            box-shadow: 0 0 0 2px rgba(44,110,98,0.2);
        }
        .btn-generate {
            background: linear-gradient(180deg, rgb(15, 43, 61) 0%, rgb(25, 110, 114) 100%);
            border: none;
            padding: 10px 28px;
            border-radius: 40px;
            color: white;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: all 0.2s;
        }
        .btn-generate:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(0,0,0,0.15);
        }

        /* Stats Cards */
        .stats {
            display: flex;
            justify-content: space-between;
            margin: 20px 50px 20px 50px;
            gap: 30px;
            flex-wrap: wrap;
        }
        .stats-container {
            flex: 1;
            min-width: 200px;
            background-color: white;
            border-radius: 20px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            transition: transform 0.3s ease;
            padding: 20px 15px;
            text-align: center;
        }
        .stats-container:hover {
            transform: translateY(-3px);
        }
        .stats-container h3 {
            font-size: 14px;
            font-weight: 600;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 12px;
        }
        .stat-value {
            font-size: 32px;
            font-weight: 600;
            color: rgb(44, 110, 98);
            margin-bottom: 8px;
            line-height: 1.2;
            word-break: break-word;
        }
        .stat-sub {
            font-size: 12px;
            color: #9ca3af;
            margin-top: 5px;
        }

        /* Dashboard Row */
        .dashboard-row {
            display: flex;
            flex-wrap: wrap;
            gap: 1.5rem;
            margin: 0 50px 30px 50px;
        }
        .sales-performance-card {
            flex: 1.5;
            background: white;
            border-radius: 24px;
            padding: 1.2rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            transition: transform 0.3s ease;
        }
        .sales-performance-card:hover {
            transform: translateY(-3px);
        }
        .sales-performance-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 1.5rem;
            padding-bottom: 12px;
            border-bottom: 2px solid rgba(44, 110, 98, 0.2);
        }
        .sales-performance-header i {
            font-size: 28px;
            color: rgb(44, 110, 98);
        }
        .sales-performance-header h3 {
            font-size: 1.2rem;
            font-weight: 600;
            color: #1e3a38;
        }
        .sales-performance-body {
            height: 320px;
            position: relative;
            width: 100%;
        }
        .stock-card {
            flex: 1;
            background: white;
            border-radius: 24px;
            padding: 1.2rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            transition: transform 0.3s ease;
        }
        .stock-card:hover {
            transform: translateY(-3px);
        }
        .stock-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 1rem;
            padding-bottom: 12px;
            border-bottom: 2px solid rgba(44, 110, 98, 0.2);
        }
        .stock-header i {
            font-size: 28px;
            color: rgb(44, 110, 98);
        }
        .stock-header h3 {
            font-size: 1.2rem;
            font-weight: 600;
            color: #1e3a38;
        }
        .stock-content {
            display: flex;
            flex-direction: row;
            gap: 20px;
            align-items: center;
            flex-wrap: wrap;
            justify-content: center;
        }
        .pie-chart-section {
            width: 200px;
            height: 200px;
        }
        .categories-list {
            flex: 1;
            max-height: 220px;
            overflow-y: auto;
            padding-right: 10px;
            min-width: 150px;
        }
        .categories-list::-webkit-scrollbar {
            width: 6px;
        }
        .categories-list::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }
        .categories-list::-webkit-scrollbar-thumb {
            background: #2c6e62;
            border-radius: 10px;
        }
        .categories-list {
            scrollbar-width: thin;
            scrollbar-color: #2c6e62 #f1f1f1;
        }
        .category-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 12px;
            border-bottom: 1px solid #f0f0f0;
            font-size: 13px;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        .category-item:hover {
            background-color: #f5f5f5;
            transform: translateX(3px);
        }
        .category-name {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 13px;
            font-weight: 500;
            color: #334155;
        }
        .category-color {
            width: 12px;
            height: 12px;
            border-radius: 50%;
        }
        .category-stats {
            font-size: 13px;
            font-weight: 600;
            color: #2c6e62;
        }

        /* Alert Card */
        .alert-card {
            background: white;
            border-radius: 24px;
            margin: 0 50px 30px 50px;
            padding: 1.2rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            border-left: 4px solid #f97316;
            transition: transform 0.3s ease;
        }
        .alert-card:hover {
            transform: translateY(-3px);
        }
        .alert-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 1rem;
        }
        .alert-header i {
            font-size: 24px;
            color: #f97316;
        }
        .alert-header h3 {
            font-size: 1.1rem;
            color: #1e3a38;
        }
        .low-stock-item {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #f0f0f0;
        }
        .low-stock-item:last-child {
            border-bottom: none;
        }

        /* Report Table - Scrollable */
        .report-table-container {
            background: white;
            border-radius: 24px;
            margin: 0 50px 30px 50px;
            padding: 1.2rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        }
        .table-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
            padding-bottom: 12px;
            border-bottom: 2px solid rgba(44, 110, 98, 0.2);
            flex-wrap: wrap;
            gap: 15px;
        }
        .table-header h3 {
            font-size: 1.2rem;
            color: #1e3a38;
        }
        .search-filter-bar {
            display: flex;
            gap: 12px;
            align-items: center;
            flex-wrap: wrap;
        }
        .search-filter-bar input {
            padding: 8px 16px;
            border-radius: 30px;
            border: 1px solid #cfdfed;
            font-size: 0.85rem;
            width: 200px;
        }
        .search-filter-bar select {
            padding: 8px 16px;
            border-radius: 30px;
            border: 1px solid #cfdfed;
            font-size: 0.85rem;
        }
        /* Scrollable Table Wrapper */
        .table-wrapper {
            max-height: 450px;
            overflow-y: auto;
            overflow-x: auto;
            border-radius: 12px;
            scrollbar-width: thin;
            scrollbar-color: #2c6e62 #f1f1f1;
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
        .data-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.85rem;
            min-width: 900px;
        }
        .data-table th, .data-table td {
            padding: 12px 10px;
            text-align: left;
            border-bottom: 1px solid #e2e8f0;
        }
        .data-table th {
            background: linear-gradient(180deg, rgb(15, 43, 61) 0%, rgb(25, 110, 114) 100%);
            color: white;
            position: sticky;
            top: 0;
            z-index: 10;
        }
        .data-table tr:hover {
            background: linear-gradient(180deg, rgb(49, 83, 104) 0%, rgba(47, 229, 239, 0.426) 100%);
            color: white;
        }
        .badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 30px;
            font-size: 0.7rem;
            font-weight: 600;
        }
        .badge-completed {
            background: #28a745;
            color: white;
        }
        .badge-pending {
            background: #ffc107;
            color: #212529;
        }
        .badge-canceled {
            background: #dc3545;
            color: white;
        }
        .badge-sale {
            background: #dcfce7;
            color: #15803d;
        }
        .badge-purchase {
            background: #fff3e3;
            color: #b45309;
        }
        
        /* View Details Button */
        .view-details-btn {
            background: #007bff;
            color: white;
            border: none;
            padding: 4px 10px;
            border-radius: 15px;
            cursor: pointer;
            font-size: 11px;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }
        .view-details-btn:hover {
            background: #0056b3;
            transform: scale(1.02);
        }
        
        .loading-spinner {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 2px solid #eef2f6;
            border-top: 2px solid #2c6e62;
            border-radius: 50%;
            animation: spin 0.6s linear infinite;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
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

        /* Modal Styles */
        .modal-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(4px);
            display: flex;
            align-items: center;
            justify-content: center;
            visibility: hidden;
            opacity: 0;
            transition: all 0.3s ease;
            z-index: 1000;
        }
        .modal-container.show {
            visibility: visible;
            opacity: 1;
        }
        .modal {
            width: 90%;
            max-width: 650px;
            background: linear-gradient(45deg, rgb(44, 110, 98) 20%, #144243 50%);
            padding: 25px;
            border-radius: 15px;
            animation: modalSlideIn 0.3s ease;
            max-height: 90vh;
            overflow-y: auto;
        }
        @keyframes modalSlideIn {
            from { transform: translateY(-30px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
        .modal-header {
            color: rgb(151, 205, 200);
            margin-bottom: 20px;
        }
        .modal-header h2 {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 1.4rem;
        }
        .sale-info, .purchase-info {
            margin-bottom: 15px;
            color: white;
            line-height: 1.8;
        }
        .sale-info strong, .purchase-info strong {
            color: rgb(151, 205, 200);
        }
        .details-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        .details-table th,
        .details-table td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            color: white;
        }
        .details-table th {
            background: rgba(15, 43, 61, 0.5);
            color: rgb(151, 205, 200);
        }
        .details-table tfoot td {
            border-top: 2px solid rgba(255, 255, 255, 0.4);
            font-weight: 700;
        }
        .cancel-button {
            width: 100%;
            padding: 12px;
            border-radius: 25px;
            cursor: pointer;
            margin-top: 10px;
            font-weight: 600;
            transition: all 0.3s ease;
            border: none;
            background: linear-gradient(180deg, rgb(188, 179, 170) 0%, rgb(214, 162, 79) 100%);
        }
        .cancel-button:hover {
            transform: translateY(-2px);
        }
        .spinner-row td {
            text-align: center;
            padding: 30px;
        }
        
        /* Date column width */
        .data-table th:first-child,
        .data-table td:first-child {
            white-space: nowrap;
            min-width: 180px;
        }
        
        /* Responsive */
        @media (max-width: 1200px) {
            .stats { 
                margin: 20px 30px; 
                gap: 20px; 
            }
            .dashboard-row { 
                margin: 0 30px 20px 30px; 
            }
            .report-table-container, .alert-card, .report-filter-bar { 
                margin-left: 30px; 
                margin-right: 30px; 
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
        }
        @media (max-width: 860px) {
            .stats { 
                margin: 20px 20px; 
                flex-direction: column;
            }
            .dashboard-row { 
                margin: 0 20px 20px 20px; 
                flex-direction: column; 
            }
            .report-table-container, .alert-card, .report-filter-bar { 
                margin-left: 20px; 
                margin-right: 20px; 
            }
            .sales-performance-body { 
                height: 280px; 
            }
            .stock-content { 
                flex-direction: column; 
            }
            .pie-chart-section { 
                width: 200px; 
                height: 200px; 
            }
            .categories-list { 
                max-height: 200px; 
                width: 100%; 
            }
            .table-wrapper { 
                max-height: 350px; 
            }
        }
        @media (max-width: 768px) {
            .sidebar { 
                width: 70px; 
            }
            .main-content { 
                margin-left: 70px; 
            }
            .stat-value { 
                font-size: 24px; 
            }
            .report-filter-bar { 
                padding: 15px 20px; 
            }
            .filter-group input, .filter-group select { 
                min-width: 100%; 
            }
            .btn-generate { 
                width: 100%; 
                justify-content: center; 
            }
            .table-header { 
                flex-direction: column; 
                align-items: flex-start; 
            }
            .search-filter-bar { 
                width: 100%; 
            }
            .table-wrapper { 
                max-height: 300px; 
            }
        }
        @media (max-width: 480px) {
            .stats { 
                margin: 15px 15px; 
            }
            .dashboard-row { 
                margin: 0 15px 15px 15px; 
            }
            .report-table-container, .alert-card, .report-filter-bar { 
                margin-left: 15px; 
                margin-right: 15px; 
                padding: 1rem; 
            }
            .sales-performance-body { 
                height: 220px; 
            }
            .pie-chart-section { 
                width: 160px;
                height: 160px; 
            }
            .data-table th, .data-table td { 
                padding: 8px 6px; 
                font-size: 0.7rem; 
            }
            .badge { 
                padding: 2px 8px; 
                font-size: 0.6rem; 
            }
            .stat-value { 
                font-size: 20px; 
            }
            .table-wrapper {
                max-height: 250px; 
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
            <div class="nav-item active">
                <button>
                    <i class="fas fa-file-alt"></i>
                    <span>Reports</span>
                </button>
            </div>
        </form>
        <form action="{{ route('admin.users') }}" method="GET">
            <div class="nav-item">
                <button>
                    <i class="fas fa-users"></i>
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
            <h1 class="dashboard">Reports & Analytics</h1>
            <p class="dashboard-sub">Real-time inventory and sales analytics from your database</p>
        </div>
        <div class="user-menu">
            @php 
                $pendingStockReportsCount = \App\Models\StockReport::where('status', 'pending')->where('notify_users', false)->count();
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
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="alert-error">
            {{ session('error') }}
        </div>
    @endif

    <!-- Report Filter Bar -->
    <div class="report-filter-bar">
        <div class="filter-group">
            <label>
                <i class="far fa-calendar-alt"></i> Start Date
            </label>
            <input type="date" id="startDate" value="2020-01-01">
        </div>
        <div class="filter-group">
            <label>
                <i class="far fa-calendar-alt"></i> End Date
            </label>
            <input type="date" id="endDate" value="{{ date('Y-m-d') }}">
        </div>
        <div class="filter-group">
            <label>Report Type</label>
            <select id="reportType">
                <option value="all">All Transactions</option>
                <option value="sales">Sales Only</option>
                <option value="purchases">Purchases Only</option>
            </select>
        </div>
        <button class="btn-generate" id="generateReportBtn">
            <i class="fas fa-chart-line"></i> Generate Report
        </button>
    </div>

    <div id="reportContent">
        <!-- Stats Cards -->
        <div class="stats">
            <div class="stats-container">
                <h3>Total Revenue</h3>
                <div class="stat-value" id="statRevenue">₱0</div>
                <div class="stat-sub">selected period</div>
            </div>
            <div class="stats-container">
                <h3>Total Transactions</h3>
                <div class="stat-value" id="statTransactionCount">0</div>
                <div class="stat-sub">sales & purchases</div>
            </div>
            <div class="stats-container">
                <h3>Avg. Transaction</h3>
                <div class="stat-value" id="statAvgTransaction">₱0</div>
                <div class="stat-sub">per transaction</div>
            </div>
            <div class="stats-container">
                <h3>Top Product</h3>
                <div class="stat-value" id="statTopProduct">—</div>
                <div class="stat-sub">best selling this period</div>
            </div>
        </div>

        <div class="alert-card" id="lowStockAlert">
            <div class="alert-header">
                <i class="fas fa-exclamation-triangle"></i>
                <h3>Low Stock Alerts</h3>
            </div>
            <div id="lowStockList">Loading...</div>
        </div>

        <!-- Charts Row -->
        <div class="dashboard-row">
            <div class="sales-performance-card">
                <div class="sales-performance-header">
                    <i class="fas fa-chart-line"></i>
                    <h3>Monthly Sales Performance</h3>
                </div>
                <div class="sales-performance-body">
                    <canvas id="salesChart"></canvas>
                </div>
            </div>
            <div class="stock-card">
                <div class="stock-header">
                    <i class="fas fa-chart-pie"></i>
                    <h3>Inventory Distribution by Category</h3>
                </div>
                <div class="stock-content">
                    <div class="pie-chart-section">
                        <canvas id="stockPieChart"></canvas>
                    </div>
                    <div class="categories-list" id="categoriesList"></div>
                </div>
            </div>
        </div>

        <!-- Detailed Report Table with View Button and Pagination -->
        <div class="report-table-container">
            <div class="table-header">
                <h3><i class="fas fa-list-alt"></i> Transaction History</h3>
                <div class="search-filter-bar">
                    <input type="text" id="searchInput" placeholder="Search product or category...">
                    <select id="statusFilter">
                        <option value="all">All Status</option>
                        <option value="completed">Completed</option>
                        <option value="pending">Pending</option>
                        <option value="canceled">Canceled</option>
                    </select>
                    <span id="recordCount" style="font-size:0.8rem; font-weight: 600; color:#2c6e62;">0 record(s)</span>
                </div>
            </div>
            <div class="table-wrapper">
                <table class="data-table" id="reportTable">
                    <thead>
                        <tr>
                            <th>Date & Time</th>
                            <th>Type</th>
                            <th>Product</th>
                            <th>Category</th>
                            <th>Quantity</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="reportTableBody">
                        <tr>
                            <td colspan="8" style="text-align:center;">
                                <span>Select filters and click Generate Report</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- Custom Pagination -->
            <div class="pagination-container" id="customPagination"></div>
            <input type="hidden" id="currentPage" value="1">
            <input type="hidden" id="lastPage" value="1">
            <input type="hidden" id="totalRecords" value="0">
        </div>
    </div>
</div>

<!-- Sale Details Modal -->
<div class="modal-container" id="saleDetailsModal">
    <div class="modal">
        <div class="modal-header">
            <h2>
                <i class="fa-solid fa-receipt"></i> Sale Details #
                <span id="sale_detail_id"></span>
            </h2>
        </div>
        <div class="modal-body">
            <div class="sale-info">
                <strong>Cashier:</strong> 
                <span id="sale_cashier"></span><br>
                <strong>Date &amp; Time:</strong> 
                <span id="sale_date_display"></span><br>
                <strong>Status:</strong> 
                <span id="sale_status_display"></span>
            </div>
            <h4 style="color:rgb(151,205,200);margin-bottom:10px;">Items Sold: 
                <span id="sale_items_count" style="font-size:13px;font-weight:400;"></span>
            </h4>
            <div style="overflow-x:auto;">
                <table class="details-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Product</th>
                            <th style="text-align:center">Qty</th>
                            <th style="text-align:right">Unit Price</th>
                            <th style="text-align:right">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody id="sale_items_table">
                        <tr class="spinner-row">
                            <td colspan="5">
                                <div class="loading-spinner"></div> Loading...
                            </td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="4" style="text-align:right;color:rgb(151,205,200);">Grand Total:</td>
                            <td style="text-align:right">
                                <strong id="sale_total">₱0.00</strong>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <button id="close_sale_modal" class="cancel-button"><i class="fa-solid fa-circle-xmark"></i> Close</button>
        </div>
    </div>
</div>

<!-- Purchase Details Modal -->
<div class="modal-container" id="purchaseDetailsModal">
    <div class="modal">
        <div class="modal-header">
            <h2><i class="fa-solid fa-truck"></i> Purchase Order #
                <span id="purchase_id"></span>
            </h2>
        </div>
        <div class="modal-body">
            <div class="purchase-info">
                <strong>Supplier:</strong> 
                    <span id="purchase_supplier"></span><br>
                <strong>Date:</strong> 
                    <span id="purchase_date"></span><br>
                <strong>Batch #:</strong> 
                    <span id="purchase_batch"></span><br>
                <strong>Status:</strong> 
                    <span id="purchase_status"></span>
            </div>
            <h4 style="color:rgb(151,205,200);margin-bottom:10px;">Items Purchased:</h4>
            <div style="overflow-x:auto;">
                <table class="details-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Product</th>
                            <th style="text-align:center">Qty</th>
                            <th style="text-align:right">Cost Price</th>
                            <th style="text-align:right">Total</th>
                        </tr>
                    </thead>
                    <tbody id="purchase_items_table">
                        <tr class="spinner-row">
                            <td colspan="5">
                                <div class="loading-spinner"></div> Loading...
                            </td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="4" style="text-align:right;color:rgb(151,205,200);">Grand Total:</td>
                            <td style="text-align:right">
                                <strong id="purchase_total">₱0.00</strong>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <button id="close_purchase_modal" class="cancel-button">
                <i class="fa-solid fa-circle-xmark"></i> Close
            </button>
        </div>
    </div>
</div>

<script>
// ==================== GLOBAL VARIABLES ====================
var markAsRead, createPurchaseOrder, editProductAndReduceStock;

// ==================== NOTIFICATION SYSTEM ====================
(function() {
    var CSRF = '';
    var lastUnreadCount = -1;
    var pollTimer = null;

    function getCSRF() {
        var meta = document.querySelector('meta[name="csrf-token"]');
        if (meta) CSRF = meta.content;
        return CSRF;
    }

    function fetchNotifications() {
        getCSRF();

        fetch('/admin/stock-reports/notifications', {
            method: 'GET',
            headers: {
                'X-CSRF-TOKEN': CSRF,
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(function(response) {
            if (!response.ok) throw new Error('HTTP ' + response.status);
            return response.json();
        })
        .then(function(data) {
            if (!data.success) return;

            updateBell(data.unread_count);

            var dropdown = document.getElementById('notificationDropdown');
            var isOpen = dropdown && dropdown.classList.contains('show');

            if (data.unread_count !== lastUnreadCount || isOpen) {
                renderDropdown(data.notifications);
                lastUnreadCount = data.unread_count;
            }
        })
        .catch(function(error) {
            console.error('Notification fetch error:', error);
        });
    }

    function updateBell(count) {
        var bell = document.getElementById('notificationBell');
        if (!bell) return;

        var badge = bell.querySelector('.notification-badge');
        
        if (!badge && count > 0) {
            badge = document.createElement('span');
            badge.className = 'notification-badge';
            bell.appendChild(badge);
        }

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
        if (!text) return '';
        var div = document.createElement('div');
        div.textContent = String(text);
        return div.innerHTML;
    }

    function renderDropdown(notifs) {
        var list = document.getElementById('notificationList');
        if (!list) return;

        if (!notifs || notifs.length === 0) {
            list.innerHTML = '<div class="no-notifications">' +
                '<i class="fas fa-check-circle" style="font-size:32px;margin-bottom:10px;display:block;"></i>' +
                '<p>No pending stock reports</p></div>';
            return;
        }

        var html = '';
        for (var i = 0; i < notifs.length; i++) {
            var n = notifs[i];
            var isDamage = n.is_damage || (n.message && n.message.indexOf('DAMAGE REPORT') !== -1);
            var isResolved = n.is_resolved || n.status === 'resolved';
            var isSystemAlert = n.user_name === 'System (Auto Alert)';
            var dqty = n.damage_quantity || 1;
            var safeName = (n.product_name || '').replace(/'/g, "\\'");

            var actionBtn = '';
            if (isDamage) {
                if (isResolved) {
                    actionBtn = '<span class="resolved-badge"><i class="fas fa-check-circle"></i> Resolved</span>';
                } else {
                    actionBtn = '<button class="btn-edit-damage" onclick="editProductAndReduceStock(' +
                        n.product_id + ',\'' + safeName + '\',' + dqty + ',' + n.id +
                        ')"><i class="fas fa-edit"></i> Edit &amp; Reduce (' + dqty + ' units)</button>';
                }
            } else {
                actionBtn = '<button class="btn-order" onclick="createPurchaseOrder(' +
                    n.product_id + ',\'' + safeName + '\',' + n.id +
                    ')"><i class="fas fa-shopping-cart"></i> ' + (isSystemAlert ? 'Restock Now' : 'Create PO') + '</button>';
            }

            var stockLabel = (n.current_stock === 0)
                ? '<span style="color:#dc3545;font-weight:bold;">OUT OF STOCK</span>'
                : n.current_stock + ' units';

            var shortMsg = (n.message || '').substring(0, 100);
            if ((n.message || '').length > 100) shortMsg += '...';

            html += '<div class="notification-item unread" data-nid="' + n.id + '">' +
                '<div class="notification-title">' +
                '<strong>' + escapeHtml(n.product_name) + '</strong>' +
                '<span class="notification-time">' + (n.time_ago || '') + '</span>' +
                '</div>' +
                '<div class="notification-message">' +
                '<strong>Reported by: </strong>' + escapeHtml(n.user_name) + '<br>' +
                '<strong>Current Stock: </strong>' + stockLabel + ' (Min: ' + n.min_stock_level + ')<br>' +
                '<small>' + escapeHtml(shortMsg) + '</small>' +
                '</div>' +
                '<div class="notification-buttons">' +
                actionBtn +
                '<button class="btn-read" onclick="markAsRead(' + n.id + ')">' +
                '<i class="fas fa-check"></i> Mark Read</button>' +
                '</div>' +
                '</div>';
        }
        list.innerHTML = html;
    }

    // ========== GLOBAL FUNCTIONS ==========
    markAsRead = function(reportId) {
        getCSRF();

        fetch('/admin/stock-report/mark-read', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': CSRF,
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({ report_id: reportId })
        })
        .then(function(response) {
            if (!response.ok) throw new Error('HTTP ' + response.status);
            return response.json();
        })
        .then(function(data) {
            if (data.success) {
                var item = document.querySelector('.notification-item[data-nid="' + reportId + '"]');
                if (item) {
                    item.style.opacity = '0';
                    item.style.transition = 'opacity 0.3s ease';
                    setTimeout(function() {
                        if (item.parentElement) item.remove();
                        checkEmptyList();
                    }, 300);
                }

                lastUnreadCount = -1;
                fetchNotifications();
            } else {
                alert('Failed: ' + (data.message || 'Unknown error'));
            }
        })
        .catch(function(error) {
            console.error('Mark as read error:', error);
            alert('Network error. Please try again.');
        });
    };

    createPurchaseOrder = function(productId, productName, reportId) {
        if (confirm('Create purchase order for "' + productName + '"?')) {
            sessionStorage.setItem('prefill_product_id', productId);
            sessionStorage.setItem('prefill_product_name', productName);
            sessionStorage.setItem('prefill_report_id', reportId);
            sessionStorage.setItem('prefill_from_stock_report', 'true');
            window.location.href = '/admin/purchases?open_modal=1&product_id=' + productId +
                '&product_name=' + encodeURIComponent(productName) + '&report_id=' + reportId;
        }
    };

    editProductAndReduceStock = function(productId, productName, damageQuantity, reportId) {
        if (confirm('Product: ' + productName + '\nDamaged Quantity: ' + damageQuantity + ' units\n\nClick OK to edit product and reduce stock by ' + damageQuantity + ' units.')) {
            window.location.href = '/admin/products?edit_damage=1&product_id=' + productId +
                '&damage_qty=' + damageQuantity + '&report_id=' + reportId;
        }
    };

    function checkEmptyList() {
        var list = document.getElementById('notificationList');
        if (list && list.querySelectorAll('.notification-item').length === 0) {
            list.innerHTML = '<div class="no-notifications">' +
                '<i class="fas fa-check-circle" style="font-size:32px;margin-bottom:10px;display:block;"></i>' +
                '<p>No pending stock reports</p></div>';
        }
    }

    // ========== INIT ==========
    function initNotifications() {
        var bell = document.getElementById('notificationBell');
        var dropdown = document.getElementById('notificationDropdown');

        if (bell && dropdown) {
            bell.addEventListener('click', function(e) {
                e.stopPropagation();
                dropdown.classList.toggle('show');
                if (dropdown.classList.contains('show')) {
                    lastUnreadCount = -1;
                    fetchNotifications();
                }
            });
        }

        document.addEventListener('click', function(e) {
            if (dropdown && bell && !dropdown.contains(e.target) && !bell.contains(e.target)) {
                dropdown.classList.remove('show');
            }
        });

        if (pollTimer) clearInterval(pollTimer);
        fetchNotifications();
        pollTimer = setInterval(fetchNotifications, 10000);
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initNotifications);
    } else {
        initNotifications();
    }
})();

// ==================== HELPER FUNCTIONS ====================
function escapeHtml(text) {
    if (!text) return '';
    var div = document.createElement('div');
    div.textContent = String(text);
    return div.innerHTML;
}

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

function formatMoney(value) {
    return '₱' + parseFloat(value).toLocaleString('en-PH', {minimumFractionDigits: 2, maximumFractionDigits: 2});
}

function formatDate(dateString) {
    if (!dateString) return 'N/A';
    var date = new Date(dateString);
    if (isNaN(date.getTime())) return dateString;
    var months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
    var month = months[date.getMonth()];
    var day = date.getDate();
    var year = date.getFullYear();
    var hours = date.getHours();
    var minutes = date.getMinutes().toString().padStart(2, '0');
    var ampm = hours >= 12 ? 'PM' : 'AM';
    hours = hours % 12;
    hours = hours ? hours : 12;
    return month + ' ' + day + ', ' + year + ' ' + hours + ':' + minutes + ' ' + ampm;
}

// ==================== REPORTS PAGE LOGIC ====================
var salesChart, stockPieChart;
var allTransactions = [];
var resizeTimeout;

function getResponsiveChartConfig() {
    var width = window.innerWidth;
    return {
        pointRadius: width < 480 ? 3 : (width < 768 ? 4 : 5),
        borderWidth: width < 480 ? 2 : 3,
        fontSize: width < 480 ? 9 : (width < 768 ? 10 : 11),
        yTicksLimit: width < 480 ? 5 : (width < 768 ? 6 : 8),
        xRotation: width < 480 ? 45 : 0,
        hoverOffset: width < 480 ? 8 : 15
    };
}

function renderPagination(currentPage, lastPage) {
    var paginationContainer = document.getElementById('customPagination');
    if (!paginationContainer || lastPage <= 1) {
        if (paginationContainer) paginationContainer.innerHTML = '';
        return;
    }
    
    var html = '<div class="custom-pagination">';
    
    if (currentPage > 1) {
        html += '<a href="#" class="page-link" data-page="' + (currentPage - 1) + '">&lt;</a>';
    } else {
        html += '<span class="page-disabled">&lt;</span>';
    }
    
    var startPage = Math.max(1, currentPage - 2);
    var endPage = Math.min(lastPage, currentPage + 2);
    
    if (currentPage <= 3) endPage = Math.min(lastPage, 5);
    if (currentPage >= lastPage - 2) startPage = Math.max(1, lastPage - 4);
    
    if (startPage > 1) {
        html += '<a href="#" class="page-link" data-page="1">1</a>';
        if (startPage > 2) html += '<span class="page-dots">...</span>';
    }
    
    for (var i = startPage; i <= endPage; i++) {
        if (i === currentPage) {
            html += '<span class="page-active">' + i + '</span>';
        } else {
            html += '<a href="#" class="page-link" data-page="' + i + '">' + i + '</a>';
        }
    }
    
    if (endPage < lastPage) {
        if (endPage < lastPage - 1) html += '<span class="page-dots">...</span>';
        html += '<a href="#" class="page-link" data-page="' + lastPage + '">' + lastPage + '</a>';
    }
    
    if (currentPage < lastPage) {
        html += '<a href="#" class="page-link" data-page="' + (currentPage + 1) + '">&gt;</a>';
    } else {
        html += '<span class="page-disabled">&gt;</span>';
    }
    
    html += '</div>';
    paginationContainer.innerHTML = html;
    
    document.querySelectorAll('.page-link').forEach(function(link) {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            var page = this.getAttribute('data-page');
            if (page) {
                document.getElementById('currentPage').value = page;
                loadReportData();
                var tableContainer = document.querySelector('.report-table-container');
                if (tableContainer) tableContainer.scrollIntoView({ behavior: 'smooth' });
            }
        });
    });
}

function loadReportData() {
    var startDate = document.getElementById('startDate').value;
    var endDate = document.getElementById('endDate').value;
    var reportType = document.getElementById('reportType').value;
    var currentPage = document.getElementById('currentPage').value;
    var searchTerm = document.getElementById('searchInput') ? document.getElementById('searchInput').value.trim() : '';
    var statusFilter = document.getElementById('statusFilter') ? document.getElementById('statusFilter').value : 'all';
    
    // Show loading states
    document.getElementById('statRevenue').innerHTML = '<div class="loading-spinner"></div>';
    document.getElementById('statTransactionCount').innerHTML = '<div class="loading-spinner"></div>';
    document.getElementById('statAvgTransaction').innerHTML = '<div class="loading-spinner"></div>';
    document.getElementById('statTopProduct').innerHTML = '<div class="loading-spinner"></div>';
    document.getElementById('reportTableBody').innerHTML = '<tr><td colspan="8" style="text-align:center;"><div class="loading-spinner"></div> Loading data...</td></tr>';
    document.getElementById('lowStockList').innerHTML = '<div class="loading-spinner"></div> Loading...';
    
    var csrfMeta = document.querySelector('meta[name="csrf-token"]');
    var token = csrfMeta ? csrfMeta.content : '';
    
    fetch('/admin/report/generate', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token,
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            start_date: startDate,
            end_date: endDate,
            report_type: reportType,
            page: currentPage,
            search: searchTerm,
            status: statusFilter
        })
    })
    .then(function(response) {
        if (!response.ok) throw new Error('HTTP ' + response.status);
        return response.json();
    })
    .then(function(data) {
        if (data.success) {
            allTransactions = data.transactions || [];
            updateStats(data);
            updateLowStockList(data.lowStockProducts);
            updateTransactionTable(data.transactions || []);
            updateCharts(data);
            updateCategoryList(data.categories);
            if (data.pagination) {
                document.getElementById('currentPage').value = data.pagination.current_page;
                document.getElementById('lastPage').value = data.pagination.last_page;
                document.getElementById('totalRecords').value = data.pagination.total;
                document.getElementById('recordCount').textContent = data.pagination.total + ' record(s)';
                renderPagination(data.pagination.current_page, data.pagination.last_page);
            }
        } else {
            alert('Error: ' + (data.message || 'Failed to load report'));
        }
    })
    .catch(function(error) {
        console.error('Error:', error);
        document.getElementById('reportTableBody').innerHTML = '<tr><td colspan="8" style="text-align:center; color:red;">Error loading data. Please try again. The server might not be responding.</td></tr>';
    });
}

function updateStats(data) {
    document.getElementById('statRevenue').textContent = formatMoney(data.totalRevenue || 0);
    document.getElementById('statTransactionCount').textContent = (data.totalTransactions || 0).toLocaleString();
    document.getElementById('statAvgTransaction').textContent = formatMoney(data.avgTransaction || 0);
    document.getElementById('statTopProduct').textContent = data.topProduct || '—';
}

function updateLowStockList(lowStockProducts) {
    var container = document.getElementById('lowStockList');
    if (!lowStockProducts || lowStockProducts.length === 0) {
        container.innerHTML = '<div style="color: #15803d;"><i class="fas fa-check-circle"></i> All products are well stocked</div>';
        return;
    }
    var html = '';
    for (var i = 0; i < lowStockProducts.length; i++) {
        var product = lowStockProducts[i];
        html += '<div class="low-stock-item">' +
            '<div><i class="fas fa-box-open"></i> ' + escapeHtml(product.product_name || 'N/A') + '</div>' +
            '<div style="color: #f97316;"><strong>' + (product.quantity || 0) + '</strong> units left (Min: ' + (product.min_stock_level || 0) + ')</div>' +
        '</div>';
    }
    container.innerHTML = html;
}

function updateTransactionTable(transactions) {
    var tbody = document.getElementById('reportTableBody');
    tbody.innerHTML = '';
    
    if (!transactions || transactions.length === 0) {
        tbody.innerHTML = '<tr><td colspan="8" style="text-align:center; padding:40px;"><i class="fa-solid fa-receipt" style="font-size: 48px; color: #ccc;"></i><p>No transactions found for selected filters</p></td></tr>';
        return;
    }
    
    var fragment = document.createDocumentFragment();
    
    for (var i = 0; i < transactions.length; i++) {
        var t = transactions[i];
        var typeBadge = t.type === 'Sale' ? 'badge-sale' : 'badge-purchase';
        var statusBadge = t.status === 'completed' ? 'badge-completed' : (t.status === 'pending' ? 'badge-pending' : 'badge-canceled');
        var statusText = t.status ? t.status.charAt(0).toUpperCase() + t.status.slice(1) : 'Completed';
        var formattedDate = formatDate(t.date);
        var referenceId = t.reference_id || '';
        
        var tr = document.createElement('tr');
        tr.innerHTML = '<td><strong>' + formattedDate + '</strong></td>' +
            '<td><span class="badge ' + typeBadge + '">' + (t.type || 'N/A') + '</span></td>' +
            '<td><strong>' + escapeHtml(t.product || '—') + '</strong></td>' +
            '<td><strong>' + escapeHtml(t.category || '—') + '</strong></td>' +
            '<td><strong>' + (t.quantity || 0) + '</strong></td>' +
            '<td><strong>' + formatMoney(t.amount || 0) + '</strong></td>' +
            '<td><span class="badge ' + statusBadge + '">' + statusText + '</span></td>' +
            '<td><button class="view-details-btn" onclick="viewTransactionDetails(\'' + t.type + '\', \'' + referenceId + '\')"><i class="fas fa-eye"></i> View</button></td>';
        
        fragment.appendChild(tr);
    }
    
    tbody.appendChild(fragment);
}

function viewTransactionDetails(type, referenceId) {
    if (!referenceId || referenceId === 'null' || referenceId === 'undefined' || referenceId === '') {
        alert('No reference ID available for this transaction.');
        return;
    }
    if (type === 'Sale') {
        viewSaleDetails(referenceId);
    } else if (type === 'Purchase') {
        viewPurchaseDetails(referenceId);
    } else {
        alert('Unknown transaction type: ' + type);
    }
}

function viewSaleDetails(id) {
    var modal = document.getElementById('saleDetailsModal');
    modal.classList.add('show');
    
    document.getElementById('sale_detail_id').textContent = id;
    document.getElementById('sale_cashier').innerHTML = '<div class="loading-spinner"></div> Loading...';
    document.getElementById('sale_date_display').innerHTML = '<div class="loading-spinner"></div> Loading...';
    document.getElementById('sale_status_display').innerHTML = '<div class="loading-spinner"></div> Loading...';
    document.getElementById('sale_total').textContent = '₱0.00';
    document.getElementById('sale_items_table').innerHTML = '<tr class="spinner-row"><td colspan="5"><div class="loading-spinner"></div> Loading sale details...</td></tr>';
    
    var csrfMeta = document.querySelector('meta[name="csrf-token"]');
    var token = csrfMeta ? csrfMeta.content : '';
    
    fetch('/admin/sale/details/' + id, {
        headers: { 'X-CSRF-TOKEN': token, 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
    })
    .then(function(response) {
        if (!response.ok) throw new Error('HTTP ' + response.status);
        return response.json();
    })
    .then(function(sale) {
        if (sale.error) throw new Error(sale.error);
        
        document.getElementById('sale_cashier').textContent = sale.user?.fullname || 'N/A';
        document.getElementById('sale_date_display').textContent = sale.sale_date || 'N/A';
        var statusLabel = sale.status ? sale.status.charAt(0).toUpperCase() + sale.status.slice(1) : 'Unknown';
        document.getElementById('sale_status_display').textContent = statusLabel;
        document.getElementById('sale_total').textContent = '₱' + parseFloat(sale.total_amount).toLocaleString(undefined, {minimumFractionDigits: 2});
        
        var details = sale.sale_details || [];
        var totalUnits = details.reduce(function(sum, d) { return sum + d.quantity; }, 0);
        document.getElementById('sale_items_count').textContent = '(' + details.length + ' product type' + (details.length !== 1 ? 's' : '') + ', ' + totalUnits + ' unit' + (totalUnits !== 1 ? 's' : '') + ')';
        
        if (details.length === 0) {
            document.getElementById('sale_items_table').innerHTML = '<tr><td colspan="5" style="text-align:center;color:rgba(255,255,255,0.6);">No items found</td></tr>';
            return;
        }
        
        var html = '';
        details.forEach(function(item, idx) {
            html += '<tr>' +
                '<td>' + (idx + 1) + '</td>' +
                '<td>' + escapeHtml(item.product?.product_name || 'N/A') + '</td>' +
                '<td style="text-align:center">' + item.quantity + '</td>' +
                '<td style="text-align:right">₱' + parseFloat(item.price).toLocaleString(undefined,{minimumFractionDigits:2}) + '</td>' +
                '<td style="text-align:right">₱' + parseFloat(item.subtotal).toLocaleString(undefined,{minimumFractionDigits:2}) + '</td>' +
            '</tr>';
        });
        document.getElementById('sale_items_table').innerHTML = html;
    })
    .catch(function(err) {
        console.error('Sale details error:', err);
        document.getElementById('sale_items_table').innerHTML = '<tr><td colspan="5" style="text-align:center;color:#ff6b6b;"><i class="fas fa-exclamation-circle"></i> Error: ' + err.message + '</td></tr>';
    });
}

function viewPurchaseDetails(id) {
    var modal = document.getElementById('purchaseDetailsModal');
    modal.classList.add('show');
    
    document.getElementById('purchase_id').textContent = id;
    document.getElementById('purchase_supplier').innerHTML = '<div class="loading-spinner"></div> Loading...';
    document.getElementById('purchase_date').innerHTML = '<div class="loading-spinner"></div> Loading...';
    document.getElementById('purchase_batch').innerHTML = '<div class="loading-spinner"></div> Loading...';
    document.getElementById('purchase_status').innerHTML = '<div class="loading-spinner"></div> Loading...';
    document.getElementById('purchase_total').textContent = '₱0.00';
    document.getElementById('purchase_items_table').innerHTML = '<tr class="spinner-row"><td colspan="5"><div class="loading-spinner"></div> Loading purchase details...</td></tr>';
    
    var csrfMeta = document.querySelector('meta[name="csrf-token"]');
    var token = csrfMeta ? csrfMeta.content : '';
    
    fetch('/admin/purchase/details/' + id, {
        headers: { 'X-CSRF-TOKEN': token, 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
    })
    .then(function(response) {
        if (!response.ok) throw new Error('HTTP ' + response.status);
        return response.json();
    })
    .then(function(data) {
        if (data.error) throw new Error(data.error);
        
        document.getElementById('purchase_supplier').textContent = data.supplier_name || 'N/A';
        document.getElementById('purchase_date').textContent = data.order_date || 'N/A';
        document.getElementById('purchase_batch').textContent = data.batch_number || 'N/A';
        var statusLabel = data.status ? data.status.charAt(0).toUpperCase() + data.status.slice(1) : 'Unknown';
        document.getElementById('purchase_status').textContent = statusLabel;
        
        var items = data.items || [];
        var total = 0;
        if (items.length === 0) {
            document.getElementById('purchase_items_table').innerHTML = '<tr><td colspan="5" style="text-align:center;color:rgba(255,255,255,0.6);">No items found</td></tr>';
        } else {
            var html = '';
            items.forEach(function(item, idx) {
                var itemTotal = (item.quantity || 0) * (item.cost_price || 0);
                total += itemTotal;
                html += '<tr>' +
                    '<td>' + (idx + 1) + '</td>' +
                    '<td>' + escapeHtml(item.product_name || 'N/A') + '</td>' +
                    '<td style="text-align:center">' + (item.quantity || 0) + '</td>' +
                    '<td style="text-align:right">₱' + parseFloat(item.cost_price || 0).toLocaleString(undefined,{minimumFractionDigits:2}) + '</td>' +
                    '<td style="text-align:right">₱' + itemTotal.toLocaleString(undefined,{minimumFractionDigits:2}) + '</td>' +
                '</tr>';
            });
            document.getElementById('purchase_items_table').innerHTML = html;
        }
        document.getElementById('purchase_total').textContent = '₱' + total.toLocaleString(undefined, {minimumFractionDigits: 2});
    })
    .catch(function(err) {
        console.error('Purchase details error:', err);
        document.getElementById('purchase_items_table').innerHTML = '<tr><td colspan="5" style="text-align:center;color:#ff6b6b;"><i class="fas fa-exclamation-circle"></i> Error loading purchase details</td></tr>';
    });
}

// Modal close handlers
var saleModal = document.getElementById('saleDetailsModal');
var closeSaleModal = document.getElementById('close_sale_modal');
var purchaseModal = document.getElementById('purchaseDetailsModal');
var closePurchaseModal = document.getElementById('close_purchase_modal');

if (closeSaleModal) closeSaleModal.onclick = function() { saleModal.classList.remove('show'); };
if (saleModal) saleModal.onclick = function(e) { if (e.target === saleModal) saleModal.classList.remove('show'); };
if (closePurchaseModal) closePurchaseModal.onclick = function() { purchaseModal.classList.remove('show'); };
if (purchaseModal) purchaseModal.onclick = function(e) { if (e.target === purchaseModal) purchaseModal.classList.remove('show'); };

// Charts
function updateCharts(data) {
    var config = getResponsiveChartConfig();
    
    var ctx1 = document.getElementById('salesChart').getContext('2d');
    if (salesChart) salesChart.destroy();
    salesChart = new Chart(ctx1, {
        type: 'line',
        data: {
            labels: data.monthlyLabels || ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            datasets: [{
                label: '', data: data.monthlySales || [],
                borderColor: '#2c6e62', backgroundColor: 'rgba(44,110,98,0.1)',
                borderWidth: config.borderWidth, fill: true, tension: 0.3,
                pointRadius: config.pointRadius, pointBackgroundColor: '#2c6e62',
                pointBorderColor: '#fff', pointBorderWidth: 2
            }]
        },
        options: {
            responsive: true, maintainAspectRatio: true,
            plugins: { 
                tooltip: { callbacks: { label: function(ctx) { return formatMoney(ctx.raw); } } }, 
                legend: { display: false } 
            },
            scales: { 
                y: { ticks: { callback: function(val) { return formatMoney(val); }, maxTicksLimit: config.yTicksLimit } }, 
                x: { ticks: { maxRotation: config.xRotation, autoSkip: true } } 
            }
        }
    });
    
    var ctx2 = document.getElementById('stockPieChart').getContext('2d');
    if (stockPieChart) stockPieChart.destroy();
    var pieColors = ['#2c6e62', '#3a8f7e', '#48b09a', '#5cc4ac', '#70d8be', '#1a5c52', '#4a7c72', '#6b9c92', '#8bbcb2', '#a3d4ca'];
    stockPieChart = new Chart(ctx2, {
        type: 'pie',
        data: { 
            labels: data.categoryLabels || [], 
            datasets: [{ 
                data: data.categoryValues || [], 
                backgroundColor: pieColors.slice(0, (data.categoryLabels || []).length), 
                borderWidth: 0, 
                hoverOffset: config.hoverOffset 
            }] 
        },
        options: { 
            responsive: true, maintainAspectRatio: true, 
            plugins: { 
                legend: { display: false }, 
                tooltip: { 
                    callbacks: { 
                        label: function(context) { 
                            var label = context.label || ''; 
                            var value = context.raw || 0; 
                            var total = context.dataset.data.reduce(function(a, b) { return a + b; }, 0); 
                            var percentage = total > 0 ? ((value / total) * 100).toFixed(1) : 0; 
                            return label + ': ' + value + ' (' + percentage + '%)'; 
                        } 
                    } 
                } 
            } 
        }
    });
}

function updateCategoryList(categories) {
    var container = document.getElementById('categoriesList');
    var pieSection = document.querySelector('.pie-chart-section');
    
    if (!categories || categories.length === 0) { 
        if (pieSection) pieSection.style.display = 'none';
        container.style.cssText = 'display:flex; align-items:center; justify-content:center; width:100%; min-height:200px; color:#999; font-size:14px; text-align:center;';
        container.innerHTML = '<div><i class="fas fa-chart-pie" style="font-size:40px; margin-bottom:10px; display:block; opacity:0.3;"></i>No category data</div>'; 
        return; 
    }

    if (pieSection) pieSection.style.display = '';
    container.style.cssText = '';
    
    var totalStock = categories.reduce(function(sum, c) { return sum + c.totalItems; }, 0);
    var pieColors = ['#2c6e62', '#3a8f7e', '#48b09a', '#5cc4ac', '#70d8be', '#1a5c52', '#4a7c72', '#6b9c92', '#8bbcb2', '#a3d4ca'];
    var html = '';
    
    for (var i = 0; i < categories.length; i++) {
        var cat = categories[i];
        var percent = totalStock === 0 ? 0 : ((cat.totalItems / totalStock) * 100).toFixed(1);
        html += '<div class="category-item">' +
            '<div class="category-name">' +
            '<div class="category-color" style="background:' + pieColors[i % pieColors.length] + '"></div>' +
            '<span>' + escapeHtml(cat.name || 'N/A') + '</span>' +
            '</div>' +
            '<div class="category-stats">' + cat.totalItems + ' (' + percent + '%)</div>' +
        '</div>';
    }
    container.innerHTML = html;
}

// Handle resize
function handleResize() {
    clearTimeout(resizeTimeout);
    resizeTimeout = setTimeout(function() {
        if (salesChart && stockPieChart) {
            var data = { 
                monthlyLabels: salesChart.data.labels, 
                monthlySales: salesChart.data.datasets[0].data, 
                categoryLabels: stockPieChart.data.labels, 
                categoryValues: stockPieChart.data.datasets[0].data 
            };
            updateCharts(data);
        }
    }, 250);
}

window.addEventListener('resize', handleResize);

// Event listeners
var generateBtn = document.getElementById('generateReportBtn');
if (generateBtn) {
    generateBtn.addEventListener('click', function() { 
        document.getElementById('currentPage').value = 1; 
        loadReportData(); 
    });
}

var searchInputReport = document.getElementById('searchInput');
if (searchInputReport) {
    searchInputReport.addEventListener('keyup', function() { 
        document.getElementById('currentPage').value = 1; 
        loadReportData(); 
    });
}

var statusFilterReport = document.getElementById('statusFilter');
if (statusFilterReport) {
    statusFilterReport.addEventListener('change', function() { 
        document.getElementById('currentPage').value = 1; 
        loadReportData(); 
    });
}

// Initial load
loadReportData();
</script>
</body>
</html>