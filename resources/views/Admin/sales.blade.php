<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Sales | Inventory MS</title>
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
            background: linear-gradient(180deg, rgb(15,43,61) 0%, rgb(10,30,44) 100%);
            color: rgba(233,241,247); 
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
            background: linear-gradient(180deg, rgb(15,43,61) 0%, rgb(25,110,114) 100%);
            color: white; 
            border-left: 3px solid #ffd700; 
            border-radius: 15px; 
            height: 40px;
        }
        .nav-item { 
            height: 40px; 
            transition: all 0.3s ease; 
        }

        /* ===== MAIN ===== */
        .main-content {
            background: linear-gradient(45deg, rgb(44,110,98) 20%, #144243 50%, rgba(60,130,110,0.35) 100%);
            flex: 1; 
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
            background: white; 
            border-bottom: 1px solid rgb(210,210,210);
            flex-wrap: wrap; 
            gap: 15px;
        }
        .page-title { 
            margin-left: 30px; 
            color: rgb(44,110,98); 
        }
        .page-title p { 
            font-size: 14px; 
            color: #6c757d; 
            margin-top: 5px; 
        }

        /* ===== NOTIFICATION ===== */
        .notification-area { 
            position: relative; 
            display: inline-block; 
            margin-right: 15px; 
        }
        .notification-bell {
            background: linear-gradient(180deg, rgb(15,43,61) 0%, rgb(25,110,114) 100%);
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
                from { 
                opacity:0; 
                transform:translateY(-10px); 
            } 
            to { 
                opacity:1; 
                transform:translateY(0); 
            } 
        }
        .notification-header {
            background: linear-gradient(135deg, rgb(15,43,61) 0%, rgb(25,110,114) 100%);
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
            cursor: pointer; 
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
            justify-content: space-between; align-items: center; 
            flex-wrap: wrap; 
            gap: 5px; 
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
            flex-wrap: wrap; 
        }
        .btn-read-notif { 
            background: #6c757d; 
            color: white; 
            border: none; 
            padding: 4px 10px; 
            border-radius: 10px; 
            cursor: pointer; 
            font-size: 11px; 
        }
        .btn-read-notif:hover { 
            background: #5a6268; 
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

        /* ===== USER MENU ===== */
        .user-menu-container a {
            background: linear-gradient(180deg, rgb(15,43,61) 0%, rgb(25,110,114) 100%);
            height: 35px; 
            padding-inline-start: 15px; 
            padding-inline-end: 15px;
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
            background: linear-gradient(180deg, rgb(15,43,61) 0%, rgb(25,110,114) 100%);
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

        /* ===== STATS ===== */
        .stats { 
            display: flex; 
            gap: 20px; 
            margin: 20px 50px; 
            flex-wrap: wrap; 
        }
        .stats-container {
            flex: 1; 
            min-width: 180px; 
            background: white; 
            padding: 20px;
            border-radius: 20px; 
            text-align: center; 
            transition: all 0.3s ease;
        }
        .stats-container:hover { 
            transform: translateY(-3px); 
            box-shadow: 0 4px 12px rgba(0,0,0,0.1); 
        }
        .stats-container h3 { 
            color: #666; 
            font-size: 14px; 
            margin-bottom: 10px; 
        }
        .stats-container h2 { 
            color: rgb(44,110,98); 
            font-size: 32px; 
        }
        .stats-container p { 
            color: #999; 
            font-size: 12px; 
            margin-top: 5px; 
        }

        /* ===== FILTER ROW ===== */
        .sales-status {
            display: flex; 
            justify-content: space-between; 
            align-items: center;
            margin: 20px 50px; 
            gap: 15px; 
            flex-wrap: wrap;
        }
        .filter-section { 
            display: flex; 
            align-items: center; 
            gap: 15px; 
            flex-wrap: wrap; 
        }
        .filter-label { 
            color: white; 
            font-weight: 600; 
        }
        .filter-dropdown {
            padding: 10px 20px; 
            border: 1px solid #e2e8f0; 
            border-radius: 25px;
            background: white;
            color: rgb(44,110,98); 
            font-weight: 500; 
            cursor: pointer; 
            outline: none; 
            min-width: 150px;
        }
        .new-sale-button {
            background: linear-gradient(180deg, rgb(15,43,61) 0%, rgb(25,110,114) 100%);
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
        .new-sale-button:hover { 
            transform: scale(1.03); 
            box-shadow: 0 4px 12px rgba(0,0,0,0.15); 
        }

        /* ===== NEW SALE MODAL ===== */
        .new-sale-container {
            position: fixed; 
            top: 0; left: 0; 
            width: 100%; 
            height: 100%;
            background: rgba(0,0,0,0.6); 
            backdrop-filter: blur(8px);
            display: flex; 
            align-items: center; 
            justify-content: center;
            visibility: hidden; 
            opacity: 0; 
            transition: all 0.3s ease; 
            z-index: 1000;
        }
        .new-sale-container.show { 
            visibility: visible; 
            opacity: 1; 
        }
        .new-sale-modal {
            width: 90%; 
            max-width: 1100px; 
            background: white; 
            border-radius: 32px;
            overflow: hidden; 
            animation: modalSlideIn 0.4s cubic-bezier(0.16,1,0.3,1);
            box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25);
        }
        @keyframes 
        modalSlideIn { 
                from { 
                opacity:0; 
                transform:scale(0.95) translateY(20px); 
            } 
            to { 
                opacity:1; 
                transform:scale(1) translateY(0); 
            } 
        }
        .modal-dual-pane { 
            display: flex; 
            flex-wrap: wrap; 
        }
        .product-pane { 
            flex: 1.2; 
            background: #f8fafc; 
            padding: 28px; 
            border-right: 1px solid #e2e8f0; 
        }
        .checkout-pane { 
            flex: 0.8; 
            background: linear-gradient(45deg, rgb(44,110,98) 20%, #144243 50%); 
            padding: 28px; 
        }
        .pane-title { 
            font-size: 18px; 
            font-weight: 600; 
            margin-bottom: 20px; 
            display: flex; 
            align-items: center; 
            gap: 10px;
        }
        .product-pane .pane-title { 
            color: rgb(44,110,98); 
        }
        .checkout-pane .pane-title { 
            color: rgb(151,205,200); 
        }
        .product-search input {
            width: 100%; 
            padding: 14px 18px; 
            border: 2px solid #e2e8f0;
            border-radius: 48px; 
            font-size: 14px; 
            outline: none; 
            margin-bottom: 20px;
        }
        .product-search input:focus { 
            border-color: rgb(44,110,98); 
            box-shadow: 0 0 0 3px rgba(44,110,98,0.1); 
        }
        .product-grid {
            display: grid; 
            grid-template-columns: repeat(auto-fill,minmax(140px,1fr));
            gap: 16px; 
            max-height: 400px; 
            overflow-y: auto; 
            padding-right: 8px;
        }
        .product-grid::-webkit-scrollbar { 
            width: 8px; 
        }
        .product-grid::-webkit-scrollbar-track { 
            background: #e2e8f0; 
            border-radius: 10px; 
        }
        .product-grid::-webkit-scrollbar-thumb { 
            background: #2c6e62; 
            border-radius: 10px; 
        }
        .product-card {
            background: white; 
            border-radius: 20px; 
            padding: 16px 12px; 
            text-align: center;
            cursor: pointer; 
            transition: all 0.3s ease; 
            border: 2px solid transparent;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }
        .product-card:hover { 
            transform: translateY(-4px); 
            box-shadow: 0 8px 20px rgba(44,110,98,0.15); 
            border-color: #2c6e62; 
        }
        .product-card.selected { 
            border-color: #2c6e62; 
            background: linear-gradient(135deg,#f0fdf4 0%,#dcfce7 100%); 
            position: relative; 
        }
        .product-icon {
            width: 60px; 
            height: 60px;
            background: linear-gradient(135deg,#2c6e62 0%,#1a4a42 100%);
            border-radius: 30px; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            margin: 0 auto 12px;
        }
        .product-icon i { 
            font-size: 28px; 
            color: white; 
        }
        .product-card h4 { 
            font-size: 14px; 
            font-weight: 600; 
            color: #1e293b; 
            margin-bottom: 4px; 
        }
        .product-card .product-price { 
            font-size: 16px; 
            font-weight: 700; 
            color: #2c6e62; 
        }
        .product-card .product-stock { 
            font-size: 11px; 
            color: #94a3b8; 
            margin-top: 4px; 
        }
        .cart-items { 
            max-height: 300px; 
            overflow-y: auto; 
            margin-bottom: 20px; 
        }
        .cart-items::-webkit-scrollbar { 
            width: 6px; 
        }
        .cart-items::-webkit-scrollbar-track { 
            background: rgba(255,255,255,0.2); 
            border-radius: 10px; 
        }
        .cart-items::-webkit-scrollbar-thumb { 
            background: rgba(255,255,255,0.4); 
            border-radius: 10px; 
        }
        .cart-item {
            display: flex; 
            justify-content: space-between; 
            align-items: center;
            padding: 12px 0; 
            border-bottom: 1px solid rgba(255,255,255,0.2);
        }
        .cart-item-info { 
            flex: 1; 
        }
        .cart-item-name { 
            font-weight: 600; 
            font-size: 14px; 
            color: white; 
        }
        .cart-item-price { 
            font-size: 12px; 
            color: rgba(255,255,255,0.7); 
        }
        .cart-item-quantity { 
            display: flex; 
            align-items: center; 
            gap: 8px; 
        }
        .cart-item-quantity button {
            width: 28px; 
            height: 28px; 
            border-radius: 14px; 
            border: none;
            background: rgba(255,255,255,0.2); 
            color: white; 
            cursor: pointer; 
            font-weight: bold;
        }
        .cart-item-quantity button:hover { 
            background: rgba(255,255,255,0.4); 
        }
        .cart-item-quantity span { 
            min-width: 30px; 
            text-align: center; 
            font-weight: 600; 
            color: white; 
        }
        .cart-item-subtotal { 
            font-weight: 700; 
            color: rgb(151,205,200); 
            min-width: 80px; 
            text-align: right; 
        }
        .cart-item-remove { 
            color: rgba(255,255,255,0.6); 
            cursor: pointer; 
            margin-left: 12px; 
        }
        .cart-item-remove:hover { 
            color: #ff6b6b; 
        }
        .cart-summary { 
            background: rgba(0,0,0,0.2); 
            border-radius: 15px; 
            padding: 18px; 
            margin-top: 20px; 
        }
        .summary-row { 
            display: flex; 
            justify-content: space-between; 
            margin-bottom: 10px; 
            font-size: 14px; 
            color: white; 
        }
        .summary-row.total {
            font-size: 18px; 
            font-weight: 700; 
            color: rgb(151,205,200);
            border-top: 1px solid rgba(255,255,255,0.2); 
            padding-top: 12px; 
            margin-top: 8px;
        }
        .payment-options select {
            width: 100%; 
            padding: 12px 16px; 
            border: 1px solid rgba(255,255,255,0.3);
            border-radius: 25px; 
            font-size: 14px; 
            background: rgba(255,255,255,0.9); 
            margin-top: 20px;
        }
        .complete-sale-btn {
            width: 100%;
            background: linear-gradient(180deg, rgb(15,43,61) 0%, rgb(25,110,114) 100%);
            border: none; 
            color: white; 
            font-weight: 600; 
            font-size: 16px;
            padding: 14px; 
            border-radius: 25px; 
            cursor: pointer; 
            margin-top: 20px; 
            transition: all 0.3s ease;
        }
        .complete-sale-btn:hover { 
            transform: translateY(-2px); 
            box-shadow: 0 4px 12px rgba(0,0,0,0.2); 
        }
        .complete-sale-btn:disabled {
            background: #6c757d; 
            cursor: not-allowed; 
        }
        .modal-close {
            position: absolute; 
            top: 15px; 
            right: 20px; 
            background: rgba(0,0,0,0.1);
            border: none; 
            width: 32px; 
            height: 32px; 
            border-radius: 50%; 
            cursor: pointer; 
            font-size: 16px; 
            z-index: 10;
        }
        .modal-close:hover { 
            background: #dc3545; 
            color: white; 
        }

        /* ===== TABLE ===== */
        .table-container { 
            max-height: 500px; 
            overflow-y: auto; 
            overflow-x: auto; 
            border-radius: 12px; 
        }
        .record-table { 
            width: 100%; 
            border-collapse: collapse; 
            font-size: 0.9rem; 
            min-width: 800px; 
        }
        .record-table th, .record-table td { 
            padding: 14px 12px; 
            text-align: left; 
            border-bottom: 1px solid #e2e8f0; 
        }
        .record-table th {
            background: linear-gradient(180deg, rgb(15,43,61) 0%, rgb(25,110,114) 100%);
            color: white; 
            font-weight: 600; 
            position: sticky; 
            top: 0; 
            z-index: 10;
        }
        .record-table tr:hover { 
            background: linear-gradient(180deg, rgb(49,83,104) 0%, rgba(47,229,239,0.426) 100%); 
            color: white; 
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
        .badge-success { 
            background: #28a745; 
            color: white; 
            padding: 4px 12px; 
            border-radius: 20px; 
            display: inline-block; font-size: 12px; 
        }
        .badge-warning { 
            background: #ffc107; 
            color: #212529; 
            padding: 4px 12px; 
            border-radius: 20px; 
            display: inline-block; font-size: 12px; 
        }
        .view-button, .pay-button {
            padding: 5px 10px; 
            border: none; 
            border-radius: 5px; 
            cursor: pointer; 
            margin: 2px; 
            font-size: 12px; 
            transition: all 0.3s ease;
        }
        .view-button { 
            background: #007bff; 
            color: white; 
        }
        .view-button:hover { 
            background: #0056b3; 
        }
        .pay-button { 
            background: #28a745; 
            color: white; 
        }
        .pay-button:hover:not(:disabled) { 
            background: #218838; 
        }
        .pay-button:disabled { 
            background: #6c757d !important; 
            cursor: not-allowed !important; 
            opacity: 0.6; 
        }
        .recordcount {
            color: rgb(71, 241, 4);
            padding: 11px 18px;
            border-radius: 25px;
            font-size: 14px;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            white-space: nowrap;
            background: linear-gradient(180deg, rgb(15,43,61) 0%, rgb(25,110,114) 100%);   
        }
        .count { 
            font-weight: 600; 
            color: white; 
        }
        .right { 
            display: flex; 
            align-items: center; 
            gap: 15px; 
            flex-wrap: wrap; 
        }

        /* ===== CUSTOM PAGINATION ===== */
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

        /* ===== MODALS (for details) ===== */
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
        .modal-container.show { 
            visibility: visible; 
            opacity: 1; 
        }
        .modal {
            width: 90%; 
            max-width: 650px;
            background: linear-gradient(45deg, rgb(44,110,98) 20%, #144243 50%);
            padding: 25px; 
            border-radius: 15px; 
            animation: modalSlideIn 0.3s ease;
            max-height: 90vh; 
            overflow-y: auto;
        }
        .modal-header { 
            color: rgb(151,205,200);
            margin-bottom: 20px; 
        }
        .modal-header h2 { 
            display: flex; 
            align-items: center; 
            gap: 10px; 
            font-size: 1.4rem; 
        }
        .sale-info { 
            margin-bottom: 15px; 
            color: white; 
            line-height: 1.8; 
        }
        .sale-info strong { 
            color: rgb(151,205,200); 
        }
        .details-table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-top: 10px; 
        }
        .details-table th, .details-table td {
            padding: 10px; 
            text-align: left;
            border-bottom: 1px solid rgba(255,255,255,0.2); 
            color: white;
        }
        .details-table th { 
            background: rgba(15,43,61,0.5); 
            color: rgb(151,205,200); 
        }
        .details-table tfoot td { 
            border-top: 2px solid rgba(255,255,255,0.4); 
            font-weight: 700; 
        }
        .items-badge {
            background: rgba(44,110,98,0.15); 
            color: #2c6e62;
            border: 1px solid rgba(44,110,98,0.3);
            padding: 2px 8px; 
            border-radius: 12px; 
            font-size: 11px; 
            font-weight: 600;
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
        .save-button { 
            background: linear-gradient(180deg, rgb(15,43,61) 0%, rgb(25,110,114) 100%); 
            color: white; }
        .cancel-button {
            background: linear-gradient(180deg, rgb(188,179,170) 0%, rgb(214,162,79) 100%); 
        }
        .product-table { 
            margin: 20px 50px; 
            padding: 20px; 
            padding-bottom: 40px; 
            background: white; 
            border-radius: 20px; 
        }
        .alert-success, .alert-error { 
            padding: 12px 40px 12px 20px; 
            margin: 10px 50px; 
            border-radius: 8px; 
            position: relative; 
        }
        .alert-success { 
            background-color: #d4edda; 
            color: #155724; 
            border-left: 4px solid #28a745; 
        }
        .alert-error { 
            background-color: #f8d7da; 
            color: #721c24; 
            border-left: 4px solid #dc3545; 
        }
        .close-btn { 
            position: absolute; 
            top: 50%; 
            right: 15px; 
            transform: translateY(-50%); 
            background: none; 
            border: none; font-size: 20px; 
            cursor: pointer; 
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
            z-index: 1100; 
            animation: slideInRight 0.3s ease;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }
        @keyframes 
            slideInRight { 
                from { 
                    transform: translateX(100%); 
                    opacity: 0; } 
                to { 
                    transform: translateX(0); 
                    opacity: 1; 
                } 
            }

        /* ===== RESPONSIVE ===== */
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
                margin: 20px; 
                flex-direction: column; 
            }
            .sales-status { 
                margin: 20px; 
                flex-direction: column; 
                align-items: stretch; 
            }
            .filter-section { 
                justify-content: space-between; 
            }
            .filter-dropdown { 
                flex: 1;
            }
            .new-sale-button { 
                justify-content: center; 
                width: 100%; 
            }
            .product-table { 
                margin: 20px; 
                padding: 15px; 
            }
            .modal-dual-pane { 
                flex-direction: column; 
            }
            .product-pane { 
                border-right: none; 
                border-bottom: 1px solid #e2e8f0; 
            }
            .alert-success, .alert-error { 
                margin: 20px; 
            }
            .notification-dropdown { 
                width: 320px; 
                right: -10px; 
            }
        }
        @media (max-width: 768px) {
            .stats-container h2 { 
                font-size: 24px; 
            }
            .stats-container h3 { 
                font-size: 12px; 
            }
        }
        @media (max-width: 480px) {
            .stats, .sales-status, .product-table { 
                margin: 15px; 
            }
            .product-grid { 
                grid-template-columns: repeat(auto-fill,minmax(100px,1fr)); 
            }
            .product-card { 
                padding: 12px 8px; 
            }
            .product-icon { 
                width: 45px; height: 45px; 
            }
            .product-icon i { 
                font-size: 20px; 
            }
            .modal { 
                max-width: 95%; 
                padding: 15px; 
            }
            .details-table th, .details-table td { 
                font-size: 11px; 
                padding: 6px; 
            }
            .notification-dropdown { 
                width: 280px; 
                right: -20px; 
            }
            .page-title h1 { 
                font-size: 20px; 
            }
            .stats-container h2 { 
                font-size: 20px; 
            }
            .recordcount strong { 
                font-size: 12px; 
            }
            .notification-item { 
                padding: 8px 12px; 
            }
            .notification-buttons { 
                flex-wrap: wrap; 
            }
        }
        @media (max-width: 380px) {
            .logout-btn { 
                padding: 6px 12px; 
                font-size: 11px; 
            }
            .notification-bell { 
                width: 35px; 
                height: 35px; 
                font-size: 14px; 
            }
            .user-menu { 
                gap: 8px; 
                margin-right: 10px; 
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
            .product-table { 
                margin: 15px 20px; 
            }
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
            <form action="{{ route('admin.dashboard') }}" method="GET">
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
                <div class="nav-item active">
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

    <!-- MAIN CONTENT -->
    <div class="main-content">

        <!-- TOP HEADER -->
        <div class="topheader">
            <div class="page-title">
                <h1>Sales</h1>
                <p>Monitor live stock and movement</p>
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
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="logout-btn">
                        <i class="fa-solid fa-right-from-bracket"></i> Logout
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

        <div class="stats">
            <div class="stats-container">
                <h3>Total Sales Today</h3>
                    <h2>{{ $totalSalesToday ?? 0 }}</h2>
                <p>Transactions</p>
            </div>
            <div class="stats-container">
                <h3>Revenue Today</h3>
                    <h2>₱{{ number_format($totalRevenueToday ?? 0, 2) }}</h2>
                <p>Total Sales</p>
            </div>
            <div class="stats-container">
                <h3>Pending Payments</h3>
                    <h2>₱{{ number_format($pendingPayments ?? 0, 2) }}</h2>
                <p>Awaiting Payment</p>
            </div>
        </div>

        <!-- SALES VIEW -->
        <div class="sales-view">
            <div class="sales-status">
                <div class="filter-section">
                    <span class="filter-label">
                        <i class="fas fa-filter"></i> Filter:
                    </span>
                    <form method="GET" action="{{ route('admin.sales') }}" id="filterForm" style="display:inline-block;">
                        <select name="filter" class="filter-dropdown" onchange="document.getElementById('filterForm').submit()">
                            <option value="all" {{ request('filter') == 'all' ? 'selected' : '' }}>All Sales</option>
                            <option value="today" {{ request('filter') == 'today' ? 'selected' : '' }}>Today's Sales</option>
                            <option value="completed" {{ request('filter') == 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="pending" {{ request('filter') == 'pending' ? 'selected' : '' }}>Pending</option>
                        </select>
                    </form>
                </div>
                <div class="right">
                    <div class="recordcount">
                        <span class="count">Total Sales: </span>
                        <strong>{{ $sales->total() }}</strong>
                    </div>
                    <div class="add-new-sale">
                        <button id="open_new_sale_modal" class="new-sale-button">
                            <i class="fas fa-plus"></i> New Sale
                        </button>
                    </div>
                </div>
            </div>

            <!-- NEW SALE MODAL -->
            <div class="new-sale-container" id="newSaleModal">
                <div class="new-sale-modal" style="position:relative;">
                    <button class="modal-close" id="closeNewSaleModal">
                        <i class="fas fa-times"></i>
                    </button>
                    <div class="modal-dual-pane">
                        <div class="product-pane">
                            <div class="pane-title">
                                <i class="fas fa-store"></i> Select Products
                            </div>
                            <div class="product-search">
                                <input type="text" id="productSearchInput" placeholder="Search products...">
                            </div>
                            <div class="product-grid" id="productGrid">
                                @foreach($products as $product)
                                <div class="product-card"
                                     data-id="{{ $product->id }}"
                                     data-name="{{ $product->product_name }}"
                                     data-price="{{ $product->price }}"
                                     data-stock="{{ $product->quantity }}">
                                    <div class="product-icon">
                                        <i class="fas fa-box"></i>
                                    </div>
                                    <h4>{{ Str::limit($product->product_name, 20) }}</h4>
                                    <div class="product-price">₱{{ number_format($product->price, 2) }}</div>
                                    <div class="product-stock">Stock: {{ $product->quantity }}</div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <!-- Checkout pane -->
                        <div class="checkout-pane">
                            <div class="pane-title">
                                <i class="fas fa-shopping-cart"></i> Checkout Summary
                            </div>
                            <div class="cart-items" id="cartItems">
                                <div style="text-align:center;padding:40px 20px;color:rgba(255,255,255,0.6);">
                                    <i class="fas fa-shopping-bag" style="font-size:48px;margin-bottom:12px;display:block;"></i>
                                    No items selected
                                </div>
                            </div>
                            <div class="cart-summary">
                                <div class="summary-row">
                                    <span>Subtotal</span>
                                    <span id="subtotal">₱0.00</span>
                                </div>
                                <div class="summary-row total">
                                    <span>Total</span>
                                    <span id="totalAmount">₱0.00</span>
                                </div>
                            </div>
                            <div class="payment-options">
                                <select id="paymentStatus">
                                    <option value="Paid">Paid</option>
                                    <option value="Pending">Pending Payment</option>
                                </select>
                            </div>
                            <button class="complete-sale-btn" id="submitSaleBtn" disabled>
                                <i class="fas fa-credit-card"></i> Complete Sale
                            </button>
                        </div>

                    </div>
                </div>
            </div>

            <!-- ===================== SALE DETAILS MODAL ===================== -->
            <div class="modal-container" id="saleDetailsModal">
                <div class="modal">
                    <div class="modal-header">
                        <h2><i class="fa-solid fa-receipt"></i> Sale Details #
                            <span id="sale_detail_id"></span>
                        </h2>
                    </div>
                    <div class="modal-body">
                        <div class="sale-info">
                            <strong>Cashier:</strong> 
                                <span id="sale_cashier"></span>
                            <br>
                            <strong>Date &amp; Time:</strong> 
                                <span id="sale_date_display"></span>
                            <br>
                            <strong>Status:</strong> 
                                <span id="sale_status_display"></span>
                        </div>
                        <h4 style="color:rgb(151,205,200);margin-bottom:10px;">Items Sold: <span id="sale_items_count" style="font-size:13px;font-weight:400;"></span></h4>
                        <div style="overflow-x:auto;">
                            <table class="details-table">
                                <thead><tr><th>#</th><th>Product</th><th style="text-align:center">Qty</th><th style="text-align:right">Unit Price</th><th style="text-align:right">Subtotal</th></tr></thead>
                                <tbody id="sale_items_table"><tr class="spinner-row"><td colspan="5"><i class="fas fa-spinner fa-spin"></i> Loading…<\/td><\/tr></tbody>
                                <tfoot><tr><td colspan="4" style="text-align:right;color:rgb(151,205,200);">Grand Total:<\/td><td style="text-align:right"><strong id="sale_total">₱0.00<\/strong><\/td><\/tr></tfoot>
                            </table>
                        </div>
                        <button id="close_sale_modal" class="cancel-button" style="margin-top:20px;"><i class="fa-solid fa-circle-xmark"></i> Close</button>
                    </div>
                </div>
            </div>

            <!-- ===================== PROCESS PAYMENT MODAL ===================== -->
            <div class="modal-container" id="paymentModal">
                <div class="modal" style="max-width:400px;">
                    <div class="modal-header"><h2><i class="fa-solid fa-credit-card"></i> Process Payment</h2></div>
                    <div class="modal-body">
                        <div class="sale-info"><strong>Sale ID:</strong> <span id="payment_sale_id"></span><br><strong>Total Amount:</strong> <span id="payment_total"></span></div>
                        <form id="processPaymentForm" method="POST">@csrf @method('PUT')<input type="hidden" name="sale_id" id="payment_sale_id_input" /><button type="submit" class="save-button"><i class="fa-solid fa-check-circle"></i> Confirm Payment</button></form>
                        <button id="close_payment_modal" class="cancel-button"><i class="fa-solid fa-circle-xmark"></i> Cancel</button>
                    </div>
                </div>
            </div>

            <!-- ===================== SALES TABLE ===================== -->
            <div class="product-table">
                <div class="table-container">
                    <table class="record-table">
                        <thead>
                            <tr>
                                <th>Sale ID</th>
                                <th>Cashier</th>
                                <th>Date &amp; Time</th>
                                <th>Status</th>
                                <th>Total Amount</th>
                                <th>Items</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($sales as $sale)
                            <tr>
                                <td><strong>#{{ $sale->id }}</strong></td>
                                <td>{{ $sale->user->fullname ?? 'N/A' }}</td>
                                <td>{{ $sale->sale_date ? $sale->sale_date->format('M j, Y g:i A') : 'N/A' }}</td>
                                <td>
                                    <span class="{{ $sale->status == 'completed' ? 'badge-success' : 'badge-warning' }}">
                                        {{ ucfirst($sale->status) }}
                                    </span>
                                </td>
                                <td>₱{{ number_format($sale->total_amount, 2) }}</span>
                                <td>
                                    <span class="items-badge">
                                        {{ $sale->saleDetails->count() }} {{ Str::plural('item', $sale->saleDetails->count()) }}
                                        ({{ $sale->saleDetails->sum('quantity') }} {{ Str::plural('unit', $sale->saleDetails->sum('quantity')) }})
                                    </span>
                                </span>
                                <td>
                                    <button class="view-button" onclick="viewSaleDetails('{{ $sale->id }}')"><i class="fas fa-eye"></i> View</button>
                                    @if($sale->status == 'pending')
                                        <button class="pay-button" onclick="processPayment('{{ $sale->id }}', '{{ $sale->total_amount }}')"><i class="fas fa-credit-card"></i> Pay Now</button>
                                    @else
                                        <button class="pay-button" disabled><i class="fas fa-check-circle"></i> Paid</button>
                                    @endif
                                </span>
                            </tr>
                            @empty
                            <td><td colspan="7" style="text-align:center;padding:30px;">No sales recorded yet</span></td>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <!-- Custom Pagination -->
                <div class="pagination-container" id="customPagination"></div>
                <input type="hidden" id="currentPage" value="{{ $sales->currentPage() }}">
                <input type="hidden" id="lastPage" value="{{ $sales->lastPage() }}">
            </div>

        </div>{{-- end .sales-view --}}
    </div>{{-- end .main-content --}}

    <script>
    // ================================================================
    //  UTILITY
    // ================================================================
    function escapeHtml(text) {
        if (text === null || text === undefined) return '';
        var d = document.createElement('div');
        d.textContent = String(text);
        return d.innerHTML;
    }

    // ================================================================
    //  UNIFORM SUCCESS/ERROR ALERT (Same as products page)
    // ================================================================
    function showUniformAlert(message, type) {
        // Remove any existing alerts
        var existingAlerts = document.querySelectorAll('.alert-success, .alert-error');
        existingAlerts.forEach(function(alert) { alert.remove(); });
        
        var alertDiv = document.createElement('div');
        alertDiv.className = type === 'success' ? 'alert-success' : 'alert-error';
        alertDiv.innerHTML = message + '<button class="close-btn" onclick="this.parentElement.style.display=\'none\'">&times;</button>';
        
        var topheader = document.querySelector('.topheader');
        if (topheader) {
            topheader.insertAdjacentElement('afterend', alertDiv);
        }
        
        // Auto hide after 5 seconds
        setTimeout(function() { 
            if (alertDiv) alertDiv.style.display = 'none'; 
        }, 5000);
    }

    // ================================================================
    //  CART STATE
    // ================================================================
    var cart = [];

    function resetCart() {
        cart = [];
        renderCart();
        updateTotal();
        var productCards = document.querySelectorAll('.product-card');
        for (var i = 0; i < productCards.length; i++) {
            productCards[i].classList.remove('selected');
        }
    }

    function addToCart(id, name, price, stock) {
        if (stock <= 0) { 
            showUniformAlert('Product is out of stock!', 'error');
            return; 
        }
        
        var existing = null;
        for (var i = 0; i < cart.length; i++) {
            if (cart[i].id === id) {
                existing = cart[i];
                break;
            }
        }
        
        if (existing) {
            if (existing.qty + 1 > stock) { 
                showUniformAlert('Only ' + stock + ' units available!', 'error');
                return; 
            }
            existing.qty++;
        } else {
            cart.push({ id: id, name: name, price: parseFloat(price), qty: 1, stock: parseInt(stock) });
        }
        renderCart();
        updateTotal();
    }

    function removeFromCart(id) {
        var newCart = [];
        for (var i = 0; i < cart.length; i++) {
            if (cart[i].id !== id) {
                newCart.push(cart[i]);
            }
        }
        cart = newCart;
        renderCart();
        updateTotal();
    }

    function updateQty(id, delta) {
        var item = null;
        for (var i = 0; i < cart.length; i++) {
            if (cart[i].id === id) {
                item = cart[i];
                break;
            }
        }
        if (!item) return;
        
        var newQty = item.qty + delta;
        if (newQty < 1) { 
            removeFromCart(id); 
            return; 
        }
        if (newQty > item.stock) { 
            showUniformAlert('Only ' + item.stock + ' units available!', 'error');
            return; 
        }
        item.qty = newQty;
        renderCart();
        updateTotal();
    }

    function renderCart() {
        var container = document.getElementById('cartItems');
        var btn = document.getElementById('submitSaleBtn');
        if (!container) return;

        if (cart.length === 0) {
            container.innerHTML = '<div style="text-align:center;padding:40px 20px;color:rgba(255,255,255,0.6);"><i class="fas fa-shopping-bag" style="font-size:48px;margin-bottom:12px;display:block;"></i>No items selected</div>';
            if (btn) btn.disabled = true;
            return;
        }

        var html = '';
        for (var i = 0; i < cart.length; i++) {
            var item = cart[i];
            html += '<div class="cart-item">' +
                '<div class="cart-item-info">' +
                    '<div class="cart-item-name">' + escapeHtml(item.name) + '</div>' +
                    '<div class="cart-item-price">₱' + item.price.toLocaleString(undefined,{minimumFractionDigits:2}) + '</div>' +
                '</div>' +
                '<div class="cart-item-quantity">' +
                    '<button type="button" onclick="updateQty(' + item.id + ',-1)">−</button>' +
                    '<span>' + item.qty + '</span>' +
                    '<button type="button" onclick="updateQty(' + item.id + ',1)">+</button>' +
                '</div>' +
                '<div class="cart-item-subtotal">₱' + (item.price * item.qty).toLocaleString(undefined,{minimumFractionDigits:2}) + '</div>' +
                '<div class="cart-item-remove" onclick="removeFromCart(' + item.id + ')"><i class="fas fa-trash-alt"></i></div>' +
            '</div>';
        }
        container.innerHTML = html;
        if (btn) btn.disabled = false;
    }

    function updateTotal() {
        var total = 0;
        for (var i = 0; i < cart.length; i++) {
            total += cart[i].price * cart[i].qty;
        }
        var fmt = total.toLocaleString(undefined, { minimumFractionDigits: 2 });
        document.getElementById('subtotal').textContent = '₱' + fmt;
        document.getElementById('totalAmount').textContent = '₱' + fmt;
    }

    // ================================================================
    //  NEW SALE MODAL — open / close
    // ================================================================
    var newSaleModal = document.getElementById('newSaleModal');
    var openNewSaleBtn = document.getElementById('open_new_sale_modal');
    var closeNewSaleBtn = document.getElementById('closeNewSaleModal');

    if (openNewSaleBtn) {
        openNewSaleBtn.onclick = function() { 
            newSaleModal.classList.add('show'); 
            resetCart(); 
        };
    }
    if (closeNewSaleBtn) {
        closeNewSaleBtn.onclick = function() { 
            newSaleModal.classList.remove('show'); 
            resetCart(); 
        };
    }
    if (newSaleModal) {
        newSaleModal.onclick = function(e) { 
            if (e.target === newSaleModal) { 
                newSaleModal.classList.remove('show'); 
                resetCart(); 
            } 
        };
    }

    // Product card click
    var productCards = document.querySelectorAll('.product-card');
    for (var i = 0; i < productCards.length; i++) {
        productCards[i].addEventListener('click', function() {
            var id = parseInt(this.dataset.id);
            var name = this.dataset.name;
            var price = parseFloat(this.dataset.price);
            var stock = parseInt(this.dataset.stock);
            addToCart(id, name, price, stock);
            this.classList.add('selected');
            var self = this;
            setTimeout(function() { self.classList.remove('selected'); }, 300);
        });
    }

    // Product search filter
    var productSearchInput = document.getElementById('productSearchInput');
    if (productSearchInput) {
        productSearchInput.addEventListener('input', function() {
            var term = this.value.toLowerCase();
            var cards = document.querySelectorAll('.product-card');
            for (var i = 0; i < cards.length; i++) {
                var card = cards[i];
                if (card.dataset.name.toLowerCase().includes(term)) {
                    card.style.display = '';
                } else {
                    card.style.display = 'none';
                }
            }
        });
    }

    // ================================================================
    //  SUBMIT SALE — with uniform success message
    // ================================================================
    var submitSaleBtn = document.getElementById('submitSaleBtn');
    if (submitSaleBtn) {
        submitSaleBtn.addEventListener('click', function() {
            if (cart.length === 0) { 
                showUniformAlert('Please add at least one item.', 'error');
                return; 
            }

            this.disabled = true;
            this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing…';

            var paymentStatus = document.getElementById('paymentStatus').value;
            var items = [];
            for (var i = 0; i < cart.length; i++) {
                items.push({ product_id: cart[i].id, quantity: cart[i].qty });
            }

            fetch('{{ route("admin.sale.store") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                },
                body: JSON.stringify({ items: items, payment_status: paymentStatus }),
            })
            .then(function(response) { 
                return response.json(); 
            })
            .then(function(result) {
                if (result.success) {
                    newSaleModal.classList.remove('show');
                    resetCart();
                    showUniformAlert('Sale #' + result.sale_id + ' recorded successfully!', 'success');
                    setTimeout(function() { 
                        location.reload(); 
                    }, 2000);
                } else {
                    showUniformAlert(result.message || 'Error processing sale', 'error');
                    this.disabled = false;
                    this.innerHTML = '<i class="fas fa-credit-card"></i> Complete Sale';
                }
            }.bind(this))
            .catch(function(err) {
                console.error(err);
                showUniformAlert('Network error. Please try again.', 'error');
                this.disabled = false;
                this.innerHTML = '<i class="fas fa-credit-card"></i> Complete Sale';
            }.bind(this));
        });
    }

    // ================================================================
    //  VIEW SALE DETAILS
    // ================================================================
    var saleDetailsModal = document.getElementById('saleDetailsModal');
    var closeSaleModal = document.getElementById('close_sale_modal');

    function viewSaleDetails(id) {
        saleDetailsModal.classList.add('show');
        document.getElementById('sale_detail_id').textContent = id;
        document.getElementById('sale_cashier').textContent = '—';
        document.getElementById('sale_date_display').textContent = '—';
        document.getElementById('sale_status_display').innerHTML = '';
        document.getElementById('sale_items_count').textContent = '';
        document.getElementById('sale_total').textContent = '₱0.00';
        document.getElementById('sale_items_table').innerHTML = '<tr class="spinner-row"><td colspan="5"><i class="fas fa-spinner fa-spin"></i> Loading…<\/td><\/tr>';

        fetch('/admin/sale/details/' + id, {
            method: 'GET',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
            },
            credentials: 'same-origin',
        })
        .then(function(res) {
            if (!res.ok) throw new Error('HTTP ' + res.status);
            return res.json();
        })
        .then(function(sale) {
            if (sale.error) throw new Error(sale.error);
            document.getElementById('sale_cashier').textContent = sale.user?.fullname || 'N/A';
            document.getElementById('sale_date_display').textContent = sale.sale_date || 'N/A';
            var statusClass = sale.status === 'completed' ? 'badge-success' : 'badge-warning';
            var statusLabel = sale.status ? sale.status.charAt(0).toUpperCase() + sale.status.slice(1) : 'Unknown';
            document.getElementById('sale_status_display').innerHTML = '<span class="' + statusClass + '">' + statusLabel + '</span>';
            document.getElementById('sale_total').textContent = '₱' + parseFloat(sale.total_amount).toLocaleString(undefined, { minimumFractionDigits: 2 });

            var details = sale.sale_details || [];
            var totalUnits = 0;
            for (var i = 0; i < details.length; i++) {
                totalUnits += details[i].quantity;
            }
            document.getElementById('sale_items_count').textContent = '(' + details.length + ' product type' + (details.length !== 1 ? 's' : '') + ', ' + totalUnits + ' unit' + (totalUnits !== 1 ? 's' : '') + ')';

            if (details.length === 0) {
                document.getElementById('sale_items_table').innerHTML = '<tr><td colspan="5" style="text-align:center;color:rgba(255,255,255,0.6);">No items found<\/td><\/tr>';
                return;
            }

            var html = '';
            for (var i = 0; i < details.length; i++) {
                var item = details[i];
                html += '<tr>' +
                    '<td>' + (i + 1) + '<\/td>' +
                    '<td>' + escapeHtml(item.product?.product_name || 'N/A') + '<\/td>' +
                    '<td style="text-align:center">' + item.quantity + '<\/td>' +
                    '<td style="text-align:right">₱' + parseFloat(item.price).toLocaleString(undefined,{minimumFractionDigits:2}) + '<\/td>' +
                    '<td style="text-align:right">₱' + parseFloat(item.subtotal).toLocaleString(undefined,{minimumFractionDigits:2}) + '<\/td>' +
                '<\/tr>';
            }
            document.getElementById('sale_items_table').innerHTML = html;
        })
        .catch(function(err) {
            console.error('Sale details error:', err);
            document.getElementById('sale_items_table').innerHTML = '<tr><td colspan="5" style="text-align:center;color:#ff6b6b;"><i class="fas fa-exclamation-circle"></i> ' + escapeHtml(err.message) + '<br><small>Please try again later.<\/small><\/td><\/tr>';
            document.getElementById('sale_cashier').textContent = 'N/A';
            document.getElementById('sale_date_display').textContent = 'N/A';
            document.getElementById('sale_status_display').innerHTML = '<span class="badge-warning">Unknown</span>';
        });
    }

    if (closeSaleModal) {
        closeSaleModal.onclick = function() { saleDetailsModal.classList.remove('show'); };
    }
    if (saleDetailsModal) {
        saleDetailsModal.onclick = function(e) { 
            if (e.target === saleDetailsModal) saleDetailsModal.classList.remove('show'); 
        };
    }

    // Make viewSaleDetails available globally
    window.viewSaleDetails = viewSaleDetails;

    // ================================================================
    //  PROCESS PAYMENT
    // ================================================================
    var paymentModal = document.getElementById('paymentModal');
    var closePaymentModal = document.getElementById('close_payment_modal');

    function processPayment(id, total) {
        if (!confirm('Confirm payment for Sale #' + id + '?\nThis will deduct stock and mark the sale as completed.')) return;
        document.getElementById('payment_sale_id').textContent = id;
        document.getElementById('payment_total').textContent = '₱' + parseFloat(total).toLocaleString(undefined, { minimumFractionDigits: 2 });
        document.getElementById('payment_sale_id_input').value = id;
        document.getElementById('processPaymentForm').action = '/admin/sale/process-payment/' + id;
        paymentModal.classList.add('show');
    }

    if (closePaymentModal) {
        closePaymentModal.onclick = function() { paymentModal.classList.remove('show'); };
    }
    if (paymentModal) {
        paymentModal.onclick = function(e) { 
            if (e.target === paymentModal) paymentModal.classList.remove('show'); 
        };
    }

    // Make processPayment available globally
    window.processPayment = processPayment;

    // ================================================================
    //  CUSTOM PAGINATION
    // ================================================================
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
        
        var pageLinks = document.querySelectorAll('.page-link');
        for (var i = 0; i < pageLinks.length; i++) {
            pageLinks[i].addEventListener('click', function(e) {
                e.preventDefault();
                var page = this.getAttribute('data-page');
                if (page) {
                    var urlParams = new URLSearchParams(window.location.search);
                    urlParams.set('page', page);
                    window.location.href = window.location.pathname + '?' + urlParams.toString();
                }
            });
        }
    }

    //  NOTIFICATION FUNCTIONS
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
                '<div class="notification-title"><strong>' + escapeHtml(notif.product_name) + '</strong><span class="notification-time">' + notif.time_ago + '</span></div>' +
                '<div class="notification-message">Reported by: ' + escapeHtml(notif.user_name) + '<br>Current Stock: <strong style="color:' + stockColor + ';">' + notif.current_stock + '</strong> units (Min: ' + notif.min_stock_level + ')<br><small>' + escapeHtml(notif.message.substring(0, 100)) + (notif.message.length > 100 ? '...' : '') + '</small></div>' +
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
            window.location.href = '/admin/purchases?open_modal=1&product_id=' + productId + '&product_name=' + encodeURIComponent(productName) + '&report_id=' + reportId;
        }
    }
    
    function editProductAndReduceStock(productId, productName, damageQuantity, reportId) {
        if (confirm('Product: ' + productName + '\nDamaged Quantity: ' + damageQuantity + ' units\n\nClick OK to edit product and reduce stock by ' + damageQuantity + ' units.')) {
            window.location.href = '/admin/products?edit_damage=1&product_id=' + productId + '&damage_qty=' + damageQuantity + '&report_id=' + reportId;
        }
    }
    
    // Make functions available globally
    window.createPurchaseOrder = createPurchaseOrder;
    window.editProductAndReduceStock = editProductAndReduceStock;
    window.markAsRead = markAsRead;

    // ================================================================
    //  NOTIFICATION BELL TOGGLE
    // ================================================================
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
    
    //  INITIALIZE
    document.addEventListener('DOMContentLoaded', function() {
        renderPagination();
        fetchNotifications();
        setInterval(fetchNotifications, 30000);
    });
</script>
</body>
</html>