<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Ingredient;
use App\Models\Menu;
use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Multi-role Users (Admin, Kitchen Staff, Customer)
        $admin = User::updateOrCreate(
            ['email' => 'admin@somefood.com'],
            [
                'name' => 'Novan Admin',
                'phone' => '6281234567890',
                'role' => 'admin',
                'password' => Hash::make('password'),
            ]
        );

        $kitchen = User::updateOrCreate(
            ['email' => 'kitchen@somefood.com'],
            [
                'name' => 'Chef Budi (Kitchen Staff)',
                'phone' => '6281298765432',
                'role' => 'kitchen_staff',
                'password' => Hash::make('password'),
            ]
        );

        $customer = User::updateOrCreate(
            ['email' => 'customer@somefood.com'],
            [
                'name' => 'Rina Pelanggan',
                'phone' => '6281355556666',
                'role' => 'customer',
                'password' => Hash::make('password'),
            ]
        );

        // 2. Food Categories
        $categoriesData = [
            [
                'name' => 'Hidangan Utama',
                'slug' => 'hidangan-utama',
                'description' => 'Sajian utama khas Nusantara dan Western dengan bahan pilihan.',
                'image' => 'https://images.unsplash.com/photo-1544025162-d76694265947?auto=format&fit=crop&w=600&q=80',
            ],
            [
                'name' => 'Mie & Pasta',
                'slug' => 'mie-pasta',
                'description' => 'Aneka olahan mie artisan dan pasta Italia autentik.',
                'image' => 'https://images.unsplash.com/photo-1555949258-eb67b1ef0ceb?auto=format&fit=crop&w=600&q=80',
            ],
            [
                'name' => 'Camilan & Pembuka',
                'slug' => 'camilan-pembuka',
                'description' => 'Appetizer hangat dan camilan renyah pendamping santai.',
                'image' => 'https://images.unsplash.com/photo-1541592106381-b31e9677c0e5?auto=format&fit=crop&w=600&q=80',
            ],
            [
                'name' => 'Minuman Segar & Kopi',
                'slug' => 'minuman-kopi',
                'description' => 'Kopi spesialti, mocktail segar, dan teh premium.',
                'image' => 'https://images.unsplash.com/photo-1513558161293-cdaf765ed2fd?auto=format&fit=crop&w=600&q=80',
            ],
            [
                'name' => 'Hidangan Penutup',
                'slug' => 'hidangan-penutup',
                'description' => 'Dessert manis dan pastry segar yang menggugah selera.',
                'image' => 'https://images.unsplash.com/photo-1551024709-8f23befc6f87?auto=format&fit=crop&w=600&q=80',
            ],
        ];

        $categories = [];
        foreach ($categoriesData as $cat) {
            $categories[$cat['slug']] = Category::updateOrCreate(['slug' => $cat['slug']], $cat);
        }

        // 3. Menus
        $menusData = [
            [
                'category_id' => $categories['hidangan-utama']->id,
                'name' => 'Nasi Goreng Wagyu Spesial',
                'slug' => 'nasi-goreng-wagyu-spesial',
                'description' => 'Nasi goreng rempah autentik dengan potongan daging sapi Wagyu MB5, telur mata sapi organik, dan acar segar.',
                'price' => 68000,
                'image' => 'https://images.unsplash.com/photo-1603133872878-684f208fb84b?auto=format&fit=crop&w=800&q=80',
                'is_available' => true,
                'is_featured' => true,
                'preparation_time' => 15,
            ],
            [
                'category_id' => $categories['hidangan-utama']->id,
                'name' => 'Iga Bakar Madu Nusantara',
                'slug' => 'iga-bakar-madu-nusantara',
                'description' => 'Iga sapi empuk dibakar dengan olesan madu hutan dan bumbu rempah khas, disajikan bersama kuah kaldu hangat.',
                'price' => 95000,
                'image' => 'https://images.unsplash.com/photo-1544025162-d76694265947?auto=format&fit=crop&w=800&q=80',
                'is_available' => true,
                'is_featured' => true,
                'preparation_time' => 20,
            ],
            [
                'category_id' => $categories['hidangan-utama']->id,
                'name' => 'Grilled Norwegian Salmon',
                'slug' => 'grilled-norwegian-salmon',
                'description' => 'Fillet salmon Norwegia panggang dengan saus lemon butter, mashed potato lembut, dan asparagus segar.',
                'price' => 115000,
                'image' => 'https://images.unsplash.com/photo-1467003909585-2f8a72700288?auto=format&fit=crop&w=800&q=80',
                'is_available' => true,
                'is_featured' => false,
                'preparation_time' => 18,
            ],
            [
                'category_id' => $categories['mie-pasta']->id,
                'name' => 'Spaghetti Truffle Carbonara',
                'slug' => 'spaghetti-truffle-carbonara',
                'description' => 'Pasta al dente dengan saus creamy keju Parmigiano-Reggiano, smoked beef crispy, dan minyak jamur truffle.',
                'price' => 62000,
                'image' => 'https://images.unsplash.com/photo-1612874742237-6526221588e3?auto=format&fit=crop&w=800&q=80',
                'is_available' => true,
                'is_featured' => true,
                'preparation_time' => 12,
            ],
            [
                'category_id' => $categories['mie-pasta']->id,
                'name' => 'Bakmi Ayam Jamur Shiitake',
                'slug' => 'bakmi-ayam-jamur-shiitake',
                'description' => 'Mie telur buatan sendiri dengan topping ayam kampung cincang, jamur shiitake, dan pangsit rebus.',
                'price' => 45000,
                'image' => 'https://images.unsplash.com/photo-1569718212165-3a8278d5f624?auto=format&fit=crop&w=800&q=80',
                'is_available' => true,
                'is_featured' => false,
                'preparation_time' => 10,
            ],
            [
                'category_id' => $categories['camilan-pembuka']->id,
                'name' => 'Truffle Parmesan Fries',
                'slug' => 'truffle-parmesan-fries',
                'description' => 'Kentang goreng renyah dengan taburan keju parmesan parut, daun parsley, dan garlic aioli dip.',
                'price' => 38000,
                'image' => 'https://images.unsplash.com/photo-1576107232684-1279f3908594?auto=format&fit=crop&w=800&q=80',
                'is_available' => true,
                'is_featured' => false,
                'preparation_time' => 8,
            ],
            [
                'category_id' => $categories['minuman-kopi']->id,
                'name' => 'Es Kopi Susu Gula Aren Organik',
                'slug' => 'es-kopi-susu-gula-aren',
                'description' => 'Double shot espresso Arabika Gayo berpadu dengan susu segar dan gula aren organik pilihan.',
                'price' => 28000,
                'image' => 'https://images.unsplash.com/photo-1461023058943-07fcbe16d735?auto=format&fit=crop&w=800&q=80',
                'is_available' => true,
                'is_featured' => true,
                'preparation_time' => 5,
            ],
            [
                'category_id' => $categories['hidangan-penutup']->id,
                'name' => 'Molten Chocolate Lava Cake',
                'slug' => 'molten-chocolate-lava-cake',
                'description' => 'Kue cokelat Belgia hangat dengan lelehan cokelat di dalamnya, disajikan dengan es krim vanilla Madagascar.',
                'price' => 42000,
                'image' => 'https://images.unsplash.com/photo-1606313564200-e75d5e30476c?auto=format&fit=crop&w=800&q=80',
                'is_available' => true,
                'is_featured' => false,
                'preparation_time' => 12,
            ],
        ];

        $menus = [];
        foreach ($menusData as $menuItem) {
            $menus[] = Menu::updateOrCreate(['slug' => $menuItem['slug']], $menuItem);
        }

        // 4. Ingredients Stock (including low-stock items for alert demonstration)
        $ingredientsData = [
            ['name' => 'Daging Sapi Wagyu MB5', 'sku' => 'ING-WGY001', 'unit' => 'kg', 'stock_quantity' => 3.5, 'min_stock_alert' => 5.0, 'unit_cost' => 450000, 'supplier' => 'PT Nusantara Meat'],
            ['name' => 'Fillet Salmon Norwegia', 'sku' => 'ING-SLM002', 'unit' => 'kg', 'stock_quantity' => 2.0, 'min_stock_alert' => 4.0, 'unit_cost' => 320000, 'supplier' => 'Ocean Fresh Indo'],
            ['name' => 'Beras Pandan Wangi Organik', 'sku' => 'ING-BRS003', 'unit' => 'kg', 'stock_quantity' => 45.0, 'min_stock_alert' => 15.0, 'unit_cost' => 18000, 'supplier' => 'Tani Makmur Cianjur'],
            ['name' => 'Biji Kopi Arabika Gayo', 'sku' => 'ING-KPI004', 'unit' => 'kg', 'stock_quantity' => 12.0, 'min_stock_alert' => 5.0, 'unit_cost' => 165000, 'supplier' => 'Aceh Roastery'],
            ['name' => 'Minyak Truffle Hitam', 'sku' => 'ING-TRF005', 'unit' => 'liter', 'stock_quantity' => 0.8, 'min_stock_alert' => 2.0, 'unit_cost' => 550000, 'supplier' => 'Gourmet Importir'],
            ['name' => 'Susu Segar Pasteurisasi', 'sku' => 'ING-SSU006', 'unit' => 'liter', 'stock_quantity' => 28.0, 'min_stock_alert' => 10.0, 'unit_cost' => 22000, 'supplier' => 'Lembang Dairy'],
        ];

        foreach ($ingredientsData as $ing) {
            Ingredient::updateOrCreate(['sku' => $ing['sku']], $ing);
        }

        // 5. Sample Orders for Dashboard Statistics & Kitchen Queue
        if (Order::count() === 0) {
            $order1 = Order::create([
                'order_number' => 'SF-' . date('Ymd') . '-A1001',
                'user_id' => $customer->id,
                'customer_name' => 'Rina Pelanggan',
                'customer_email' => 'customer@somefood.com',
                'customer_phone' => '6281355556666',
                'table_number' => 'Meja 04',
                'order_type' => 'dine_in',
                'status' => 'preparing',
                'subtotal' => 164000,
                'tax' => 18040,
                'total_amount' => 182040,
                'payment_gateway' => 'midtrans',
                'payment_status' => 'paid',
                'payment_reference' => 'MT-SNAP-982341A',
            ]);

            $order1->items()->createMany([
                ['menu_id' => $menus[0]->id, 'quantity' => 2, 'unit_price' => 68000, 'subtotal' => 136000],
                ['menu_id' => $menus[6]->id, 'quantity' => 1, 'unit_price' => 28000, 'subtotal' => 28000],
            ]);

            $order2 = Order::create([
                'order_number' => 'SF-' . date('Ymd') . '-B2042',
                'user_id' => null,
                'customer_name' => 'Andi Pratama',
                'customer_email' => 'andi@example.com',
                'customer_phone' => '6281277778888',
                'table_number' => 'Meja 11',
                'order_type' => 'dine_in',
                'status' => 'completed',
                'subtotal' => 157000,
                'tax' => 17270,
                'total_amount' => 174270,
                'payment_gateway' => 'xendit',
                'payment_status' => 'paid',
                'payment_reference' => 'XN-INV-771230B',
            ]);

            $order2->items()->createMany([
                ['menu_id' => $menus[1]->id, 'quantity' => 1, 'unit_price' => 95000, 'subtotal' => 95000],
                ['menu_id' => $menus[3]->id, 'quantity' => 1, 'unit_price' => 62000, 'subtotal' => 62000],
            ]);
        }
    }
}
