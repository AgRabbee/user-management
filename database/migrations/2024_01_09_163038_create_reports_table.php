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
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->text('report_title');
            $table->text('query');
            $table->tinyInteger('status')->default(1)->comment('0->inactive; 1->active');
            $table->string('type')->nullable();
            $table->timestamps();
            $table->index('report_title');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reports', function(Blueprint $table){
            $table->dropIndex('report_title');
            $table->dropIfExists();
        });
    }
};
