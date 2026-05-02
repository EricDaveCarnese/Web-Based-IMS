<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Management;
use App\Http\Controllers\UserManagementController;

// ==================== PUBLIC ROUTES ====================
Route::get('/', [UserManagementController::class, 'showLoginForm'])->name('landing');
Route::get('/login', [UserManagementController::class, 'showLoginForm'])->name('login');
Route::post('/login', [UserManagementController::class, 'login'])->name('login.post');
Route::post('/register', [UserManagementController::class, 'register'])->name('register');
Route::post('/logout', [UserManagementController::class, 'logout'])->name('logout');

// ==================== ADMIN ROUTES ====================
Route::prefix('admin')->middleware(['auth', 'role:admin'])->name('admin.')->group(function () {
    Route::get('/dashboard', [Management::class, 'adminDashboard'])->name('dashboard');
    Route::get('/products', [Management::class, 'adminProducts'])->name('products');
    Route::post('/product/store', [Management::class, 'storeProduct'])->name('product.store');
    Route::put('/product/update/{id}', [Management::class, 'updateProduct'])->name('product.update');
    Route::delete('/product/delete/{id}', [Management::class, 'deleteProduct'])->name('product.delete');
    Route::get('/product/{id}/data', [Management::class, 'getProductData'])->name('product.data');
    Route::post('/force-low-stock-alerts', [Management::class, 'forceCreateLowStockAlerts'])->name('force.lowstock');
    
    Route::get('/categories', [Management::class, 'adminCategories'])->name('categories');
    Route::post('/category/store', [Management::class, 'storeCategory'])->name('category.store');
    Route::put('/category/update/{id}', [Management::class, 'updateCategory'])->name('category.update');
    Route::delete('/category/delete/{id}', [Management::class, 'deleteCategory'])->name('category.delete');
    
    Route::get('/suppliers', [Management::class, 'adminSuppliers'])->name('suppliers');
    Route::post('/supplier/store', [Management::class, 'storeSupplier'])->name('supplier.store');
    Route::put('/supplier/update/{id}', [Management::class, 'updateSupplier'])->name('supplier.update');
    Route::delete('/supplier/delete/{id}', [Management::class, 'deleteSupplier'])->name('supplier.delete');
    
    Route::get('/sales', [Management::class, 'adminSales'])->name('sales');
    Route::post('/sale/store', [Management::class, 'storeSale'])->name('sale.store');
    Route::put('/sale/process-payment/{id}', [Management::class, 'processPayment'])->name('sale.process-payment');
    Route::get('/sale/details/{id}', [Management::class, 'getSaleDetails'])->name('sale.details');
    
    Route::get('/purchase/details/{id}', [Management::class, 'getPurchaseDetails'])->name('purchase.details');
    Route::get('/purchases', [Management::class, 'adminPurchases'])->name('purchases');
    Route::post('/purchase/store', [Management::class, 'storePurchase'])->name('purchase.store');
    Route::get('/purchase/details/{id}', [Management::class, 'getPurchaseDetails'])->name('purchase.details');
    Route::post('/purchase/complete/{id}', [Management::class, 'completePurchase'])->name('purchase.complete');
    Route::post('/purchase/cancel/{id}', [Management::class, 'cancelPurchase'])->name('purchase.cancel');
    
    Route::get('/reports', [Management::class, 'adminReports'])->name('reports');
    Route::post('/report/generate', [Management::class, 'generateReport'])->name('report.generate');
    
    Route::get('/users', [Management::class, 'adminUsers'])->name('users');
    Route::post('/user/store', [Management::class, 'storeUser'])->name('user.store');
    Route::put('/user/update/{id}', [Management::class, 'updateUser'])->name('user.update');
    Route::delete('/user/delete/{id}', [Management::class, 'deleteUser'])->name('user.delete');
    
    Route::get('/logs', [Management::class, 'logs'])->name('logs');
    
    Route::get('/stock-reports', [Management::class, 'stockReports'])->name('stock.reports');
    Route::post('/stock-report/mark-read', [Management::class, 'markStockReportAsRead'])->name('stock.report.read');
    Route::post('/stock-report/mark-ordered', [Management::class, 'markStockReportAsOrdered'])->name('stock.report.mark-ordered');

    Route::get('/stock-reports/notifications', [Management::class, 'getStockReportNotifications'])->name('stock.reports.notifications');
});

// ==================== USER ROUTES ====================
Route::prefix('user')->middleware(['auth', 'role:user'])->name('user.')->group(function () {
    Route::get('/dashboard', [Management::class, 'userDashboard'])->name('dashboard');
    Route::get('/products', [Management::class, 'userProducts'])->name('products');
    Route::get('/sales', [Management::class, 'userSales'])->name('sales');
    Route::get('/purchases', [Management::class, 'userPurchases'])->name('purchases');
    
    Route::put('/sale/process-payment/{id}', [Management::class, 'processUserPayment'])->name('sale.process-payment');
    Route::get('/sales/{id}/details', [Management::class, 'getUserSaleDetails'])->name('sale.details');
    Route::post('/sale/store', [Management::class, 'storeSale'])->name('sale.store');

    Route::post('/purchase/complete/{id}', [Management::class, 'completePurchase'])->name('purchase.complete');
    Route::post('/purchase/cancel/{id}', [Management::class, 'cancelPurchase'])->name('purchase.cancel');
    Route::get('/purchase/details/{id}', [Management::class, 'getUserPurchaseDetails'])->name('purchase.details');

    Route::post('/report-out-of-stock', [Management::class, 'reportOutOfStock'])->name('report.outofstock');
    
    Route::get('/notifications', [Management::class, 'getUserNotifications'])->name('notifications');
    Route::get('/notifications/bell', [Management::class, 'getUserNotificationsBell'])->name('notifications.bell');
    Route::post('/notification/mark-read', [Management::class, 'markUserNotificationAsRead'])->name('notification.mark-read');
    Route::post('/notification/receive', [Management::class, 'markUserNotificationAsReceived'])->name('notification.receive');
    Route::get('/notifications/unread-count', [Management::class, 'getUserUnreadCount'])->name('notifications.unread-count');

    Route::post('/report-damage', [Management::class, 'reportDamage'])->name('report.damage');
});