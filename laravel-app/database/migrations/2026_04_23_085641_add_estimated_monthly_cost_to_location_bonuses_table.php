<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('location_bonuses', function (Blueprint $table) {
            $table->integer('estimated_monthly_cost')->default(0)->after('bonus_amount');
        });

        // Demo monthly city costs for existing locations
        DB::table('location_bonuses')->where('location_name', 'London')->update(['estimated_monthly_cost' => 2200]);
        DB::table('location_bonuses')->where('location_name', 'Manchester')->update(['estimated_monthly_cost' => 1600]);
        DB::table('location_bonuses')->where('location_name', 'Birmingham')->update(['estimated_monthly_cost' => 1500]);
        DB::table('location_bonuses')->where('location_name', 'Leeds')->update(['estimated_monthly_cost' => 1450]);
    }

    public function down(): void
    {
        Schema::table('location_bonuses', function (Blueprint $table) {
            $table->dropColumn('estimated_monthly_cost');
        });
    }
};