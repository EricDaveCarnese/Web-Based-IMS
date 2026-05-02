<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Purchases | Inventory MS</title>
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'%3E%3Crect width='100' height='100' fill='%232c6e62' rx='20'/%3E%3Crect x='25' y='30' width='50' height='40' fill='white' rx='5'/%3E%3Crect x='35' y='40' width='30' height='20' fill='%232c6e62' rx='3'/%3E%3C/svg%3E">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
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
            transition: all 0.3s ease; 
        }
        .logout-btn:hover { 
            transform: translateY(-2px); 
        }
        .batch-badge { 
            background: #6c757d; 
            color: white; 
            padding: 2px 8px; 
            border-radius: 20px; 
            font-size: 10px; 
            margin-left: 8px; 
        }

        /* Options Section */
        .purchase-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
            margin: 20px 50px;
            flex-wrap: wrap;
        }

        /* Search Container */
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

        /* Autocomplete Dropdown */
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

        .new-purchase {
            background: linear-gradient(180deg, rgb(15, 43, 61) 0%, rgb(25, 110, 114) 100%);
            border: none;
            color: white;
            font-weight: 600;
            font-size: 16px;
            padding: 10px 22px;
            cursor: pointer;
            border-radius: 25px;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: all 0.3s ease;
        }
        .new-purchase:hover {
            transform: scale(1.03);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        /* Purchases Table */
        .purchase-table {
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
            min-width: 800px;
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
        .record-table tr:hover .ordered-text { 
            color: white; 
        }
        .ordered-text.status-completed {
            color: #28a745;
            font-size: 12px;
            font-weight: 600;
        }

        .ordered-text.status-canceled {
            color: #dc3545;
            font-size: 12px;
            font-weight: 600;
        }
        
        .action-button {
            background: #28a745;
            border: none;
            color: white;
            padding: 6px 14px;
            border-radius: 20px;
            cursor: pointer;
            font-size: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
            margin-right: 5px;
        }
        .action-button:hover {
            background: #218838;
            transform: scale(1.02);
        }
        .cancel-order-btn {
            background: #dc3545;
            border: none;
            color: white;
            padding: 6px 14px;
            border-radius: 20px;
            cursor: pointer;
            font-size: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .cancel-order-btn:hover {
            background: #c82333;
            transform: scale(1.02);
        }
        .badge-success {
            background: #28a745;
            color: white;
            padding: 4px 12px;
            border-radius: 20px;
            font-weight: 600;
            display: inline-block;
            font-size: 12px;
        }
        .badge-warning {
            background: #ffc107;
            color: #212529;
            padding: 4px 12px;
            border-radius: 20px;
            font-weight: 600;
            display: inline-block;
            font-size: 12px;
        }
        .badge-danger {
            background: #dc3545;
            color: white;
            padding: 4px 12px;
            border-radius: 20px;
            font-weight: 600;
            display: inline-block;
            font-size: 12px;
        }
        .view-details-btn { 
            background: #17a2b8; 
            border: none; 
            color: white; 
            padding: 6px 14px; 
            border-radius: 20px; 
            cursor: pointer; 
            font-size: 12px; 
            margin-right: 5px; 
            transition: all 0.3s ease; 
            font-weight: 600;
        }
        .view-details-btn:hover { 
            background: #138496; 
            transform: scale(1.02); 
        }

        /* Alert Messages with Close Button */
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

        /* Modal Styles */
        .modal-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
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
            max-width: 450px;
            background: linear-gradient(45deg, rgb(44, 110, 98) 20%, #144243 50%, rgba(60, 130, 110, 0.35) 100%);
            padding: 25px;
            border-radius: 15px;
            animation: modalSlideIn 0.3s ease;
            max-height: 90vh;
            overflow-y: auto;
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
            margin: 0;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 1.4rem;
        }
        .modal-body {
            width: 100%;
        }
        .details-info {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            padding: 15px;
            margin-bottom: 15px;
        }
        .details-info p {
            margin: 8px 0;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 10px;
        }
        .details-info strong {
            color: rgb(151, 205, 200);
        }
        .cancel-modal-btn {
            background: linear-gradient(180deg, rgb(188, 179, 170) 0%, rgb(214, 162, 79) 100%);
            border: none;
            width: 100%;
            font-size: 14px;
            font-weight: 600;
            padding: 12px;
            border-radius: 25px;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .cancel-modal-btn:hover {
            transform: scale(1.02);
            box-shadow: 0 4px 12px rgba(255, 255, 255, 0.259);
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

        /* Responsive Design */
        @media (max-width: 1200px) {
            .purchase-table {
                margin: 20px 30px;
            }
            .purchase-container {
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
            .purchase-container {
                margin: 20px 20px;
                flex-direction: column;
                align-items: stretch;
            }
            .search-container {
                max-width: 100%;
            }
            .purchase-table {
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
            .action-button, .cancel-order-btn, .view-details-btn {
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
                max-width: 90%;
                padding: 20px;
            }
            .modal-header h2 {
                font-size: 1.2rem;
            }
        }

        @media (max-width: 480px) {
            .purchase-container {
                margin: 15px 15px;
            }
            .purchase-table {
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
            .badge-success, .badge-warning, .badge-danger {
                font-size: 9px;
                padding: 2px 6px;
            }
            .action-button, .cancel-order-btn, .view-details-btn {
                padding: 3px 8px;
                font-size: 9px;
                margin: 0 2px;
            }
            .pagination a, .pagination span {
                padding: 5px 8px;
                font-size: 12px;
            }
            .modal {
                max-width: 95%;
                padding: 15px;
            }
            .search-input {
                padding: 10px 14px;
                font-size: 13px;
            }
            .search-btn {
                width: 40px;
                height: 40px;
            }
            .new-purchase {
                padding: 8px 16px;
                font-size: 14px;
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
            .purchase-table {
                margin: 15px 20px;
            }
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
                <form action="{{ route('user.dashboard')}}" method="GET">
                    <div class="nav-item">
                        <button type="submit" class="button">
                            <i class="fa-solid fa-chart-column"></i>
                            <span>Dashboard</span>
                        </button>
                    </div>
                </form>
                <form action="{{ route('user.products') }}" method="GET">
                    <div class="nav-item">
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
                    <div class="nav-item active">
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
    </div>
    <div class="main-content">
        <div class="topheader">
            <div class="page-title">
                <h1 class="dashboard">Purchase Orders</h1>
                <p class="dashboard-sub">Create and manage purchase orders</p>
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

        <div id="dynamicAlertContainer"></div>

        @if(session('success'))
            <div class="alert-success sessionAlert">
                {{ session('success') }}
                <button class="close-btn" onclick="this.parentElement.style.display='none'">&times;</button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert-error sessionAlert">
                {{ session('error') }}
                <button class="close-btn" onclick="this.parentElement.style.display='none'">&times;</button>
            </div>
        @endif

        <!-- Hidden data for autocomplete -->
        <div id="supplierData" style="display: none;" data-suppliers='@json($allSuppliers ?? [])'></div>
        <div id="purchaseOrdersData" style="display: none;" data-purchases='@json($allPurchases ?? [])'></div>

        <div class="purchase-view">
            <div class="purchase-container">
                <div class="search-container">
                    <div class="search-wrapper">
                        <input type="text" id="searchInput" class="search-input" placeholder="Search by Batch #, or Supplier..." autocomplete="off" value="{{ request('search') }}">
                        <button class="search-btn" onclick="performSearch()">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                    <div id="autocompleteDropdown" class="autocomplete-dropdown"></div>
                </div>
                <div class="recordcount">
                    <span class="count">Total: PO</span>
                    <strong>{{ $purchases->total() }}</strong>
                </div>
            </div>

            <!-- View Details Modal -->
            <div class="modal-container" id="view_details_modal">
                <div class="modal details-modal">
                    <div class="modal-header">
                        <h2>
                            <i class="fa-solid fa-receipt"></i> Purchase Order Details #
                            <span id="purchase_detail_id"></span>
                        </h2>
                    </div>
                    <div class="modal-body">
                        <div class="details-info">
                            <p>
                                <strong>Batch Number:</strong> 
                                <span id="detail_batch_number">-</span>
                            </p>
                            <p>
                                <strong>Supplier:</strong> 
                                <span id="detail_supplier">-</span>
                            </p>
                            <p>
                                <strong>Order Date:</strong> 
                                <span id="detail_order_date">-</span>
                            </p>
                            <p>
                                <strong>Due Date:</strong> 
                                <span id="detail_due_date">-</span>
                            </p>
                            <p>
                                <strong>Product:</strong> 
                                <span id="detail_product">-</span>
                            </p>
                            <p>
                                <strong>Quantity:</strong> 
                                <span id="detail_quantity">-</span>
                            </p>
                            <p>
                                <strong>Cost per Unit:</strong> 
                                <span id="detail_cost">-</span>
                            </p>
                            <p>
                                <strong>Total Amount:</strong> 
                                <span id="detail_total">-</span>
                            </p>
                            <p>
                                <strong>Status:</strong> 
                                <span id="detail_status">-</span>
                            </p>
                        </div>
                        <button id="close_details_modal" class="cancel-modal-btn">
                            <i class="fa-solid fa-circle-xmark"></i> Close
                        </button>
                    </div>
                </div>
            </div>

            <div class="purchase-table">
                <div class="table-container">
                    <table class="record-table">
                        <thead>
                            <tr>
                                <th>PO #</th>
                                <th>Batch #</th>
                                <th>Supplier</th>
                                <th>Order Date</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($purchases as $purchase)
                            <tr>
                                <td><span>#{{ $purchase->id }}</span></td>
                                <td>
                                    <span class="batch-badge" >
                                        {{ $purchase->batch_number ?? 'BATCH-' . str_pad($purchase->id, 4, '0', STR_PAD_LEFT) }}
                                    </span>
                                </span>
                                <td><strong>{{ $purchase->supplier->supplier_name ?? 'N/A' }}</strong></td>
                                <td>{{ $purchase->purchase_date ? $purchase->purchase_date->format('M j, Y g:i A') : 'N/A' }}</span></td>
                                <td>₱{{ number_format($purchase->purchaseDetails->sum(function($detail) { return $detail->quantity * $detail->cost_price; }), 2) }}</span></td>
                                <td>
                                    @if($purchase->status == 'completed')
                                        <span class="badge-success"><i class="fa-solid fa-check"></i> Completed</span>
                                    @elseif($purchase->status == 'pending')
                                        <span class="badge-warning"><i class="fa-solid fa-spinner"> Pending</span>
                                    @else
                                        <span class="badge-danger"><i class="fa-solid fa-ban"></i> Canceled</span>
                                    @endif
                                </span>
                                <td>
                                    <button class="view-details-btn" onclick="viewPurchaseDetails('{{ $purchase->id }}')">
                                        <i class="fas fa-eye"></i> View
                                    </button>
                                    @if($purchase->status == 'pending')
                                        <form method="POST" action="{{ route('user.purchase.complete', $purchase->id) }}" style="display: inline;">
                                            @csrf
                                            <button type="submit" class="action-button" onclick="return confirm('Complete this purchase order? This will update product stock.')">
                                                <i class="fa-solid fa-circle-check"></i> Receive
                                            </button>
                                        </form>
                                    @elseif($purchase->status == 'completed')
                                        <span class="ordered-text status-completed">
                                            <i class="fas fa-check-double"></i> Received
                                        </span>
                                    @else
                                        <span class="ordered-text status-canceled">
                                            <i class="fas fa-ban"></i> Canceled
                                        </span>
                                    @endif
                                </span>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" style="text-align: center; padding: 40px;">
                                    <i class="fas fa-shopping-cart" style="font-size: 48px; color: #ccc;"></i>
                                    <p style="margin-top: 10px;">No purchase orders found</p>
                                </span>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <!-- Custom Pagination -->
            <div class="pagination-container" id="customPagination"></div>
            <input type="hidden" id="currentPage" value="{{ $purchases->currentPage() }}">
            <input type="hidden" id="lastPage" value="{{ $purchases->lastPage() }}">
            </div>
        </div>
    </div>
    <div id="suggestionData" style="display:none;" 
        data-suggestions='@json(array_unique(array_merge(
            \App\Models\Purchase::where("user_id", Auth::id())->pluck("batch_number")->toArray(),
            \App\Models\Supplier::pluck("supplier_name")->toArray()
        )))'>
    </div>

    <script>

        function showAlertMessage(message, type) {
            var alertContainer = document.getElementById('dynamicAlertContainer');
            if (!alertContainer) return;
            
            var alertDiv = document.createElement('div');
            alertDiv.className = type === 'success' ? 'alert-success' : 'alert-error';
            alertDiv.innerHTML = message + '<button type="button" class="close-btn" onclick="this.parentElement.style.display = \'none\'">&times;</button>';
            
            alertContainer.innerHTML = '';
            alertContainer.appendChild(alertDiv);
            
            window.scrollTo({ top: 0, behavior: 'smooth' });
            
            setTimeout(function() {
                if (alertDiv && alertDiv.parentElement) {
                    alertDiv.style.opacity = '0';
                    alertDiv.style.transition = 'opacity 0.5s ease';
                    setTimeout(function() {
                        if (alertDiv && alertDiv.parentElement) alertDiv.remove();
                    }, 500);
                }
            }, 3000);
        }
        function autoCloseSessionAlerts() {
            var sessionAlert = document.querySelector('.sessionAlert');
            if (sessionAlert) {
                setTimeout(function() {
                    if (sessionAlert) {
                        sessionAlert.style.opacity = '0';
                        sessionAlert.style.transition = 'opacity 0.5s ease';
                        setTimeout(function() {
                            if (sessionAlert && sessionAlert.parentElement) {
                                sessionAlert.remove();
                            }
                        }, 500);
                    }
                }, 3000);
            }
        }
        //SUPPLIER AUTOCOMPLETE
        var supplierDataElement = document.getElementById('supplierData');
        var allSuppliers = [];
        
        if (supplierDataElement) {
            try {
                var suppliersJson = supplierDataElement.getAttribute('data-suppliers');
                allSuppliers = JSON.parse(suppliersJson);
            } catch(e) {
                allSuppliers = [];
            }
        }

        // Purchase orders for autocomplete
        var allPurchaseOrders = [];
        var purchaseOrdersDataEl = document.getElementById('purchaseOrdersData');
        if (purchaseOrdersDataEl) {
            try {
                var purchasesJson = purchaseOrdersDataEl.getAttribute('data-purchases');
                if (purchasesJson) {
                    allPurchaseOrders = JSON.parse(purchasesJson);
                }
            } catch(e) {
                console.error('Error parsing purchase orders:', e);
            }
        }
        
        var searchInput = document.getElementById('searchInput');
        var dropdown = document.getElementById('autocompleteDropdown');
        var searchTimeout;
        
        function showSuggestions() {
            if (!searchInput) return;
            
            var query = searchInput.value.trim().toLowerCase();
            
            if (query.length === 0) {
                if (dropdown) dropdown.classList.remove('show');
                return;
            }
            
            var matches = [];
            var isNumber = /^\d+$/.test(query);
            
            // Search in purchase orders (PO # and Batch #)
            if (allPurchaseOrders && allPurchaseOrders.length > 0) {
                for (var i = 0; i < allPurchaseOrders.length; i++) {
                    var po = allPurchaseOrders[i];
                    if (!po) continue;
                    var poNumber = String(po.id || '');
                    var batchNumber = (po.batch_number || '').toLowerCase();
                    var supplierName = (po.supplier_name || '').toLowerCase();
                    
                    if (batchNumber.includes(query)) {
                        matches.push({ value: po.batch_number, label: 'Batch: ' + po.batch_number });
                    } else if (supplierName.includes(query)) {
                        matches.push({ value: po.supplier_name, label: 'Supplier: ' + po.supplier_name });
                    }
                    if (matches.length >= 10) break;
                }
            }
            
            // Search in suppliers
            if (allSuppliers && allSuppliers.length > 0) {
                for (var i = 0; i < allSuppliers.length; i++) {
                    var supplier = allSuppliers[i];
                    if (!supplier) continue;
                    var supplierName = (supplier.supplier_name || '').toLowerCase();
                    
                    if (supplierName.includes(query) && !matches.some(function(m) { return m.value === supplier.supplier_name; })) {
                        matches.push({ value: supplier.supplier_name, label: 'Supplier: ' + supplier.supplier_name });
                    }
                    if (matches.length >= 10) break;
                }
            }
            
            if (matches.length > 0 && dropdown) {
                var html = '';
                for (var i = 0; i < matches.length; i++) {
                    var m = matches[i];
                    var highlightedValue = m.value.replace(new RegExp('(' + query.replace(/[.*+?^${}()|[\]\\]/g, '\\$&') + ')', 'gi'), '<strong>$1</strong>');
                    var escapedValue = m.value.replace(/'/g, "\\'");
                    html += '<div class="autocomplete-item" onclick="selectSuggestion(\'' + escapedValue + '\')">' +
                        '<div>' + highlightedValue + '</div>' +
                    '</div>';
                }
                dropdown.innerHTML = html;
                dropdown.classList.add('show');
            } else if (dropdown) {
                dropdown.innerHTML = '<div class="no-results">No results found matching "' + query + '"</div>';
                dropdown.classList.add('show');
            }
        }
        
        function selectSuggestion(value) {
            if (searchInput) {
                searchInput.value = value;
            }
            if (dropdown) dropdown.classList.remove('show');
            performSearch();
        }
        
        function performSearch() {
            if (!searchInput) return;
            var query = searchInput.value.trim();
            var url = new URL(window.location.href);
            if (query) {
                url.searchParams.set('search', query);
            } else {
                url.searchParams.delete('search');
            }
            window.location.href = url.toString();
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

        //VIEW DETAILS MODAL
        var viewDetailsModal = document.getElementById('view_details_modal');
        var closeDetailsModal = document.getElementById('close_details_modal');
        
        if (closeDetailsModal) {
            closeDetailsModal.onclick = function () {
                viewDetailsModal.classList.remove('show');
            };
        }
        if (viewDetailsModal) {
            viewDetailsModal.onclick = function (e) {
                if (e.target === viewDetailsModal)
                    viewDetailsModal.classList.remove('show');
            };
        }

        window.viewPurchaseDetails = function (id) {
            viewDetailsModal.classList.add('show');
            document.getElementById('purchase_detail_id').innerHTML = id;

            document.getElementById('detail_batch_number').innerHTML = '<i class="fas fa-spinner fa-spin"></i> Loading...';
            document.getElementById('detail_supplier').innerHTML = '<i class="fas fa-spinner fa-spin"></i> Loading...';
            document.getElementById('detail_order_date').innerHTML = '<i class="fas fa-spinner fa-spin"></i> Loading...';
            document.getElementById('detail_due_date').innerHTML = '<i class="fas fa-spinner fa-spin"></i> Loading...';
            document.getElementById('detail_product').innerHTML = '<i class="fas fa-spinner fa-spin"></i> Loading...';
            document.getElementById('detail_quantity').innerHTML = '<i class="fas fa-spinner fa-spin"></i> Loading...';
            document.getElementById('detail_cost').innerHTML = '<i class="fas fa-spinner fa-spin"></i> Loading...';
            document.getElementById('detail_total').innerHTML = '<i class="fas fa-spinner fa-spin"></i> Loading...';
            document.getElementById('detail_status').innerHTML = '<i class="fas fa-spinner fa-spin"></i> Loading...';

            fetch('/user/purchase/details/' + id, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'X-Requested-With': 'XMLHttpRequest',
                },
            })
            .then(function (response) {
                return response.json();
            })
            .then(function (data) {
                if (data.error) {
                    document.getElementById('detail_batch_number').innerHTML = 'Error loading';
                    return;
                }

                document.getElementById('detail_batch_number').innerHTML = data.batch_number || 'N/A';
                document.getElementById('detail_supplier').innerHTML = data.supplier_name || 'N/A';
                document.getElementById('detail_order_date').innerHTML = data.order_date || 'N/A';
                document.getElementById('detail_due_date').innerHTML = data.due_date || 'Not set';
                document.getElementById('detail_product').innerHTML = data.product_name || 'N/A';
                document.getElementById('detail_quantity').innerHTML = data.quantity || 0;
                document.getElementById('detail_cost').innerHTML = '₱' +
                    parseFloat(data.cost_price || 0).toLocaleString(undefined, {
                        minimumFractionDigits: 2,
                    });
                document.getElementById('detail_total').innerHTML = '₱' +
                    parseFloat(data.total || 0).toLocaleString(undefined, {
                        minimumFractionDigits: 2,
                    });

                var statusBadge = '';
                if (data.status === 'completed')
                    statusBadge = '<span class="badge-success">Completed</span>';
                else if (data.status === 'pending')
                    statusBadge = '<span class="badge-warning">Pending</span>';
                else
                    statusBadge = '<span class="badge-danger">Canceled</span>';
                document.getElementById('detail_status').innerHTML = statusBadge;
            })
            .catch(function (error) {
                console.error('Error:', error);
                document.getElementById('detail_batch_number').innerHTML = 'Error loading details';
            });
        };

        //UNIFIED USER NOTIFICATION FUNCTIONS
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
        var userBell = document.getElementById('userNotificationBell');
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
        
        // Pagination
        function renderPagination() {
            var cur  = parseInt(document.getElementById('currentPage').value);
            var last = parseInt(document.getElementById('lastPage').value);
            var cont = document.getElementById('customPagination');
            if (!cont || last <= 1) return;
            var html = '<div class="custom-pagination">';
            html += cur > 1 ? '<a data-page="' + (cur-1) + '">&lt;</a>' : '<span>&lt;</span>';
            var s = Math.max(1,cur-2), e = Math.min(last,cur+2);
            if (cur<=3) e = Math.min(last,5);
            if (cur>=last-2) s = Math.max(1,last-4);
            if (s>1) { html += '<a data-page="1">1</a>'; if (s>2) html += '<span>…</span>'; }
            for (var i=s;i<=e;i++) html += (i===cur) ? '<span class="page-active">'+i+'</span>' : '<a data-page="'+i+'">'+i+'</a>';
            if (e<last) { if(e<last-1) html+='<span>…</span>'; html+='<a data-page="'+last+'">'+last+'</a>'; }
            html += cur < last ? '<a data-page="' + (cur+1) + '">&gt;</a>' : '<span>&gt;</span>';
            html += '</div>';
            cont.innerHTML = html;
            cont.querySelectorAll('a[data-page]').forEach(function(a){
                a.onclick = function(e){
                    e.preventDefault();
                    var url = new URL(window.location.href);
                    url.searchParams.set('page', this.dataset.page);
                    window.location.href = url;
                };
            });
        }

        // Init
        document.addEventListener('DOMContentLoaded', function() {
            renderPagination();
            fetchUserNotifications();
            autoCloseSessionAlerts();
            setInterval(fetchUserNotifications, 30000);
        });
    </script>
</body>
</html>