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
        Schema::create('complaints', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('transaction_id')->constrained()->onDelete('cascade');
            $table->string('reason_category');
            $table->text('description');
            $table->string('evidence_images')->nullable();
            $table->enum('status', ['pending', 'reviewed', 'approved', 'rejected', 'resolved'])->default('pending');
            $table->enum('action_type', ['refund', 'replacement']);
            $table->string('refund_method')->nullable();
            $table->string('refund_account')->nullable();
            $table->string('contact_number')->nullable();
            $table->text('admin_notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('complaints');
    }
};
