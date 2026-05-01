<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes" />
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
            position: fixed; 
            z-index: 100;
        }
        .brand { 
            display: flex; 
            align-items: center; 
            gap: 15px; 
            margin-bottom: 15px;
            border-bottom: 1px solid rgba(255,255,255,0.15); 
            padding-bottom: 1.5rem; 
        }
        .brand-icon { 
            background: linear-gradient(180deg, rgb(15,43,61) 0%, rgb(25,110,114) 100%);
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
            color: rgba(189,189,189,0.6); 
            transition: all 0.3s ease; 
        }
        .nav-item:hover:not(.active) { 
            background-color: rgba(60,130,110,0.35); 
            color: white;
            height: 40px; 
            border-left: 3px solid #ffd700; 
            border-radius: 15px; 
        }
        .nav-item.active button { 
            background: linear-gradient(180deg,rgb(15,43,61) 0%,rgb(25,110,114) 100%);
            color: white; 
            border-left: 3px solid #ffd700; 
            border-radius: 15px; 
            height: 40px; 
        }
        .nav-item { 
            height: 40px; 
            transition: all 0.3s ease; 
        }

        .main-content { 
            background: linear-gradient(45deg,rgb(44,110,98) 20%,#144243 50%,rgba(60,130,110,0.35) 100%);
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
            background-color: white; 
            border-bottom: 1px solid rgb(210,210,210);
            flex-wrap: wrap; 
            gap: 15px; 
        }
        .page-title { 
            margin-left: 30px; 
            color: rgb(44,110,98); 
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
            background: linear-gradient(180deg,rgb(15,43,61) 0%,rgb(25,110,114) 100%);
            height: 35px; 
            padding-inline: 15px; 
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
            background: linear-gradient(180deg,rgb(15,43,61) 0%,rgb(25,110,114) 100%);
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

        /* Notification */
        .notification-area { 
            position: relative; 
            display: inline-block; 
            margin-right: 15px; 
        }
        .notification-bell { 
            background: linear-gradient(180deg,rgb(15,43,61) 0%,rgb(25,110,114) 100%);
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
            font-weight: bold; 
        }
        .notification-dropdown { 
            position: absolute; 
            top: 50px; 
            right: 0; 
            width: 380px;
            background: white; 
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
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
                from{
                    opacity:0;
                    transform:translateY(-10px)
                } 
                to{
                    opacity:1;
                    transform:translateY(0)} 
                }
        .notification-header { 
            background: linear-gradient(135deg,rgb(15,43,61) 0%,rgb(25,110,114) 100%);
            color: white; 
            padding: 12px 15px; 
            font-weight: 600; 
        }
        .notification-list { 
            max-height: 350px; 
            overflow-y: auto; 
        }
        .notification-list::-webkit-scrollbar {
            width: 6px;
        }
        .notification-list::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }
        .notification-list::-webkit-scrollbar-thumb {
            background: #2c6e62;
            border-radius: 10px;
        }
        .notification-list {
            scrollbar-width: thin;
            scrollbar-color: #2c6e62 #f1f1f1;
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
            align-items: flex-start; 
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
            white-space: nowrap; 
            margin-left: 8px; 
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
            border-radius: 15px; font-size: 11px; 
            cursor: pointer; 
            border: none; 
        }
        .btn-read  { 
            background: #6c757d; 
            color: white; 
            padding: 4px 10px; 
            border-radius: 15px; font-size: 11px; 
            cursor: pointer;
            border: none; 
        }
        .btn-edit-damage { 
            background: #fd7e14; 
            color: white; 
            padding: 4px 10px; 
            border-radius: 15px; font-size: 11px; 
            cursor: pointer; 
            border: none; 
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
        .no-notifications { 
            padding: 30px; 
            text-align: center; 
            color: #9ca3af; 
        }

        /* Options */
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
        .search-wrapper { display: flex; align-items: center; gap: 10px; width: 100%; }
        .search-input { 
            flex: 1; 
            padding: 12px 16px; 
            border: 1px solid #e2e8f0;
            border-radius: 25px; 
            font-size: 14px; 
            outline: none; 
        }
        .search-input:focus { 
            border-color: rgb(44,110,98); 
            box-shadow: 0 0 0 3px rgba(44,110,98,0.1); 
        }
        .search-btn { 
            background: linear-gradient(180deg,rgb(15,43,61) 0%,rgb(25,110,114) 100%);
            border: none; 
            color: white; 
            width: 44px; 
            height: 44px; 
            border-radius: 50%;
            cursor: pointer; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
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
        .add-product-button { 
            background: linear-gradient(180deg,rgb(15,43,61) 0%,rgb(25,110,114) 100%);
            border: none;
            color: white; 
            font-weight: 600; 
            font-size: 16px; 
            padding: 10px 24px;
            cursor: pointer; 
            border-radius: 25px; 
            display: flex; 
            align-items: center; 
            gap: 10px; transition: all 0.3s ease; 
        }
        .right { 
            display: flex; 
            align-items: center; 
            gap: 15px; 
            flex-wrap: wrap; 
        }
        .recordcount { 
            color: rgb(71,241,4); 
            padding: 11px 18px; 
            border-radius: 25px; 
            font-size: 14px;
            font-weight: 600; 
            display: inline-flex; 
            align-items: center; 
            gap: 8px;
            background: linear-gradient(180deg,rgb(15,43,61) 0%,rgb(25,110,114) 100%); 
        }
        .count { 
            font-weight: 600; 
            color: white; 
        }

        /* Table */
        .product-table { 
            margin: 20px 50px; 
            background: white; 
            border-radius: 20px;
            padding: 1.5rem; 
            box-shadow: 0 10px 30px rgba(0,0,0,0.08); 
        }
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
        .record-table th, .record-table td { 
            padding: 14px 12px; 
            text-align: left; 
            border-bottom: 1px solid #e2e8f0; 
        }
        .record-table th { 
            background: linear-gradient(180deg,rgb(15,43,61) 0%,rgb(25,110,114) 100%);
            color: white; 
            font-weight: 600; 
            position: sticky; 
            top: 0; 
            z-index: 10; 
        }
        .record-table tr:hover { 
            background: linear-gradient(180deg,rgb(49,83,104) 0%,rgba(47,229,239,0.426) 100%); 
            color: white;
        }
        .description-cell { 
            max-width: 300px;
            min-width: 200px; 
            white-space: normal; 
            word-wrap: break-word; 
        }
        .short-desc, .full-desc { 
            display: block; 
        }
        .full-desc { 
            display: none; 
        }
        .toggle-description { 
            color: rgb(44,110,98); 
            cursor: pointer; 
            font-size: 12px; 
            text-decoration: none; 
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
        .status-in-stock    { 
            background: #d4edda; 
            color: #155724;
        }
        .status-low-stock   { 
            background: #fff3cd; 
            color: #856404; 
        }
        .status-out-of-stock{ 
            background: #f8d7da; 
            color: #721c24; 
        }
        .price-cell { 
            font-weight: 600; 
            color: #2c6e62; 
        }
        .edit-button, .delete-button { 
            padding: 6px 14px; 
            border-radius: 20px; 
            cursor: pointer;
            font-size: 12px; 
            display: inline-flex; 
            align-items: center; 
            gap: 5px; 
            border: none; 
            transition: all 0.3s ease; 
        }
        .edit-button   { 
            background: linear-gradient(180deg,rgb(40,140,203) 0%,rgb(25,110,114) 100%); 
            color: white; 
        }
        .delete-button { 
            background: linear-gradient(180deg,rgb(188,179,170) 0%,rgb(214,162,79) 100%); 
            color: white; 
        }

        /* Alerts */
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
        .alert-error   { 
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
            cursor: pointer; 
        }

        /* Autocomplete */
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
            color: rgb(44,110,98); 
        }
        .autocomplete-price { 
            font-size: 11px; 
            color: #666; 
            margin-top: 3px; 
        }
        .no-results { 
            padding: 12px 16px; 
            text-align: center; 
            color: #999; 
        }

        /* Modals */
        .modal-container { 
            position: fixed; 
            top: 0; 
            left: 0; 
            width: 100%; 
            height: 100%;
            background: rgba(0,0,0,0.5); 
            backdrop-filter: blur(4px);
            display: flex; 
            align-items: center; 
            justify-content: center;
            visibility: hidden; 
            opacity: 0; 
            transition: all 0.3s ease; 
            z-index: 1000; 
        }
        .modal-container.show { visibility: visible; 
            opacity: 1; 
        }
        .modal { 
            width: 90%; 
            max-width: 550px; 
            max-height: 90vh; 
            overflow-y: auto;
            background: linear-gradient(45deg,rgb(44,110,98) 20%,#144243 50%);
            padding: 25px; 
            border-radius: 15px; 
            animation: modalSlideIn 0.3s ease; 
        }
        @keyframes 
            modalSlideIn { 
                from{
                    transform:translateY(-30px);
                    opacity:0
                } to{
                    transform:translateY(0);
                    opacity:1
                } 
            }
        .modal-header { 
            margin-bottom: 20px; 
            color: rgb(151,205,200); 
        }
        .modal-header h2 { 
            display: flex; 
            align-items: center; 
            gap: 10px; 
            font-size: 1.4rem; 
        }
        .modal input, .modal textarea, .modal select {
            width: 100%; 
            padding: 12px 16px; 
            border: 1px solid #e2e8f0;
            border-radius: 25px; 
            font-size: 14px; 
            margin-bottom: 15px; 
            background: white; 
            box-sizing: border-box; 
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
            border: none; 
        }
        .save-button   { 
            background: linear-gradient(180deg,rgb(15,43,61) 0%,rgb(25,110,114) 100%); 
            color: white; 
        }
        .cancel-button { 
            background: linear-gradient(180deg,rgb(188,179,170) 0%,rgb(214,162,79) 100%); 
        }

        /* Damage-mode styles — visually grey out non-editable fields */
        .field-readonly-visual {
            background-color: #e9ecef !important;
            color: #6c757d !important;
            cursor: not-allowed !important;
            pointer-events: none;
        }
        .damage-notice { 
            background: #fd7e14; 
            color: white; 
            padding: 12px;
            border-radius: 8px; 
            margin-bottom: 15px; 
            text-align: center; 
            font-size: 13px; 
        }
        .damage-highlight { 
            border: 2px solid #fd7e14 !important; 
            background-color: #fff8f0 !important; 
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

        /* Toast */
        .toast-message { 
            position: fixed; 
            bottom: 20px; 
            right: 20px; 
            color: white;
            padding: 12px 20px; 
            border-radius: 8px; 
            z-index: 1100; 
            animation: slideIn 0.3s ease; 
        }
        @keyframes 
            slideIn { 
                from{
                    transform:translateX(100%);
                    opacity:0
            } 
                to{
                    transform:translateX(0);
                opacity:1
            } 
        }

        @media (max-width: 1000px) { 
            .sidebar{width:90px;} 
            .brand h2,.nav-menu button span{display:none;} 
            .main-content{margin-left:90px;} 
        }
        @media (max-width: 860px)  { 
            .options{margin:20px;flex-direction:column;} 
            .right{width:100%;justify-content:space-between;} .product-table{margin:20px;} 
        }
            @media (max-width: 480px)  { 
                .options{margin:15px;} 
            .product-table{margin:15px;padding:0.8rem;} 
            .modal{padding:15px;} 
        }
    </style>
</head>
<body>
    <!-- SIDEBAR -->
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
                <div class="nav-item active">
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
                <div class="nav-item">
                    <button>
                        <i class="fa-solid fa-triangle-exclamation"></i>
                        <span>Stock Reports</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- MAIN -->
    <div class="main-content">
        <!-- TOPHEADER -->
        <div class="topheader">
            <div class="page-title">
                <h1 class="dashboard">Products</h1>
                <p class="dashboard-sub">Manage all product catalog, stock levels and categories</p>
            </div>
            <div class="user-menu">
                @php 
                    $pendingStockReportsCount = \App\Models\StockReport::where('status','pending')->where('notify_users',false)->count(); 
                @endphp
                <div class="notification-area">
                    <button class="notification-bell" id="notificationBell">
                        <i class="fas fa-bell"></i>
                        @if($pendingStockReportsCount > 0)
                            <span class="notification-badge" id="notifBadge">{{ $pendingStockReportsCount }}</span>
                        @endif
                    </button>
                    <div class="notification-dropdown" id="notificationDropdown">
                        <div class="notification-header">
                            <i class="fas fa-exclamation-triangle"></i> Stock Alerts
                        </div>
                        <div class="notification-list" id="notificationList">
                            <div style="padding:15px;text-align:center;color:#999;">Loading...</div>
                        </div>
                        <div class="notification-footer">
                            <a href="{{ route('admin.stock.reports') }}">View All Reports →</a>
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

        <!-- OPTIONS -->
        <div class="options">
            <div class="search-container">
                <div class="search-wrapper">
                    <input type="text" id="searchInput" class="search-input" placeholder="Search products..." value="{{ request('search') }}">
                    <button class="search-btn" onclick="performSearch()">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
                <div id="autocompleteDropdown" class="autocomplete-dropdown"></div>
            </div>
            <div class="right">
                <select id="filterStatus" class="filter-dropdown" onchange="applyFilter()">
                    <option value="all"        {{ request('status')=='all'        ? 'selected' : '' }}>All Products</option>
                    <option value="instock"    {{ request('status')=='instock'    ? 'selected' : '' }}>In Stock</option>
                    <option value="lowstock"   {{ request('status')=='lowstock'   ? 'selected' : '' }}>Low Stock</option>
                    <option value="outofstock" {{ request('status')=='outofstock' ? 'selected' : '' }}>Out of Stock</option>
                </select>
                <div class="recordcount">
                    <span class="count">Total Products: </span>
                    <strong>{{ $products->total() }}</strong>
                </div>
                <button id="open_modal" class="add-product-button">
                    <i class="fas fa-plus"></i>
                    <span>Add Product</span>
                </button>
            </div>
        </div>

        <!-- ADD PRODUCT MODAL -->
        <div class="modal-container" id="modal_container">
            <div class="modal">
                <div class="modal-header">
                    <h2><i class="fa-solid fa-box-open"></i> Add New Product</h2>
                </div>
                <form method="POST" action="{{ route('admin.product.store') }}">
                    @csrf
                    <input type="text" name="product_name" placeholder="Product Name" required/>
                    <textarea name="description" placeholder="Description"></textarea>
                    <select name="category_id" required>
                        <option value="">Select Category</option>
                        @foreach($categories as $c)
                            <option value="{{ $c->id }}">{{ $c->category_name }}</option>
                        @endforeach
                    </select>
                    <select name="supplier_id" required>
                        <option value="">Select Supplier</option>
                        @foreach($suppliers as $s)
                            <option value="{{ $s->id }}">{{ $s->supplier_name }}</option>
                        @endforeach
                    </select>
                    <input type="number" step="0.01" name="price" placeholder="Price" required/>
                    <input type="number" name="quantity" placeholder="Stock Quantity" required/>
                    <input type="number" name="min_stock_level" placeholder="Minimum Stock Alert" value="10" required/>
                    <button class="save-button" type="submit">
                        <i class="fa-solid fa-circle-check"></i> Save Product
                    </button>
                </form>
                <button id="close_modal" class="cancel-button">
                    <i class="fa-solid fa-circle-xmark"></i> Cancel
                </button>
            </div>
        </div>

       <!-- Edit Product Modal -->
        <div class="modal-container" id="edit_modal_container">
            <div class="modal">
                <div class="modal-header">
                    <h2><i class="fa-solid fa-box-open"></i> Edit Product</h2>
                </div>
                <div id="editModalBody">
                    <form method="POST" id="editProductForm">
                        @csrf
                        @method('PUT')
                            {{-- Hidden fields —always submitted, never disabled --}}
                        <input type="number" name="damage_report_id" id="edit_damage_report_id">
                            {{-- Visible / editable fields --}}
                        <input type="text" name="product_name" id="edit_product_name" placeholder="Product Name" required/>
                        <textarea name="description" id="edit_description" placeholder="Description"></textarea>
                        <select name="category_id" id="edit_category_id" required>
                            <option value="">-- Select Category --</option>
                            @foreach($categories as $c)
                                <option value="{{ $c->id }}">{{ $c->category_name }}</option>
                            @endforeach
                        </select>
                        <select name="supplier_id" id="edit_supplier_id" required>
                            <option value="">-- Select Supplier --</option>
                            @foreach($suppliers as $s)
                                <option value="{{ $s->id }}">{{ $s->supplier_name }}</option>
                            @endforeach
                        </select>
                        <input type="number" step="0.01" name="price" id="edit_price" placeholder="Price" required/>
                        <input type="hidden" name="quantity" id="edit_quantity" placeholder="Stock Quantity" readonly/>
                        <input type="number" name="min_stock_level" id="edit_min_stock" placeholder="Min Stock Alert" required/>

                        <button type="submit" class="save-button" id="editSubmitBtn">
                            <i class="fa-solid fa-circle-check"></i> Update Product
                        </button>
                    </form>
                    <button id="close_edit_modal" class="cancel-button">
                        <i class="fa-solid fa-circle-xmark"></i> Cancel
                    </button>
                </div>
            </div>
        </div>

        <!-- PRODUCTS TABLE -->
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
                    <tbody>
                        @forelse($products as $product)
                        <tr>
                            <td>{{ $product->id }}</td>
                            <td><strong>{{ $product->product_name }}</strong></td>
                            <td class="description-cell">
                                <span class="short-desc">
                                    <small>{{ Str::limit($product->description, 80) }}</small></span>
                                <span class="full-desc" style="display:none;">{{ $product->description }}</span>
                                @if(strlen($product->description) > 80)
                                    <a href="javascript:void(0)" class="toggle-description">Show more</a>
                                @endif
                            </td>
                            <td>{{ $product->category->category_name ?? 'N/A' }}</td>
                            <td><span class="price-cell">₱{{ number_format($product->price,2) }}</span></td>
                            <td>{{ $product->quantity }} <small>units</small></td>
                            <td>{{ $product->min_stock_level }} <small>units</small></td>
                            <td>
                                @if($product->quantity == 0)
                                    <span class="status-badge status-out-of-stock">
                                        <i class="fas fa-times-circle"></i> Out of Stock
                                    </span>
                                @elseif($product->quantity <= $product->min_stock_level)
                                    <span class="status-badge status-low-stock">
                                        <i class="fas fa-exclamation-triangle"></i> Low Stock
                                    </span>
                                @else
                                    <span class="status-badge status-in-stock">
                                        <i class="fas fa-check-circle"></i> In Stock
                                    </span>
                                @endif
                            </td>
                            <td>
                                <button type="button" class="edit-button" onclick="editProduct('{{ $product->id }}')">
                                    <i class="fas fa-edit"></i> Edit
                                </button>
                                <form method="POST" action="{{ route('admin.product.delete',$product->id) }}"
                                      style="display:inline;" onsubmit="return confirm('Delete this product?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="delete-button">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" style="text-align:center;padding:40px;">No products found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div id="customPagination"></div>
            <input type="hidden" id="currentPage" value="{{ $products->currentPage() }}">
            <input type="hidden" id="lastPage"    value="{{ $products->lastPage() }}">
        </div>
    </div>

    <div id="productData" style="display:none;" data-products='@json($allProducts ?? [])'></div>

    <script>
    var CSRF = document.querySelector('meta[name="csrf-token"]').content;

    // Product data for autocomplete 
    var allProducts = [];
    try { allProducts = JSON.parse(document.getElementById('productData').dataset.products); }
    catch(e) {}

    // Search / Filter
    function performSearch() {
        var q  = document.getElementById('searchInput').value.trim();
        var st = document.getElementById('filterStatus').value;
        var url = new URL(window.location.href);
        if (q)  url.searchParams.set('search', q); else url.searchParams.delete('search');
        if (st && st !== 'all') url.searchParams.set('status', st); else url.searchParams.delete('status');
        url.searchParams.delete('page');
        window.location.href = url;
    }
    function applyFilter() { performSearch(); }

    // Autocomplete
    var siEl  = document.getElementById('searchInput');
    var acDdEl = document.getElementById('autocompleteDropdown');
    var acTimer;
    function showSuggestions() {
        var q = (siEl.value || '').trim().toLowerCase();
        if (!q) { acDdEl.classList.remove('show'); return; }
        var matches = allProducts.filter(function(p){ return (p.product_name||'').toLowerCase().includes(q); }).slice(0,10);
        if (!matches.length) {
            acDdEl.innerHTML = '<div class="no-results">No products matching "' + q + '"</div>';
        } else {
            acDdEl.innerHTML = matches.map(function(p){
                var hl = p.product_name.replace(new RegExp('(' + q + ')','gi'), '<strong>$1</strong>');
                return '<div class="autocomplete-item" onclick="selectProduct(\'' + p.product_name.replace(/'/g,"\\'") + '\')">' +
                       hl + '<div class="autocomplete-price">₱' + parseFloat(p.price).toLocaleString() + '</div></div>';
            }).join('');
        }
        acDdEl.classList.add('show');
    }
    function selectProduct(name) { siEl.value = name; acDdEl.classList.remove('show'); performSearch(); }
    if (siEl) {
        siEl.addEventListener('input', function(){ clearTimeout(acTimer); acTimer = setTimeout(showSuggestions, 300); });
        siEl.addEventListener('keypress', function(e){ if (e.key==='Enter'){ acDdEl.classList.remove('show'); performSearch(); } });
    }
    document.addEventListener('click', function(e){
        if (acDdEl && siEl && !siEl.contains(e.target) && !acDdEl.contains(e.target)) acDdEl.classList.remove('show');
    });

    // Description toggle
    document.querySelectorAll('.toggle-description').forEach(function(l){
        l.onclick = function(e){
            e.preventDefault();
            var p  = this.closest('.description-cell');
            var sh = p.querySelector('.short-desc');
            var fu = p.querySelector('.full-desc');
            if (fu.style.display === 'none' || !fu.style.display) {
                sh.style.display = 'none'; fu.style.display = 'inline'; this.textContent = 'Show less';
            } else {
                sh.style.display = 'inline'; fu.style.display = 'none'; this.textContent = 'Show more';
            }
        };
    });

    // Modal helpers 
    function openModal(id)  { document.getElementById(id).classList.add('show'); }
    function closeModal(id) { document.getElementById(id).classList.remove('show'); }

    document.getElementById('open_modal').onclick    = function(){ openModal('modal_container'); };
    document.getElementById('close_modal').onclick   = function(){ closeModal('modal_container'); };
    document.getElementById('modal_container').onclick = function(e){ if(e.target===this) closeModal('modal_container'); };

    document.getElementById('close_edit_modal').onclick = function(){ closeEditModalClean(); };
    document.getElementById('edit_modal_container').onclick = function(e){ if(e.target===this) closeEditModalClean(); };

    function closeEditModalClean() {
        closeModal('edit_modal_container');
        removeDamageNotice();
        restoreAllFields();
    }

    // Toast
    function showToast(msg, color) {
        var old = document.querySelector('.toast-message');
        if (old) old.remove();
        var t = document.createElement('div');
        t.className = 'toast-message';
        t.style.background = color || '#28a745';
        t.innerHTML = '<i class="fas fa-info-circle"></i> ' + msg;
        document.body.appendChild(t);
        setTimeout(function(){ if (t.parentElement) t.remove(); }, 3500);
    }

    // Field state management
    var LOCK_FIELDS = ['edit_product_name','edit_description','edit_category_id','edit_supplier_id','edit_price','edit_min_stock'];

    function lockFieldsForDamage() {
        LOCK_FIELDS.forEach(function(id){
            var f = document.getElementById(id);
            if (!f) return;
            if (f.tagName === 'SELECT' || f.tagName === 'TEXTAREA') {
                f.classList.add('field-readonly-visual');
            } else {
                f.setAttribute('readonly', true);
                f.classList.add('field-readonly-visual');
            }
        });
        var qty = document.getElementById('edit_quantity');
        if (qty) { qty.removeAttribute('readonly'); qty.classList.remove('field-readonly-visual'); }
    }

    function restoreAllFields() {
        var all = ['edit_product_name','edit_description','edit_category_id','edit_supplier_id','edit_price','edit_min_stock','edit_quantity'];
        all.forEach(function(id){
            var f = document.getElementById(id);
            if (!f) return;
            f.removeAttribute('readonly');
            f.classList.remove('field-readonly-visual');
            f.classList.remove('damage-highlight');
        });
    }

    function removeDamageNotice() {
        var n = document.querySelector('#editModalBody .damage-notice');
        if (n) n.remove();
    }

    // Edit product (normal)
    function editProduct(productId) {
        showToast('Loading product…', '#17a2b8');
        fetch('/admin/product/' + productId + '/data', {
            headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' }
        })
        .then(function(r){ return r.json(); })
        .then(function(data){
            if (!data.success || !data.product) {
                alert('Error loading product: ' + (data.message || 'Unknown error'));
                return;
            }
            var p = data.product;
            document.getElementById('edit_product_name').value = p.product_name  || '';
            document.getElementById('edit_description').value  = p.description   || '';
            document.getElementById('edit_price').value        = p.price         || '';
            document.getElementById('edit_quantity').value     = p.quantity      || '';
            document.getElementById('edit_min_stock').value    = p.min_stock_level || '';
            document.getElementById('edit_category_id').value  = p.category_id   || '';
            document.getElementById('edit_supplier_id').value  = p.supplier_id   || '';
            document.getElementById('edit_damage_report_id').value = '';
            document.getElementById('editProductForm').action  = '/admin/product/update/' + p.id;

            removeDamageNotice();
            restoreAllFields();
            openModal('edit_modal_container');
            showToast('Product loaded!', '#28a745');
        })
        .catch(function(err){ alert('Error: ' + err.message); });
    }
    window.editProduct = editProduct;

    // Edit product for DAMAGE (from notification bell or stock-report page)
    function editProductForDamage(productId, damageQty, reportId) {
        damageQty = parseInt(damageQty) || 1;
        showToast('Loading damage report…', '#fd7e14');

        fetch('/admin/product/' + productId + '/data', {
            headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' }
        })
        .then(function(r){ return r.json(); })
        .then(function(data){
            if (!data.success || !data.product) {
                alert('Product not found');
                return;
            }
            var p = data.product;

            // Fill ALL fields so they submit correctly
            document.getElementById('edit_product_name').value = p.product_name  || '';
            document.getElementById('edit_description').value  = p.description   || '';
            document.getElementById('edit_price').value        = p.price         || '';
            document.getElementById('edit_min_stock').value    = p.min_stock_level || '';
            document.getElementById('edit_category_id').value  = p.category_id   || '';
            document.getElementById('edit_supplier_id').value  = p.supplier_id   || '';
            document.getElementById('edit_damage_report_id').value = reportId || '';

            // Set suggested quantity
            var currentStock = parseInt(p.quantity) || 0;
            var suggested    = Math.max(0, currentStock - damageQty);
            var qtyEl = document.getElementById('edit_quantity');
            qtyEl.value = suggested;
            qtyEl.setAttribute('data-original', currentStock);
            qtyEl.classList.add('damage-highlight');

            document.getElementById('editProductForm').action = '/admin/product/update/' + p.id;

            // Visually lock non-quantity fields (they are NOT disabled, just readonly)
            lockFieldsForDamage();

            // Add damage notice banner
            removeDamageNotice();
            var notice = document.createElement('div');
            notice.className = 'damage-notice';
            notice.innerHTML =
                '<i class="fas fa-exclamation-triangle"></i> <strong>DAMAGE REPORT MODE</strong><br>' +
                'Reported damage: <strong>' + damageQty + '</strong> units<br>' +
                'Current stock: <strong>' + currentStock + '</strong> → Suggested new stock: <strong>' + suggested + '</strong><br>' +
                '<small>Only the <u>Quantity</u> field is editable. All other fields are locked.</small>';
            var body = document.getElementById('editModalBody');
            body.insertBefore(notice, body.firstChild);

            openModal('edit_modal_container');
            showToast('Damage mode — only quantity is editable', '#fd7e14');
        })
        .catch(function(err){ alert('Error: ' + err.message); });
    }
    window.editProductForDamage = editProductForDamage;

    // Create PO (navigates to purchases page with URL params)
    window.createPO = function(pid, pname, rid) {
        if (confirm('Create Purchase Order for "' + pname + '"?\n\nYou will be redirected to the Purchases page.')) {
            window.location.href = '/admin/purchases?open_modal=1&product_id=' + pid
                + '&product_name=' + encodeURIComponent(pname)
                + (rid ? '&report_id=' + rid : '');
        }
    };

    // Mark report as read (bell)
    window.markRead = function(id) {
        fetch('{{ route("admin.stock.report.read") }}', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF },
            body: JSON.stringify({ report_id: id })
        })
        .then(function(r){ return r.json(); })
        .then(function(d){
            if (d.success) {
                showToast('Report marked as read', '#28a745');
                fetchNotifications();
            } else {
                showToast(d.message || 'Could not mark as read', '#dc3545');
            }
        })
        .catch(function(e){ console.error(e); });
    };

    // Check URL params for damage-mode auto-open
    (function checkUrlParams(){
        var params  = new URLSearchParams(window.location.search);
        var pid     = params.get('product_id');
        var dqty    = params.get('damage_qty');
        var rid     = params.get('report_id');
        if (pid && dqty) {
            window.history.replaceState({}, document.title, window.location.pathname);
            setTimeout(function(){ editProductForDamage(pid, parseInt(dqty), rid); }, 600);
        }
    })();

    // Notification bell
    function fetchNotifications() {
        fetch('/admin/stock-reports/notifications', {
            headers: { 'X-CSRF-TOKEN': CSRF, 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(function(r){ return r.json(); })
        .then(function(d){
            if (!d.success) return;
            var badge = document.getElementById('notifBadge');
            if (d.unread_count > 0) {
                if (!badge) {
                    badge = document.createElement('span');
                    badge.id = 'notifBadge';
                    badge.className = 'notification-badge';
                    document.getElementById('notificationBell').appendChild(badge);
                }
                badge.textContent = d.unread_count;
                badge.style.display = 'flex';
            } else {
                if (badge) badge.style.display = 'none';
            }
            renderNotifications(d.notifications);
        })
        .catch(function(e){ console.error('Notification fetch error', e); });
    }

    function renderNotifications(notifs) {
        var list = document.getElementById('notificationList');
        if (!list) return;
        if (!notifs || !notifs.length) {
            list.innerHTML = '<div class="no-notifications"><i class="fas fa-check-circle" style="font-size:2rem;margin-bottom:8px;"></i><p>No pending alerts</p></div>';
            return;
        }

        var html = '';
        notifs.forEach(function(n){
            var isDamage = n.is_damage || (n.message && n.message.includes('DAMAGE REPORT'));
            var dqty     = n.damage_quantity || 1;
            var isResolved = (n.status === 'resolved');
            var pname    = (n.product_name || '').replace(/'/g, "\\'");

            var actionBtn = '';
            if (isDamage) {
                if (isResolved) {
                    actionBtn = '<span class="resolved-badge"><i class="fas fa-check-circle"></i> Resolved</span>';
                } else {
                    actionBtn = '<button class="btn-edit-damage" onclick="editProductForDamage(' + n.product_id + ',' + dqty + ',' + n.id + ')">'
                              + '<i class="fas fa-edit"></i> Edit &amp; Reduce (' + dqty + ' units)</button>';
                }
            } else {
                actionBtn = '<button class="btn-order" onclick="createPO(' + n.product_id + ',\'' + pname + '\',' + n.id + ')">'
                          + '<i class="fas fa-shopping-cart"></i> Create PO</button>';
            }

            var stockLabel = (n.current_stock == 0)
                ? '<span style="color:#dc3545;font-weight:bold;">OUT OF STOCK</span>'
                : n.current_stock + ' units';

            html += '<div class="notification-item unread" data-id="' + n.id + '">'
                + '<div class="notification-title">'
                +   '<strong>' + (n.product_name || '') + '</strong>'
                +   '<span class="notification-time">' + (n.time_ago || '') + '</span>'
                + '</div>'
                + '<div class="notification-message">'
                +   '<b>Reported by:</b> ' + (n.user_name || '') + '<br>'
                +   '<b>Current Stock:</b> ' + stockLabel + ' (Min: ' + n.min_stock_level + ')<br>'
                +   '<small>' + ((n.message||'').substring(0,120)) + ((n.message||'').length>120?'…':'') + '</small>'
                + '</div>'
                + '<div class="notification-buttons">'
                +   actionBtn
                +   '<button class="btn-read" onclick="markRead(' + n.id + ')"><i class="fas fa-check"></i> Mark Read</button>'
                + '</div>'
                + '</div>';
        });
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

    var bellEl     = document.getElementById('notificationBell');
    var dropdownEl = document.getElementById('notificationDropdown');
    if (bellEl) {
        bellEl.onclick = function(e) {
            e.stopPropagation();
            dropdownEl.classList.toggle('show');
            if (dropdownEl.classList.contains('show')) fetchNotifications();
        };
    }
    document.addEventListener('click', function(){
        if (dropdownEl) dropdownEl.classList.remove('show');
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
    document.addEventListener('DOMContentLoaded', function(){
        renderPagination();
        fetchNotifications();
        setInterval(fetchNotifications, 30000);
    });
    </script>
</body>
</html>