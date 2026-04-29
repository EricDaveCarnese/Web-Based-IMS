<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard | Inventory MS</title>
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
        }
        .logout-container:hover {
            transform: translateY(3px);
            box-shadow: 0 -4px 5px rgba(0, 0, 0, 0.1);
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
            flex-wrap: wrap;
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
        
        /* Stats Cards */
        .stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 25px;
            margin: 20px 50px;
        }
        .stats-container {
            background-color: white;
            border-radius: 20px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            transition: transform 0.3s ease;
            padding: 22px 15px;
            text-align: center;
        }
        .stats-container:hover {
            transform: translateY(-5px);
        }
        .stats-container h3 {
            font-size: 13px;
            font-weight: 600;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 12px;
        }
        .stat-number {
            font-size: 28px;
            font-weight: 700;
            color: rgb(44, 110, 98);
            margin-bottom: 8px;
        }
        .stat-sub {
            font-size: 11px;
            color: #9ca3af;
        }
        
        /* Stock Distribution Card */
        .stock-card {
            background: white;
            border-radius: 20px;
            padding: 1.5rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            width: 100%;
            max-width: 600px;
        }
        .stock-header {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
            padding-bottom: 12px;
            border-bottom: 2px solid rgba(44, 110, 98, 0.2);
        }
        .stock-header i {
            font-size: 24px;
            color: rgb(65, 148, 127);
        }
        .stock-header h3 {
            font-size: 1.2rem;
            font-weight: 600;
            color: #1a3b34;
        }
        .stock-content {
            display: flex;
            flex-direction: row;
            gap: 30px;
            align-items: center;
            flex-wrap: wrap;
            justify-content: center;
        }
        .pie-chart-section {
            flex-shrink: 0;
            width: 200px;
            height: 200px;
        }
        .categories-list {
            flex: 1;
            max-height: 280px;
            overflow-y: auto;
            padding-right: 10px;
            min-width: 180px;
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

        .dashboard-row {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            margin: 0 50px 20px 50px;
            align-items: stretch;
        }
        .dashboard-row .stock-card {
            flex: 1.2;
            min-width: 350px;
            margin: 0;
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
            margin: 0;
        }
        .sales-performance-body {
            width: 100%;
            height: 320px;
            position: relative;
        }
        .sales-record {
            flex: 2;
            background: white;
            border-radius: 20px;
            padding: 1.5rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            transition: all 0.2s;
            display: flex;
            flex-direction: column;
            width: auto;
            margin: 0 50px 30px 50px;
        }
        .record-title {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.8rem;
            border-bottom: 2px solid rgba(44, 110, 98, 0.2);
            padding-bottom: 12px;
            flex-wrap: wrap;
            gap: 15px;
        }
        .record-title h3 {
            font-size: 1.3rem;
            font-weight: 600;
            color: #1e3a38;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .record-title i {
            color: rgb(44, 110, 98);
            font-size: 1.4rem;
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
            outline: none;
        }
        .search-filter-bar input:focus {
            border-color: rgb(44, 110, 98);
            box-shadow: 0 0 0 2px rgba(44, 110, 98, 0.1);
        }
        .search-filter-bar select {
            padding: 8px 16px;
            border-radius: 30px;
            border: 1px solid #cfdfed;
            font-size: 0.85rem;
            outline: none;
            cursor: pointer;
        }
        .record-count {
            font-size: 0.8rem;
            font-weight: 600;
            color: #2c6e62;
        }
        
        /* View Button */
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

        /* Scrollable Table Container */
        .table-container {
            max-height: 500px;
            overflow-y: auto;
            overflow-x: auto;
            border-radius: 12px;
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
        .table-container {
            scrollbar-width: thin;
            scrollbar-color: #2c6e62 #f1f1f1;
        }
        .record-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.9rem;
            min-width: 1000px;
        }
        .record-table th,
        .record-table td {
            padding: 14px 12px;
            text-align: left;
            border-bottom: 1px solid #e2e8f0;
        }
        .record-table th {
            background: linear-gradient(180deg, rgb(15, 43, 61) 0%, rgb(25, 110, 114) 100%);
            color: white;
            font-weight: 600;
            position: sticky;
            top: 0;
            z-index: 10;
        }
        .record-table tr:hover {
            background: linear-gradient(180deg, rgb(49, 83, 104) 0%, rgba(47, 229, 239, 0.426) 100%);
            color: white;
        }
        .badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 30px;
            font-size: 0.75rem;
            font-weight: 600;
        }
        .badge-sale {
            background: #dcfce7;
            color: #15803d;
        }
        .badge-purchase {
            background: #fff3e3;
            color: #b45309;
        }
        
        /* Alert Messages */
        .alert-success {
            position: relative;
            background-color: #d4edda;
            color: #155724;
            padding: 12px 40px 12px 20px;
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
            font-weight: bold;
            cursor: pointer;
            color: inherit;
            opacity: 0.7;
            transition: opacity 0.3s;
        }
        .close-btn:hover {
            opacity: 1;
        }
        
        .badge-success {
            background-color: #28a745;
            color: white;
            padding: 4px 12px;
            border-radius: 30px;
            font-size: 0.75rem;
            font-weight: 600;
        }
        .badge-warning {
            background-color: #ffc107;
            color: #212529;
            padding: 4px 12px;
            border-radius: 30px;
            font-size: 0.75rem;
            font-weight: 600;
        }
        
        .hidden-data {
            display: none;
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
        @media (max-width: 640px) {
            .custom-pagination { gap: 4px; }
            .custom-pagination a, .custom-pagination span { min-width: 28px; height: 28px; font-size: 12px; }
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

        /* Toast Message */
        .toast-message {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: #28a745;
            color: white;
            padding: 12px 20px;
            border-radius: 8px;
            z-index: 9999;
            animation: slideInRight 0.3s ease;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }
        @keyframes slideInRight {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }

        /* Responsive */
        @media (max-width: 1200px) {
            .stats { margin: 20px 30px; gap: 20px; }
            .dashboard-row { margin: 0 30px 20px 30px; }
            .sales-record { margin: 0 30px 30px 30px; }
        }
        @media (max-width: 1000px) {
            .sidebar { width: 90px; padding: 1rem 0.5rem; }
            .brand h2, .nav-menu button span { display: none; }
            .main-content { margin-left: 90px; }
            .brand { justify-content: center; }
            .nav-menu button { justify-content: center; padding: 10px; }
            .page-title { margin-left: 20px; }
            .page-title h1 { font-size: 1.3rem; }
        }
        @media (max-width: 860px) {
            .stats { margin: 20px 20px; grid-template-columns: repeat(2, 1fr); }
            .dashboard-row { margin: 0 20px 20px 20px; flex-direction: column; }
            .sales-performance-card { width: 100%; }
            .dashboard-row .stock-card { min-width: auto; width: 100%; }
            .sales-record { margin: 0 20px 30px 20px; padding: 1rem; }
            .sales-performance-body { height: 280px; }
            .stock-content { flex-direction: column; }
            .pie-chart-section { width: 200px; height: 200px; }
            .categories-list { max-height: 200px; width: 100%; }
            .table-container { max-height: 300px; }
            .topheader { padding: 15px; }
            .page-title { margin-left: 15px; }
            .user-menu { margin-right: 15px; }
            .record-table th, .record-table td { padding: 10px 8px; font-size: 0.8rem; }
            .search-filter-bar input { width: 100%; }
        }
        @media (max-width: 768px) {
            .sidebar { width: 70px; padding: 1rem 0.3rem; }
            .main-content { margin-left: 70px; }
            .brand-icon { width: 35px; height: 35px; font-size: 18px; }
            .nav-menu button { font-size: 14px; padding: 8px; }
            .page-title h1 { font-size: 1.2rem; }
            .stat-number { font-size: 22px; }
            .stats-container h3 { font-size: 11px; }
            .record-title h3 { font-size: 1rem; }
        }
        @media (max-width: 550px) {
            .stats { grid-template-columns: 1fr; }
        }
        @media (max-width: 480px) {
            .stats { margin: 15px 15px; grid-template-columns: 1fr; }
            .dashboard-row { margin: 0 15px 15px 15px; }
            .sales-record { margin: 0 15px 20px 15px; padding: 0.8rem; }
            .record-table th, .record-table td { font-size: 0.7rem; padding: 8px 6px; }
            .badge { padding: 2px 8px; font-size: 0.65rem; }
            .sales-performance-body { height: 220px; }
            .pie-chart-section { width: 160px; height: 160px; }
            .category-item { padding: 8px 10px; }
            .category-name { font-size: 11px; }
            .topheader { padding: 10px; }
            .user-menu { gap: 10px; }
            .logout-btn { padding: 8px 16px; font-size: 12px; }
            .record-title { flex-direction: column; align-items: flex-start; }
            .search-filter-bar { width: 100%; }
            .notification-dropdown { width: 300px; right: -50px; }
        }
    </style>
</head>
<body>
    <div class="main">
        <div class="sidebar">
            <div class="brand">
                <div class="brand-icon">
                    <i class="fa-solid fa-box"></i>
                </div>
                <div>
                    <h2 class="title">Inventory MS</h2>
                </div>
            </div>
            <div class="nav-menu">
                <form action="{{ route('admin.dashboard')}}" method="GET">
                    <div class="nav-item active">
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
                <form action="{{ route('admin.categories') }}" method="GET"><div class="nav-item"><button><i class="fa-solid fa-folder-open"></i><span>Categories</span></button></div></form>
                <form action="{{ route('admin.suppliers') }}" method="GET"><div class="nav-item"><button><i class="fa-solid fa-warehouse"></i><span>Suppliers</span></button></div></form>
                <form action="{{ route('admin.sales') }}" method="GET"><div class="nav-item"><button><i class="fas fa-chart-line"></i><span>Sales</span></button></div></form>
                <form action="{{ route('admin.purchases') }}" method="GET"><div class="nav-item"><button><i class="fas fa-shopping-cart"></i><span>Purchases</span></button></div></form>
                <form action="{{ route('admin.reports') }}" method="GET"><div class="nav-item"><button><i class="fas fa-file-alt"></i><span>Reports</span></button></div></form>
                <form action="{{ route('admin.users') }}" method="GET"><div class="nav-item"><button><i class="fa-solid fa-users"></i><span>Users</span></button></div></form>
                <form action="{{ route('admin.logs') }}" method="GET"><div class="nav-item"><button><i class="fa-solid fa-file-lines"></i><span>Log</span></button></div></form>
                <form action="{{ route('admin.stock.reports') }}" method="GET"><div class="nav-item"><button><i class="fa-solid fa-triangle-exclamation"></i><span>Stock Reports</span></button></div></form>
            </div>
        </div>
    </div>
    <div class="main-content">
        <div class="topheader">
            <div class="page-title">
                <h1 class="dashboard">Dashboard</h1>
                <p class="dashboard-sub">Real-time inventory overview</p>
            </div>
            <div class="user-menu">
                @php $pendingStockReportsCount = \App\Models\StockReport::where('status', 'pending')->where('notify_users', false)->count(); @endphp
                <div class="notification-area">
                    <button class="notification-bell" id="notificationBell">
                        <i class="fas fa-bell"></i>
                        @if($pendingStockReportsCount > 0)
                            <span class="notification-badge">{{ $pendingStockReportsCount }}</span>
                        @endif
                    </button>
                    <div class="notification-dropdown" id="notificationDropdown">
                        <div class="notification-header"><i class="fas fa-exclamation-triangle"></i> Stock Alerts</div>
                        <div class="notification-list" id="notificationList"><div class="loading-notifications">Loading...</div></div>
                        <div class="notification-footer"><a href="{{ route('admin.stock.reports') }}">View All Reports</a></div>
                    </div>
                </div>
                <div class="user-menu-container"><a href="#"><i class="fa-solid fa-user"></i><strong>{{ Auth::user()->fullname }}</strong></a></div>
                <form action="{{ route('logout')}}" method="POST">@csrf<button type="submit" class="logout-btn"><i class="fa-solid fa-right-from-bracket"></i>Logout</button></form>
            </div>
        </div>

        @if(session('success'))<div class="alert-success">{{ session('success') }}<button class="close-btn" onclick="this.parentElement.style.display='none'">&times;</button></div>@endif
        @if(session('error'))<div class="alert-error">{{ session('error') }}<button class="close-btn" onclick="this.parentElement.style.display='none'">&times;</button></div>@endif

        <div id="categoryData" class="hidden-data" data-categories='@json($categoryDistribution ?? [])'></div>
        <div id="salesChartData" class="hidden-data" data-sales='@json($salesData ?? [])'></div>

        <div class="stats">
            <div class="stats-container"><h3>Total Products</h3><div class="stat-number">{{ $totalProducts ?? 0 }}</div><div class="stat-sub">{{ $lowStockProductsCount ?? 0 }} low stock items</div></div>
            <div class="stats-container"><h3>Sales Today</h3><div class="stat-number">₱{{ number_format($todaySalesAmount ?? 0, 2) }}</div><div class="stat-sub">today's transactions</div></div>
            <div class="stats-container"><h3>Total Sales</h3><div class="stat-number">₱{{ number_format($totalSales ?? 0, 2) }}</div><div class="stat-sub">all sales (completed + pending)</div></div>
            <div class="stats-container"><h3>Completed Sales</h3><div class="stat-number">₱{{ number_format($completedSales ?? 0, 2) }}</div><div class="stat-sub">paid & completed</div></div>
            <div class="stats-container"><h3>Pending Sales</h3><div class="stat-number">₱{{ number_format($pendingSales ?? 0, 2) }}</div><div class="stat-sub">awaiting payment</div></div>
            <div class="stats-container"><h3>Active Users</h3><div class="stat-number">{{ \App\Models\UserManagement::count() }}</div><div class="stat-sub">system users</div></div>
        </div>

        <div class="dashboard-row">
            <div class="sales-performance-card">
                <div class="sales-performance-header"><i class="fas fa-chart-line"></i><h3>Sales Performance & Forecasting</h3></div>
                <div class="sales-performance-body"><canvas id="salesPerformanceChart"></canvas></div>
            </div>
            <div class="stock-card">
                <div class="stock-header"><i class="fas fa-chart-pie"></i><h3>Stock by Category</h3></div>
                <div class="stock-content">
                    <div class="pie-chart-section"><canvas id="stockChart"></canvas></div>
                    <div class="categories-list" id="categoriesList"></div>
                </div>
            </div>
        </div>

        <div class="sales-record">
            <div class="record-title">
                <h3><i class="fa-solid fa-receipt"></i> Recent Transactions</h3>
                <div class="search-filter-bar">
                    <input type="text" id="searchInput" placeholder="Search product or category...">
                    <select id="statusFilter">
                        <option value="all">All Status</option>
                        <option value="pending">Pending</option>
                        <option value="completed">Completed</option>
                        <option value="canceled">Canceled</option>
                    </select>
                    <span class="record-count">Total Records: {{ $recentTransactions->total() ?? 0 }}</span>
                </div>
            </div>
            <div class="table-container">
                <table class="record-table">
                    <thead>
                        <tr><th>Date & Time</th><th>Type</th><th>Product</th><th>Category</th><th>Qty</th><th>Amount</th><th>Status</th><th>Actions</th></tr>
                    </thead>
                    <tbody id="transactionsTableBody">
                        @forelse($recentTransactions ?? [] as $transaction)
                        <tr>
                            <td>{{ $transaction->date ? (method_exists($transaction->date, 'format') ? $transaction->date->format('M j, Y g:i A') : $transaction->date) : 'N/A' }}</span>
                            <td><span class="badge {{ $transaction->type == 'Sale' ? 'badge-sale' : 'badge-purchase' }}">{{ $transaction->type }}</span></span>
                            <td>{{ $transaction->product }}</span>
                            <td>{{ $transaction->category }}</span>
                            <td>{{ $transaction->quantity }}</span>
                            <td>₱{{ number_format($transaction->amount, 2) }}</span>
                            <td>@if($transaction->status == 'pending')<span class="badge-warning">Pending</span>@elseif($transaction->status == 'completed')<span class="badge-success">Completed</span>@else<span class="badge" style="background:#f8d7da; color:#721c24;">Canceled</span>@endif</span>
                            <td><button class="view-details-btn" onclick="viewTransactionDetails('{{ $transaction->type }}', '{{ $transaction->reference_id ?? ',' }}')"><i class="fas fa-eye"></i> View</button></span>
                        </tr>
                        @empty
                        <tr><td colspan="8" style="text-align:center; padding:40px;"><i class="fas fa-receipt" style="font-size:48px; color:#ccc;"></i><p>No transactions found</p></span></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="pagination-container" id="customPagination"></div>
            <input type="hidden" id="currentPage" value="{{ $recentTransactions->currentPage() ?? 1 }}">
            <input type="hidden" id="lastPage" value="{{ $recentTransactions->lastPage() ?? 1 }}">
        </div>
    </div>

    <!-- Sale Details Modal -->
    <div class="modal-container" id="saleDetailsModal">
        <div class="modal"><div class="modal-header"><h2><i class="fa-solid fa-receipt"></i> Sale Details #<span id="sale_detail_id"></span></h2></div>
        <div class="modal-body"><div class="sale-info"><strong>Cashier:</strong> <span id="sale_cashier"></span><br><strong>Date &amp; Time:</strong> <span id="sale_date_display"></span><br><strong>Status:</strong> <span id="sale_status_display"></span></div>
        <h4 style="color:rgb(151,205,200);margin-bottom:10px;">Items Sold: <span id="sale_items_count" style="font-size:13px;font-weight:400;"></span></h4>
        <div style="overflow-x:auto;"><table class="details-table"><thead><tr><th>#</th><th>Product</th><th style="text-align:center">Qty</th><th style="text-align:right">Unit Price</th><th style="text-align:right">Subtotal</th></tr></thead>
        <tbody id="sale_items_table"><tr class="spinner-row"><td colspan="5"><i class="fas fa-spinner fa-spin"></i> Loading…</td></tr></tbody>
        <tfoot><tr><td colspan="4" style="text-align:right;color:rgb(151,205,200);">Grand Total:</td><td style="text-align:right"><strong id="sale_total">₱0.00</strong></td></tr></tfoot></table></div>
        <button id="close_sale_modal" class="cancel-button"><i class="fa-solid fa-circle-xmark"></i> Close</button></div></div>
    </div>

    <!-- Purchase Details Modal -->
    <div class="modal-container" id="purchaseDetailsModal">
        <div class="modal"><div class="modal-header"><h2><i class="fa-solid fa-truck"></i> Purchase Order #<span id="purchase_id"></span></h2></div>
        <div class="modal-body"><div class="purchase-info"><strong>Supplier:</strong> <span id="purchase_supplier"></span><br><strong>Date:</strong> <span id="purchase_date"></span><br><strong>Batch #:</strong> <span id="purchase_batch"></span><br><strong>Status:</strong> <span id="purchase_status"></span></div>
        <h4 style="color:rgb(151,205,200);margin-bottom:10px;">Items Purchased:</h4>
        <div style="overflow-x:auto;"><table class="details-table"><thead><tr><th>#</th><th>Product</th><th style="text-align:center">Qty</th><th style="text-align:right">Cost Price</th><th style="text-align:right">Total</th></tr></thead>
        <tbody id="purchase_items_table"><tr class="spinner-row"><td colspan="5"><i class="fas fa-spinner fa-spin"></i> Loading…</td></tr></tbody>
        <tfoot><tr><td colspan="4" style="text-align:right;color:rgb(151,205,200);">Grand Total:</td><td style="text-align:right"><strong id="purchase_total">₱0.00</strong></td></tr></tfoot></table></div>
        <button id="close_purchase_modal" class="cancel-button"><i class="fa-solid fa-circle-xmark"></i> Close</button></div></div>
    </div>

    <div id="suggestionData" style="display:none;" data-suggestions='@json(array_unique(array_merge(\App\Models\Product::pluck("product_name")->toArray(), \App\Models\StockReport::distinct()->pluck("user_name")->toArray())))'></div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Stock by Category Chart
            var categoryData = [];
            try { var categoryEl = document.getElementById('categoryData'); if(categoryEl) categoryData = JSON.parse(categoryEl.getAttribute('data-categories') || '[]'); } catch(e) { console.error('Category data error:', e); }
            var stockChartCanvas = document.getElementById('stockChart');
            if (stockChartCanvas && categoryData && categoryData.length > 0) {
                var labels = [], data = [], totalProducts = 0;
                var colors = ['#2c6e62','#3a8f7e','#48b09a','#5cc4ac','#70d8be','#1a5c52','#4a7c72','#6b9c92','#8bbcb2','#a3d4ca'];
                for (var i = 0; i < categoryData.length; i++) {
                    labels.push(categoryData[i].category_name);
                    var count = categoryData[i].products_count || 0;
                    data.push(count);
                    totalProducts += count;
                }
                new Chart(stockChartCanvas.getContext('2d'), { type: 'pie', data: { labels: labels, datasets: [{ data: data, backgroundColor: colors.slice(0, labels.length), borderWidth: 0 }] }, options: { responsive: true, maintainAspectRatio: true, plugins: { legend: { display: false }, tooltip: { callbacks: { label: function(ctx) { var p = totalProducts > 0 ? ((ctx.raw / totalProducts) * 100).toFixed(1) : 0; return ctx.label + ': ' + ctx.raw + ' (' + p + '%)'; } } } } } });
                var categoriesList = document.getElementById('categoriesList');
                if(categoriesList) {
                    categoriesList.innerHTML = '';
                    for (var i = 0; i < labels.length; i++) {
                        var percentage = totalProducts > 0 ? ((data[i] / totalProducts) * 100).toFixed(1) : 0;
                        var categoryItem = document.createElement('div');
                        categoryItem.className = 'category-item';
                        categoryItem.innerHTML = '<div class="category-name"><div class="category-color" style="background:' + colors[i % colors.length] + '"></div><span>' + labels[i] + '</span></div><div class="category-stats">' + data[i] + ' (' + percentage + '%)</div>';
                        categoriesList.appendChild(categoryItem);
                    }
                }
            }

            // Sales Performance Chart
            var salesData = [];
            try { var salesChartEl = document.getElementById('salesChartData'); if(salesChartEl) salesData = JSON.parse(salesChartEl.getAttribute('data-sales') || '[]'); } catch(e) { console.error('Sales data error:', e); }
            var salesChartCanvas = document.getElementById('salesPerformanceChart');
            if (salesChartCanvas) {
                var months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
                var salesValues = Array(12).fill(0);
                for (var i = 0; i < salesData.length; i++) { if (salesData[i] && salesData[i].month) salesValues[salesData[i].month - 1] = salesData[i].total || 0; }
                new Chart(salesChartCanvas.getContext('2d'), { type: 'line', data: { labels: months, datasets: [{ label: 'Sales Revenue', data: salesValues, borderColor: '#2c6e62', backgroundColor: 'rgba(44,110,98,0.1)', borderWidth: 3, fill: true, tension: 0.3 }] }, options: { responsive: true, maintainAspectRatio: true, plugins: { legend: { display: false }, tooltip: { callbacks: { label: function(ctx) { return '₱' + ctx.raw.toLocaleString(); } } } } } });
            }

            // Search and Filter functionality
            const searchInput = document.getElementById('searchInput');
            const statusFilter = document.getElementById('statusFilter');
            function filterAndDisplay() {
                const searchTerm = searchInput?.value.toLowerCase() || '';
                const statusValue = statusFilter?.value || 'all';
                const rows = document.querySelectorAll('#transactionsTableBody tr');
                rows.forEach(row => {
                    const product = row.cells[2]?.textContent.toLowerCase() || '';
                    const category = row.cells[3]?.textContent.toLowerCase() || '';
                    const status = row.cells[6]?.textContent.toLowerCase() || '';
                    let show = true;
                    if (statusValue !== 'all' && status !== statusValue) show = false;
                    if (searchTerm && !product.includes(searchTerm) && !category.includes(searchTerm)) show = false;
                    row.style.display = show ? '' : 'none';
                });
            }
            if (searchInput) searchInput.addEventListener('keyup', filterAndDisplay);
            if (statusFilter) statusFilter.addEventListener('change', filterAndDisplay);
        });

        // ==================== VIEW TRANSACTION DETAILS ====================
        function viewTransactionDetails(type, referenceId) {
            if (!referenceId || referenceId === '') { 
                alert('No reference ID available for this transaction'); 
                return; 
            }
            if (type === 'Sale') viewSaleDetails(referenceId);
            else if (type === 'Purchase') viewPurchaseDetails(referenceId);
            else alert('Unknown transaction type: ' + type);
        }

        function viewSaleDetails(id) {
            const modal = document.getElementById('saleDetailsModal');
            modal.classList.add('show');
            document.getElementById('sale_detail_id').textContent = id;
            document.getElementById('sale_cashier').innerHTML = '<i class="fas fa-spinner fa-spin"></i> Loading...';
            document.getElementById('sale_date_display').innerHTML = '<i class="fas fa-spinner fa-spin"></i> Loading...';
            document.getElementById('sale_status_display').innerHTML = '<i class="fas fa-spinner fa-spin"></i> Loading...';
            document.getElementById('sale_total').textContent = '₱0.00';
            document.getElementById('sale_items_table').innerHTML = '<tr class="spinner-row"><td colspan="5"><i class="fas fa-spinner fa-spin"></i> Loading sale details...<\/td><\/tr>';
            fetch('/admin/sale/details/' + id, { method: 'GET', headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content, 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }, credentials: 'same-origin' })
            .then(function(response) { if (!response.ok) throw new Error('HTTP ' + response.status); return response.json(); })
            .then(function(sale) {
                if (sale.error) throw new Error(sale.error);
                document.getElementById('sale_cashier').innerHTML = sale.user?.fullname || 'N/A';
                document.getElementById('sale_date_display').innerHTML = sale.sale_date || 'N/A';
                var statusClass = sale.status === 'completed' ? 'badge-success' : 'badge-warning';
                var statusLabel = sale.status ? sale.status.charAt(0).toUpperCase() + sale.status.slice(1) : 'Unknown';
                document.getElementById('sale_status_display').innerHTML = '<span class="' + statusClass + '">' + statusLabel + '</span>';
                document.getElementById('sale_total').innerHTML = '₱' + parseFloat(sale.total_amount).toLocaleString(undefined, { minimumFractionDigits: 2 });
                var details = sale.sale_details || [];
                var totalUnits = 0;
                for (var i = 0; i < details.length; i++) totalUnits += details[i].quantity;
                document.getElementById('sale_items_count').innerHTML = '(' + details.length + ' product type' + (details.length !== 1 ? 's' : '') + ', ' + totalUnits + ' unit' + (totalUnits !== 1 ? 's' : '') + ')';
                if (details.length === 0) { document.getElementById('sale_items_table').innerHTML = '<tr><td colspan="5" style="text-align:center;color:rgba(255,255,255,0.6);">No items found<\/td><\/tr>'; return; }
                var html = '';
                for (var i = 0; i < details.length; i++) {
                    var item = details[i];
                    html += '<tr>'
                        + '<td>' + (i + 1) + '<\/td>'
                        + '<td>' + escapeHtml(item.product?.product_name || 'N/A') + '<\/td>'
                        + '<td style="text-align:center">' + item.quantity + '<\/td>'
                        + '<td style="text-align:right">₱' + parseFloat(item.price).toLocaleString(undefined,{minimumFractionDigits:2}) + '<\/td>'
                        + '<td style="text-align:right">₱' + parseFloat(item.subtotal).toLocaleString(undefined,{minimumFractionDigits:2}) + '<\/td>'
                        + '<\/tr>';
                }
                document.getElementById('sale_items_table').innerHTML = html;
            })
            .catch(function(err) { console.error('Sale details error:', err); document.getElementById('sale_items_table').innerHTML = '<tr><td colspan="5" style="text-align:center;color:#ff6b6b;"><i class="fas fa-exclamation-circle"></i> Error loading sale details: ' + err.message + '<\/td><\/tr>'; });
        }

        function viewPurchaseDetails(id) {
    const modal = document.getElementById('purchaseDetailsModal');
    modal.classList.add('show');
    document.getElementById('purchase_id').textContent = id;
    document.getElementById('purchase_supplier').innerHTML = '<i class="fas fa-spinner fa-spin"></i> Loading...';
    document.getElementById('purchase_date').innerHTML = '<i class="fas fa-spinner fa-spin"></i> Loading...';
    document.getElementById('purchase_batch').innerHTML = '<i class="fas fa-spinner fa-spin"></i> Loading...';
    document.getElementById('purchase_status').innerHTML = '<i class="fas fa-spinner fa-spin"></i> Loading...';
    document.getElementById('purchase_total').textContent = '₱0.00';
    document.getElementById('purchase_items_table').innerHTML = '<tr class="spinner-row"><td colspan="5"><i class="fas fa-spinner fa-spin"></i> Loading purchase details...<\/td><\/tr>';
    
    fetch('/admin/purchase/details/' + id, { 
        method: 'GET', 
        headers: { 
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content, 
            'X-Requested-With': 'XMLHttpRequest', 
            'Accept': 'application/json' 
        }, 
        credentials: 'same-origin' 
    })
    .then(function(response) { 
        if (!response.ok) throw new Error('HTTP ' + response.status); 
        return response.json(); 
    })
    .then(function(data) {
        if (data.error) throw new Error(data.error);
        
        document.getElementById('purchase_supplier').innerHTML = data.supplier_name || 'N/A';
        document.getElementById('purchase_date').innerHTML = data.order_date || 'N/A';
        document.getElementById('purchase_batch').innerHTML = data.batch_number || 'N/A';
        
        var statusClass = data.status === 'completed' ? 'badge-success' : (data.status === 'pending' ? 'badge-warning' : 'badge');
        var statusLabel = data.status ? data.status.charAt(0).toUpperCase() + data.status.slice(1) : 'Unknown';
        document.getElementById('purchase_status').innerHTML = '<span class="' + statusClass + '">' + statusLabel + '</span>';
        
        // FIXED: Check if data has items array or direct product data
        var items = [];
        var total = 0;
        
        // If data has items array (for multi-item purchases)
        if (data.items && data.items.length > 0) {
            items = data.items;
            total = data.total_amount || 0;
        } 
        // If data has single product fields (for single product purchases)
        else if (data.product_name) {
            items = [{
                product_name: data.product_name,
                quantity: data.quantity || 0,
                cost_price: data.cost_price || 0,
                total: data.total || 0
            }];
            total = data.total || 0;
        }
        
        if (items.length === 0) { 
            document.getElementById('purchase_items_table').innerHTML = '<tr><td colspan="5" style="text-align:center;color:rgba(255,255,255,0.6);">No items found<\/td><\/tr>'; 
        } else {
            var itemsHtml = '';
            for (var i = 0; i < items.length; i++) {
                var item = items[i];
                itemsHtml += '<tr>' +
                    '<td>' + (i + 1) + '<\/td>' +
                    '<td>' + escapeHtml(item.product_name || 'N/A') + '<\/td>' +
                    '<td style="text-align:center">' + (item.quantity || 0) + '<\/td>' +
                    '<td style="text-align:right">₱' + parseFloat(item.cost_price || 0).toLocaleString(undefined,{minimumFractionDigits:2}) + '<\/td>' +
                    '<td style="text-align:right">₱' + parseFloat(item.total || 0).toLocaleString(undefined,{minimumFractionDigits:2}) + '<\/td>' +
                '<\/tr>';
            }
            document.getElementById('purchase_items_table').innerHTML = itemsHtml;
        }
        
        document.getElementById('purchase_total').textContent = '₱' + parseFloat(total).toLocaleString(undefined, { minimumFractionDigits: 2 });
    })
    .catch(function(err) { 
        console.error('Purchase details error:', err); 
        document.getElementById('purchase_items_table').innerHTML = '<tr><td colspan="5" style="text-align:center;color:#ff6b6b;"><i class="fas fa-exclamation-circle"></i> Error loading purchase details: ' + err.message + '<\/td><\/tr>'; 
    });
}

        function escapeHtml(text) {
            if (!text) return '';
            var div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }

         // Modal Close Handlers
        var saleModal = document.getElementById('saleDetailsModal');
        var closeSaleModal = document.getElementById('close_sale_modal');
        var purchaseModal = document.getElementById('purchaseDetailsModal');
        var closePurchaseModal = document.getElementById('close_purchase_modal');
        if (closeSaleModal) closeSaleModal.onclick = function() { saleModal.classList.remove('show'); };
        if (saleModal) saleModal.onclick = function(e) { if (e.target === saleModal) saleModal.classList.remove('show'); };
        if (closePurchaseModal) closePurchaseModal.onclick = function() { purchaseModal.classList.remove('show'); };
        if (purchaseModal) purchaseModal.onclick = function(e) { if (e.target === purchaseModal) purchaseModal.classList.remove('show'); };

        // ==================== CUSTOM PAGINATION ====================
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
            if (startPage > 1) { html += `<a href="#" class="page-link" data-page="1">1</a>`; if (startPage > 2) html += `<span class="page-dots">...</span>`; }
            for (let i = startPage; i <= endPage; i++) { if (i === currentPage) html += `<span class="page-active">${i}</span>`; else html += `<a href="#" class="page-link" data-page="${i}">${i}</a>`; }
            if (endPage < lastPage) { if (endPage < lastPage - 1) html += `<span class="page-dots">...</span>`; html += `<a href="#" class="page-link" data-page="${lastPage}">${lastPage}</a>`; }
            if (currentPage < lastPage) html += `<a href="#" class="page-link" data-page="${currentPage + 1}">&gt;</a>`;
            else html += `<span class="page-disabled">&gt;</span>`;
            html += '</div>';
            paginationContainer.innerHTML = html;
            document.querySelectorAll('.page-link').forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    const page = this.getAttribute('data-page');
                    if (page) { const url = new URL(window.location.href); url.searchParams.set('page', page); window.location.href = url.toString(); }
                });
            });
        }
        function showToastMessage(message, bgColor) {
            var toast = document.createElement('div');
            toast.className = 'toast-message';
            toast.style.background = bgColor || '#28a745';
            toast.innerHTML = '<i class="fas fa-info-circle"></i> ' + message;
            document.body.appendChild(toast);
            setTimeout(function() { if (toast.parentElement) toast.remove(); }, 3000);
        }

        // ==================== FIXED NOTIFICATION FUNCTIONS WITH CORRECT DAMAGE QUANTITY ====================
        function fetchNotifications() {
            fetch('/admin/stock-reports/notifications', { method: 'GET', headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'X-Requested-With': 'XMLHttpRequest' } })
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
            var badge = document.querySelector('.notification-badge');
            if (badge) {
                badge.style.display = count > 0 ? 'flex' : 'none';
                if (count > 0) badge.textContent = count;
            }
        }
        
        function renderNotificationDropdown(notifications) {
            var list = document.getElementById('notificationList');
            if (!list) return;
            if (!notifications || notifications.length === 0) {
                list.innerHTML = '<div class="no-notifications"><i class="fas fa-check-circle" style="font-size: 32px; margin-bottom: 10px;"></i><p>No pending stock reports</p></div>';
                return;
            }
            var html = '';
            for (var i = 0; i < notifications.length; i++) {
                var notif = notifications[i];
                var isDamage = notif.message && notif.message.includes('DAMAGE REPORT');
                var actionButton = '';
                
                if (isDamage) {
                    var damageQty = notif.damage_quantity || 1;
                    if (notif.is_resolved) {
                        actionButton = '<span class="resolved-badge"><i class="fas fa-check-circle"></i> Resolved</span>';
                    } else {
                        actionButton = '<button class="btn-edit-damage" onclick="openDamageEditModal(' + notif.product_id + ', \'' + escapeHtml(notif.product_name).replace(/'/g, "\\'") + '\', ' + damageQty + ', ' + notif.id + ')"><i class="fas fa-edit"></i> Edit & Reduce (' + damageQty + ' units)</button>';
                    }
                } else {
                    actionButton = '<button class="btn-order" onclick="createPurchaseOrder(' + notif.product_id + ', \'' + escapeHtml(notif.product_name).replace(/'/g, "\\'") + '\', ' + notif.id + ')"><i class="fas fa-shopping-cart"></i> Create PO</button>';
                }
                
                html += '<div class="notification-item unread" data-id="' + notif.id + '">' +
                    '<div class="notification-title"><strong>' + escapeHtml(notif.product_name) + '</strong><span class="notification-time">' + notif.time_ago + '</span></div>' +
                    '<div class="notification-message">Reported by: ' + escapeHtml(notif.user_name) + '<br>Current Stock: ' + notif.current_stock + ' units (Min: ' + notif.min_stock_level + ')<br><small>' + escapeHtml(notif.message.substring(0, 100)) + (notif.message.length > 100 ? '...' : '') + '</small></div>' +
                    '<div class="notification-buttons">' + actionButton + '<button class="btn-read" onclick="markAsRead(' + notif.id + ')"><i class="fas fa-check"></i> Mark Read</button></div>' +
                '</div>';
            }
            list.innerHTML = html;
        }
        
        // ==================== OPEN DAMAGE EDIT MODAL WITH CORRECT QUANTITY ====================
        function openDamageEditModal(productId, productName, damageQuantity, reportId) {
            showToastMessage('Loading product for damage report (' + damageQuantity + ' units)...', '#fd7e14');
            sessionStorage.setItem('edit_product_id', productId);
            sessionStorage.setItem('edit_product_name', productName);
            sessionStorage.setItem('damage_quantity', damageQuantity);
            sessionStorage.setItem('damage_report_id', reportId);
            sessionStorage.setItem('edit_from_damage_report', 'true');
            window.location.href = '/admin/products?edit_damage=1&product_id=' + productId + '&damage_qty=' + damageQuantity + '&report_id=' + reportId;
        }
        
        function showToastMessage(message, bgColor) {
            var toast = document.createElement('div');
            toast.className = 'toast-message';
            toast.style.background = bgColor || '#28a745';
            toast.innerHTML = '<i class="fas fa-info-circle"></i> ' + message;
            document.body.appendChild(toast);
            setTimeout(function() { if (toast.parentElement) toast.remove(); }, 3000);
        }
        
        function markAsRead(reportId) {
            if (confirm('Mark this report as read?')) {
                fetch('{{ route("admin.stock.report.read") }}', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                    body: JSON.stringify({ report_id: reportId })
                }).then(function(response) { return response.json(); }).then(function(data) {
                    if (data.success) { location.reload(); }
                    else { alert('Failed to mark as read'); }
                }).catch(function(error) { console.error('Error:', error); alert('An error occurred'); });
            }
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
        
        // Notification bell toggle
        var bell = document.getElementById('notificationBell');
        var dropdown = document.getElementById('notificationDropdown');
        if (bell) {
            bell.addEventListener('click', function(e) { e.stopPropagation(); dropdown.classList.toggle('show'); if (dropdown.classList.contains('show')) fetchNotifications(); });
        }
        document.addEventListener('click', function() { if (dropdown) dropdown.classList.remove('show'); });
        
        // Initialize
        renderPagination();
        fetchNotifications();
        setInterval(fetchNotifications, 30000);
    </script>
</body>
</html>