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
        Schema::create('notifications', function (Blueprint $table) {
            $table->uuid('id')->primary(); // ID unique au format UUID
            $table->string('type'); // Le nom de la classe de notification
            $table->morphs('notifiable'); // Polymorphisme : user_id + user_type
            $table->text('data'); // Le contenu de ta méthode toDatabase()
            $table->timestamp('read_at')->nullable(); // null = non lue, sinon = lue
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
