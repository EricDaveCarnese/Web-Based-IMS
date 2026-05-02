<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Categories | Inventory MS</title>
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
            overflow-x: hidden; 
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
            transition: all 0.3s ease;
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
            height: 45px; border-radius: 14px; 
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
            margin: 0; padding: 10px 25px; 
            width: 100%; 
            border-radius: 15px; 
            border: none; 
            cursor: pointer; 
            color: rgba(189, 189, 189, 0.6); transition: all 0.3s ease; 
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
            color: white; border-left: 3px solid #ffd700; 
            border-radius: 15px; 
            height: 40px; 
        }
        .nav-item { 
            height: 40px; 
            transition: all 0.3s ease; 
        }
        
        .main-content {
            background: linear-gradient(45deg, rgb(44, 110, 98) 20%, #144243 50%, rgba(60, 130, 110, 0.35) 100%);
            flex: 1; 
            overflow-y: auto; 
            margin-left: 280px; 
            min-height: 100vh;
            transition: all 0.3s ease;
        }
        
        /* Header Styles */
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
        .dashboard { 
            margin-bottom: 3px; 
            font-weight: bold; 
        }
        .dashboard-sub { 
            color: gray; 
            font-size: 14px; 
        }
        .user-menu-container a { 
            background: linear-gradient(180deg, rgb(15, 43, 61) 0%, rgb(25, 110, 114) 100%); 
            height: 35px; padding-inline-start: 15px; 
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
        @keyframes 
            slideDown { 
                from { 
                    opacity: 0; 
                    transform: translateY(-10px); 
                } to {
                    opacity: 1; transform: translateY(0); 
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
            cursor: pointer;
            transition: background 0.2s;
        }
        .notification-item:hover { 
            background: #f8f9fa; 
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
            justify-content: space-between; flex-wrap: wrap; 
            gap: 5px; 
        }
        .notification-message { 
            font-size: 12px; 
            color: #6c757d; 
            margin-bottom: 8px; 
            line-height: 1.5; 
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
        .btn-order, .btn-read, .btn-edit-damage { 
            padding: 4px 10px; 
            border-radius: 15px; 
            font-size: 11px; 
            cursor: pointer; 
            border: none; 
            transition: all 0.2s; 
        }
        .btn-order { 
            background: #28a745; 
            color: white; 
        }
        .btn-order:hover { background: #1e7e34; 
        }
        .btn-read { 
            background: #6c757d; 
            color: white; 
        }
        .btn-read:hover { 
            background: #5a6268; 
        }
        .btn-edit-damage { 
            background: #fd7e14; 
            color: white; 
        }
        .btn-edit-damage:hover { 
            background: #e6690a; 
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
        
        /* Options Section */
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
            width: 100%; 
        }
        .search-input { 
            flex: 1; 
            padding: 12px 16px; 
            border: 1px solid #e2e8f0; 
            border-radius: 25px; 
            font-size: 14px; 
            outline: none; transition: all 0.3s ease; 
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
        .no-results { 
            padding: 12px 16px; 
            text-align: center; 
            color: #999; 
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
        .add-category-button {
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
        .add-category-button:hover { 
            transform: scale(1.03); 
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15); 
        }
        
        /* Categories Table */
        .category-table { 
            margin: 20px 50px; 
            background: white; 
            border-radius: 20px; 
            padding: 1.5rem; 
            padding-bottom: 40px; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08); 
        }
        .table-container { 
            max-height: 500px; 
            overflow-y: auto; 
            border-radius: 12px; 
            margin-top: 10px; 
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
            min-width: 500px; 
        }
        .record-table th, .record-table td { 
            padding: 14px 12px; 
            text-align: left; 
            border-bottom: 1px solid #e2e8f0; 
        }
        .record-table th { 
            background: linear-gradient(180deg, rgb(15, 43, 61) 0%, rgb(25, 110, 114) 100%); color: white; font-weight: 600; 
            position: sticky; 
            top: 0; 
            z-index: 10; 
        }
        .record-table tr:hover { 
            background: linear-gradient(180deg, rgb(49, 83, 104) 0%, rgba(47, 229, 239, 0.426) 100%); 
            color: white; 
        }
        .edit-button {
            background: linear-gradient(180deg, rgb(40, 140, 203) 0%, rgb(25, 110, 114) 100%);
            border: none; 
            color: white; 
            padding: 6px 14px; 
            border-radius: 20px; 
            cursor: pointer;
            transition: all 0.3s ease; 
            font-size: 12px; 
            display: inline-flex; 
            align-items: center;
            gap: 5px;
            margin-right: 5px;
        }
        .edit-button:hover { 
            background: white; 
            color: rgb(25, 110, 114); 
            transform: translateY(-2px); 
        }
        .delete-button {
            background: linear-gradient(180deg, rgb(188, 179, 170) 0%, rgb(214, 162, 79) 100%);
            border: none; 
            color: white; 
            padding: 6px 14px; 
            border-radius: 20px; 
            cursor: pointer;
            transition: all 0.3s ease; 
            font-size: 12px; 
            display: inline-flex; 
            align-items: center; 
            gap: 5px;
        }
        .delete-button:hover { 
            background: white; 
            color: red; 
            transform: translateY(-2px); 
        }
        
        /* Alert Messages */
        .alert-success, .alert-error {
            position: relative; 
            padding: 12px 40px 12px 20px; 
            border-radius: 8px;
            margin: 10px 50px; 
            border-left: 4px solid;
        }
        .alert-success { 
            background-color: #d4edda; 
            color: #155724; 
            border-left-color: #28a745; 
        }
        .alert-error { 
            background-color: #f8d7da; 
            color: #721c24; 
            border-left-color: #dc3545; 
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
            color: inherit; opacity: 0.7;
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
            opacity: 1; }
        .modal {
            width: 90%;
            max-width: 450px; 
            max-height: 90vh; 
            overflow-y: auto;
            background: linear-gradient(45deg, rgb(44, 110, 98) 20%, #144243 50%, rgba(60, 130, 110, 0.35) 100%);
            padding: 25px; 
            border-radius: 15px; 
            animation: modalSlideIn 0.3s ease;
        }
        @keyframes 
            modalSlideIn { 
                from { 
                    transform: translateY(-30px); 
                    opacity: 0; 
                } to { 
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
            font-size: 1.4rem; }
        .modal-body {
            width: 100%; 
        }
        .modal input, .modal textarea {
            width: 100%; 
            padding: 12px 16px; 
            border: 1px solid #e2e8f0; 
            border-radius: 25px;
            font-size: 14px; 
            outline: none; 
            transition: all 0.3s ease; 
            margin-bottom: 20px;
            box-sizing: border-box; 
            background: white;
        }
        .modal textarea { 
            height: 100px; 
            resize: vertical; 
            font-family: inherit; 
        }
        .save-button {
            background: linear-gradient(180deg, rgb(15, 43, 61) 0%, rgb(25, 110, 114) 100%);
            border: none;
            width: 100%; 
            font-size: 14px; 
            font-weight: 600; 
            padding: 12px 16px;
            border-radius: 25px; 
            color: white; 
            cursor: pointer; 
            transition: all 0.3s ease; 
            margin-bottom: 10px;
        }
        .cancel-button {
            background: linear-gradient(180deg, rgb(188, 179, 170) 0%, rgb(214, 162, 79) 100%);
            border: none; 
            width: 100%; 
            font-size: 14px; 
            font-weight: 600; 
            padding: 12px 16px;
            border-radius: 25px; 
            cursor: pointer; 
            transition: all 0.3s ease;
        }
        .save-button:hover, .cancel-button:hover { 
            transform: scale(1.02); 
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
        
        .toast-message {
            position: fixed; 
            bottom: 20px; 
            right: 20px; 
            background: #28a745;
            color: white; 
            padding: 12px 20px; 
            border-radius: 8px;
            z-index: 1100; 
            animation: slideInRight 0.3s ease;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }
        @keyframes 
            slideInRight { 
                from { 
                    transform: translateX(100%); 
                    opacity: 0; 
                } to { 
                    transform: translateX(0); 
                    opacity: 1; 
                } 
            }
        
        @media (max-width: 1200px) {
            .options { 
                margin: 20px 30px; 
            }
            .category-table { 
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
                margin: 20px; 
                flex-direction: column; 
                align-items: stretch; 
            }
            .search-container { 
                max-width: 100%; 
            }
            .right { 
                width: 100%; 
                justify-content: space-between; 
            }
            .add-category-button { 
                width: auto; 
            }
            .category-table { 
                margin: 20px; 
                padding: 1rem; 
            }
            .table-container { 
                max-height: 400px; 
            }
            .alert-success, .alert-error { 
                margin: 20px; 
            }
            .topheader { 
                padding: 15px; 
            }
            .page-title { 
                margin-left: 15px; 
            }
            .user-menu { 
                margin-right: 15px; 
                gap: 12px; 
            }
            .record-table th, .record-table td { 
                padding: 10px 8px; 
                font-size: 0.8rem; 
            }
            .edit-button, .delete-button { 
                padding: 4px 10px; 
                font-size: 11px; 
            }
            .notification-dropdown { 
                width: 320px; 
                right: -10px; 
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
            .recordcount { 
                font-size: 12px; 
                padding: 8px 14px; 
            }
            .add-category-button { 
                font-size: 14px; 
                padding: 8px 16px; 
            }
        }
        @media (max-width: 480px) {
            .options { 
                margin: 15px; 
                gap: 12px; 
            }
            .category-table { 
                margin: 15px; 
                padding: 0.8rem; 
            }
            .alert-success, .alert-error { 
                margin: 15px; 
                padding: 10px 35px 10px 15px; 
                font-size: 13px; 
            }
            .record-table th, .record-table td { 
                font-size: 0.7rem; 
                padding: 8px 6px; 
            }
            .edit-button, .delete-button { 
                padding: 3px 8px; 
                font-size: 9px; 
                margin: 2px; 
            }
            .modal { 
                max-width: 95%; 
                padding: 15px; 
            }
            .modal input, .modal textarea { 
                padding: 10px 12px; 
                font-size: 13px; 
                margin-bottom: 15px; 
            }
            .save-button, .cancel-button { 
                padding: 10px; 
                font-size: 13px; 
            }
            .search-input { 
                padding: 10px 14px; 
                font-size: 13px; 
            }
            .search-btn { width: 40px;
                height: 40px; 
            }
            .add-category-button {
                padding: 6px 14px; 
                font-size: 13px; 
            }
            .topheader { 
                padding: 10px; 
            }
            .user-menu { 
                gap: 8px; 
                margin-right: 10px; 
            }
            .logout-btn { 
                padding: 6px 14px; 
                font-size: 12px; 
            }
            .user-menu-container a { 
                padding-inline-start: 8px; 
                padding-inline-end: 8px; 
                font-size: 11px; 
            }
            .notification-dropdown { 
                width: 280px; 
                right: -20px; 
            }
            .notification-item { 
                padding: 8px 12px; 
            }
            .notification-buttons { 
                flex-wrap: wrap; 
            }
            .notification-title { 
                flex-direction: column; 
            }
            .recordcount .count { 
                font-size: 10px; 
            }
            .recordcount strong { 
                font-size: 12px; 
            }
        }
        @media (max-width: 380px) {
            .user-menu { 
                gap: 5px; 
            }
            .logout-btn { 
                padding: 5px 10px; 
                font-size: 11px; 
            }
            .notification-bell { 
                width: 35px; 
                height: 35px; 
                font-size: 14px; 
            }
            .recordcount strong { 
                font-size: 11px; 
            }
            .add-category-button i { 
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
            .category-table {
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
                    <div class="nav-item active">
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
    </div>
    <div class="main-content">
        <div class="topheader">
            <div class="page-title">
                <h1 class="dashboard">Categories</h1>
                <p class="dashboard-sub">Organize your products into categories</p>
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

        <div id="categoryData" style="display: none;" data-categories='@json($allCategories ?? [])'></div>

        <div class="record-categories">
            <div class="options">
                <div class="search-container">
                    <div class="search-wrapper">
                        <input type="text" id="searchInput" class="search-input" placeholder="Search categories..." autocomplete="off" value="{{ request('search') }}">
                        <button class="search-btn" onclick="performSearch()">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                    <div id="autocompleteDropdown" class="autocomplete-dropdown"></div>
                </div>
                <div class="right">
                    <div class="recordcount">
                        <span class="count">Total Categories: </span>
                        <strong>{{ $categories->total() }}</strong>
                    </div>
                    <div class="add-button">
                        <button id="open_modal" class="add-category-button">
                            <i class="fas fa-plus"></i>
                            <span>Add Category</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Add Category Modal -->
            <div class="modal-container" id="modal_container">
                <div class="modal">
                    <div class="modal-header">
                        <h2><i class="fa-solid fa-folder-open"></i> Add New Category</h2>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="{{ route('admin.category.store') }}">
                            @csrf
                            <input type="text" name="category_name" placeholder="Category Name: e.g., Electronics" required/>
                            <textarea name="description" placeholder="Description (Optional)"></textarea>
                            <button class="save-button" type="submit">
                                <i class="fa-solid fa-circle-check"></i> Save Category
                            </button>
                        </form>
                        <button id="close_modal" class="cancel-button">
                            <i class="fa-solid fa-circle-xmark"></i> Cancel
                        </button>
                    </div>
                </div>
            </div>

            <!-- Edit Category Modal -->
            <div class="modal-container" id="edit_modal_container">
                <div class="modal">
                    <div class="modal-header">
                        <h2><i class="fa-solid fa-folder-open"></i> Edit Category</h2>
                    </div>
                    <div class="modal-body">
                        <form method="POST" id="editCategoryForm">
                            @csrf
                            @method('PUT')
                            <input type="text" id="edit_category_name" name="category_name" placeholder="Category Name" required/>
                            <textarea id="edit_description" name="description" placeholder="Description (Optional)"></textarea>
                            <button class="save-button" type="submit">
                                <i class="fa-solid fa-circle-check"></i> Update Category
                            </button>
                        </form>
                        <button id="close_edit_modal" class="cancel-button">
                            <i class="fa-solid fa-circle-xmark"></i> Cancel
                        </button>
                    </div>
                </div>
            </div>

            <div class="category-table">
                <div class="table-container">
                    <table class="record-table">
                        <thead>
                            <tr>
                                <th>Category Name</th>
                                <th>Description</th>
                                <th>Products</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($categories as $category)
                            <tr>
                                <td>{{ $category->category_name }}</td>
                                <td><small>{{ $category->description ?? '—' }}</small></td>
                                <td><span>{{ $category->products_count ?? 0 }}</span></td>
                                <td>
                                    <span>
                                    <button class="edit-button" data-category='@json($category)' onclick="editCategory(this)">
                                        <i class="fa-solid fa-pen-to-square"></i> Edit
                                    </button>   
                                        <form method="POST" action="{{ route('admin.category.delete', $category->id) }}" style="display: inline;" onsubmit="return confirmDeleteCategory('{{ addslashes($category->category_name) }}')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="delete-button">
                                                <i class="fas fa-trash"></i> Delete
                                            </button>
                                        </form>
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" style="text-align: center; padding: 40px;">
                                    <i class="fas fa-folder-open" style="font-size: 48px; color: #ccc;"></i>
                                    <p style="margin-top: 10px; color: #666;">No categories found. Click "Add Category" to create one.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="pagination-container" id="customPagination"></div>
                <input type="hidden" id="currentPage" value="{{ $categories->currentPage() }}">
                <input type="hidden" id="lastPage" value="{{ $categories->lastPage() }}">
            </div>
        </div>
        
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
    var categoryDataElement = document.getElementById('categoryData');
    var allCategories = [];
    
    if (categoryDataElement) {
        try {
            var categoriesJson = categoryDataElement.getAttribute('data-categories');
            allCategories = JSON.parse(categoriesJson);
        } catch(e) {
            allCategories = [];
        }
    }
    
    // Confirmation for delete category
    function confirmDeleteCategory(categoryName) {
        return confirm('Delete category "' + categoryName + '"?\n\nProducts in this category will NOT be deleted, but they will become uncategorized.\n\nThis action cannot be undone. Continue?');
    }
    
    //AUTOCOMPLETE SUGGESTIONS
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
        if (allCategories && allCategories.length > 0) {
            for (var i = 0; i < allCategories.length; i++) {
                var category = allCategories[i];
                if (!category) continue;
                var categoryName = (category.category_name || '').toLowerCase();
                if (categoryName.includes(query)) {
                    matches.push(category);
                }
                if (matches.length >= 10) break;
            }
        }
        if (matches.length > 0 && autocompleteDropdown) {
            var html = '';
            for (var i = 0; i < matches.length; i++) {
                var c = matches[i];
                var highlightedName = c.category_name.replace(new RegExp('(' + query + ')', 'gi'), '<strong>$1</strong>');
                var escapedName = c.category_name.replace(/'/g, "\\'");
                html += '<div class="autocomplete-item" onclick="selectCategory(\'' + escapedName + '\')"><div>' + highlightedName + '</div></div>';
            }
            autocompleteDropdown.innerHTML = html;
            autocompleteDropdown.classList.add('show');
        } else if (autocompleteDropdown) {
            autocompleteDropdown.innerHTML = '<div class="no-results">No categories found matching "' + escapeHtml(query) + '"</div>';
            autocompleteDropdown.classList.add('show');
        }
    }
    
    function selectCategory(categoryName) {
        if (searchInput) searchInput.value = categoryName;
        if (autocompleteDropdown) autocompleteDropdown.classList.remove('show');
        performSearch();
    }
    
    function escapeHtml(text) {
        var div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
    
    function performSearch() {
        if (!searchInput) return;
        var query = searchInput.value.trim();
        var url = new URL(window.location.href);
        if (query) url.searchParams.set('search', query);
        else url.searchParams.delete('search');
        url.searchParams.delete('page');
        window.location.href = url.toString();
    }
    
    if (searchInput) {
        searchInput.addEventListener('input', function() { 
            clearTimeout(searchTimeout); 
            searchTimeout = setTimeout(showSuggestions, 300); 
        });
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                if (autocompleteDropdown) autocompleteDropdown.classList.remove('show');
                performSearch();
            }
        });
        document.addEventListener('click', function(e) {
            if (autocompleteDropdown && searchInput && !searchInput.contains(e.target) && !autocompleteDropdown.contains(e.target)) {
                autocompleteDropdown.classList.remove('show');
            }
        });
    }
    
    // ==================== ADD CATEGORY MODAL ====================
    var open_modal = document.getElementById('open_modal');
    var modal_container = document.getElementById('modal_container');
    var close_modal = document.getElementById('close_modal');

    if (open_modal) open_modal.onclick = function() { modal_container.classList.add('show'); };
    if (close_modal) close_modal.onclick = function() { modal_container.classList.remove('show'); };
    if (modal_container) modal_container.onclick = function(e) { if (e.target === modal_container) modal_container.classList.remove('show'); };

    // ==================== EDIT CATEGORY MODAL ====================
    var edit_modal_container = document.getElementById('edit_modal_container');
    var close_edit_modal = document.getElementById('close_edit_modal');

    function editCategory(button) {
        var category = JSON.parse(button.getAttribute('data-category'));
        document.getElementById('edit_category_name').value = category.category_name;
        document.getElementById('edit_description').value = category.description || '';
        var form = document.getElementById('editCategoryForm');
        form.action = '/admin/category/update/' + category.id;
        edit_modal_container.classList.add('show');
    }

    if (close_edit_modal) close_edit_modal.onclick = function() { edit_modal_container.classList.remove('show'); };
    if (edit_modal_container) edit_modal_container.onclick = function(e) { if (e.target === edit_modal_container) edit_modal_container.classList.remove('show'); };

    // ==================== NOTIFICATION DROPDOWN FUNCTIONS ====================
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
                    '<strong>Reported by:</strong> ' + escapeHtml(notif.user_name) + '<br>' +
                    '<strong>Current Stock:</strong> <strong' + stockColor + ';">' + notif.current_stock + '</strong> units (Min: ' + notif.min_stock_level + ')<br>' +
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
                // Remove item from bell dropdown immediately
                var item = document.querySelector('.notification-item[data-id="' + reportId + '"]');
                if (item) {
                    item.style.opacity = '0';
                    item.style.transition = 'opacity 0.3s ease';
                    setTimeout(function() {
                        item.remove();
                        // Check if dropdown is now empty
                        var list = document.getElementById('notificationList');
                        if (list && list.querySelectorAll('.notification-item').length === 0) {
                            list.innerHTML = '<div class="no-notifications"><i class="fas fa-check-circle" style="font-size:32px;margin-bottom:10px;display:block;"></i><p>No pending stock reports</p></div>';
                        }
                    }, 300);
                }
                // Refresh bell count
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
    
    // ==================== NOTIFICATION BELL TOGGLE ====================
    var bell = document.getElementById('notificationBell');
    var dropdown = document.getElementById('notificationDropdown');
    if (bell) {
        bell.addEventListener('click', function(e) { 
            e.stopPropagation(); 
            dropdown.classList.toggle('show'); 
            if (dropdown.classList.contains('show')) fetchNotifications();
        });
    }
    document.addEventListener('click', function() { if (dropdown) dropdown.classList.remove('show'); });
    
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
    
    document.addEventListener('DOMContentLoaded', function() {
        autoCloseSessionAlerts();
        renderPagination();
        fetchNotifications();
        setInterval(fetchNotifications, 30000);
    });
</script>
</body>
</html>