<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\{Company, Period, Branch, Product};

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('targets', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Company::class)->nullable();
            $table->foreignIdFor(Period::class)->nullable();
            $table->foreignIdFor(Branch::class)->nullable();
            $table->foreignIdFor(Product::class)->nullable();
            $table->decimal('targetprod', 15, 2)->default(0);
            $table->decimal('total', 15, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('targets');
    }
};
