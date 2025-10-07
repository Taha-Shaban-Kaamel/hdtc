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
        Schema::create('lectures', function (Blueprint $table) {
            $table->id();
			$table->foreignId("course_id")->constrained("courses")->cascadeOnDelete()->cascadeOnUpdate();
			$table->foreignId("chapter_id")->constrained("chapters")->cascadeOnDelete()->cascadeOnUpdate();
			$table->string("title");
			$table->string("exam_google")->nullable();
			$table->boolean('type');
			$table->string('order', 1000);
			$table->integer('lecture_views');
			$table->enum('type_video', ["server", "server_id", "vimeo", "youtube", "zoom", "liveStream" , "vdocipher", "iframe"]);
			$table->string('videoID', 500);
			$table->decimal('price');
			$table->integer('re_exam_count');
			$table->integer('count_questions');
			$table->string('duration_exam', 50);
			$table->boolean('status')->default(1);
			$table->integer('duration')->nullable()->comment('minutes');
			$table->dateTime('start_time')->nullable();
			$table->text('start_url')->nullable();
			$table->text('join_url')->nullable();
            $table->text("internalMeetingID")->nullable();
			$table->text("attendeePW")->nullable();
			$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lectures');
    }
};
