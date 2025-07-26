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
    Schema::create('messages', function (Blueprint $table) {
        // Primary key for the message
        $table->id();
        
        // Foreign key reference to the users table for sender
        $table->foreignId('sender_id')->constrained('users')->onDelete('cascade');
        
        // Foreign key reference to the users table for receiver
        $table->foreignId('receiver_id')->constrained('users')->onDelete('cascade');
        
        // Content of the message
        $table->text('content');
        
        // Timestamp columns to track when the message was created
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
