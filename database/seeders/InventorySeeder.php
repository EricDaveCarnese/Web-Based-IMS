<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UserManagement;
use App\Models\Category;
use App\Models\Supplier;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\Purchase;
use App\Models\PurchaseDetail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class InventorySeeder extends Seeder
{
    public function run()
    {
        // Clear existing data
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        PurchaseDetail::truncate();
        Purchase::truncate();
        SaleDetail::truncate();
        Sale::truncate();
        Product::truncate();
        Supplier::truncate();
        Category::truncate();
        UserManagement::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $this->command->info('Creating users...');
        
        // Create Admin Users
        UserManagement::create([
            'fullname' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);
        
        UserManagement::create([
            'fullname' => 'Jamaica',
            'email' => 'jamaica@example.com',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);
        
        UserManagement::create([
            'fullname' => 'Jane Doe',
            'email' => 'jane@example.com',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);

        $this->command->info('Creating 8 categories...');
        
        // Create 8 Categories
        $categories = [
            ['category_name' => 'Electronics', 'description' => 'Electronic devices and accessories'],
            ['category_name' => 'School Supplies', 'description' => 'Educational and office supplies'],
            ['category_name' => 'Office Equipment', 'description' => 'Office furniture and equipment'],
            ['category_name' => 'Motorparts', 'description' => 'Motorcycle parts and accessories'],
            ['category_name' => 'Safety Gear', 'description' => 'Protective equipment and safety gear'],
            ['category_name' => 'Furniture', 'description' => 'Home and office furniture'],
            ['category_name' => 'Tools & Hardware', 'description' => 'Hand tools and hardware supplies'],
            ['category_name' => 'Clothing & Apparel', 'description' => 'Clothes and fashion accessories'],
        ];
        
        $categoryModels = [];
        foreach ($categories as $cat) {
            $categoryModels[] = Category::create($cat);
        }

        $this->command->info('Creating suppliers...');
        
        // Create Suppliers
        $suppliers = [
            ['supplier_name' => 'Tech Distributors Inc.', 'email' => 'sales@techdist.com', 'contact_number' => '09123456789', 'address' => '123 Tech Street, Makati City', 'contact_person' => 'John Reyes'],
            ['supplier_name' => 'Office Warehouse PH', 'email' => 'orders@officewarehouse.ph', 'contact_number' => '09876543210', 'address' => '456 Commerce Ave, Pasig City', 'contact_person' => 'Maria Santos'],
            ['supplier_name' => 'Motorland PH', 'email' => 'info@motorland.ph', 'contact_number' => '09234567890', 'address' => '789 Motor Ave, Quezon City', 'contact_person' => 'Ramon Cruz'],
            ['supplier_name' => 'Safety Pro Trading', 'email' => 'orders@safetypro.com', 'contact_number' => '09345678901', 'address' => '321 Safety St, Mandaluyong City', 'contact_person' => 'Anna Reyes'],
            ['supplier_name' => 'Furniture Depot', 'email' => 'sales@furnituredepot.ph', 'contact_number' => '09456789012', 'address' => '555 Furniture Road, Taguig City', 'contact_person' => 'Carlos Lopez'],
            ['supplier_name' => 'Hardware Hub', 'email' => 'info@hardwarehub.com', 'contact_number' => '09567890123', 'address' => '777 Hardware St, Pasay City', 'contact_person' => 'Mario Santos'],
            ['supplier_name' => 'Fashion Wholesale PH', 'email' => 'orders@fashionwholesale.ph', 'contact_number' => '09678901234', 'address' => '888 Fashion Ave, Manila City', 'contact_person' => 'Liza Soberano'],
        ];
        
        $supplierModels = [];
        foreach ($suppliers as $sup) {
            $supplierModels[] = Supplier::create($sup);
        }

        $this->command->info('Creating 3 products per category (24 total products)...');
        
        // Define products for each category (3 products per category)
        $productsData = [
            // Electronics (Category 1)
            [
                'product_name' => 'Wireless Mouse',
                'description' => 'Ergonomic wireless mouse with USB receiver',
                'price' => 589.00,
                'quantity' => 50,
                'min_stock_level' => 10,
                'supplier_id' => $supplierModels[0]->id
            ],
            [
                'product_name' => 'Mechanical Keyboard',
                'description' => 'RGB mechanical gaming keyboard',
                'price' => 2400.00,
                'quantity' => 30,
                'min_stock_level' => 5,
                'supplier_id' => $supplierModels[0]->id
            ],
            [
                'product_name' => 'Gaming Headset',
                'description' => '7.1 Surround sound gaming headset',
                'price' => 1500.00,
                'quantity' => 25,
                'min_stock_level' => 8,
                'supplier_id' => $supplierModels[0]->id
            ],
            
            // School Supplies (Category 2)
            [
                'product_name' => 'Notebook (Pack of 5)',
                'description' => 'A5 ruled notebooks, 80 pages each',
                'price' => 199.00,
                'quantity' => 200,
                'min_stock_level' => 50,
                'supplier_id' => $supplierModels[1]->id
            ],
            [
                'product_name' => 'Ballpen (Box of 50)',
                'description' => 'Blue ink ballpoint pens',
                'price' => 499.00,
                'quantity' => 150,
                'min_stock_level' => 30,
                'supplier_id' => $supplierModels[1]->id
            ],
            [
                'product_name' => 'Correction Tape (Pack of 10)',
                'description' => 'White correction tape, 6m each',
                'price' => 299.00,
                'quantity' => 100,
                'min_stock_level' => 20,
                'supplier_id' => $supplierModels[1]->id
            ],
            
            // Office Equipment (Category 3)
            [
                'product_name' => 'Office Chair',
                'description' => 'Ergonomic mesh office chair',
                'price' => 5499.00,
                'quantity' => 15,
                'min_stock_level' => 3,
                'supplier_id' => $supplierModels[1]->id
            ],
            [
                'product_name' => 'Executive Table',
                'description' => 'Wooden executive office desk',
                'price' => 12500.00,
                'quantity' => 8,
                'min_stock_level' => 2,
                'supplier_id' => $supplierModels[1]->id
            ],
            [
                'product_name' => 'Filing Cabinet',
                'description' => 'Steel 4-drawer filing cabinet',
                'price' => 3800.00,
                'quantity' => 12,
                'min_stock_level' => 3,
                'supplier_id' => $supplierModels[1]->id
            ],
            
            // Motorparts (Category 4)
            [
                'product_name' => 'Pitsbike bore kit 62mm',
                'description' => 'For engine performance upgrade',
                'price' => 5000.00,
                'quantity' => 9,
                'min_stock_level' => 10,
                'supplier_id' => $supplierModels[2]->id
            ],
            [
                'product_name' => 'Piston kit',
                'description' => 'Engine piston replacement kit',
                'price' => 500.00,
                'quantity' => 16,
                'min_stock_level' => 10,
                'supplier_id' => $supplierModels[2]->id
            ],
            [
                'product_name' => 'TB 36mm',
                'description' => 'Throttle body for better performance',
                'price' => 6500.00,
                'quantity' => 21,
                'min_stock_level' => 10,
                'supplier_id' => $supplierModels[2]->id
            ],
            
            // Safety Gear (Category 5)
            [
                'product_name' => 'Helmet',
                'description' => 'For head protection',
                'price' => 3500.00,
                'quantity' => 12,
                'min_stock_level' => 10,
                'supplier_id' => $supplierModels[3]->id
            ],
            [
                'product_name' => 'Breaklight Switch',
                'description' => 'Motorcycle brake light switch',
                'price' => 25.00,
                'quantity' => 10,
                'min_stock_level' => 10,
                'supplier_id' => $supplierModels[3]->id
            ],
            [
                'product_name' => 'Knee Guard',
                'description' => 'Protective knee guard for riding',
                'price' => 850.00,
                'quantity' => 20,
                'min_stock_level' => 8,
                'supplier_id' => $supplierModels[3]->id
            ],
            
            // Furniture (Category 6)
            [
                'product_name' => 'Study Desk',
                'description' => 'Adjustable height study desk',
                'price' => 3200.00,
                'quantity' => 18,
                'min_stock_level' => 5,
                'supplier_id' => $supplierModels[4]->id
            ],
            [
                'product_name' => 'Bookshelf',
                'description' => '5-layer wooden bookshelf',
                'price' => 2800.00,
                'quantity' => 14,
                'min_stock_level' => 4,
                'supplier_id' => $supplierModels[4]->id
            ],
            [
                'product_name' => 'Bed Frame',
                'description' => 'Queen size metal bed frame',
                'price' => 6800.00,
                'quantity' => 10,
                'min_stock_level' => 3,
                'supplier_id' => $supplierModels[4]->id
            ],
            
            // Tools & Hardware (Category 7)
            [
                'product_name' => 'Tool Set (32 pcs)',
                'description' => 'Complete home tool kit',
                'price' => 1200.00,
                'quantity' => 25,
                'min_stock_level' => 8,
                'supplier_id' => $supplierModels[5]->id
            ],
            [
                'product_name' => 'Drill Machine',
                'description' => 'Hammer drill 650W',
                'price' => 2500.00,
                'quantity' => 12,
                'min_stock_level' => 4,
                'supplier_id' => $supplierModels[5]->id
            ],
            [
                'product_name' => 'Measuring Tape',
                'description' => '5m steel tape measure',
                'price' => 150.00,
                'quantity' => 50,
                'min_stock_level' => 15,
                'supplier_id' => $supplierModels[5]->id
            ],
            
            // Clothing & Apparel (Category 8)
            [
                'product_name' => 'T-Shirt (Pack of 3)',
                'description' => 'Cotton crew neck t-shirts',
                'price' => 599.00,
                'quantity' => 80,
                'min_stock_level' => 20,
                'supplier_id' => $supplierModels[6]->id
            ],
            [
                'product_name' => 'Denim Jacket',
                'description' => 'Classic denim jacket',
                'price' => 1200.00,
                'quantity' => 25,
                'min_stock_level' => 8,
                'supplier_id' => $supplierModels[6]->id
            ],
            [
                'product_name' => 'Running Shoes',
                'description' => 'Lightweight athletic running shoes',
                'price' => 1800.00,
                'quantity' => 30,
                'min_stock_level' => 10,
                'supplier_id' => $supplierModels[6]->id
            ],
        ];
        
        // Create products with their respective categories
        $productIndex = 0;
        foreach ($categoryModels as $category) {
            for ($i = 0; $i < 3; $i++) {
                $productData = $productsData[$productIndex];
                Product::create([
                    'product_name' => $productData['product_name'],
                    'category_id' => $category->id,
                    'supplier_id' => $productData['supplier_id'],
                    'description' => $productData['description'],
                    'price' => $productData['price'],
                    'quantity' => $productData['quantity'],
                    'min_stock_level' => $productData['min_stock_level']
                ]);
                $productIndex++;
            }
        }

        $this->command->info('==========================================');
        $this->command->info('Database seeded successfully!');
        $this->command->info('==========================================');
        $this->command->info('Categories created: 8');
        $this->command->info('Products created: 24 (3 per category)');
        $this->command->info('Suppliers created: 7');
        $this->command->info('Users created: 3 (1 admin, 2 users)');
        $this->command->info('==========================================');
        $this->command->info('Admin Login: admin@example.com / password');
        $this->command->info('User Logins: jamaica@example.com / password');
        $this->command->info('             jane@example.com / password');
        $this->command->info('==========================================');
        $this->command->info('NOTE: No sales records have been created.');
        $this->command->info('      You can create sales through the system.');
        $this->command->info('==========================================');
    }
}