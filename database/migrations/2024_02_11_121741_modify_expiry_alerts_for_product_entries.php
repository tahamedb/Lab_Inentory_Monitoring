<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('expiry_alerts', function (Blueprint $table) {
            if (Schema::hasColumn('expiry_alerts', 'product_id')) {
                $table->dropForeign(['product_id']); // Drop existing foreign key constraint
                $table->dropColumn('product_id'); // Remove the old 'product_id' column
            }

            // Check if the column does not already exist before trying to add it
            if (!Schema::hasColumn('expiry_alerts', 'product_entry_id')) {
                $table->unsignedBigInteger('product_entry_id')->nullable(); // Add the new column, nullable
                $table->foreign('product_entry_id')->references('id')->on('product_entries')->onDelete('set null');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('expiry_alerts', function (Blueprint $table) {
            $table->dropForeign(['product_entry_id']);
            $table->dropColumn('product_entry_id');

            // Re-add the old product_id column when rolling back
            $table->unsignedBigInteger('product_id')->nullable();
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }
};
