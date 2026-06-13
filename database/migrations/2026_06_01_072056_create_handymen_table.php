<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('handymen', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('provider_id')->nullable()->constrained('users')->nullOnDelete();

            $table->decimal('commission', 10, 2)->default(0);
            $table->enum('commission_type', ['percent', 'fixed'])->default('percent');

            $table->string('country')->nullable();
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            $table->text('address')->nullable();

            $table->enum('status', ['active', 'inactive', 'pending'])->default('active');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('handymen');
    }
};