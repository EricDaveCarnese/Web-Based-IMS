<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=yes"
    />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Purchases | Inventory MS</title>
    <link
        rel="icon"
        type="image/svg+xml"
        href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'%3E%3Crect width='100' height='100' fill='%232c6e62' rx='20'/%3E%3Crect x='25' y='30' width='50' height='40' fill='white' rx='5'/%3E%3Crect x='35' y='40' width='30' height='20' fill='%232c6e62' rx='3'/%3E%3C/svg%3E"
    />
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"
    />
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
            background: linear-gradient(180deg, rgb(15, 43, 61) 0%, rgb(25, 110, 114) 100%); width: 45px; 
            height: 45px; 
            border-radius: 14px; 
            display: flex; 
            align-items: center; justify-content: center; 
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
            gap: 15px; font-size: 18px; 
            margin: 0; 
            padding: 10px 25px; 
            width: 100%; 
            border-radius: 15px; border: none; 
            cursor: pointer; 
            color: rgba(189, 189, 189, 0.6); 
            transition: all 0.3s ease; 
        }
        .nav-item:hover:not(.active) { 
            background-color: rgba(60, 130, 110, 0.35); 
            color: white; height: 40px; 
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
            background: linear-gradient(45deg, rgb(44, 110, 98) 20%, #144243 50%, rgba(60, 130, 110, 0.35) 100%); flex: 1; 
            overflow-y: auto; 
            margin-left: 280px; 
            min-height: 100vh; 
            transition: all 0.3s ease; 
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
        .dashboard { 
            margin-bottom: 3px; 
            font-weight: bold; 
            font-size: 24px; 
        }
        .dashboard-sub { 
            color: gray; 
            font-size: 14px; 
            margin-top: 5px; 
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
            gap: 5px; color: white; 
        }
        .user-menu { 
            display: flex; 
            align-items: center; 
            gap: 20px; color: white;
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
            gap: 12px; font-size: 14px; 
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
            height: 40px; border-radius: 50%;
            cursor: pointer; 
            display: flex; 
            align-items: center; justify-content: center;
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
            width: 380px; background: white;
            border-radius: 12px; 
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            display: none; 
            z-index: 1000; 
            max-height: 500px; overflow: hidden;
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
            border-bottom: 1px solid #e2e8f0; cursor: pointer;
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
            justify-content: space-between; 
            flex-wrap: wrap; 
            gap: 5px;
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
        .btn-order:hover { 
            background: #1e7e34; 
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
        
        .purchase-container { 
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
        .right { 
            display: flex; 
            align-items: center; 
            gap: 15px; 
            flex-wrap: wrap; 
        }
        
        .purchase-table { 
            margin: 20px 50px; 
            background: white; 
            border-radius: 20px; 
            padding: 1.5rem; 
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08); 
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
            min-width: 900px; 
        }
        .record-table th, .record-table td { 
            padding: 14px 12px; 
            text-align: left; 
            border-bottom: 1px solid #e2e8f0; 
        }
        .record-table th { 
            background: linear-gradient(180deg, rgb(15, 43, 61) 0%, rgb(25, 110, 114) 100%); 
            color: white; 
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
        
        .badge-completed { 
            background: #28a745; 
            color: white; 
            padding: 4px 12px; 
            border-radius: 20px; 
            display: inline-block; 
            font-size: 12px; 
            font-weight: 600;
        }
        .badge-pending { 
            background: #ffc107; 
            color: #212529; 
            padding: 4px 12px; 
            border-radius: 20px; 
            display: inline-block; 
            font-size: 12px; 
            font-weight: 600;
        }
        .badge-canceled { 
            background: #dc3545; 
            color: white; 
            padding: 4px 12px; 
            border-radius: 20px; 
            display: inline-block; 
            font-size: 12px; 
            font-weight: 600;
        }
        .badge-info { 
            background: #17a2b8; 
            color: white; 
            padding: 4px 12px; 
            border-radius: 20px; 
            font-size: 11px; 
            display: inline-block; 
            font-weight: 600;
        }
        .ordered-text { 
            color: rgb(17, 180, 17); 
            font-size: 12px; 
            font-weight: 600; 
        }
        .batch-badge { 
            background: #6c757d; 
            color: white; 
            padding: 2px 8px; 
            border-radius: 20px; 
            font-size: 10px; 
            margin-left: 8px; 
        }
        
        .action-button { 
            background: #28a745; 
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
        .action-button:hover { 
            background: #218838; 
            transform: scale(1.02); 
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
            transform: scale(1.02); }
        .cancel-order-btn {
            background: #dc3545; 
            border: none; 
            color: white; 
            padding: 6px 14px; 
            border-radius: 20px; 
            cursor: pointer; 
            font-size: 12px; 
            transition: all 0.3s ease; 
            font-weight: 600;
        }
        .cancel-order-btn:hover { 
            background: #c82333; 
            transform: scale(1.02); 
        }
        .cancel-order-btn:disabled { 
            background: #6c757d !important; 
            cursor: not-allowed !important; 
            opacity: 0.6; 
        }
        
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
            cursor: pointer; 
        }
        
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
            max-width: 500px; 
            background: linear-gradient(45deg, rgb(44, 110, 98) 20%, #144243 50%);
            padding: 25px; 
            border-radius: 15px; 
            animation: modalSlideIn 0.3s ease;
            max-height: 90vh; 
            overflow-y: auto;
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
        .modal input, .modal select { 
            width: 100%; 
            padding: 12px 16px; 
            border: 1px solid #e2e8f0; 
            border-radius: 25px; 
            font-size: 14px; 
            margin-bottom: 20px; 
            background: white; 
        }
        .modal input[type="date"] { 
            cursor: pointer; 
        }
        .save-button {
            background: linear-gradient(180deg, rgb(15, 43, 61) 0%, rgb(25, 110, 114) 100%);
            border: none; 
            width: 100%; 
            font-size: 14px; 
            font-weight: 600; 
            padding: 12px;
            border-radius: 25px; 
            color: white; 
            cursor: pointer; 
            margin-bottom: 10px;
            transition: all 0.3s ease;
        }
        .save-button:hover { 
            transform: scale(1.02); 
            box-shadow: 0 4px 12px rgba(255, 255, 255, 0.259); 
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
        
        .price-warning { 
            background: rgba(255, 193, 7, 0.2); 
            border-left: 3px solid #ffc107; 
            padding: 10px; 
            border-radius: 8px; 
            margin-bottom: 15px; 
            font-size: 12px; 
            display: none; 
        }
        .price-warning.higher { 
            background: rgba(220, 53, 69, 0.2); 
            border-left-color: #dc3545; 
            color: #dc3545; 
        }
        .price-warning.lower { 
            background: rgba(40, 167, 69, 0.2); 
            border-left-color: #28a745; 
            color: #28a745; 
        }
        .input-hint { 
            color: rgba(255, 255, 255, 0.7); 
            font-size: 11px; 
            margin-top: -15px; 
            margin-bottom: 15px; 
            display: block; 
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
        .cancel-info { 
            background: rgba(255, 193, 7, 0.2); 
            border-left: 3px solid #ffc107; 
            padding: 12px; 
            border-radius: 8px; 
            margin-top: 10px; 
        }
        .price-drop-info { 
            background: rgba(220, 53, 69, 0.2); 
            border-left: 3px solid #dc3545; 
            padding: 12px; 
            border-radius: 8px; 
            margin-top: 10px; 
        }
        .prefill-notice { 
            background: #28a745; 
            color: white; 
            padding: 12px; 
            border-radius: 8px; 
            margin-bottom: 15px; 
            text-align: center; 
            font-size: 14px; 
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
            cursor: default; 
        }
        .custom-pagination .page-dots { 
            color: #a0aec0; 
            cursor: default; 
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
            .page-title { 
                margin-left: 20px; 
            }
            .page-title h1 { 
                font-size: 1.3rem; 
            }
        }
        @media (max-width: 860px) { 
            .purchase-container { 
                margin: 20px; 
                flex-direction: column; 
                align-items: stretch; 
            }
            .search-container { 
                max-width: 100%; 
            }
            .right { 
                justify-content: space-between; 
                width: 100%; 
            }
            .new-purchase { 
                width: auto; 
            }
            .purchase-table { 
                margin: 20px; 
                padding: 1rem; 
            } 
            .table-container { 
                max-height: 400px; 
            } 
            .notification-dropdown { 
                width: 320px; 
                right: -10px; 
            }
            .alert-success, .alert-error { 
                margin: 20px; 
            }
            .topheader { 
                padding: 15px; }
            .user-menu {
                margin-right: 15px; 
                gap: 12px; 
            }
        }
        @media (max-width: 768px) {
            .dashboard { 
                font-size: 20px; 
            }
            .dashboard-sub { 
                font-size: 12px; 
            }
            .recordcount { 
                font-size: 12px; 
                padding: 8px 14px; 
            }
            .new-purchase { 
                font-size: 14px; 
                padding: 8px 16px; 
            }
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
            .notification-dropdown { 
                width: 280px; 
                right: -20px; 
            }
            .notification-item { 
                padding: 10px; 
            }
            .notification-buttons button { 
                padding: 3px 8px; 
                font-size: 9px; 
            }
        }
        @media (max-width: 480px) { 
            .purchase-table { 
                margin: 15px; 
                padding: 0.8rem; 
            } 
            .record-table th, .record-table td { 
                font-size: 0.7rem; 
                padding: 8px 6px; 
            }
            .view-details-btn, .action-button, .cancel-order-btn { 
                padding: 3px 8px; 
                font-size: 9px; 
                margin-right: 2px; 
            }
            .batch-badge { 
                font-size: 8px; 
                padding: 1px 4px; 
            }
            .notification-dropdown { 
                width: 260px; 
                right: -30px; 
            }
            .modal { 
                max-width: 95%; 
                padding: 15px; 
            }
            .modal input, .modal select { 
                padding: 10px 12px; 
                font-size: 13px; 
                margin-bottom: 15px; 
            }
            .save-button, .cancel-modal-btn { 
                padding: 10px; 
                font-size: 13px; 
            }
            .logout-btn { 
                padding: 6px 14px; 
                font-size: 12px; 
            }
            .user-menu { 
                gap: 8px; 
                margin-right: 10px; 
            }
            .notification-bell { 
                width: 35px; 
                height: 35px; 
                font-size: 14px; 
            }
        }
        @media (max-width: 380px) {
            .recordcount strong { 
                font-size: 11px; 
            }
            .recordcount .count { 
                font-size: 10px; 
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
            .purchase-table { 
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
                <div class="nav-item active">
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

    <div class="main-content">
        <div class="topheader">
            <div class="page-title">
                <h1 class="dashboard">Purchase Orders</h1>
                <p class="dashboard-sub">Create and manage purchase orders with batch tracking</p>
            </div>
            <div class="user-menu">
                @php 
                    $pendingStockReportsCount = \App\Models\StockReport::where('status', 'pending')->where('notify_users', false)->count(); 
                @endphp
                <div class="notification-area">
                    <button class="notification-bell" id="notificationBell">
                        <i class="fas fa-bell"></i>
                        @if ($pendingStockReportsCount > 0)
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

        <div id="supplierData" style="display: none" data-suppliers='@json($allSuppliers ?? [])'></div>
        <div id="purchaseOrdersData" style="display: none" data-purchases='@json($allPurchases ?? [])'></div>

        <div class="purchase-view">
            <div class="purchase-container">
                <div class="search-container">
                    <div class="search-wrapper">
                        <input type="text" id="searchInput" class="search-input" placeholder="Search by batch #, or supplier..." autocomplete="off" value="{{ request('search') }}"/>
                        <button class="search-btn" onclick="performSearch()">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                    <div id="autocompleteDropdown" class="autocomplete-dropdown"></div>
                </div>
                <div class="right">
                    <div class="recordcount">
                        <span class="count">Total PO: </span>
                        <strong>{{ $purchases->total() }}</strong>
                    </div>
                    <div class="add-button">
                        <button id="open_modal" class="new-purchase">
                            <i class="fas fa-plus"></i>
                            <span>New Purchase Order</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Add Purchase Modal -->
            <div class="modal-container" id="modal_container">
                <div class="modal">
                    <div class="modal-header">
                        <h2>
                            <i class="fa-solid fa-folder-open"></i> New Purchase Order
                        </h2>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="{{ route('admin.purchase.store') }}" id="purchaseForm">
                            @csrf
                            <input type="hidden" name="report_id" id="report_id_input" value="" />
                            <select name="supplier_id" id="supplier_select" required >
                                <option value="">Select Supplier</option>
                                @foreach ($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}" data-supplier-name="{{ $supplier->supplier_name }}" > 
                                        {{ $supplier->supplier_name }}
                                    </option>
                                @endforeach
                            </select>
                            <select name="product_id" id="product_select" required >
                                <option value="">Select Product</option>
                                @foreach ($products as $product)
                                    <option value="{{ $product->id }}" data-price="{{ $product->price }}" data-product-name="{{ $product->product_name }}" data-supplier-id="{{ $product->supplier_id }}" data-supplier-name="{{ $product->supplier->supplier_name ?? '' }}" >
                                        {{ $product->product_name }} (Current Stock: {{ $product->quantity }}) - ₱{{ number_format($product->price, 2) }}
                                    </option>
                                @endforeach
                            </select>
                            <input type="number" name="quantity" id="quantity_input" placeholder="Quantity" required />
                            <input type="number" step="0.01" name="cost_price" id="cost_price_input" placeholder="Cost per unit" required />
                            <div id="priceWarning" class="price-warning"></div>
                                <small class="input-hint">
                                    <i class="fas fa-info-circle"></i> Current
                                    product price auto-filled. You can adjust if
                                    supplier price changed.
                                </small>
                            <input type="date" name="due_date" id="due_date_input" required />
                            <small class="input-hint">
                                <i class="fas fa-calendar-alt"></i> 
                                Set deadline for cancellation
                            </small>
                            <button class="save-button" type="submit">
                                <i class="fa-solid fa-circle-check"></i> Create Order
                            </button>
                        </form>
                        <button id="close_modal" class="cancel-modal-btn">
                            <i class="fa-solid fa-circle-xmark"></i> Cancel
                        </button>
                    </div>
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
                        <div id="cancel_info_container" class="cancel-info" style="display: none; margin: 10px" >
                            <span id="cancel_info_text"></span>
                        </div>
                        <div id="price_drop_container" class="price-drop-info" style="display: none" >
                            <span id="price_drop_text"></span>
                        </div>
                        <button id="close_details_modal" class="cancel-modal-btn" >
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
                                <th>Batch #</th>
                                <th>PO #</th>
                                <th>Supplier</th>
                                <th>Order Date</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($purchases as $purchase)
                                <tr>
                                    <td><span>#{{ $purchase->id }}</span></td>
                                    <td>
                                        <span class="batch-badge" >
                                            {{ $purchase->batch_number ?? 'BATCH-' . str_pad($purchase->id, 4, '0', STR_PAD_LEFT) }}
                                        </span>
                                    </td>
                                    <td>
                                        <strong>{{ $purchase->supplier->supplier_name ?? 'N/A' }}</strong>
                                    </td>
                                    <td>
                                        <span>
                                            {{ $purchase->purchase_date ? $purchase->purchase_date->format('M j, Y g:i A') : 'N/A' }}
                                        </span>
                                    </td>
                                    <td>
                                        <span>
                                            ₱{{ number_format($purchase->purchaseDetails->sum(function($detail) { return $detail->quantity * $detail->cost_price; }), 2) }}
                                        </span>
                                    </td>
                                    <td>
                                        <span>
                                            @if ($purchase->status == 'completed')
                                                <span class="badge-completed">
                                                    <i class="fa-solid fa-check"></i> Completed
                                                </span>
                                            @elseif ($purchase->status == 'pending')
                                                <span class="badge-pending">
                                                    <i class="fa-solid fa-spinner"></i> Pending
                                                </span>
                                            @else
                                                <span class="badge-canceled">
                                                    <i class="fa-solid fa-ban"></i> Canceled
                                                </span>
                                            @endif
                                        </span>
                                    </td>
                                    <td>
                                        <span>
                                            <button class="view-details-btn" onclick="viewPurchaseDetails('{{ $purchase->id }}')" >
                                                <i class="fas fa-eye"></i> View
                                            </button>
                                            @if ($purchase->status == 'pending')
                                                <form method="POST" action="{{ route('admin.purchase.complete', $purchase->id) }}" style="display: inline">
                                                    @csrf
                                                    <button type="submit" class="action-button" onclick=" return confirm('Complete this purchase order?\n\nThis will add stock to inventoryremove low stock alerts.',);">
                                                        <i class="fa-solid fa-circle-check"></i>Receive
                                                    </button>
                                                </form>
                                                @php 
                                                    $dueDate = $purchase->due_date ? \Carbon\Carbon::parse($purchase->due_date) : null; $canCancel = $dueDate ? $dueDate->isPast() : true; 
                                                @endphp
                                                <form method="POST" action="{{ route('admin.purchase.cancel', $purchase->id) }}" style="display: inline" >
                                                    @csrf
                                                    <button type="submit" class="cancel-order-btn" onclick=" return confirm('Cancel this purchase order?',);"{{ !$canCancel ? 'disabled' : '' }}>
                                                        <i class="fa-solid fa-circle-xmark" ></i>
                                                        Cancel
                                                    </button>
                                                </form>
                                            @elseif ($purchase->status == 'completed')
                                                <span class="ordered-text">
                                                    <i class="fas fa-check-double" ></i>Received
                                                </span>
                                            @else
                                                <span class="ordered-text" style="color: #dc3545;font-size: 12px;">
                                                    <i class="fas fa-ban"></i>Canceled
                                                </span>
                                            @endif
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" style="text-align: center; padding: 40px;">
                                        <i class="fas fa-shopping-cart" style="font-size: 48px; color: #ccc;"></i>
                                        <p style="margin-top: 10px;">No purchase orders found</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="pagination-container" id="customPagination"></div>
                <input type="hidden" id="currentPage" value="{{ $purchases->currentPage() }}" />
                <input type="hidden" id="lastPage" value="{{ $purchases->lastPage() }}" />
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

        //  UTILITY FUNCTIONS
        function escapeHtml(text) {
            if (!text) return '';
            var div = document.createElement('div');
            div.textContent = text;
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
            setTimeout(function () {
                if (toast.parentElement) toast.remove();
            }, 3000);
        }

        document.addEventListener('DOMContentLoaded', function () {
            var supplierSelect = document.getElementById('supplier_select');
            var productSelect = document.getElementById('product_select');
            var costPriceInput = document.getElementById('cost_price_input');
            var priceWarningDiv = document.getElementById('priceWarning');
            var dueDateInput = document.getElementById('due_date_input');
            var quantityInput = document.getElementById('quantity_input');

            var allProductOptions = [];
            if (productSelect) {
                for (var i = 0; i < productSelect.options.length; i++) {
                    allProductOptions.push({
                        value: productSelect.options[i].value,
                        text: productSelect.options[i].text,
                        price: productSelect.options[i].getAttribute('data-price'),
                        productName:
                            productSelect.options[i].getAttribute('data-product-name'),
                        supplierId:
                            productSelect.options[i].getAttribute('data-supplier-id'),
                        supplierName:
                            productSelect.options[i].getAttribute('data-supplier-name'),
                    });
                }
            }

            var originalProductPrice = 0;
            var currentProductName = '';

            //FILTER PRODUCTS BY SUPPLIER 
            function filterProductsBySupplier() {
                if (!productSelect || !supplierSelect) return;
                var selectedSupplierId = supplierSelect.value;
                productSelect.innerHTML = '';
                var hasProducts = false;
                for (var i = 0; i < allProductOptions.length; i++) {
                    var product = allProductOptions[i];
                    if (
                        !selectedSupplierId ||
                        product.supplierId == selectedSupplierId
                    ) {
                        var option = document.createElement('option');
                        option.value = product.value;
                        option.text = product.text;
                        option.setAttribute('data-price', product.price);
                        option.setAttribute('data-product-name', product.productName);
                        option.setAttribute('data-supplier-id', product.supplierId);
                        option.setAttribute('data-supplier-name', product.supplierName);
                        productSelect.appendChild(option);
                        hasProducts = true;
                    }
                }
                var defaultOption = document.createElement('option');
                defaultOption.value = '';
                defaultOption.text = 'Select Product';
                defaultOption.selected = true;
                productSelect.insertBefore(defaultOption, productSelect.firstChild);
                if (costPriceInput) {
                    costPriceInput.value = '';
                    originalProductPrice = 0;
                }
                if (priceWarningDiv) priceWarningDiv.style.display = 'none';
                if (!hasProducts && selectedSupplierId) {
                    productSelect.innerHTML = '';
                    var noProductOption = document.createElement('option');
                    noProductOption.value = '';
                    noProductOption.text = '-- No products found for this supplier --';
                    noProductOption.disabled = true;
                    noProductOption.selected = true;
                    productSelect.appendChild(noProductOption);
                }
            }

            //AUTO-FILL SUPPLIER AND PRICE FROM PRODUCT
            function autoFillSupplierFromProduct() {
                if (!productSelect || !supplierSelect) return;
                var selectedOption = productSelect.options[productSelect.selectedIndex];
                if (!selectedOption || !selectedOption.value) return;
                var productSupplierId = selectedOption.getAttribute('data-supplier-id');
                var productSupplierName =
                    selectedOption.getAttribute('data-supplier-name');
                var productPrice = selectedOption.getAttribute('data-price');
                var productName = selectedOption.getAttribute('data-product-name');
                if (productSupplierId) {
                    for (var i = 0; i < supplierSelect.options.length; i++) {
                        if (supplierSelect.options[i].value == productSupplierId) {
                            supplierSelect.selectedIndex = i;
                            showToast( 'Supplier auto-filled: ' +
                                (productSupplierName || 'Supplier'), '#17a2b8',
                            );
                            break;
                        }
                    }
                }
                if (productPrice) {
                    originalProductPrice = parseFloat(productPrice);
                    currentProductName = productName;
                    costPriceInput.value = productPrice;
                    costPriceInput.style.borderColor = '#28a745';
                    setTimeout(function () {
                        costPriceInput.style.borderColor = '#e2e8f0';
                    }, 2000);
                    showToast( 'Price auto-filled: ₱' +
                            parseFloat(productPrice).toLocaleString(undefined, {
                                minimumFractionDigits: 2,
                            }), '#17a2b8',
                    );
                }
                if (priceWarningDiv) priceWarningDiv.style.display = 'none';
            }

            //PRICE COMPARISON WARNING 
            function updatePriceWarning(enteredPrice, originalPrice, productName) {
                if (!priceWarningDiv) return;
                if (
                    enteredPrice &&
                    originalPrice &&
                    parseFloat(enteredPrice) !== parseFloat(originalPrice)
                ) {
                    priceWarningDiv.style.display = 'block';
                    if (parseFloat(enteredPrice) > parseFloat(originalPrice)) {
                        priceWarningDiv.className = 'price-warning higher';
                        priceWarningDiv.innerHTML = '<i class="fas fa-arrow-up"></i> Price INCREASED: ₱' +
                            parseFloat(enteredPrice).toLocaleString() + ' vs current ₱' +
                            parseFloat(originalPrice).toLocaleString() + ' (+' +
                            (parseFloat(enteredPrice) - parseFloat(originalPrice)).toLocaleString() + ')';
                    } else {
                        priceWarningDiv.className = 'price-warning lower';
                        priceWarningDiv.innerHTML = '<i class="fas fa-arrow-down"></i> Price DROP: ₱' +
                            parseFloat(enteredPrice).toLocaleString() + ' vs current ₱' +
                            parseFloat(originalPrice).toLocaleString() + ' (Save ₱' +
                            (parseFloat(originalPrice) - parseFloat(enteredPrice)).toLocaleString() + ')';
                    }
                } else if (
                    enteredPrice &&
                    originalPrice &&
                    parseFloat(enteredPrice) === parseFloat(originalPrice)) 
                {
                    priceWarningDiv.style.display = 'block';
                    priceWarningDiv.className = 'price-warning';
                    priceWarningDiv.innerHTML = '<i class="fas fa-check-circle"></i> Price matches current product price (₱' +
                        parseFloat(originalPrice).toLocaleString() + ')';
                } else {
                    priceWarningDiv.style.display = 'none';
                }
            }

            if (supplierSelect)
                supplierSelect.addEventListener('change', filterProductsBySupplier);
            if (productSelect)
                productSelect.addEventListener('change', autoFillSupplierFromProduct);
            if (costPriceInput) {
                costPriceInput.addEventListener('input', function () {
                    updatePriceWarning(
                        this.value,
                        originalProductPrice,
                        currentProductName,
                    );
                });
            }

            //AUTO-OPEN MODAL FROM STOCK REPORT
            function checkAndOpenModalFromStockReport() {
                var urlParams = new URLSearchParams(window.location.search);
                var openModalParam = urlParams.get('open_modal');
                var productIdParam = urlParams.get('product_id');
                var productNameParam = urlParams.get('product_name');
                var reportIdParam = urlParams.get('report_id');
                var prefillProductId = sessionStorage.getItem('prefill_product_id');
                var prefillProductName = sessionStorage.getItem('prefill_product_name');
                var prefillReportId = sessionStorage.getItem('prefill_report_id');
                var prefillFromStockReport = sessionStorage.getItem(
                    'prefill_from_stock_report',
                );
                var finalProductId = productIdParam || prefillProductId;
                var finalProductName = productNameParam || prefillProductName;
                var finalReportId = reportIdParam || prefillReportId;
                if ((openModalParam === '1' || finalProductId) && finalProductId) {
                    var modal = document.getElementById('modal_container');
                    var reportIdInput = document.getElementById('report_id_input');
                    if (modal) {
                        modal.classList.add('show');
                        setTimeout(function () {
                            if (productSelect) {
                                filterProductsBySupplier();
                                for (var i = 0; i < productSelect.options.length; i++) {
                                    if (
                                        productSelect.options[i].value == finalProductId ) 
                                    {
                                        productSelect.selectedIndex = i;
                                        var changeEvent = new Event('change');
                                        productSelect.dispatchEvent(changeEvent);
                                        break;
                                    }
                                }
                            }
                            if (reportIdInput && finalReportId)
                                reportIdInput.value = finalReportId;
                            var modalBody = document.querySelector( '#modal_container .modal-body', );
                            var existingNote = modalBody ? modalBody.querySelector('.prefill-notice') : null;
                            if (modalBody && !existingNote) {
                                var productNameSpan = document.createElement('div');
                                productNameSpan.className = 'prefill-notice';
                                productNameSpan.innerHTML = '<i class="fas fa-info-circle"></i> <strong>' +
                                    (prefillFromStockReport === 'true' ? 'Creating purchase order from Stock Report' : 'Creating purchase order') + ' for: ' +
                                    (finalProductName || 'Product') + '</strong>';
                                modalBody.insertBefore(
                                    productNameSpan,
                                    modalBody.firstChild,
                                );
                            }
                            showToast( 'Product pre-filled: ' + (finalProductName || 'Product'), '#28a745', );
                        }, 300);
                    }
                    sessionStorage.removeItem('prefill_product_id');
                    sessionStorage.removeItem('prefill_product_name');
                    sessionStorage.removeItem('prefill_report_id');
                    sessionStorage.removeItem('prefill_from_stock_report');
                    var newUrl = window.location.pathname;
                    window.history.replaceState({}, document.title, newUrl);
                }
            }

            if (dueDateInput) {
                var tomorrow = new Date();
                tomorrow.setDate(tomorrow.getDate() + 1);
                var yyyy = tomorrow.getFullYear();
                var mm = String(tomorrow.getMonth() + 1).padStart(2, '0');
                var dd = String(tomorrow.getDate()).padStart(2, '0');
                dueDateInput.min = yyyy + '-' + mm + '-' + dd;
            }

            var allPurchaseOrders = [];
            var purchaseOrdersDataEl = document.getElementById('purchaseOrdersData');
            if (purchaseOrdersDataEl) {
                try {
                    var purchasesJson =
                        purchaseOrdersDataEl.getAttribute('data-purchases');
                    if (purchasesJson) {
                        allPurchaseOrders = JSON.parse(purchasesJson);
                    }
                } catch (e) {
                    console.error('Error parsing purchase orders:', e);
                }
            }

            var allSuppliers = [];
            var supplierDataElement = document.getElementById('supplierData');
            if (supplierDataElement) {
                try {
                    allSuppliers = JSON.parse(
                        supplierDataElement.getAttribute('data-suppliers'),
                    );
                } catch (e) {
                    allSuppliers = [];
                }
            }

            var searchInput = document.getElementById('searchInput');
            var autocompleteDropdown = document.getElementById('autocompleteDropdown');
            var searchTimeout;

            window.showSuggestions = function () {
                if (!searchInput) return;
                var query = searchInput.value.trim().toLowerCase();
                if (query.length === 0) {
                    if (autocompleteDropdown)
                        autocompleteDropdown.classList.remove('show');
                    return;
                }

                var matches = [];
                var isNumber = /^\d+$/.test(query);

                if (allPurchaseOrders && allPurchaseOrders.length > 0) {
                    for (var i = 0; i < allPurchaseOrders.length; i++) {
                        var po = allPurchaseOrders[i];
                        if (!po) continue;
                        var poNumber = String(po.id || '');
                        var batchNumber = (po.batch_number || '').toLowerCase();
                        var supplierName = (po.supplier_name || '').toLowerCase();

                        if (isNumber && poNumber.includes(query)) {
                            matches.push({
                                type: 'po',
                                id: po.id,
                                value: '#' + po.id,
                                label: 'PO #' + po.id,
                                batch: po.batch_number,
                                supplier: po.supplier_name,
                            });
                        } else if (batchNumber.includes(query)) {
                            matches.push({
                                type: 'batch',
                                id: po.id,
                                value: po.batch_number,
                                label: 'Batch: ' + po.batch_number,
                                batch: po.batch_number,
                                supplier: po.supplier_name,
                            });
                        } else if (supplierName.includes(query)) {
                            matches.push({
                                type: 'supplier',
                                id: po.id,
                                value: po.supplier_name,
                                label: 'Supplier: ' + po.supplier_name,
                                batch: po.batch_number,
                                supplier: po.supplier_name,
                            });
                        }
                        if (matches.length >= 10) break;
                    }
                }

                if (allSuppliers && allSuppliers.length > 0) {
                    for (var i = 0; i < allSuppliers.length; i++) {
                        var supplier = allSuppliers[i];
                        if (!supplier) continue;
                        var supplierName = (supplier.supplier_name || '').toLowerCase();
                        if (
                            supplierName.includes(query) &&
                            !matches.some(function (m) {
                                return m.value === supplier.supplier_name;
                            })
                        ) {
                            matches.push({
                                type: 'supplier_only',
                                id: supplier.id,
                                value: supplier.supplier_name,
                                label: 'Supplier: ' + supplier.supplier_name,
                                batch: null,
                                supplier: supplier.supplier_name,
                            });
                        }
                        if (matches.length >= 10) break;
                    }
                }

                if (matches.length > 0 && autocompleteDropdown) {
                    var html = '';
                    for (var i = 0; i < matches.length; i++) {
                        var m = matches[i];
                        var highlightedValue = m.value.replace(
                            new RegExp( '(' + query.replace(/[.*+?^${}()|[\]\\]/g, '\\$&') + ')', 'gi', ), '<strong>$1</strong>',
                        );
                        html += '<div class="autocomplete-item" onclick="selectPOSuggestion(\'' +
                            m.value.replace(/'/g, "\\'") + '\')"><div> ' +
                            highlightedValue + '</div></div>';
                    }
                    autocompleteDropdown.innerHTML = html;
                    autocompleteDropdown.classList.add('show');
                } else if (autocompleteDropdown) {
                    autocompleteDropdown.innerHTML = '<div class="no-results">No results found matching "' +
                        escapeHtml(query) + '"</div>';
                    autocompleteDropdown.classList.add('show');
                }
            };

            window.selectPOSuggestion = function (value) {
                if (searchInput) searchInput.value = value;
                if (autocompleteDropdown) autocompleteDropdown.classList.remove('show');
                performSearch();
            };

            window.performSearch = function () {
                if (!searchInput) return;
                var query = searchInput.value.trim();
                var url = new URL(window.location.href);
                if (query) {
                    url.searchParams.set('search', query);
                } else {
                    url.searchParams.delete('search');
                }
                url.searchParams.set('page', '1');
                window.location.href = url.toString();
            };

            if (searchInput) {
                searchInput.addEventListener('input', function () {
                    clearTimeout(searchTimeout);
                    searchTimeout = setTimeout(window.showSuggestions, 300);
                });
                document.addEventListener('click', function (e) {
                    if (
                        autocompleteDropdown &&
                        searchInput &&
                        !searchInput.contains(e.target) &&
                        !autocompleteDropdown.contains(e.target)
                    ) {
                        autocompleteDropdown.classList.remove('show');
                    }
                });
                searchInput.addEventListener('keypress', function (e) {
                    if (e.key === 'Enter') {
                        if (autocompleteDropdown)
                            autocompleteDropdown.classList.remove('show');
                        performSearch();
                    }
                });
            }

            //MODAL CONTROLS
            var openModal = document.getElementById('open_modal');
            var modalContainer = document.getElementById('modal_container');
            var closeModalBtn = document.getElementById('close_modal');
            if (openModal) {
                openModal.onclick = function () {
                    if (supplierSelect) supplierSelect.value = '';
                    if (productSelect) filterProductsBySupplier();
                    if (costPriceInput) costPriceInput.value = '';
                    if (dueDateInput) dueDateInput.value = '';
                    if (quantityInput) quantityInput.value = '';
                    if (priceWarningDiv) priceWarningDiv.style.display = 'none';
                    originalProductPrice = 0;
                    modalContainer.classList.add('show');
                };
            }
            if (closeModalBtn)
                closeModalBtn.onclick = function () {
                    modalContainer.classList.remove('show');
                };
            if (modalContainer)
                modalContainer.onclick = function (e) {
                    if (e.target === modalContainer)
                        modalContainer.classList.remove('show');
                };

            //VIEW DETAILS MODAL
            var viewDetailsModal = document.getElementById('view_details_modal');
            var closeDetailsModal = document.getElementById('close_details_modal');
            if (closeDetailsModal)
                closeDetailsModal.onclick = function () {
                    viewDetailsModal.classList.remove('show');
                };
            if (viewDetailsModal)
                viewDetailsModal.onclick = function (e) {
                    if (e.target === viewDetailsModal)
                        viewDetailsModal.classList.remove('show');
                };

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
                document.getElementById('cancel_info_container').style.display = 'none';
                document.getElementById('price_drop_container').style.display = 'none';

                fetch('/admin/purchase/details/' + id, {
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
                            document.getElementById('detail_batch_number').innerHTML =
                                'Error loading';
                            return;
                        }

                        document.getElementById('detail_batch_number').innerHTML = data.batch_number || 'N/A';
                        document.getElementById('detail_supplier').innerHTML = data.supplier_name || 'N/A';
                        document.getElementById('detail_order_date').innerHTML = data.order_date || 'N/A';
                        document.getElementById('detail_due_date').innerHTML = data.due_date || 'N/A';
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
                            statusBadge =
                                '<span class="badge-success">Completed</span>';
                        else if (data.status === 'pending')
                            statusBadge = '<span class="badge-warning">Pending</span>';
                        else statusBadge = '<span class="badge-danger">Canceled</span>';
                        document.getElementById('detail_status').innerHTML =
                            statusBadge;

                        if (
                            data.status === 'pending' &&
                            data.due_date &&
                            data.due_date !== 'Not set' ) {
                            document.getElementById('cancel_info_text').innerHTML = '<i class="fas fa-info-circle"></i> Cancellation available after: ' + data.due_date;
                            document.getElementById('cancel_info_container' ,).style.display = 'block';
                        }
                    })
                    .catch(function (error) {
                        console.error('Error:', error);
                        document.getElementById('detail_batch_number').innerHTML =
                            'Error loading details';
                    });
            };

            //CUSTOM PAGINATION
            function renderPagination() {
                var currentPage = parseInt(
                    document.getElementById('currentPage').value,
                );
                var lastPage = parseInt(document.getElementById('lastPage').value);
                var paginationContainer = document.getElementById('customPagination');
                if (!paginationContainer || lastPage <= 1) return;
                var html = '<div class="custom-pagination">';
                if (currentPage > 1) {
                    html += '<a href="#" class="page-link" data-page="' + (currentPage - 1) + '">&lt;</a>';
                } else {
                    html += '<span class="page-disabled">&lt;</span>';
                }
                var startPage = Math.max(1, currentPage - 2);
                var endPage = Math.min(lastPage, currentPage + 2);
                if (currentPage <= 3) {
                    endPage = Math.min(lastPage, 5);
                }
                if (currentPage >= lastPage - 2) {
                    startPage = Math.max(1, lastPage - 4);
                }
                if (startPage > 1) {
                    html += '<a href="#" class="page-link" data-page="1">1</a>';
                    if (startPage > 2) {
                        html += '<span class="page-dots">...</span>';
                    }
                }
                for (var i = startPage; i <= endPage; i++) {
                    if (i === currentPage) {
                        html += '<span class="page-active">' + i + '</span>';
                    } else {
                        html += '<a href="#" class="page-link" data-page="' + i + '">' + i + '</a>';
                    }
                }
                if (endPage < lastPage) {
                    if (endPage < lastPage - 1) {
                        html += '<span class="page-dots">...</span>';
                    }
                    html += '<a href="#" class="page-link" data-page="' +
                        lastPage + '">' +
                        lastPage + '</a>';
                }
                if (currentPage < lastPage) {
                    html += '<a href="#" class="page-link" data-page="' +
                        (currentPage + 1) + '">&gt;</a>';
                } else {
                    html += '<span class="page-disabled">&gt;</span>';
                }
                html += '</div>';
                paginationContainer.innerHTML = html;
                var pageLinks = document.querySelectorAll('.page-link');
                for (var i = 0; i < pageLinks.length; i++) {
                    pageLinks[i].addEventListener('click', function (e) {
                        e.preventDefault();
                        var page = this.getAttribute('data-page');
                        if (page) {
                            var urlParams = new URLSearchParams(window.location.search);
                            urlParams.set('page', page);
                            window.location.href =
                                window.location.pathname + '?' + urlParams.toString();
                        }
                    });
                }
            }
            renderPagination();

            setTimeout(checkAndOpenModalFromStockReport, 500);

            function fetchNotifications() {
                fetch('/admin/stock-reports/notifications', {
                    method: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                })
                    .then(function (response) {
                        return response.json();
                    })
                    .then(function (data) {
                        if (data.success) {
                            updateNotificationBell(data.unread_count);
                            renderNotificationDropdown(data.notifications);
                        }
                    })
                    .catch(function (error) {
                        console.error('Error:', error);
                    });
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
                    list.innerHTML =
                        '<div class="no-notifications"><i class="fas fa-check-circle" style="font-size: 32px; margin-bottom: 10px;"></i><p>No pending stock reports</p></div>';
                    return;
                }
                var html = '';
                for (var i = 0; i < notifications.length; i++) {
                    var notif = notifications[i];
                    var isDamage =
                        notif.message && notif.message.includes('DAMAGE REPORT');
                    var isSystemAlert = notif.user_name === 'System (Auto Alert)';
                    var isOutOfStock = notif.current_stock === 0;
                    var stockColor = isOutOfStock ? '#dc3545' : 
                        notif.current_stock <= notif.min_stock_level  ? '#fd7e14'  : '#28a745';
                    var actionButton = '';

                    if (isDamage) {
                        if (notif.is_resolved) {
                            actionButton =
                                '<span class="resolved-badge"><i class="fas fa-check-circle"></i> Resolved</span>';
                        } else {
                            var damageQty = notif.damage_quantity || 1;
                            actionButton = '<button class="btn-edit-damage" onclick="editProductAndReduceStock(' +
                                notif.product_id + ", '" +
                                escapeHtml(notif.product_name).replace(/'/g, "\\'") + "', " +
                                damageQty + ', ' +
                                notif.id + ')"><i class="fas fa-edit"></i> Edit & Reduce (' +
                                damageQty + ' units)</button>';
                        }
                    } else {
                        actionButton = '<button class="btn-order" onclick="createPurchaseOrder(' +
                            notif.product_id + ", '" +
                            escapeHtml(notif.product_name).replace(/'/g, "\\'") + "', " +
                            notif.id + ')"><i class="fas fa-shopping-cart"></i> ' +
                            (isSystemAlert ? 'Restock Now' : 'Create PO') + '</button>';
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

            //FIXED FUNCTIONS FOR NOTIFICATION BUTTONS
            window.createPurchaseOrder = function (productId, productName, reportId) {
                if (confirm('Create purchase order for "' + productName + '"?')) {
                    sessionStorage.setItem('prefill_product_id', productId);
                    sessionStorage.setItem('prefill_product_name', productName);
                    sessionStorage.setItem('prefill_report_id', reportId);
                    sessionStorage.setItem('prefill_from_stock_report', 'true');
                    window.location.href = '/admin/purchases?open_modal=1&product_id=' + productId + '&product_name=' + encodeURIComponent(productName) + '&report_id=' + reportId;
                }
            };
            window.editProductAndReduceStock = function ( productId, productName, damageQuantity, reportId,) 
                {
                if (confirm( 'Product: ' + productName + '\nDamaged Quantity: ' + damageQuantity + ' units\n\nClick OK to edit product and reduce stock by ' + damageQuantity + ' units.', )) 
                { 
                    window.location.href = '/admin/products?edit_damage=1&product_id=' + productId + '&damage_qty=' + damageQuantity + '&report_id=' + reportId;
                }
            };
            window.markAsRead = markAsRead;
            //NOTIFICATION BELL TOGGLE
            var bell = document.getElementById('notificationBell');
            var dropdown = document.getElementById('notificationDropdown');
            if (bell) {
                bell.addEventListener('click', function (e) {
                    e.stopPropagation();
                    dropdown.classList.toggle('show');
                    if (dropdown.classList.contains('show')) fetchNotifications();
                });
            }
            document.addEventListener('click', function () {
                if (dropdown) dropdown.classList.remove('show');
            });
            
            autoCloseSessionAlerts();
            renderPagination();
            fetchNotifications();
            setInterval(fetchNotifications, 10000);
        });
    </script>
</body>
</html>
