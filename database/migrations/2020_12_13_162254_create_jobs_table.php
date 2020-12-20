<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->foreignId('job_type_id')->constrained();
            $table->foreignId('location_id')->constrained();
            $table->foreignId('industry_id')->nullable()->constrained();
            $table->string('title');
            $table->string('slug')->nullable()->unique();
            $table->longText('description')->nullable();
            $table->foreignId('salary_type_id')->constrained();
            $table->float('salary_min',10,2)->nullable();
            $table->float('salary_max',10,2)->nullable();
            $table->foreignId('currency_id')->nullable()->constrained()->restrictOnDelete();
            $table->date('publish_start')->nullable();
            $table->date('publish_end')->nullable();
            $table->boolean('published')->default(false);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jobs');
    }
}
