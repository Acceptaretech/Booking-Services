<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // System Configuration
        Schema::create('system_configs', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->string('type')->default('text'); // text, image, boolean, json
            $table->string('group')->default('general');
            $table->timestamps();
        });

        // Zones (admin-created)
        Schema::create('zones', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('country')->nullable();
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });

        // Users (all roles)
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username')->unique()->nullable();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->string('country_code')->default('+91');
            $table->string('password');
            $table->enum('role', ['admin', 'customer', 'provider', 'handyman'])->default('customer');
            $table->string('designation')->nullable();
            $table->string('profile_image')->nullable();
            $table->string('address')->nullable();
            $table->string('country')->nullable();
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            $table->foreignId('zone_id')->nullable()->constrained('zones')->nullOnDelete();
            $table->decimal('wallet_amount', 10, 2)->default(0.00);
            $table->enum('status', ['active', 'inactive', 'pending', 'rejected'])->default('pending');
            $table->boolean('is_verified')->default(false);
            $table->string('otp')->nullable();
            $table->timestamp('otp_expires_at')->nullable();
            $table->rememberToken();
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        // Provider documents
        Schema::create('user_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('voting_card')->nullable();
            $table->string('pan_card')->nullable();
            $table->string('passport')->nullable();
            $table->string('aadhar_card')->nullable();
            $table->string('driving_licence')->nullable();
            $table->enum('verification_status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->timestamps();
        });

        // Categories
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->string('icon')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->integer('sort_order')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });

        // Sub Categories
        Schema::create('sub_categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
            $table->softDeletes();
        });

        // Shops (Provider shops)
        Schema::create('shops', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // provider
            $table->string('name');
            $table->string('registration_number')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('country_code')->default('+91');
            $table->text('address')->nullable();
            $table->string('country')->nullable();
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->string('image')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->json('languages')->nullable(); // supported languages
            $table->timestamps();
            $table->softDeletes();
        });

        // Services
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // provider
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->foreignId('sub_category_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('shop_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->json('gallery')->nullable();
            $table->decimal('price', 10, 2)->default(0);
            $table->decimal('discount', 5, 2)->default(0); // percentage
            $table->enum('price_type', ['fixed', 'hourly'])->default('fixed');
            $table->integer('duration')->nullable(); // in minutes
            $table->enum('type', ['fixed', 'online', 'both'])->default('fixed');
            $table->json('available_locations')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->decimal('avg_rating', 3, 2)->default(0);
            $table->integer('total_reviews')->default(0);
            $table->integer('total_bookings')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });

        // Service FAQs
        Schema::create('service_faqs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->text('description')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });

        // Service Packages
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // provider
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('sub_category_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('service_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->enum('package_type', ['single_category', 'multi_category'])->default('single_category');
            $table->decimal('price', 10, 2);
            $table->decimal('original_price', 10, 2)->nullable();
            $table->date('start_at')->nullable();
            $table->date('end_at')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
            $table->softDeletes();
        });

        // Service Addons
        Schema::create('addons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // provider
            $table->foreignId('service_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->decimal('price', 10, 2);
            $table->string('image')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
            $table->softDeletes();
        });

        // Handyman Commission
        Schema::create('handyman_commissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // provider
            $table->string('name');
            $table->decimal('commission', 10, 2);
            $table->enum('type', ['percent', 'fixed'])->default('percent');
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });

        // Coupons
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete(); // null = admin
            $table->string('code')->unique();
            $table->text('description')->nullable();
            $table->enum('discount_type', ['percent', 'fixed'])->default('percent');
            $table->decimal('discount', 10, 2);
            $table->decimal('min_amount', 10, 2)->default(0);
            $table->decimal('max_discount', 10, 2)->nullable();
            $table->integer('usage_limit')->nullable();
            $table->integer('used_count')->default(0);
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });

        // Bookings
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('booking_number')->unique();
            $table->foreignId('customer_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('service_id')->constrained()->cascadeOnDelete();
            $table->foreignId('provider_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('handyman_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('shop_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('coupon_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('package_id')->nullable()->constrained()->nullOnDelete();
            $table->json('addons')->nullable();
            $table->decimal('base_price', 10, 2);
            $table->decimal('discount_amount', 10, 2)->default(0);
            $table->decimal('coupon_discount', 10, 2)->default(0);
            $table->decimal('tax_amount', 10, 2)->default(0);
            $table->decimal('total_amount', 10, 2);
            $table->decimal('paid_amount', 10, 2)->default(0);
            $table->integer('quantity')->default(1);
            $table->text('address')->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->datetime('booking_date');
            $table->text('notes')->nullable();
            $table->enum('status', [
                'pending','accepted','assigned','in_progress',
                'hold','completed','cancelled','rejected','failed',
                'pending_approval','waiting'
            ])->default('pending');
            $table->enum('payment_status', [
                'pending','paid','advanced_paid','advance_refund','failed'
            ])->default('pending');
            $table->enum('payment_type', ['cash','stripe','razorpay','flutterwave','wallet'])->nullable();
            $table->string('transaction_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        // Booking Status Logs
        Schema::create('booking_status_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained()->cascadeOnDelete();
            $table->foreignId('changed_by')->constrained('users')->cascadeOnDelete();
            $table->string('old_status')->nullable();
            $table->string('new_status');
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        // Payments
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained()->cascadeOnDelete();
            $table->foreignId('customer_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('provider_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('handyman_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('transaction_id')->nullable();
            $table->decimal('amount', 10, 2);
            $table->decimal('admin_commission', 10, 2)->default(0);
            $table->decimal('provider_earning', 10, 2)->default(0);
            $table->decimal('handyman_earning', 10, 2)->default(0);
            $table->decimal('tax', 10, 2)->default(0);
            $table->enum('type', ['cash','stripe','razorpay','flutterwave','wallet'])->default('cash');
            $table->enum('status', ['pending','paid','advanced_paid','advance_refund','failed'])->default('pending');
            $table->json('payment_data')->nullable();
            $table->timestamps();
        });

        // Commission Settings
        Schema::create('commission_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('provider_id')->nullable()->constrained('users')->nullOnDelete();
            $table->decimal('commission_value', 5, 2)->default(10);
            $table->enum('commission_type', ['percent', 'fixed'])->default('percent');
            $table->timestamps();
        });

        // Reviews
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained()->cascadeOnDelete();
            $table->foreignId('customer_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('service_id')->constrained()->cascadeOnDelete();
            $table->foreignId('provider_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('handyman_id')->nullable()->constrained('users')->nullOnDelete();
            $table->decimal('rating', 3, 2);
            $table->text('review')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });

        // Wallet Transactions
        Schema::create('wallet_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->decimal('amount', 10, 2);
            $table->enum('type', ['credit', 'debit']);
            $table->string('description')->nullable();
            $table->string('reference_id')->nullable();
            $table->timestamps();
        });

        // Withdrawal Requests
        Schema::create('withdrawal_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('bank_name')->nullable();
            $table->string('account_number')->nullable();
            $table->string('ifsc_code')->nullable();
            $table->decimal('amount', 10, 2);
            $table->enum('payment_type', ['bank','paypal','other'])->default('bank');
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('reason')->nullable();
            $table->timestamps();
        });

        // Job Requests (Custom Jobs)
        Schema::create('job_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
            $table->string('title');
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2)->nullable();
            $table->enum('status', ['pending','accepted','rejected','completed'])->default('pending');
            $table->timestamps();
        });

        // Job Bids
        Schema::create('job_bids', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_request_id')->constrained()->cascadeOnDelete();
            $table->foreignId('provider_id')->constrained('users')->cascadeOnDelete();
            $table->decimal('price', 10, 2);
            $table->integer('duration')->nullable(); // days
            $table->text('notes')->nullable();
            $table->enum('status', ['pending','accepted','rejected'])->default('pending');
            $table->timestamps();
        });

        // Blogs
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('author_id')->constrained('users')->cascadeOnDelete();
            $table->string('title');
            $table->text('content');
            $table->string('image')->nullable();
            $table->string('slug')->unique();
            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();
            $table->integer('read_time')->nullable(); // minutes
            $table->integer('views')->default(0);
            $table->enum('status', ['published', 'draft'])->default('draft');
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        // Notifications
        Schema::create('notifications_log', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('title');
            $table->text('message');
            $table->string('type')->default('general');
            $table->string('reference_id')->nullable();
            $table->boolean('is_read')->default(false);
            $table->timestamps();
        });

        // Promotional Banners (provider)
        Schema::create('promotional_banners', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // provider
            $table->string('image');
            $table->text('short_description')->nullable();
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('duration_days')->nullable();
            $table->decimal('per_day_charge', 10, 2)->default(10);
            $table->decimal('total_amount', 10, 2);
            $table->enum('select_type', ['featured','banner','both'])->default('banner');
            $table->enum('payment_method', ['online','wallet'])->default('online');
            $table->enum('status', ['pending','accepted','rejected'])->default('pending');
            $table->text('reason')->nullable();
            $table->timestamps();
        });

        // Taxes
        Schema::create('taxes', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->decimal('value', 5, 2);
            $table->enum('type', ['percent', 'fixed'])->default('percent');
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });

        // Help Desk / Support Tickets
        Schema::create('help_desks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('subject');
            $table->text('description');
            $table->string('image')->nullable();
            $table->enum('role', ['admin','provider','handyman','customer'])->default('customer');
            $table->enum('mode', ['online','offline'])->default('online');
            $table->enum('status', ['open','in_progress','closed'])->default('open');
            $table->timestamps();
        });

        // Personal Access Tokens (Sanctum)
        Schema::create('personal_access_tokens', function (Blueprint $table) {
            $table->id();
            $table->morphs('tokenable');
            $table->string('name');
            $table->string('token', 64)->unique();
            $table->text('abilities')->nullable();
            $table->timestamp('last_used_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();
        });

        // Password Reset Tokens
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        // Sessions
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });

        // Cache
        Schema::create('cache', function (Blueprint $table) {
            $table->string('key')->primary();
            $table->mediumText('value');
            $table->integer('expiration');
        });

        Schema::create('cache_locks', function (Blueprint $table) {
            $table->string('key')->primary();
            $table->string('owner');
            $table->integer('expiration');
        });
    }

    public function down(): void
    {
        $tables = [
            'cache_locks','cache','sessions','password_reset_tokens',
            'personal_access_tokens','help_desks','taxes','promotional_banners',
            'notifications_log','blogs','job_bids','job_requests',
            'withdrawal_requests','wallet_transactions','reviews',
            'commission_settings','payments','booking_status_logs','bookings',
            'coupons','handyman_commissions','addons','packages',
            'service_faqs','services','shops','sub_categories','categories',
            'user_documents','users','zones','system_configs',
        ];
        foreach ($tables as $table) {
            Schema::dropIfExists($table);
        }
    }
};
