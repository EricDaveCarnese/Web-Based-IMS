<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Products | Inventory MS</title>
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
            gap: 25px;
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

        /* Filter Dropdown */
        .filter-container {
            position: relative;
        }
        .filter-dropdown {
            padding: 10px 16px;
            border: 1px solid #e2e8f0;
            border-radius: 25px;
            font-size: 12px;
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

        /* Product Table */
        .product-table {
            margin: 20px 50px;
            background: white;
            border-radius: 20px;
            padding: 1.5rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
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
        .table-container::-webkit-scrollbar-thumb:hover {
            background: #1a4a42;
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
        .record-table tr:hover{
            background: linear-gradient(180deg, rgb(49, 83, 104) 0%, rgba(47, 229, 239, 0.426) 100%);
            color: white;
        }

        .description-cell {
            max-width: 300px;
            min-width: 200px;
            white-space: normal;
            word-wrap: break-word;
            line-height: 1.4;
        }
        .short-desc, .full-desc {
            display: block;
            line-height: 1.4;
            word-wrap: break-word;
        }
        .full-desc {
            display: none;
        }
        .toggle-description {
            color: rgb(44, 110, 98);
            cursor: pointer;
            font-size: 12px;
            margin-top: 5px;
            display: inline-block;
            text-decoration: none;
        }
        .toggle-description:hover {
            text-decoration: underline;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            white-space: nowrap;
        }
        .status-in-stock {
            background: #d4edda;
            color: #155724;
        }
        .status-low-stock {
            background: #fff3cd;
            color: #856404;
        }
        .status-out-of-stock {
            background: #f8d7da;
            color: #721c24;
        }

        .action-buttons {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }
        
        /* Report Damage Button */
        .report-damage-btn {
            background: #fd7e14;
            border: none;
            color: white;
            padding: 6px 14px;
            border-radius: 20px;
            cursor: pointer;
            font-size: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }
        .report-damage-btn:hover {
            background: #e86c00;
            transform: scale(1.02);
        }
        .damage-reported-badge {
            background: #fd7e14;
            color: white;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 10px;
            display: inline-block;
        }
        .damage-pending-badge {
            background: #fd7e14;
            color: white;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .stock-alert {
            font-size: 12px;
            color: #666;
            white-space: nowrap;
        }
        .stock-alert i {
            margin-right: 4px;
            color: #ffc107;
        }
        .price-cell {
            font-weight: 600;
            color: #2c6e62;
            white-space: nowrap;
        }
        .stock-quantity {
            font-weight: 600;
            text-align: center;
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
            max-width: 500px;
            max-height: 90vh;
            overflow-y: auto;
            background: linear-gradient(45deg, rgb(44, 110, 98) 20%, #144243 50%);
            padding: 25px;
            border-radius: 15px;
            animation: modalSlideIn 0.3s ease;
        }
        @keyframes modalSlideIn {
            from {
                transform: translateY(-30px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }
        .modal-header {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 20px;
            color: rgb(151, 205, 200);
        }
        .modal-header h2 {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 1.4rem;
        }
        .modal-body {
            width: 100%;
        }
        .modal input, .modal textarea, .modal select {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid #e2e8f0;
            border-radius: 25px;
            font-size: 14px;
            margin-bottom: 15px;
            background: white;
        }
        .modal textarea {
            height: 80px;
            resize: vertical;
        }
        .save-button, .cancel-button {
            width: 100%;
            padding: 12px;
            border-radius: 25px;
            cursor: pointer;
            margin-top: 10px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .save-button {
            background: linear-gradient(180deg, rgb(15, 43, 61) 0%, rgb(25, 110, 114) 100%);
            border: none;
            color: white;
        }
        .save-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }
        .cancel-button {
            background: linear-gradient(180deg, rgb(188, 179, 170) 0%, rgb(214, 162, 79) 100%);
            border: none;
        }
        .cancel-button:hover {
            transform: translateY(-2px);
        }

        .input-group {
            margin-bottom: 15px;
        }
        .input-label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: #fff;
            margin-bottom: 5px;
        }
        .input-hint {
            font-size: 11px;
            color: rgba(255,255,255,0.7);
            margin-top: 5px;
            display: flex;
            align-items: center;
            gap: 5px;
            flex-wrap: wrap;
        }

        .autocomplete-dropdown {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: white;
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
        .autocomplete-item .product-price {
            font-size: 12px;
            color: #666;
            margin-top: 4px;
        }
        .no-results {
            padding: 12px 16px;
            text-align: center;
            color: #999;
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

        /* Responsive Design */
        @media (max-width: 1200px) {
            .options {
                margin: 20px 30px;
            }
            .product-table {
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
            .options {
                margin: 20px 20px;
                flex-direction: column;
                align-items: stretch;
            }
            .search-container {
                max-width: 100%;
            }
            .filter-dropdown {
                width: 100%;
            }
            .right {
                justify-content: space-between;
                width: 100%;
            }
            .product-table {
                margin: 20px 20px;
                padding: 1rem;
            }
            .table-container {
                max-height: 400px;
            }
            .alert-success, .alert-error {
                margin: 20px 20px;
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
            .record-table th,
            .record-table td {
                padding: 10px 8px;
                font-size: 0.8rem;
            }
            .status-badge {
                padding: 4px 8px;
                font-size: 10px;
            }
            .report-damage-btn {
                padding: 4px 10px;
                font-size: 11px;
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
            .modal {
                max-width: 95%;
                padding: 20px;
            }
            .modal-header h2 {
                font-size: 1.2rem;
            }
            .description-cell {
                max-width: 200px;
                min-width: 150px;
            }
        }

        @media (max-width: 480px) {
            .options {
                margin: 15px 15px;
            }
            .product-table {
                margin: 15px 15px;
                padding: 0.8rem;
            }
            .alert-success, .alert-error {
                margin: 15px 15px;
                padding: 10px 35px 10px 15px;
                font-size: 13px;
            }
            .record-table th,
            .record-table td {
                font-size: 0.7rem;
                padding: 8px 6px;
            }
            .status-badge {
                padding: 3px 6px;
                font-size: 9px;
                gap: 3px;
            }
            .report-damage-btn {
                padding: 3px 8px;
                font-size: 9px;
            }
            .modal {
                max-width: 95%;
                padding: 15px;
            }
            .modal input, .modal textarea, .modal select {
                padding: 10px 12px;
                font-size: 13px;
                margin-bottom: 12px;
            }
            .save-button, .cancel-button {
                padding: 10px;
                font-size: 13px;
            }
            .search-input {
                padding: 10px 14px;
                font-size: 13px;
            }
            .search-btn {
                width: 40px;
                height: 40px;
            }
            .filter-dropdown {
                padding: 10px 14px;
                font-size: 11px;
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
            .description-cell {
                max-width: 150px;
                min-width: 120px;
            }
            .price-cell, .stock-quantity, .stock-alert {
                white-space: normal;
            }
        }

        /* Landscape mode for mobile devices */
        @media (orientation: landscape) and (max-height: 500px) {
            .sidebar {
                height: auto;
                min-height: 100vh;
            }
            .table-container {
                max-height: 250px;
            }
            .modal {
                max-height: 90vh;
                overflow-y: auto;
            }
        }

        /* Small height devices */
        @media (max-height: 600px) {
            .table-container {
                max-height: 300px;
            }
            .product-table {
                margin: 15px 20px;
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
            <h2 class="title">Inventory MS</h2>
        </div>
        <div class="nav-menu">
            <form action="{{ route('user.dashboard')}}" method="GET">
                <div class="nav-item">
                    <button type="submit" class="button">
                        <i class="fa-solid fa-chart-column"></i>
                        <span>Dashboard</span>
                    </button>
                </div>
            </form>
            <form action="{{ route('user.products') }}" method="GET">
                <div class="nav-item active">
                    <button type="submit" class="button">
                        <i class="fas fa-cubes"></i>
                        <span>Products</span>
                    </button>
                </div>
            </form>
            <form action="{{ route('user.sales') }}" method="GET">
                <div class="nav-item">
                    <button type="submit" class="button">
                        <i class="fas fa-chart-line"></i>
                        <span>Sales</span>
                    </button>
                </div>
            </form>
            <form action="{{ route('user.purchases') }}" method="GET">
                <div class="nav-item">
                    <button type="submit" class="button">
                        <i class="fas fa-shopping-cart"></i>
                        <span>Purchases</span>
                    </button>
                </div>
            </form>
            <form action="{{ route('user.notifications') }}" method="GET">
                <div class="nav-item">
                    <button type="submit" class="button">
                        <i class="fas fa-bell"></i>
                        <span>Notifications</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="main-content">
        <div class="topheader">
            <div class="page-title">
                <h1 class="dashboard">Products</h1>
                <p class="dashboard-sub">View all product catalog and stock levels</p>
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
                    <a href="#"><i class="fa-solid fa-user"></i><strong>{{ Auth::user()->fullname }}</strong></a>
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
                <button type="button" class="close-btn" onclick="this.parentElement.style.display = 'none'">&times;</button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert-error">
                {{ session('error') }}
                <button type="button" class="close-btn" onclick="this.parentElement.style.display = 'none'">&times;</button>
            </div>
        @endif
        
        <div class="options">
            <div class="search-container">
                <div class="search-wrapper">
                    <input type="text" id="searchInput" class="search-input" placeholder="Search products..." autocomplete="off" value="{{ request('search') }}">
                    <button class="search-btn" onclick="performSearch()">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
                <div id="autocompleteDropdown" class="autocomplete-dropdown"></div>
            </div>
            <div class="filter-container">
                <select id="filterStatus" class="filter-dropdown" onchange="applyFilter()">
                    <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>All Products</option>
                    <option value="instock" {{ request('status') == 'instock' ? 'selected' : '' }}>In Stock</option>
                    <option value="lowstock" {{ request('status') == 'lowstock' ? 'selected' : '' }}>Low Stock</option>
                    <option value="outofstock" {{ request('status') == 'outofstock' ? 'selected' : '' }}>Out of Stock</option>
                </select>
            </div>
            <div class="right">
                <!-- Users cannot add products, only view -->
            </div>
        </div>

        <div class="product-table">
            <div class="table-container">
                <table class="record-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Product Name</th>
                            <th>Description</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Stock</th>
                            <th>Min Alert</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="productsTableBody">
                        @forelse($products as $product)
                        <tr>
                            <td><span>{{ $product->id }}</span></td>
                            <td><span><strong>{{ $product->product_name }}</strong></span></td>
                            <td class="description-cell">
                                <span>
                                    <span class="short-desc">
                                        {{ Str::limit($product->description, 80) }}
                                    </span>
                                    <span class="full-desc" style="display: none;">
                                        {{ $product->description }}
                                    </span>
                                    @if(strlen($product->description) > 80)
                                        <a href="javascript:void(0)" class="toggle-description">Show more</a>
                                    @endif
                                </span>
                            </td>
                            <td><span style="font-size: 13px;">{{ $product->category->category_name ?? 'N/A' }}</span></td>
                            <td><span class="price-cell">₱{{ number_format($product->price, 2) }}</span></td>
                            <td><span class="stock-quantity">{{ $product->quantity }} units</span></td>
                            <td>
                                <span class="stock-alert">
                                    <i class="fas fa-bell"></i> {{ $product->min_stock_level }} units
                                </span>
                            </td>
                            <td>
                                <span>
                                    @if($product->quantity <= $product->min_stock_level && $product->quantity > 0)
                                        <span class="status-badge status-low-stock">
                                            <i class="fas fa-exclamation-triangle"></i> Low Stock
                                        </span>
                                    @elseif($product->quantity == 0)
                                        <span class="status-badge status-out-of-stock">
                                            <i class="fas fa-times-circle"></i> Out of Stock
                                        </span>
                                    @else
                                        <span class="status-badge status-in-stock">
                                            <i class="fas fa-check-circle"></i> In Stock
                                        </span>
                                    @endif
                                </span>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    @php
                                        // Check for pending damage report (waiting for admin action)
                                        $hasPendingDamage = \App\Models\StockReport::where('product_id', $product->id)
                                            ->where('user_id', Auth::id())
                                            ->where('status', 'pending')
                                            ->where('message', 'like', '%DAMAGE%')
                                            ->exists();
                                        
                                        // Check for resolved damage report (admin already acted - can report again)
                                        $hasResolvedDamage = \App\Models\StockReport::where('product_id', $product->id)
                                            ->where('user_id', Auth::id())
                                            ->where('status', 'resolved')
                                            ->where('message', 'like', '%DAMAGE%')
                                            ->exists();
                                    @endphp
                                    
                                    @if($hasPendingDamage)
                                        <span class="damage-pending-badge">
                                            <i class="fas fa-clock"></i> Damage Pending
                                        </span>
                                    @else
                                        <button class="report-damage-btn" onclick="openDamageModal('{{ $product->id }}', '{{ $product->product_name }}', '{{ $product->category->category_name ?? N/A }}')">
                                            <i class="fas fa-exclamation-triangle"></i> 
                                            {{ $hasResolvedDamage ? 'Report Damage Again' : 'Report Damage' }}
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                            <tr>
                                <td colspan="9" style="text-align: center; padding: 40px;">
                                    <div style="display: flex; flex-direction: column; align-items: center; justify-content: center;">
                                        <i class="fas fa-box-open" style="font-size: 48px; color: #ccc;"></i>
                                        <p style="margin-top: 10px; color: #666;">No products found</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <!-- Custom Pagination -->
            <div class="pagination-container" id="customPagination"></div>
            <input type="hidden" id="currentPage" value="{{ $products->currentPage() }}">
            <input type="hidden" id="lastPage" value="{{ $products->lastPage() }}">
        </div>
    </div>

    <!-- Report Damage Modal -->
    <div class="modal-container" id="damage_modal_container">
        <div class="modal">
            <div class="modal-header">
                <h2>
                    <i class="fas fa-exclamation-triangle"></i> Report Damaged Product
                </h2>
            </div>
            <div class="modal-body">
                <form id="damageReportForm">
                    @csrf
                    <input type="hidden" name="product_id" id="damage_product_id">
                    <input type="hidden" name="product_name" id="damage_product_name">
                    <input type="hidden" name="category_name" id="damage_category_name">
                    
                    <div class="input-group">
                        <label class="input-label">Product:</label>
                        <input type="text" id="damage_product_display" readonly style="background: #f0f0f0; cursor: not-allowed;">
                    </div>
                    
                    <div class="input-group">
                        <label class="input-label">Category:</label>
                        <input type="text" id="damage_category_display" readonly style="background: #f0f0f0; cursor: not-allowed;">
                    </div>
                    
                    <div class="input-group">
                        <label class="input-label">Damage Description *</label>
                        <textarea name="damage_description" id="damage_description" placeholder="Describe the damage issue..." required></textarea>
                    </div>
                    
                    <div class="input-group">
                        <label class="input-label">Quantity Affected</label>
                        <input type="number" name="damage_quantity" id="damage_quantity" placeholder="Number of damaged units" min="1">
                    </div>
                    
                    <button type="submit" class="save-button">
                        <i class="fas fa-paper-plane"></i> Submit Damage Report
                    </button>
                </form>
                <button id="close_damage_modal" class="cancel-button">
                    <i class="fa-solid fa-circle-xmark"></i> Cancel
                </button>
            </div>
        </div>
    </div>

    <!-- Hidden JSON data element -->
    <div id="productData" style="display: none;" data-products='@json($allProducts ?? [])'></div>
    <div id="suggestionData" style="display:none;" data-suggestions='@json(array_unique(array_merge(\App\Models\Product::pluck("product_name")->toArray(), \App\Models\StockReport::distinct()->pluck("user_name")->toArray())))'></div>

    <script>
        // ==================== REPORT DAMAGE ====================
        var damageModal = document.getElementById('damage_modal_container');
        var closeDamageModal = document.getElementById('close_damage_modal');
        
        function openDamageModal(productId, productName, categoryName) {
            document.getElementById('damage_product_id').value = productId;
            document.getElementById('damage_product_name').value = productName;
            document.getElementById('damage_category_name').value = categoryName;
            document.getElementById('damage_product_display').value = productName;
            document.getElementById('damage_category_display').value = categoryName;
            document.getElementById('damage_description').value = '';
            document.getElementById('damage_quantity').value = '';
            damageModal.classList.add('show');
        }
        
        if (closeDamageModal) {
            closeDamageModal.onclick = function() {
                damageModal.classList.remove('show');
            };
        }
        if (damageModal) {
            damageModal.onclick = function(e) {
                if (e.target === damageModal) {
                    damageModal.classList.remove('show');
                }
            };
        }
        
        // Submit Damage Report
        document.getElementById('damageReportForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = {
                product_id: document.getElementById('damage_product_id').value,
                product_name: document.getElementById('damage_product_name').value,
                category_name: document.getElementById('damage_category_name').value,
                damage_description: document.getElementById('damage_description').value,
                damage_quantity: document.getElementById('damage_quantity').value,
                _token: '{{ csrf_token() }}'
            };
            
            if (!formData.damage_description) {
                alert('Please provide a damage description.');
                return;
            }
            
            const submitButton = document.querySelector('#damageReportForm .save-button');
            const originalText = submitButton.innerHTML;
            submitButton.disabled = true;
            submitButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Submitting...';
            
            fetch('{{ route("user.report.damage") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify(formData)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('✓ Damage report sent to admin successfully!');
                    damageModal.classList.remove('show');
                    location.reload();
                } else {
                    alert(data.message || 'Failed to send damage report.');
                    submitButton.disabled = false;
                    submitButton.innerHTML = originalText;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred. Please try again.');
                submitButton.disabled = false;
                submitButton.innerHTML = originalText;
            });
        });

        // ==================== SEARCH FUNCTIONALITY ====================
        var productDataElement = document.getElementById('productData');
        var allProducts = [];
        
        if (productDataElement) {
            try {
                var productsJson = productDataElement.getAttribute('data-products');
                allProducts = JSON.parse(productsJson);
            } catch(e) {
                allProducts = [];
            }
        }
        
        var searchInput = document.getElementById('searchInput');
        var searchTimeout;
        var dropdown = document.getElementById('autocompleteDropdown');
        
        function showSuggestions() {
            if (!searchInput) return;
            var query = searchInput.value.trim().toLowerCase();
            if (query.length === 0) {
                if (dropdown) dropdown.classList.remove('show');
                return;
            }
            var matches = [];
            if (allProducts && allProducts.length > 0) {
                for (var i = 0; i < allProducts.length; i++) {
                    var product = allProducts[i];
                    if (!product) continue;
                    var productName = (product.product_name || '').toLowerCase();
                    if (productName.includes(query)) {
                        matches.push(product);
                    }
                    if (matches.length >= 10) break;
                }
            }
            if (matches.length > 0 && dropdown) {
                var html = '';
                for (var i = 0; i < matches.length; i++) {
                    var p = matches[i];
                    var highlightedName = p.product_name.replace(new RegExp('(' + query + ')', 'gi'), '<strong>$1</strong>');
                    var escapedName = p.product_name.replace(/'/g, "\\'");
                    html += '<div class="autocomplete-item" onclick="selectProduct(\'' + escapedName + '\')">' +
                        '<div>' + highlightedName + '</div>' +
                        '<div class="product-price">₱' + parseFloat(p.price).toLocaleString() + '</div>' +
                    '</div>';
                }
                dropdown.innerHTML = html;
                dropdown.classList.add('show');
            } else if (dropdown) {
                dropdown.innerHTML = '<div class="no-results">No products found matching "' + query + '"</div>';
                dropdown.classList.add('show');
            }
        }
        
        function selectProduct(productName) {
            if (searchInput) {
                searchInput.value = productName;
            }
            if (dropdown) dropdown.classList.remove('show');
            performSearch();
        }
        
        function performSearch() {
            if (!searchInput) return;
            var query = searchInput.value.trim();
            var status = document.getElementById('filterStatus').value;
            var url = new URL(window.location.href);
            if (query) {
                url.searchParams.set('search', query);
            } else {
                url.searchParams.delete('search');
            }
            if (status && status !== 'all') {
                url.searchParams.set('status', status);
            } else {
                url.searchParams.delete('status');
            }
            window.location.href = url.toString();
        }
        
        function applyFilter() {
            performSearch();
        }
        
        if (searchInput) {
            searchInput.addEventListener('input', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(showSuggestions, 300);
            });
            
            document.addEventListener('click', function(e) {
                if (dropdown && searchInput && !searchInput.contains(e.target) && !dropdown.contains(e.target)) {
                    dropdown.classList.remove('show');
                }
            });
            
            searchInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    if (dropdown) dropdown.classList.remove('show');
                    performSearch();
                }
            });
        }
        
        // Toggle description show more/less
        document.addEventListener('DOMContentLoaded', function() {
            var toggleLinks = document.querySelectorAll('.toggle-description');
            for (var i = 0; i < toggleLinks.length; i++) {
                toggleLinks[i].onclick = function(e) {
                    e.preventDefault();
                    var parentCell = this.closest('.description-cell');
                    var shortDesc = parentCell.querySelector('.short-desc');
                    var fullDesc = parentCell.querySelector('.full-desc');
                    if (fullDesc.style.display === 'none' || fullDesc.style.display === '') {
                        shortDesc.style.display = 'none';
                        fullDesc.style.display = 'inline';
                        this.innerHTML = 'Show less';
                    } else {
                        shortDesc.style.display = 'inline';
                        fullDesc.style.display = 'none';
                        this.innerHTML = 'Show more';
                    }
                };
            }
        });
        
        // ==================== CUSTOM PAGINATION ====================
        function renderPagination() {
            const currentPage = parseInt(document.getElementById('currentPage').value);
            const lastPage = parseInt(document.getElementById('lastPage').value);
            const paginationContainer = document.getElementById('customPagination');
            
            if (!paginationContainer || lastPage <= 1) return;
            
            let html = '<div class="custom-pagination">';
            
            // Previous button (<)
            if (currentPage > 1) {
                html += `<a href="#" class="page-link" data-page="${currentPage - 1}">&lt;</a>`;
            } else {
                html += `<span class="page-disabled">&lt;</span>`;
            }
            
            // Page numbers
            let startPage = Math.max(1, currentPage - 2);
            let endPage = Math.min(lastPage, currentPage + 2);
            
            // Adjust if at the beginning
            if (currentPage <= 3) {
                endPage = Math.min(lastPage, 5);
            }
            
            // Adjust if at the end
            if (currentPage >= lastPage - 2) {
                startPage = Math.max(1, lastPage - 4);
            }
            
            // First page
            if (startPage > 1) {
                html += `<a href="#" class="page-link" data-page="1">1</a>`;
                if (startPage > 2) {
                    html += `<span class="page-dots">...</span>`;
                }
            }
            
            // Page numbers
            for (let i = startPage; i <= endPage; i++) {
                if (i === currentPage) {
                    html += `<span class="page-active">${i}</span>`;
                } else {
                    html += `<a href="#" class="page-link" data-page="${i}">${i}</a>`;
                }
            }
            
            // Last page
            if (endPage < lastPage) {
                if (endPage < lastPage - 1) {
                    html += `<span class="page-dots">...</span>`;
                }
                html += `<a href="#" class="page-link" data-page="${lastPage}">${lastPage}</a>`;
            }
            
            // Next button (>)
            if (currentPage < lastPage) {
                html += `<a href="#" class="page-link" data-page="${currentPage + 1}">&gt;</a>`;
            } else {
                html += `<span class="page-disabled">&gt;</span>`;
            }
            
            html += '</div>';
            paginationContainer.innerHTML = html;
            
            // Add click event listeners
            document.querySelectorAll('.page-link').forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    const page = this.getAttribute('data-page');
                    if (page) {
                        const urlParams = new URLSearchParams(window.location.search);
                        urlParams.set('page', page);
                        // Preserve existing filters
                        const searchTerm = searchInput ? searchInput.value.trim() : '';
                        const statusValue = document.getElementById('filterStatus')?.value || 'all';
                        if (searchTerm) urlParams.set('search', searchTerm);
                        if (statusValue && statusValue !== 'all') urlParams.set('status', statusValue);
                        window.location.href = window.location.pathname + '?' + urlParams.toString();
                    }
                });
            });
        }
        
        document.addEventListener('DOMContentLoaded', function() {
            renderPagination();
        });
        
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