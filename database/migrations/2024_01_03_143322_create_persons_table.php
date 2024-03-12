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
        Schema::create('persons', function (Blueprint $table) {
            $table->id();
            $table->string('user_id')->nullable()->index('user_id');
            $table->string('name')->index('name');
            $table->string('father_name')->nullable();
            $table->tinyInteger('father_is_dead')->default(0)->comment('0-> alive; 1->dead');
            $table->string('mother_name')->nullable();
            $table->tinyInteger('mother_is_dead')->default(0)->comment('0-> alive; 1->dead');
            $table->date('dob')->nullable();
            $table->string('blood_group')->nullable();
            $table->text('contact_no')->nullable();
            $table->string('email')->nullable();
            $table->string('gender',10)->nullable();
            $table->tinyInteger('marital_status')->default(0)->comment('0-> unmarried; 1->married; 2->divorced; 3->separate');
            $table->string('spouse_user_id')->default(0)->index('spouse_user_id');
            $table->string('spouse_user_name')->nullable();
            $table->text('present_address')->nullable();
            $table->text('permanent_address')->nullable();
            $table->tinyInteger('is_head_of_family')->default(0)->comment('0-> member; 1->head of family');
            $table->string('family_head_user_id')->default(0)->index('family_head_user_id')->comment('if head of family then this value will be 0; otherwise value will be an user_id');
            $table->longText('academic_info')->nullable()->comment('`degree_name` `subject_name` `institution_name` `institution_address` `passing_year` will be stored as json');
            $table->longText('professional_info')->nullable()->comment('`profession` `job_title` `company_name` `company_address` will be stored as json');
            $table->timestamps();
            $table->integer('created_by')->default(0);
            $table->integer('updated_by')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ahmadis', function (Blueprint $table) {
            $table->dropIndex('user_id');
            $table->dropIndex('name');
            $table->dropIndex('spouse_user_id');
            $table->dropIndex('family_head_user_id');
            $table->dropIfExists();
        });
    }
};
