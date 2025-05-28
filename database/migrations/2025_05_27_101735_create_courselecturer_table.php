<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('course_lecturers', function (Blueprint $table) {
            $table->ulid('id')->primary();

            // Foreign keys dengan tipe string
            $table->string('course_id');
            $table->foreign('course_id')->references('course_id')->on('courses')->onDelete('cascade');

            $table->string('lecturer_id');
            $table->foreign('lecturer_id')->references('lecturer_id')->on('lecturers')->onDelete('cascade');

            $table->string('role');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('course_lecturers');
    }
};
