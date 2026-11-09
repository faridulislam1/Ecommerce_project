<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Shop;
use App\Models\Product;
use App\Models\ShopProduct;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create Administrator
        $admin = User::create([
            'name' => 'System Administrator',
            'email' => 'admin@ecommerce.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'phone' => '+1 800 555 0199',
        ]);

        // 2. Create Shop Owners
        $owner1 = User::create([
            'name' => 'John Tech',
            'email' => 'john@shop.com',
            'password' => Hash::make('password'),
            'role' => 'shop_owner',
            'phone' => '+1 555 0101',
        ]);

        $owner2 = User::create([
            'name' => 'Sarah Styles',
            'email' => 'sarah@shop.com',
            'password' => Hash::make('password'),
            'role' => 'shop_owner',
            'phone' => '+1 555 0102',
        ]);

        $owner3 = User::create([
            'name' => 'David Living',
            'email' => 'david@shop.com',
            'password' => Hash::make('password'),
            'role' => 'shop_owner',
            'phone' => '+1 555 0103',
        ]);

        // 3. Create Shops
        $shop1 = Shop::create([
            'user_id' => $owner1->id,
            'name' => 'ElectroTech Hub',
            'slug' => 'electrotech-hub',
            'description' => 'Your one-stop destination for cutting-edge gadgets, audio gear, and workstation peripherals.',
            'logo' => 'https://images.unsplash.com/photo-1550009158-9ebf69173e03?w=300&auto=format&fit=crop&q=80',
            'banner' => 'https://images.unsplash.com/photo-1519389950473-47ba0277781c?w=1200&auto=format&fit=crop&q=80',
            'phone' => '+1 555 0101',
            'address' => '742 Evergreen Terrace, Tech Park, Suite 100',
            'status' => 'active',
        ]);

        $shop2 = Shop::create([
            'user_id' => $owner2->id,
            'name' => 'Urban Fashion Lounge',
            'slug' => 'urban-fashion-lounge',
            'description' => 'Curated contemporary apparel, streetwear aesthetics, and premium everyday wardrobe essentials.',
            'logo' => 'https://images.unsplash.com/photo-1441986300917-64674bd600d8?w=300&auto=format&fit=crop&q=80',
            'banner' => 'https://images.unsplash.com/photo-1441984904996-e0b6ba687e04?w=1200&auto=format&fit=crop&q=80',
            'phone' => '+1 555 0102',
            'address' => '120 Broadway Blvd, Fashion District, NY',
            'status' => 'active',
        ]);

        $shop3 = Shop::create([
            'user_id' => $owner3->id,
            'name' => 'Home Essentials & Co',
            'slug' => 'home-essentials-co',
            'description' => 'Modern lifestyle products, minimalist desk organization, and premium home hydration accessories.',
            'logo' => 'https://images.unsplash.com/photo-1513694203232-719a280e022f?w=300&auto=format&fit=crop&q=80',
            'banner' => 'https://images.unsplash.com/photo-1497366216548-37526070297c?w=1200&auto=format&fit=crop&q=80',
            'phone' => '+1 555 0103',
            'address' => '89 Magnolia Lane, Austin, TX',
            'status' => 'active',
        ]);

        // 4. Create Shared Catalog Products (Created by Admin)
        $pHeadphones = Product::create([
            'created_by_user_id' => $admin->id,
            'title' => 'Wireless Noise-Cancelling Headphones Pro',
            'slug' => Str::slug('Wireless Noise-Cancelling Headphones Pro'),
            'sku' => 'CAT-AUDIO-001',
            'category' => 'Electronics',
            'default_price' => 199.99,
            'description' => 'High-fidelity audio with active noise cancellation, 40-hour battery life, and ultra-comfortable memory foam ear cushions.',
            'default_thumbnail' => 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=600&auto=format&fit=crop&q=80',
            'status' => 'active',
        ]);

        $pWatch = Product::create([
            'created_by_user_id' => $admin->id,
            'title' => 'NextGen Smart Fitness Watch',
            'slug' => Str::slug('NextGen Smart Fitness Watch'),
            'sku' => 'CAT-WEAR-002',
            'category' => 'Electronics',
            'default_price' => 149.00,
            'description' => 'Real-time heart rate monitoring, built-in GPS, sleep analysis, and 5 ATM water resistance for swimmers.',
            'default_thumbnail' => 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=600&auto=format&fit=crop&q=80',
            'status' => 'active',
        ]);

        $pKeyboard = Product::create([
            'created_by_user_id' => $admin->id,
            'title' => 'Ergonomic Mechanical Keyboard RGB',
            'slug' => Str::slug('Ergonomic Mechanical Keyboard RGB'),
            'sku' => 'CAT-TECH-003',
            'category' => 'Computer Accessories',
            'default_price' => 119.50,
            'description' => 'Hot-swappable switches, wireless Bluetooth 5.2 connectivity, PBT keycaps, and customizable per-key RGB backlighting.',
            'default_thumbnail' => 'https://images.unsplash.com/photo-1587829741301-dc798b83add3?w=600&auto=format&fit=crop&q=80',
            'status' => 'active',
        ]);

        $pMonitor = Product::create([
            'created_by_user_id' => $admin->id,
            'title' => 'UltraFine 27-inch 4K IPS Monitor',
            'slug' => Str::slug('UltraFine 27-inch 4K IPS Monitor'),
            'sku' => 'CAT-TECH-004',
            'category' => 'Electronics',
            'default_price' => 389.00,
            'description' => 'Crisp 3840x2160 resolution, 99% sRGB color gamut coverage, HDR400, and USB Type-C 90W power delivery.',
            'default_thumbnail' => 'https://images.unsplash.com/photo-1527443224154-c4a3942d3acf?w=600&auto=format&fit=crop&q=80',
            'status' => 'active',
        ]);

        $pJacket = Product::create([
            'created_by_user_id' => $admin->id,
            'title' => 'Classic Vintage Denim Jacket',
            'slug' => Str::slug('Classic Vintage Denim Jacket'),
            'sku' => 'CAT-FASH-005',
            'category' => 'Apparel',
            'default_price' => 89.99,
            'description' => 'Heavyweight 13oz washed denim, button placket front, flap chest pockets, and relaxed timeless cut.',
            'default_thumbnail' => 'https://images.unsplash.com/photo-1576995853123-5a10305d93c0?w=600&auto=format&fit=crop&q=80',
            'status' => 'active',
        ]);

        $pBottle = Product::create([
            'created_by_user_id' => $admin->id,
            'title' => 'Insulated Stainless Steel Flask (750ml)',
            'slug' => Str::slug('Insulated Stainless Steel Flask (750ml)'),
            'sku' => 'CAT-HOME-006',
            'category' => 'Home & Living',
            'default_price' => 34.50,
            'description' => 'Double-wall vacuum insulation keeps drinks cold up to 24 hours or piping hot for 12 hours. BPA-free leak-proof lid.',
            'default_thumbnail' => 'https://images.unsplash.com/photo-1602143407151-7111542de6e8?w=600&auto=format&fit=crop&q=80',
            'status' => 'active',
        ]);

        $pLamp = Product::create([
            'created_by_user_id' => $admin->id,
            'title' => 'Nordic Minimalist Wooden Desk Lamp',
            'slug' => Str::slug('Nordic Minimalist Wooden Desk Lamp'),
            'sku' => 'CAT-HOME-007',
            'category' => 'Home & Living',
            'default_price' => 54.00,
            'description' => 'Solid beechwood base with matte aluminum shade. Touch dimmable 3 color temperature modes.',
            'default_thumbnail' => 'https://images.unsplash.com/photo-1507473885765-e6ed057f782c?w=600&auto=format&fit=crop&q=80',
            'status' => 'active',
        ]);

        // 5. Shared Catalog Products created by Shop Owners (Requirement: "Shop owners can create their own products, which should also become available in the shared catalog")
        $pMouse = Product::create([
            'created_by_user_id' => $owner1->id, // Created by John Tech (Shop Owner)
            'title' => 'HyperSpeed Lightweight Wireless Gaming Mouse',
            'slug' => Str::slug('HyperSpeed Lightweight Wireless Gaming Mouse'),
            'sku' => 'CAT-TECH-008',
            'category' => 'Computer Accessories',
            'default_price' => 69.99,
            'description' => 'Ultralight 58g honeycomb shell, 26,000 DPI optical sensor, optical switches rated for 90M clicks.',
            'default_thumbnail' => 'https://images.unsplash.com/photo-1615663245857-ac93bb7c39e7?w=600&auto=format&fit=crop&q=80',
            'status' => 'active',
        ]);

        $pBag = Product::create([
            'created_by_user_id' => $owner2->id, // Created by Sarah Styles (Shop Owner)
            'title' => 'Handcrafted Full-Grain Leather Tote Bag',
            'slug' => Str::slug('Handcrafted Full-Grain Leather Tote Bag'),
            'sku' => 'CAT-FASH-009',
            'category' => 'Fashion & Accessories',
            'default_price' => 145.00,
            'description' => 'Supple Italian full-grain leather with brass hardware, interior laptop sleeve, and magnetic snap closure.',
            'default_thumbnail' => 'https://images.unsplash.com/photo-1584917865442-de89df76afd3?w=600&auto=format&fit=crop&q=80',
            'status' => 'active',
        ]);

        // 6. Unassigned Product in Catalog (To prove unassigned products are hidden from customer view)
        Product::create([
            'created_by_user_id' => $admin->id,
            'title' => 'Vintage 35mm Analog Film Camera (Unassigned Catalog Item)',
            'slug' => Str::slug('Vintage 35mm Analog Film Camera'),
            'sku' => 'CAT-CAM-999',
            'category' => 'Photography',
            'default_price' => 240.00,
            'description' => 'Classic mechanical manual rangefinder camera. Not currently assigned to any shop front.',
            'default_thumbnail' => 'https://images.unsplash.com/photo-1526170375885-4d8ecf77b99f?w=600&auto=format&fit=crop&q=80',
            'status' => 'active',
        ]);

        // 7. Assign Products to Shops (with shop-specific overrides for price, details, and thumbnails)
        
        // Shop 1 (ElectroTech Hub) listings:
        // - Headphones: has custom price ($179.99 instead of $199.99), custom title, custom description
        ShopProduct::create([
            'shop_id' => $shop1->id,
            'product_id' => $pHeadphones->id,
            'custom_price' => 179.99,
            'custom_title' => 'ElectroTech Exclusive: Noise-Cancelling Pro (Special Deal)',
            'custom_description' => 'Get our store-exclusive bundle with an extra braided audio cable and hardshell traveling case included!',
            'custom_thumbnail' => 'https://images.unsplash.com/photo-1546435770-a3e426bf472b?w=600&auto=format&fit=crop&q=80',
            'stock' => 25,
            'is_available' => true,
        ]);

        // - Smart Watch: has custom price ($139.00)
        ShopProduct::create([
            'shop_id' => $shop1->id,
            'product_id' => $pWatch->id,
            'custom_price' => 139.00,
            'custom_title' => null,
            'custom_description' => null,
            'custom_thumbnail' => null,
            'stock' => 40,
            'is_available' => true,
        ]);

        // - Mechanical Keyboard: uses catalog defaults
        ShopProduct::create([
            'shop_id' => $shop1->id,
            'product_id' => $pKeyboard->id,
            'custom_price' => null,
            'custom_title' => null,
            'custom_description' => null,
            'custom_thumbnail' => null,
            'stock' => 15,
            'is_available' => true,
        ]);

        // - 4K Monitor
        ShopProduct::create([
            'shop_id' => $shop1->id,
            'product_id' => $pMonitor->id,
            'custom_price' => 369.00,
            'custom_title' => null,
            'custom_description' => null,
            'custom_thumbnail' => null,
            'stock' => 8,
            'is_available' => true,
        ]);

        // - Gaming Mouse (Product created by Shop Owner 1 himself)
        ShopProduct::create([
            'shop_id' => $shop1->id,
            'product_id' => $pMouse->id,
            'custom_price' => 64.99,
            'custom_title' => null,
            'custom_description' => null,
            'custom_thumbnail' => null,
            'stock' => 50,
            'is_available' => true,
        ]);


        // Shop 2 (Urban Fashion Lounge) listings:
        // - Denim Jacket: custom price & custom description
        ShopProduct::create([
            'shop_id' => $shop2->id,
            'product_id' => $pJacket->id,
            'custom_price' => 82.50,
            'custom_title' => 'Urban Vintage Distressed Denim Jacket',
            'custom_description' => 'Hand-distressed vintage finish in our downtown studio. Pair with black chinos or joggers.',
            'custom_thumbnail' => 'https://images.unsplash.com/photo-1544441893-675973e31985?w=600&auto=format&fit=crop&q=80',
            'stock' => 30,
            'is_available' => true,
        ]);

        // - Leather Tote Bag (Created by Owner 2)
        ShopProduct::create([
            'shop_id' => $shop2->id,
            'product_id' => $pBag->id,
            'custom_price' => 135.00,
            'custom_title' => 'Handcrafted Tuscan Leather Tote',
            'custom_description' => 'Includes a complimentary dust bag and leather conditioning balm.',
            'custom_thumbnail' => null,
            'stock' => 12,
            'is_available' => true,
        ]);

        // - Smart Watch: Shared catalog product chosen by fashion shop too!
        ShopProduct::create([
            'shop_id' => $shop2->id,
            'product_id' => $pWatch->id,
            'custom_price' => 155.00, // Fashion boutique sells it at premium with designer watchband
            'custom_title' => 'NextGen Smart Fitness Watch - Rose Gold Edition',
            'custom_description' => 'Fitted with our boutique Italian silicone and rose gold pin buckle strap.',
            'custom_thumbnail' => 'https://images.unsplash.com/photo-1508685096489-7aacd43bd3b1?w=600&auto=format&fit=crop&q=80',
            'stock' => 18,
            'is_available' => true,
        ]);


        // Shop 3 (Home Essentials & Co) listings:
        ShopProduct::create([
            'shop_id' => $shop3->id,
            'product_id' => $pBottle->id,
            'custom_price' => 29.99,
            'custom_title' => 'EcoSip 750ml Vacuum Insulated Flask',
            'custom_description' => 'Powder-coated scratch resistant finish. 100% leakproof guarantee.',
            'custom_thumbnail' => null,
            'stock' => 60,
            'is_available' => true,
        ]);

        ShopProduct::create([
            'shop_id' => $shop3->id,
            'product_id' => $pLamp->id,
            'custom_price' => 49.99,
            'custom_title' => null,
            'custom_description' => null,
            'custom_thumbnail' => null,
            'stock' => 22,
            'is_available' => true,
        ]);

        // Leather bag also listed by Home Essentials from shared catalog!
        ShopProduct::create([
            'shop_id' => $shop3->id,
            'product_id' => $pBag->id,
            'custom_price' => 140.00,
            'custom_title' => null,
            'custom_description' => null,
            'custom_thumbnail' => null,
            'stock' => 5,
            'is_available' => true,
        ]);
    }
}
