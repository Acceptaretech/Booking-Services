<?php

namespace Database\Seeders;

use App\Models\{Category, CommissionSetting, Coupon, Service, SystemConfig, Tax, User, Zone};
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ── System Config ──────────────────────────────────────────────
        $configs = [
            ['key'=>'app_name',         'value'=>'HandyMan',                        'group'=>'general'],
            ['key'=>'contact_number',   'value'=>'+15265897485',                    'group'=>'general'],
            ['key'=>'contact_email',    'value'=>'info@handyman.com',               'group'=>'general'],
            ['key'=>'footer_description','value'=>'Your trusted home service platform.','group'=>'general'],
            ['key'=>'social_facebook',  'value'=>'https://facebook.com/handyman',   'group'=>'social'],
            ['key'=>'social_twitter',   'value'=>'https://twitter.com/handyman',    'group'=>'social'],
            ['key'=>'social_instagram', 'value'=>'https://instagram.com/handyman',  'group'=>'social'],
            ['key'=>'google_play_url',  'value'=>'#',                               'group'=>'app'],
            ['key'=>'app_store_url',    'value'=>'#',                               'group'=>'app'],
            ['key'=>'razorpay_key',     'value'=>null,                              'group'=>'payment'],
            ['key'=>'stripe_key',       'value'=>null,                              'group'=>'payment'],
        ];
        foreach ($configs as $c) {
            SystemConfig::firstOrCreate(['key' => $c['key']], $c);
        }

        // ── Zones ─────────────────────────────────────────────────────
        $zones = [
            ['name'=>'New York', 'country'=>'US', 'state'=>'New York', 'city'=>'New York City'],
            ['name'=>'Los Angeles', 'country'=>'US', 'state'=>'California', 'city'=>'Los Angeles'],
            ['name'=>'London', 'country'=>'UK', 'state'=>'England', 'city'=>'London'],
            ['name'=>'Melbourne', 'country'=>'AU', 'state'=>'Victoria', 'city'=>'Melbourne'],
        ];
        foreach ($zones as $z) {
            Zone::firstOrCreate(['name' => $z['name']], array_merge($z, ['status'=>'active']));
        }

        $zone = Zone::first();

        // ── Users ─────────────────────────────────────────────────────
        $admin = User::firstOrCreate(['email'=>'admin@demo.com'], [
            'first_name'=>'Demo', 'last_name'=>'Admin', 'username'=>'demo_admin',
            'phone'=>'+1234567890', 'password'=>Hash::make('password'),
            'role'=>'admin', 'status'=>'active', 'is_verified'=>true,
        ]);

        $provider = User::firstOrCreate(['email'=>'provider@demo.com'], [
            'first_name'=>'Felix', 'last_name'=>'Harris', 'username'=>'felix_harris',
            'phone'=>'+1987654321', 'designation'=>'Manager',
            'password'=>Hash::make('password'),
            'role'=>'provider', 'status'=>'active', 'is_verified'=>true,
            'zone_id'=>$zone->id, 'wallet_amount'=>50.00,
        ]);

        $provider2 = User::firstOrCreate(['email'=>'provider2@demo.com'], [
            'first_name'=>'Katie', 'last_name'=>'Brown', 'username'=>'katie_brown',
            'phone'=>'+1122334455', 'designation'=>'Manager',
            'password'=>Hash::make('password'),
            'role'=>'provider', 'status'=>'active', 'is_verified'=>true,
            'zone_id'=>$zone->id,
        ]);

        $handyman = User::firstOrCreate(['email'=>'handyman@demo.com'], [
            'first_name'=>'John', 'last_name'=>'Doe', 'username'=>'john_doe',
            'phone'=>'+1567891234', 'password'=>Hash::make('password'),
            'role'=>'handyman', 'status'=>'active', 'is_verified'=>true,
            'zone_id'=>$zone->id,
        ]);

        $customer = User::firstOrCreate(['email'=>'customer@demo.com'], [
            'first_name'=>'Pedro', 'last_name'=>'Norris', 'username'=>'pedro_norris',
            'phone'=>'+1456789012', 'password'=>Hash::make('password'),
            'role'=>'customer', 'status'=>'active', 'is_verified'=>true,
        ]);

        // ── Commission Setting ─────────────────────────────────────────
        CommissionSetting::firstOrCreate(['provider_id'=>null], [
            'commission_value'=>10, 'commission_type'=>'percent',
        ]);
        CommissionSetting::firstOrCreate(['provider_id'=>$provider->id], [
            'commission_value'=>30, 'commission_type'=>'percent',
        ]);

        // ── Tax ───────────────────────────────────────────────────────
        Tax::firstOrCreate(['title'=>'VAT'], [
            'value'=>13.5, 'type'=>'percent', 'status'=>'active',
        ]);

        // ── Categories ───────────────────────────────────────────────
        $cats = [
            ['name'=>'Cooking',      'description'=>'Delightful Exploration Of Culinary Arts','is_featured'=>true],
            ['name'=>'AC CoolCare',  'description'=>'Experience Enhanced Comfort With Our AC Services','is_featured'=>true],
            ['name'=>'Painter',      'description'=>'The Painter Category Celebrates The World Of Colors','is_featured'=>true],
            ['name'=>'Plumber',      'description'=>'Navigate The Intricacies Of Plumbing','is_featured'=>true],
            ['name'=>'Electrician',  'description'=>'Delve Into The Electrician Category','is_featured'=>false],
            ['name'=>'Cleaning',     'description'=>'Efficiently Remove Dirt And Grime','is_featured'=>false],
            ['name'=>'Carpenter',    'description'=>'A Carpenter Is A Skilled Tradesperson','is_featured'=>false],
            ['name'=>'Pest Control', 'description'=>'The Pest Control Category Equips You','is_featured'=>false],
            ['name'=>'Laundry',      'description'=>'Experience The Convenience Of Pristine Garments','is_featured'=>false],
            ['name'=>'Remote Services','description'=>'Service Will Be Completed Online/Remotely','is_featured'=>false],
        ];

        $createdCats = [];
        foreach ($cats as $c) {
            $createdCats[] = Category::firstOrCreate(['name'=>$c['name']], array_merge($c, ['status'=>'active']));
        }

        // ── Services ─────────────────────────────────────────────────
        $services = [
            ['name'=>'Sewer Line Cleaning',  'price'=>27,'discount'=>5,  'duration'=>20,'cat_idx'=>0],
            ['name'=>'Fault Diagnosis',       'price'=>25,'discount'=>0,  'duration'=>20,'cat_idx'=>4],
            ['name'=>'Relationship Compatibility Reading','price'=>35,'discount'=>10,'duration'=>20,'cat_idx'=>9],
            ['name'=>'Custom Frame Painting', 'price'=>12,'discount'=>0,  'duration'=>10,'cat_idx'=>2],
            ['name'=>'Residential Security',  'price'=>43,'discount'=>4,  'duration'=>30,'cat_idx'=>5,'featured'=>true],
            ['name'=>'Water Heater Installation','price'=>25,'discount'=>0,'duration'=>30,'cat_idx'=>3,'featured'=>true],
            ['name'=>'Pipe Bursting Repair',  'price'=>0, 'discount'=>0,  'duration'=>30,'cat_idx'=>3,'featured'=>true],
            ['name'=>'Wire Repair',            'price'=>0, 'discount'=>0,  'duration'=>10,'cat_idx'=>4],
            ['name'=>'Italian Cook',           'price'=>10,'discount'=>0,  'duration'=>60,'cat_idx'=>0],
            ['name'=>'Office Cleaning',        'price'=>32,'discount'=>0,  'duration'=>30,'cat_idx'=>5],
            ['name'=>'Electrical Wiring',      'price'=>26,'discount'=>0,  'duration'=>25,'cat_idx'=>4],
            ['name'=>'Smart Lighting Installation','price'=>50,'discount'=>4,'duration'=>30,'cat_idx'=>4,'featured'=>true],
        ];

        $createdServices = [];
        foreach ($services as $s) {
            $createdServices[] = Service::firstOrCreate(
                ['name'=>$s['name'],'user_id'=>$provider->id],
                [
                    'category_id' => $createdCats[$s['cat_idx']]->id,
                    'price'       => $s['price'],
                    'discount'    => $s['discount'],
                    'price_type'  => 'fixed',
                    'duration'    => $s['duration'],
                    'type'        => 'fixed',
                    'is_featured' => $s['featured'] ?? false,
                    'status'      => 'active',
                    'avg_rating'  => rand(35,50)/10,
                    'total_reviews'=> rand(1,20),
                ]
            );
        }

        // ── Coupons ──────────────────────────────────────────────────
        Coupon::firstOrCreate(['code'=>'RTS4RT5G'], [
            'discount_type'=>'percent','discount'=>2,'min_amount'=>10,
            'start_date'=>now()->subDays(5)->toDateString(),
            'end_date'=>now()->addDays(30)->toDateString(),
            'status'=>'active',
        ]);
        Coupon::firstOrCreate(['code'=>'SAVE20'], [
            'discount_type'=>'percent','discount'=>20,'min_amount'=>25,
            'end_date'=>now()->addDays(60)->toDateString(),
            'status'=>'active',
        ]);

        $this->command->info('✅ Seeding complete! Demo credentials:');
        $this->command->info('Admin:    admin@demo.com    / password');
        $this->command->info('Provider: provider@demo.com / password');
        $this->command->info('Handyman: handyman@demo.com / password');
        $this->command->info('Customer: customer@demo.com / password');
    }
}
