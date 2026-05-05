<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Users Management | Inventory MS</title>
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
        .page-title {
            margin-left: 30px;
            color: rgb(44, 110, 98);
        }
        .page-title p {
            font-size: 14px;
            color: #6c757d;
            margin-top: 5px;
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

        /* Search Container with Autocomplete */
        .user-container {
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
        .autocomplete-dropdown.show { display: block; }
        .autocomplete-item {
            padding: 12px 16px;
            cursor: pointer;
            border-bottom: 1px solid #eee;
            transition: background 0.2s;
        }
        .autocomplete-item:hover { background: #f0f2f5; }
        .autocomplete-item strong { color: rgb(44, 110, 98); }
        .no-results {
            padding: 12px 16px;
            text-align: center;
            color: #999;
        }

        .new-user {
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
        .new-user:hover {
            transform: scale(1.03);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }
        .right {
            display: flex;
            align-items: center;
            gap: 15px;
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

        .user-table {
            margin: 20px 50px;
            background: white;
            border-radius: 20px;
            padding: 1.5rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        }
        .options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
            margin: 20px 50px;
            flex-wrap: wrap;
        }

        /* Scrollable Table Container */
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
        .record-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.9rem;
            min-width: 600px;
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

        .edit-button,
        .delete-button {
            padding: 6px 14px;
            border-radius: 20px;
            cursor: pointer;
            border: none;
            margin: 0 5px;
            font-size: 12px;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            transition: all 0.3s ease;
        }
        .edit-button {
            background: rgb(40, 140, 203);
            color: white;
        }
        .edit-button:hover {
            background: white;
            color: rgb(40, 140, 203);
            transform: translateY(-2px);
        }
        .delete-button {
            background: linear-gradient(180deg, rgb(188, 179, 170) 0%, rgb(214, 162, 79) 100%);
            color: white;
        }
        .delete-button:hover {
            background: white;
            color: red;
            transform: translateY(-2px);
        }
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
        .password-match-error {
            color: #dc3545;
            font-size: 12px;
            margin-top: -8px;
            margin-bottom: 10px;
            padding: 6px 12px;
            background: rgba(220, 53, 69, 0.08);
            border-radius: 8px;
            border-left: 3px solid #dc3545;
            display: none;
            align-items: center;
            gap: 6px;
        }
        .password-match-error.show {
            display: flex;
        }

        /* Password Field Styles */
        .password-field {
            position: relative;
            margin-bottom: 15px;
        }
        .password-field input {
            width: 100%;
            padding: 12px 45px 12px 16px;
            border: 1px solid #e2e8f0;
            border-radius: 25px;
            font-size: 14px;
            background: white;
            transition: all 0.3s ease;
        }
        .password-field input:focus {
            border-color: rgb(44, 110, 98);
            box-shadow: 0 0 0 3px rgba(44, 110, 98, 0.1);
            outline: none;
        }
        .toggle-password {
            position: absolute;
            right: 15px;
            top: 40%;
            transform: translateY(-60%);
            cursor: pointer;
            color: #6c757d;
            transition: color 0.3s ease;
            font-size: 16px;
            z-index: 10;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 20px;
            height: 20px;
        }
        .toggle-password:hover {
            color: #2c6e62;
        }
        .password-match-error {
            color: #ff6b6b;
            font-size: 11px;
            margin-top: -10px;
            margin-bottom: 10px;
            display: none;
        }
        .password-match-error.show {
            display: block;
        }

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
            max-width: 450px;
            background: linear-gradient(45deg, rgb(44, 110, 98) 20%, #144243 50%);
            padding: 25px;
            border-radius: 15px;
            animation: modalSlideIn 0.3s ease;
        }
        @keyframes 
            modalSlideIn {
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
            color: rgb(151, 205, 200);
            margin-bottom: 20px;
        }
        .modal-header h2 {
            font-size: 1.4rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .modal input,
        .modal select {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid #e2e8f0;
            border-radius: 25px;
            margin-bottom: 15px;
            font-size: 14px;
        }
        .role {
            margin-bottom: 20px;
            display: flex;
            justify-content: space-evenly;
            gap: 20px;
            flex-wrap: wrap;
        }
        .role label {
            display: flex;
            flex-direction: row;
            align-items: center;
            gap: 8px;
            color: white;
            cursor: pointer;
        }
        .save-button {
            background: linear-gradient(180deg, rgb(15, 43, 61) 0%, rgb(25, 110, 114) 100%);
            border: none;
            width: 100%;
            padding: 12px;
            border-radius: 25px;
            color: white;
            cursor: pointer;
            margin-bottom: 10px;
            transition: all 0.3s ease;
        }
        .save-button:hover:not(:disabled) {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }
        .save-button:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }
        .cancel-button {
            background: linear-gradient(180deg, rgb(188, 179, 170) 0%, rgb(214, 162, 79) 100%);
            border: none;
            width: 100%;
            padding: 12px;
            border-radius: 25px;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .cancel-button:hover {
            transform: translateY(-2px);
        }
        .badge-primary {
            background: #007bff;
            color: white;
            padding: 4px 12px;
            border-radius: 20px;
            display: inline-block;
            font-size: 12px;
        }
        .badge-secondary {
            background: #6c757d;
            color: white;
            padding: 4px 12px;
            border-radius: 20px;
            display: inline-block;
            font-size: 12px;
        }

        /* Responsive Design */
        @media (max-width: 1200px) {
            .user-table, .user-container, .alert-success, .alert-error { 
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
            .page-title h1 { 
                font-size: 1.3rem; 
            }
        }
        @media (max-width: 860px) {
            .user-container { 
                margin: 20px 20px; 
                flex-direction: column; 
                align-items: stretch; 
            }
            .search-container { 
                max-width: 100%; 
            }
            .user-table { 
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
            .record-table th, .record-table td { 
                padding: 10px 8px; 
                font-size: 0.8rem; 
            }
            .edit-button, .delete-button { 
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
            .modal-header h2 { 
                font-size: 1.2rem; 
            }
            .role { 
                flex-direction: column; 
                align-items: flex-start; 
                gap: 10px; 
            }
        }
        @media (max-width: 480px) {
            .user-container, .user-table, .alert-success, .alert-error { 
                margin: 15px 15px; 
                padding: 0.8rem; 
            }
            .alert-success, .alert-error { 
                padding: 10px 35px 10px 15px; 
                font-size: 13px; 
            }
            .record-table th, .record-table td { 
                font-size: 0.7rem; 
                padding: 8px 6px; 
            }
            .badge-primary, .badge-secondary { 
                font-size: 9px; 
                padding: 2px 6px; 
            }
            .edit-button, .delete-button { 
                padding: 3px 8px; 
                font-size: 9px; 
                margin: 0 2px; 
            }
            .modal { 
                max-width: 95%; 
                padding: 15px; 
            }
            .modal input, .modal select { 
                padding: 10px 12px; 
                font-size: 13px; 
            }
            .save-button, .cancel-button { 
                padding: 10px; 
                font-size: 14px; 
            }
            .search-input { 
                padding: 10px 14px; 
                font-size: 13px; 
            }
            .search-btn { 
                width: 40px;
                height: 40px; 
            }
            .new-user { 
                padding: 8px 16px; 
                font-size: 14px; 
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
        @media (max-height: 600px) {
            .table-container { 
                max-height: 300px; 
            }
            .user-table { 
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
                <div class="nav-item active">
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
                <h1>User Management</h1>
                <p>Manage system users and their access levels</p>
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
                        <i class="fa-solid fa-right-from-bracket"></i>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </div>

        <div id="dynamicAlertContainer"></div>

        @if(session('success'))
            <div class="alert-success session-alert">
                {{ session('success') }}
                <button type="button" class="close-btn" onclick="this.parentElement.style.display='none'">&times;</button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert-error session-alert">
                {{ session('error') }}
                <button type="button" class="close-btn" onclick="this.parentElement.style.display='none'">&times;</button>
            </div>
        @endif

        <div id="userData" style="display: none;" data-users='@json($allUsers ?? [])'></div>
        <div id="suggestionData" style="display:none;" data-suggestions='@json(array_unique(array_merge(\App\Models\Product::pluck("product_name")->toArray(), \App\Models\StockReport::distinct()->pluck("user_name")->toArray())))'></div>

        @if (Auth::user()->isAdmin())
            <div class="user-container">
                <div class="search-container">
                    <div class="search-wrapper">
                        <input type="text" id="searchInput" class="search-input" placeholder="Search users by name or email..." autocomplete="off" value="{{ request('search') }}">
                        <button class="search-btn" onclick="performSearch()">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                    <div id="autocompleteDropdown" class="autocomplete-dropdown"></div>
                </div>
                <div class="right">
                    <div class="recordcount">
                        <span class="count">Total Users: </span>
                        <strong>{{ $users->total() }}</strong>
                    </div>
                    <div class="add-button">
                        <button id="open_modal" class="new-user">
                            <i class="fas fa-plus"></i> Add User
                        </button>
                    </div>
                </div>
            </div>

            <!-- Add User Modal with Confirm Password -->
            <div class="modal-container" id="modal_container">
                <div class="modal">
                    <div class="modal-header">
                        <h2><i class="fa-solid fa-user-plus"></i> Add New User</h2>
                    </div>
                    <div class="modal-body">
                        <form method="POST" id="addUserForm" action="{{ route('admin.user.store') }}">
                            @csrf
                            <input type="text" name="fullname" placeholder="Full Name" required/>
                            <input type="email" name="email" placeholder="Email" required/>
                        
                            <div class="password-field">
                                <input type="password" name="password" id="add_password" placeholder="Password" required/>
                                <i class="fas fa-eye-slash toggle-password" data-target="add_password"></i>
                            </div>
                            
                            <div class="password-field">
                                <input type="password" name="password_confirmation" id="add_password_confirm" placeholder="Confirm Password" required/>
                                <i class="fas fa-eye-slash toggle-password" data-target="add_password_confirm"></i>
                            </div>
                            <div class="password-match-error" id="add_password_error">
                                <i class="fas fa-exclamation-circle"></i> Passwords do not match!
                            </div>
                            
                            <div class="role">
                                <label>
                                    <input type="radio" name="role" value="admin" required/> 
                                    <i class="fa-solid fa-user-tie"></i> Admin
                                </label>
                                <label>
                                    <input type="radio" name="role" value="user" required/> 
                                    <i class="fa-solid fa-user"></i> User
                                </label>
                            </div>
                            <button class="save-button" type="submit" id="add_user_submit">
                                <i class="fa-solid fa-circle-check"></i> Save User
                            </button>
                        </form>
                        <button id="close_modal" class="cancel-button">
                            <i class="fa-solid fa-circle-xmark"></i> Cancel
                        </button>
                    </div>
                </div>
            </div>

            <!-- Edit User Modal with Confirm Password -->
            <div class="modal-container" id="edit_modal_container">
                <div class="modal">
                    <div class="modal-header">
                        <h2><i class="fa-solid fa-user-edit"></i> Edit User</h2>
                    </div>
                    <div class="modal-body">
                        <form method="POST" id="editUserForm">
                            @csrf
                            @method('PUT')
                        
                                <input type="text" id="edit_fullname" name="fullname" placeholder="Full Name" required/>
                                <input type="email" id="edit_email" name="email" placeholder="Email" required/>
                                <div class="password-field">
                                    <input type="password" name="password" id="edit_password" placeholder="New Password (leave blank to keep current)"/>
                                    <i class="fas fa-eye-slash toggle-password" data-target="edit_password"></i>
                                </div>
                                <div class="password-field">
                                    <input type="password" name="password_confirmation" id="edit_password_confirm" placeholder="Confirm New Password"/>
                                    <i class="fas fa-eye-slash toggle-password" data-target="edit_password_confirm"></i>
                                </div>
                                <div class="password-match-error" id="edit_password_error">
                                    <i class="fas fa-exclamation-circle"></i> Passwords do not match!
                                </div>
                                <div class="role" id="role_buttons_container">
                                    <label>
                                        <input type="radio" name="role" value="admin" id="edit_role_admin"/> 
                                        <i class="fa-solid fa-user-tie"></i> Admin
                                    </label>
                                    <label>
                                        <input type="radio" name="role" value="user" id="edit_role_user"/> 
                                        <i class="fa-solid fa-user"></i> User
                                    </label>
                                </div>
                                <button class="save-button" type="submit" id="edit_user_submit">
                                    <i class="fa-solid fa-circle-check"></i> Update User
                                </button>
                            </form>
                            <button id="close_edit_modal" class="cancel-button">
                                <i class="fa-solid fa-circle-xmark"></i> Cancel
                            </button>
                        </div>
                    </div>
                </div>

            <div class="user-table">
                <div class="table-container">
                    <table class="record-table">
                        <thead>
                            <tr>
                                <th>Full Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Created Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $user)
                            <tr>
                                <td><strong>{{ $user->fullname }}</strong></td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    <span class="{{ $user->role == 'admin' ? 'badge-primary' : 'badge-secondary' }}"><i class="fas {{ $user->role == 'admin' ? 'fa-user-tie' : 'fa-user' }}"></i> {{ ucfirst($user->role) }}</span>
                                </td>
                                <td>
                                    <span>{{ $user->created_at->format('Y-m-d') }}</span>
                                </td>
                                <td>
                                    @if (Auth::id() != $user->id)
                                        <button class="edit-button" onclick='editUser("{{ $user->id }}", "{{ addslashes($user->fullname) }}", "{{ $user->email }}", "{{ $user->role }}", false)'>
                                            <i class="fa-solid fa-edit"></i> Edit
                                        </button>
                                        <form method="POST" action="{{ route('admin.user.delete', $user->id) }}" style="display: inline;" onsubmit="return confirm('Delete user {{ addslashes($user->fullname) }}?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="delete-button">
                                                <i class="fa-solid fa-trash"></i> Delete</button>
                                        </form>
                                    @else
                                        <button class="edit-button" onclick='editUser("{{ $user->id }}", "{{ addslashes($user->fullname) }}", "{{ $user->email }}", "{{ $user->role }}", true)'>
                                            <i class="fa-solid fa-edit"></i> Edit
                                        </button>
                                        <span style="color: gray; font-size: 12px;">
                                            <i class="fa-solid fa-user-check"></i> Current User
                                        </span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" style="text-align: center; padding: 40px;">
                                    <i class="fas fa-users-slash" style="font-size: 48px; color: #ccc;"></i>
                                    <p>No users found</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="pagination-container" id="customPagination"></div>
                <input type="hidden" id="currentPage" value="{{ $users->currentPage() }}">
                <input type="hidden" id="lastPage" value="{{ $users->lastPage() }}">
            </div>
        @else
            <div class="alert-error" style="text-align: center; margin: 50px">
                <i class="fa-solid fa-ban" style="font-size: 48px"></i>
                <h2>Access Denied</h2>
                <p>Administrator access required.</p>
                <a href="{{ route('admin.dashboard') }}" style="display: inline-block; margin-top: 20px; padding: 10px 20px; background: rgb(44, 110, 98); color: white; text-decoration: none; border-radius: 5px;">Back to Dashboard</a>
            </div>
        @endif
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
    var sessionAlerts = document.querySelectorAll('.session-alert');
    sessionAlerts.forEach(function(alert) {
        setTimeout(function() {
            alert.style.opacity = '0';
            alert.style.transition = 'opacity 0.5s ease';
            setTimeout(function() {
                if (alert && alert.parentElement) alert.remove();
            }, 500);
        }, 3000);
    });
}

var userDataElement = document.getElementById('userData');
var allUsers = [];

if (userDataElement) {
    try {
        var usersJson = userDataElement.getAttribute('data-users');
        allUsers = JSON.parse(usersJson);
    } catch(e) { allUsers = []; }
}

// Autocomplete functionality
var searchInput = document.getElementById('searchInput');
var autocompleteDropdown = document.getElementById('autocompleteDropdown');
var searchTimeout;

function showSuggestions() {
    if (!searchInput) return;
    var query = searchInput.value.trim().toLowerCase();
    if (query.length === 0) { 
        if (autocompleteDropdown) autocompleteDropdown.classList.remove('show'); 
        return; 
    }
    var matches = [];
    if (allUsers && allUsers.length > 0) {
        for (var i = 0; i < allUsers.length; i++) {
            var user = allUsers[i];
            if (!user) continue;
            var fullname = (user.fullname || '').toLowerCase();
            var email = (user.email || '').toLowerCase();
            if (fullname.includes(query) || email.includes(query)) { matches.push(user); }
            if (matches.length >= 10) break;
        }
    }
    if (matches.length > 0 && autocompleteDropdown) {
        var html = '';
        for (var i = 0; i < matches.length; i++) {
            var u = matches[i];
            var highlightedName = u.fullname.replace(new RegExp('(' + query + ')', 'gi'), '<strong>$1</strong>');
            var escapedName = u.fullname.replace(/'/g, "\\'");
            html += '<div class="autocomplete-item" onclick="selectUser(\'' + escapedName + '\')"><div>' + highlightedName + '</div><div class="product-price">' + u.email + '</div></div>';
        }
        autocompleteDropdown.innerHTML = html;
        autocompleteDropdown.classList.add('show');
    } else if (autocompleteDropdown) {
        autocompleteDropdown.innerHTML = '<div class="no-results">No users found matching "' + query + '"</div>';
        autocompleteDropdown.classList.add('show');
    }
}

function selectUser(userName) {
    if (searchInput) searchInput.value = userName;
    if (autocompleteDropdown) autocompleteDropdown.classList.remove('show');
    performSearch();
}

function performSearch() {
    if (!searchInput) return;
    var query = searchInput.value.trim();
    var url = new URL(window.location.href);
    if (query) url.searchParams.set('search', query);
    else url.searchParams.delete('search');
    window.location.href = url.toString();
}

if (searchInput) {
    searchInput.addEventListener('input', function() { 
        clearTimeout(searchTimeout); 
        searchTimeout = setTimeout(showSuggestions, 300); 
    });
    document.addEventListener('click', function(e) {
        if (autocompleteDropdown && searchInput && !searchInput.contains(e.target) && !autocompleteDropdown.contains(e.target)) {
            autocompleteDropdown.classList.remove('show');
        }
    });
    searchInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            if (autocompleteDropdown) autocompleteDropdown.classList.remove('show');
            performSearch();
        }
    });
}

//PASSWORD TOGGLE EYE FUNCTION
function initializePasswordToggles() {
    document.querySelectorAll('.toggle-password').forEach(function(eyeIcon) {
        eyeIcon.addEventListener('click', function() {
            var targetId = this.getAttribute('data-target');
            var passwordInput = document.getElementById(targetId);
            if (passwordInput) {
                if (passwordInput.getAttribute('type') === 'password') {
                    passwordInput.setAttribute('type', 'text');
                    this.classList.remove('fa-eye-slash');
                    this.classList.add('fa-eye');
                } else {
                    passwordInput.setAttribute('type', 'password');
                    this.classList.remove('fa-eye');
                    this.classList.add('fa-eye-slash');
                }
            }
        });
    });
}

//PASSWORD MATCH VALIDATION
function validatePasswords(passwordId, confirmId, errorId, submitBtnId) {
    var password = document.getElementById(passwordId);
    var confirm = document.getElementById(confirmId);
    var error = document.getElementById(errorId);
    var submitBtn = document.getElementById(submitBtnId);
    
    function checkMatch() {
        var isEditForm = passwordId === 'edit_password';
        if (isEditForm && !password.value && !confirm.value) {
            error.classList.remove('show');
            if (submitBtn) submitBtn.disabled = false;
            return true;
        }

        if (password.value || confirm.value) {
            if (password.value !== confirm.value) {
                error.classList.add('show');
                confirm.style.borderColor = '#dc3545';
                confirm.style.boxShadow = '0 0 0 3px rgba(220,53,69,0.15)';
                if (submitBtn) submitBtn.disabled = true;
                return false;
            } else {
                error.classList.remove('show');
                confirm.style.borderColor = '#28a745';
                confirm.style.boxShadow = '0 0 0 3px rgba(40,167,69,0.15)';
                if (submitBtn) submitBtn.disabled = false;
                return true;
            }
        } else {
            error.classList.remove('show');
            confirm.style.borderColor = '#e2e8f0';
            confirm.style.boxShadow = '';
            if (submitBtn) submitBtn.disabled = false;
            return true;
        }
    }
    
    if (password) password.addEventListener('input', function() {
        if (confirm.value) checkMatch();
    });
    if (confirm) confirm.addEventListener('input', checkMatch);
    
    var form = submitBtn ? submitBtn.closest('form') : null;
    if (form) {
        form.addEventListener('submit', function(e) {
            if (!checkMatch()) {
                e.preventDefault();
                confirm.focus();
            }
        });
    }
}

//ADD USER MODAL
function resetAddForm() {
    var addPassword = document.getElementById('add_password');
    var addConfirm = document.getElementById('add_password_confirm');
    if (addPassword) addPassword.value = '';
    if (addConfirm) addConfirm.value = '';
    var errorEl = document.getElementById('add_password_error');
    if (errorEl) errorEl.classList.remove('show');
    var submitBtn = document.getElementById('add_user_submit');
    if (submitBtn) submitBtn.disabled = false;
}

//EDIT USER MODAL
function resetEditForm() {
    var editPassword = document.getElementById('edit_password');
    var editConfirm = document.getElementById('edit_password_confirm');
    if (editPassword) editPassword.value = '';
    if (editConfirm) editConfirm.value = '';
    var errorEl = document.getElementById('edit_password_error');
    if (errorEl) errorEl.classList.remove('show');
    var submitBtn = document.getElementById('edit_user_submit');
    if (submitBtn) submitBtn.disabled = false;

    // Re-enable and show role buttons on reset
    var roleContainer = document.getElementById('role_buttons_container');
    if (roleContainer) roleContainer.style.display = 'flex';
    var adminRadio = document.getElementById('edit_role_admin');
    var userRadio = document.getElementById('edit_role_user');
    if (adminRadio) adminRadio.disabled = false;
    if (userRadio) userRadio.disabled = false;
}

function editUser(id, fullname, email, role, isSelf) {
    document.getElementById('edit_fullname').value = fullname;
    document.getElementById('edit_email').value = email;
    if (role === 'admin') document.getElementById('edit_role_admin').checked = true;
    else document.getElementById('edit_role_user').checked = true;

    // Reset password fields
    var editPassword = document.getElementById('edit_password');
    var editConfirm = document.getElementById('edit_password_confirm');
    if (editPassword) editPassword.value = '';
    if (editConfirm) editConfirm.value = '';
    var errorEl = document.getElementById('edit_password_error');
    if (errorEl) errorEl.classList.remove('show');
    var submitBtn = document.getElementById('edit_user_submit');
    if (submitBtn) submitBtn.disabled = false;

    // Hide role selector if editing own account
    var roleContainer = document.getElementById('role_buttons_container');
    if (roleContainer) {
        if (isSelf) {
            roleContainer.style.display = 'none';
            document.getElementById('edit_role_admin').disabled = true;
            document.getElementById('edit_role_user').disabled = true;
        } else {
            roleContainer.style.display = 'flex';
            document.getElementById('edit_role_admin').disabled = false;
            document.getElementById('edit_role_user').disabled = false;
        }
    }

    var form = document.getElementById('editUserForm');
    form.action = '/admin/user/update/' + id;
    document.getElementById('edit_modal_container').classList.add('show');
}

//NOTIFICATION FUNCTIONS
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
    var badge = document.querySelector('.notification-badge');
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
        var isSystemAlert = notif.user_name === 'System (Auto Alert)';
        var isOutOfStock = notif.current_stock === 0;
        var stockColor = isOutOfStock ? '#dc3545' : (notif.current_stock <= notif.min_stock_level ? '#fd7e14' : '#28a745');
        
        var actionButton = '';
        if (isDamage) {
            if (notif.is_resolved) {
                actionButton = '<span class="resolved-badge"><i class="fas fa-check-circle"></i> Resolved</span>';
            } else {
                var damageQty = notif.damage_quantity || 1;
                actionButton = '<button class="btn-edit-damage" onclick="editProductAndReduceStock(' + notif.product_id + ', \'' + escapeHtml(notif.product_name).replace(/'/g, "\\'") + '\', ' + damageQty + ', ' + notif.id + ')"><i class="fas fa-edit"></i> Edit & Reduce (' + damageQty + ' units)</button>';
            }
        } else {
            actionButton = '<button class="btn-order" onclick="createPurchaseOrder(' + notif.product_id + ', \'' + escapeHtml(notif.product_name).replace(/'/g, "\\'") + '\', ' + notif.id + ')"><i class="fas fa-shopping-cart"></i> ' + (isSystemAlert ? 'Restock Now' : 'Create PO') + '</button>';
        }
        
        html += '<div class="notification-item unread" data-id="' + notif.id + '" style="border-left: 3px solid ' + stockColor + ';">' +
            '<div class="notification-title">' +
                '<strong>' + escapeHtml(notif.product_name) + '</strong>' +
                '<span class="notification-time">' + notif.time_ago + '</span>' +
            '</div>' +
            '<div class="notification-message">' +
                '<strong>Reported by: </strong>' + escapeHtml(notif.user_name) + '<br>' +
                '<strong>Current Stock: </strong>' + notif.current_stock + ' units (Min: ' + notif.min_stock_level + ')<br>' +
                '<small>' + escapeHtml(notif.message.substring(0, 100)) + (notif.message.length > 100 ? '...' : '') + '</small>' +
            '</div>' +
            '<div class="notification-buttons">' + actionButton + '<button class="btn-read" onclick="markAsRead(' + notif.id + ')"><i class="fas fa-check"></i> Mark Read</button></div>' +
        '</div>';
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

function escapeHtml(text) {
    if (!text) return '';
    var div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

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

//DOM CONTENT LOADED
document.addEventListener('DOMContentLoaded', function() {

    // Add User Modal
    var open_modal = document.getElementById('open_modal');
    var modal_container = document.getElementById('modal_container');
    var close_modal = document.getElementById('close_modal');

    if (open_modal) {
        open_modal.onclick = function() {
            modal_container.classList.add('show');
            resetAddForm();
        };
    }
    if (close_modal) {
        close_modal.onclick = function() {
            modal_container.classList.remove('show');
            resetAddForm();
        };
    }
    if (modal_container) {
        modal_container.onclick = function(e) {
            if (e.target === modal_container) {
                modal_container.classList.remove('show');
                resetAddForm();
            }
        };
    }

    // Edit User Modal
    var edit_modal_container = document.getElementById('edit_modal_container');
    var close_edit_modal = document.getElementById('close_edit_modal');

    if (close_edit_modal) {
        close_edit_modal.onclick = function() {
            edit_modal_container.classList.remove('show');
            resetEditForm();
        };
    }
    if (edit_modal_container) {
        edit_modal_container.onclick = function(e) {
            if (e.target === edit_modal_container) {
                edit_modal_container.classList.remove('show');
                resetEditForm();
            }
        };
    }

    // Notification bell toggle
    var bell = document.getElementById('notificationBell');
    var dropdown = document.getElementById('notificationDropdown');
    if (bell) {
        bell.addEventListener('click', function(e) {
            e.stopPropagation();
            dropdown.classList.toggle('show');
            if (dropdown.classList.contains('show')) fetchNotifications();
        });
    }
    document.addEventListener('click', function() { 
        if (dropdown) dropdown.classList.remove('show'); 
    });

    renderPagination();
    autoCloseSessionAlerts();
    initializePasswordToggles();
    validatePasswords('add_password', 'add_password_confirm', 'add_password_error', 'add_user_submit');
    validatePasswords('edit_password', 'edit_password_confirm', 'edit_password_error', 'edit_user_submit');
    fetchNotifications();
    setInterval(fetchNotifications, 10000);
});
    </script>
</body>
</html>