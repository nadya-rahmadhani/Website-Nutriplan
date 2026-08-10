<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
          
            $table->enum('goal', ['diet', 'maintenance', 'bulking'])->nullable()->after('email');
            $table->decimal('current_weight', 5, 2)->nullable()->after('goal');
            $table->decimal('target_weight', 5, 2)->nullable()->after('current_weight');
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['goal', 'current_weight', 'target_weight']);
        });
    }
};