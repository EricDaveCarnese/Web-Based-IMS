<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Category;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseDetail;
use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\StockReport;
use App\Models\Supplier;
use App\Models\UserManagement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class Management extends Controller
{
    private function logActivity($action, $module, $description, $oldData = null, $newData = null)
    {
        try {
            ActivityLog::create([
                'user_id'     => Auth::id(),
                'user_name'   => Auth::user()->fullname,
                'action'      => $action,
                'module'      => $module,
                'description' => $description,
                'old_data'    => $oldData ? json_encode($oldData) : null,
                'new_data'    => $newData ? json_encode($newData) : null,
                'ip_address'  => request()->ip(),
            ]);
        } catch (\Exception $e) {
        }
    }
    
   private function createAutomaticLowStockAlert($product)
{
    if ($product->quantity > $product->min_stock_level) {
        return false;
    }
    
    $existingReport = StockReport::where('product_id', $product->id)
        ->whereIn('status', ['pending', 'read', 'ordered'])
        ->first();
    
    if ($existingReport) {
        return false;
    }
    
    $adminUser = UserManagement::where('role', 'admin')->first();
    
    StockReport::create([
        'user_id' => $adminUser ? $adminUser->id : 1,
        'user_name' => 'System (Auto Alert)',
        'product_id' => $product->id,
        'product_name' => $product->product_name,
        'current_stock' => $product->quantity,
        'min_stock_level' => $product->min_stock_level,
        'message' => "LOW STOCK ALERT: {$product->product_name} has fallen below minimum stock level.",
        'status' => 'pending',
        'user_notified' => false,
        'notify_users' => false,
    ]);
    
    return true;
}
    
    public function adminDashboard()
{
    $this->checkAndSyncLowStockAlerts();
    $lowStockProducts = Product::whereColumn('quantity', '<=', 'min_stock_level')->get();
    
    foreach ($lowStockProducts as $product) {
        $existingReport = StockReport::where('product_id', $product->id)
            ->whereIn('status', ['pending', 'read', 'ordered'])
            ->first();
        
        if (!$existingReport) {
            $adminUser = UserManagement::where('role', 'admin')->first();
            
            StockReport::create([
                'user_id' => $adminUser ? $adminUser->id : 1,
                'user_name' => 'System (Auto Alert)',
                'product_id' => $product->id,
                'product_name' => $product->product_name,
                'current_stock' => $product->quantity,
                'min_stock_level' => $product->min_stock_level,
                'message' => "AUTOMATIC ALERT: {$product->product_name} has fallen below minimum stock level. Current stock: {$product->quantity} units (Min required: {$product->min_stock_level})",
                'status' => 'pending',
                'user_notified' => false,
                'notify_users' => false,
            ]);
        }
    }
    
    $restockedProducts = Product::whereColumn('quantity', '>', 'min_stock_level')->get();
    foreach ($restockedProducts as $product) {
        StockReport::where('product_id', $product->id)
            ->where('user_name', 'System (Auto Alert)')
            ->where('status', 'pending')
            ->delete();
    }
    
    $totalProducts = Product::count();
    $lowStockProductsCount = Product::whereColumn('quantity', '<=', 'min_stock_level')->count();
    $todaySalesAmount = Sale::whereDate('sale_date', today())->sum('total_amount');
    $totalSales = Sale::sum('total_amount');
    $completedSales = Sale::where('status', 'completed')->sum('total_amount');
    $pendingSales = Sale::where('status', 'pending')->sum('total_amount');
    $pendingStockReports = StockReport::where('status', 'pending')->where('notify_users', false)->count();
    
    $perPage = 15;
    $currentPage = request()->get('page', 1);
    
    $todayStart = today()->startOfDay();
    $todayEnd = today()->endOfDay();
    
    $allTransactions = collect();
    
    $todaySalesRecords = Sale::with(['saleDetails.product.category', 'user'])
        ->whereBetween('sale_date', [$todayStart, $todayEnd])
        ->latest()
        ->get();
    
    foreach ($todaySalesRecords as $sale) {
        foreach ($sale->saleDetails as $detail) {
            $allTransactions->push((object)[
                'type' => 'Sale',
                'product' => $detail->product->product_name,
                'category' => $detail->product->category->category_name ?? 'N/A',
                'quantity' => $detail->quantity,
                'amount' => $detail->subtotal,
                'date' => $sale->sale_date,
                'status' => $sale->status,
                'reference_id' => $sale->id,
                'reference_type' => 'sale'
            ]);
        }
    }
    
    $todayPurchases = Purchase::with(['purchaseDetails.product.category', 'supplier'])
        ->whereBetween('purchase_date', [$todayStart, $todayEnd])
        ->latest()
        ->get();
    
    foreach ($todayPurchases as $purchase) {
        foreach ($purchase->purchaseDetails as $detail) {
            $allTransactions->push((object)[
                'type' => 'Purchase',
                'product' => $detail->product->product_name,
                'category' => $detail->product->category->category_name ?? 'N/A',
                'quantity' => $detail->quantity,
                'amount' => $detail->quantity * $detail->cost_price,
                'date' => $purchase->purchase_date,
                'status' => $purchase->status,
                'reference_id' => $purchase->id,
                'reference_type' => 'purchase'
            ]);
        }
    }
    
    $allTransactions = $allTransactions->sortByDesc('date')->values();
    
    $search = request()->get('search', '');
    if (!empty($search)) {
        $allTransactions = $allTransactions->filter(function ($transaction) use ($search) {
            return stripos($transaction->product, $search) !== false || 
                   stripos($transaction->category, $search) !== false;
        });
    }

    $statusFilter = request()->get('status', '');
    if (!empty($statusFilter) && $statusFilter !== 'all') {
        $allTransactions = $allTransactions->filter(function ($transaction) use ($statusFilter) {
            return $transaction->status === $statusFilter;
        });
    }
    
    $totalTransactions = $allTransactions->count();
    $recentTransactions = new \Illuminate\Pagination\LengthAwarePaginator(
        $allTransactions->slice(($currentPage - 1) * $perPage, $perPage)->values(),
        $totalTransactions,
        $perPage,
        $currentPage,
        ['path' => request()->url(), 'query' => request()->query()]
    );
    
    $lowStockItems = Product::whereColumn('quantity', '<=', 'min_stock_level')->take(5)->get();
    
    $categoryDistribution = Category::withCount('products')->get();
    
    $salesData = Sale::selectRaw('MONTH(sale_date) as month, SUM(total_amount) as total')
        ->whereYear('sale_date', date('Y'))
        ->where('status', 'completed')
        ->groupBy('month')
        ->orderBy('month')
        ->get();
    
    return view('Admin.dashboard', compact(
        'totalProducts', 
        'lowStockProductsCount', 
        'todaySalesAmount',
        'totalSales',
        'completedSales', 
        'pendingSales', 
        'pendingStockReports',
        'recentTransactions', 
        'lowStockItems', 
        'categoryDistribution', 
        'salesData'
    ));
}
    public function adminProducts()
{
    $this->checkAndSyncLowStockAlerts();
    $lowStockProducts = Product::whereColumn('quantity', '<=', 'min_stock_level')->get();
    
    foreach ($lowStockProducts as $product) {
        $existingReport = StockReport::where('product_id', $product->id)
            ->whereIn('status', ['pending', 'read', 'ordered'])
            ->first();
        
        if (!$existingReport) {
            $adminUser = UserManagement::where('role', 'admin')->first();
            
            StockReport::create([
                'user_id' => $adminUser ? $adminUser->id : 1,
                'user_name' => 'System (Auto Alert)',
                'product_id' => $product->id,
                'product_name' => $product->product_name,
                'current_stock' => $product->quantity,
                'min_stock_level' => $product->min_stock_level,
                'message' => "AUTOMATIC ALERT: {$product->product_name} has fallen below minimum stock level. Current stock: {$product->quantity} units (Min required: {$product->min_stock_level})",
                'status' => 'pending',
                'user_notified' => false,
                'notify_users' => false,
            ]);
        }
    }
    
    $search = request('search');
    $status = request('status');
    $query = Product::with(['category', 'supplier'])->whereNull('deleted_at');

    if ($search) {
        $query->where(function ($q) use ($search) {
            $q->where('product_name', 'like', "%{$search}%")
              ->orWhere('description', 'like', "%{$search}%");
        });
    }

    if ($status == 'instock') {
        $query->whereColumn('quantity', '>', 'min_stock_level');
    } elseif ($status == 'lowstock') {
        $query->whereColumn('quantity', '<=', 'min_stock_level')->where('quantity', '>', 0);
    } elseif ($status == 'outofstock') {
        $query->where('quantity', 0);
    }

    $products = $query->paginate(15);
    $allProducts = Product::with(['category', 'supplier'])->get();
    $categories = Category::all();
    $suppliers = Supplier::all();

    return view('Admin.products', compact('products', 'categories', 'suppliers', 'allProducts'));
}
    public function storeProduct(Request $request)
    {
        $request->validate([
            'product_name'    => 'required',
            'price'           => 'required|numeric|min:0',
            'quantity'        => 'required|integer|min:0',
            'min_stock_level' => 'required|integer|min:0',
            'category_id'     => 'required|exists:categories,id',
            'supplier_id'     => 'required|exists:suppliers,id',
        ]);

        $product = Product::create($request->all());

        $this->logActivity(
            'create', 'product',
            'Created product: ' . $product->product_name .
            ' (Price: ₱' . number_format($product->price, 2) .
            ', Stock: ' . $product->quantity . ' units)',
            null, $product->toArray()
        );

        return redirect()->route('admin.products')->with('success', 'Product created successfully.');
    }

    public function updateProduct(Request $request, $id)
{
    try {
        $product = Product::findOrFail($id);

        $request->validate([
            'product_name'    => 'required|string|max:255',
            'price'           => 'required|numeric|min:0',
            'quantity'        => 'required|integer|min:0',
            'min_stock_level' => 'required|integer|min:0',
        ]);

        $oldQuantity = $product->quantity;
        $damageReportId = $request->input('damage_report_id');

        $updateData = [
            'quantity' => $request->quantity,
        ];

        if (!$damageReportId) {
            $updateData['product_name']    = $request->product_name;
            $updateData['description']     = $request->description;
            $updateData['price']           = $request->price;
            $updateData['min_stock_level'] = $request->min_stock_level;
            if ($request->filled('category_id')) $updateData['category_id'] = $request->category_id;
            if ($request->filled('supplier_id')) $updateData['supplier_id'] = $request->supplier_id;
        }

        $product->update($updateData);
        $quantityReduced = $oldQuantity - $product->quantity;

        if ($damageReportId) {
            $damageReport = StockReport::find($damageReportId);
            if ($damageReport && in_array($damageReport->status, ['pending', 'read'])) {
                $damageReport->status = 'resolved';
                $damageReport->admin_response = "Stock reduced by {$quantityReduced} units due to damage report on " . now()->format('M j, Y g:i A');
                $damageReport->save();

                $allUsers = UserManagement::where('role', 'user')->get();
                foreach ($allUsers as $user) {
                    $alreadyNotified = StockReport::where('user_id', $user->id)
                        ->where('product_id', $product->id)
                        ->where('notify_users', true)
                        ->where('status', 'pending')
                        ->where('message', 'like', '%DAMAGE RESOLVED%')
                        ->exists();

                    if (!$alreadyNotified) {
                        StockReport::create([
                            'user_id'         => $user->id,
                            'user_name'       => $user->fullname,
                            'product_id'      => $product->id,
                            'product_name'    => $product->product_name,
                            'current_stock'   => $product->quantity,
                            'min_stock_level' => $product->min_stock_level,
                            'message'         => " DAMAGE RESOLVED: Admin has processed the damage report for '{$product->product_name}'. Stock reduced by {$quantityReduced} units. Current stock: {$product->quantity} units.",
                            'status'          => 'pending',  
                            'user_notified'   => false,
                            'notify_users'    => true,   
                        ]);
                    }
                }
            }
        }

        if ($product->quantity <= $product->min_stock_level) {
            $this->createAutomaticLowStockAlert($product);
        } else {
            StockReport::where('product_id', $product->id)
                ->where('user_name', 'System (Auto Alert)')
                ->where('status', 'pending')
                ->delete();
        }

        $this->logActivity(
            'update', 'product',
            'Updated product: ' . $product->product_name .
            ($quantityReduced > 0 ? " (Stock reduced by {$quantityReduced} units)" : ''),
        );

        return redirect()->route('admin.products')->with('success', 
            $damageReportId && $quantityReduced > 0
                ? "Stock reduced by {$quantityReduced} units. Damage report marked as RESOLVED!"
                : 'Product updated successfully!'
        );

    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Failed to update product: ' . $e->getMessage());
    }
}
public function deleteProduct($id)
{
    try {
        $product = Product::findOrFail($id);
        
        $stockReportsCount = StockReport::where('product_id', $id)->count();
        
        if ($stockReportsCount > 0) {
            return redirect()->route('admin.products')->with('error', 
                'Cannot delete "' . $product->product_name . '" because it has ' . $stockReportsCount . ' stock report(s). 
                This product has been reported by users. Please review the reports before taking action.'
            );
        }
        
        $saleDetailsCount = SaleDetail::where('product_id', $id)->count();
        
        if ($saleDetailsCount > 0) {
            return redirect()->route('admin.products')->with('error', 
                'Cannot delete "' . $product->product_name . '" because it has ' . $saleDetailsCount . ' sale record(s).'
            );
        }
        
        $purchaseDetailsCount = PurchaseDetail::where('product_id', $id)->count();
        
        if ($purchaseDetailsCount > 0) {
            return redirect()->route('admin.products')->with('error', 
                'Cannot delete "' . $product->product_name . '" because it has ' . $purchaseDetailsCount . ' purchase record(s).'
            );
        }
        
        $productData = $product->toArray();
        
        $product->deleted_by = Auth::id();
        $product->deleted_at = now();
        $product->save();
        
        $this->logActivity(
            'delete', 'product', 
            'Deleted product: ' . $product->product_name . ' (Deleted by ' . Auth::user()->fullname . ')', 
            $productData, 
            null
        );
        
        $product->delete();
        
        return redirect()->route('admin.products')->with('success', 
            'Product "' . $product->product_name . '" has been deleted successfully.'
        );
        
    } catch (\Exception $e) {
        return redirect()->route('admin.products')->with('error', 
            'Failed to delete product: ' . $e->getMessage()
        );
    }
}
    
    public function adminCategories()
    {
        $search = request('search');
        $query = Category::query();

        if ($search) {
            $query->where('category_name', 'like', "%{$search}%");
        }

        $categories = $query->withCount('products')->paginate(15);
        $allCategories = Category::all();

        return view('Admin.categories', compact('categories', 'allCategories'));
    }

    public function storeCategory(Request $request)
    {
        $request->validate([
            'category_name' => 'required|unique:categories',
        ]);

        $category = Category::create($request->all());

        $this->logActivity(
            'create', 'category',
            'Created category: ' . $category->category_name,
            null, $category->toArray()
        );

        return redirect()->route('admin.categories')->with('success', 'Category created successfully!');
    }

    public function updateCategory(Request $request, $id)
{
    $category = Category::findOrFail($id);

    $request->validate([
        'category_name' => 'required|unique:categories,category_name,' . $id,
    ]);

    $oldData = $category->toArray();
    
    $category->update($request->all());

    $this->logActivity(
        'update', 'category',
        'Updated category: ' . $category->category_name,
        $oldData, 
        $category->fresh()->toArray()
    );

    return redirect()->route('admin.categories')->with('success', 'Category updated successfully!');
}

    public function deleteCategory($id)
    {
        $category = Category::findOrFail($id);

        if ($category->products()->count() > 0) {
            return redirect()->route('admin.categories')->with('error', 'Cannot delete category with products!');
        }

        $this->logActivity(
            'delete', 'category',
            'Deleted category: ' . $category->category_name,
            $category->toArray()
        );

        $category->delete();

        return redirect()->route('admin.categories')->with('success', 'Category deleted successfully!');
    }

    public function adminSuppliers()
    {
        $search = request('search');
        $query = Supplier::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('supplier_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $suppliers = $query->paginate(15);
        $allSuppliers = Supplier::all();

        return view('Admin.suppliers', compact('suppliers', 'allSuppliers'));
    }

    public function storeSupplier(Request $request)
    {
        $request->validate([
        'supplier_name'  => 'required|string|max:255',
        'email'          => 'required|email|unique:suppliers',
        'contact_number' => 'required|regex:/^[\d\s\(\)\+-]+$/|min:7',
        'address'        => 'required|string',
        'contact_person' => 'nullable|string|max:255',
    ], [
        'contact_number.regex' => 'The contact number may only contain numbers, spaces, and the characters: ( ) + -',
        'contact_number.min' => 'The contact number must contain at least 7 digits.',
    ]);

    $supplier = Supplier::create([
        'supplier_name'  => $request->supplier_name,
        'email'          => $request->email,
        'contact_number' => $request->contact_number,
        'address'        => $request->address,
        'contact_person' => $request->contact_person,
    ]);

        $this->logActivity(
            'create', 'supplier',
            'Created supplier: ' . $supplier->supplier_name .
            ' (Email: ' . $supplier->email . ')',
            null, $supplier->toArray()
        );

        return redirect()->route('admin.suppliers')->with('success', 'Supplier created successfully!');
    }

    public function updateSupplier(Request $request, $id)
{
    $supplier = Supplier::findOrFail($id);

    $request->validate([
        'supplier_name'  => 'required|string|max:255',
        'email'          => 'required|email|unique:suppliers,email,' . $id,
        'contact_number' => 'required|regex:/^[\d\s\(\)\+-]+$/|min:7',
        'address'        => 'required|string',
        'contact_person' => 'nullable|string|max:255',
    ], [
        'contact_number.regex' => 'The contact number may only contain numbers, spaces, and the characters: ( ) + -',
        'contact_number.min' => 'The contact number must contain at least 7 digits.',
    ]);

    $oldData = $supplier->toArray();

    $supplier->update([
        'supplier_name'  => $request->supplier_name,
        'email'          => $request->email,
        'contact_number' => $request->contact_number,
        'address'        => $request->address,
        'contact_person' => $request->contact_person,
    ]);

    $this->logActivity(
        'update', 'supplier',
        'Updated supplier: ' . $supplier->supplier_name,
        $oldData, 
        $supplier->fresh()->toArray()
    );

    return redirect()->route('admin.suppliers')->with('success', 'Supplier updated successfully!');
}

    public function deleteSupplier($id)
    {
        $supplier = Supplier::findOrFail($id);

        if ($supplier->products()->count() > 0) {
            return redirect()->route('admin.suppliers')->with('error', 'Cannot delete supplier with products!');
        }

        $this->logActivity(
            'delete', 'supplier',
            'Deleted supplier: ' . $supplier->supplier_name,
            $supplier->toArray()
        );

        $supplier->delete();

        return redirect()->route('admin.suppliers')->with('success', 'Supplier deleted successfully!');
    }

    public function adminSales()
    {
        $products = Product::all();
        $filter = request('filter', 'all');
        $query = Sale::with('user', 'saleDetails.product');

        if ($filter == 'today') {
            $query->whereDate('sale_date', today());
        } elseif ($filter == 'completed') {
            $query->where('status', 'completed');
        } elseif ($filter == 'pending') {
            $query->where('status', 'pending');
        }

        $sales = $query->orderBy('id', 'desc')->paginate(10);

        $today = now()->format('Y-m-d');
        $totalSalesToday = Sale::whereDate('sale_date', $today)->count();
        $totalRevenueToday = Sale::whereDate('sale_date', $today)->where('status', 'completed')->sum('total_amount');
        $pendingPayments = Sale::where('status', 'pending')->sum('total_amount');

        return view('Admin.sales', compact(
            'sales', 'products', 'totalSalesToday',
            'totalRevenueToday', 'pendingPayments', 'filter'
        ));
    }

    public function storeSale(Request $request)
{
    if ($request->has('items')) {
        $request->validate([
            'items'                => 'required|array|min:1',
            'items.*.product_id'   => 'required|exists:products,id',
            'items.*.quantity'     => 'required|integer|min:1',
            'payment_status'       => 'required|in:Paid,Pending',
        ]);
 
        DB::beginTransaction();
        try {
            $status       = $request->payment_status === 'Paid' ? 'completed' : 'pending';
            $grandTotal   = 0;
            $itemsToSave  = [];
 
            foreach ($request->items as $item) {
                $product = Product::findOrFail($item['product_id']);
 
                if ($request->payment_status === 'Paid' && $product->quantity < $item['quantity']) {
                    DB::rollBack();
                    return response()->json([
                        'success' => false,
                        'message' => 'Insufficient stock for "' . $product->product_name
                                     . '"! Only ' . $product->quantity . ' available.',
                    ], 422);
                }
 
                $subtotal    = $product->price * $item['quantity'];
                $grandTotal += $subtotal;
 
                $itemsToSave[] = [
                    'product'  => $product,
                    'quantity' => $item['quantity'],
                    'subtotal' => $subtotal,
                ];
            }
 
            $sale = Sale::create([
                'user_id'      => Auth::id(),
                'sale_date'    => now(),
                'status'       => $status,
                'total_amount' => $grandTotal,
            ]);
 
            $lowStockAlerts = [];
 
            foreach ($itemsToSave as $entry) {
                $product = $entry['product'];
 
                SaleDetail::create([
                    'sale_id'    => $sale->id,
                    'product_id' => $product->id,
                    'quantity'   => $entry['quantity'],
                    'price'      => $product->price,
                    'subtotal'   => $entry['subtotal'],
                ]);
 
                if ($request->payment_status === 'Paid') {
                    $product->quantity -= $entry['quantity'];
                    $product->save();
 
                    if ($product->quantity <= $product->min_stock_level) {
                        $alerted = $this->createAutomaticLowStockAlert($product);
                        if ($alerted) {
                            $lowStockAlerts[] = $product->product_name;
                        }
                    }
                }
            }
 
            $this->logActivity(
                'create', 'sale',
                'Recorded sale #' . $sale->id
                . ' — ' . count($itemsToSave) . ' product(s)'
                . ', Total: ₱' . number_format($grandTotal, 2)
                . ', Payment: ' . $request->payment_status,
                null,
                $sale->toArray()
            );
 
            DB::commit();
 
            $message = 'Sale #' . $sale->id . ' recorded successfully!';
            if (!empty($lowStockAlerts)) {
                $message .= ' Low stock alert(s) for: ' . implode(', ', $lowStockAlerts);
            }
 
            return response()->json([
                'success'    => true,
                'message'    => $message,
                'sale_id'    => $sale->id,
                'low_stock'  => $lowStockAlerts,
            ]);
 
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Sale failed: ' . $e->getMessage(),
            ], 500);
        }
    }
 
    $request->validate([
        'product_id'     => 'required|exists:products,id',
        'quantity'       => 'required|integer|min:1',
        'payment_status' => 'required|in:Paid,Pending',
    ]);
 
    DB::beginTransaction();
    try {
        $product  = Product::findOrFail($request->product_id);
 
        if ($request->payment_status === 'Paid' && $product->quantity < $request->quantity) {
            return redirect()->back()->with(
                'error',
                'Insufficient stock! Only ' . $product->quantity . ' items available.'
            );
        }
 
        $subtotal = $product->price * $request->quantity;
        $status   = $request->payment_status === 'Paid' ? 'completed' : 'pending';
 
        $sale = Sale::create([
            'user_id'      => Auth::id(),
            'sale_date'    => now(),
            'status'       => $status,
            'total_amount' => $subtotal,
        ]);
 
        SaleDetail::create([
            'sale_id'    => $sale->id,
            'product_id' => $request->product_id,
            'quantity'   => $request->quantity,
            'price'      => $product->price,
            'subtotal'   => $subtotal,
        ]);
 
        $lowStockAlertCreated = false;
 
        if ($request->payment_status === 'Paid') {
            $product->quantity -= $request->quantity;
            $product->save();
 
            if ($product->quantity <= $product->min_stock_level) {
                $lowStockAlertCreated = $this->createAutomaticLowStockAlert($product);
            }
        }
 
        $this->logActivity(
            'create', 'sale',
            'Recorded sale #' . $sale->id
            . ' — Product: ' . $product->product_name
            . ', Qty: ' . $request->quantity
            . ', Total: ₱' . number_format($subtotal, 2)
            . ', Payment: ' . $request->payment_status,
            null,
            $sale->toArray()
        );
 
        DB::commit();
 
        $message = 'Sale recorded successfully!';
        if ($lowStockAlertCreated) {
            $message .= ' Low stock alert created for ' . $product->product_name . '!';
        }
 
        return Auth::user()->role === 'admin'
            ? redirect()->route('admin.sales')->with('success', $message)
            : redirect()->route('user.sales')->with('success', $message);
 
    } catch (\Exception $e) {
        DB::rollBack();
        return redirect()->back()->with('error', 'Sale failed: ' . $e->getMessage());
    }
}
    public function processPayment(Request $request, $id)
    {
        DB::beginTransaction();

        try {
            $sale = Sale::findOrFail($id);

            if ($sale->status != 'pending') {
                return redirect()->back()->with('error', 'This sale is already completed or canceled.');
            }

            $lowStockAlerts = [];

            foreach ($sale->saleDetails as $detail) {
                $product = Product::findOrFail($detail->product_id);
                if ($product->quantity < $detail->quantity) {
                    DB::rollBack();
                    return redirect()->back()->with('error', 'Insufficient stock for ' . $product->product_name);
                }
            }

            $sale->status = 'completed';
            $sale->save();

            foreach ($sale->saleDetails as $detail) {
                $product = Product::findOrFail($detail->product_id);
                $product->quantity -= $detail->quantity;
                $product->save();
                
                if ($product->quantity <= $product->min_stock_level) {
                    $alertCreated = $this->createAutomaticLowStockAlert($product);
                    if ($alertCreated) {
                        $lowStockAlerts[] = $product->product_name;
                    }
                }
            }

            $this->logActivity(
                'payment', 'sale',
                'Processed payment for sale #' . $sale->id .
                ' — Total: ₱' . number_format($sale->total_amount, 2)
            );

            DB::commit();

            $message = 'Payment processed successfully! Stock has been updated.';
            if (!empty($lowStockAlerts)) {
                $message .= 'Low stock alerts created for: ' . implode(', ', $lowStockAlerts);
            }

            return redirect()->route('admin.sales')->with('success', $message);

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to process payment: ' . $e->getMessage());
        }
    }

    public function getSaleDetails($id)
{
    $sale = Sale::with(['user', 'saleDetails.product'])->find($id);

    if (!$sale) {
        return response()->json(['error' => 'Sale not found'], 404);
    }

    return response()->json([
        'id' => $sale->id,
        'user' => $sale->user ? ['fullname' => $sale->user->fullname] : ['fullname' => 'N/A'],
        'sale_date' => $sale->sale_date ? $sale->sale_date->format('F j, Y g:i A') : 'N/A',
        'status' => $sale->status,
        'total_amount' => (float) $sale->total_amount,
        'sale_details' => $sale->saleDetails->map(function ($detail) {
            return [
                'quantity' => $detail->quantity,
                'price' => (float) $detail->price,
                'subtotal' => (float) $detail->subtotal,
                'product' => $detail->product ? ['product_name' => $detail->product->product_name] : ['product_name' => 'N/A'],
            ];
        }),
    ]);
}

    public function adminPurchases()
{
    $search = request('search');
    $query = Purchase::with(['user', 'supplier', 'purchaseDetails.product']);
    
    if ($search) {
        $query->where(function($q) use ($search) {
            $q->whereHas('supplier', function($q) use ($search) {
                $q->where('supplier_name', 'like', "%{$search}%");
            })->orWhere('batch_number', 'like', "%{$search}%");
        });
    }
    
    $purchases = $query->orderBy('id', 'desc')->paginate(15);
    $suppliers = Supplier::all();
    $products = Product::all();
    $allSuppliers = Supplier::select('id', 'supplier_name')->get();
    
    $allPurchases = Purchase::select('id', 'batch_number')->with('supplier')->orderBy('id', 'desc')->get()->map(function($purchase) {
        return [
            'batch_number' => $purchase->batch_number,
            'supplier_name' => $purchase->supplier->supplier_name ?? ''
        ];
    });
    
    return view('Admin.purchases', compact('purchases', 'suppliers', 'products', 'allSuppliers', 'allPurchases'));
}

    public function storePurchase(Request $request)
{
    $request->validate([
        'supplier_id' => 'required|exists:suppliers,id',
        'product_id'  => 'required|exists:products,id',
        'quantity'    => 'required|integer|min:1',
        'cost_price'  => 'required|numeric|min:0',
        'due_date'    => 'nullable|date|after:today',
    ]);

    DB::beginTransaction();

    try {
        $product = Product::findOrFail($request->product_id);
        $batchNumber = 'PO-' . strtoupper(substr(uniqid(), -4));
        $priceDifference = null;
        $originalProductPrice = $product->price;

        if ($request->cost_price != $originalProductPrice) {
            $difference = $request->cost_price - $originalProductPrice;
            $priceDifference = ($difference > 0 ? '+' : '') . number_format($difference, 2);
        }

        $purchase = Purchase::create([
            'user_id'        => Auth::id(),
            'supplier_id'    => $request->supplier_id,
            'purchase_date'  => now(),
            'status'         => 'pending',
            'batch_number'   => $batchNumber,
            'original_price' => $request->cost_price,
            'due_date'       => $request->due_date,
        ]);

        PurchaseDetail::create([
            'purchase_id' => $purchase->id,
            'product_id'  => $request->product_id,
            'quantity'    => $request->quantity,
            'cost_price'  => $request->cost_price,
        ]);

        $reportId = $request->input('report_id');
        if ($reportId) {
            $report = StockReport::find($reportId);
            if ($report && ($report->status == 'pending' || $report->status == 'read')) {
                $report->status = 'ordered';
                $report->purchase_id = $purchase->id;
                $priceNote = $priceDifference ? " Price difference: ₱{$priceDifference} from current price." : "";
                $report->admin_response = "Purchase order #{$purchase->id} created on " .
                    now()->format('M j, Y') . ". Ordered at ₱" .
                    number_format($request->cost_price, 2) . " per unit." . $priceNote;
                $report->save();

                $this->notifyUsersAboutOrder($report, $purchase);
            }
        }

        $this->logActivity(
            'create', 'purchase',
            'Created purchase order #' . $purchase->id . ' (' . $batchNumber . ')' .
            ' — Product: ' . $product->product_name .
            ', Qty: ' . $request->quantity .
            ', Cost: ₱' . number_format($request->cost_price, 2) .
            ($priceDifference ? ', Price diff: ₱' . $priceDifference : ''),
            null, $purchase->toArray()
        );

        DB::commit();

        $message = "Purchase order #{$purchase->id} ({$batchNumber}) created successfully!";
        if ($priceDifference) {
            $message .= " Note: Ordered at ₱" . number_format($request->cost_price, 2) .
                " (Current product price: ₱" . number_format($originalProductPrice, 2) . ")";
        }
        if ($purchase->due_date) {
            $message .= " Cancel available after due date: " . date('M j, Y', strtotime($purchase->due_date));
        }

        return redirect()->route('admin.purchases')->with('success', $message);

    } catch (\Exception $e) {
        DB::rollBack();
        return redirect()->back()->with('error', 'Failed to create purchase order: ' . $e->getMessage());
    }
}
    public function getUserNotifications(Request $request)
    {
        $userId = Auth::id();

        $query = StockReport::where('user_id', $userId)
            ->where('notify_users', true)
            ->orderBy('created_at', 'desc');

        // Add search functionality
        $search = $request->search;
        if ($search) {
            $query->where('product_name', 'like', "%{$search}%");
        }

        $status = $request->status;
        if ($status && $status != 'all') {
            $query->where('status', $status);
        }

        $notifications = $query->paginate(15);
        $notifications->appends(['search' => $search, 'status' => $status]);

        return view('Users.notifications', compact('notifications'));
    }

public function getUserNotificationsBell()
{
    $userId = Auth::id();

    $unreadCount = StockReport::where('user_id', $userId)
        ->where('status', 'pending')
        ->where('notify_users', true)
        ->count();

    $recentNotifications = StockReport::where('user_id', $userId)
        ->where('notify_users', true)
        ->where('status', 'pending')
        ->orderBy('created_at', 'desc')
        ->take(8)
        ->get()
        ->map(function($notification) {
            $product = Product::find($notification->product_id);
            $poStatus = null;
            if ($notification->purchase_id) {
                $purchase = Purchase::find($notification->purchase_id);
                $poStatus = $purchase ? $purchase->status : 'ordered';
            }
            return [
                'id'              => $notification->id,
                'product_id'      => $notification->product_id,
                'product_name'    => $notification->product_name,
                'message'         => $notification->message,
                'status'          => $notification->status,
                'time_ago'        => $notification->created_at->diffForHumans(),
                'current_stock'   => $product ? $product->quantity : $notification->current_stock,
                'min_stock_level' => $product ? $product->min_stock_level : $notification->min_stock_level,
                'po_status'       => $poStatus,
                'is_resolved'     => str_contains($notification->message, 'DAMAGE RESOLVED'),
            ];
        });

    return response()->json([
        'success'        => true,
        'unread_count'   => $unreadCount,
        'notifications'  => $recentNotifications,
    ]);
}
public function markUserNotificationAsRead(Request $request)
{
    $notification = StockReport::where('id', $request->notification_id)
        ->where('user_id', Auth::id())
        ->where('notify_users', true)
        ->first();

    if ($notification) {
        $notification->status = 'read';
        $notification->user_notified = true;
        $notification->save();
        return response()->json(['success' => true]);
    }

    return response()->json(['success' => false]);
}
public function markUserNotificationAsReceived(Request $request)
{
    $notification = StockReport::where('id', $request->notification_id)
        ->where('user_id', Auth::id())
        ->first();
    
    if ($notification) {
        $notification->status = 'ordered';
        $notification->user_notified = true;
        $notification->save();
        
        return response()->json(['success' => true]);
    }
    
    return response()->json(['success' => false]);
}
public function getUserUnreadCount()
{
    $count = StockReport::where('user_id', Auth::id())
        ->where('status', 'pending')
        ->where('notify_users', true)
        ->count();
    
    return response()->json(['count' => $count]);
}

    public function completePurchase($id)
{
    DB::beginTransaction();

    try {
        $purchase = Purchase::findOrFail($id);

        if ($purchase->status != 'pending') {
            return redirect()->back()->with('error', 'This purchase order is already completed or canceled.');
        }

        $updatedProducts = [];
        $priceDrops = [];
        $restockedProducts = [];

        foreach ($purchase->purchaseDetails as $detail) {
            $product = Product::findOrFail($detail->product_id);
            $oldQuantity = $product->quantity;
            $product->quantity += $detail->quantity;
            $product->save();
            $updatedProducts[] = $product->product_name . ' (+' . $detail->quantity . ')';
            
            if ($oldQuantity <= $product->min_stock_level && $product->quantity > $product->min_stock_level) {
                $restockedProducts[] = $product->product_name;
                $this->removeLowStockAlertWhenRestocked($product);
            }

            if ($detail->cost_price > $product->price) {
                $priceDrops[] = $product->product_name .
                    ': Ordered at ₱' . number_format($detail->cost_price, 2) .
                    ', Current: ₱' . number_format($product->price, 2);
            }
        }

        $purchase->status = 'completed';
        $purchase->save();

        $this->logActivity(
            'receive', 'purchase',
            'Received purchase order #' . $purchase->id .
            ' (' . $purchase->batch_number . ')' .
            ' — Stock updated: ' . implode(', ', $updatedProducts) .
            (!empty($priceDrops) ? ' | Price drops: ' . implode('; ', $priceDrops) : '')
        );

        DB::commit();

        $message = "Purchase order #{$purchase->id} completed! Stock updated: " . implode(', ', $updatedProducts);
        if (!empty($priceDrops)) {
            $message .= " Note: Price drops detected - " . implode('; ', $priceDrops);
        }
        if (!empty($restockedProducts)) {
            $message .= " Low stock alerts removed for: " . implode(', ', $restockedProducts);
        }

        $route = Auth::user()->role === 'admin' ? 'admin.purchases' : 'user.purchases';
        return redirect()->route($route)->with('success', $message);

    } catch (\Exception $e) {
        DB::rollBack();
        return redirect()->back()->with('error', 'Failed to complete purchase: ' . $e->getMessage());
    }
}
    public function cancelPurchase($id)
{
    DB::beginTransaction();
    try {
        $purchase = Purchase::findOrFail($id);

        if ($purchase->status != 'pending') {
            return redirect()->back()->with('error', 'This purchase order is already completed or canceled.');
        }

        if ($purchase->due_date && \Carbon\Carbon::parse($purchase->due_date)->isFuture()) {
            $dueDateFormatted = \Carbon\Carbon::parse($purchase->due_date)->format('M j, Y');
            return redirect()->back()->with('error',
                "Cannot cancel this order yet. Cancellation is only available after the due date: {$dueDateFormatted}"
            );
        }

        $purchase->status = 'canceled';
        $purchase->save();

        foreach ($purchase->purchaseDetails as $detail) {
            $product = Product::find($detail->product_id);
            if ($product && $product->quantity <= $product->min_stock_level) {
                StockReport::where('product_id', $product->id)
                    ->where('user_name', 'System (Auto Alert)')
                    ->where('status', 'ordered')
                    ->delete();

                StockReport::where('purchase_id', $purchase->id)
                    ->where('notify_users', false)
                    ->update(['status' => 'pending', 'purchase_id' => null]);

                StockReport::create([
                    'user_id'         => Auth::id(),
                    'user_name'       => 'System (Auto Alert)',
                    'product_id'      => $product->id,
                    'product_name'    => $product->product_name,
                    'current_stock'   => $product->quantity,
                    'min_stock_level' => $product->min_stock_level,
                    'message'         => "PO CANCELLED - RESTOCK NEEDED: Purchase Order #{$purchase->id} for '{$product->product_name}' was cancelled. Current stock: {$product->quantity} units (Min: {$product->min_stock_level}). Please create a new purchase order!",
                    'status'          => 'pending',
                    'user_notified'   => false,
                    'notify_users'    => false,
                ]);
            }
        }

        $this->logActivity(
            'cancel', 'purchase',
            'Canceled purchase order #' . $purchase->id .
            ' (' . $purchase->batch_number . ')'
        );

        DB::commit();
        return redirect()->route('admin.purchases')->with('success', 'Purchase order canceled. Low stock alert re-created for affected products.');

    } catch (\Exception $e) {
        DB::rollBack();
        return redirect()->back()->with('error', 'Failed to cancel purchase: ' . $e->getMessage());
    }
}
    public function adminReports()
    {
        return view('Admin.reports');
    }

    public function generateReport(Request $request)
{
    $startDate = $request->start_date;
    $endDate = $request->end_date . ' 23:59:59';
    $reportType = $request->report_type;
    $page = $request->page ?? 1;
    $perPage = 15;
    $search = $request->search ?? '';
    $statusFilter = $request->status ?? 'all';
    
    $transactions = collect();
    
    if ($reportType == 'sales' || $reportType == 'all') {
        $salesQuery = Sale::with(['saleDetails.product.category', 'user'])
            ->whereBetween('sale_date', [$startDate, $endDate]);
        
        if ($statusFilter !== 'all') {
            $salesQuery->where('status', $statusFilter);
        }
        
        $sales = $salesQuery->orderBy('sale_date', 'desc')->get();
        
        foreach ($sales as $sale) {
            foreach ($sale->saleDetails as $detail) {
                $productName = $detail->product->product_name ?? 'N/A';
                $categoryName = $detail->product->category->category_name ?? 'N/A';
                
                if (!empty($search) && stripos($productName, $search) === false && stripos($categoryName, $search) === false) {
                    continue;
                }
                
                $transactions->push((object)[
                    'date' => $sale->sale_date,
                    'type' => 'Sale',
                    'product' => $productName,
                    'category' => $categoryName,
                    'quantity' => $detail->quantity,
                    'amount' => $detail->subtotal,
                    'status' => $sale->status,
                    'reference_id' => $sale->id, 
                    'reference_type' => 'sale'
                ]);
            }
        }
    }
    
    if ($reportType == 'purchases' || $reportType == 'all') {
        $purchasesQuery = Purchase::with(['purchaseDetails.product.category', 'supplier'])
            ->whereBetween('purchase_date', [$startDate, $endDate]);
        
        if ($statusFilter !== 'all') {
            $purchasesQuery->where('status', $statusFilter);
        }
        
        $purchases = $purchasesQuery->orderBy('purchase_date', 'desc')->get();
        
        foreach ($purchases as $purchase) {
            foreach ($purchase->purchaseDetails as $detail) {
                $productName = $detail->product->product_name ?? 'N/A';
                $categoryName = $detail->product->category->category_name ?? 'N/A';
                
                if (!empty($search) && stripos($productName, $search) === false && stripos($categoryName, $search) === false) {
                    continue;
                }
                
                $transactions->push((object)[
                    'date' => $purchase->purchase_date,
                    'type' => 'Purchase',
                    'product' => $productName,
                    'category' => $categoryName,
                    'quantity' => $detail->quantity,
                    'amount' => $detail->quantity * $detail->cost_price,
                    'status' => $purchase->status,
                    'reference_id' => $purchase->id,
                    'reference_type' => 'purchase'
                ]);
            }
        }
    }
    
    $transactions = $transactions->sortByDesc('date')->values();
    
    $totalRevenue = $transactions->where('type', 'Sale')->sum('amount');
    $totalTransactions = $transactions->count();
    $avgTransaction = $totalTransactions > 0 ? $totalRevenue / $totalTransactions : 0;
    
    $productSales = [];
    foreach ($transactions as $transaction) {
        if ($transaction->type == 'Sale') {
            $productName = $transaction->product;
            if (!isset($productSales[$productName])) {
                $productSales[$productName] = 0;
            }
            $productSales[$productName] += $transaction->quantity;
        }
    }
    $topProduct = !empty($productSales) ? array_keys($productSales, max($productSales))[0] : '—';
    
    $lowStockProducts = Product::whereColumn('quantity', '<=', 'min_stock_level')
        ->get(['product_name', 'quantity', 'min_stock_level']);
    
    $monthlySales = Sale::whereBetween('sale_date', [$startDate, $endDate])
        ->where('status', 'completed')
        ->selectRaw('MONTH(sale_date) as month, SUM(total_amount) as total')
        ->groupBy('month')
        ->orderBy('month')
        ->get();
    
    $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
    $monthlySalesData = array_fill(0, 12, 0);
    foreach ($monthlySales as $sale) {
        $monthlySalesData[$sale->month - 1] = (float)$sale->total;
    }
    
    $categories = Category::with('products')->get();
    $categoryLabels = [];
    $categoryValues = [];
    $categoryTableData = [];
    foreach ($categories as $category) {
        $totalItems = $category->products->sum('quantity');
        if ($totalItems > 0) {
            $categoryLabels[] = $category->category_name;
            $categoryValues[] = $totalItems;
            $categoryTableData[] = [
                'name' => $category->category_name,
                'totalItems' => $totalItems,
            ];
        }
    }
    
    $paginatedTransactions = $transactions->forPage($page, $perPage)->values();
    
    return response()->json([
        'success' => true,
        'transactions' => $paginatedTransactions,
        'pagination' => [
            'current_page' => (int)$page,
            'last_page' => ceil($totalTransactions / $perPage),
            'per_page' => $perPage,
            'total' => $totalTransactions,
            'from' => (($page - 1) * $perPage) + 1,
            'to' => min($page * $perPage, $totalTransactions),
        ],
        'totalRevenue' => $totalRevenue,
        'totalTransactions' => $totalTransactions,
        'avgTransaction' => $avgTransaction,
        'topProduct' => $topProduct,
        'lowStockProducts' => $lowStockProducts,
        'monthlyLabels' => $months,
        'monthlySales' => $monthlySalesData,
        'categoryLabels' => $categoryLabels,
        'categoryValues' => $categoryValues,
        'categories' => $categoryTableData
    ]);
}
    
    public function adminUsers()
    {
        $search = request('search');
        $query = UserManagement::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('fullname', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $users = $query->paginate(10);
        $allUsers = UserManagement::select('id', 'fullname', 'email')->get();

        return view('Admin.users', compact('users', 'allUsers'));
    }

    public function storeUser(Request $request)
    {
        $request->validate([
            'fullname' => 'required|string|max:255',
            'email'    => 'required|email|unique:user_management,email',
            'password' => 'required|min:6',
            'role'     => 'required|in:admin,user',
        ]);

        $user = UserManagement::create([
            'fullname' => $request->fullname,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
        ]);

        $this->logActivity(
            'create', 'user',
            'Created user: ' . $user->fullname .
            ' (' . $user->email . ') — Role: ' . ucfirst($user->role)
        );

        return redirect()->route('admin.users')->with('success', 'User created successfully!');
    }

    public function updateUser(Request $request, $id)
{
    $user = UserManagement::findOrFail($id);

    $request->validate([
        'fullname' => 'required|string|max:255',
        'email'    => 'required|email|unique:user_management,email,' . $id,
        'role'     => 'required|in:admin,user',
    ]);

    $oldData = $user->only(['fullname', 'email', 'role']);
    
    $user->fullname = $request->fullname;
    $user->email = $request->email;
    $user->role = $request->role;

    if ($request->filled('password')) {
        $user->password = Hash::make($request->password);
    }
    $user->save();

    $this->logActivity(
        'update', 'user',
        'Updated user: ' . $user->fullname .
        ' (' . $user->email . ') — Role: ' . ucfirst($user->role),
        $oldData
    );

    return redirect()->route('admin.users')->with('success', 'User updated successfully!');
}

    public function deleteUser($id)
    {
        $user = UserManagement::findOrFail($id);

        if ($user->id == Auth::id()) {
            return redirect()->route('admin.users')->with('error', 'You cannot delete your own account!');
        }

        $this->logActivity(
            'delete', 'user',
            'Deleted user: ' . $user->fullname . ' (' . $user->email . ')',
            $user->only(['fullname', 'email', 'role'])
        );

        $user->delete();

        return redirect()->route('admin.users')->with('success', 'User deleted successfully!');
    }

    public function logs(Request $request)
{
    $search = $request->search;
    $module = $request->module;
    $action = $request->action;
    
    $query = ActivityLog::query();
    
    if ($search) {
        $query->where(function($q) use ($search) {
            $q->where('user_name', 'like', "%{$search}%")
              ->orWhere('description', 'like', "%{$search}%")
              ->orWhere('ip_address', 'like', "%{$search}%");
        });
    }
    
    if ($module && $module != 'all') {
        $query->where('module', $module);
    }
    
    if ($action && $action != 'all') {
        $query->where('action', $action);
    }

    $totalRecords = $query->count();
    $logs = $query->orderBy('created_at', 'desc')->paginate(30);
    
    return view('Admin.logs', compact('logs', 'totalRecords'));
}

    public function userDashboard()
{
    $totalProducts = Product::count();
    $lowStockProducts = Product::whereColumn('quantity', '<=', 'min_stock_level')->count();
    $todaySales = Sale::whereDate('sale_date', today())->sum('total_amount');
    $totalSales = Sale::sum('total_amount');
    $completedSales = Sale::where('status', 'completed')->sum('total_amount');
    $pendingSales = Sale::where('status', 'pending')->sum('total_amount');

    $todayStart = today()->startOfDay();
    $todayEnd   = today()->endOfDay();
    $perPage    = 15;
    $currentPage = request()->get('page', 1);

    $allTransactions = collect();

    $todaySalesRecords = Sale::with(['saleDetails.product.category', 'user'])
        ->whereBetween('sale_date', [$todayStart, $todayEnd])
        ->latest()->get();

    foreach ($todaySalesRecords as $sale) {
        foreach ($sale->saleDetails as $detail) {
            $allTransactions->push((object)[
                'type'         => 'Sale',
                'product'      => $detail->product->product_name ?? 'N/A',
                'category'     => $detail->product->category->category_name ?? 'N/A',
                'quantity'     => $detail->quantity,
                'amount'       => $detail->subtotal,
                'date'         => $sale->sale_date,
                'status'       => $sale->status,
                'reference_id' => $sale->id,
            ]);
        }
    }

    $allTransactions = $allTransactions->sortByDesc('date')->values();

    $recentTransactions = new \Illuminate\Pagination\LengthAwarePaginator(
        $allTransactions->forPage($currentPage, $perPage)->values(),
        $allTransactions->count(),
        $perPage,
        $currentPage,
        ['path' => request()->url(), 'query' => request()->query()]
    );

    $lowStockItems       = Product::whereColumn('quantity', '<=', 'min_stock_level')->take(5)->get();
    $categoryDistribution = Category::withCount('products')->get();
    $salesData = Sale::selectRaw('MONTH(sale_date) as month, SUM(total_amount) as total')
        ->whereYear('sale_date', date('Y'))
        ->where('status', 'completed')
        ->groupBy('month')->orderBy('month')->get();

    return view('Users.dashboard', compact(
        'totalProducts','lowStockProducts','todaySales','totalSales',
        'completedSales','pendingSales','recentTransactions',
        'lowStockItems','categoryDistribution','salesData'
    ));
}

    public function userProducts()
    {
        $search = request('search');
        $status = request('status');
        $query = Product::with(['category', 'supplier']);

        if ($search) {
            $query->where('product_name', 'like', "%{$search}%");
        }

        if ($status == 'instock') {
            $query->whereColumn('quantity', '>', 'min_stock_level');
        } elseif ($status == 'lowstock') {
            $query->whereColumn('quantity', '<=', 'min_stock_level')->where('quantity', '>', 0);
        } elseif ($status == 'outofstock') {
            $query->where('quantity', 0);
        }

        $products = $query->paginate(15);
        $allProducts = Product::with(['category', 'supplier'])->get();
        $categories = Category::all();
        $suppliers = Supplier::all();

        return view('Users.products', compact('products', 'categories', 'suppliers', 'allProducts'));
    }

    public function userSales()
    {
        $products = Product::all();
        $filter = request('filter', 'all');
        $query = Sale::with('user', 'saleDetails.product');

        if ($filter == 'today') {
            $query->whereDate('sale_date', today());
        } elseif ($filter == 'completed') {
            $query->where('status', 'completed');
        } elseif ($filter == 'pending') {
            $query->where('status', 'pending');
        }

        $sales = $query->orderBy('id', 'desc')->paginate(15);

        $today = now()->format('Y-m-d');
        $totalSalesToday = Sale::whereDate('sale_date', $today)->count();
        $totalRevenueToday = Sale::whereDate('sale_date', $today)->where('status', 'completed')->sum('total_amount');
        $pendingPayments = Sale::where('status', 'pending')->sum('total_amount');

        return view('Users.sales', compact(
            'sales', 'products', 'totalSalesToday',
            'totalRevenueToday', 'pendingPayments', 'filter'
        ));
    }

    public function userPurchases()
{
    $search = request('search');
    $query = Purchase::with(['user', 'supplier', 'purchaseDetails.product']);
    
    if ($search) {
        $query->where(function($q) use ($search) {
            $q->whereHas('supplier', function($q) use ($search) {
                $q->where('supplier_name', 'like', "%{$search}%");
            })->orWhere('batch_number', 'like', "%{$search}%");
        });
    }
    
    $purchases = $query->orderBy('id', 'desc')->paginate(15);
    $suppliers = Supplier::all();
    $products = Product::all();
    $allSuppliers = Supplier::select('id', 'supplier_name')->get();
    
    $allPurchases = Purchase::select('id', 'batch_number')->with('supplier')->orderBy('id', 'desc')->get()->map(function($purchase) {
        return [
            'id' => $purchase->id,
            'batch_number' => $purchase->batch_number,
            'supplier_name' => $purchase->supplier->supplier_name ?? ''
        ];
    });
    
    return view('Users.purchases', compact('purchases', 'suppliers', 'products', 'allSuppliers', 'allPurchases'));
}
public function getUserPurchaseDetails($id)
{
    $purchase = Purchase::with(['supplier', 'purchaseDetails.product'])->find($id);
    
    if (!$purchase) {
        return response()->json(['error' => 'Purchase order not found'], 404);
    }
    
    $firstDetail = $purchase->purchaseDetails->first();
    
    return response()->json([
        'success' => true,
        'batch_number' => $purchase->batch_number ?? 'N/A',
        'supplier_name' => $purchase->supplier->supplier_name ?? 'N/A',
        'order_date' => $purchase->purchase_date ? $purchase->purchase_date->format('M j, Y g:i A') : 'N/A',
        'due_date' => $purchase->due_date ? \Carbon\Carbon::parse($purchase->due_date)->format('M j, Y') : 'Not set',
        'status' => $purchase->status,
        'product_name' => $firstDetail ? $firstDetail->product->product_name : 'N/A',
        'quantity' => $firstDetail ? $firstDetail->quantity : 0,
        'cost_price' => $firstDetail ? $firstDetail->cost_price : 0,
        'total' => $firstDetail ? ($firstDetail->quantity * $firstDetail->cost_price) : 0,
    ]);
}

    public function reportOutOfStock(Request $request)
{
    $request->validate([
        'product_id' => 'required|exists:products,id',
        'message'    => 'nullable|string',
    ]);

    $product = Product::findOrFail($request->product_id);
    
    $existingSystemReport = StockReport::where('product_id', $product->id)
        ->where('user_name', 'System (Auto Alert)')
        ->whereIn('status', ['pending', 'read', 'ordered'])
        ->first();
    
    if ($existingSystemReport) {
        return response()->json([
            'success' => false,
            'message' => 'This product already has an active stock alert. Admin has been notified and is processing it.',
        ]);
    }
    
    $existingUserReport = StockReport::where('product_id', $product->id)
        ->where('user_id', Auth::id())
        ->whereIn('status', ['pending', 'read'])
        ->first();
    
    if ($existingUserReport) {
        $statusText = $existingUserReport->status == 'pending' ? 'pending' : 'already been reviewed';
        return response()->json([
            'success' => false,
            'message' => 'You have already reported this product. It is ' . $statusText . '.',
        ]);
    }

    StockReport::create([
        'user_id'         => Auth::id(),
        'user_name'       => Auth::user()->fullname,
        'product_id'      => $product->id,
        'product_name'    => $product->product_name,
        'current_stock'   => $product->quantity,
        'min_stock_level' => $product->min_stock_level,
        'message'         => $request->message,
        'status'          => 'pending',
        'user_notified'   => false,
    ]);

    $this->logActivity(
        'report', 'stock',
        'Reported low/out of stock for product: ' . $product->product_name .
        ' | Current stock: ' . $product->quantity . ' units' .
        ' | Min required: ' . $product->min_stock_level . ' units'
    );

    return response()->json(['success' => true, 'message' => 'Stock report sent to admin']);
}
    public function markStockReportAsRead(Request $request)
{
    $report = StockReport::find($request->report_id);
    if ($report) {
        if ($report->status == 'pending') {
            $report->status = 'read';
            $report->save();

            $this->logActivity(
                'update', 'stock',
                'Marked stock report as read — Product: ' . $report->product_name
            );

            return response()->json(['success' => true, 'message' => 'Report marked as read']);
        }
        return response()->json(['success' => false, 'message' => 'Report is already ' . $report->status]);
    }
    return response()->json(['success' => false, 'message' => 'Report not found']);
}
    public function markStockReportAsOrdered(Request $request)
    {
        $report = StockReport::find($request->report_id);
        if ($report) {
            if ($report->status == 'pending' || $report->status == 'read') {
                $report->status = 'ordered';
                $report->save();

                $this->logActivity(
                    'update', 'stock',
                    'Marked stock report as ordered — Product: ' . $report->product_name
                );

                return redirect()->back()->with('success', 'Report marked as ordered');
            }
            return redirect()->back()->with('error', 'Report is already ' . $report->status);
        }
        return redirect()->back()->with('error', 'Report not found');
    }

    public function stockReports()
{
    $search = request('search');
    $status = request('status');
    $type   = request('type'); 
    
    $query = StockReport::where('notify_users', false)
        ->orderBy('created_at', 'desc');
    
    if ($search) {
        $query->where(function($q) use ($search) {
            $q->where('product_name', 'like', "%{$search}%")
              ->orWhere('user_name', 'like', "%{$search}%");
        });
    }
    
    if ($status && $status != 'all') {
        $query->where('status', $status);
    }

    if ($type === 'damage') {
        $query->where('message', 'like', '%DAMAGE REPORT%');
    } elseif ($type === 'lowstock') {
        $query->where('message', 'not like', '%DAMAGE REPORT%');
    }
    
    $reports = $query->paginate(15);
    $reports->appends(['search' => $search, 'status' => $status, 'type' => $type]);
    
    return view('Admin.stock_reports', compact('reports'));
}
    public function userNotifications()
    {
        $notifications = StockReport::where('user_id', Auth::id())
            ->whereIn('status', ['ordered', 'completed'])
            ->orderBy('updated_at', 'desc')
            ->paginate(15);

        return view('Users.notifications', compact('notifications'));
    }

    public function markUserNotificationsAsRead()
    {
        StockReport::where('user_id', Auth::id())
            ->where('user_notified', false)
            ->update(['user_notified' => true]);

        return response()->json(['success' => true]);
    }

    public function getPurchaseDetails($id)
{
    $purchase = Purchase::with(['supplier', 'purchaseDetails.product.category'])->find($id);

    if (!$purchase) {
        return response()->json(['error' => 'Purchase order not found'], 404);
    }

    $items = [];
    $totalAmount = 0;
    
    foreach ($purchase->purchaseDetails as $detail) {
        $itemTotal = $detail->quantity * $detail->cost_price;
        $totalAmount += $itemTotal;
        
        $items[] = [
            'product_name' => $detail->product->product_name ?? 'N/A',
            'quantity' => $detail->quantity,
            'cost_price' => (float) $detail->cost_price,
            'total' => (float) $itemTotal,
        ];
    }

    $priceDrop = null;
    if ($purchase->original_price && $purchase->purchaseDetails->first()) {
        $firstDetail = $purchase->purchaseDetails->first();
        if ($firstDetail && $purchase->original_price > $firstDetail->cost_price) {
            $priceDrop = "Price dropped from ₱" . number_format($purchase->original_price, 2) .
                " to ₱" . number_format($firstDetail->cost_price, 2);
        }
    }

    $firstItem = $items[0] ?? null;
    
    return response()->json([
        'success' => true,
        'batch_number' => $purchase->batch_number ?? 'N/A',
        'supplier_name' => $purchase->supplier->supplier_name ?? 'N/A',
        'order_date' => $purchase->purchase_date ? $purchase->purchase_date->format('M j, Y g:i A') : 'N/A',
        'due_date' => $purchase->due_date ? \Carbon\Carbon::parse($purchase->due_date)->format('M j, Y') : 'Not set',
        'status' => $purchase->status,
        'items' => $items,
        'total_amount' => (float) $totalAmount,
        'product_name' => $firstItem ? $firstItem['product_name'] : 'N/A',
        'quantity' => $firstItem ? $firstItem['quantity'] : 0,
        'cost_price' => $firstItem ? $firstItem['cost_price'] : 0,
        'total' => $firstItem ? $firstItem['total'] : 0,
        'price_drop' => $priceDrop,
    ]);
}
private function removeLowStockAlertWhenRestocked($product)
{
    if ($product->quantity > $product->min_stock_level) {
        $deleted = StockReport::where('product_id', $product->id)
            ->where('user_name', 'System (Auto Alert)')
            ->where('status', 'pending')
            ->delete();
        
        if ($deleted > 0) {
            $this->logActivity(
                'auto_remove', 'stock',
                'Automatically removed low stock alert for: ' . $product->product_name .
                ' (Stock restored to ' . $product->quantity . ' units, Min: ' . $product->min_stock_level . ' units)'
            );
            return true;
        }
    }
    
    return false;
}
private function notifyUsersAboutOrder($stockReport, $purchase)
{
    $users = UserManagement::where('role', 'user')->get();
    
    foreach ($users as $user) {
        $existingNotification = StockReport::where('user_id', $user->id)
            ->where('product_id', $stockReport->product_id)
            ->where('notify_users', true)
            ->whereIn('status', ['pending', 'read'])
            ->first();
        
        if (!$existingNotification) {
            StockReport::create([
                'user_id' => $user->id,
                'user_name' => $user->fullname,
                'product_id' => $stockReport->product_id,
                'product_name' => $stockReport->product_name,
                'current_stock' => $stockReport->current_stock,
                'min_stock_level' => $stockReport->min_stock_level,
                'message' => "GOOD NEWS: Admin has created Purchase Order #{$purchase->id} for {$stockReport->product_name}. The product will be restocked soon!",
                'status' => 'pending',
                'user_notified' => false,
                'notify_users' => true,
                'admin_response' => "Purchase order #{$purchase->id} created",
                'purchase_id' => $purchase->id
            ]);
        }
    }
}
public function reportDamage(Request $request)
{
    $request->validate([
        'product_id' => 'required|exists:products,id',
        'product_name' => 'required|string',
        'damage_description' => 'required|string',
        'damage_quantity' => 'nullable|integer|min:1',
    ]);

    $product = Product::findOrFail($request->product_id);
    $damageQuantity = $request->damage_quantity ?? 1;
    
    $pendingDamageReport = StockReport::where('product_id', $request->product_id)
        ->where('message', 'like', '%DAMAGE REPORT%')
        ->where('status', 'pending')
        ->first();
    
    if ($pendingDamageReport) {
        return response()->json([
            'success' => false,
            'message' => 'You already have a pending damage report for this product.'
        ]);
    }

    $adminUser = UserManagement::where('role', 'admin')->first();
    
if ($adminUser) {
        StockReport::create([
            'user_id'          => $adminUser->id,
            'reporter_user_id' => Auth::id(),
            'user_name'        => Auth::user()->fullname,
            'product_id'       => $request->product_id,
            'product_name'     => $product->product_name,
            'current_stock'    => $product->quantity,
            'min_stock_level'  => $product->min_stock_level,
            'message'          => "DAMAGE REPORT: User " . Auth::user()->fullname . " reported {$damageQuantity} damaged item(s) for '{$product->product_name}'. " .
                                  "Description: {$request->damage_description} | Quantity affected: {$damageQuantity}",
            'status'           => 'pending',
            'user_notified'    => false,
            'notify_users'     => false,
        ]);
    }

    $this->logActivity(
        'report', 'stock',
        'Reported damage for product: ' . $product->product_name .
        ' | Quantity affected: ' . $damageQuantity .
        ' | Description: ' . $request->damage_description
    );

    return response()->json([
        'success' => true,
        'message' => 'Damage report sent to admin successfully!'
    ]);
}
public function getStockReportNotifications()
{
    $this->checkAndSyncLowStockAlerts();
    
    $reports = StockReport::where('status', 'pending')
        ->where('notify_users', false)
        ->orderBy('created_at', 'desc')
        ->take(15)
        ->get();
    
    $notifications = [];
    foreach ($reports as $report) {
        $product = Product::find($report->product_id);
        $isOutOfStock = ($report->current_stock == 0);
        
        $notifications[] = [
            'id' => $report->id,
            'product_id' => $report->product_id,
            'product_name' => $product ? $product->product_name : $report->product_name,
            'user_name' => $report->user_name,
            'current_stock' => $product ? $product->quantity : $report->current_stock,
            'min_stock_level' => $product ? $product->min_stock_level : $report->min_stock_level,
            'message' => $report->message,
            'time_ago' => $report->created_at->diffForHumans(),
            'is_system_alert' => ($report->user_name == 'System (Auto Alert)'),
            'is_out_of_stock' => $isOutOfStock,
            'is_damage' => str_contains($report->message, 'DAMAGE REPORT'),
            'damage_quantity' => $this->extractDamageQuantity($report->message)
        ];
    }
    
    return response()->json([
        'success' => true,
        'unread_count' => $reports->count(),
        'notifications' => $notifications
    ]);
}

private function extractDamageQuantity($message)
{
    if (preg_match('/(\d+)\s+damaged/i', $message, $matches)) {
        return (int)$matches[1];
    }
    if (preg_match('/Quantity affected:\s*(\d+)/i', $message, $matches)) {
        return (int)$matches[1];
    }
    return 1;
}
public function syncStockReportsData()
{
    $reports = StockReport::where('status', '!=', 'resolved')->get();
    $updatedCount = 0;
    
    foreach ($reports as $report) {
        $product = Product::find($report->product_id);
        if ($product) {
            if ($report->current_stock != $product->quantity) {
                $report->current_stock = $product->quantity;
                $report->save();
                $updatedCount++;
            }
            if ($report->min_stock_level != $product->min_stock_level) {
                $report->min_stock_level = $product->min_stock_level;
                $report->save();
                $updatedCount++;
            }
        }
    }
    
    return response()->json([
        'success' => true,
        'message' => "Updated {$updatedCount} stock reports with current product data."
    ]);
}
public function getProductData($id)
{
    $product = Product::with(['category', 'supplier'])->find($id);
    
    if ($product) {
        return response()->json([
            'success' => true,
            'product' => [
                'id' => $product->id,
                'product_name' => $product->product_name,
                'description' => $product->description,
                'price' => $product->price,
                'quantity' => $product->quantity,
                'min_stock_level' => $product->min_stock_level,
                'category_id' => $product->category_id,  
                'supplier_id' => $product->supplier_id,  
                'category_name' => $product->category ? $product->category->category_name : null,
                'supplier_name' => $product->supplier ? $product->supplier->supplier_name : null
            ]
        ]);
    }
    
    return response()->json(['success' => false, 'message' => 'Product not found']);
}
public function forceCreateLowStockAlerts()
{
    $lowStockProducts = Product::whereColumn('quantity', '<=', 'min_stock_level')->get();
    $createdCount = 0;
    
    foreach ($lowStockProducts as $product) {
        StockReport::where('product_id', $product->id)
            ->where('user_name', 'System (Auto Alert)')
            ->where('status', 'pending')
            ->delete();
        
        $adminUser = UserManagement::where('role', 'admin')->first();
        
        StockReport::create([
            'user_id' => $adminUser ? $adminUser->id : 1,
            'user_name' => 'System (Auto Alert)',
            'product_id' => $product->id,
            'product_name' => $product->product_name,
            'current_stock' => $product->quantity,
            'min_stock_level' => $product->min_stock_level,
            'message' => "AUTOMATIC ALERT: {$product->product_name} has fallen below minimum stock level. Current stock: {$product->quantity} units (Min required: {$product->min_stock_level})",
            'status' => 'pending',
            'user_notified' => false,
            'notify_users' => false,
        ]);
        
        $createdCount++;
    }
    
    return response()->json([
        'success' => true,
        'message' => "Created {$createdCount} low stock alerts",
        'products' => $lowStockProducts->pluck('product_name')
    ]);
}

public function getUserSaleDetails($id)
{
    $sale = Sale::with(['user', 'saleDetails.product'])->find($id);
 
    if (!$sale) {
        return response()->json(['error' => 'Sale not found'], 404);
    }
 
    return response()->json([
        'id'           => $sale->id,
        'user'         => $sale->user
                            ? ['fullname' => $sale->user->fullname]
                            : ['fullname' => 'N/A'],
        'sale_date'    => $sale->sale_date
                            ? $sale->sale_date->format('F j, Y g:i:s A')
                            : 'N/A',
        'status'       => $sale->status,
        'total_amount' => (float) $sale->total_amount,
        'sale_details' => $sale->saleDetails->map(function ($detail) {
            return [
                'quantity' => $detail->quantity,
                'price'    => (float) $detail->price,
                'subtotal' => (float) $detail->subtotal,
                'product'  => $detail->product
                                ? ['product_name' => $detail->product->product_name]
                                : ['product_name' => 'N/A'],
            ];
        }),
    ]);
}

public function processUserPayment(Request $request, $id)
{
    DB::beginTransaction();

    try {
        $sale = Sale::findOrFail($id);

        if ($sale->status != 'pending') {
            return redirect()->back()->with('error', 'This sale is already completed or canceled.');
        }

        $lowStockAlerts = [];

        foreach ($sale->saleDetails as $detail) {
            $product = Product::findOrFail($detail->product_id);
            if ($product->quantity < $detail->quantity) {
                DB::rollBack();
                return redirect()->back()->with('error', 'Insufficient stock for ' . $product->product_name);
            }
        }

        $sale->status = 'completed';
        $sale->save();

        foreach ($sale->saleDetails as $detail) {
            $product = Product::findOrFail($detail->product_id);
            $product->quantity -= $detail->quantity;
            $product->save();
            
            if ($product->quantity <= $product->min_stock_level) {
                $alertCreated = $this->createAutomaticLowStockAlert($product);
                if ($alertCreated) {
                    $lowStockAlerts[] = $product->product_name;
                }
            }
        }

        DB::commit();

        $message = 'Payment processed successfully! Stock has been updated.';
        if (!empty($lowStockAlerts)) {
            $message .= ' Low stock alerts created for: ' . implode(', ', $lowStockAlerts);
        }

        return redirect()->route('user.sales')->with('success', $message);

    } catch (\Exception $e) {
        DB::rollBack();
        return redirect()->back()->with('error', 'Failed to process payment: ' . $e->getMessage());
    }
}
private function checkAndSyncLowStockAlerts()
{
    $lowStockProducts = Product::whereColumn('quantity', '<=', 'min_stock_level')->get();
    
    foreach ($lowStockProducts as $product) {
        $existingAlert = StockReport::where('product_id', $product->id)
            ->where('user_name', 'System (Auto Alert)')
            ->whereIn('status', ['pending', 'read', 'ordered', 'resolved'])  
            ->first();
        
        if ($existingAlert) {
            if ($existingAlert->current_stock != $product->quantity) {
                $existingAlert->current_stock = $product->quantity;
                $existingAlert->message = ($product->quantity == 0)
                    ? "OUT OF STOCK ALERT: {$product->product_name} is completely out of stock! Current stock: 0 units. Minimum required: {$product->min_stock_level} units. Immediate restock needed!"
                    : "LOW STOCK ALERT: {$product->product_name} has reached critical low stock level. Current stock: {$product->quantity} units. Minimum required: {$product->min_stock_level} units. Please restock soon!";
                $existingAlert->save();
            }
        } else {
            try{
                $adminUser = UserManagement::where('role', 'admin')->first();
                    StockReport::create([
                        'user_id'         => $adminUser ? $adminUser->id : 1,
                        'user_name'       => 'System (Auto Alert)',
                        'product_id'      => $product->id,
                        'product_name'    => $product->product_name,
                        'current_stock'   => $product->quantity,
                        'min_stock_level' => $product->min_stock_level,
                        'message'         => ($product->quantity == 0)
                            ? "OUT OF STOCK ALERT: {$product->product_name} is completely out of stock! Current stock: 0 units. Minimum required: {$product->min_stock_level} units. Immediate restock needed!"
                            : "LOW STOCK ALERT: {$product->product_name} has reached critical low stock level. Current stock: {$product->quantity} units. Minimum required: {$product->min_stock_level} units. Please restock soon!",
                        'status'          => 'pending',
                        'user_notified'   => false,
                        'notify_users'    => false,
                    ]);
                } catch (\Illuminate\Database\UniqueConstraintViolationException $e) {
            }
        }
    }
    
    $restockedProducts = Product::whereColumn('quantity', '>', 'min_stock_level')->get();
    foreach ($restockedProducts as $product) {
        StockReport::where('product_id', $product->id)
            ->where('user_name', 'System (Auto Alert)')
            ->whereIn('status', ['pending', 'read']) 
            ->delete();
    }
}

}