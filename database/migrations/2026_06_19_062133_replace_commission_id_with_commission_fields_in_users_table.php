<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
    
            if (Schema::hasColumn('users', 'commission_id')) {
                $table->dropForeign(['commission_id']);
                $table->dropColumn('commission_id');
            }
    
            if (!Schema::hasColumn('users', 'commission_type')) {
                $table->enum('commission_type', ['fixed', 'percentage'])
                    ->nullable()
                    ->after('provider_id');
            }
    
            if (!Schema::hasColumn('users', 'commission')) {
                $table->decimal('commission', 10, 2)
                    ->nullable()
                    ->after('commission_type');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'commission_type')) {
                $table->dropColumn('commission_type');
            }

            if (Schema::hasColumn('users', 'commission')) {
                $table->dropColumn('commission');
            }

            if (!Schema::hasColumn('users', 'commission_id')) {
                $table->unsignedBigInteger('commission_id')->nullable();
            }
        });
    }
};